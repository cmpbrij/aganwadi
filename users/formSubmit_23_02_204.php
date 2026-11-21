<?php
	 include('../config/settings.php');
	// if(isset($_POST['save1'])){
	// 	$sql = "INSERT INTO `application_details`(`name`, `name_hindi`, `father`, `father_hindi`, `mother`, `mother_hindi`, `dob`, `gender`, `category`, `state`, `dist`, `tahsil`, `full_address`, `created`, `updated`) VALUES ('".$_POST['name']."','".$_POST['name_hi']."','".$_POST['father_name']."','".$_POST['father_name_hi']."','".$_POST['mother_name']."','".$_POST['mother_name_hi']."','".$_POST['dob']."','".$_POST['gender']."','".$_POST['category']."','".$_POST['state']."','".$_POST['dist']."','".$_POST['tahsil']."','".$_POST['full_address']."','','')";
		
	// 		$stmt = $conn -> query($sql);
           
 //            if ($stmt) {
 //            	$msg="Data saved successfully!";
 //            	header('Location: upload_document.php');
         
              
 //            }
            
	// }


	 //$sql="INSERT INTO `users_application_details`(`dist_name`, `block_name`, `post_name`, `center_code`, `center_name`, `urban_rural`, `ward_name`, `ward_number`, `applicant_name`, `applicant_position`, `husband_name`, `father_name`, `mother_name`, `mobile`, `category`, `subcategory`, `married_status`, `m_serial_no`, `married_date`, `certificate_issued_by`, `certificate_serial`, `certificate_date`, `percentage`, `ff_certificate`, `ff_serial`, `ff_date`, `working_select`, `working_date`, `working_center`, `working_ward`, `p_house_no`, `p_village`, `p_post`, `p_dist`, `niwash_officer`, `niwash_serial`, `niwash_date`,`cc_issued`, `cc_serial`, `cc_date`, `is_bpl`, `income_certificate_issued`, `income_certificate_serial`, `income_certificate_date`, `income_yearly`, `dob`, `income_word`, `aadhar_no`, `created`) VALUES ('".$_POST['dist_name']."','".$_POST['block_name']."','".$_POST['post_name']."','".$_POST['center_code']."','".$_POST['center_name']."','".$_POST['urban_rural']."','".$_POST['ward_name']."','".$_POST['ward_number']."','".$_POST['applicant_name']."','".$_POST['applicant_position']."','".$_POST['husband_name']."','".$_POST['father_name']."','".$_POST['mother_name']."','".$_POST['mobile']."','".$_POST['category']."','".$_POST['subcategory']."','".$_POST['married_status']."','".$_POST['m_serial_no']."','".$_POST['married_date']."','".$_POST['certificate_issued_by']."','".$_POST['certificate_serial']."','".$_POST['certificate_date']."','".$_POST['percentage']."','".$_POST['ff_certificate']."','".$_POST['ff_serial']."','".$_POST['ff_date']."','".$_POST['working_select']."','".$_POST['working_date']."','".$_POST['working_center']."','".$_POST['working_ward']."','".$_POST['p_house_no']."','".$_POST['p_village']."','".$_POST['p_post']."','".$_POST['p_dist']."','".$_POST['niwash_officer']."','".$_POST['niwash_serial']."','".$_POST['niwash_date']."','".$_POST['cc_issued']."','".$_POST['cc_serial']."','".$_POST['cc_date']."','".$_POST['is_bpl']."','".$_POST['income_certificate_issued']."','".$_POST['income_certificate_serial']."','".$_POST['income_certificate_date']."','".$_POST['income_yearly']."','".$_POST['dob']."','".$_POST['income_word']."','".$_POST['aadhar_no']."','".$date."')";
	    //$stmt = $conn -> query($sql);
	if(isset($_POST['save1'])){
		$date=date("Y-m-d H:i:s");
		$uid=$_SESSION['uid'];
		//if(!isset($_SESSION['personal_details-1'])){
				$district = mysqli_real_escape_string($conn, $_POST['district_name']);
				$tehseel = mysqli_real_escape_string($conn, $_POST['tehsil']);
				$vikas_khand = mysqli_real_escape_string($conn, $_POST['project']);
				$grameen_sehri = mysqli_real_escape_string($conn, $_POST['urban_rural']);
				$gram_panchayat = mysqli_real_escape_string($conn, $_POST['gram_panchayat']);
				$ward_name = mysqli_real_escape_string($conn, $_POST['ward']);
				$nay_panchayat = mysqli_real_escape_string($conn, $_POST['nya_panchyat']);
				$rikt_pd = mysqli_real_escape_string($conn, $_POST['rikt_pd']);
				$rikt_aww_center = mysqli_real_escape_string($conn, $_POST['rikt_aww_center']);
				$name_hi = mysqli_real_escape_string($conn, $_POST['applicant_name']);
				$name_en = mysqli_real_escape_string($conn, $_POST['applicant_name_en']);
				//$isthiti = mysqli_real_escape_string($conn, $_POST['married_status']);
				$fname = mysqli_real_escape_string($conn, $_POST['father_name']);
				$mname = mysqli_real_escape_string($conn, $_POST['mother_name']);
				$hname = mysqli_real_escape_string($conn, $_POST['husband_name']);
				$mobile = mysqli_real_escape_string($conn, $_POST['mobile']);
				//$category = mysqli_real_escape_string($conn, $_POST['category']);
				//$sub_category = mysqli_real_escape_string($conn, $_POST['subcategory']);
				$dob = mysqli_real_escape_string($conn, $_POST['dob']);
				$age = mysqli_real_escape_string($conn, $_POST['age']);
				$prename=mysqli_real_escape_string($conn, $_POST['pre_name']);
			
			
				$sql = "INSERT INTO `new_application_details`(`userid`,`district`, `tehseel`, `vikas_khand`, `grameen_sehri`, `gram_panchayat`, `word_name`, `nay_panchayat`, `rikt_pd`, `rikt_aww_center`, `name_hi`, `name_en`, `fname`, `mname`, `hname`, `mobile`, `date_of_birth`,`age`,`pre_name`) VALUES
				 ('$uid','$district','$tehseel','$vikas_khand','$grameen_sehri','$gram_panchayat','$ward_name','$nay_panchayat','$rikt_pd','$rikt_aww_center',
				 '$name_hi','$name_en','$fname','$mname','$hname','$mobile','$dob','$age','$prename')";
				// echo $sql; die;
				$_SESSION['pad_name']=$rikt_pd;
				$res = mysqli_query($conn, $sql);
			
			   //echo $sql; die;
				$res=mysqli_query($conn, $sql);
				$_SESSION['personal-details-1']=mysqli_insert_id($conn);
				if($res){
					$_SESSION['success']="Data save Successfully!";
					header('Location: personal_details.php');
				}
				else{
					$msg="Occure some error!";
				}
		//}	
		// else{
		// 	header('Location: personal_details.php');
		// }
	    
   }

if(isset($_POST['save2'])){
	// header('Location: address_details.php');
	// exit();
	$_SESSION['mobile']='9838668867';
	$date=date("Y-m-d H:i:s");
		// if(isset($_SESSION['personal-details-2'])){
			
		// 	header('Location: address_details.php');
		// }
		// else{
			
			$category = mysqli_real_escape_string($conn, $_POST['category']);
			$sub_category = mysqli_real_escape_string($conn, $_POST['sub_category']);
			$divangta_avedan_krmank = mysqli_real_escape_string($conn, $_POST['divangta_avedan_krmank']);
			$divangta_pramnpatr_kramank = mysqli_real_escape_string($conn, $_POST['divangta_pramnpatr_kramank']);
			$percentage = mysqli_real_escape_string($conn, $_POST['percentage']);
			$f_senani_sambandh = mysqli_real_escape_string($conn, $_POST['f_senani_sambandh']);
			$f_senani_prmanptr = mysqli_real_escape_string($conn, $_POST['f_senani_prmanptr']);
			$avedika_status = mysqli_real_escape_string($conn, $_POST['avedika_status']);
			$vidhwa_certificateno = mysqli_real_escape_string($conn, $_POST['vidhwa_certificateno']);
			$v_jarikrta_name = mysqli_real_escape_string($conn, $_POST['v_jarikrta_name']);
			$v_uploaddata = mysqli_real_escape_string($conn, $_POST['v_uploaddata']);
			$nivas_prmaanpatr_no = mysqli_real_escape_string($conn, $_POST['nivas_prmaanpatr_no']);
			$nivas_avedan_prmanpatr = mysqli_real_escape_string($conn, $_POST['nivas_avedan_prmanpatr']);
			$nivas_upload = mysqli_real_escape_string($conn, $_POST['nivas_upload']);
			$jaant_prmaanpatr_no = mysqli_real_escape_string($conn, $_POST['jaant_prmaanpatr_no']);
			$jaati_avedan_prmanpatr = mysqli_real_escape_string($conn, $_POST['jaati_avedan_prmanpatr']);
			$jaati_upload = mysqli_real_escape_string($conn, $_POST['jaati_upload']);
			$aay_prmaanpatr_no = mysqli_real_escape_string($conn, $_POST['aay_prmaanpatr_no']);
			$aay_avedan_prmanpatr = mysqli_real_escape_string($conn, $_POST['aay_avedan_prmanpatr']);
			$aay_upload = mysqli_real_escape_string($conn, $_POST['aay_upload']);
			$bpl_card = mysqli_real_escape_string($conn, $_POST['bpl_card']);
			$pre_name = mysqli_real_escape_string($conn, $_POST['pre_name']);
			$uid=$_SESSION['uid'];
		
		
			$sql = "INSERT INTO `personal_details`(`userid`,`category`, `sub_category`, `divangta_avedan_krmank`, `divangta_pramnpatr_kramank`, 
			`percentage`, `f_senani_sambandh`, `f_senani_prmanptr`, `avedika_status`, `vidhwa_certificateno`, 
			`v_jarikrta_name`, `v_uploaddata`, `nivas_prmaanpatr_no`, `nivas_avedan_prmanpatr`, `nivas_upload`, `jaant_prmaanpatr_no`,
			 `jaati_avedan_prmanpatr`, `jaati_upload`, `aay_prmaanpatr_no`, `aay_avedan_prmanpatr`, `aay_upload`, `bpl_card`)
			 VALUES 
			 ('$uid','$category','$sub_category','$divangta_avedan_krmank','$divangta_pramnpatr_kramank','$percentage','$f_senani_sambandh','$f_senani_prmanptr',
			 '$avedika_status', '$vidhwa_certificateno','$v_jarikrta_name','$v_uploaddata','$nivas_prmaanpatr_no','$nivas_avedan_prmanpatr','$nivas_upload',
			 '$jaant_prmaanpatr_no','$jaati_avedan_prmanpatr','$jaati_upload','$aay_prmaanpatr_no','$aay_avedan_prmanpatr','$aay_upload','$bpl_card')";

			// echo $sql; die;
		
			// $sql1="INSERT INTO `personal_details_2`(`userid`, `mobile`, `form1_id`, `current_situation`, `current_situation_attachment`, `handicap_cerno`, `handicap_perc`, `ff_document`, `address_cerno`, `cast_cerno`, `income_cerno`, `is_bpl`, `aadhar_no`, `created`) VALUES ('".$_SESSION['uid']."','".$_SESSION['mobile']."','".$_SESSION['personal-details-1']."','".$_POST['current_situation']."','','".$_POST['handicap_cerno']."','".$_POST['handicap_perc']."','".$_POST['ff_document']."','".$_POST['address_cerno']."','".$_POST['cast_cerno']."','".$_POST['income_cerno']."','".$_POST['is_bpl']."','".$_POST['aadhar_no']."','".date('Y-d-m H:i:s')."')";
			//echo $sql1; die;
			$stmt = $conn -> query($sql);
			if($stmt){
			  $msg="Data save Successfully!";
			  $_SESSION['success']= $msg;
			  $_SESSION['academicid']=mysqli_insert_id($conn);
			  header('Location: academic_details.php');
			// }
			// else{
			//   $msg="Occure some error!";
			//   echo $msg;
			// }
		}
		
		
		//echo $sql; 

	    // $sql="INSERT INTO `academic_details`(`userid`, `first_step_status`, `h_school`, `h_board`, `h_year`, `h_maxmarks`, `h_englishmarks`, `h_typeofmarks`, `h_totalmarks`, `i_school`, `i_board`, `i_year`, `i_maxmarks`, `i_englishmarks`, `i_typeofmarks`, `i_totalmarks`, `g_school`, `g_board`, `g_year`, `g_macmarks`, `g_typeofmarks`, `g_totalmarks`, `apply_date`, `created`) VALUES ('','','".$_POST['h_school']."','".$_POST['h_board']."','".$_POST['h_year']."','".$_POST['h_year']."','".$_POST['h_maxMarks']."','".$_POST['h_englishMarks']."','".$_POST['h_typeofMarks']."','".$_POST['h_totalMarks']."','".$_POST['i_school']."','".$_POST['i_board']."','".$_POST['i_year']."','".$_POST['i_maxMarks']."','".$_POST['i_englishMarks']."','".$_POST['i_typeofMarks']."','".$_POST['i_totalMarks']."','".$_POST['g_school']."','".$_POST['g_year']."','".$_POST['g_maxMarks']."','".$_POST['g_typeofMarks']."','".$_POST['g_totalMarks']."','".date('Y-m-d')."','".date('Y-m-d H:i:s')."')";

	 //  echo $sql;

	   // die;
	    
  
   }
   
if(isset($_POST['addressSubmit'])){
	if(isset($_SESSION['addressformid'])){
		header('Location: academic_details.php');
	}
	else{
		$sql="INSERT INTO `address_details`(`userid`, `mobile`, `form2`, `district`, `tahsil`, `project`, `post`, `urban_rural`, `ward_no`, `grampanchyat`, `house_no`, `village`, `vacant_aaganwadi_name`, `created`) VALUES ('".$_SESSION['uid']."','".$_SESSION['mobile']."','".$_SESSION['personal-details-2']."','".$_POST['district']."','".$_POST['tahsil']."','".$_POST['project']."','".$_POST['post']."','".$_POST['urban_rural']."','".$_POST['ward_no']."','".$_POST['grampanchyat']."','".$_POST['house_no']."','".$_POST['village']."','".$_POST['vacant_aaganwadi_name']."','".date('Y-m-d H:i:s')."')";
		//echo $sql; die;
		$stmt = $conn -> query($sql);
		if($stmt){
			$msg="Data save Successfully!";
			$_SESSION['success']= $msg;
			$_SESSION['addressformid']=mysqli_insert_id($conn);
			header('Location: academic_details.php');
		}
		else{
			$msg="Occure some error!";
			echo $msg;
		}
	}
	
}

if(isset($_POST['academicSubmit'])){
	$sql="INSERT INTO `academic_details`(`userid`, `mobile`, `addressformid`, `h_school`, `h_board`, `h_year`, `h_maxmarks`, `h_typeofmarks`, `h_totalmarks`, `h_marksheetdoc`, `h_otherdoc`, `i_school`, `i_board`, `i_year`, `i_maxmarks`, `i_typeofmarks`, `i_marksheetdoc`, `i_otherdoc`,`i_totalmarks`, `g_school`, `g_board`, `g_year`, `g_maxmarks`, `g_typeofmarks`, `g_totalmarks`, `g_marksheetdoc`, `g_otherdoc`,  `pg_school`, `pg_board`, `pg_year`, `pg_maxmarks`, `pg_typeofmarks`, `pg_totalmarks`, `pg_marksheetdoc`, `pg_otherdoc`,`created`) VALUES ('".$_SESSION['uid']."','".$_SESSION['mobile']."','".$_SESSION['addressformid']."','".$_POST['h_school']."','".$_POST['h_board']."','".$_POST['h_year']."','".$_POST['h_maxmarks']."','".$_POST['h_typeofmarks']."','".$_POST['h_totalmarks']."',' ',' ','".$_POST['i_school']."','".$_POST['i_board']."','".$_POST['i_year']."','".$_POST['i_maxmarks']."','".$_POST['i_typeofmarks']."','".$_POST['i_totalmarks']."','".$_POST['i_marksheetdoc']."','".$_POST['i_otherdoc']."','".$_POST['g_school']."','".$_POST['g_board']."','".$_POST['g_year']."','".$_POST['g_maxmarks']."','".$_POST['g_typeofmarks']."','".$_POST['g_totalmarks']."','".$_POST['g_marksheetdoc']."','".$_POST['g_otherdoc']."','".$_POST['pg_school']."','".$_POST['pg_board']."','".$_POST['pg_year']."','".$_POST['pg_maxmarks']."','".$_POST['pg_typeofmarks']."','".$_POST['pg_totalmarks']."','".$_POST['pg_marksheetdoc']."','".$_POST['pg_otherdoc']."','".date('Y-d-m H:i:s')."')";
	
	$stmt = $conn -> query($sql);
	//echo $sql; die;
		if($stmt){
			$msg="Data save Successfully!";
			$_SESSION['success']= $msg;
			$_SESSION['academicid']=mysqli_insert_id($conn);
			header('Location: upload_document.php');
		}
		else{
			$msg="Occure some error!";
			echo $msg;
		}
}

if(isset($_POST['uploadPhoto'])){
	    $date=date("Y-m-d H:i:s");
	    		//file upload path
				
		$dir='../uploads/';
		$newdir=$_SESSION['uid'];
		$check=$dir.'/'.$newdir;
		if (!file_exists ($check)){
            mkdir('../uploads/'.$newdir,0777,true);  
        }
		$targetDir = "../uploads/".$newdir."/";

		//echo $newdir; die;
		//Photo Upload
		$fileName = basename($_FILES["photo_graph"]["name"]); 
		$fileName1 = basename($_FILES["signature"]["name"]);

		//echo $fileName; die;
		$randName = 'photo'.time();
		$randName1 = 'signature'.time();

		//echo $targetFilePath; die;
		$fileType = pathinfo($fileName,PATHINFO_EXTENSION);
		$fileType1 = pathinfo($fileName1,PATHINFO_EXTENSION);

		//echo $fileName; die;
		$targetFilePath = $targetDir . $randName .'.'.$fileType;
		$targetFilePath1 = $targetDir . $randName1 .'.'.$fileType;;
		
		$filesavephoto=$targetDir. $randName.'.'.$fileType;
		$filesavephoto1=$targetDir . $randName1.'.'.$fileType;

		//allow certain file formats
		    $allowTypes = array('jpg','png','jpeg','gif');
		    if(in_array($fileType, $allowTypes)){
		        //upload file to server
		        if(move_uploaded_file($_FILES["photo_graph"]["tmp_name"], $targetFilePath) ){
		           // $statusMsg = "The file ".$fileName. " has been uploaded.";
		            $sql="INSERT INTO `uploaded_documents`(`userid`, `academicid`, `applicationid`, `photo`,`signature`,  `date`, `created`) VALUES ('".$_SESSION['uid']."','".$_SESSION['academicid']."',' ','".$filesavephoto."','".$filesavephoto1."','".date('y-m-d')."','".date('Y-m-d H:i:s')."')";
		            
		             $stmt = $conn -> query($sql);
					 $msg="Photo & signature Uploaded Successfully";
		             $_SESSION['success']=$msg;
					 $_SESSION['photoupdatedid']=mysqli_insert_id($conn);
	     			 header('Location: declearation.php');
		        }else{
		            $statusMsg = "Sorry, there was an error uploading your file.";
		            echo $statusMsg;
		        }
		    }else{
		        $statusMsg = 'Sorry, only JPG, JPEG, PNG, GIF files are allowed to upload.';
		        echo $statusMsg;
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

	if(isset($_POST['declerationSubmit'])){
		$sql="select * from new_application_details where userid='".$_SESSION['uid']."'";
		$res=execute_query($sql);
		$row=mysqli_fetch_array($res);
		$dist=strtoupper($row['district']);
		$project=strtoupper($row['vikas_khand']);
		$id=$_SESSION['uid'];
		//print_r($row);
		$type= $row['rikt_pd'];
		if($type == '1'){
			$pad='AWWUP';
		}
		else if($type == '2'){
			$pad='AWHUP';
		}
		else{
			$pad='MAWWHUP';
		}

		$_SESSION['app_no']=$pad.'/'.$dist.'/'.$project.'/'.str_pad($id, 6, '0', STR_PAD_LEFT);
		$_SESSION['declearation']='yes';
		//echo"test"; die;
		header('Location: preview_form.php');
	}

	if(isset($_GET['user'])){
		if(isset($_SESSION['uid'])){
			$sql="SELECT district,vikas_khand,nay_panchayat, rikt_pd from new_application_details where userid='".$_SESSION['uid']."'";
			$res=execute_query($sql);
			$row=mysqli_fetch_array($res);
			$dist=$row['district'];
			$project=$row['vikas_khand'];
			$category=$row['category'];
			$id=$_SESSION['uid'];
			//print_r($row); die;
			$type= $row['rikt_pd'];

			$appno=createapp_number();
			$date=date('Y-m-d');
			$dtime=date('Y-m-d H:i:s');
			
			$sql="INSERT INTO `decleration`(`userid`, `application_no`, `filled_date`, `application_type`, `category`,`aganwadi_center`,`apply_order`, `created`) VALUES ('".$_SESSION['uid']."','".$appno."','".$date."','".$type."','".$category."','".$row['center']."','1','".$dtime."')";
			//echo $sql; die;
			$res=execute_query($sql);
			if($res){
				$_SESSION['success']="Your form is submitted succussfully !";
				header('Location: dashboard.php');
			}
			else{
				
			}
			
		}
		
	}

	if(isset($_POST['apply_more'])){
		$sql1="select count(userid) as c from decleration";
		$res1=execute_query($sql1);
		$orow=mysqli_fetch_array($res1);
		$count=$orow['c'];
			$id=$_SESSION['uid'];
			//print_r($row); die;
			$type= $_POST['rikt_pd'];
			$center=$_POST['rikt_aww_center'];
			$category=$_POST['category'];

			$appno=createapp_number();
			$date=date('Y-m-d');
			$dtime=date('Y-m-d H:i:s');
			
			$sql="INSERT INTO `decleration`(`userid`, `application_no`, `filled_date`, `application_type`, `category`,`aganwadi_center`,`apply_order`, `created`) VALUES ('".$_SESSION['uid']."','".$appno."','".$date."','".$type."','".$category."','".$row['center']."','$count','".$dtime."')";
			//echo $sql; die;
			$res=execute_query($sql);
			if($res){
				$_SESSION['success']="Your form is submitted succussfully !";
				header('Location: dashboard.php');
			}
			else{
				
			}
	}

	function createapp_number(){
		$sql="SELECT district,vikas_khand,nay_panchayat, rikt_pd from new_application_details where userid='".$_SESSION['uid']."'";
			$res=execute_query($sql);
			$row=mysqli_fetch_array($res);
			$dist=strtoupper($row['district']);
			$project=strtoupper($row['vikas_khand']);
			$id=$_SESSION['uid'];
			//print_r($row); die;
			$type= $row['rikt_pd'];
			if($type == '1'){
				$pad='AWWUP';
			}
			else{
				$pad='AWHUP';
			}

			
		//$appno=$pad.'/'.$dist.'/'.$project.'/'.str_pad($id, 6, '0', STR_PAD_LEFT);
		$sql="SELECT form_number FROM `application_no` WHERE  formtype='".$type."'";
		$res=execute_query($sql);
		$formrow=mysqli_fetch_array($res);
		$formnum=$formrow['form_number'];
		$formnum=str_pad($formnum, 6, '0', STR_PAD_LEFT);
		$next=$formnum + 1;
		$sql1="UPDATE `application_no` SET `form_number` = '".$next."' WHERE formtype='".$type."'";
		execute_query($sql1);

		$appno=$pad.'/'.$dist.'/'.$project.'/'.$formnum;
		return $appno;
	}

?>