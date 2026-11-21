<?php
header('Content-Type: application/json');
session_start();
include('../config/db_config.php');



function sendJson($status, $message, $code = 200) {
    http_response_code($code);
    echo json_encode([
        'status' => $status,
        'message' => $message
    ]);
    exit;
}

// if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
//     sendJson('error', 'Invalid request method', 400);
// }

if (!isset($_POST['UploadFinalList'])) {
    sendJson('error', 'Invalid request', 400);
}

if (!isset($_SESSION['distid']) || !isset($_SESSION['sid'])) {
    sendJson('error', 'Session expired. Please login again.', 401);
}

$did = (int)$_SESSION['distid'];
$uid = (int)$_SESSION['sid'];
$remarks = isset($_POST['remarks']) ? trim($_POST['remarks']) : '';

if (!isset($_FILES['pdf_file'])) {
    sendJson('error', 'No file received', 400);
}

if ($_FILES['pdf_file']['error'] !== UPLOAD_ERR_OK) {
    sendJson('error', 'File upload error', 400);
}

$fileTmpPath = $_FILES['pdf_file']['tmp_name'];
$fileName    = $_FILES['pdf_file']['name'];
$fileSize    = $_FILES['pdf_file']['size'];

$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
if ($fileExtension !== 'pdf') {
    sendJson('error', 'Only PDF files are allowed', 400);
}

$uploadDir = __DIR__ . '/finalList';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$newFileName = $did . '_' . uniqid('final_', true) . '.pdf';
$destPath = $uploadDir . '/' . $newFileName;

if (!move_uploaded_file($fileTmpPath, $destPath)) {
    sendJson('error', 'Failed to move uploaded file', 500);
}

$createdAt = date('Y-m-d H:i:s');
$currentDate = date('Y-m-d');
$remarksEscaped = mysqli_real_escape_string($conn, $remarks);
$newFileNameEscaped = mysqli_real_escape_string($conn, $newFileName);

$sql = "INSERT INTO uploaded_final_list 
(userid, district, attached_pdf, `date`, created_at, `remarks`)
VALUES 
('$uid', '$did', '$newFileNameEscaped', '$currentDate', '$createdAt', '$remarksEscaped')";

$res = execute_query($sql);

if ($res) {
    sendJson('success', 'PDF uploaded successfully', 200);
} else {
    if (file_exists($destPath)) {
        unlink($destPath);
    }
    sendJson('error', 'Database insertion failed', 500);
}
?>