<?php
include('../config/db_config.php');
setcookie("PHPSESSID", "qhr4j17m53ir2ev8fqo3sv5a4a", time()+1800, "/", "demo.techsseract.com", true, true);
// Start the session with desired session settings
session_start([
    'cookie_lifetime' => 0,  // Adjust as needed
    'cookie_secure' => true, // Ensure cookies are only sent over HTTPS
    'cookie_httponly' => true, // Ensure cookies are only accessible via HTTP
    // Other session configuration options
]);
function page_header_start($title){
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
  <?php 
    header("X-XSS-Protection: 1; mode=block");
    header("X-Content-Type-Options: nosniff");
    header("X-Frame-Options: SAMEORIGIN");

  ?>

    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Dashboard | ICDS | AWW Recruitment</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <link rel="stylesheet" href="vendors/datatables.net-bs4/dataTables.bootstrap4.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="css/vertical-layout-light/style.css">

    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.ico" />
    <script type="text/javascript" src="../public/css/alert/sweet-alert.min.js"></script>
  <link href="../public/css/alert/sweet-alert.css" rel="stylesheet" />
  <link href="../public/css/alert/sweet-alert.min.css" rel="stylesheet" />

    <?php	
}

function page_header_end(){
?>
</head>

<body>
    <style>
    .sidebar .nav .nav-item.active>.nav-link i,
    .sidebar .nav .nav-item.active>.nav-link .menu-title,
    .sidebar .nav .nav-item.active>.nav-link .menu-arrow {
        color: white !important;
    }

    .sidebar .nav .nav-item.active>.nav-link {
        color: white !important;
        background: orangered 50% !important;
        border-radius: 5px;
        transition: all 0.3s;
    }

    .sidebar {
        display: flex;
        flex-direction: column;
        position: relative;
        background: radial-gradient(circle at 10% 20%, rgb(255, 229, 168) 10%, rgb(251, 174, 222) 100.7%);
    }

    .sidebar {
        color: white !important;
    }

    .sidebar .nav .nav-item>.nav-link {
        color: black !important;
        background-color: rgb(255, 255, 255, 0.2) !important;
        backdrop-filter: blur(2px);

        padding: 15px;
        transition: all 0.3s;
    }

    .sidebar .nav .nav-item>.nav-link:hover {

        background-color: orange !important;
        color: white !important;

    }



    .sidebar .nav .nav-item.active>.nav-link:hover {
        box-shadow: 0px 0px 10px rgb(231, 231, 231);
        background: rgb(192, 51, 0) !important;
    }

    .navbar .navbar-menu-wrapper {
        /* width: 80%;
        margin-left: 20% !important; */
        width: 100%;
        background: radial-gradient(circle at 10% 20%, rgb(255, 229, 168) 10%, rgb(251, 174, 222) 100.7%);
        border-bottom: 0px;
    }

    .content-wrapper {
        background: rgba(255, 165, 0, 0.1);
    }



    .sidebarLogo {
        height: 20vh;

    }

    .navbar-brand {
        display: flex !important;
        align-items: center;
        justify-content: center;

    }

    .sidebar-icon-only img {
        height: 5vh !important;
        margin-left: 15% !important;
    }

    .mdi-sort-variant::before {
        color: white !important;
    }

    @media only screen and (max-width:900px) {
        .sidebar {
            position: fixed;

        }

        .sidebarLogo {
            height: 10vh;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 5%;
        }

        .navbar .navbar-menu-wrapper {
            width: 100%;
            margin-left: 0% !important;
        }
    }
    </style>
    <?php
}
function sidebar(){
	?>
    <!-- partial:partials/_sidebar.html -->
    <nav class="sidebar sidebar-offcanvas " id="sidebar">
        <a class="navbar-brand brand-logo" href="">
            <!-- <img style="height:20vh !important;"
                            src="images/logo.svg" alt="logo" /> -->
            <img class="sidebarLogo" src="../assets/img/icds.png" alt="logo"/>
        </a>
        <ul class="nav">
           
        <li class="nav-item">
            <a class="nav-link" href="admin_dashboard.php">
              <i class="mdi mdi-home menu-icon"></i>
              <span class="menu-title">Dashboard</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="districtvacancies.php">
            <i class="fa fa-envelope menu-icon" aria-hidden="true"></i>
              <span class="menu-title">District Vacancies</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="activedistrictvacancy.php">
            <i class="fa fa-certificate menu-icon" aria-hidden="true"></i>
              <span class="menu-title">Active Vacancies</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="admindistrictwiseapplication.php">
            <i class="fa fa-snowflake-o menu-icon" aria-hidden="true"></i>
              <span class="menu-title">Received Application</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="dist-opened-broadsheet.php">
            <i class="fa fa-folder-open menu-icon" aria-hidden="true"></i> 
              <span class="menu-title"> Dist Opened Broadsheet</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="dpo_login_details.php">
            <i class="fa fa-tasks menu-icon" aria-hidden="true"></i>
              <span class="menu-title">DPO Login Details</span>
            </a>
          </li>

        </ul>
    </nav>
    <?php
}
function navigation(){
?>
    <div class="container-scroller">

        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">


            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-center">

                <ul class="navbar-nav mr-lg-4 w-100">
                    <li class="nav-item nav-search d-none d-lg-block w-100">
                        <button class="navbar-toggler navbar-toggler align-self-center" type="button"
                            data-toggle="minimize">
                            <span class="mdi mdi-sort-variant"></span>
                        </button>
                    </li>
                </ul>
                <ul class="navbar-nav navbar-nav-right">
                    <!--<li class="nav-item dropdown me-1">
		   <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-bs-toggle="dropdown">
			 <i class="mdi mdi-message-text mx-0"></i>
			 <span class="count"></span>
		   </a>
		   <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
			 <p class="mb-0 font-weight-normal float-left dropdown-header">Messages</p>
			 <a class="dropdown-item preview-item">
			   <div class="preview-thumbnail">
				   <img src="../../images/faces/face4.jpg" alt="image" class="profile-pic">
			   </div>
			   <div class="preview-item-content flex-grow">
				 <h6 class="preview-subject ellipsis font-weight-normal">David Grey
				 </h6>
				 <p class="font-weight-light small-text text-muted mb-0">
				   The meeting is cancelled
				 </p>
			   </div>
			 </a>
			 <a class="dropdown-item preview-item">
			   <div class="preview-thumbnail">
				   <img src="../../images/faces/face2.jpg" alt="image" class="profile-pic">
			   </div>
			   <div class="preview-item-content flex-grow">
				 <h6 class="preview-subject ellipsis font-weight-normal">Tim Cook
				 </h6>
				 <p class="font-weight-light small-text text-muted mb-0">
				   New product launch
				 </p>
			   </div>
			 </a>
			 <a class="dropdown-item preview-item">
			   <div class="preview-thumbnail">
				   <img src="../../images/faces/face3.jpg" alt="image" class="profile-pic">
			   </div>
			   <div class="preview-item-content flex-grow">
				 <h6 class="preview-subject ellipsis font-weight-normal"> Johnson
				 </h6>
				 <p class="font-weight-light small-text text-muted mb-0">
				   Upcoming board meeting
				 </p>
			   </div>
			 </a>
		   </div>
		 </li>-->
                    <li class="nav-item dropdown me-4">
                        <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center notification-dropdown"
                            id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                            <i class="mdi mdi-bell mx-0"></i>
                            <span class="count"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                            aria-labelledby="notificationDropdown">
                            <!-- <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p> -->
                            
                           
                            <!--<a class="dropdown-item preview-item">
			   <div class="preview-thumbnail">
				 <div class="preview-icon bg-info">
				   <i class="mdi mdi-account-box mx-0"></i>
				 </div>
			   </div>
			   <div class="preview-item-content">
				 <h6 class="preview-subject font-weight-normal">New user registration</h6>
				 <p class="font-weight-light small-text mb-0 text-muted">
				   2 days ago
				 </p>
			   </div>
			 </a>-->
                        </div>
                    </li>
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
                            <img src="../assets/img/icds.png" alt="profile" />
                            <span class="nav-profile-name"><?php echo $_SESSION['role']; ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown"
                            aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="admin_change_pass.php">
                                <i class="mdi mdi-settings text-primary"></i>
                               Change Password
                            </a>
                            <a href="logout.php" class="dropdown-item">
                                <i class="mdi mdi-logout text-primary"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                    <!-- <li class="nav-item nav-settings d-none d-lg-flex">
                        <a class="nav-link" href="#">
                            <i class="mdi mdi-apps"></i>
                        </a>
                    </li> -->
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button>
            </div>
        </nav>

        <?php
}

function page_footer(){
?>
        <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2024 <a
                        href="#" target="_blank">Techsseract</a>. All rights reserved.</span>
            </div>
        </footer>
        <!-- partial -->
    </div>
    <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <script>

    </script>
     <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <script src="vendors/chart.js/Chart.min.js"></script>
    <script src="vendors/datatables.net/jquery.dataTables.js"></script>
    <script src="vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script>
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/template.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="js/dashboard.js"></script>
    <!-- End custom js for this page-->
    <script src="js/jquery.cookie.js" type="text/javascript"></script>

    <script src="js/data-table.js"></script>
    <script src="vendors/jquery-validation/jquery.validate.min.js"></script>
</body>

</html>


<?php
}


function checkLogin(){
		if(isset($_SESSION['uid'])){
			return true;
		}
		else{
			return false;
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

function getGrampanchayatName($id){
	$sql="SELECT gram_panchayat_name FROM `gram_panchayat` WHERE id='".$id."'";
	$res=execute_query($sql);
	$row=mysqli_fetch_array($res);
  if(mysqli_num_rows($res) > 0)
  return $row['gram_panchayat_name'];
  else
  return '';
	
}

function getcenterName($id){
	$sql="SELECT awc_name FROM `aaganwadi_center` WHERE id='".$id."'";
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
  else{
    return '';
  }

}

function getSubcategoryText($id){
	if ($id== '1') {
		return 'दिव्यांगता';
	} 
  else if($id=='2'){
    return  'स्वतन्त्रता संग्राम सेनानी के आश्रित';
  }
  else{
    return '';
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
	return 'तलाकशुदा/तलाकशुदा';
}

else{
  return 'अन्य';
}
}

function getPBL($id){
	if($id=='1'){
		return 'YES';

	}
	else{
		return 'NO';
	}
}

function subcategoryEnable(){
  $sql="select * from setting where district_id='".$_SESSION['distid']."'";
  $res=execute_query($sql);
  $row=mysqli_fetch_assoc($res);
  if($row['sub_category_hadnicap'] == 1 && $row['sub_category_ff']==1){
    return 1;
  }
  else{
    return 0;
  }
}

function districtVacancy_Count($id){
  $sql="SELECT COUNT(unique_code) as count from new_vacancy where district_id='".$id."'  AND vacancy_available='Yes' group by district_id;";
  $res=execute_query($sql);
  $row=mysqli_fetch_array($res);
  return $row['count'];

}
?>