<?php


// Start session with secure settings
session_start([
    'cookie_httponly' => true,
    'cookie_secure' => true,
    'cookie_samesite' => 'Strict'
]);

// Security headers
// header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline'; img-src 'self' data:;");
// header("X-Content-Type-Options: nosniff");
// header("X-Frame-Options: DENY");

// Include config files
include('../config/db_config.php');
include('../config/sms-config.php');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
// Helper Functions Definition
function recordLoginAttempt($userid, $ip, $success) {
    global $conn;
    
    $stmt = $conn->prepare("INSERT INTO admin_login_attempts (userid, ip_address, success) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $userid, $ip, $success);
    return $stmt->execute();
}

function isAccountLocked($userid, $ip) {
    global $conn;
    
    // Check for account lock based on username
    $stmt = $conn->prepare("
        SELECT COUNT(*) as attempts 
        FROM admin_login_attempts 
        WHERE userid = ? 
        AND success = 0 
        AND attempt_time > DATE_SUB(NOW(), INTERVAL 15 MINUTE)
    ");
    $stmt->bind_param("s", $userid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if($row['attempts'] >= 4) { // Changed to 5 failed attempts
            return true; // Account is locked
        }
    }
    
    return false;
}

function isIpRateLimited($ip) {
    global $conn;
    
    // Check for IP-based rate limiting (last hour)
    $stmt = $conn->prepare("
        SELECT COUNT(*) as attempts 
        FROM admin_login_attempts 
        WHERE ip_address = ? 
        AND attempt_time > DATE_SUB(NOW(), INTERVAL 1 HOUR)
    ");
    $stmt->bind_param("s", $ip);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if($row['attempts'] >= 20) { // 20 attempts per hour max
            return true;
        }
    }
    
    // More strict: last 5 minutes
    $stmt = $conn->prepare("
        SELECT COUNT(*) as attempts 
        FROM admin_login_attempts 
        WHERE ip_address = ? 
        AND attempt_time > DATE_SUB(NOW(), INTERVAL 5 MINUTE)
    ");
    $stmt->bind_param("s", $ip);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if($row['attempts'] >= 10) { // 10 attempts in 5 minutes
            return true;
        }
    }
    
    return false;
}

function getFailedAttempts($userid, $ip) {
    global $conn;
    
    $stmt = $conn->prepare("
        SELECT COUNT(*) as attempts 
        FROM admin_login_attempts 
        WHERE userid = ? 
        AND ip_address = ?
        AND success = 0 
        AND attempt_time > DATE_SUB(NOW(), INTERVAL 15 MINUTE)
    ");
    $stmt->bind_param("ss", $userid, $ip);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['attempts'];
    }
    
    return 0;
}

function clearFailedAttempts($userid, $ip) {
    global $conn;
    
    $stmt = $conn->prepare("
        DELETE FROM admin_login_attempts 
        WHERE userid = ? 
        AND ip_address = ?
    ");
    $stmt->bind_param("ss", $userid, $ip);
    return $stmt->execute();
}

function lockAccount($userid) {
    global $conn;
    
    // Optional: You could add a 'locked_until' column to admin_users table
    // For now, we just rely on the admin_login_attempts table tracking
    
    // You can also log this event if you have account_locks table
    if($conn->query("SHOW TABLES LIKE 'account_locks'")->num_rows > 0) {
        $stmt = $conn->prepare("
            INSERT INTO account_locks (userid, locked_at, reason) 
            VALUES (?, NOW(), 'Too many failed login attempts')
        ");
        $stmt->bind_param("s", $userid);
        $stmt->execute();
    }
    
    return true;
}

function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}

// Main Login Logic
if(isset($_POST['login'])){
    // Validate inputs
    $username = base64_decode(urldecode($_POST['uname']));
    $password = base64_decode(urldecode($_POST['pass']));

    $uname = isset($username) ? trim($username) : '';
    $pass = isset($password) ? trim($password) : '';
    $captcha = isset($_POST['captcha']) ? trim($_POST['captcha']) : '';
    
    // Check if database connection exists
    if (!isset($conn) || !$conn) {
        $_SESSION['warning'] = "System error. Please try again later.";
        header('Location: index.php');
        exit;
    }
    
    // Validate required fields
    if(empty($uname) || empty($pass) || empty($captcha)){
        $_SESSION['verror'] = "All fields are required";
        header('Location: index.php');
        exit;
    }
    
    // Validate captcha length
    if(strlen($captcha) != 5) {
        $_SESSION['cerror'] = "Invalid captcha!";
        header('Location: index.php');
        exit;
    }
    
    
    // Verify captcha
    if(function_exists('verifyCaptcha')) {
        $cstatus = json_decode(verifyCaptcha($captcha), true);
        
        if($cstatus['captcha_status'] == 407){
            $_SESSION['cerror'] = "Captcha Expired! Please refresh the page";
            header('Location: index.php');
            exit;
        }
        else if($cstatus['captcha_status'] == 400){
            $_SESSION['cerror'] = "Captcha Verification Failed!";
            header('Location: index.php');
            exit;
        }
    }
    
    // Get client IP
    $ip = get_client_ip();
    
    // Sanitize inputs (prepared statements will handle escaping)
    $uname = mysqli_real_escape_string($conn, $uname);
    $ip = mysqli_real_escape_string($conn, $ip);
    
    // Check if account is locked
    if(isAccountLocked($uname, $ip)){
        $_SESSION['warning'] = "Account is temporarily locked. Please try again after 15 minutes.";
       // echo"test"; die;
        header('Location: index.php');
        exit;
    }
    
    // Check if IP is rate limited
    if(isIpRateLimited($ip)){
        $_SESSION['warning'] = "Too many login attempts from your IP. Please try again later.";
        header('Location: index.php');
        exit;
    }
    
    try {
        // Query the database for user
        $sql = "SELECT * FROM admin_users WHERE userid = ?";
        $stmt = $conn->prepare($sql);
        
        if(!$stmt) {
            error_log("Prepare failed: " . $conn->error);
            $_SESSION['warning'] = "System error. Please try again later.";
            header('Location: index.php');
            exit;
        }
        
        $stmt->bind_param("s", $uname);
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Record login attempt (initially as failed)
        recordLoginAttempt($uname, $ip, 0);
          
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            
            // Verify password (MD5 - consider upgrading to password_hash() and password_verify())
            $hashed_pass = md5($pass);
            
            if($row['password'] == $hashed_pass){
                // Successful login
                recordLoginAttempt($uname, $ip, 1);
                
                // Clear failed attempts
                clearFailedAttempts($uname, $ip);
                
                $role = $row['user_type'];
                
                // Generate a new session identifier
                $newSessionIdentifier = bin2hex(random_bytes(32));
                
                // Update session identifier in database
                $update_stmt = $conn->prepare("UPDATE admin_users SET session_identifier = ? WHERE userid = ?");
                $update_stmt->bind_param('ss', $newSessionIdentifier, $row['userid']);
                $update_stmt->execute();
                
                // Regenerate session ID to prevent session fixation
                session_regenerate_id(true);
                
                // Set session variables
                $_SESSION['session_identifier'] = $newSessionIdentifier;
                $_SESSION['user_id'] = $row['userid'];
                $_SESSION['login_time'] = time();
                $_SESSION['ip_address'] = $ip;
             
                if($role == 'DPO'){
                    $_SESSION['role'] = 'DPO';
                    $_SESSION['adminid'] = $row['userid'];
                    $_SESSION['distid'] = $row['district_id'];
                    $_SESSION['sid'] = $row['id'];
                    $_SESSION['success'] = 'Login Successfully!';
                    
                    // Log the login
                    $log_sql = "INSERT INTO `admin_login_details`(`user_id`, `distid`, `date`, `user_type`,`ip`,`timestamp`) 
                                VALUES (?, ?, ?, 'DPO', ?, NOW())";
                    $log_stmt = $conn->prepare($log_sql);
                    $log_stmt->bind_param("ssss", $uname, $row['district_id'], date('Y-m-d'), $ip);
                    $log_stmt->execute();
                    
                    header('Location: main_dashboard.php');
                    exit;
                }
                else if($role == 'admin'){
                    $_SESSION['role'] = 'admin';
                    $_SESSION['uid'] = $row['userid'];
                    $_SESSION['success'] = 'Login Successfully!';
                    $distid ='';
                    $login_date = date('Y-m-d H:i:s');

                    
                    $log_sql = "INSERT INTO `admin_login_details`(`user_id`, `distid`, `date`, `user_type`,`ip`,`timestamp`) 
                                VALUES (?, ?, ?, 'admin', ?, NOW())";
                    $log_stmt = $conn->prepare($log_sql);
                    $log_stmt->bind_param("ssss", $uname,$distid,$login_date,$ip);
                    $log_stmt->execute();
                    
                    session_regenerate_id(true);
                    header('Location: new_dashboard.php');
                    exit;
                }
                else {
                    // Unknown role
                    $_SESSION['warning'] = "Invalid user role";
                    header('Location: index.php');
                    exit;
                }
            } else {
                // Wrong password
                $_SESSION['wpass'] = 'Username or password is wrong';
                
                // Check if we should lock the account or show captcha
                $attempts = getFailedAttempts($uname, $ip);
                
                if($attempts >= 4){ // 5th failed attempt
                    lockAccount($uname);
                    $_SESSION['warning'] = "Account has been locked due to too many failed attempts. Please try again after 15 minutes.";
                }
                else if($attempts >= 2){ // Show captcha after 3 failed attempts
                    $_SESSION['force_captcha'] = true;
                }
                
                header('Location: index.php');
                exit;
            }
        } else {
            // Username doesn't exist
            $_SESSION['warning'] = "Invalid username or password";
            
            // Check IP rate limiting for failed attempts
            $ip_attempts = getFailedAttempts($uname, $ip);
            if($ip_attempts >= 2) {
                $_SESSION['force_captcha'] = true;
            }
            
            header('Location: index.php');
            exit;
        }
        
    } catch (Exception $e) {
        error_log("Login error: " . $e->getMessage());
        $_SESSION['warning'] = "An error occurred. Please try again.";
        header('Location: index.php');
        exit;
    }
} 

 if(isset($_POST['changePass'])){
        
        $sql = "SELECT `password` FROM admin_users WHERE userid='".$_SESSION['adminid']."'";
        $result = execute_query($sql);
        $chk=isPasswordStrong($_POST['new_pass']);
        if(!$chk){
            $_SESSION['weekpass']="Password is week!";
                   
            header('Location: change_pass.php');
           // die;
        }
        if (mysqli_num_rows($result) > 0) {

           
            $oldpass=md5($_POST['old_pass']);
            $newpass=md5($_POST['new_pass']);
            $row = $result->fetch_assoc();
            $stored_password = $row["password"];
            
            // Verify current password
            if ($stored_password==$oldpass) {
                $update_sql = "UPDATE admin_users SET password = ? WHERE userid = ?";
                // Prepare the statement
                $stmt = $conn->prepare($update_sql);
                // Bind parameters
                $stmt->bind_param("ss", $newpass, $_SESSION['adminid']);
                // Execute the statement
               $res= $stmt->execute();
                if ($res) {
                    $newSessionIdentifier = bin2hex(random_bytes(10));
                    $stmt = $conn->prepare("UPDATE admin_users SET session_identifier = ? WHERE userid = ?");
                    $stmt->bind_param('ss',$newSessionIdentifier, $_SESSION['adminid']);
                    $stmt->execute();
                    $_SESSION['success']="Password updated successfully";

                    header('Location: change_pass.php');
                } else {
                    $_SESSION['error_in_change']="Error in password change";
                   
                    header('Location: change_pass.php');
                    
                }
            } else {
                $_SESSION['warning']="Old password not matched";
               
                header('Location:change_pass.php');
            }
        } else {
            echo "User not found";
        }



    }


    if(isset($_POST['adminchangePass'])){
        $sql = "SELECT `password` FROM admin_users WHERE userid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $_SESSION['uid']); 
        $stmt->execute();
        $result = $stmt->get_result();
        $chk=isPasswordStrong($_POST['new_pass']);
        if(!$chk){
            $_SESSION['weekpass']="Password is week!";
            header('Location: admin_change_pass.php');
            //die;
        }
      
        if ($result->num_rows > 0) {
            $oldpass=md5($_POST['old_pass']);
            $newpass=md5($_POST['new_pass']);
            $row = $result->fetch_assoc();
            $stored_password = $row["password"];
            // echo  $stored_password;
            // echo '<br>'.$oldpass;
            // print_r($row); die;
            
            // Verify current password
            if ($stored_password==$oldpass) {
                $update_sql = "UPDATE admin_users SET password = ? WHERE userid = ?";
                $stmt = $conn->prepare($update_sql);
                
                $stmt->bind_param("ss", $newpass, $_SESSION['uid']);
                $res=$stmt->execute();

                if ($res) {
                    $newSessionIdentifier = bin2hex(random_bytes(10));
                    $stmt = $conn->prepare("UPDATE admin_users SET session_identifier = ? WHERE userid = ?");
                    $stmt->bind_param('ss',$newSessionIdentifier, $_SESSION['uid']);
                    $r=$stmt->execute();
                   
                    $_SESSION['success']="Password updated successfully";
                   
                    header('Location: admin_change_pass.php');
                } else {
                    $_SESSION['error_in_change']="Error in password change";
                   
                    header('Location: admin_change_pass.php');
                    
                }
            } else {
                $_SESSION['warning']="Old password not matched";
               
                header('Location:admin_change_pass.php');
            }
        } else {
            echo "User not found";
        }
    }

   
    function verifyCaptcha($input) {
        /**
         verifyCaptcha : This function verifies the validity of Captcha Images
         
         @return : 407 (captcha expired), 200 (captcha verified), 400 (captcha unverified), 500 (Server Error)
         **/
    
          $date = time();
        if(isset($_SESSION['captcha_set']) &&
            isset($_SESSION['captcha_token']) &&
                isset($_SESSION['captcha_expire'])) {
                    //assign values
                    $captcha_expire = $_SESSION['captcha_expire'] ;
                    $captcha_token = $_SESSION['captcha_token'];
                    //check if captcha has expired
                   if($date < $_SESSION['captcha_expire']){
                        if(md5($input.$captcha_expire) == $captcha_token){
                            unset( $_SESSION['captcha_expire'] );
                            unset( $_SESSION['captcha_token']);
                            unset($_SESSION['captcha_set']);
                            $return = array(
                                "captcha_status" => 200,
                                "captcha_message" => "Captcha Verified!",
                            );
                            return json_encode($return); 
                        } else {
                            $return = array(
                                "captcha_status" => 400,
                                "captcha_message" => "Captcha Verification Failed!",
                             );
                             return json_encode($return);
                        }
    
                    }else{
                        $return = array(
                        "captcha_status" => 407,
                        "captcha_message" => "Captcha Expired!",
                        );
                        return json_encode($return);
                   }
                }else{
                    $return = array(
                    "captcha_status" => 500,
                    "captcha_message" => "Session Invalid!",
                     );
                    return json_encode($return);
                }
    }

    function isPasswordStrong($password) {
        // Minimum password length
        $min_length = 8;
        
        // Check if password meets minimum length
        if (strlen($password) < $min_length) {
            return false;
        }
        
        // Check for presence of uppercase letters
        if (!preg_match('/[A-Z]/', $password)) {
            return false;
        }
        
        // Check for presence of lowercase letters
        if (!preg_match('/[a-z]/', $password)) {
            return false;
        }
        
        // Check for presence of numbers
        if (!preg_match('/[0-9]/', $password)) {
            return false;
        }
        
        // Check for presence of special characters
        if (!preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $password)) {
            return false;
        }
        
        // All checks passed, password is strong
        return true;
    }


   // In your submitLogin.php or separate OTP handler
if(isset($_POST['forgot_pass_submit'])){
   
    $captcha = isset($_POST['captcha']) ? trim($_POST['captcha']) : '';
   
    if(strlen($captcha) != 5) {
        $_SESSION['cerror'] = "Invalid captcha!";
        header('Location: forget_password.php');
        exit;
    }
    
    // Verify captcha
    if(function_exists('verifyCaptcha')) {
        $cstatus = json_decode(verifyCaptcha($captcha), true);
        
        if($cstatus['captcha_status'] == 407){
            $_SESSION['cerror'] = "Captcha Expired! Please refresh the page";
            header('Location: forget_password.php');
            exit;
        }
        else if($cstatus['captcha_status'] == 400){
            $_SESSION['cerror'] = "Captcha Verification Failed!";
            header('Location: forget_password.php');
            exit;
        }
    }
   
    
    
    if($_POST['mobile'] != ''){
        $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
        $current_time = time();
        $block_check_sql = "SELECT * FROM otp_rate_limit 
                           WHERE mobile='$mobile' AND block_until > $current_time";
        $block_result = execute_query($block_check_sql);
        
        if(mysqli_num_rows($block_result) > 0) {
            $_SESSION['err'] = "Please wait before requesting another OTP";
            header('Location: forget_password.php');
            exit();
        }
   
        
        // 2. Check recent attempts (last 1 hour)
        $one_hour_ago = $current_time - 3600;
        $attempt_sql = "SELECT COUNT(*) as attempt_count FROM otp_attempts 
                       WHERE mobile='$mobile' AND attempt_time > $one_hour_ago";
        $attempt_result = execute_query($attempt_sql);
        $attempt_data = mysqli_fetch_assoc($attempt_result);
        
        // Limit to 5 attempts per hour
        if($attempt_data['attempt_count'] >= 5) {
            // Block for 1 hour
            $block_until = $current_time + 3600;
            $block_sql = "INSERT INTO otp_rate_limit (mobile, block_until) 
                         VALUES ('$mobile', $block_until) 
                         ON DUPLICATE KEY UPDATE block_until=$block_until";
            execute_query($block_sql);
            
            $_SESSION['err'] = "Too many attempts. Please try again in 1 hour.";
            header('Location: forget_password.php');
            exit();
        }

            
        
        // 3. Check minimum time between requests (2 minutes)
        $two_minutes_ago = $current_time - 120;
        $recent_sql = "SELECT * FROM otp_attempts 
                      WHERE mobile='$mobile' AND attempt_time > $two_minutes_ago 
                      ORDER BY attempt_time DESC LIMIT 1";
        $recent_result = execute_query($recent_sql);
        
        if(mysqli_num_rows($recent_result) > 0) {
            $_SESSION['err'] = "Please wait 2 minutes before requesting another OTP";
            header('Location: forget_password.php');
            exit();
        }
        
        // 4. Verify user exists
        $sqlc = "SELECT * FROM admin_users WHERE mobile='".$mobile."'";
        // echo $sqlc; die;
      
      
        $r = execute_query($sqlc);

         $mo=mysqli_num_rows($r);
    
        if(mysqli_num_rows($r) > 0) {
            $otp = rand(1000, 9999);
          //echo $otp;
            
            // 5. Record this attempt
            $record_sql = "INSERT INTO otp_attempts (mobile, attempt_time, otp_code) 
                          VALUES ('$mobile', $current_time, '$otp')";
                         // echo $record_sql; die;
            execute_query($record_sql);
            
            // 6. Send OTP (with delay simulation to prevent timing attacks)
          //  usleep(rand(100000, 300000)); // Random delay 100-300ms
            
            $s = sendroutedSms($otp, $mobile);

      
           
            
            
            $_SESSION['forgotpass'] = $mobile;
            $_SESSION['otp_created_at'] = $current_time;
            $_SESSION['dpo-otp'] = $otp;
            
            // Set OTP expiry (10 minutes)
            $_SESSION['otp_expiry'] = $current_time + 600;
            
            header('Location: forgot_otp.php');
            exit;
        } else {
            $_SESSION['err'] = "Mobile number not found";
            header('Location: forget_password.php');
            exit;
        }
    }
}


if(isset($_POST['forgot_pass_otp'])) {
 
    if(!isset($_SESSION['forgotpass']) || !isset($_SESSION['dpo-otp'])) {
        session_regenerate_id(true);
        $_SESSION['err'] = "Session expired. Please start over.";
        header('Location: forget_password.php');
        exit();
    }
    
    // Check OTP expiry (should be set when OTP was generated)
    $current_time = time();
    if(!isset($_SESSION['otp_created_at']) || 
       ($current_time - $_SESSION['otp_created_at']) > 600) { // 10 minutes expiry
        // Clear OTP data
        unset($_SESSION['dpo-otp'], $_SESSION['otp_created_at'], $_SESSION['forgotpass']);
        session_regenerate_id(true);
        $_SESSION['err'] = "OTP expired. Please request a new one.";
        header('Location: forget_password.php');
        exit();
    }
    
    // Initialize attempt counter
    if(!isset($_SESSION['otp_attempts'])) {
        $_SESSION['otp_attempts'] = 0;
    }
    
    // Check attempt limit (max 5 attempts)
    if($_SESSION['otp_attempts'] >= 5) {
        // Clear all session data and block further attempts
        session_destroy();
        session_start();
        $_SESSION['err'] = "Too many failed attempts. Please try again after 30 minutes.";
        header('Location: forget_password.php');
        exit();
    }
    
    // Validate OTP input
    $entered_otp = trim($_POST['otp'] ?? '');
    
    // Basic validation
    if(empty($entered_otp) || !is_numeric($entered_otp) || strlen($entered_otp) !== 4) {
        $_SESSION['otp_attempts'] = ($_SESSION['otp_attempts'] ?? 0) + 1;
        $_SESSION['otperror'] = "Invalid OTP format. Please enter a valid 4-digit code.";
        header('Location: forgot_otp.php');
        exit();
    }
    
    // Timing-safe comparison to prevent timing attacks
    $stored_otp = $_SESSION['dpo-otp'];
    
    if(hash_equals((string)$stored_otp, (string)$entered_otp)) {
        // OTP verified successfully
        
        // Clear sensitive OTP data
        unset($_SESSION['dpo-otp'], $_SESSION['otp_created_at'], $_SESSION['otp_attempts']);
        
        // Set verification flag with timestamp
        $_SESSION['otp-set-dpo'] = 'yes';
        $_SESSION['otp_verified_at'] = $current_time;
        
        // Regenerate session ID for security
        session_regenerate_id(true);
        
        // Redirect to password reset page
        header('Location: password_set_dpo.php');
        exit();
    } else {
        // Invalid OTP
        $_SESSION['otp_attempts'] = ($_SESSION['otp_attempts'] ?? 0) + 1;
        
        // Calculate remaining attempts
        $remaining_attempts = 5 - $_SESSION['otp_attempts'];
        
        if($remaining_attempts > 0) {
            $_SESSION['otperror'] = "Invalid OTP. You have {$remaining_attempts} attempt(s) remaining.";
        } else {
            $_SESSION['otperror'] = "Maximum attempts reached. Please start over.";
        }
        
        // Add delay to prevent brute force (increases with each failed attempt)
        usleep($_SESSION['otp_attempts'] * 500000); // 0.5s delay per attempt
        
        header('Location: forgot_otp.php');
        exit();
    }
}
   

    if(isset($_POST['update_dpo_pass'])){
        if(!isset($_SESSION['reset_csrf_token'])) {
                session_destroy();
                session_start();
            $_SESSION['cerror'] = "Security token invalid. Please start over.";
            header('Location: forget_password.php');
            exit();
        }
    
    unset($_SESSION['reset_csrf_token']);


   // echo $_SESSION['dporest']; die;
    // 2. Validate session state
   if(!isset($_SESSION['forgotpass']) || !isset($_SESSION['otp_verified_at'])) {
        session_destroy();
        session_start();
        $_SESSION['cerror'] = "Invalid session. Please start over.";
        header('Location: forget_password.php');
        exit();
    }
    
    // 3. Check reset session expiry (15 minutes)
    $current_time = time();
    if(($current_time - $_SESSION['otp_verified_at']) > 900) {
        session_destroy();
        session_start();
        $_SESSION['cerror'] = "Password reset session expired. Please start over.";
        header('Location: forget_password.php');
        exit();
    }
    
    // 4. Validate passwords
    $password = $_POST['pass'] ?? '';
    $confirm_password = $_POST['confirm_pass'] ?? '';
    
    // Check if passwords match
    if($password !== $confirm_password) {
        $_SESSION['cerror'] = "Passwords do not match.";
        header('Location: password_set_dpo.php');
        exit();
    }
    
   
    // 6. Get mobile from session
    $mobile = $_SESSION['forgotpass'];
    
        $sql="select id,mobile,district_id from admin_users where mobile='".$_SESSION['forgotpass']."'";
        
        $r=execute_query($sql);
        
        if(mysqli_num_rows($r) > 0){
            $pass=md5($_POST['pass']);
            $q="update admin_users set password='".$pass."' where mobile='".$_SESSION['forgotpass']."'";
            
            $res=execute_query($q);
            if($res){
                $row=mysqli_fetch_assoc($r);
                $sql1="INSERT INTO `change_pass_bkp`(`userid`, `districtid`, `timestamp`) VALUES ('".$row['id']."','".$row['district_id']."','".date('Y-m-d H:i:s')."')";

               // echo $sql1; die;
                execute_query($sql1);
                unset($_SESSION['otp-set-dpo']);
                unset($_SESSION['forgotpass']);
                unset($_SESSION['dpo-otp']);
                $_SESSION['resetpass']="Password reset successfully! Please login.";
                header('Location: index.php');
            }
            else{
                $_SESSION['reset_error']='';
                echo"some problem occure! please try after some time";
            }
        }
        else{
            header('Location: forget_password.php');
        }
       
    }
?>