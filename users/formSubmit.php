<?php

include('../config/db_config.php');
include('../config/settings.php');
include('../config/sms-config.php');
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
error_reporting(E_ALL);
//session_start();
//echo "test"; die;

// if (isset($_POST['pDetails-1'])) {
//     print_r($_POST);
// }
if(!isset($_SESSION['uid'])){
    echo"Something went wrong! Please login again.";
}

if (isset($_POST['save1'])) {
	//echo "<pre>"; print_r($_POST); exit;
	
    $date = date("Y-m-d H:i:s");
    $uid = $_SESSION['uid'];
    $mobile = $_SESSION['mobile'];

    $district = mysqli_real_escape_string($conn, $_POST['district_name']);
   // $tehseel = mysqli_real_escape_string($conn, $_POST['tehsil']);
    $vikas_khand = mysqli_real_escape_string($conn, $_POST['project']);
    $grameen_sehri = mysqli_real_escape_string($conn, $_POST['grameen_sehri']);
    $gram_panchayat = mysqli_real_escape_string($conn, $_POST['gram_panchayat']);
    //$ward_name = mysqli_real_escape_string($conn, $_POST['ward']);
    $nay_panchayat = mysqli_real_escape_string($conn, $_POST['nya_panchyat']);
   // $rikt_pd = mysqli_real_escape_string($conn, $_POST['rikt_pd']);
    $rikt_aww_center = mysqli_real_escape_string($conn, $_POST['rikt_aww_center']);
    $name_hi = mysqli_real_escape_string($conn, $_POST['applicant_name']);
    $name_en = mysqli_real_escape_string($conn, $_POST['applicant_name_en']);

    $fname = mysqli_real_escape_string($conn, $_POST['father_name']);
    $mname = mysqli_real_escape_string($conn, $_POST['mother_name']);
    $hname = mysqli_real_escape_string($conn, $_POST['husband_name']);

    $dob = $_POST['dob'];
    $year = mysqli_real_escape_string($conn, $_POST['year']);
    $month = mysqli_real_escape_string($conn, $_POST['month']);
    $day = mysqli_real_escape_string($conn, $_POST['day']);
    $prename = mysqli_real_escape_string($conn, $_POST['pre_name']);

	$sql1="select count(userid) as count from `new_application_details` where userid='".$_SESSION['uid']."'";
	$res1=execute_query($sql1);
	$count=mysqli_fetch_assoc($res1);
	//echo $count['count'];   die;
	if($count['count'] == 0){
		$sql = "INSERT INTO `new_application_details`(`userid`,`district`, `project`, `grameen_sehri`, `gram_panchayat`, `nay_panchayat`, `rikt_aww_center`, `name_hi`, `name_en`, `fname`, `mname`, `hname`, `mobile`, `date_of_birth`, `year`, `month`, `day`,`pre_name`) VALUES
		('$uid','$district','$vikas_khand','$grameen_sehri','$gram_panchayat','$nay_panchayat','$rikt_aww_center',
		'$name_hi','$name_en','$fname','$mname','$hname','$mobile','$dob','$year','$month','$day','$prename')";

      //echo $sql; die;
		$result = execute_query($sql);
		
		$_SESSION['success'] = "Data save Successfully!";
		if ($result) {
			$_SESSION['success'] = "Data save Successfully!";
			header('Location: personal_details.php');
		} else {
			//header('Location: application_details.php');
			$msg = "Occure some error!";
		}
        die;
	}
	else{
   
    $sql1="delete from new_application_details where userid='".$uid."'";
    execute_query($sql1);
    
    $sql = "INSERT INTO `new_application_details`(`userid`,`district`, `project`, `grameen_sehri`, `gram_panchayat`, `nay_panchayat`, `rikt_aww_center`, `name_hi`, `name_en`, `fname`, `mname`, `hname`, `mobile`, `date_of_birth`, `year`, `month`, `day`,`pre_name`) VALUES
    ('$uid','$district','$vikas_khand','$grameen_sehri','$gram_panchayat','$nay_panchayat','$rikt_aww_center',
    '$name_hi','$name_en','$fname','$mname','$hname','$mobile','$dob','$year','$month','$day','$prename')";

  // echo $sql; die;
    $result = execute_query($sql);
    
    $_SESSION['success'] = "Data save Successfully!";
    if ($result) {
        $_SESSION['success'] = "Data save Successfully!";
        header('Location: personal_details.php');
    } else {
        //header('Location: application_details.php');
        $msg = "Occure some error!";
    }
	}	
    
}

if (isset($_POST['save2'])) {
    print_r($_POST);
    die;
    // header('Location: address_details.php');
    // exit();
    $uid = $_SESSION['uid'];
    //$_SESSION['mobile'] = '9838668867';
    $date = date("Y-m-d H:i:s");
    // if(isset($_SESSION['personal-details-2'])){
    // 	header('Location: address_details.php');
    // }
    // else{
        if(!isset($_POST['sub_category'])){
            $_POST['sub_category']='';
        }
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $sub_category = mysqli_real_escape_string($conn, $_POST['sub_category']);
    if($sub_category==''){
        $sub_category=3;
    }

    
    $divangta_avedan_krmank = mysqli_real_escape_string($conn, $_POST['divangta_avedan_krmank']);
    $divangta_pramnpatr_kramank = mysqli_real_escape_string($conn, $_POST['divangta_pramnpatr_kramank']);
    $percentage = mysqli_real_escape_string($conn, $_POST['percentage']);
    $f_senani_sambandh = mysqli_real_escape_string($conn, $_POST['f_senani_sambandh']);
    // $f_senani_prmanptr = mysqli_real_escape_string($conn, $_POST['f_senani_prmanptr']);
    $avedika_status = mysqli_real_escape_string($conn, $_POST['avedika_status']);
    $vidhwa_certificateno = mysqli_real_escape_string($conn, $_POST['vidhwa_certificateno']);
    $v_jarikrta_name = mysqli_real_escape_string($conn, $_POST['v_jarikrta_name']);
    // $v_uploaddata = mysqli_real_escape_string($conn, $_POST['v_uploaddata']);
    $nivas_prmaanpatr_no = mysqli_real_escape_string($conn, $_POST['nivas_prmaanpatr_no']);
    $nivas_avedan_prmanpatr = mysqli_real_escape_string($conn, $_POST['nivas_avedan_prmanpatr']);
    $nivas_upload = mysqli_real_escape_string($conn, $_POST['nivas_upload']);
    $jaant_prmaanpatr_no = mysqli_real_escape_string($conn, $_POST['jaant_prmaanpatr_no']);
    $jaati_avedan_prmanpatr = mysqli_real_escape_string($conn, $_POST['jaati_avedan_prmanpatr']);
    $jaati_upload = mysqli_real_escape_string($conn, $_POST['jaati_upload']);
    $aay_prmaanpatr_no = mysqli_real_escape_string($conn, $_POST['aay_prmaanpatr_no']);
    $aay_avedan_prmanpatr = mysqli_real_escape_string($conn, $_POST['aay_avedan_prmanpatr']);
    $aay_upload = mysqli_real_escape_string($conn, $_POST['aay_upload']);
    $bpl_card = mysqli_real_escape_string($conn, $_POST['bpl']);

    $drlno = mysqli_real_escape_string($conn, $_POST['drl_no']);
    $ddate = mysqli_real_escape_string($conn, $_POST['deth_date']);
    $dperson = mysqli_real_escape_string($conn, $_POST['death_person']);
    // $pre_name = mysqli_real_escape_string($conn, $_POST['pre_name']);
    // $uid = $_SESSION['uid'];
    //file upload path
    $dir = '../newuploads/';
    $newdir = $_SESSION['uid'];
    $check = $dir . '/' . $newdir;
    if (!file_exists($check)) {
        mkdir('../newuploads/' . $newdir, 0777, true);
    }
    $targetDir = "../newuploads/".$newdir."/";

   // echo $targetDir;  die;
    $fileName = basename($_FILES["f_senani_prmanptr"]["name"]);
    $randName = 'ff' . time();
    $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
    $targetFilePath = $targetDir.$randName.'.'.$fileType;


    //$targetDir = "../uploads/" . $newdir . "/";
    $fileName1 = basename($_FILES["cretificate_of_wido"]["name"]);
    $randName1 = 'cretificate_of_wido'.time();
    $fileType1 = pathinfo($fileName1, PATHINFO_EXTENSION);
   // echo $fileType1; 
    $targetFilePath1 = $targetDir.$randName1.'.'.$fileType1;
   // echo $targetFilePath1;

    

    //echo  $targetFilePath1; die;
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    $ff = 0;
    $widocer = 0;
    $widocer = 0;
    if($_FILES["f_senani_prmanptr"]["size"] > 1){
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["f_senani_prmanptr"]["tmp_name"], $targetFilePath)) {
                $ff = 1;
            }
            else{

            }
        }
    }
    if($_FILES["cretificate_of_wido"]["size"] > 1){
        if (in_array($fileType1, $allowTypes)) {
            if (move_uploaded_file($_FILES["cretificate_of_wido"]["tmp_name"],$targetFilePath1)) {
                $widocer = 1;
            }
           
        }
    }

	$sql1="select count(userid) as count from `personal_details` where userid='".$_SESSION['uid']."'";
	$res1=execute_query($sql1);
	$count=mysqli_fetch_assoc($res1);
	//echo $count['count']; die;
	if($count['count'] == 0){
    $sql = "INSERT INTO `personal_details`(`userid`,`category`, `sub_category`, `divangta_avedan_krmank`, `divangta_pramnpatr_kramank`, 
			`percentage`, `f_senani_sambandh`, `f_senani_prmanptr`, `avedika_status`, `vidhwa_certificateno`, 
			`v_jarikrta_name`, `v_uploaddata`, `nivas_prmaanpatr_no`, `nivas_avedan_prmanpatr`, `nivas_upload`, `jaant_prmaanpatr_no`,
			 `jaati_avedan_prmanpatr`, `jaati_upload`, `aay_prmaanpatr_no`, `aay_avedan_prmanpatr`, `aay_upload`, `bpl_card`,`drl_no`,`death_date`,`death_person_name`)
	VALUES ('$uid','$category','$sub_category','$divangta_avedan_krmank','$divangta_pramnpatr_kramank','$percentage','$f_senani_sambandh','$targetFilePath',
			 '$avedika_status', '$vidhwa_certificateno','$v_jarikrta_name','$targetFilePath1','$nivas_prmaanpatr_no','$nivas_avedan_prmanpatr','$nivas_upload',
			 '$jaant_prmaanpatr_no','$jaati_avedan_prmanpatr','$jaati_upload','$aay_prmaanpatr_no','$aay_avedan_prmanpatr','$aay_upload','$bpl_card','$drlno','$ddate','$dperson')";

            //  echo $sql; 
            //  die;
    		$stmt = execute_query($sql);
			if ($stmt) {
				$msg = "Data save Successfully!";
				$_SESSION['success'] = $msg;
				$_SESSION['academicid'] = mysqli_insert_id($conn);
				header('Location: academic_details.php');
			} else {
				header('Location: academic_details.php');
				$msg = "Occure some error!";
				echo $msg;
			}
	}
	else{
    $sql1="delete from personal_details where userid='".$uid."'";
    execute_query($sql1);
        $sql = "INSERT INTO `personal_details`(`userid`,`category`, `sub_category`, `divangta_avedan_krmank`, `divangta_pramnpatr_kramank`, 
        `percentage`, `f_senani_sambandh`, `f_senani_prmanptr`, `avedika_status`, `vidhwa_certificateno`, 
        `v_jarikrta_name`, `v_uploaddata`, `nivas_prmaanpatr_no`, `nivas_avedan_prmanpatr`, `nivas_upload`, `jaant_prmaanpatr_no`,
         `jaati_avedan_prmanpatr`, `jaati_upload`, `aay_prmaanpatr_no`, `aay_avedan_prmanpatr`, `aay_upload`, `bpl_card`,`drl_no`,`death_date`,`death_person_name`)
VALUES ('$uid','$category','$sub_category','$divangta_avedan_krmank','$divangta_pramnpatr_kramank','$percentage','$f_senani_sambandh','$targetFilePath',
         '$avedika_status', '$vidhwa_certificateno','$v_jarikrta_name','$targetFilePath1','$nivas_prmaanpatr_no','$nivas_avedan_prmanpatr','$nivas_upload',
         '$jaant_prmaanpatr_no','$jaati_avedan_prmanpatr','$jaati_upload','$aay_prmaanpatr_no','$aay_avedan_prmanpatr','$aay_upload','$bpl_card','$drlno','$ddate','$dperson')";
        $stmt = $conn->query($sql);
        if ($stmt) {
            $msg = "Data save Successfully!";
            $_SESSION['success'] = $msg;
            $_SESSION['academicid'] = mysqli_insert_id($conn);
            header('Location: academic_details.php');
        } else {
            header('Location: academic_details.php');
            $msg = "Occure some error!";
            echo $msg;
        }
		header('Location: academic_details.php');
	}


    //echo $sql; 

    // $sql="INSERT INTO `academic_details`(`userid`, `first_step_status`, `h_school`, `h_board`, `h_year`, `h_maxmarks`, `h_englishmarks`, `h_typeofmarks`, `h_totalmarks`, `i_school`, `i_board`, `i_year`, `i_maxmarks`, `i_englishmarks`, `i_typeofmarks`, `i_totalmarks`, `g_school`, `g_board`, `g_year`, `g_macmarks`, `g_typeofmarks`, `g_totalmarks`, `apply_date`, `created`) VALUES ('','','".$_POST['h_school']."','".$_POST['h_board']."','".$_POST['h_year']."','".$_POST['h_year']."','".$_POST['h_maxMarks']."','".$_POST['h_englishMarks']."','".$_POST['h_typeofMarks']."','".$_POST['h_totalMarks']."','".$_POST['i_school']."','".$_POST['i_board']."','".$_POST['i_year']."','".$_POST['i_maxMarks']."','".$_POST['i_englishMarks']."','".$_POST['i_typeofMarks']."','".$_POST['i_totalMarks']."','".$_POST['g_school']."','".$_POST['g_year']."','".$_POST['g_maxMarks']."','".$_POST['g_typeofMarks']."','".$_POST['g_totalMarks']."','".date('Y-m-d')."','".date('Y-m-d H:i:s')."')";

    //  echo $sql;

    // die;


}


if (isset($_POST['academicSubmit'])) {
    $sql1="select count(userid) as count from `academic_details` where userid='".$_SESSION['uid']."'";
	$res1=execute_query($sql1);
	$count=mysqli_fetch_assoc($res1);
	//echo $count['count']; die;
	if($count['count'] == 0){

        $dir = '../newuploads/';
        $newdir = $_SESSION['uid'];
        $check = $dir . '/' . $newdir;
        if (!file_exists($check)) {
            mkdir('../newuploads/' . $newdir, 0777, true);
        }
        $targetDir = "../newuploads/" . $newdir . "/";
        $fileName = basename($_FILES["h_marksheetdoc"]["name"]);
        $randName = 'h_marksheetdoc' . time();
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        $h_marksheetdoc = $targetDir . $randName . '.' . $fileType;

      
        $fileName1 = basename($_FILES["h_otherdoc"]["name"]);
        $randName1 = 'h_otherdoc' . time();
        $fileType1 = pathinfo($fileName1, PATHINFO_EXTENSION);
        $h_otherdoc = $targetDir . $randName1 . '.' . $fileType1;

      
        $fileName2 = basename($_FILES["i_marksheetdoc"]["name"]);
        $randName2 = 'i_marksheetdoc' . time();
        $fileType2 = pathinfo($fileName2, PATHINFO_EXTENSION);
        $i_marksheetdoc = $targetDir . $randName2 . '.' . $fileType2;

      
        $fileName3 = basename($_FILES["i_otherdoc"]["name"]);
        $randName3 = 'i_otherdoc' . time();
        $fileType3 = pathinfo($fileName3, PATHINFO_EXTENSION);
        $i_otherdoc = $targetDir . $randName3 . '.' . $fileType3;

      
        $fileName4 = basename($_FILES["g_marksheetdoc"]["name"]);
        $randName4 = 'g_marksheetdoc' . time();
        $fileType4 = pathinfo($fileName4, PATHINFO_EXTENSION);
        $g_marksheetdoc = $targetDir . $randName4 . '.' . $fileType4;

      
        $fileName5 = basename($_FILES["g_otherdoc"]["name"]);
        $randName5 = 'g_otherdoc' . time();
        $fileType5 = pathinfo($fileName5, PATHINFO_EXTENSION);
        $g_otherdoc = $targetDir . $randName5 . '.' . $fileType5;

      
        $fileName6 = basename($_FILES["pg_marksheetdoc"]["name"]);
        $randName6 = 'pg_marksheetdoc' . time();
        $fileType6 = pathinfo($fileName6, PATHINFO_EXTENSION);
        $pg_marksheetdoc = $targetDir . $randName6 . '.' . $fileType6;

      
        $fileName7 = basename($_FILES["pg_otherdoc"]["name"]);
        $randName7 = 'pg_otherdoc' . time();
        $fileType7 = pathinfo($fileName6, PATHINFO_EXTENSION);
        $pg_otherdoc = $targetDir . $randName7 . '.' . $fileType7;


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

        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["h_marksheetdoc"]["tmp_name"], $h_marksheetdoc)) {
                $h_mar = 1;
            }
        }
        if (in_array($fileType1, $allowTypes)) {
            if (move_uploaded_file($_FILES["h_otherdoc"]["tmp_name"], $h_otherdoc)) {
                $h_ot = 1;
            }
        }
        if (in_array($fileType1, $allowTypes)) {
            if (move_uploaded_file($_FILES["i_marksheetdoc"]["tmp_name"], $i_marksheetdoc)) {
                $i_mar = 1;
            }
        }
        if (in_array($fileType1, $allowTypes)) {
            if (move_uploaded_file($_FILES["i_otherdoc"]["tmp_name"], $i_otherdoc)) {
                $i_ot = 1;
            }
        }
        if (in_array($fileType1, $allowTypes)) {
            if (move_uploaded_file($_FILES["g_marksheetdoc"]["tmp_name"], $g_marksheetdoc)) {
                $g_mar = 1;
            }
        }
        if (in_array($fileType1, $allowTypes)) {
            if (move_uploaded_file($_FILES["g_otherdoc"]["tmp_name"], $g_otherdoc)) {
                $g_ot = 1;
            }
        }
        if (in_array($fileType1, $allowTypes)) {
            if (move_uploaded_file($_FILES["pg_marksheetdoc"]["tmp_name"], $pg_marksheetdoc)) {
                $pg_mar = 1;
            }
        }
        if (in_array($fileType1, $allowTypes)) {
            if (move_uploaded_file($_FILES["pg_otherdoc"]["tmp_name"], $pg_otherdoc)) {
                $pg_ot = 1;
            }
        }
        $_SESSION['addressformid']='';
		$tot=(float)$_POST['i_present'] + (float)$_POST['g_present'] + (float)$_POST['pg_present'];
		$merit=(float)$tot/10;
        $sql = "INSERT INTO `academic_details`(`userid`, `mobile`, `addressformid`, `h_school`, `h_board`, `h_year`, `h_maxmarks`,  `h_totalmarks`,`h_present`, `h_marksheetdoc`, `h_otherdoc`, `i_school`, `i_board`, `i_year`, `i_maxmarks`, `i_marksheetdoc`, `i_otherdoc`,`i_totalmarks`,`i_present`,`g_present`,`pg_present`, `g_school`, `g_board`, `g_year`, `g_maxmarks`,  `g_totalmarks`, `g_marksheetdoc`, `g_otherdoc`,  `pg_school`, `pg_board`, `pg_year`, `pg_maxmarks`,  `pg_totalmarks`, `pg_marksheetdoc`, `pg_otherdoc`,`created`,`merit`) VALUES
    
    ('" . $_SESSION['uid'] . "','" . $_SESSION['mobile'] . "','" . $_SESSION['addressformid'] . "',
         '" . $_POST['h_school'] . "','" . $_POST['h_board'] . "','" . $_POST['h_year'] . "','" . $_POST['h_maxmarks'] . "','" . $_POST['h_totalmarks'] . "','" . $_POST['h_present'] . "',
         '" . $h_marksheetdoc . "','" . $h_otherdoc . "',
         '" . $_POST['i_school'] . "','" . $_POST['i_board'] . "','" . $_POST['i_year'] . "','" . $_POST['i_maxmarks'] . "','" . $i_marksheetdoc . "',
         '" . $i_otherdoc  . "','" . $_POST['i_totalmarks'] . "','" . $_POST['i_present'] . "',
         '" . $_POST['g_present'] . "','" . $_POST['pg_present'] . "','" . $_POST['g_school'] . "','" . $_POST['g_board'] . "','" . $_POST['g_year'] . "','" . $_POST['g_maxmarks'] . "','" . $_POST['g_totalmarks'] . "',
         '" . $g_marksheetdoc . "','" . $g_otherdoc . "',
         '" . $_POST['pg_school'] . "','" . $_POST['pg_board'] . "','" . $_POST['pg_year'] . "','" . $_POST['pg_maxmarks'] . "','" . $_POST['pg_totalmarks'] . "',
         '" . $pg_marksheetdoc . "','" . $pg_otherdoc . "',
         '" . date('Y-d-m H:i:s') . "','".$merit."')";
        $stmt = $conn->query($sql);


        //  echo $sql;
        // die;

        if ($stmt) {
            $msg = "Data save Successfully!";
            $_SESSION['success'] = $msg;
            $_SESSION['academicid'] = mysqli_insert_id($conn);
            header('Location: upload_document.php');
        } else {
            
            header('Location: upload_document.php');
            $msg = "Occure some error!";
            echo $msg;
        }
    }
    else{
        $sql1="DELETE from `academic_details` where userid='".$_SESSION['uid']."'";
        execute_query($sql1);
        $dir = '../newuploads/';
        $newdir = $_SESSION['uid'];
        $check = $dir . '/' . $newdir;
        if (!file_exists($check)) {
            mkdir('../newuploads/' . $newdir, 0777, true);
        }
        $targetDir = "../newuploads/".$newdir."/";
        $fileName = basename($_FILES["h_marksheetdoc"]["name"]);
        $randName = 'h_marksheetdoc' . time();
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        $h_marksheetdoc = $targetDir . $randName . '.' . $fileType;

       
        $fileName1 = basename($_FILES["h_otherdoc"]["name"]);
        $randName1 = 'h_otherdoc' . time();
        $fileType1 = pathinfo($fileName1, PATHINFO_EXTENSION);
        $h_otherdoc = $targetDir . $randName1 . '.' . $fileType1;

       
        $fileName2 = basename($_FILES["i_marksheetdoc"]["name"]);
        $randName2 = 'i_marksheetdoc' . time();
        $fileType2 = pathinfo($fileName2, PATHINFO_EXTENSION);
        $i_marksheetdoc = $targetDir . $randName2 . '.' . $fileType2;

       
        $fileName3 = basename($_FILES["i_otherdoc"]["name"]);
        $randName3 = 'i_otherdoc' . time();
        $fileType3 = pathinfo($fileName3, PATHINFO_EXTENSION);
        $i_otherdoc = $targetDir . $randName3 . '.' . $fileType3;

       
        $fileName4 = basename($_FILES["g_marksheetdoc"]["name"]);
        $randName4 = 'g_marksheetdoc' . time();
        $fileType4 = pathinfo($fileName4, PATHINFO_EXTENSION);
        $g_marksheetdoc = $targetDir . $randName4 . '.' . $fileType4;

       
        $fileName5 = basename($_FILES["g_otherdoc"]["name"]);
        $randName5 = 'g_otherdoc' . time();
        $fileType5 = pathinfo($fileName5, PATHINFO_EXTENSION);
        $g_otherdoc = $targetDir . $randName5 . '.' . $fileType5;

       
        $fileName6 = basename($_FILES["pg_marksheetdoc"]["name"]);
        $randName6 = 'pg_marksheetdoc' . time();
        $fileType6 = pathinfo($fileName6, PATHINFO_EXTENSION);
        $pg_marksheetdoc = $targetDir . $randName6 . '.' . $fileType6;

       
        $fileName7 = basename($_FILES["pg_otherdoc"]["name"]);
        $randName7 = 'pg_otherdoc' . time();
        $fileType7 = pathinfo($fileName6, PATHINFO_EXTENSION);
        $pg_otherdoc = $targetDir . $randName7 . '.' . $fileType7;


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

        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["h_marksheetdoc"]["tmp_name"], $h_marksheetdoc)) {
                $h_mar = 1;
            }
        }
        if (in_array($fileType1, $allowTypes)) {
            if (move_uploaded_file($_FILES["h_otherdoc"]["tmp_name"], $h_otherdoc)) {
                $h_ot = 1;
            }
        }
        if (in_array($fileType1, $allowTypes)) {
            if (move_uploaded_file($_FILES["i_marksheetdoc"]["tmp_name"], $i_marksheetdoc)) {
                $i_mar = 1;
            }
        }
        if (in_array($fileType1, $allowTypes)) {
            if (move_uploaded_file($_FILES["i_otherdoc"]["tmp_name"], $i_otherdoc)) {
                $i_ot = 1;
            }
        }
        if (in_array($fileType1, $allowTypes)) {
            if (move_uploaded_file($_FILES["g_marksheetdoc"]["tmp_name"], $g_marksheetdoc)) {
                $g_mar = 1;
            }
        }
        if (in_array($fileType1, $allowTypes)) {
            if (move_uploaded_file($_FILES["g_otherdoc"]["tmp_name"], $g_otherdoc)) {
                $g_ot = 1;
            }
        }
        if (in_array($fileType1, $allowTypes)) {
            if (move_uploaded_file($_FILES["pg_marksheetdoc"]["tmp_name"], $pg_marksheetdoc)) {
                $pg_mar = 1;
            }
        }
        if (in_array($fileType1, $allowTypes)) {
            if (move_uploaded_file($_FILES["pg_otherdoc"]["tmp_name"], $pg_otherdoc)) {
                $pg_ot = 1;
            }
        }
        
		$tot=(float)$_POST['i_present'] + (float)$_POST['g_present'] + (float)$_POST['pg_present'];
		$merit=(float)$tot/10;
        $sql = "INSERT INTO `academic_details`(`userid`, `mobile`, `addressformid`, `h_school`, `h_board`, `h_year`, `h_maxmarks`,  `h_totalmarks`,`h_present`, `h_marksheetdoc`, `h_otherdoc`, `i_school`, `i_board`, `i_year`, `i_maxmarks`, `i_marksheetdoc`, `i_otherdoc`,`i_totalmarks`,`i_present`,`g_present`,`pg_present`, `g_school`, `g_board`, `g_year`, `g_maxmarks`,  `g_totalmarks`, `g_marksheetdoc`, `g_otherdoc`,  `pg_school`, `pg_board`, `pg_year`, `pg_maxmarks`,  `pg_totalmarks`, `pg_marksheetdoc`, `pg_otherdoc`,`created`,`merit`) VALUES
    
    ('" . $_SESSION['uid'] . "','" . $_SESSION['mobile'] . "','" . $_SESSION['addressformid'] . "',
         '" . $_POST['h_school'] . "','" . $_POST['h_board'] . "','" . $_POST['h_year'] . "','" . $_POST['h_maxmarks'] . "','" . $_POST['h_totalmarks'] . "','" . $_POST['h_present'] . "',
         '" . $h_marksheetdoc . "','" . $h_otherdoc . "',
         '" . $_POST['i_school'] . "','" . $_POST['i_board'] . "','" . $_POST['i_year'] . "','" . $_POST['i_maxmarks'] . "','" . $i_marksheetdoc . "',
         '" . $i_otherdoc  . "','" . $_POST['i_totalmarks'] . "','" . $_POST['i_present'] . "',
         '" . $_POST['g_present'] . "','" . $_POST['pg_present'] . "','" . $_POST['g_school'] . "','" . $_POST['g_board'] . "','" . $_POST['g_year'] . "','" . $_POST['g_maxmarks'] . "','" . $_POST['g_totalmarks'] . "',
         '" . $g_marksheetdoc . "','" . $g_otherdoc . "',
         '" . $_POST['pg_school'] . "','" . $_POST['pg_board'] . "','" . $_POST['pg_year'] . "','" . $_POST['pg_maxmarks'] . "','" . $_POST['pg_totalmarks'] . "',
         '" . $pg_marksheetdoc . "','" . $pg_otherdoc . "',
         '" . date('Y-d-m H:i:s') . "','".$merit."')";
        $stmt = $conn->query($sql);
        header('Location: upload_document.php');
    }
}
if (isset($_POST['uploadPhoto'])) {
    $date = date("Y-m-d H:i:s");
    //file upload path
    $sql1="select count(userid) as count from `uploaded_documents` where userid='".$_SESSION['uid']."'";
	$res1=execute_query($sql1);
	$count=mysqli_fetch_assoc($res1);
	//echo $count['count']; die;
	if($count['count'] == 0){
        $dir = '../newuploads/';
        $newdir = $_SESSION['uid'];
        $check = $dir . '/' . $newdir;
        if (!file_exists($check)) {
            mkdir('../newuploads/' . $newdir, 0777, true);
        }
        $targetDir = "../newuploads/" . $newdir . "/";

        //echo $newdir; die;
        //Photo Upload
        $fileName = basename($_FILES["photo_graph"]["name"]);
        $fileName1 = basename($_FILES["signature"]["name"]);

        //echo $fileName; die;
        $randName = 'photo' . time();
        $randName1 = 'signature' . time();

        //echo $targetFilePath; die;
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        $fileType1 = pathinfo($fileName1, PATHINFO_EXTENSION);

        //echo $fileName; die;
        $targetFilePath = $targetDir . $randName . '.' . $fileType;
        $targetFilePath1 = $targetDir . $randName1 . '.' . $fileType1;

        $filesavephoto = $targetDir . $randName . '.' . $fileType;
        $filesavephoto1 = $targetDir . $randName1 . '.' . $fileType1;

        //allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes) && in_array($fileType1, $allowTypes)) {
            //upload file to server
            if (move_uploaded_file($_FILES["photo_graph"]["tmp_name"], $targetFilePath) && move_uploaded_file($_FILES["signature"]["tmp_name"], $targetFilePath1)) {
                // $statusMsg = "The file ".$fileName. " has been uploaded.";
                $sql = "INSERT INTO `uploaded_documents`(`userid`, `academicid`, `applicationid`, `photo`,`signature`,  `date`, `created`) VALUES ('" . $_SESSION['uid'] . "','" . $_SESSION['academicid'] . "',' ','" . $filesavephoto . "','" . $filesavephoto1 . "','" . date('y-m-d') . "','" . date('Y-m-d H:i:s') . "')";
               //echo $sql; die;

                $stmt = $conn->query($sql);
                $msg = "Photo & signature Uploaded Successfully";
                $_SESSION['success'] = $msg;
                $_SESSION['photoupdatedid'] = mysqli_insert_id($conn);
                header('Location: declearation.php');
            } else {
                $statusMsg = "Sorry, there was an error uploading your file.";
                echo $statusMsg; die;
            }
        } else {
            
        
            $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF files are allowed to upload.';
            echo $statusMsg;
            $_SESSION['error']=$statusMsg;
            header('Location: upload_document.php');
           // echo $statusMsg; die;
        }
    }
     else{
        $sql="DELETE from `uploaded_documents` where userid='".$_SESSION['uid']."'";
        execute_query($sql);

        $dir = '../newuploads/';
        $newdir = $_SESSION['uid'];
        $check = $dir . '/' . $newdir;
        if (!file_exists($check)) {
            mkdir('../newuploads/' . $newdir, 0777, true);
        }
        $targetDir = "../newuploads/" . $newdir . "/";

        //echo $newdir; die;
        //Photo Upload
        $fileName = basename($_FILES["photo_graph"]["name"]);
        $fileName1 = basename($_FILES["signature"]["name"]);

        //echo $fileName; die;
        $randName = 'photo' . time();
        $randName1 = 'signature' . time();

        //echo $targetFilePath; die;
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION);
        $fileType1 = pathinfo($fileName1, PATHINFO_EXTENSION);

        //echo $fileName; die;
        $targetFilePath = $targetDir . $randName . '.' . $fileType;
        $targetFilePath1 = $targetDir . $randName1 . '.' . $fileType1;

        $filesavephoto = $targetDir . $randName . '.' . $fileType;
        $filesavephoto1 = $targetDir . $randName1 . '.' . $fileType1;

        //allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes) && in_array($fileType1, $allowTypes)) {
            //upload file to server
            if (move_uploaded_file($_FILES["photo_graph"]["tmp_name"], $targetFilePath) && move_uploaded_file($_FILES["signature"]["tmp_name"], $targetFilePath1)) {
                // $statusMsg = "The file ".$fileName. " has been uploaded.";
                $sql = "INSERT INTO `uploaded_documents`(`userid`, `academicid`, `applicationid`, `photo`,`signature`,  `date`, `created`) VALUES ('" . $_SESSION['uid'] . "','" . $_SESSION['academicid'] . "',' ','" . $filesavephoto . "','" . $filesavephoto1 . "','" . date('y-m-d') . "','" . date('Y-m-d H:i:s') . "')";
               //echo $sql; die;

                $stmt = execute_query($sql);
                $msg = "Photo & signature Uploaded Successfully";
                $_SESSION['success'] = $msg;
                $_SESSION['photoupdatedid'] = mysqli_insert_id($conn);
                header('Location: declearation.php');
            } else {
                $statusMsg = "Sorry, there was an error uploading your file. Please retry again.";
                echo $statusMsg; die;
            }

            $msg = "Photo & signature Updated Successfully";
                $_SESSION['success'] = $msg;
            header('Location: declearation.php');
        }
        else{
            echo "Something Went wrong, Please try again!";
        }
    }
}


// if(isset($_POST['upload_doc'])){

// 	//file upload path
// 	$targetDir = "uploads/";
// 	$fileName = basename($_FILES["photo_graph"]["name"]);
// 	echo $fileName; die;
// 	$targetFilePath = $targetDir . $fileName;
// 	$fileType = pathinfo($targetFilePath,PATHINFO_EXTENSION);
// 	//allow certain file formats
// 	    $allowTypes = array('jpg','png','jpeg','gif');
// 	    if(in_array($fileType, $allowTypes)){
// 	        //upload file to server
// 	        if(move_uploaded_file($_FILES["photo_graph"]["tmp_name"], $targetFilePath)){
// 	            $statusMsg = "The file ".$fileName. " has been uploaded.";
// 	        }else{
// 	            $statusMsg = "Sorry, there was an error uploading your file.";
// 	        }
// 	    }else{
// 	        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF, & PDF files are allowed to upload.';
// 	    }

// }

if (isset($_POST['declerationSubmit'])) {
    // $sql = "select * from new_application_details where userid='" . $_SESSION['uid'] . "'";
    // $res = execute_query($sql);
    // $row = mysqli_fetch_array($res);
    // $dist = strtoupper($row['district']);
    // $project = strtoupper($row['vikas_khand']);
    // $id = $_SESSION['uid'];
    // //print_r($row);
    // $type = $row['rikt_pd'];
    // if ($type == '1') {
    //     $pad = 'AWWUP';
    // } else if ($type == '2') {
    //     $pad = 'AWHUP';
    // } else {
    //     $pad = 'MAWWHUP';
    // }

    // $_SESSION['app_no'] = $pad . '/' . $dist . '/' . $project . '/' . str_pad($id, 6, '0', STR_PAD_LEFT);
    // $_SESSION['declearation'] = 'yes';
    //echo"test"; die;
    header('Location: preview_form.php');
}

if (isset($_GET['userOTP'])) {
    $sql="select mobile from users where id='" .$_GET['userOTP']."'";
   
    $res=execute_query($sql);
    $row=mysqli_fetch_assoc($res);
    $otp = rand(1000,9999);
    sendresetOTP($otp,$row['mobile']);
    $_SESSION['otp-final']=$otp;
  
    $_SESSION['otp-finalmsg']=$otp;
    header('Location: finalotp.php');

}
if (isset($_POST['finalotpVerify'])) {
    if (isset($_SESSION['uid'])) {

     
        if($_SESSION['otp-final']==$_POST['otp']){
           // unset($_SESSION['otp-final']);
        }
        else{
            $_SESSION['nototp1']="OTP wrong";
            header('Location: finalotp.php');
        }

      
        $sql = "SELECT district,project,gram_panchayat,rikt_pd,rikt_aww_center from new_application_details where userid='" . $_SESSION['uid'] . "'";

       
        $res = execute_query($sql);
        $row = mysqli_fetch_array($res);

        $sql1q = "SELECT district from users where id='" . $_SESSION['uid'] . "'";
        $resu=execute_query($sql1q);
        $udata=mysqli_fetch_assoc($resu);
        $sql_q="select last_date from vacancy_order where dist_id='".$udata['district']."'";
      //  echo $sql_q;
        $r=execute_query($sql_q);
        $lrow=mysqli_fetch_assoc($r);

       
        // if($lrow['last_date'] < date('Y-m-d')){
        //     $q="update users set application_no = 'R' where id='".$_SESSION['uid']."'";
        //     execute_query($q);
        //     $_SESSION['last_date']="Can not submit";
        //     header('Location: dashboard.php');
        //     die;
        // }


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

        $sql1="update users set application_no='".$appno."' where id='".$_SESSION['uid']."'";
        execute_query($sql1);


        $sql = "INSERT INTO `decleration`(`userid`,`district_id`, `project_id`, `gram_panchyat_id`, `application_no`, `filled_date`, `application_type`, `category`,`aganwadi_center`,`apply_order`, `created`) 
        VALUES ('" . $_SESSION['uid'] . "','" . $dist . "','" . $project . "','" . $gram . "','" . $appno . "','" . $date . "','" . $type . "','" . $category . "','" . $row['rikt_aww_center'] . "','1','" . $dtime . "')";
        //echo $sql; die;
        $res = execute_query($sql);
        if ($res) {
            $_SESSION['success'] = "Your form is submitted succussfully !";
            header('Location: dashboard.php');
        } 
    }
}

if (isset($_POST['apply_more'])) {

    $sql1 = "select count(userid) as c from decleration where userid='" . $_SESSION['uid'] . "'";;
    $res1 = execute_query($sql1);
    $orow = mysqli_fetch_array($res1);
    $count = $orow['c'];
    if($count <= 3){
        $id = $_SESSION['uid'];
        //print_r($row); die;
        $type = '';
        $center = $_POST['rikt_aww_center'];
        $category = $_POST['category'];
//echo $center; die;

        $appno = createapp_number();
        $date = date('Y-m-d');
        $dtime = date('Y-m-d H:i:s');

        $q="select district, project, gram_panchayat from new_application_details where userid='".$_SESSION['uid']."'";
        $result=execute_query($q);
        $apdata=mysqli_fetch_array($result);


        $sql = "INSERT INTO `decleration`(`userid`, `application_no`, `filled_date`, `application_type`, `category`,`aganwadi_center`,`apply_order`, `created`,district_id,project_id,gram_panchyat_id) VALUES ('" . $_SESSION['uid'] . "','" . $appno . "','" . $date . "','" . $type . "','" . $category . "','" .$center. "','$count','".$dtime."','".$apdata['district']."','".$apdata['project']."','".$apdata['gram_panchayat']."')";
        //echo $sql; die;
        $res = execute_query($sql);
        if ($res) {
            $_SESSION['success'] = "Your form is submitted succussfully !";
            header('Location: dashboard.php');
        } else {
            echo 'Some thing went wrong';
        }
    }
    else{
        echo "Can not apply";
    }
}

function createapp_number(){
    $sql = "SELECT district,project,nay_panchayat from new_application_details where userid='" . $_SESSION['uid'] . "'";
    $res = execute_query($sql);
    $row = mysqli_fetch_array($res);
    $dist = strtoupper($row['district']);
    $project = strtoupper($row['project']);
    $id = $_SESSION['uid'];
    //print_r($row); die;
   $pad='AWW';
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
