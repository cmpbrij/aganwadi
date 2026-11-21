<?php
session_start();

require_once(__DIR__ . '/../../includes/connect.php');
include('../funcFtion.php');


$districtId = $_SESSION['district_id'];

if (isset($_POST['status'])) {

    $sql = "UPDATE dsc_sign_jobs 
        SET status='1' 
        WHERE id = (
            SELECT id FROM (
                SELECT id FROM dsc_sign_jobs 
                WHERE district_id='$districtId' 
                ORDER BY id DESC 
                LIMIT 1
            ) as temp
        )";

    if (mysqli_query($con, $sql)) {
        echo "success";
    } else {
        echo "error";
    }
}
