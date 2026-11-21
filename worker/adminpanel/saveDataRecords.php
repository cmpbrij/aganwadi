<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

if (isset($_POST['saveProject'])) {
    $project_id = $_POST['project_id'] ?? '';
    $projectName = $_POST['projectName'] ?? '';
    $district_id = $_SESSION['distid'] ?? 0;

    if (empty($projectName)) {
        $_SESSION['error-msg'] = "Please enter Project Name";
        redirectBack('manageprojects.php');
        exit;
    }

    $tableName = 'projects';

    if ($project_id) {
        // Update existing project
        $sql = "UPDATE $tableName SET project_name = ?, district_id = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sii", $projectName, $district_id, $project_id);
    } else {
        // Check if project already exists
        $stmt = $conn->prepare("SELECT * FROM $tableName WHERE project_name = ? AND district_id = ?");
        $stmt->bind_param("si", $projectName, $district_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $_SESSION['error-msg'] = "Project Already Exists";
            redirectBack('manageprojects.php');
            exit;
        }

        // Insert new project
        $sql = "INSERT INTO $tableName (project_name, district_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $projectName, $district_id);
    }

    if ($stmt->execute()) {
        $_SESSION['success-msg'] = $project_id ? "Project Updated Successfully" : "Project Added Successfully";
        header('Location: projectslist.php');
        exit;
    } else {
        $_SESSION['error-msg'] = $project_id ? "Failed to Update Project" : "Failed to Add Project";
        redirectBack('manageprojects.php');
        exit;
    }
}

if (isset($_POST['saveGramPanchayat'])) {
    $row_id = $_POST['row_id'] ?? '';
    $gram_panchayat_name = $_POST['gram_panchayat_name'] ?? '';
    $project_id = $_POST['project_id'] ?? '';
    $type = $_POST['type'] ?? '';

    
    $district_id = $_SESSION['distid'] ?? 0;

    if (empty($gram_panchayat_name)) {
        $_SESSION['error-msg'] = "Please enter Gram Panchayat Name";
        redirectBack('managegrampanchayat.php');
        exit;
    }
    if (empty($project_id)) {
        $_SESSION['error-msg'] = "Please choose project";
        redirectBack('managegrampanchayat.php');
        exit;
    }

    $tableName = 'gram_panchayat';

    if ($row_id) {
        $sql = "UPDATE $tableName SET type = ? , project_id = ? ,gram_panchayat_name = ?, district_id = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssii",$type , $project_id, $gram_panchayat_name, $district_id, $row_id);
    } else {
        // Check if Gram Panchayat already exists
        $stmt = $conn->prepare("SELECT * FROM $tableName WHERE project_id = ? AND gram_panchayat_name = ? AND district_id = ?");
        $stmt->bind_param("ssi",  $project_id , $gram_panchayat_name, $district_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $_SESSION['error-msg'] = "Gram Panchayat Already Exists";
            redirectBack('managegrampanchayat.php');
            exit;
        }

        $sql = "INSERT INTO $tableName (type , project_id , gram_panchayat_name, district_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi",$type , $project_id, $gram_panchayat_name, $district_id);
    }

    if ($stmt->execute()) {
        $_SESSION['success-msg'] = $row_id ? "Gram Panchayat Updated Successfully" : "Gram Panchayat Added Successfully";
        header('Location: grampanchayatlist.php');
        exit;
    } else {
        $_SESSION['error-msg'] = $row_id ? "Failed to Update Gram Panchayat" : "Failed to Add Gram Panchayat";
        redirectBack('managegrampanchayat.php');
        exit;
    }
}




if (isset($_POST['action']) && $_POST['action'] == 'delete_project') {
    $row_id = !empty($_POST['row_id']) ? $_POST['row_id'] : '';
    if (empty($row_id)) {
        echo json_encode(['success' => false]);
        exit;
    }

    $sql = "DELETE FROM `projects` WHERE `id` = ?";
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


if (isset($_POST['action']) && $_POST['action'] == 'delete_grampanchayat') {
    $row_id = !empty($_POST['row_id']) ? $_POST['row_id'] : '';
    if (empty($row_id)) {
        echo json_encode(['success' => false]);
        exit;
    }

    $sql = "DELETE FROM `gram_panchayat` WHERE `id` = ?";
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

