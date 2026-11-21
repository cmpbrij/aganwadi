<?php
include 'admin_master.php';
ob_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!checkLogin()) {
    header('Location: login.php');
}


// Check if the form has been submitted
if (isset($_POST['changeUserDetails'])) {
    if (isset($_POST['user_id'])) {
        $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
        
        // Fetch the existing user data
        $q1 = "SELECT * FROM admin_users WHERE id = ?";
        $stmt1 = $conn->prepare($q1);
        $stmt1->bind_param("i", $user_id);
        $stmt1->execute();
        $res1 = $stmt1->get_result();
        $adata = $res1->fetch_assoc();

        if ($adata) {
            $u_id = $adata['id'];
            $u_mobile = $adata['mobile'];
            $u_name = $adata['name'];
        } else {
            $_SESSION['error_in_update'] = "Error: User details do not exist.";
            header('Location: admin_user_update.php');
            exit();
        }
    } else {
        $_SESSION['error_in_update'] = "Error: User ID not provided.";
        header('Location: admin_user_update.php');
        exit();
    }

    // Retrieve and sanitize the form data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
    $updated_at = date('Y-m-d H:i:s'); // Current date and time

    // Prepare the SQL statement to update user details
    $q = "UPDATE admin_users SET `name` = ?, `mobile` = ?,`userid` = ? WHERE id = ?";
    $stmt1 = $conn->prepare($q);
    $stmt1->bind_param("sssi", $name, $mobile, $mobile, $user_id);

    // Execute the update statement
    if ($stmt1->execute()) {
        // Prepare the SQL statement to insert update record
        $sql = "INSERT INTO admin_user_updates (`user_id`, `name`, `mobile`, `updated_at`) 
                VALUES (?, ?, ?, ?)";
        $stmt2 = $conn->prepare($sql);
        // Bind parameters
        $stmt2->bind_param("isss", $u_id, $u_name, $u_mobile, $updated_at);

        

        // Execute the insert statement
        if ($stmt2->execute()) {
            $_SESSION['success'] = "User details updated successfully!";
        } else {
            $_SESSION['error_in_update'] = "Error recording update details: " . $stmt2->error;
        }
    } else {
        $_SESSION['error_in_update'] = "Error updating user details: " . $stmt1->error;
    }

    // Redirect back to the form or desired page
    header('Location: admin_user_update.php?id='.$u_id);
    exit();
}
else{
    echo"Something went wrong";
}
?>
