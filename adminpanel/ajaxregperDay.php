<?php
include('../config/db_config.php');
// Fetch data from database
$sql = "SELECT DATE_FORMAT(created, '%d-%m-%Y') AS regdate,DATE_FORMAT(created, '%Y-%m-%d') as createddate, count(id) as count FROM users group by createddate,regdate";
$result = execute_query($sql);

$data = array();

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}



// Convert data to JSON format
echo json_encode($data);


?>