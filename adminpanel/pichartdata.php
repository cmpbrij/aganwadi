<?php
include('../config/db_config.php');

$sql = "select count(id) as count from users";
$result = execute_query($sql);
$row=mysqli_fetch_assoc($result);
$ureg=$row['count'];

$sql = "select count(id) as count from new_vacancy where vacancy_available='Yes'";
$result = execute_query($sql);
$row=mysqli_fetch_assoc($result);
$totalvacancy=$row['count'];


$sql = "select count(id) as count from vacancy_order";
$result = execute_query($sql);
$row=mysqli_fetch_assoc($result);
$totaladv=$row['count'];



$sql = "select count(id) as count from  decleration";
$result = execute_query($sql);
$row=mysqli_fetch_assoc($result);
$application=$row['count'];

$sql = "select count(id) as count from  new_application_details";
$result = execute_query($sql);
$row=mysqli_fetch_assoc($result);
$appstarted=$row['count'];

$stratedcount=$appstarted - $application;


$data=array(
    "user_reg" =>$ureg,
    "totaladv" =>$totaladv,
    "application" =>$application,
    "appstarted" =>$appstarted,
    "totalvacancy" =>$totalvacancy
   
);

echo json_encode($data);

?>