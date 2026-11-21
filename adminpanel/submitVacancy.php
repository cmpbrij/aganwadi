<?php

include 'master.php';
ob_start();

if (!checkLogin()) {
    header('Location: login.php');
}


function redirectBack($path = '/')
{
    if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != '') {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        header("Location: " . $path);
        exit();
    }
}

if (isset($_POST['saveAwwCenter'])) {
    $awc_name = isset($_POST['center_name']) ? $_POST['center_name'] : '';
    $project_id = isset($_POST['project_id']) ? $_POST['project_id'] : '';
    $project_name = isset($_POST['project_name']) ? $_POST['project_name'] : '';
    $awccode = $_POST['awc_code'];
    $sector = isset($_POST['sector']) ? $_POST['sector'] : '';
    $gram_panchayat_id = isset($_POST['gram_panchayat_id']) ? intval($_POST['gram_panchayat_id']) : 0;
    $row_id = isset($_POST['row_id']) ? $_POST['row_id'] : '';
    // echo '<pre>';
    // print_r($_POST);
    // echo '</pre>';
    // exit;

    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $vacancy_available = 'Yes';
    $centertype = isset($_POST['centertype']) ? $_POST['centertype'] : '';

    $district_id = isset($_SESSION['distid']) ? $_SESSION['distid'] : 0;
    $district_name = getdistName($district_id);
    // $project_name = getProjectName($project_id);

    if (empty($awc_name)) {
        $_SESSION['error-msg'] = "Please enter Aww Center Name";
        redirectBack('managenewvacancy.php');
        exit;
    } elseif (empty($project_id)) {
        $_SESSION['error-msg'] = "Please choose project";
        redirectBack('managenewvacancy.php');
        exit;
    }
    $qry = "select id from new_vacancy where unique_code='$awccode'";
    $r = execute_query($qry);
    // if (mysqli_num_rows($r) > 0) {
    //     $_SESSION['error-msg'] = "This center already added!";
    //     redirectBack('managenewvacancy.php');
    //     exit;
    // }
}
if (isset($_POST['old'])) {
    $old = 1;
} else {
    $old = 0;
}

if (isset($_SESSION['adminid'])) {
    $user_id = $_SESSION['adminid'];
} else {
    $user_id = 0;
}
// print_r($_SESSION['adminid']);
// exit;
$sql = "INSERT INTO new_vacancy 
                (awc_master_id,project_name, district_name, unique_code, vacancy_available, project_id, awc_name, district_id, category, gp_id, sector, awc_urban_rural,created_at,is_old)
                VALUES ('$row_id','$project_name', '$district_name', '$awccode', '$vacancy_available',  '$project_id', '$awc_name', '$district_id' , '$category', '$gram_panchayat_id', '$sector', '$centertype','" . date('Y-m-d H:i:s') . "','" . $old . "')";

$log_sql = "INSERT INTO activity_log 
                (awc_master_id, unique_code, vacancy_available, project_id, district_id, category, gp_id, sector, awc_urban_rural, created_at, is_old, user_id, action)
                VALUES 
                ('$row_id', '$awccode', '$vacancy_available', '$project_id', '$district_id', '$category', '$gram_panchayat_id', '$sector', '$centertype', '" . date('Y-m-d H:i:s') . "', '$old', '$user_id', 'Added')";

mysqli_query($conn, $log_sql);

if ($old == 1)
    $q = "UPDATE `old_vacancy` SET `status`='1' WHERE id='$row_id'";
else
    $q = "UPDATE `awc_master_new` SET `status`='1' WHERE id='$row_id'";

execute_query($q);
// Execute query
if (execute_query($sql)) {
    $_SESSION['success-msg'] = "AWH Center Added Successfully";
    if ($old == 0)
        header('Location: managenewvacancy.php');
    else
        header('Location: old-vacancies.php');
} else {
    $_SESSION['error-msg'] = "Failed to Add Aww Center";
    if ($old == 0)
        header('Location: managenewvacancy.php');
    else
        header('Location: old-vacancies.php');
    // redirectBack('managenewvacancy.php');
}
