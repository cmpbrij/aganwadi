<?php


if (!isset($_SESSION['uid']) || !isset($_SESSION['login_token'])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

$uid = $_SESSION['uid'];
$token = $_SESSION['login_token'];

$stmt = $conn->prepare("SELECT login_token FROM users WHERE id=?");
$stmt->bind_param("i", $uid);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    session_destroy();
    header("Location: login.php");
    exit;
}

$row = $result->fetch_assoc();

if ($row['login_token'] !== $token) {
    session_destroy();
    header("Location: login.php");
    exit;
}