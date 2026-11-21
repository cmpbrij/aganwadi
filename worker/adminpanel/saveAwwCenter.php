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
    $awc_name = isset($_POST['awc_name']) ? $_POST['awc_name'] : '';
    $project_id = isset($_POST['project_id']) ? $_POST['project_id'] : '';
    // $type_of_anganwadi = isset($_POST['type_of_anganwadi']) ? $_POST['type_of_anganwadi'] : '';
    $row_id = isset($_POST['row_id']) ? $_POST['row_id'] : '';

    $unique_code = isset($_POST['unique_code']) ? $_POST['unique_code'] : '';
    $vacancy_available = 'No';
    $category = isset($_POST['category']) ? $_POST['category'] : '';
    $gram_panchayat_id = isset($_POST['gram_panchayat_id']) ? $_POST['gram_panchayat_id'] : '';
    $ews = '0';
    if ($category == '5') {
        $ews = '1';
    } else {
        $ews = '0';
    }

    $district_id = isset($_SESSION['distid']) ? $_SESSION['distid'] : 0;
    $district_name = getdistName($district_id);
    $project_name = getProjectName($project_id);
    $gram_panchayat_name = getGrampanchayatName($gram_panchayat_id);
  
    $gram_panchayat_type = gpType($gram_panchayat_id);
    // Validation
    if (empty($awc_name)) {
        $_SESSION['error-msg'] = "Please enter Aww Center Name";
        redirectBack('manageawwcenter.php');
        exit;
    } elseif (empty($project_id)) {
        $_SESSION['error-msg'] = "Please choose project";
        redirectBack('manageawwcenter.php');
        exit;
    } elseif (empty($gram_panchayat_id)) {
        $_SESSION['error-msg'] = "Please choose gram panchayat";
        redirectBack('manageawwcenter.php');
        exit;
    }


    // Check if Aww Center already exists
    if (empty($row_id)) {
        $sql = "SELECT unique_code FROM new_vacancy WHERE unique_code = '$unique_code' AND district_id = '$district_id'";
       // echo $sql;

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $_SESSION['error-msg'] = "Aww Center Already Exists";
            redirectBack('manageawwcenter.php');
            exit;
        }
    }


    if ($row_id) {
        // Update query
        $sql = "UPDATE new_vacancy 
                SET district_name = '$district_name', 
                    project_name = '$project_name', 
                    -- unique_code = '$unique_code', 
                    vacancy_available = '$vacancy_available',
                
                    project_id = '$project_id', 
                    awc_name = '$awc_name', 
                    district_id = '$district_id' ,
                    category = '$category', 
                    ews = '$ews', 
                    gram_panchayat_id = '$gram_panchayat_id',
                    gram_panchayat_name = '$gram_panchayat_name',
                    awc_urban_rural = '$gram_panchayat_type'
                WHERE id = '$row_id'";
    } else {
        // Insert query
        $sql = "INSERT INTO new_vacancy 
                (project_name, district_name, unique_code, vacancy_available, project_id, awc_name, district_id, category, ews , gram_panchayat_id, gram_panchayat_name, awc_urban_rural)
                VALUES ('$project_name', '$district_name', '$unique_code', '$vacancy_available',  '$project_id', '$awc_name', '$district_id' , '$category', '$ews' , '$gram_panchayat_id', '$gram_panchayat_name', '$gram_panchayat_type')";
    }

    // Execute query
    if (execute_query($sql)) {
        $_SESSION['success-msg'] = $row_id ? "Aww Center Updated Successfully" : "Aww Center Added Successfully";
        header('Location: awwcenterlist.php');
    } else {
        $_SESSION['error-msg'] = $row_id ? "Failed to Update Aww Center" : "Failed to Add Aww Center";
        redirectBack('manageawwcenter.php');
    }
    exit;
}




if (isset($_POST['action']) && $_POST['action'] == 'delete_awwcenter') {
    $row_id = !empty($_POST['row_id']) ? $_POST['row_id'] : '';
    if (empty($row_id)) {
        echo json_encode(['success' => false]);
        exit;
    }

    $sql = "DELETE FROM `new_vacancy` WHERE `id` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $row_id);

    if ($stmt->execute()) {
        echo json_encode(['success' => true]);
        exit;
    } else {
        echo json_encode(['success' => false]);
        exit;
    }
}
