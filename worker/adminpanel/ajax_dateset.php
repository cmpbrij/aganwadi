<?php
session_start();
include('../config/db_config.php');

header('Content-Type: application/json');

error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method'
    ]);
    exit;
}

if (!isset($_POST['save_letter_date'])) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request'
    ]);
    exit;
}

$anumodan_date = isset($_POST['anumodan_date']) ? trim($_POST['anumodan_date']) : '';
$letter_date = isset($_POST['letter_date']) ? trim($_POST['letter_date']) : '';
$remarks     = isset($_POST['remarks']) ? trim($_POST['remarks']) : '';
$dist_id     = isset($_SESSION['distid']) ? (int)$_SESSION['distid'] : 0;
$created_at  = date('Y-m-d H:i:s');

if ($letter_date == '') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Please select letter date'
    ]);
    exit;
}

if ($dist_id <= 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Session expired. Please login again.'
    ]);
    exit;
}

$remarks = $remarks;
$letter_date = $letter_date;

$sql = "INSERT INTO letter_date_setting (letter_date,anumodan_date,remarks, dist_id, created_at)
        VALUES ('$letter_date','$anumodan_date', '$remarks', '$dist_id', '$created_at')";
     
       

$run = execute_query($sql);


if ($run) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Date saved successfully'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Database insert failed: ' . mysqli_error($conn)
    ]);
}
exit;
?>