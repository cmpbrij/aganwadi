<?php
session_start();
// Include config files
include('../config/db_config.php');
include('../config/sms-config.php');
// header("Content-Security-Policy: default-src 'self'; base-uri 'self'; form-action 'self'; frame-ancestors 'self'; object-src 'none'; script-src 'self'; style-src 'self' 'unsafe-inline'; img-src 'self' data: blob:; font-src 'self'; connect-src 'self'; media-src 'self';");

// Security configuration
$max_otp_attempts = 2;
$otp_lockout_time = 900; 
$otp_expiry_time = 300; 

// Initialize OTP attempt tracking
if (!isset($_SESSION['otp_attempts'])) {
    $_SESSION['otp_attempts'] = 0;
}

if (isset($_SESSION['otp_lockout_until']) && $_SESSION['otp_lockout_until'] > time()) {
    $remaining_time = $_SESSION['otp_lockout_until'] - time();
    $remaining_minutes = ceil($remaining_time / 60);
    $_SESSION['error'] = "Account Locked! Too many failed attempts. Try again in " . $remaining_minutes . " minutes.";
    header('Location: uploadvacancy.php');
    exit();
}

// Reset attempts after 1 hour of inactivity
if (isset($_SESSION['otp_last_attempt']) && (time() - $_SESSION['otp_last_attempt'] > 3600)) {
    $_SESSION['otp_attempts'] = 0;
    unset($_SESSION['otp_lockout_until']);
}

if(isset($_POST['saveuploadOrder'])){
    
    // Update last attempt time
    $_SESSION['otp_last_attempt'] = time();
    
    // Validate CSRF token
    if (isset($_SESSION['csrf_token']) && isset($_POST['csrf_token'])) {
        if ($_SESSION['csrf_token'] !== $_POST['csrf_token']) {
            $_SESSION['error'] = "Security token invalid. Please try again.";
            header('Location: uploadvacancy.php');
            exit();
        }
    }
    
    // Check if OTP exists in session
    if (!isset($_SESSION['uotp'])) {
        $_SESSION['error'] = "No OTP found. Please request a new one.";
        header('Location: uploadvacancy.php');
        exit();
    }
    
    // Check if OTP is expired
    if (!isset($_SESSION['otp_created']) || (time() - $_SESSION['otp_created'] > $otp_expiry_time)) {
        unset($_SESSION['uotp']);
        unset($_SESSION['otp_created']);
        $_SESSION['error'] = "OTP has expired. Please request a new one.";
        header('Location: uploadvacancy.php');
        exit();
    }
    
    // Check if OTP input is provided
    if (!isset($_POST['uotp']) || empty(trim($_POST['uotp']))) {
        $_SESSION['error'] = "Please enter the OTP.";
        header('Location: uploadvacancy.php');
        exit();
    }
    
    // Increment attempt counter
    $_SESSION['otp_attempts']++;
    
    // Check if exceeded maximum attempts
    if ($_SESSION['otp_attempts'] > $max_otp_attempts) {
        $_SESSION['otp_lockout_until'] = time() + $otp_lockout_time;
        $_SESSION['error'] = "Account Locked! Too many failed attempts. Try again in 15 minutes.";
        header('Location: uploadvacancy.php');
        exit();
    }
    
    // Validate OTP
    if($_POST['uotp'] == $_SESSION['uotp']){
        // Successful verification - reset all counters
        $_SESSION['otp_attempts'] = 0;
        unset($_SESSION['otp_lockout_until']);
        unset($_SESSION['uotp']);
        unset($_SESSION['otp_created']);
        unset($_SESSION['otp_last_attempt']);
        
        // Check if district ID exists
        if (!isset($_SESSION['distid']) || empty($_SESSION['distid'])) {
            $_SESSION['error'] = "Session expired. Please login again.";
            header('Location: uploadvacancy.php');
            exit();
        }
        
        // Validate required fields
        $required_fields = ['last_date', 'cutoff_date', 'pdffile'];
        foreach ($required_fields as $field) {
            if (!isset($_POST[$field]) && !isset($_FILES[$field])) {
                $_SESSION['error'] = "Please fill all required fields.";
                header('Location: uploadvacancy.php');
                exit();
            }
        }
        
        // Validate last date
        $last_date = $_POST['last_date'];
        if (empty($last_date)) {
            $_SESSION['error'] = "Please select last date.";
            header('Location: uploadvacancy.php');
            exit();
        }
        
        // Validate date is not in past
        $today = date('Y-m-d');
        if ($last_date < $today) {
            $_SESSION['error'] = "Last date cannot be in the past.";
            header('Location: uploadvacancy.php');
            exit();
        }
        
        // Validate cutoff date
        $cutoff_date = $_POST['cutoff_date'];
        if (empty($cutoff_date) || !in_array($cutoff_date, ['jan', 'july'])) {
            $_SESSION['error'] = "Please select valid cutoff date.";
            header('Location: uploadvacancy.php');
            exit();
        }
        
        // File upload validation
        if ($_FILES["pdffile"]["error"] != 0) {
            $error_messages = [
                1 => "The uploaded file exceeds the upload_max_filesize directive",
                2 => "The uploaded file exceeds the MAX_FILE_SIZE directive",
                3 => "The uploaded file was only partially uploaded",
                4 => "No file was uploaded",
                6 => "Missing a temporary folder",
                7 => "Failed to write file to disk",
                8 => "A PHP extension stopped the file upload"
            ];
            $_SESSION['error'] = "File upload error: " . ($error_messages[$_FILES["pdffile"]["error"]] ?? "Unknown error");
            header('Location: uploadvacancy.php');
            exit();
        }
        
        // Validate file extension
        $fileName = basename($_FILES["pdffile"]["name"]); 
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if($fileType !== 'pdf'){
            $_SESSION['error'] = 'Only PDF files are allowed.';
            header('Location: uploadvacancy.php');
            exit();
        }
        
        // Validate file size (max 5MB)
        $maxFileSize = 5 * 1024 * 1024;
        if ($_FILES["pdffile"]["size"] > $maxFileSize) {
            $_SESSION['error'] = "File size too large. Maximum size is 5MB.";
            header('Location: uploadvacancy.php');
            exit();
        }
        
        // Validate MIME type
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $_FILES["pdffile"]["tmp_name"]);
        finfo_close($finfo);
        
     //  $allowTypes = array('pdf','PDF');

       
        if($mimeType !== 'application/pdf'){
            $_SESSION['error'] = "Invalid file type. Please upload a PDF file.";
            header('Location: uploadvacancy.php');
            exit();
        }
        $tmpFile  = $_FILES["pdffile"]["tmp_name"];
        $fileName = $_FILES["pdffile"]["name"];
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
         $pdfContent = file_get_contents($tmpFile);
        
        // Convert to ASCII text for easier detection (remove binary data)
        $pdfText = '';
        for ($i = 0; $i < strlen($pdfContent); $i++) {
            $char = $pdfContent[$i];
            $ascii = ord($char);
            if ($ascii >= 32 && $ascii <= 126) { // Printable ASCII characters
                $pdfText .= $char;
            } else {
                $pdfText .= ' '; // Replace non-printable with space
            }
        }
        
        // Convert to lowercase for case-insensitive search
        $pdfTextLower = strtolower($pdfText);
        
        // List of dangerous strings to search for (PDF-specific XSS vectors)
        $dangerousStrings = [
            // JavaScript in PDF objects
            '/javascript',
            '/js(',
            '/js ',
            
            // PDF Actions that can execute code
            '/openaction',
           
            '/submitform',
            '/importdata',
            
            // JavaScript functions commonly used in PDF XSS
            'app.alert',
            'this.print',
            'console.log',
            'eval(',
            'settimeout',
            'setinterval',
            
            // Other dangerous patterns
            '/type/action',
            '/s/javascript',
            '/names[',
            '/action[',
            
            // HTML/JS tags (sometimes embedded in PDF)
            '<script',
            'javascript:',
            'onload=',
            'onclick=',
            
           
        ];

        $isMalicious = false;
        foreach ($dangerousStrings as $badString) {
            if (strpos($pdfTextLower, $badString) !== false) {
                $isMalicious = true;
                // Log for debugging
                error_log("PDF XSS DETECTED: Found '$badString' in uploaded PDF");
                break;
            }
        }

        // if ($isMalicious) {
        //     $_SESSION['error'] = "PDF contains unsafe content. Please upload a clean PDF file.";
        //     header('Location: uploadvacancy.php');
        //     exit;
        // }

        /* ---------- ADDITIONAL SAFETY CHECK ---------- */
        // Check for encoded/obfuscated JavaScript
        // $encodedPatterns = [
        //     '6a617661736372697074', // hex for 'javascript'
        //     '6a73',                 // hex for 'js'
        //     '616c657274',           // hex for 'alert'
        // ];
        
        // foreach ($encodedPatterns as $hexPattern) {
        //     if (stripos(bin2hex($pdfContent), $hexPattern) !== false) {
        //         $_SESSION['error'] = "PDF contains encoded unsafe content.";
        //         header('Location: uploadvacancy.php');
        //         exit;
        //     }
        // }
        
        // Upload directory
        $dir = '../uploadOrder/';
        if (!file_exists($dir)){
            mkdir($dir, 0775, true);
        }
        
        // Generate unique filename
        $randName = 'ordercopy_' . time() . '_' . bin2hex(random_bytes(4));
        $targetFilePath = $dir . $randName . '.pdf';
        
        // Upload file to server
        if(move_uploaded_file($_FILES["pdffile"]["tmp_name"], $targetFilePath)) {
            
            $dist_id = $_SESSION['distid'];
            $uploaded_date = date('Y-m-d');
            $created = date('Y-m-d H:i:s');
            
           $sqldata = "SELECT * FROM `vacancy_order` WHERE `dist_id` = '" . $_SESSION['distid'] . "'";
            $resu = execute_query($sqldata);
            $data = mysqli_num_rows($resu);
            if($data > 0){
                $_SESSION['error']="Vacancy already uploaded!";
                header('Location: uploadvacancy.php');
            }
            else{
                // Insert new record
                $insert_sql = "INSERT INTO `vacancy_order`(`dist_id`,`pdf_name`,`last_date`,`uploaded_date`,`cutoff_date`,`created`) VALUES (?,?,?,?,?,?)";
                $insert_stmt = $conn->prepare($insert_sql);
                $insert_stmt->bind_param("ssssss", $dist_id, $targetFilePath, $last_date, $uploaded_date, $cutoff_date, $created);
                $insert_stmt->execute();
                
                // Insert into history
                $history_sql = "INSERT INTO `vacancy_order_history`(`dist_id`,`pdf_name`,`last_date`,`uploaded_date`,`cutoff_date`,`created`) VALUES (?,?,?,?,?,?)";
                $history_stmt = $conn->prepare($history_sql);
                $history_stmt->bind_param("ssssss", $dist_id, $targetFilePath, $last_date, $uploaded_date, $cutoff_date, $created);
                $history_stmt->execute();
                unset($_SESSION['uotp']);
                unset($_SESSION['otp_created']);
                unset($_SESSION['otp_attempts']);
                unset($_SESSION['otp_last_attempt']);
                unset($_SESSION['otp_lockout_until']);
                if(isset($_SESSION['otp_rate_limit'])) {
                    unset($_SESSION['otp_rate_limit']);
                }
                $msg = "PDF Uploaded Successfully";
            }
            
            $_SESSION['success'] = $msg;
            header('Location: uploadvacancy.php');
            exit();
            
        } else {
            error_log("File upload failed: " . $_FILES["pdffile"]["error"]);
            $_SESSION['error'] = "Sorry, there was an error uploading your file.";
            //die;
            header('Location: uploadvacancy.php');
            exit();
        }
        
    } else {
        // Invalid OTP
        $remaining_attempts = $max_otp_attempts - $_SESSION['otp_attempts'];
        
        if ($remaining_attempts <= 0) {
            $_SESSION['otp_lockout_until'] = time() + $otp_lockout_time;
            $_SESSION['error'] = "Account Locked! Too many failed attempts. Try again in 15 minutes.";
        } else {
            $_SESSION['error'] = "Invalid OTP! Attempt " . $_SESSION['otp_attempts'] . " of " . $max_otp_attempts . ". " . $remaining_attempts . " attempt(s) remaining.";
        }
        
        header('Location: uploadvacancy.php');
        exit();
    }
} else {
    $_SESSION['error'] = "Invalid request.";
    header('Location: uploadvacancy.php');
    exit();
}
?>