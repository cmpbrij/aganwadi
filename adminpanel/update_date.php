<?php
include('../config/db_config.php');
$sql = "SELECT id, date_of_birth FROM new_application_details LIMIT 5";
$res = execute_query($sql);
while ($row = mysqli_fetch_assoc($res)) {
    $date = date('Y-m-d', strtotime($row['date_of_birth']));
    $q = "UPDATE new_application_details SET dob='" . $date . "' WHERE id='" . $row['id'] . "'";
    $r = execute_query($q);
    if (!$r) {
        echo  $row['id'] . ",";
    }
}
?>