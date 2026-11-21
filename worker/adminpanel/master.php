<?php
include('../config/db_config.php');
session_start();
function page_header_start($title){
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>AWW Recruitment UP</title>
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
    
        <link rel="shortcut icon" href="images/favicon.ico" />
        <script type="text/javascript" src="../public/css/alert/sweet-alert.min.js"></script>
    <link href="../public/css/alert/sweet-alert.css" rel="stylesheet" />
    <link href="../public/css/alert/sweet-alert.min.css" rel="stylesheet" />
    <script type="text/javascript" src="../public/js/jquery-min.js"></script>

    <?php	
}

// Start the session


// Set the session timeout duration (e.g., 1800 seconds = 30 minutes)
$timeout_duration = 1800;

// Check if the timeout is set and the session is active
if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY']) > $timeout_duration) {
    // If the session has expired, destroy it and redirect to the login page
    session_unset();     // Unset $_SESSION variable for the run-time
    session_destroy();   // Destroy session data in storage
    header("Location: login.php");
    exit();
}

// Update the last activity time
$_SESSION['LAST_ACTIVITY'] = time();


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
       background: #caa5e2;
        background: linear-gradient(90deg,rgba(131, 58, 180, 1) 0%, rgb(222, 81, 81) 0%, rgb(244, 179, 88) 100%);
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

    a.navlink {}

    .sidebar .nav .nav-item.active>.nav-link:hover {
        box-shadow: 0px 0px 10px rgb(231, 231, 231);
        background: rgb(198, 64, 15) !important;
    }

    .navbar .navbar-menu-wrapper {
        /* width: 80%;
        margin-left: 20% !important; */
        width: 100%;
        background: #833AB4;
        background: linear-gradient(90deg,rgba(131, 58, 180, 1) 0%, rgb(195, 48, 8) 0%, rgb(147, 111, 61) 100%);
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
            <img class="sidebarLogo" src="../assets/img/icds.png" alt="logo" />
        </a>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">
                    <i class="mdi mdi-home menu-icon"></i>
                    <span class="menu-title">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="vacancieslist.php">
                    <i class="mdi mdi-folder menu-icon"></i>

                    <span class="menu-title">Vacancies</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="uploadvacancy.php">
                    <i class="mdi mdi-upload menu-icon"></i>
                    <span class="menu-title">Upload New Advertisement</span>
                </a>
            </li>
          
            <?php
                $sql="select shift,last_date from vacancy_order where dist_id='".$_SESSION['distid']."'";
               
                $res=execute_query($sql);
              
                if(mysqli_num_rows($res) > 0){
                    $row=mysqli_fetch_assoc($res);
                   $lastDateStr = $row['last_date']; // expected YYYY-MM-DD

                    $last = DateTime::createFromFormat('Y-m-d', $lastDateStr);
                    if (!$last) { // fallback if format differs
                        $last = new DateTime($lastDateStr);
                    }

                    $lastPlus7 = (clone $last)->modify('+6 days');
                    $today = new DateTime('today');

                    if ($lastPlus7 <= $today) {
                        $CH=1;
                    }
                    else{
                        $CH=0;
                    }
            
                }
                else{
                    $CH=0;
                }
              
               
                if($CH==1){
            ?>
             <!-- <li class="nav-item">
                <a class="nav-link" href="projectwise-broadsheet.php">
                    <i class="mdi mdi-format-align-bottom menu-icon"></i>
                    <span class="menu-title">Broadsheet-B1</span>
                </a>
            </li>  -->
             <li class="nav-item">
                <a class="nav-link" href="projectwise-broadsheet-api.php">
                    <i class="mdi mdi-checkbox-marked-circle-outline menu-icon"></i>
                    <span class="menu-title">Broadsheet</span>
                </a>
            </li> 
             <li class="nav-item">
                <a class="nav-link" href="dateset.php">
                    <i class="mdi mdi-checkbox-marked-circle-outline menu-icon"></i>
                    <span class="menu-title">Set Letter Date</span>
                </a>
            </li> 
            <li class="nav-item">
                <a class="nav-link" href="uploadbroadsheet.php">
                    <i class="mdi mdi-file menu-icon"></i>
                    <span class="menu-title">Upload Eligible Candidates List</span>
                </a>
            </li> 

            <li class="nav-item">
                <a class="nav-link" href="uploadFinallist.php">
                    <i class="mdi mdi-file menu-icon"></i>
                    <span class="menu-title">Upload Final Candidates List</span>
                </a>
            </li>
              <?php
                }
            ?>

           
            <li class="nav-item">
                <a class="nav-link" href="extend_application_date.php">
                    <i class="mdi mdi-clock menu-icon"></i>
                    <span class="menu-title">Extend Application Date</span>
                </a>
            </li>
            <!-- <li class="nav-item">
                        <a class="nav-link" href="projectslist.php">
                            <i class="mdi  mdi-dna menu-icon"></i>
                            <span class="menu-title">Manage Projects</span>
                        </a>
                    </li> -->

                   
                    <li class="nav-item">
                        <a class="nav-link" href="managenewvacancy.php">
                        <i class="mdi  mdi-decagram-outline menu-icon"></i>
                            <span class="menu-title">Manage Vacancy</span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="viewallvacancy.php">
                        <i class="mdi  mdi-dna menu-icon"></i>
                            <span class="menu-title">View All Vacancy</span>
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
                    <li class="nav-item nav-search d-none d-lg-block w-100 text-center">
                        <h5 style="color:white";>Anganwadi Worker New Recruitment - 2026</h5>
                    </li>

                </ul>
                <ul class="navbar-nav navbar-nav-right">
                     
                    <li class="nav-item dropdown me-4">
                       
                        <?php
                            $sql="SELECT * FROM `admin_users` WHERE id='".$_SESSION['sid']."'";
                            $res=execute_query($sql);
                            $data=mysqli_fetch_array($res);
                            echo' <h6 class="preview-subject">District: '.$data['district'].'</h6>';
                        ?>
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                            aria-labelledby="notificationDropdown">
                            <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-success">
                                        <i class="mdi mdi-information mx-0"></i>
                                    </div>
                                </div>
                               
                            </a>
                            <a class="dropdown-item preview-item">
                                <div class="preview-thumbnail">
                                    <div class="preview-icon bg-warning">
                                        <i class="mdi mdi-settings mx-0"></i>
                                    </div>
                                </div>
                                
                            </a>
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
                            <!-- <a class="dropdown-item" href="/../adminpanel/change_pass.php">
                                <i class="mdi mdi-settings text-primary"></i>
                                Change Password
                            </a> -->
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
                <!-- <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                    data-toggle="offcanvas">
                    <span class="mdi mdi-menu"></span>
                </button> -->
            </div>
        </nav>

        <?php
}

function page_footer(){
?>
        <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © ICDS | Developed by 
                <a href="https://techsseract.com/create/" target="_blank">CMP  Techsseract LLP </a>.| Powered by UPDESCO</span>
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
    <!-- plugins:js -->
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



function checkSession() {
    if (isset($_SESSION['sid'])) {
      
        $userId = $_SESSION['sid'];
        $sessionIdentifier = $_SESSION['session_identifier'];
       // echo $sessionIdentifier.'<br>';
        $sql="SELECT session_identifier FROM admin_users WHERE id ='".$userId."'";
        $res=execute_query($sql);
        $row=mysqli_fetch_assoc($res);
        $dbSessionIdentifier=$row['session_identifier'];
       // echo $dbSessionIdentifier; die;
    
        if ($dbSessionIdentifier !== $sessionIdentifier) {
            session_destroy();
            header("Location: login.php");
            exit;
        }
    } else {
        
        header("Location: login.php");
        exit;
    }
  }

function checkLogin(){
    if(isset($_SESSION['role']) && isset($_SESSION['sid'])){
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

function getBlockname($id){
	$sql="SELECT block_name FROM `block_master` WHERE id='".$id."'";
	$res=execute_query($sql);
	$row=mysqli_fetch_array($res);
  if(mysqli_num_rows($res) > 0)
  return $row['block_name'];
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

function gpType($id){
    $sql="SELECT `type` FROM `gram_panchayat` WHERE id='".$id."'";
	$res=execute_query($sql);
	$row=mysqli_fetch_array($res);
    if(mysqli_num_rows($res) > 0)
    return $row['type'];
    else
    return '';
}

function getcenterName($id){
    if($id !=''){
       
            $sql="SELECT awc_name FROM `new_vacancy` WHERE id='".$id."'";
            $res=execute_query($sql);
            $row=mysqli_fetch_array($res);
        if(mysqli_num_rows($res) > 0)
            return strtoupper($row['awc_name']);
        else
        return 'NA';
    }
    else{
        return 'NA';
    }
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
    return 'सामान्य (अनारक्षित)';
  }

}


function getCategoryTexteng($selectedValue){
	if ($selectedValue == '1') {
		return 'General(UR)';
	} elseif ($selectedValue == '2') {
		return 'Other Backward Caste(OBC)';
	} elseif ($selectedValue == "3") {
		return 'Scheduled Caste(SC)';
	} elseif ($selectedValue == "4") {
		return 'Scheduled Tribes(ST)';
	} elseif ($selectedValue == "5") {
		return 'Economically Weaker Section(EWS)';
	}
  else{
    return 'General(UR)';
  }

}

function ewstext($val){
    if($val==1){
        return 'YES';
    }
    else{
        return 'NO';
    }
}

function getewsText($selectedValue){
	if ($selectedValue == 1) {
		return 'YES';
	} elseif ($selectedValue == 0) {
		return 'NO';
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
    return 'NA';
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
	return 'परित्यकता/तलाकशुदा';
}

else{
  return 'अन्य';
}
}


function getCurrentsituationen($id){
    if($id=='1'){
        return 'Wido';
    }
    else if($id=='2'){
        return 'Abandoned/Divorced';
    }
    
    else{
      return 'Other';
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

function shiftonecheck(){
    $sql="select shift,last_date from vacancy_order where dist_id='".$_SESSION['distid']."'";
    $res=execute_query($sql);
  
    if(mysqli_num_rows($res) > 0){
        $row=mysqli_fetch_assoc($res);
        $v=$row['shift'];
        if($v==1){
            return 1;
        }
        else{
            return 0;
        }

    }
    else{
        return 0;
    }
  
}

function checkReservation($id){
    $sql="select category from new_vacancy where unique_code='".$id."'";
    $res=execute_query($sql);
    if(mysqli_num_rows($res) > 0){
        $row=mysqli_fetch_assoc($res);
        return $row['category'];
    }
    else{
        return 'NA';
    }
}
?>