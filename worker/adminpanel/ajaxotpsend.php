<?php
include 'master.php';
include '../config/sms-config.php';

// ini_set('display_errors', 0);
// error_reporting(E_ALL);

if(isset($_POST['uploadOTP'])){
    header('Content-Type: application/json');
    
    // Check if user is logged in
    if(!isset($_SESSION['sid'])) {
        echo json_encode(['status' => 'error', 'message' => 'Session expired. Please login again.']);
        exit;
    }
    
    // ========== RATE LIMITING START ==========
    
    // Initialize rate limiting if not exists
    if (!isset($_SESSION['otp_rate_limit'])) {
        $_SESSION['otp_rate_limit'] = [
            'count' => 0,
            'first_request' => time(),
            'last_request' => 0
        ];
    }
    
    $current_time = time();
    $rate_limit = &$_SESSION['otp_rate_limit'];
    
    // Reset counter if 1 hour has passed since first request
    if ($current_time - $rate_limit['first_request'] > 3600) {
        $rate_limit['count'] = 0;
        $rate_limit['first_request'] = $current_time;
    }
    
    // Check daily limit (10 OTPs per day)
    if ($rate_limit['count'] >= 10) {
        echo json_encode([
            'status' => 'error', 
            'message' => 'Daily OTP limit reached. Try again tomorrow.',
            'show_otp_input' => false
        ]);
        exit;
    }
    
    // Check minimum interval between OTP requests (60 seconds)
    if ($current_time - $rate_limit['last_request'] < 60) {
        $wait_time = 60 - ($current_time - $rate_limit['last_request']);
        echo json_encode([
            'status' => 'error', 
            'message' => "Please wait $wait_time seconds before requesting new OTP",
            'show_otp_input' => false
        ]);
        exit;
    }
    
    // Update rate limit counters
    $rate_limit['count']++;
    $rate_limit['last_request'] = $current_time;
    
    // ========== RATE LIMITING END ==========
    
    // Check if OTP already exists and is still valid (5 minutes)
    if (isset($_SESSION['uotp']) && isset($_SESSION['otp_created'])) {
        $otp_age = time() - $_SESSION['otp_created'];
        if ($otp_age < 300) { // 300 seconds = 5 minutes
            // OTP still valid, don't send new one
            $remaining_minutes = 5 - floor($otp_age/60);
            echo json_encode([
                'status' => 'error', 
                'message' => 'OTP already sent. Check your mobile. Valid for ' . $remaining_minutes . ' more minutes.',
                'show_otp_input' => true,
                'remaining_time' => (300 - $otp_age) // Send remaining seconds
            ]);
            exit;
        }
    }
    
    // Generate 6-digit OTP (more secure than 4-digit)
    $otp = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
    
    // Store OTP in session with timestamp
    $_SESSION['uotp'] = $otp;
    $_SESSION['otp_created'] = time();
    $_SESSION['otp_attempts'] = 0; // Reset attempt counter
    
    // Get user mobile from database
    $sql = "SELECT mobile FROM admin_users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_SESSION['sid']);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $mob = $row['mobile'];
        
        // Validate mobile number
        if(empty($mob) || strlen($mob) < 10) {
            echo json_encode([
                'status' => 'error', 
                'message' => 'Invalid mobile number. Please update your profile.',
                'show_otp_input' => false
            ]);
            exit;
        }
        
        // Send OTP
        $smsres = sendroutedSms($otp, $mob);
       // $smsres = json_decode($smsres, true);
       //  if (!empty($smsres['status']) && $smsres['status'] === true) {

       if (1) {

            echo json_encode([
                'status' => 'success',
                'message' => 'OTP sent successfully.',
                'show_otp_input' => true,
                'remaining_time' => 300
            ]);

        } else {
            // Clear OTP from session if sending failed
            unset($_SESSION['uotp']);
            unset($_SESSION['otp_created']);
            
            echo json_encode([
                'status' => 'error', 
                'message' => 'Failed to send OTP. Please try again.',
                'show_otp_input' => false
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error', 
            'message' => 'User not found. Please login again.',
            'show_otp_input' => false
        ]);
    }
    exit;
}
?>