<?php

include 'master.php';
ob_start();

if (!checkLogin()) {
    header('Location: login.php');
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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

// echo "<pre>";
// print_r($_POST);
// exit;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['saveAwwCenter'])) {
    $awc_name = isset($_POST['center_name']) ? $_POST['center_name'] : '';
    $project_id = isset($_POST['project_id']) ? $_POST['project_id'] : '';
     $project_name = isset($_POST['project_name']) ? $_POST['project_name'] : '';
    $awccode=$_POST['awc_code'];
    $sector = isset($_POST['sector_name']) ? $_POST['sector_name'] : '';
    $row_id = isset($_POST['row_id']) ? $_POST['row_id'] : '';

    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $vacancy_available = 'Yes';
    $centertype = isset($_POST['centertype']) ? $_POST['centertype'] : '';

    $district_id = isset($_SESSION['distid']) ? $_SESSION['distid'] : 0;
     $district_name = getdistName($district_id);
     $gpname=$_POST['gp_name'];
     $wardname=$_POST['ward_name'];
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
    $qry="select id from new_vacancy where unique_code='$awccode'";
    $r=execute_query($qry);
    if(mysqli_num_rows($r) > 1){
         $_SESSION['error-msg'] = "This center already added!";
        redirectBack('managenewvacancy.php');
        exit;
    }
    $is_old = isset($_POST['is_old']) ? 1 : 0;

     $sql = "INSERT INTO new_vacancy 
                (awc_master_id,project_name, district_name, unique_code, vacancy_available, project_id, awc_name, district_id, category, sector, awc_urban_rural,created_at,gp_name,ward_name,is_old)
                VALUES ('$row_id','$project_name', '$district_name', '$awccode', '$vacancy_available',  '$project_id', '$awc_name', '$district_id' , '$category', '$sector', '$centertype','".date('Y-m-d h:i:s')."','$gpnaem','$wardname','$is_old')";
    
    $q="UPDATE `awc_master_new` SET `status`='1' WHERE id='$row_id'";
  
    execute_query($q);
    // Execute query
    if (execute_query($sql)) {
        $_SESSION['success-msg'] = "AWW Center Added Successfully";
        header('Location: managenewvacancy.php');
    } else {
        $_SESSION['error-msg'] = "Failed to Add Aww Center";
        redirectBack('managenewvacancy.php');
    }
    

}
else{
    echo"Some thing went wrong!";
}

?>