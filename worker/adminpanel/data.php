<?php
include('../config/db_config.php');
// Fetch data from database
$sql = "SELECT DATE_FORMAT(filled_date, '%d-%m-%Y') AS filled_date, count(application_no) as count FROM decleration group by filled_date";
$result = execute_query($sql);

$data = array();

while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}



// Convert data to JSON format
echo json_encode($data);


?>