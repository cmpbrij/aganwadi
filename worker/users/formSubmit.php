<?php

include('../config/db_config.php');
include('../config/settings.php');
include('../config/sms-config.php');
session_start();
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 0);
// error_reporting(E_ALL);


if (!isset($_SESSION['uid'])) {
    echo "Something went wrong! Please login again.";
    die;
}

$query = "SELECT `name`,`father_name`,`mobile`,`id`,district FROM users WHERE `id`='" .$_SESSION['uid'] . "'";
    $res = execute_query($query);
    $data = mysqli_fetch_assoc($res);

    $district_id = $data['district'];
   


   $q = "SELECT districts.id,districts.district_name  FROM `districts`
    JOIN `vacancy_order` ON districts.id=vacancy_order.dist_id 
    WHERE vacancy_order.last_date >= '" . date('Y-m-d') . "' AND districts.id='" . $district_id . "'";
    $re = execute_query($q);
    if (mysqli_num_rows($re) <= 0) {
        header('Location: dashboard.php');
    }
// function getAgeDetails(string $dateOfBirth): array {
//     if (empty($dateOfBirth)) {
//         return ['year' => 0, 'month' => 0, 'day' => 0];
//     }
    
//     // Fixed cutoff date as per your requirement
//     $cutoffDate = "2026-01-01"; // Change this year as needed
    
//     $dob = new DateTime($dateOfBirth);
//     $cutoff = new DateTime($cutoffDate);
    
    
//     $interval = $dob->diff($cutoff);
    
//     return [
//         'year'  => (int) $interval->y,
//         'month' => (int) $interval->m,
//         'day'   => (int) $interval->d
//     ];
// }

function getAgeDetails(string $dateOfBirth, int $district_id): array
{
    if (empty($dateOfBirth)) {
        return [
            'year' => 0,
            'month' => 0,
            'day' => 0
        ];
    }

    $query = "SELECT cutoff_date
              FROM vacancy_order
              WHERE dist_id = '$district_id'
              LIMIT 1";

    $res = execute_query($query);

    if (!$res || mysqli_num_rows($res) == 0) {
        return [
            'year' => 0,
            'month' => 0,
            'day' => 0
        ];
    }

    $row = mysqli_fetch_assoc($res);

    // Value from DB: jan or july
    $cutoffType = strtolower(trim($row['cutoff_date']));

    if ($cutoffType == 'july') {
        $cutoffDate = '2026-07-01';
    } else {
        $cutoffDate = '2026-01-01';
    }

    // DOB format is YYYY-MM-DD
    $dob = new DateTime($dateOfBirth);
    $cutoff = new DateTime($cutoffDate);

    $interval = $dob->diff($cutoff);

    return [
        'year'  => (int)$interval->y,
        'month' => (int)$interval->m,
        'day'   => (int)$interval->d
    ];
}

if (isset($_POST['save1'])) {
    $date = date("Y-m-d H:i:s");
    $uid = $_SESSION['uid'];
    $mobile = isset($_SESSION['mobile']) ? $_SESSION['mobile'] : '';
    
    // Check if user is logged in
    if (empty($uid)) {
        $_SESSION['error'] = "कुछ गलत हुआ! कृपया पुनः लॉगिन करें।";
        header('Location: step-1.php');
        exit;
    }
    
    // Initialize validation flag
    $isValid = true;
    $errorMessages = [];
    
    // Validate required fields
    $requiredFields = [
        'district_name' => 'जनपद का नाम',
        'project' => 'परियोजना',
        'grameen_sehri' => 'शहरी/ग्रामीण',
        'gram_panchayat' => 'ग्राम पंचायत/वार्ड का नाम',
        'rikt_aww_center' => 'रिक्त आंगनवाड़ी केंद्र का नाम',
        'applicant_name' => 'आवेदिका का हिंदी में नाम',
        'applicant_name_en' => 'आवेदिका का अंग्रेजी में नाम',
        'father_name' => 'पिता का नाम',
        'mother_name' => 'माता का नाम',
        'marital_status' => 'वैवाहिक स्थिति',
        'permanent_full_address' => 'स्थायी पता',
        'permanent_full_address_pincode' => 'स्थायी पता पिन कोड',
        'mailing_full_address' => 'पत्र व्यवहार का पता',
        'mailing_full_address_pincode' => 'पत्र व्यवहार पिन कोड',
        'dob' => 'जन्मतिथि'
    ];
    
    // Check all required fields
    foreach ($requiredFields as $field => $fieldName) {
        if (empty($_POST[$field])) {
            $isValid = false;
            $errorMessages[] = "$fieldName आवश्यक है।";
        }
    }
    
    // Special validation for husband name if married
    if (isset($_POST['marital_status']) && $_POST['marital_status'] == '1' && empty($_POST['husband_name'])) {
        $isValid = false;
        $errorMessages[] = "विवाहित स्थिति में पति का नाम आवश्यक है।";
    }
    
    // Age validation
    if (!empty($_POST['dob'])) {
        $dob = $_POST['dob'];
        $ageDetails = getAgeDetails($dob,$district_id);
        
        // Check age range (18-35 years)
        if ($ageDetails['year'] < 18 || $ageDetails['year'] > 35) {
            $isValid = false;
            $errorMessages[] = "आवेदिका की आयु 18 से 35 वर्ष के बीच होनी चाहिए। वर्तमान आयु: {$ageDetails['year']} वर्ष";
            $_SESSION['error'] = "फ़ाइल अपलोड करते समय त्रुटि हुई।";
            $_SESSION['old'] = $_POST;

            header("Location: step-1.php");
            exit;
        }
    }
    
   
    // File upload validation
    $h_marksheet = '';
    $old_h_marksheet = !empty($_POST['old_h_marksheet']) ? $_POST['old_h_marksheet'] : '';
    
    if (!$isValid) {
        // If validation failed, redirect with errors
        $_SESSION['error'] = implode("<br>", $errorMessages);
        // header('Location: step-1.php');
        // exit;
    }
    
    // Proceed with file upload if validation passed
    if (isset($_FILES['h_marksheet']) && !empty($_FILES['h_marksheet']['name'])) {
        $file = $_FILES['h_marksheet'];
        $maxSize = 250 * 1024; // 200KB as per your form
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        
        // Check file size
        // if ($file['size'] > $maxSize) {
        //     $_SESSION['error'] = "फ़ाइल का आकार 250KB से अधिक नहीं होना चाहिए।";
        //     header('Location: step-1.php');
        //     exit;
        // }
        
        // Check file type
        $fileType = mime_content_type($file['tmp_name']);
        if (!in_array($fileType, $allowedTypes)) {
            $_SESSION['error'] = "केवल JPG, PNG. JPEG फ़ाइलें अनुमत हैं।";
            
            // header('Location: step-1.php');
            // exit;
        }
        
        
        // Prepare upload directory
        $dir = '../newuploads/';
        $newdir = $_SESSION['uid'];
        $check = $dir . '/' . $newdir;
        
        if (!file_exists($check)) {
            mkdir('../newuploads/' . $newdir, 0777, true);
        }
        
        $uploadDir = "../newuploads/" . $newdir . "/";
        $fileName = uniqid() . '_' . basename($file['name']);
        $targetFile = $uploadDir . $fileName;
        
        // Move uploaded file
        if (!move_uploaded_file($file['tmp_name'], $targetFile)) {
            $_SESSION['error'] = "फ़ाइल अपलोड करते समय त्रुटि हुई।";
            // header('Location: step-1.php');
            // exit;
        }
        
        // Remove old file if exists
        if (!empty($old_h_marksheet) && file_exists($old_h_marksheet)) {
            unlink($old_h_marksheet);
        }
        
        $h_marksheet = $targetFile;
        } else if (!empty($old_h_marksheet)) {
            // Use old file if no new file uploaded
            $h_marksheet = $old_h_marksheet;
        } else {
        // No file uploaded and no old file
        $_SESSION['error'] = "हाई स्कूल प्रमाणपत्र आवश्यक है।";
        // header('Location: step-1.php');
        // exit;
    }
   
    
    // Escape all input data
    $district = mysqli_real_escape_string($conn, $_POST['district_name']);
    $vikas_khand = mysqli_real_escape_string($conn, $_POST['project']);
    $grameen_sehri = mysqli_real_escape_string($conn, $_POST['grameen_sehri']);
    $gram_panchayat = mysqli_real_escape_string($conn, $_POST['gram_panchayat']);
    $nay_panchayat = mysqli_real_escape_string($conn, $_POST['nya_panchyat']);
    $rikt_aww_center = mysqli_real_escape_string($conn, $_POST['rikt_aww_center']);
    $name_hi = mysqli_real_escape_string($conn, $_POST['applicant_name']);
    $name_en = mysqli_real_escape_string($conn, $_POST['applicant_name_en']);
    $fname = mysqli_real_escape_string($conn, $_POST['father_name']);
    $mname = mysqli_real_escape_string($conn, $_POST['mother_name']);
    $hname = mysqli_real_escape_string($conn, $_POST['husband_name']);
    $prename = !empty($_POST['pre_name']) ? mysqli_real_escape_string($conn, $_POST['pre_name']) : '';
    $dob = $_POST['dob'];
    $marital_status = $_POST['marital_status'];
    $permanent_full_address = mysqli_real_escape_string($conn, $_POST['permanent_full_address']);
    $permanent_full_address_pincode = mysqli_real_escape_string($conn, $_POST['permanent_full_address_pincode']);
    $mailing_full_address = mysqli_real_escape_string($conn, $_POST['mailing_full_address']);
    $mailing_full_address_pincode = mysqli_real_escape_string($conn, $_POST['mailing_full_address_pincode']);
    
    // Get age details
     $dateOfBirth = getAgeDetails($dob,$district_id);
    $day = !empty($dateOfBirth['day']) ? $dateOfBirth['day'] : '0';
    $month = !empty($dateOfBirth['month']) ? $dateOfBirth['month'] : '0';
    $year = !empty($dateOfBirth['year']) ? $dateOfBirth['year'] : '0';
    
    // Get AWW code
    $qr = "SELECT unique_code FROM new_vacancy WHERE id='" .$rikt_aww_center. "'";
    $res_code = execute_query($qr);
    
    if (!$res_code || mysqli_num_rows($res_code) == 0) {
        $_SESSION['error'] = "रिक्त आंगनवाड़ी केंद्र का डेटा उपलब्ध नहीं है।";
        header('Location: step-1.php');
        exit;
    }
    
    $codedata = mysqli_fetch_assoc($res_code);
    $awwcode = $codedata['unique_code'];
    
    // Check if application already exists
    $sql1 = "SELECT COUNT(userid) as count FROM `new_application_details` WHERE userid='" . mysqli_real_escape_string($conn, $uid) . "'";
    $res1 = execute_query($sql1);
    
    if (!$res1) {
        $_SESSION['error'] = "डेटाबेस त्रुटि हुई। कृपया पुनः प्रयास करें।";
        header('Location: step-1.php');
        exit;
    }
    
    $count = mysqli_fetch_assoc($res1);
    
    if ($count['count'] == 0) {
        // Insert new record
        $sql = "INSERT INTO `new_application_details` (
            `userid`,`district`, 
            `project`,`grameen_sehri`, 
            `gram_panchayat`,`nay_panchayat`, 
            `rikt_aww_center`,`aww_code`,
            `name_hi`,`name_en`,`fname`,`mname`,`hname`,`mobile`, 
            `date_of_birth`,`year`,`month`,`day`,`pre_name`,
            `permanent_full_address`,`permanent_full_address_pincode`,`mailing_full_address`,`mailing_full_address_pincode`,
            `h_marksheet`,`marital_status`
        ) VALUES (
            '$uid','$district', 
            '$vikas_khand','$grameen_sehri', 
            '$gram_panchayat','$nay_panchayat', 
            '$rikt_aww_center', '$awwcode',
            '$name_hi','$name_en','$fname','$mname','$hname','$mobile', 
            '$dob','$year','$month','$day','$prename',
            '$permanent_full_address','$permanent_full_address_pincode','$mailing_full_address','$mailing_full_address_pincode',
            '$h_marksheet','$marital_status'
        )";
    } else {
        // Delete old record and insert new one
        $sql1 = "DELETE FROM new_application_details WHERE userid='" . mysqli_real_escape_string($conn, $uid) . "'";
        execute_query($sql1);
        
        $sql = "INSERT INTO `new_application_details` (
            `userid`,`district`, 
            `project`,`grameen_sehri`, 
            `gram_panchayat`,`nay_panchayat`, 
            `rikt_aww_center`,`aww_code`,
            `name_hi`,`name_en`,`fname`,`mname`,`hname`,`mobile`, 
            `date_of_birth`,`year`,`month`,`day`,`pre_name`,
            `permanent_full_address`,`permanent_full_address_pincode`,`mailing_full_address`,`mailing_full_address_pincode`,
            `h_marksheet`,`marital_status`
        ) VALUES (
            '$uid','$district', 
            '$vikas_khand','$grameen_sehri', 
            '$gram_panchayat','$nay_panchayat', 
            '$rikt_aww_center', '$awwcode',
            '$name_hi','$name_en','$fname','$mname','$hname','$mobile', 
            '$dob','$year','$month','$day','$prename',
            '$permanent_full_address','$permanent_full_address_pincode','$mailing_full_address','$mailing_full_address_pincode',
            '$h_marksheet','$marital_status'
        )";
    }
    
    $result = execute_query($sql);
    
    if ($result) {
         $_SESSION['success'] ="Step 1 completed successfully. Please proceed to Step 2.";
        header('Location: step-2.php');
        exit;
    } else {
        $_SESSION['error'] = "कुछ त्रुटि हुई! कृपया पुनः प्रयास करें।";
        header('Location: step-1.php');
        exit;
    }
}

if (isset($_POST['save2'])) {

    $uid = $_SESSION['uid'];
  
    $q="select userid from new_application_details where userid='".$uid."'";
    $res=execute_query($q);
    if(mysqli_num_rows($res) <= 0){
         $_SESSION['error'] = "कुछ गलत हुआ! कृपया पुनः भरे।";
         header('Location: step-1.php');
            exit;
    }
    $date = date("Y-m-d H:i:s");
    if (!isset($_POST['sub_category'])) {
        $_POST['sub_category'] = '';
    }

    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $sub_category = mysqli_real_escape_string($conn, $_POST['sub_category']);
    if ($sub_category == '') {
        $sub_category = 3;
    }

   
  
    $avedika_status = mysqli_real_escape_string($conn, $_POST['avedika_status']);
    $vidhwa_certificateno = mysqli_real_escape_string($conn, $_POST['vidhwa_certificateno']);
    $v_jarikrta_name = mysqli_real_escape_string($conn, $_POST['v_jarikrta_name']);
    $nivas_prmaanpatr_no = mysqli_real_escape_string($conn, $_POST['nivas_prmaanpatr_no']);
    $nivas_avedan_prmanpatr = mysqli_real_escape_string($conn, $_POST['nivas_avedan_prmanpatr']);

    $jaant_prmaanpatr_no = mysqli_real_escape_string($conn, $_POST['jaant_prmaanpatr_no']);
    $jaati_avedan_prmanpatr = mysqli_real_escape_string($conn, $_POST['jaati_avedan_prmanpatr']);

    $aay_prmaanpatr_no = mysqli_real_escape_string($conn, $_POST['aay_prmaanpatr_no']);
    $aay_avedan_prmanpatr = mysqli_real_escape_string($conn, $_POST['aay_avedan_prmanpatr']);

    $bpl_card = mysqli_real_escape_string($conn, $_POST['bpl']);
    $drlno = mysqli_real_escape_string($conn, $_POST['drl_no']);
    $ddate = mysqli_real_escape_string($conn, $_POST['deth_date']);
    $dperson = mysqli_real_escape_string($conn, $_POST['death_person']);

    $grampanchayatname = mysqli_real_escape_string($conn, $_POST['grampanchayatname']);
    $aganvadi_center = mysqli_real_escape_string($conn, $_POST['aganvadi_center']);
    $jaati = mysqli_real_escape_string($conn, $_POST['jaati']);
    $varshik_aay = mysqli_real_escape_string($conn, $_POST['varshik_aay']);
    $aay_prmaanpatr_issue_date = mysqli_real_escape_string($conn, $_POST['aay_prmaanpatr_issue_date']);
    
echo $aay_prmaanpatr_issue_date; 
    //file upload path
    $dir = '../newuploads/';
    $newdir = $_SESSION['uid'];
    $check = $dir . '/' . $newdir;
    if (!file_exists($check)) {
        mkdir('../newuploads/' . $newdir, 0775, true);
    }

    $targetDir = "../newuploads/" . $newdir . "/";

    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');

    $ff = 0;
    $widocer = 0;

    
   

    // $aay_upload = mysqli_real_escape_string($conn, $_POST['aay_upload']);

    $divangta_pramnpatr = !empty($_POST['old_divangta_pramnpatr']) ? $_POST['old_divangta_pramnpatr'] : '';

   


    $aay_upload = !empty($_POST['old_aay_upload']) ? $_POST['old_aay_upload'] : '';
    if ($_FILES["aay_upload"]["size"] > 1) {
        $aayfileName = basename($_FILES["aay_upload"]["name"]);
        $aayfilerandName = 'aay_upload' . time();
        $aayfileType = pathinfo($aayfileName, PATHINFO_EXTENSION);
        $aay_upload_name = $targetDir . $aayfilerandName . '.' . $aayfileType;

        if (in_array($aayfileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["aay_upload"]["tmp_name"], $aay_upload_name)) {
                $ff = 1;
                $aay_upload = $aay_upload_name;
            }
        }
    }

    $nivas_upload = '';
    $jaati_upload = !empty($_POST['old_jaati_upload']) ? $_POST['old_jaati_upload'] : '';
    if ($_FILES["jaati_upload"]["size"] > 1) {
        $jaatifileName = basename($_FILES["jaati_upload"]["name"]);
        $jaatifilerandName = 'jaati_upload' . time();
        $jaatifileType = pathinfo($jaatifileName, PATHINFO_EXTENSION);
        $jaati_upload_name = $targetDir . $jaatifilerandName . '.' . $jaatifileType;

        if (in_array($jaatifileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["jaati_upload"]["tmp_name"], $jaati_upload_name)) {
                $ff = 1;
                $jaati_upload = $jaati_upload_name;
            }
        }
    }

    $niwash_file = !empty($_POST['old_niwash_file']) ? $_POST['old_niwash_file'] : '';
    if ($_FILES["niwash_file"]["size"] > 1) {
        $niwashfileName = basename($_FILES["niwash_file"]["name"]);
        $niwashfilerandName = 'niwash_file' . time();
        $niwashfileType = pathinfo($niwashfileName, PATHINFO_EXTENSION);
        $niwash_file_name = $targetDir . $niwashfilerandName . '.' . $niwashfileType;

        if (in_array($niwashfileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["niwash_file"]["tmp_name"], $niwash_file_name)) {
                $ff = 1;
                $niwash_file =  $niwash_file_name;
            }
        }
    }

    $v_uploaddata = !empty($_POST['old_cretificate_of_wido']) ? $_POST['old_cretificate_of_wido'] : '';

    if ($_FILES["cretificate_of_wido"]["size"] > 1) {

        $fileName1 = basename($_FILES["cretificate_of_wido"]["name"]);
        $randName1 = 'cretificate_of_wido' . time();
        $fileType1 = pathinfo($fileName1, PATHINFO_EXTENSION);
        $v_uploaddata_name = $targetDir . $randName1 . '.' . $fileType1;
        if (in_array($fileType1, $allowTypes)) {

            if (move_uploaded_file($_FILES["cretificate_of_wido"]["tmp_name"], $v_uploaddata_name)) {
                $widocer = 1;
                $v_uploaddata = $v_uploaddata_name;
            }
        }
    }

   

    $sql1 = "select count(userid) as count from `personal_details` where userid='" . $_SESSION['uid'] . "'";
    $res1 = execute_query($sql1);
    $count = mysqli_fetch_assoc($res1);

    if ($count['count'] == 0) {
        $sql = "INSERT INTO `personal_details` (`userid`,
        `category`,
        `sub_category`,
       
        `avedika_status`, 
        `vidhwa_certificateno`, 
        `v_jarikrta_name`, 
        `v_uploaddata`, 
        `nivas_prmaanpatr_no`, 
        `nivas_avedan_prmanpatr`, 
        `nivas_upload`, 
        `jaant_prmaanpatr_no`,
        `jaati_avedan_prmanpatr`, 
        `jaati_upload`, 
        `aay_prmaanpatr_no`, 
        `aay_avedan_prmanpatr`, 
        `aay_upload`, 
        `bpl_card`,
        `drl_no`,
        `death_date`,
        `death_person_name` ,`aganvadi_center` , `grampanchayatname`, `niwash_file` , `jaati`,
        `aay_prmaanpatr_issue_date` , `varshik_aay` )
	VALUES ('$uid',
        '$category',
        '$sub_category',
       
        '$avedika_status',
        '$vidhwa_certificateno',
        '$v_jarikrta_name',
        '$v_uploaddata',
        '$nivas_prmaanpatr_no',
        '$nivas_avedan_prmanpatr',
        '$nivas_upload',
        '$jaant_prmaanpatr_no',
        '$jaati_avedan_prmanpatr',
        '$jaati_upload',
        '$aay_prmaanpatr_no',
        '$aay_avedan_prmanpatr',
        '$aay_upload',
        '$bpl_card',
        '$drlno',
        '$ddate',
        '$dperson' ,'$aganvadi_center' , '$grampanchayatname', '$niwash_file' , '$jaati',
        '$aay_prmaanpatr_issue_date' , '$varshik_aay')";
        


        $stmt = execute_query($sql);
        if ($stmt) {
            // $msg = "Data save Successfully!";
             $_SESSION['success'] ="Step 2 completed successfully. Please proceed to Step 3.";
            //$_SESSION['academicid'] = mysqli_insert_id($conn);
            header('Location: step-3.php');
            exit;
        } else {
            $msg = "Occure some error!";
            $_SESSION['error'] = $msg;
            header('Location: step-3.php');
            exit;
        }
    } else {

        $sql1 = "delete from personal_details where userid='" . $uid . "'";
        $result1 = execute_query($sql1);

        $sql = "INSERT INTO `personal_details` (`userid`,
                `category`,
                `sub_category`,
                `avedika_status`,
                `vidhwa_certificateno`, 
                `v_jarikrta_name`,
                `v_uploaddata`,
                `nivas_prmaanpatr_no`,
                `nivas_avedan_prmanpatr`,
                `nivas_upload`,
                `jaant_prmaanpatr_no`,
                `jaati_avedan_prmanpatr`,
                `jaati_upload`,
                `aay_prmaanpatr_no`,
                `aay_avedan_prmanpatr`,
                `aay_upload`,
                `bpl_card`,
                `drl_no`,
                `death_date`,
                `death_person_name` ,`aganvadi_center` , `grampanchayatname`,  `niwash_file` , `jaati`,
                `aay_prmaanpatr_issue_date` , `varshik_aay` ) 
        VALUES ('$uid',
                '$category',
                '$sub_category',
               
                '$avedika_status',
                '$vidhwa_certificateno',
                '$v_jarikrta_name',
                '$v_uploaddata',
                '$nivas_prmaanpatr_no',
                '$nivas_avedan_prmanpatr',
                '$nivas_upload',
                '$jaant_prmaanpatr_no',
                '$jaati_avedan_prmanpatr',
                '$jaati_upload',
                '$aay_prmaanpatr_no',
                '$aay_avedan_prmanpatr',
                '$aay_upload',
                '$bpl_card',
                '$drlno',
                '$ddate',
                '$dperson' ,'$aganvadi_center' , '$grampanchayatname', '$niwash_file' , '$jaati',
                '$aay_prmaanpatr_issue_date' , '$varshik_aay')";

              

        if ($result1) {
            $stmt = $conn->query($sql);
        }

        if ($stmt) {
            $msg = "Data save Successfully!";
            $_SESSION['success'] = $msg;
            $_SESSION['academicid'] = mysqli_insert_id($conn);
            header('Location: step-3.php');
        } else {
            $msg = "Occure some error!";
            $_SESSION['error'] = $msg;
            header('Location: step-3.php');
            exit;
        }
        header('Location: step-3.php');
    }
}
if (isset($_POST['academicSubmit'])) {

    $session_uid = !empty($_SESSION['uid']) ? $_SESSION['uid'] : '';
    $mobile = !empty($_SESSION['mobile']) ? $_SESSION['mobile'] : '';
   
    $i_present = !empty($_POST['i_present']) ? $_POST['i_present'] : '';
  
    $g_present = !empty($_POST['g_present']) ? $_POST['g_present'] : '';
    $pg_present = !empty($_POST['pg_present']) ? $_POST['pg_present'] : '';
    $h_school = !empty($_POST['h_school']) ? $_POST['h_school'] : '';
    $h_board = !empty($_POST['h_board']) ? $_POST['h_board'] : '';
    $h_year = !empty($_POST['h_year']) ? $_POST['h_year'] : '';
    $h_maxmarks = !empty($_POST['h_maxmarks']) ? $_POST['h_maxmarks'] : '';
    $h_totalmarks = !empty($_POST['h_totalmarks']) ? $_POST['h_totalmarks'] : '';
    $h_present = !empty($_POST['h_present']) ? $_POST['h_present'] : '';
    $i_school = !empty($_POST['i_school']) ? $_POST['i_school'] : '';
    $i_board = !empty($_POST['i_board']) ? $_POST['i_board'] : '';
    $i_year = !empty($_POST['i_year']) ? $_POST['i_year'] : '';
    $i_maxmarks = !empty($_POST['i_maxmarks']) ? $_POST['i_maxmarks'] : '';
    $i_totalmarks = !empty($_POST['i_totalmarks']) ? $_POST['i_totalmarks'] : '';
    
    $g_school = !empty($_POST['g_school']) ? $_POST['g_school'] : '';
    $g_board = !empty($_POST['g_board']) ? $_POST['g_board'] : '';
    $g_year = !empty($_POST['g_year']) ? $_POST['g_year'] : '';
    $g_maxmarks = !empty($_POST['g_maxmarks']) ? $_POST['g_maxmarks'] : '';
    $g_totalmarks = !empty($_POST['g_totalmarks']) ? $_POST['g_totalmarks'] : '';
    $pg_school = !empty($_POST['pg_school']) ? $_POST['pg_school'] : '';
    $pg_board = !empty($_POST['pg_board']) ? $_POST['pg_board'] : '';
    $pg_year = !empty($_POST['pg_year']) ? $_POST['pg_year'] : '';
    $pg_maxmarks = !empty($_POST['pg_maxmarks']) ? $_POST['pg_maxmarks'] : '';
    $pg_totalmarks = !empty($_POST['pg_totalmarks']) ? $_POST['pg_totalmarks'] : '';

    $sql1 = "select count(userid) as count from `academic_details` where userid='" . $session_uid . "'";
    $res1 = execute_query($sql1);
    $count = mysqli_fetch_assoc($res1);

    if ($count['count'] == 0) {
    } else {
        $sql1 = "DELETE from `academic_details` where userid='" . $session_uid . "'";
        execute_query($sql1);
    }

    $dir = '../newuploads/';
    $newdir = $session_uid;
    $check = $dir . '/' . $newdir;
    if (!file_exists($check)) {
        mkdir('../newuploads/' . $newdir, 0777, true);
    }

    //allow certain file formats
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    $h_mar = 0;
    $h_ot = 0;
    $i_mar = 0;
    $i_ot = 0;
    $g_mar = 0;
    $g_ot = 0;
    $pg_mar = 0;
    $pg_ot = 0;

    $targetDir = "../newuploads/" . $newdir . "/";

    $h_marksheetdoc = !empty($_POST['old_h_marksheetdoc']) ? $_POST['old_h_marksheetdoc'] : '';
    if (!empty($_FILES["h_marksheetdoc"]) && $_FILES["h_marksheetdoc"]["error"] == 0) {
        $fileName = basename($_FILES["h_marksheetdoc"]["name"]);
        $randName = 'h_marksheetdoc' . time();
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        $h_marksheetdoc_name = $targetDir . $randName . '.' . $fileType;

        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["h_marksheetdoc"]["tmp_name"], $h_marksheetdoc_name)) {
                $h_marksheetdoc = $h_marksheetdoc_name;
            }
        }
    }


    $h_otherdoc = !empty($_POST['old_h_otherdoc']) ? $_POST['old_h_otherdoc'] : '';

    if (!empty($_FILES["h_otherdoc"]) && $_FILES["h_otherdoc"]["error"] == 0) {
        $fileName1 = basename($_FILES["h_otherdoc"]["name"]);
        $randName1 = 'h_otherdoc' . time();
        $fileType1 = pathinfo($fileName1, PATHINFO_EXTENSION);
        $h_otherdoc_name = $targetDir . $randName1 . '.' . $fileType1;

        if (in_array($fileType1, $allowTypes)) {
            if (move_uploaded_file($_FILES["h_otherdoc"]["tmp_name"], $h_otherdoc_name)) {
                $h_otherdoc = $h_otherdoc_name;
            }
        }
    }

    $i_marksheetdoc = !empty($_POST['old_i_marksheetdoc']) ? $_POST['old_i_marksheetdoc'] : '';

    if (!empty($_FILES["i_marksheetdoc"]) && $_FILES["i_marksheetdoc"]["error"] == 0) {
        $fileName2 = basename($_FILES["i_marksheetdoc"]["name"]);
        $randName2 = 'i_marksheetdoc' . time();
        $fileType2 = pathinfo($fileName2, PATHINFO_EXTENSION);
        $i_marksheetdoc_name = $targetDir . $randName2 . '.' . $fileType2;

        if (in_array($fileType2, $allowTypes)) {
            if (move_uploaded_file($_FILES["i_marksheetdoc"]["tmp_name"], $i_marksheetdoc_name)) {
                $i_marksheetdoc = $i_marksheetdoc_name;
            }
        }
    }


    $i_otherdoc = !empty($_POST['old_i_otherdoc']) ? $_POST['old_i_otherdoc'] : '';
    if (!empty($_FILES["i_otherdoc"]) && $_FILES["i_otherdoc"]["error"] == 0) {
        $fileName3 = basename($_FILES["i_otherdoc"]["name"]);
        $randName3 = 'i_otherdoc' . time();
        $fileType3 = pathinfo($fileName3, PATHINFO_EXTENSION);
        $i_otherdoc_name = $targetDir . $randName3 . '.' . $fileType3;

        if (in_array($fileType3, $allowTypes)) {
            if (move_uploaded_file($_FILES["i_otherdoc"]["tmp_name"], $i_otherdoc_name)) {
                $i_otherdoc = $i_otherdoc_name;
            }
        }
    }

    $g_marksheetdoc = !empty($_POST['old_g_marksheetdoc']) ? $_POST['old_g_marksheetdoc'] : '';
    if (!empty($_FILES["g_marksheetdoc"]) && $_FILES["g_marksheetdoc"]["error"] == 0) {
        $fileName4 = basename($_FILES["g_marksheetdoc"]["name"]);
        $randName4 = 'g_marksheetdoc' . time();
        $fileType4 = pathinfo($fileName4, PATHINFO_EXTENSION);
        $g_marksheetdoc_name = $targetDir . $randName4 . '.' . $fileType4;

        if (in_array($fileType4, $allowTypes)) {
            if (move_uploaded_file($_FILES["g_marksheetdoc"]["tmp_name"], $g_marksheetdoc_name)) {
                $g_marksheetdoc = $g_marksheetdoc_name;
            }
        }
    }

    $g_otherdoc = !empty($_POST['old_g_otherdoc']) ? $_POST['old_g_otherdoc'] : '';
    if (!empty($_FILES["g_otherdoc"]) && $_FILES["g_otherdoc"]["error"] == 0) {
        $fileName5 = basename($_FILES["g_otherdoc"]["name"]);
        $randName5 = 'g_otherdoc' . time();
        $fileType5 = pathinfo($fileName5, PATHINFO_EXTENSION);
        $g_otherdoc_name = $targetDir . $randName5 . '.' . $fileType5;

        if (in_array($fileType5, $allowTypes)) {
            if (move_uploaded_file($_FILES["g_otherdoc"]["tmp_name"], $g_otherdoc_name)) {
                $g_otherdoc = $g_otherdoc_name;
            }
        }
    }

    $pg_marksheetdoc = !empty($_POST['old_pg_marksheetdoc']) ? $_POST['old_pg_marksheetdoc'] : '';
    if (!empty($_FILES["pg_marksheetdoc"]) && $_FILES["pg_marksheetdoc"]["error"] == 0) {
        $fileName6 = basename($_FILES["pg_marksheetdoc"]["name"]);
        $randName6 = 'pg_marksheetdoc' . time();
        $fileType6 = pathinfo($fileName6, PATHINFO_EXTENSION);
        $pg_marksheetdoc_name = $targetDir . $randName6 . '.' . $fileType6;

        if (in_array($fileType6, $allowTypes)) {
            if (move_uploaded_file($_FILES["pg_marksheetdoc"]["tmp_name"], $pg_marksheetdoc_name)) {
                $pg_marksheetdoc = $pg_marksheetdoc_name;
            }
        }
    }

    $pg_otherdoc = !empty($_POST['old_pg_otherdoc']) ? $_POST['old_pg_otherdoc'] : '';
    if (!empty($_FILES["pg_otherdoc"]) && $_FILES["pg_otherdoc"]["error"] == 0) {
        $fileName7 = basename($_FILES["pg_otherdoc"]["name"]);
        $randName7 = 'pg_otherdoc' . time();
        $fileType7 = pathinfo($fileName6, PATHINFO_EXTENSION);
        $pg_otherdoc_name = $targetDir . $randName7 . '.' . $fileType7;

        if (in_array($fileType7, $allowTypes)) {
            if (move_uploaded_file($_FILES["pg_otherdoc"]["tmp_name"], $pg_otherdoc_name)) {
                $pg_otherdoc = $pg_otherdoc_name;
            }
        }
    }

   // $_SESSION['addressformid'] = '';
    $tot = (float) $i_present + (float) $g_present + (float) $pg_present;
        
    $merit = (float) $tot / 10;
    $created = date('Y-d-m H:i:s');

    $sql = "INSERT INTO `academic_details` (
        `userid`, `mobile`, `addressformid`, `h_school`, `h_board`, `h_year`, `h_maxmarks`, `h_totalmarks`, 
        `h_present`, `h_marksheetdoc`, `h_otherdoc`, `i_school`, `i_board`, `i_year`, `i_maxmarks`, 
        `i_marksheetdoc`, `i_otherdoc`, `i_totalmarks`, `i_present`, `g_present`, `pg_present`, `g_school`, 
        `g_board`, `g_year`, `g_maxmarks`, `g_totalmarks`, `g_marksheetdoc`, `g_otherdoc`, `pg_school`, 
        `pg_board`, `pg_year`, `pg_maxmarks`, `pg_totalmarks`, `pg_marksheetdoc`, `pg_otherdoc`, `created`, `merit`
    ) VALUES (
        '" . $session_uid . "', '" . $mobile . "', '" . $_SESSION['addressformid'] . "', '" . $h_school . "', 
        '" . $h_board . "', '" . $h_year . "', '" . $h_maxmarks . "', '" . $h_totalmarks . "', '" . $h_present . "', 
        '" . $h_marksheetdoc . "', '" . $h_otherdoc . "', '" . $i_school . "', '" . $i_board . "', '" . $i_year . "', 
        '" . $i_maxmarks . "', '" . $i_marksheetdoc . "', '" . $i_otherdoc . "', '" . $i_totalmarks . "', '" . $i_present . "', 
        '" . $g_present . "', '" . $pg_present . "', '" . $g_school . "', '" . $g_board . "', '" . $g_year . "', '" . $g_maxmarks . "', 
        '" . $g_totalmarks . "', '" . $g_marksheetdoc . "', '" . $g_otherdoc . "', '" . $pg_school . "', '" . $pg_board . "', 
        '" . $pg_year . "', '" . $pg_maxmarks . "', '" . $pg_totalmarks . "', '" . $pg_marksheetdoc . "', '" . $pg_otherdoc . "', 
        '" . $created . "', '" . $merit . "'
    )";


    $stmt = $conn->query($sql);

    if ($stmt) {
        $msg = "Data save Successfully!";
        $_SESSION['success'] = $msg;
        $_SESSION['academicid'] = mysqli_insert_id($conn);
        header('Location: step-4.php');
    } else {

        header('Location: step-4.php');
        $msg = "Occure some error!";
        echo $msg;
    }
}
if (isset($_POST['uploadPhoto'])) {
   
    $session_uid = !empty($_SESSION['uid']) ? $_SESSION['uid'] : '';
    $sql1 = "select count(userid) as count from `uploaded_documents` where userid='" . $session_uid . "'";
    $res1 = execute_query($sql1);
    $count = mysqli_fetch_assoc($res1);

    if ($count['count'] == 0) {
    } else {
        $sql = "DELETE from `uploaded_documents` where userid='" . $session_uid . "'";
        execute_query($sql);
    }
   

    $old_photo_graph = !empty($_POST['old_photo_graph']) ? $_POST['old_photo_graph'] : '';
    $old_signature = !empty($_POST['old_signature']) ? $_POST['old_signature'] : '';
    $academicid = !empty($_SESSION['academicid']) ? $_SESSION['academicid'] : '';
    $date = date("Y-m-d H:i:s");
    $date1 = date("y-m-d");

    $dir = '../newuploads/';
    $newdir = $session_uid;
    $check = $dir . '/' . $newdir;
    if (!file_exists($check)) {
        mkdir('../newuploads/' . $newdir, 0777, true);
    }
    $targetDir = "../newuploads/" . $newdir . "/";

    //allow certain file formats
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');

    $filesavephoto = $old_photo_graph;

    if (!empty($_FILES["photo_graph"]) && $_FILES["photo_graph"]["error"] == 0) {
        $fileName = basename($_FILES["photo_graph"]["name"]);
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        $randName = 'photo' . time();
        $targetFilePath = $targetDir . $randName . '.' . $fileType;

        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["photo_graph"]["tmp_name"], $targetFilePath)) {
                $filesavephoto = $targetFilePath;
            }
        } else {
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF files are allowed to upload.';
            $_SESSION['error'] = $statusMsg;
            header('Location: step-4.php');
        }
    }

    $filesavesign = $old_signature;
    if (!empty($_FILES["signature"]) && $_FILES["signature"]["error"] == 0) {
        $fileName1 = basename($_FILES["signature"]["name"]);
        $fileType1 = pathinfo($fileName1, PATHINFO_EXTENSION);
        $randName1 = 'signature' . time();
        $targetFilePath1 = $targetDir . $randName1 . '.' . $fileType1;

        if (in_array($fileType1, $allowTypes)) {
            if (move_uploaded_file($_FILES["signature"]["tmp_name"], $targetFilePath1)) {
                $filesavesign = $targetFilePath1;
            }
        } else {
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF files are allowed to upload.';
            $_SESSION['error'] = $statusMsg;
            header('Location: step-4.php');
        }
    }


    $sql = "INSERT INTO `uploaded_documents` (`userid`,`academicid`,`applicationid`,`photo`,`signature`,`date`,`created`) VALUES ('" . $session_uid . "','" . $academicid . "','','" . $filesavephoto . "','" . $filesavesign . "','" . $date1 . "','" . $date . "')";

    $stmt = $conn->query($sql);
    $msg = "Photo & signature Uploaded Successfully";
    $_SESSION['success'] = $msg;
    $_SESSION['photoupdatedid'] = mysqli_insert_id($conn);
    header('Location: step-5.php');
}

if (isset($_POST['declerationSubmit'])) {
        $session_uid = $_SESSION['uid'];

   $sql = "SELECT 
        CASE 
            WHEN nad.userid IS NOT NULL 
             AND pd.userid IS NOT NULL 
             AND ad.userid IS NOT NULL 
             AND ud.userid IS NOT NULL
            THEN TRUE 
            ELSE FALSE 
        END AS form_complete
    FROM users u
    LEFT JOIN new_application_details nad ON u.id = nad.userid
    LEFT JOIN personal_details pd ON u.id = pd.userid
    LEFT JOIN academic_details ad ON u.id = ad.userid
    LEFT JOIN uploaded_documents ud ON u.id = ud.userid
    WHERE u.id = '$session_uid'";
   // echo $sql; 

        $res = execute_query($sql);
        $row = mysqli_fetch_assoc($res);

    if($row['form_complete']){
        header('Location: preview_form.php');
    }else{
         header('Location: login.php');
    }

   
}


if (isset($_GET['userOTP'])) {
    $sql = "select mobile from users where id='" . $_GET['userOTP'] . "'";
    $res = execute_query($sql);
    $row = mysqli_fetch_assoc($res);
    $otp = rand(1000, 9999);
    $re=sendroutedSms($otp, $row['mobile']);
  // print_r($re); die;
    $_SESSION['otp-final'] = $otp;
    $_SESSION['otp-finalmsg'] = $otp;
    header('Location: finalotp.php');
    exit;
}
if (isset($_POST['finalotpVerify'])) {

    if (isset($_SESSION['uid'])) {
        if(!isset($_SESSION['otp-final'])){
            header('Location: preview_form.php');
			 exit;
        }

     $captcha=$_POST['captcha'];
		$cstatus=json_decode(verifyCaptcha($captcha),true);
		//print_r($cstatus); die;
		if($cstatus['captcha_status'] ==407){
			$_SESSION['cerror']="Captcha Expired! Please refersh the page";
			 header('Location: finalotp.php');
			 exit;
		}
		else if($cstatus['captcha_status'] ==400){
			$_SESSION['cerror']="Captcha Verification Failed!";
			 header('Location: finalotp.php');
			 exit;
		}


        $postedOtp  = trim((string)($_POST['otp'] ?? ''));
        $sessionOtp = trim((string)($_SESSION['otp-final']));

        if ($postedOtp === '' || $postedOtp !== $sessionOtp) {
            $_SESSION['nototp1'] = "OTP wrong";
            header('Location: finalotp.php');
            exit;
        }
        unset($_SESSION['otp-final']);
        $_SESSION['otp_verified'] = true;


        // if ($_SESSION['otp-final'] == $_POST['otp']) {
        //      unset($_SESSION['otp-final']);
        // } else {
        //     $_SESSION['nototp1'] = "OTP wrong";
        //     header('Location: finalotp.php');
        //     ex
        // it;
        // }
                $uid= $_SESSION['uid'];
                $sqlv = "SELECT(
                    nad.userid IS NOT NULL
                    AND pd.userid IS NOT NULL
                    AND ad.userid IS NOT NULL
                    AND ud.userid IS NOT NULL
                ) AS form_complete
                FROM users u
                LEFT JOIN new_application_details nad ON u.id = nad.userid
                LEFT JOIN personal_details pd ON u.id = pd.userid
                LEFT JOIN academic_details ad ON u.id = ad.userid
                LEFT JOIN uploaded_documents ud ON u.id = ud.userid
                WHERE u.id = '$uid'
                LIMIT 1";

                $resv = execute_query($sqlv);
                $rowv = mysqli_fetch_array($resv);
            
              

                if ($rowv['form_complete'] == 1) {
                    // All records exist
                    // Continue
                } else {
                    // Any table missing this userid
                    $_SESSION['error']="Some thing went wrong! Plese try again";
                    header("Location: step-1.php");
                    exit;
                }
       


        $sql = "SELECT district,project,gram_panchayat,rikt_pd,rikt_aww_center from new_application_details where userid='" . $_SESSION['uid'] . "'";

        $res = execute_query($sql);
        $row = mysqli_fetch_array($res);
        if(mysqli_num_rows($res) > 0){
             $sql1="select userid from  decleration where userid='".$_SESSION['uid']."' and aganwadi_center='".$row['rikt_aww_center']."'";
             $res1=execute_query($sql1);
             if(mysqli_num_rows($res1) > 0){
                     $_SESSION['error'] = "You have already submitted an application for this center";
                     header('Location: dashboard.php');
                     exit;
             }
        }
        else{
            $_SESSION['error'] = "Some error occure, login again!";
            header('Location: login.php');
            exit;
        }

        $sql1q = "SELECT district from users where id='" . $_SESSION['uid'] . "'";
        $resu = execute_query($sql1q);
        $udata = mysqli_fetch_assoc($resu);

        $sql_q = "select last_date from vacancy_order where dist_id='" . $udata['district'] . "'";
        //  echo $sql_q;
        $r = execute_query($sql_q);
        $lrow = mysqli_fetch_assoc($r);


        if (date('Y-m-d') > $lrow['last_date'] ) {
            $q = "update users set application_no = 'R' where id='" . $_SESSION['uid'] . "'";
            execute_query($q);
            $_SESSION['error'] = "Can not submit, application date ended!";
            header('Location: dashboard.php');
            die;
        }


        $sql1 = "SELECT category from personal_details where userid='" . $_SESSION['uid'] . "'";
        $res1 = execute_query($sql1);
        $row1 = mysqli_fetch_array($res1);


        $dist = $row['district'];
        $project = $row['project'];
        $gram = $row['gram_panchayat'];

        // $project = $row['vikas_khand'];
        $category = $row1['category'];
        $id = $_SESSION['uid'];
        $type = $row['rikt_pd'];

        $appno = createapp_number();
        $date = date('Y-m-d');
        $dtime = date('Y-m-d H:i:s');

        $sql1 = "update users set application_no='" . $appno . "' where id='" . $_SESSION['uid'] . "'";
        execute_query($sql1);

         $sqlc="SELECT aganwadi_center from decleration WHERE userid='" . $_SESSION['uid'] . "' AND aganwadi_center='" .$center. "' ";
        $resc=execute_query($sqlc);
        if(mysqli_num_rows($resc) > 0){
            $_SESSION['success'] = "You have already submitted an application for this center";
            header('Location: dashboard.php');
            exit;
        }


        $sql = "INSERT INTO `decleration`(`userid`,`district_id`, `project_id`, `gram_panchyat_id`, `application_no`, `filled_date`, `application_type`, `category`,`aganwadi_center`,`apply_order`, `created`) 
        VALUES ('" . $_SESSION['uid'] . "','" . $dist . "','" . $project . "','" . $gram . "','" . $appno . "','" . $date . "','" . $type . "','" . $category . "','" . $row['rikt_aww_center'] . "','1','" . $dtime . "')";
        //echo $sql; die;
        $res = execute_query($sql);
        if ($res) {
            $_SESSION['success'] = "Your form is submitted succussfully !";
            header('Location: dashboard.php');
        }
        else{
            $_SESSION['error'] = "कुछ गलत हुआ! कृपया पुनः भरे।";
             header('Location: step-1.php');
            exit;
        }
    }
}
if (isset($_POST['apply_more'])) {

    $sql1 = "select count(userid) as c from decleration where userid='" . $_SESSION['uid'] . "'";;
    $res1 = execute_query($sql1);
    $orow = mysqli_fetch_array($res1);
    $count = $orow['c'];
    if($count <=0){
          $_SESSION['error'] = "Fill proper form!";
            header('Location: step-1.php');
            exit;
    }
    if ($count <= 3) {
        $id = $_SESSION['uid']; 
        $type = '';
        $center = $_POST['rikt_aww_center'];
        $category = $_POST['category'];
        $sqlc="SELECT aganwadi_center from decleration WHERE userid='" . $_SESSION['uid'] . "' AND aganwadi_center='" .$center. "' ";
        $resc=execute_query($sqlc);
        if(mysqli_num_rows($resc) > 0){
            $_SESSION['success'] = "You have already submitted an application for this center";
            header('Location: dashboard.php');
            exit;
        }
        
        $appno = createapp_number();
        $date = date('Y-m-d');
        $dtime = date('Y-m-d H:i:s');

        $q = "select district, project, gram_panchayat from new_application_details where userid='" . $_SESSION['uid'] . "'";
        $result = execute_query($q);
        $apdata = mysqli_fetch_array($result);



        $sql = "INSERT INTO `decleration`(`userid`, `application_no`, `filled_date`, `application_type`, `category`,`aganwadi_center`,`apply_order`, `created`,district_id,project_id,gram_panchyat_id) VALUES ('" . $_SESSION['uid'] . "','" . $appno . "','" . $date . "','" . $type . "','" . $category . "','" . $center . "','$count','" . $dtime . "','" . $apdata['district'] . "','" . $apdata['project'] . "','" . $apdata['gram_panchayat'] . "')";
        
        $res = execute_query($sql);
        if ($res) {
            $_SESSION['success'] = "Your form is submitted succussfully !";
            header('Location: dashboard.php');
        } else {
            echo 'Some thing went wrong';
        }
    } else {
        echo "Can not apply";
    }
}
function createapp_number()
{
    $sql = "SELECT district,project,nay_panchayat from new_application_details where userid='" . $_SESSION['uid'] . "'";
    $res = execute_query($sql);
    $row = mysqli_fetch_array($res);
    $dist = strtoupper($row['district']);
    $project = strtoupper($row['project']);
    $id = $_SESSION['uid'];
    //print_r($row); die;
    $pad = 'AWW';
    //$appno=$pad.'/'.$dist.'/'.$project.'/'.str_pad($id, 6, '0', STR_PAD_LEFT);
    $sql = "SELECT form_number FROM `application_no`";
    $res = execute_query($sql);
    $formrow = mysqli_fetch_array($res);
    $formnum = $formrow['form_number'];
    $formnum = str_pad($formnum, 6, '0', STR_PAD_LEFT);
    $next = $formnum + 1;
    $sql1 = "UPDATE `application_no` SET `form_number` = '" . $next . "'";
    execute_query($sql1);

    $appno = $pad . '/' . $dist . '/' . $project . '/' . $formnum;
    return $appno;
}


function verifyCaptcha($input) {
    /**
     verifyCaptcha : This function verifies the validity of Captcha Images
     
     @return : 407 (captcha expired), 200 (captcha verified), 400 (captcha unverified), 500 (Server Error)
     **/

 	 $date = time();
    if(isset($_SESSION['captcha_set']) &&
        isset($_SESSION['captcha_token']) &&
            isset($_SESSION['captcha_expire'])) {
                //assign values
                $captcha_expire = $_SESSION['captcha_expire'] ;
                $captcha_token = $_SESSION['captcha_token'];
                //check if captcha has expired
               if($date < $_SESSION['captcha_expire']){
                    if(md5($input.$captcha_expire) == $captcha_token){
                        unset( $_SESSION['captcha_expire'] );
                        unset( $_SESSION['captcha_token']);
                        unset($_SESSION['captcha_set']);
                        $return = array(
                            "captcha_status" => 200,
                            "captcha_message" => "Captcha Verified!",
                        );
                        return json_encode($return); 
                    } else {
                        $return = array(
                            "captcha_status" => 400,
                            "captcha_message" => "Captcha Verification Failed!",
                         );
                         return json_encode($return);
                    }

                }else{
                    $return = array(
                    "captcha_status" => 407,
                    "captcha_message" => "Captcha Expired!",
                    );
                    return json_encode($return);
               }
            }else{
                $return = array(
                "captcha_status" => 500,
                "captcha_message" => "Session Invalid!",
                 );
                return json_encode($return);
            }
}