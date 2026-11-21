<?php
session_start();
include('db_config.php');

if (isset($_SESSION['user_id'], $_SESSION['session_token'])) {
    $user_id = $_SESSION['user_id'];
    $session_token = $_SESSION['session_token'];

    $stmt = $pdo->prepare("SELECT session_token FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $db_token = $stmt->fetchColumn();

    // If tokens don't match, log the user out
    if ($session_token !== $db_token) {
        session_destroy();
        header("Location: login.php");
        exit;
    }
} else {
    // Redirect to login if not logged in
    header("Location: login.php");
    exit;
}



?>