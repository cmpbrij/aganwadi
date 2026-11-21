<?php
//include 'master.php';
session_start();
include('../config/db_config.php');
// ob_start();

// error_reporting(E_ALL);
// ini_set('display_errors', 0);
// ini_set('log_errors', 1);

// if ($_SERVER['REQUEST_METHOD'] != 'POST') {
//     echo 'Invalid request method';
//     exit();
// }



// if (!isset($_POST['UploadBroadsheet'])) {
//     echo 'Invalid request';
//     exit();
// }

// Session check
if (!isset($_SESSION['distid']) || !isset($_SESSION['sid'])) {
    echo 'Session expired. Please login again.';
    exit();
}

$did = $_SESSION['distid'];
$uid = $_SESSION['sid'];
$remarks = isset($_POST['remarks']) ? trim($_POST['remarks']) : '';

// File check
if (!isset($_FILES['pdf_file'])) {
    echo 'No file received';
    exit();
}

if ($_FILES['pdf_file']['error'] !== UPLOAD_ERR_OK) {
    $uploadErrors = [
        UPLOAD_ERR_INI_SIZE   => 'File exceeds upload_max_filesize',
        UPLOAD_ERR_FORM_SIZE  => 'File exceeds MAX_FILE_SIZE',
        UPLOAD_ERR_PARTIAL    => 'File was only partially uploaded',
        UPLOAD_ERR_NO_FILE    => 'No file uploaded',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing temp folder',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk',
        UPLOAD_ERR_EXTENSION  => 'Upload stopped by extension',
    ];

    $errCode = $_FILES['pdf_file']['error'];
    echo isset($uploadErrors[$errCode]) ? $uploadErrors[$errCode] : 'Unknown upload error';
    exit();
}

$fileTmpPath = $_FILES['pdf_file']['tmp_name'];
$fileName    = $_FILES['pdf_file']['name'];
$fileSize    = $_FILES['pdf_file']['size'];

if (empty($fileTmpPath) || !is_uploaded_file($fileTmpPath)) {
    echo 'Invalid uploaded file';
    exit();
}

// Extension check
$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
if ($fileExtension !== 'pdf') {
    echo 'Only PDF files are allowed';
    exit();
}

// Size check
$maxFileSize = 190 * 1024 * 1024; // 190MB
if ($fileSize > $maxFileSize) {
    echo 'File size exceeds 190MB limit';
    exit();
}

// MIME check
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mimeType = finfo_file($finfo, $fileTmpPath);
finfo_close($finfo);

if ($mimeType !== 'application/pdf') {
    echo 'Invalid file type. Please upload a valid PDF file';
    exit();
}

// Upload folder
$uploadDir = __DIR__ . '/../uploadedBroadsheet';
if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0755, true)) {
        echo 'Failed to create upload directory';
        exit();
    }
}

if (!is_writable($uploadDir)) {
    echo 'Upload directory is not writable';
    exit();
}

// New file name
$newFileName = $did . '_' . uniqid('sheet_', true) . '.pdf';
$destPath = $uploadDir . '/' . $newFileName;

// Move file
if (!move_uploaded_file($fileTmpPath, $destPath)) {
    echo 'Failed to move uploaded file';
    exit();
}

// DB insert
$timestamp = date('Y-m-d H:i:s');
$remarksEscaped = mysqli_real_escape_string($conn, $remarks);

$sql = "INSERT INTO uploaded_broadsheet (userid, districtid, attached_pdf, `timestamp`, `remarks`)
        VALUES ('$uid', '$did', '$newFileName', '$timestamp', '$remarksEscaped')";

$res = execute_query($sql);

if ($res) {
    echo 'PDF uploaded successfully';
} else {
    // optional rollback
    if (file_exists($destPath)) {
        unlink($destPath);
    }
    echo 'Database insertion failed';
}

exit();
?>