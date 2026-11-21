<?php
include 'master.php';

$userid = (int)$_GET['userid'];
$table  = $_GET['table'];
$column = $_GET['column'];

$allowTables = [
    'new_application_details',
    'academic_details',
    'personal_details'
];

if (!in_array($table, $allowTables)) {
    die("Invalid Request");
}

$sql = "SELECT `$column` FROM `$table` WHERE userid='$userid'";
$res = execute_query($sql);

if ($row = mysqli_fetch_assoc($res)) {

    $filepath = $row[$column];

    if (!empty($filepath)) {

        // If stored path starts with /
        $fullPath = $_SERVER['DOCUMENT_ROOT'] . $filepath;

        // If relative path
        if (!file_exists($fullPath)) {
            $fullPath = $filepath;
        }

        if (file_exists($fullPath)) {

            if (unlink($fullPath)) {
                echo "<script>
                    alert('Document deleted successfully.');
                    window.location='pbdoc.php?userid=".$userid."';
                </script>";
                exit;
            } else {
                echo "Unable to delete file.";
            }

        } else {
            echo "File not found.";
        }

    } else {
        echo "No document available.";
    }

} else {
    echo "Candidate not found.";
}
?>