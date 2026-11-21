<?php 
session_start();

// Security headers
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");

// Check if user arrived from proper flow
if(!isset($_SESSION['forgotpass']) || !isset($_SESSION['otp_created_at'])) {
    header('Location: forget_password.php');
    exit();
}

// Check OTP expiry (10 minutes)
$current_time = time();
$otp_expiry = $_SESSION['otp_created_at'] + 600; // 10 minutes expiry

if($current_time > $otp_expiry) {
    // Clear OTP session data
    unset($_SESSION['dpo-otp']);
    unset($_SESSION['otp_created_at']);
    unset($_SESSION['otp_attempts']);
    
    $_SESSION['err'] = "OTP expired. Please request a new one.";
    header('Location: forget_password.php');
    exit();
}

// Initialize OTP attempt counter if not exists
if(!isset($_SESSION['otp_attempts'])) {
    $_SESSION['otp_attempts'] = 0;
    $_SESSION['otp_locked_until'] = 0;
}

// Check if OTP attempts are locked
if(isset($_SESSION['otp_locked_until']) && $current_time < $_SESSION['otp_locked_until']) {
    $remaining_time = ceil(($_SESSION['otp_locked_until'] - $current_time) / 60);
    $error_message = "Too many failed attempts. Please try again after {$remaining_time} minutes.";
    die("<script>alert('{$error_message}'); window.location.href='forget_password.php';</script>");
}

// Handle OTP verification from form submission
if(isset($_POST['forgot_pass_otp'])) {
    $entered_otp = $_POST['otp'] ?? '';

    
    // Basic validation
    if(empty($entered_otp) || !is_numeric($entered_otp) || strlen($entered_otp) != 4) {
        $_SESSION['otperror'] = "Invalid OTP format";
        $_SESSION['otp_attempts']++;
        header('Location: forgot_otp.php');
        exit();
    }
    
    // Check OTP attempts limit
    if($_SESSION['otp_attempts'] >= 5) {
        // Lock for 30 minutes
        $_SESSION['otp_locked_until'] = $current_time + 1800;
        unset($_SESSION['dpo-otp']);
        
        $error_message = "Maximum OTP attempts reached. Account locked for 30 minutes.";
        die("<script>alert('{$error_message}'); window.location.href='forget_password.php';</script>");
    }
    
    // Verify OTP (time-constant comparison to prevent timing attacks)
    $stored_otp = $_SESSION['dpo-otp'] ?? '';
    
    // Use hash_equals for timing-safe comparison
    if(hash_equals((string)$stored_otp, (string)$entered_otp)) {
        // OTP verified successfully
        
        // Clear OTP-related session data
        unset($_SESSION['dpo-otp']);
        unset($_SESSION['otp_created_at']);
        unset($_SESSION['otp_attempts']);
        unset($_SESSION['otp_locked_until']);
        
        // Set flag for password reset page
        $_SESSION['otp_verified'] = true;
        $_SESSION['otp_verified_at'] = $current_time;
        
        // Redirect to password reset page
        header('Location: password_set_dpo.php');
        exit();
    } else {
        // Invalid OTP
        $_SESSION['otp_attempts']++;
        
        // Log failed attempt (in production, log to database)
        $mobile = $_SESSION['forgotpass'];
        $ip_address = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
        $log_message = date('Y-m-d H:i:s') . " - Failed OTP attempt for mobile: {$mobile}, IP: {$ip_address}, Attempt: {$_SESSION['otp_attempts']}";
        error_log($log_message);
        
        // Check if we should lock now
        if($_SESSION['otp_attempts'] >= 5) {
            $_SESSION['otp_locked_until'] = $current_time + 1800; // 30 minutes
            unset($_SESSION['dpo-otp']);
            
            $error_message = "Too many failed attempts. Account locked for 30 minutes.";
            die("<script>alert('{$error_message}'); window.location.href='forget_password.php';</script>");
        }
        
        $_SESSION['otperror'] = "Invalid OTP. You have " . (5 - $_SESSION['otp_attempts']) . " attempts remaining.";
        header('Location: forgot_otp.php');
        exit();
    }
}

// Calculate remaining attempts for display
$remaining_attempts = 5 - $_SESSION['otp_attempts'];
$remaining_time = max(0, ceil(($otp_expiry - $current_time) / 60));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline';">
    <title>Admin Dashboard | ICDS | OTP Verification</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- inject:css -->
    <link rel="stylesheet" href="css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.ico" />
    <style>
    .auth .login-half-bg {
        background: url(../public/images/aww-image.jpg);
        background-size: cover;
    }
    .otp-timer {
        background: #f8f9fa;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
        text-align: center;
        border-left: 4px solid #007bff;
    }
    .attempts-warning {
        color: #dc3545;
        font-size: 14px;
        margin-top: 10px;
    }
    </style>
</head>

<body class="boxed-layout">
    <div class="container-scroller" style="padding: 0px;">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
                <div class="row flex-grow">
                    <div class="col-lg-6 d-flex align-items-center justify-content-center">
                        <div class="auth-form-transparent text-left p-3">
                            <div class="brand-logo">
                                <img style="margin-left: 25%;" src="../assets/img/icds.png" alt="logo">
                            </div>
                            <h4>OTP Verification</h4>
                            
                            <div class="otp-timer">
                                <i class="mdi mdi-clock-outline"></i>
                                OTP expires in: <strong id="timer">10:00</strong> minutes<br>
                                <small>OTP sent to: <?php echo substr($_SESSION['forgotpass'], 0, 3) . '****' . substr($_SESSION['forgotpass'], -3); ?></small>
                            </div>
                            
                            <?php if(isset($_SESSION['otperror'])): ?>
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <?php echo htmlspecialchars($_SESSION['otperror']); ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <?php unset($_SESSION['otperror']); ?>
                            <?php endif; ?>
                            
                            <div class="attempts-warning">
                                <i class="mdi mdi-alert-circle-outline"></i>
                                Attempts remaining: <strong><?php echo $remaining_attempts; ?></strong>
                            </div>
                            
                            <form class="pt-3" method="post" action="" id="otpForm" autocomplete="off">
                                <?php 
                                // Add CSRF token
                                if(!isset($_SESSION['csrf_token'])) {
                                    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                                }
                                ?>
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                                
                                <div class="form-group">
                                    <label for="otpInput">Enter 4-digit OTP</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="mdi mdi-lock-outline text-primary"></i>
                                            </span>
                                        </div>
                                        <input type="text" 
                                               name="otp" 
                                               id="otpInput"
                                               class="form-control form-control-lg border-left-0" 
                                               placeholder="Enter 4-digit OTP" 
                                               maxlength="4" 
                                               pattern="[0-9]{4}"
                                               inputmode="numeric"
                                               required
                                               autofocus>
                                    </div>
                                    <small class="form-text text-muted">
                                        Enter the OTP sent to your registered mobile number
                                    </small>
                                </div>
                                
                                <div class="my-3">
                                    <button type="submit" 
                                            id=""
                                            class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                                            name="forgot_pass_otp">
                                        Verify OTP
                                    </button>
                                </div>
                                
                                <div class="text-center mt-3">
                                    <a href="forget_password.php" class="text-primary">
                                        <i class="mdi mdi-refresh"></i> Request New OTP
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 login-half-bg d-flex flex-row"></div>
                    
                    <p class="font-weight-medium text-center flex-grow align-self-center"
                        style="color:white !important; margin:0px; padding:0px; position:absolute; bottom:0px; left:0px; right:0px; width:100%; background: pink; padding:5px;">
                        Copyright © ICDS |
                        Developed by
                        <a href="https://techsseract.com/create/" target="_blank" rel="noopener noreferrer">CMP Techsseract LLP</a>. | Powered by UPDESCO
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for timer and input handling -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script>
    // Timer for OTP expiry
    let expiryTime = <?php echo $otp_expiry * 1000; ?>; // Convert to milliseconds
    let timerElement = document.getElementById('timer');
    
    function updateTimer() {
        let now = new Date().getTime();
        let distance = expiryTime - now;
        
        if (distance < 0) {
            timerElement.innerHTML = "EXPIRED";
            clearInterval(timerInterval);
            alert('OTP has expired. Please request a new one.');
            window.location.href = 'forget_password.php';
            return;
        }
        
        let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        timerElement.innerHTML = minutes.toString().padStart(2, '0') + ":" + 
                                seconds.toString().padStart(2, '0');
    }
    
    // Update timer every second
    let timerInterval = setInterval(updateTimer, 1000);
    updateTimer(); // Initial call
    
    // OTP input formatting
    document.getElementById('otpInput').addEventListener('input', function(e) {
        // Remove non-numeric characters
        this.value = this.value.replace(/[^0-9]/g, '');
        
        // Auto-submit when 4 digits are entered
        if(this.value.length === 4) {
            document.getElementById('submitBtn').focus();
        }
    });
    
    // Form submission handler
    document.getElementById('otpForm').addEventListener('submit', function(e) {
        let otpInput = document.getElementById('otpInput');
        
        // Validate OTP format
        if(!/^[0-9]{4}$/.test(otpInput.value)) {
            e.preventDefault();
            alert('Please enter a valid 4-digit OTP');
            otpInput.focus();
            return false;
        }
        
        // Disable button to prevent double submission
        document.getElementById('submitBtn').disabled = true;
        document.getElementById('submitBtn').innerHTML = 
            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Verifying...';
    });
    
    // Prevent form resubmission on page refresh
    if(window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    </script>
</body>
</html>