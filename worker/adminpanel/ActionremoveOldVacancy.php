<?php
include 'master.php';
ob_start();

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if (!checkLogin()) {
    header('Location: login.php');
    exit;
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error-msg'] = 'Invalid ID provided.';
    header('Location: old-vacancies.php');
    exit;
}

$row_id = $_GET['id']; 

$fetch_sql = "SELECT * FROM new_vacancy WHERE awc_master_id = '$row_id' LIMIT 1";
//echo $fetch_sql; die;
$fetch_result = execute_query($fetch_sql);
$row = mysqli_fetch_assoc($fetch_result);

$deleteQuery = "DELETE FROM new_vacancy WHERE awc_master_id = '$row_id'";
$deleteResult = execute_query($deleteQuery);



$updateQuery = "UPDATE awc_master_new SET status = 0 WHERE id = '$row_id'";
$updateResult = execute_query($updateQuery);


// $updateQuery2 = "UPDATE old_vacancy SET status = 0 WHERE id = '$row_id'";
// $updateResult2 = execute_query($updateQuery2);

if ($deleteResult && $updateResult) {

    $awccode = $row['unique_code'];
    $vacancy_available = $row['vacancy_available'];
    $project_id = $row['project_id'];
    $district_id = $row['district_id'];
    $category = $row['category'];
   $gram_panchayat_id = $row['gp_id'] ?? 0;

    $sector = $row['sector'];
    $centertype = $row['awc_urban_rural'] ?? 0;
    $old = $row['is_old'] ?? 0;
    $user_id = $_SESSION['adminid'] ?? null;

    $log_sql = "INSERT INTO activity_log 
                (awc_master_id, unique_code, vacancy_available, project_id, district_id, category, gp_id, sector, awc_urban_rural, created_at, is_old, user_id, action)
                VALUES 
                ('$row_id', '$awccode', '$vacancy_available', '$project_id', '$district_id', '$category', '$gram_panchayat_id', '$sector', '$centertype', '".date('Y-m-d H:i:s')."', '$old', '$user_id', 'Deleted')";
    execute_query($log_sql);

    $_SESSION['success-msg'] = "Vacancy removed successfully!";
} else {
    $_SESSION['error-msg'] = "Error removing vacancy. Please try again.";
}

header('Location: viewallvacancy.php');
exit;
?>
