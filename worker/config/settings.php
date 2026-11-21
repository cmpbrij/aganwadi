<?php

	//include('db_config.php');
	session_start();
	function topheader(){
?>
		<!doctype html>
		<!-- <html lang="{{str_replace('_', '-', app()->getLocale())}}"> -->
		<html>
			<head>
			<title>Application Form : Anganwadi Helper Recruitment 2025, Lucknow, India</title>
				<meta charset="utf-8">
			
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<meta name="viewport" content="width=device-width, initial-scale=1">
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<meta name="csrf-token" content="O9mUTOIwJ98dHE8ncyPuGeXHGQNe6Ctjpf9lCdBX" />
				<link rel="shortcut icon" href="../public/images/favicon.png" />
				<link href="../public/css/bootstrap.css" rel='stylesheet' />
				<link href="../public/css/all.css" rel="stylesheet" />
				<link href="../public/css/custom_theme_student.css" rel="stylesheet" />
				<link href="../public/css/responsive.css" rel="stylesheet" />
				<link href="../public/css/select2.min.css" rel="stylesheet" />
				<script type="text/javascript" src="../public/js/jquery-min.js"></script>
				<!-- <link href="../public/css/js_latest_toastr.min.css" rel="stylesheet" /> -->
				<link href="../public/css/dataTables.bootstrap5.min.css" rel='stylesheet' />
				<link href="../public/css/draggle.css" rel="stylesheet">
				<link rel="stylesheet" href="../public/css/multilevel-form.css">
				<script src="../public/bootstrap.bundle.min.js"></script>
				<script src="../public/js/custom.js"></script>
				<script src="../public/js/js_latest_toastr.min.js"></script>
			</head>
			<style>
			.loader {
				width: 48px;
				height: 48px;
				border: 2px solid #128cbc;
				border-radius: 50%;
				display: inline-block;
				position: absolute;
				box-sizing: border-box;
				animation: rotation 1s linear infinite;
				z-index: 9999999999;
				top: 50%;
				left: 50%;
				transform: translate(-50%)
			}

			.loader::after,
			.loader::before {
				content: '';
				box-sizing: border-box;
				position: absolute;
				left: 0;
				top: 0;
				background: #FF3D00;
				width: 6px;
				height: 6px;
				transform: translate(150%, 150%);
				border-radius: 50%;
			}

			.loader::before {
				left: auto;
				top: auto;
				right: 0;
				bottom: 0;
				transform: translate(-150%, -150%);
			}

			@keyframes rotation {
				0% {
					transform: rotate(0deg);
				}

				100% {
					transform: rotate(360deg);
				}
			}

			.screen {
				position: fixed;
				top: 0;
				left: 0;
				right: 0;
				bottom: 0;
				display: flex;
				align-items: center;
				backdrop-filter: blur(1.5px);
				z-index: 99999;
			}

			a.not-allowed {
				cursor: not-allowed !important;
				pointer-events: none;
			}
			.active-tab {
				background: #ffdebb;
				border-bottom: 1px solid #ef8937;
			}
		</style>
		<body class="dashbg">
		<?php
		}
		function footer(){
		?>
		 <footer>
            <div class="row">
                <div class="col-md-9">
                    <ul class="foot-list">
                        <li>Copyright © ICDS | Developed by CMP Techsseract LLP | Powered by UPDESCO Technical Helpline : 18001375678</li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <ul class="foot-list">
                        <!-- <li>Powered by <a href="#" target="_blank"></a></li> -->
                    </ul>
                </div>
            </div>
        </footer>
	<?php }
	function footerlinks(){ 
	?>
		</div>
		
		</body>
	</html>

	<?php } 
	function errorMsg($msg){
		echo'<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
			  <div class="toast-header">
			    <img src="..." class="rounded me-2" alt="...">
			    <strong class="me-auto">'.$msg.'</strong>
			    <small>11 mins ago</small>
			    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
			  </div>
			  <div class="toast-body">
			    Hello, world! This is a toast message.
			  </div>
			</div>';

	}

	function successMsg($msg){
		echo'<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
			  <div class="toast-header">
			    <img src="..." class="rounded me-2" alt="...">
			    <strong class="me-auto">'.$msg.'</strong>
			    <small>11 mins ago</small>
			    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
			  </div>
			  <div class="toast-body">
			    Hello, world! This is a toast message.
			  </div>
			</div>';

	}

	function getdistNamehindi($id){
		$sql="SELECT district FROM `admin_users` WHERE district_id='".$id."'";
		$res=execute_query($sql);
		$row=mysqli_fetch_array($res);
		if(mysqli_num_rows($res) > 0)
			return $row['district'];
		else
		return '';
	}

	function getawwCode($id){
		$sql="SELECT unique_code FROM `new_vacancy` WHERE id='".$id."'";
		$res=execute_query($sql);
		$row=mysqli_fetch_array($res);
	if(mysqli_num_rows($res) > 0)
		return $row['unique_code'];
	else
	return '';
	}


	function getallDist(){
		$sql = "SELECT * FROM district_master";
		//echo $sql;
    	$result = execute_query($sql);
    	if($result){
    		
    		return $result;
    	}
    	else{
    		return 0;
    	}
    	
	}

	function checkLogin(){
		if($_SESSION['uid'] && $_SESSION['mobile']){
			return true;
		}
		else{
			return false;
		}
	}

	function getCategoryText($selectedValue){
        if ($selectedValue == '1') {
            return 'सामान्य (अनारक्षित)';
        } elseif ($selectedValue == '2') {
            return 'अन्य पिछड़ा वर्ग';
        } elseif ($selectedValue == "3") {
            return 'अनुसूचित जाति';
        } elseif ($selectedValue == "4") {
            return 'अनुसूचित जनजाति';
        } elseif ($selectedValue == "5") {
            return 'आर्थिक रूप से कमजोर वर्ग(EWS)';
        }

}

function getcolocated($selectedValues){
    if ($selectedValues) {
        if ($selectedValues == "1") {
            return 'शहरी';
        } elseif ($selectedValues == "2") {
            return 'ग्रामीण';
        }
    }
}

function getPrename($id){
    if ($id) {
        if ($id == "1") {
            return 'श्रीमती';
        } elseif ($id == "2") {
            return 'कुमारी';
        }
    }
}

function padName($id){
	if($id=='1'){
		return 'आंगनवाड़ी कार्यकत्री';
	}
	else{
		return 'सहायिका';
	}
}

function marriedStatus($id){
	if($id=='1'){
		return 'विवाहित';
	}
	else {
		return 'अविवाहित';
	}
	
}

function typeofMark($id){
	if($id=='1'){
		return 'ग्रेड';
	}
	else {
		return 'श्रेणी';
	}
	
}

function getCurrentsituation($id){
	if($id=='1'){
		return 'विधवा';
	}
	else if($id=='2'){
		return 'तलाकशुदा/परित्यकता';
	}
	else{
		return 'अन्य';
	}
}

function getSubcategory($id){
	if($id=='1'){
		return 'दिव्यांगता';
	}
	else if($id=='2'){
		return 'स्वतन्त्रता संग्राम सेनानी के आश्रित';
	}
	else if($id=='3'){
		return 'स्पोर्ट्स-वूमेंस';
	}
	else{
		return 'N/A';
	}
}



function getProjectname($id){
	$sql="SELECT project_name FROM `projects` WHERE id='".$id."'";
	$res=execute_query($sql);
	$row=mysqli_fetch_array($res);
	if(mysqli_num_rows($res) > 0)
	return $row['project_name'];
 	 else
  	return '';
	
}


function getBlockName($id){
	$sql="SELECT block_name FROM `block_master` WHERE id='".$id."'";
	$res=execute_query($sql);
	$row=mysqli_fetch_array($res);
	if(mysqli_num_rows($res) > 0)
	return $row['block_name'];
 	 else
  	return '';
	
}

// function getProjectnameDist($did,$pid){
// 	$sql="SELECT project_name FROM `projects` WHERE id='".$id."'";
// 	$res=execute_query($sql);
// 	$row=mysqli_fetch_array($res);
// 	if(mysqli_num_rows($res) > 0)
// 	return $row['project_name'];
//  	 else
//   	return '';
	
// }

function getGrampanchayatName($id){
	$sql="SELECT gram_panchayat_name FROM `gram_panchayat` WHERE id='".$id."'";
	$res=execute_query($sql);
	$row=mysqli_fetch_array($res);
	if(mysqli_num_rows($res) > 0)
	  return $row['gram_panchayat_name'];
 	 else
  	return '';
	//return $row['gram_panchayat_name'];
}

function getcenterName($id){
	$sql="SELECT awc_name FROM `new_vacancy` WHERE id='".$id."'";
	$res=execute_query($sql);
	$row=mysqli_fetch_array($res);
  	if(mysqli_num_rows($res) > 0)
	  return $row['awc_name'];
 	 else
  	return '';
}

function getdistName($id){
	$sql="SELECT district_name, id FROM `districts` WHERE id='".$id."'";
	$res=execute_query($sql);
	$row=mysqli_fetch_array($res);
  if(mysqli_num_rows($res) > 0)
	  return $row['district_name'];
  else
  return '';
}
function getawwCenter($id){
	$sql="SELECT awc_name FROM `new_vacancy` WHERE id='".$id."'";
	$res=execute_query($sql);
	$row=mysqli_fetch_array($res);
  if(mysqli_num_rows($res) > 0)
	  return $row['awc_name'];
  else
  return '';
}




?>