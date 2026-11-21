<?php
session_start();

// Security headers
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("X-Frame-Options: DENY");
header("X-Content-Type-Options: nosniff");



// Validate session - must have OTP verification AND mobile number
if(!isset($_SESSION['forgotpass']) || !isset($_SESSION['otp_verified_at'])) {
    
    // Clear any existing session data
    session_destroy();
    session_start();
   
    $_SESSION['err'] = "Invalid or expired reset link. Please start over.";
    header('Location: forget_password.php');
    exit();
}

// Check if reset session is still valid (15 minutes max)
$current_time = time();
if(($current_time - $_SESSION['otp_verified_at']) > 900) { // 15 minutes
    session_destroy();
    session_start();
    $_SESSION['err'] = "Password reset session expired. Please start over.";
    header('Location: forget_password.php');
    exit();
}


    $_SESSION['reset_csrf_token'] = bin2hex(random_bytes(32));


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self' 'unsafe-inline'; style-src 'self' 'unsafe-inline';">
    <title>Admin Dashboard | ICDS | Set New Password</title>
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
    .password-strength {
        margin-top: 5px;
        font-size: 12px;
    }
    .strength-meter {
        height: 5px;
        background: #eee;
        margin: 5px 0;
        border-radius: 3px;
        overflow: hidden;
    }
    .strength-meter div {
        height: 100%;
        width: 0;
        transition: width 0.3s;
    }
    .password-requirements {
        font-size: 12px;
        color: #666;
        margin-top: 10px;
    }
    .requirement {
        margin-bottom: 3px;
    }
    .requirement.valid {
        color: #28a745;
    }
    .requirement.invalid {
        color: #dc3545;
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
                            <h4>Set New Password</h4>
                            <p class="text-muted">Account: <?php echo substr($_SESSION['forgotpass'], 0, 3) . '****' . substr($_SESSION['forgotpass'], -3); ?></p>
                            
                            <?php if(isset($_SESSION['reset_error'])): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php echo $_SESSION['reset_error']; ?>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <?php unset($_SESSION['reset_error']); ?>
                            <?php endif; ?>
                            
                            <form class="pt-3" method="post" action="submitLogin.php" id="resetForm" autocomplete="off">
                                <!-- CSRF Token -->
                                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['reset_csrf_token']; ?>">
                                
                                <div class="form-group">
                                    <label for="newPassword">New Password</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="">
                                                <i class="mdi mdi-lock-outline text-primary"></i>
                                            </span>
                                        </div>
                                        <input type="password" 
                                               name="pass" 
                                               id="newPassword"
                                               class="form-control form-control-lg border-left-0" 
                                               placeholder="Enter new password" 
                                               required
                                               autocomplete="new-password"
                                               oninput="checkPasswordStrength()">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-transparent border-left-0">
                                                <button type="button" class="btn btn-sm" onclick="togglePassword('newPassword')" tabindex="-1">
                                                    <i class="mdi mdi-eye-outline"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="password-strength">
                                        <div class="strength-meter">
                                            <div id="strengthBar" style="background: #dc3545;"></div>
                                        </div>
                                        <small id="strengthText" style="color: #dc3545;">Very Weak</small>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="confirmPassword">Confirm Password</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                             <span class="">
                                                <i class="mdi mdi-lock-outline text-primary"></i>
                                            </span>
                                        </div>
                                        <input type="password" 
                                               name="confirm_pass" 
                                               id="confirmPassword"
                                               class="form-control form-control-lg border-left-0" 
                                               placeholder="Confirm new password" 
                                               required
                                               autocomplete="new-password"
                                               oninput="checkPasswordMatch()">
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-transparent border-left-0">
                                                <button type="button" class="btn btn-sm" onclick="togglePassword('confirmPassword')" tabindex="-1">
                                                    <i class="mdi mdi-eye-outline"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </div>
                                    <small id="matchText" class="form-text" style="display: none;"></small>
                                </div>
                                
                                <!-- Password Requirements -->
                                <div class="password-requirements">
                                    <p class="font-weight-bold">Password must contain:</p>
                                    <div class="requirement invalid" id="reqLength">At least 8 characters</div>
                                    <div class="requirement invalid" id="reqUpper">One uppercase letter (A-Z)</div>
                                    <div class="requirement invalid" id="reqLower">One lowercase letter (a-z)</div>
                                    <div class="requirement invalid" id="reqNumber">One number (0-9)</div>
                                    <div class="requirement invalid" id="reqSpecial">One special character (!@#$%^&*)</div>
                                </div>
                                
                                <div class="my-3">
                                    <button type="submit" 
                                            id="submitBtn"
                                            class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                                            name="update_dpo_pass"
                                            disabled>
                                        Update Password
                                    </button>
                                </div>
                                
                                <div class="text-center mt-3">
                                    <a href="forget_password.php" class="text-primary">
                                        <i class="mdi mdi-arrow-left"></i> Back to Login
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 login-half-bg d-flex flex-row"></div>
                     <!-- <p class="font-weight-medium text-center flex-grow align-self-center"
                        style="color:white !important; margin:0px; padding:0px; position:absolute;  left:0px; right:0px; width:100%; background: pink; padding:5px;">
                        Copyright © ICDS |
                        Developed by
                        <a href="https://techsseract.com/create/" target="_blank" rel="noopener noreferrer">CMP Techsseract LLP</a>. | Powered by UPDESCO
                    </p> -->
                   
                </div>
                
            </div>
            
        </div>
        
    </div>
    

    <!-- JavaScript -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <script>
    // Toggle password visibility
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = field.parentElement.querySelector('.mdi');
        if (field.type === 'password') {
            field.type = 'text';
            icon.classList.remove('mdi-eye-outline');
            icon.classList.add('mdi-eye-off-outline');
        } else {
            field.type = 'password';
            icon.classList.remove('mdi-eye-off-outline');
            icon.classList.add('mdi-eye-outline');
        }
    }
    
    // Check password strength
    function checkPasswordStrength() {
        const password = document.getElementById('newPassword').value;
        const strengthBar = document.getElementById('strengthBar');
        const strengthText = document.getElementById('strengthText');
        
        let strength = 0;
        let color = '#dc3545';
        let text = 'Very Weak';
        
        // Check requirements
        const hasLength = password.length >= 8;
        const hasUpper = /[A-Z]/.test(password);
        const hasLower = /[a-z]/.test(password);
        const hasNumber = /[0-9]/.test(password);
        const hasSpecial = /[\W_]/.test(password);
        
        // Update requirement indicators
        document.getElementById('reqLength').className = hasLength ? 'requirement valid' : 'requirement invalid';
        document.getElementById('reqUpper').className = hasUpper ? 'requirement valid' : 'requirement invalid';
        document.getElementById('reqLower').className = hasLower ? 'requirement valid' : 'requirement invalid';
        document.getElementById('reqNumber').className = hasNumber ? 'requirement valid' : 'requirement invalid';
        document.getElementById('reqSpecial').className = hasSpecial ? 'requirement valid' : 'requirement invalid';
        
        // Calculate strength
        if (hasLength) strength += 20;
        if (hasUpper) strength += 20;
        if (hasLower) strength += 20;
        if (hasNumber) strength += 20;
        if (hasSpecial) strength += 20;
        
        // Set color and text based on strength
        if (strength >= 80) {
            color = '#28a745';
            text = 'Very Strong';
        } else if (strength >= 60) {
            color = '#17a2b8';
            text = 'Strong';
        } else if (strength >= 40) {
            color = '#ffc107';
            text = 'Moderate';
        } else if (strength >= 20) {
            color = '#fd7e14';
            text = 'Weak';
        }
        
        strengthBar.style.width = strength + '%';
        strengthBar.style.background = color;
        strengthText.textContent = text;
        strengthText.style.color = color;
        
        // Enable/disable submit button
        validateForm();
    }
    
    // Check password match
    function checkPasswordMatch() {
        const password = document.getElementById('newPassword').value;
        const confirm = document.getElementById('confirmPassword').value;
        const matchText = document.getElementById('matchText');
        
        if (confirm.length === 0) {
            matchText.style.display = 'none';
        } else if (password === confirm) {
            matchText.textContent = 'Passwords match';
            matchText.style.color = '#28a745';
            matchText.style.display = 'block';
        } else {
            matchText.textContent = 'Passwords do not match';
            matchText.style.color = '#dc3545';
            matchText.style.display = 'block';
        }
        
        validateForm();
    }
    
    // Validate entire form
    function validateForm() {
        const password = document.getElementById('newPassword').value;
        const confirm = document.getElementById('confirmPassword').value;
        const submitBtn = document.getElementById('submitBtn');
        
        // Check all requirements
        const hasLength = password.length >= 8;
        const hasUpper = /[A-Z]/.test(password);
        const hasLower = /[a-z]/.test(password);
        const hasNumber = /[0-9]/.test(password);
        const hasSpecial = /[\W_]/.test(password);
        const passwordsMatch = password === confirm && password.length > 0;
        
        const isValid = hasLength && hasUpper && hasLower && hasNumber && hasSpecial && passwordsMatch;
        
        submitBtn.disabled = !isValid;
    }
    
    // Prevent form resubmission
    if(window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
    
    // Initialize validation
    document.addEventListener('DOMContentLoaded', function() {
        checkPasswordStrength();
        checkPasswordMatch();
    });
    </script>
</body>
</html>