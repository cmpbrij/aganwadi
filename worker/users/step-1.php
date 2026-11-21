<?php
include('../config/db_config.php');
include('../config/settings.php');
//   ini_set('display_errors', 1);
// ini_set('display_startup_errors', 0);
// error_reporting(E_ALL);

if (!checkLogin()) {
    header('Location: login.php');
}
require_once '../config/auth_check.php';

$session_uid = $_SESSION['uid'];

if (isset($session_uid)) {
    $query = "SELECT `name`,`father_name`,`mobile`,`id`,district FROM users WHERE `id`='" . $session_uid . "'";
    $res = $conn->query($query);
    $data = $res->fetch_assoc();

    $district_id = !empty($data['district']) ? $data['district'] : '';

    $q = "SELECT districts.id,districts.district_name,vacancy_order.cutoff_date  FROM `districts`
    JOIN `vacancy_order` ON districts.id=vacancy_order.dist_id 
    WHERE vacancy_order.last_date >='" . date('Y-m-d') . "' AND districts.id='" . $district_id . "'";
    $re = execute_query($q);
    if (mysqli_num_rows($re) <= 0) {
        header('Location: dashboard.php');
        exit;
    }
    $vadata=mysqli_fetch_assoc($re);

    $q1="select userid from decleration where userid='".$_SESSION['uid'] ."'";
   // echo $q1; die;
    $res1=execute_query($q1);
    $countdata=mysqli_num_rows($res1);
    if($countdata >=1){
        header('Location: dashboard.php');
        exit;
    }
    $sql = "SELECT * FROM new_application_details WHERE `userid`='" . $session_uid . "'";
    $res = $conn->query($sql);
    $pdata = mysqli_fetch_assoc($res);
    
}


topheader();
?>

<!-- <div id="loading"><img src="loading.gif" alt="Loading..." width="100" height="100"><p>Loading...</p></div> -->


<style>
    tr {
        margin-bottom: 10px;
    }

    .ellipsis {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

<div class="screen" style="display: none" id="loading"> <span class="loader"></span> </div>
<header class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 text-center col-md-1 b-rights px-0">
                <img src="../public/images/logo.png" alt="" class="dash-logo" />
            </div>
            <div class="col-9 col-md-9 px-0">
                <h4 class="moudlename">Anganwadi Recruitment Uttar Pradesh</h4>
                <h5 class="dash-head"> Government of Uttar Pradesh </h5>
            </div>
            <div class="col px-0 text-end" style="display: block ruby;">
                <a href="javascript::void(0)" class="profileicon">
                    <!-- <img src="../public/images/profile2.png" /></a> -->
                    <div class="dropdown">
                        <a class="dropdown-toggle profileicon" href="#" role="button" id="dropdownMenuLink"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../public/images/profile2.png" />
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<div class="contentwraper">


    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-1 col-2">
                <a title="Dashboard" href="dashboard.php" style="color: #282d6a;" class="intentbtn">
                    <span class="intenticon">
                        <span class="icons icon-home" style="font-size: 32px;"></span>
                    </span>
                </a>
            </div>
            <div class="col-md-3 col-10"> <a href="application_details.php" class="intentbtn bg-c-yellow">
                <span class="intenticon"><img src="../public/images/icon1.png"></span>
                <span class="intentdata"> <b class="intentno"></b>Worker Application Form </span> </a>
            </div>
            <div class="col-md-7">
                <div class="row mt-4">
                    <div class="col-md-4 col-12 text-center"> <strong> Applicant's Name </strong>:
                        <?php echo !empty($data['name']) ? $data['name'] : ''; ?> </div>
                        <div class="col-md-4 col-12 text-center"> <strong>Father Name</strong> :
                            <?php echo !empty($data['father_name']) ? $data['father_name'] : ''; ?></div>
                            <div class="col-md-4 col-12 text-center"><strong>Mobile No.</strong> :
                                <?php echo !empty($data['mobile']) ? $data['mobile'] : ''; ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border bg-light p-1 mb-1">
                </div>

                <!-- start here -->
                <div id="multi-step-form-container" >
                    <!-- Form Steps / Progress Bar -->
                    <ul class="form-stepper form-stepper-horizontal text-center mx-auto">
                        <!-- Step 1 -->
                        <li class="form-stepper-active text-center form-stepper-list" step="1">
                            <a class="mx-1">
                                <span class="form-stepper-circle">
                                    <span>1</span>
                                </span>
                                <div class="label">व्यक्तिगत विवरण - 1</div>
                            </a>
                        </li>
                        <!-- Step 2 -->
                        <li class="form-stepper-unfinished text-center form-stepper-list" step="2">
                            <a class="mx-2">
                                <span class="form-stepper-circle text-muted">
                                    <span>2</span>
                                </span>
                                <div class="label text-muted">व्यक्तिगत विवरण - 2</div>
                            </a>
                        </li>

                        <li class="form-stepper-unfinished text-center form-stepper-list" step="4">
                            <a class="mx-2">
                                <span class="form-stepper-circle text-muted">
                                    <span>4</span>
                                </span>
                                <div class="label text-muted">शैक्षिक योग्यता</div>
                            </a>
                        </li>
                        <!-- Step 3 -->
                        <li class="form-stepper-unfinished text-center form-stepper-list" step="5">
                            <a class="mx-2">
                                <span class="form-stepper-circle text-muted">
                                    <span>5</span>
                                </span>
                                <div class="label text-muted">अपलोड फोटो</div>
                            </a>
                        </li>
                        <!-- Step 4 -->
                        <li class="form-stepper-unfinished text-center form-stepper-list" step="6">
                            <a class="mx-2">
                                <span class="form-stepper-circle text-muted">
                                    <span>6</span>
                                </span>
                                <div class="label text-muted">घोषणापत्र</div>
                            </a>
                        </li>
                        <!-- Step 5 -->
                    </ul>
                    <!-- Step Wise Form Content -->
                    <!-- <form id="userAccountSetupForm" name="form1" id="form1" method="post" action=""> -->
                    </div>
                </div>


                <!-- Step 1 Content -->
                <section id="step-1" class="form-step">
                    <div class="row">
                        <?php
                            $success_msg = $_SESSION['success'] ?? '';
                            $error_msg   = $_SESSION['error'] ?? '';
                            $errorMessages = $_SESSION['errorMessages'] ?? [];
                        ?>
                          <!-- Display Success Message -->
                    <?php if (!empty($success_msg)): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success_msg); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Display Error Message -->
                    <?php if (!empty($error_msg)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($error_msg); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($errorMessages)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h6 class="alert-heading">कृपया निम्नलिखित त्रुटियाँ सुधारें:</h6>
                            <ul class="mb-0">
                                <?php foreach ($errorMessages as $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php
                        unset($_SESSION['success'], $_SESSION['error'], $_SESSION['errorMessages']);
                    ?>
                        <div class="heading-line">
                            <span>व्यक्तिगत विवरण - 1</span>
                        </div>
                        <form class="row g-3 needs-validation mt-2" id="myform" name="form1" method="post" enctype="multipart/form-data" action="formSubmit.php" onsubmit="return checkValidation();">
                            <input type="hidden" name="uid" value="<?php echo $session_uid; ?>">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="district" class="placeholder">जनपद का नाम <span class="text-danger">*</span></label>
                                    <select class="form-control form-select" name="district_name" id="district" required>
                                        <!-- <option value="">कृप्या विकल्प चुने</option> -->
                                        <?php
                                        $q = "SELECT id,district_name  FROM `districts` WHERE id='" . $district_id . "'";
                                        $result = execute_query($q);
                                        $row = mysqli_fetch_array($result);
                                        ?>
                                        <option value="<?php echo $row['id']; ?>"><?php echo strtoupper($row['district_name']); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="project" class="placeholder"> परियोजना <span class="text-danger">*</span></label>
                                    <select class="form-control form-select" name="project" id="project" required>
                                        <option value="">कृप्या विकल्प चुने</option>
                                        <?php $q = "SELECT bm.id, bm.block_name 
                                        FROM `block_master` AS bm 
                                        JOIN `new_vacancy` AS nv ON bm.id = nv.project_id 
                                        WHERE nv.district_id = '" . $district_id . "' GROUP BY bm.id ORDER BY bm.block_name";

                                        $result = execute_query($q);
                                        while ($row = mysqli_fetch_array($result)) {
                                            $selected = (isset($pdata['project']) && $pdata['project'] == $row['id']) ? 'selected="selected"' : '';
                                            ?>
                                            <option value="<?php echo $row['id']; ?>" <?php echo $selected; ?>>
                                                <?php echo strtoupper($row['block_name']); ?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="r_b" class="placeholder"> शहरी/ग्रामीण <span class="text-danger">*</span></label>
                                    <select class="form-control form-select" name="grameen_sehri" id="r_b" required>
                                        <option value="" disable>कृप्या विकल्प चुने</option>
                                        <option value="1" <?php if (isset($pdata) && ($pdata['grameen_sehri'] == '1')) { ?> selected="selected" <?php } ?>>शहरी</option>
                                        <option value="2" <?php if (isset($pdata) && ($pdata['grameen_sehri'] == '2')) { ?> selected="selected" <?php } ?>>ग्रामीण</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4" id="gramp">
                                <div class="form-group mb-3">
                                    <label for="gram_p" class="placeholder"> <span id="lablegram"> </span> <span id="lableward">ग्राम पंचायत/वार्ड का नाम </span><span class="text-danger">*</span></label>
                                    <select class="form-control form-select" name="gram_panchayat" id="gram_p" required>
                                        <option value="">कृप्या विकल्प चुने</option>
                                        <!-- <option value="bkt">ग्राम पंचायत-1</option> -->
                                        <?php
                                        if (isset($pdata)) {
                                            $q = "SELECT DISTINCT 
                                                COALESCE(NULLIF(gp_name, ''), ward_name) AS gram_panchayat_name FROM new_vacancy where project_id='" . $pdata['project'] . "'";
                                            $result = mysqli_query($conn, $q);
                                            while ($row = mysqli_fetch_array($result)) {
                                                $selected = (isset($pdata) && $pdata['gram_panchayat'] == $row['gram_panchayat_name']) ? 'selected="selected"' : '';
                                                ?>
                                                <option value="<?php echo $row['gram_panchayat_name']; ?>" <?php echo $selected; ?>><?php echo $row['gram_panchayat_name']; ?></option>
                                            <?php }
                                        } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4" id="nyap">
                                <div class="form-group mb-3">
                                    <label for="nya_panchyat" class="placeholder"> न्याय पंचायत का नाम <span class="text-danger"></span></label>
                                    <input type="text" name="nya_panchyat" id="nya_panchyat" class="form-control str" value="<?php if (isset($pdata['nay_panchayat'])) {
                                        echo $pdata['nay_panchayat'];
                                    }  ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="rikt_center" class="form-label">रिक्त आंगनवाड़ी केंद्र का नाम<span class="text-danger">*</span></label>
                                <select class="form-control form-select" name="rikt_aww_center" id="rikt_center" required>
                                    <!-- <option value="">कृप्या विकल्प चुने</option> -->
                                    <?php echo '<option value="' . $pdata['rikt_aww_center'] . '">' . getawwCenter($pdata['rikt_aww_center']) . '</option>';
                                    ?>
                                </select>
                            </div>

                            <div class="row"></div>
                            <div class="col-md-4">
                                <label for="applicant_name" class="form-label">आवेदिका का हिंदी में नाम <span
                                    class="text-danger">*</span></label>
                                    <div class="input-group has-validation">
                                        <input type="text" class="form-control" name="applicant_name" id="applicant_name" value="<?php if (isset($pdata)) {
                                            echo $pdata['name_hi'];
                                        }  ?>" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="applicant_name_en" class="form-label">आवेदिका का अंग्रेजी में नाम<span class="text-danger">*</span></label>
                                    <div class="input-group has-validation">
                                        <input type="text" class="form-control" name="applicant_name_en" id="applicant_name_en" value="<?php if (isset($pdata)) {
                                            echo $pdata['name_en'];
                                        }  ?>" required>
                                    </div>
                                </div>
                    
                    <div class="col-md-4">
                        <label for="father_name" class="form-label">पिता का नाम <span class="text-danger">*</span></label>
                        <input type="text" id="father_name" name="father_name" class="form-control" value="<?php if (isset($pdata)) {
                            echo $pdata['fname'];
                        }  ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="mother_name" class="form-label">माता का नाम <span class="text-danger">*</span></label>
                        <div class="input-group has-validation">
                            <input type="text" name="mother_name" class="form-control" id="mother_name" value="<?php if (isset($pdata)) {
                                echo $pdata['mname'];
                            }  ?>" required>
                        </div>
                    </div>

                    <div class="col-md-4 mt-3">
                        <label for="marital_status" class="form-label">वैवाहिक स्थिति</label>
                        <select class="form-select" onchange="checkMaritalStatus()" id="marital_status" name="marital_status" required>
                            <option selected value="">कृप्या विकल्प चुने </option>
                            
                            <option value="1" <?php if (!empty($pdata['marital_status']) && ($pdata['marital_status'] == '1')) { ?> selected="selected" <?php  } ?>>विवाहित </option>
                            <option value="2" <?php if (!empty($pdata['marital_status']) && ($pdata['marital_status'] == '2')) { ?> selected="selected" <?php  } ?>>अविवाहित </option> 
                        </select>
                    </div>

                    <div class="col-md-4" id="husbanddiv">
                        <label for="husband_name" class="form-label">पति का नाम <span class="text-danger">*</span></label>
                        <input type="text" name="husband_name" class="form-control" id="husband_name" value="<?php if (isset($pdata)) {
                            echo $pdata['hname'];
                        }  ?>">
                    </div>
                    <div class="col-md-4">
                        <label for="mobile" class="form-label">आवेदिका का मोबाइल नंबर <span class="text-danger">*</span></label>
                        <input type="text" name="mobile" class="form-control" id="mobile" value="<?php echo $_SESSION['mobile']; ?>" disabled required>
                    </div>


                    <div class="col-md-12 mt-4 mb-4" style="background-color:#CCC;padding-top:15px;padding-bottom:15px;">
                        <b> Address Details </b>
                    </div>                                                                                                      
                    <div class="col-md-12 mb-4">
                      
                        <table class="add">
                            <tr class="mt-3">
                                <td class="col-2 p-2"> पूरा पता <span class="text-danger">*</span></td>
                                    <td>
                                        <td class="col-5 p-2">
                                            <label for="permanent_full_address" class="form-label">स्थायी पता<span class="text-danger">*</span></label>
                                            <textarea rows="2" required name="permanent_full_address" class="form-control" id="full_address1" required><?= !empty($pdata['permanent_full_address']) ? $pdata['permanent_full_address'] : ''; ?></textarea>
                                        </td>
                                        <td class="col-5 p-2">
                                            <label for="mailing_full_address" class="form-label">पत्र व्यवहार का पता<span class="text-danger">*</span></label>
                                            <textarea rows="2" required name="mailing_full_address" class="form-control" id="mailing_full_address" required><?= !empty($pdata['mailing_full_address']) ? $pdata['mailing_full_address'] : ''; ?></textarea>
                                        </td>
                                    </tr>

                                    <tr class="mt-3">
                                        <td class="col-2 p-2">पिन कोड <span class="text-danger">*</span></td>
                                            <td>
                                                <td class="col-5 p-2">
                                                    <input type="text" value="<?= !empty($pdata['permanent_full_address_pincode']) ? $pdata['permanent_full_address_pincode'] : ''; ?>" name="permanent_full_address_pincode" maxlength="6" class="form-control num_digit" id="permanent_full_address_pincode" required>
                                                </td>
                                                <td class="col-5 p-2">
                                                    <input type="text" value="<?= !empty($pdata['mailing_full_address_pincode']) ? $pdata['mailing_full_address_pincode'] : ''; ?>" name="mailing_full_address_pincode" maxlength="6" class="form-control num_digit" id="mailing_full_address_pincode" required>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <hr>

                                    <div class="row">
                                        <div class="col-md-4 mt-2">
                                            <label for="dob" class="form-label">जन्मतिथि <span class="text-danger">*</span></label>
                                            <div class="input-group has-validation">
                                                <input type="date" class="form-control" name="dob" id="dob"
                                                value="<?php if (isset($pdata)) {
                                                    echo $pdata['date_of_birth'];
                                                }  ?>" required>
                                            </div>
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <div class="row">
                                                <div class="col-4">
                                                    <label for="year" class="form-label">वर्ष <span class="text-danger">*</span></label>
                                                    <div class="input-group has-validation">
                                                        <input type="text" class="form-control" name="year" id="year" required value="<?php if (isset($pdata)) {
                                                            echo $pdata['year'];
                                                        }  ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <label for="month" class="form-label">माह<span class="text-danger">*</span></label>
                                                    <div class="input-group has-validation">
                                                        <input type="text" class="form-control" name="month" id="month" required value="<?php if (isset($pdata)) {
                                                            echo $pdata['month'];
                                                        }  ?>" readonly>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <label for="day" class="form-label"> दिन</label>
                                                    <div class="input-group has-validation">
                                                        <input type="text" class="form-control" name="day" id="day" required value="<?php if (isset($pdata)) {
                                                            echo $pdata['day'];
                                                        }  ?>" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        <span id="exact_age"></span>
                                            <label class="mt-1 form-label" style="font-size: 12px;">आवेदिका की आयु ( 18 से 35 वर्ष मान्य है )</label>
                                            CUT OFF DATE - <?php echo $vadata['cutoff_date']; ?>
                                            <input type="hidden" name="cutoff_date" id="cutoff_date" value="<?php echo $vadata['cutoff_date']; ?>">
                                        </div>
                                    </div> 
                                    <div class=" col-md-4 mt-1">
                                        <div class="row"> 
                                            <label for="h_marksheet" class="form-label">हाई स्कूल प्रमाणपत्र (जन्मतिथि के लिए) (Max 200KB - png,jpg,jpeg) <span class="text-danger">*</span></label>
                                            <div class="input-group has-validation">
                                                <input onchange="validateFileSize(this)" <?php if (empty($pdata['h_marksheet'])) { ?> required <?php } ?> type="file" accept="image/*" name="h_marksheet" id="h_marksheet" class="form-control" >
                                                
                                                <input type="hidden" name="old_h_marksheet" value="<?php echo !empty($pdata['h_marksheet']) ? $pdata['h_marksheet'] : ''; ?>">
                                            </div>

                                            <?php if (isset($pdata) && ($pdata['h_marksheet'] != '')) {
                                                echo '<a href="' . $pdata['h_marksheet'] . '" target="_blank"> View Privious uploaded file</a>';
                                            }  ?>
                                        </div>
                                    </div>
                                    <div class="col-md-12 row text-center">
                                        <div class="col-12 mt-3">
                                           <button type="submit" class="btn btn-primary" name="save1" value="submit" id="save1-btn">
                                                 <?php echo isset($pdata) ? 'अपडेट & अगला' : 'अगला'; ?>
                                            </button>
                                        </div>
                                   
                                    </div>

                                    <div class="col-12">
                                        Note:<br>
                                          <span style="color:red">  *आयु हेतु केवल हाई-स्कूल अथवा समक्ष प्रमाण पत्र ही मान्य है।  </span><br>
                                          <span style="color:red">  * यदि कोई महिला विवाहित है तो आवदेन ससुराल के निवास प्रमाण-पत्र के आधार पर ही  करे। </span>
                                    </div>
                                </form>
                            </section>

               
            </div>

        </div>
    </div>

    <script>
        <?php
        if (isset($_SESSION['success']) && !empty($_SESSION['success'])) {
            echo "showToastMsg('" . $_SESSION['success'] . "' , 'Success' , 'success');";
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
            echo "showToastMsg('" . $_SESSION['error'] . "' , 'Error' , 'error');";
            unset($_SESSION['error']);
        }
        ?>
    </script>

    <script>

        function validateFileSize(inputElement) {
            const file = inputElement.files[0];
        const maxSize = 200 * 1024; // 200 KB in bytes
        
        if (file) {
            if (file.size > maxSize) {
                alert("File size exceeds the 200KB limit.");
            inputElement.value = ''; // Clear the file input if the file is too large
        }
    }
}

$(document).ready(function () {

    $("#dob").on("blur", function () {

        var mdate = $("#dob").val();
        if (!mdate) {
            $("#exact_age").text("Please select a date.");
            return;
        }

        var yearThen = parseInt(mdate.substring(0, 4), 10);
        var monthThen = parseInt(mdate.substring(5, 7), 10) - 1;
        var dayThen = parseInt(mdate.substring(8, 10), 10);

        var birthday = new Date(yearThen, monthThen, dayThen);

        // Get cutoff type (jan / july)
        var cutoffType = $("#cutoff_date").val().toLowerCase().trim();

        var cutoff;
        var cutoffText;

        if (cutoffType === "july") {
            cutoff = new Date(2026, 6, 1); // 01-07-2026
            cutoffText = "01-07-2026";
        } else {
            cutoff = new Date(2026, 0, 1); // 01-01-2026
            cutoffText = "01-01-2026";
        }

        // Age calculation
        var year_age = cutoff.getFullYear() - birthday.getFullYear();
        var month_age = cutoff.getMonth() - birthday.getMonth();
        var day_age = cutoff.getDate() - birthday.getDate();

        if (day_age < 0) {
            month_age--;
            var lastMonthDays = new Date(cutoff.getFullYear(), cutoff.getMonth(), 0).getDate();
            day_age += lastMonthDays;
        }

        if (month_age < 0) {
            year_age--;
            month_age += 12;
        }

        if (isNaN(year_age) || isNaN(month_age) || isNaN(day_age)) {
            $("#exact_age").text("Invalid birth date. Please try again!");
            return;
        }

        // Minimum age: 18 years completed
            if (year_age < 18) {
                alert("Age must be 18 years or above as on " + cutoffText);
                $("#dob").val('');
                $("#year, #month, #day").val('');
                return;
            }

            // Maximum age: Less than 35 years
            if (
                year_age > 35 ||
                (year_age == 35 && (month_age > 0 || day_age > 0)) ||
                (year_age == 35 && month_age == 0 && day_age == 0)
            ) {
                alert("Age must be less than 35 years as on " + cutoffText);
                $("#dob").val('');
                $("#year, #month, #day").val('');
                return;
            }

        $("#year").val(year_age);
        $("#month").val(month_age);
        $("#day").val(day_age);

        $("#exact_age").html(
            "Age as on <b>" + cutoffText + "</b><br><span id='age'>" +
            year_age + " years " + month_age + " months " + day_age + " days</span>"
        );

    });

});



</script>



<script>
    checkMaritalStatus();

    function checkMaritalStatus(){
        if ($('#marital_status').val() == '1') {
            $('#husbanddiv').show();
            document.getElementById('husband_name').setAttribute('required', true);
        } else {
            $('#husbanddiv').hide();
            document.getElementById('husband_name').removeAttribute('required');
        }
    }

    $(function() {
        $('#pre_name').change(function() {
            if ($('#pre_name').val() == '1') {
                $('#husbanddiv').show();
            } else {
                $('#husbanddiv').hide();
            }
        });
    });
</script>

<script>
    function getdistrict(val) {
        $.ajax({
            type: "POST",
            url: "../ajax.php",
            data: 'distid=' + val,
            success: function(data) {
                $("#block").html('');
                $("#block").html(data);
            }
        });
    }
</script>


<script>
    $(document).ready(function() {

        $('#district').on('change', function() {
            var project_name = this.value;
            $('#loading').show();
            $.ajax({
                url: "../ajax.php",
                type: "POST",
                data: {
                    project_name: project_name
                },
                cache: false,
                success: function(result) {
                    $('#loading').hide();
                    $("#project").html('');
                    $("#project").html(result);
                }
            });
        });

        $('#r_b').on('change', function() {
            var ru = $('#r_b').val();
            if (ru == '1') {
                $('#nyap').hide();
            } else {
                $('#nyap').show();
            }
        });

        $('#project').on('change', function() {
            var ru = $('#r_b').val();
            $('#loading').show();
            var projectid = $('#project').val();
            var distid = $('#district').val();
            $.ajax({
                url: "../ajax.php",
                type: "POST",
                data: {
                    gramp: ru,
                    projectID: projectid,
                    distID: distid
                },
                cache: false,
                success: function(result) {
                    $('#loading').hide();
                    $('#gram_p').html('');
                    if (gramp == '1') {
                        $('#gram_p').html(result);
                    } else {
                        $('#gram_p').html(result);
                        $('#gramp').show();
                    }
                    // $('#gram_p').html('<option value="">कृप्या विकल्प चुने</option>');
                }
            });
        });


        $('#r_b').on('change', function() {
            var gramp = this.value;
            var projectid = $('#project').val();
            var distid = $('#district').val();
            $.ajax({
                url: "../ajax.php",
                type: "POST",
                data: {
                    distID: distid,
                    gramp: gramp,
                    projectID: projectid
                },
                cache: false,
                success: function(result) {
                    $('#gram_p').html('');
                    if (gramp == '1') {
                        $('#gram_p').html(result);
                    } else {
                        $('#gram_p').html(result);
                        $('#gramp').show();
                    }
                    // $('#gram_p').html('<option value="">कृप्या विक्लप चुने</option>');
                }
            });
        });

        $('#gram_p').on('change', function() {
            var gramp = this.value;
            var projectid = $('#project').val();
            var dist = $('#district').val();
            var rg = $('#r_b').val();
            // alert(rg);
            $('#loading').show();
            $.ajax({
                url: "../ajax.php",
                type: "POST",
                data: {
                    grampanchayatID: gramp,
                    pid: projectid,
                    distID: dist,
                    UR: rg
                },
                cache: false,
                success: function(result) {
                    $('#loading').hide();
                    $("#rikt_center").html('');
                    $("#rikt_center").html(result);
                }
            });
        });

        $('#ward_name').on('change', function() {
            var ward_name = this.value;
            var projectid = $('#project').val();
            $.ajax({
                url: "../ajax.php",
                type: "POST",
                data: {
                    grampanchayatID: ward_name,
                    pid: projectid
                },
                cache: false,
                success: function(result) {
                    $("#gram_p").html('');
                    $("#rikt_center").html('');
                    $("#rikt_center").html(result);
                }
            });
        });

    });
</script>


<script>
 function checkValidation(event) {

    const dob = document.getElementById('dob').value;

    if (!dob) {
        alert('Please select your Date of Birth.');
        return false;
    }

    const dobDate = new Date(dob + 'T00:00:00');

    // 01-07-2025
    const cutoff = new Date(2026, 6, 1); // July = 6 (0-based month)

    if (dobDate > cutoff) {
        alert('Date of Birth issue');
        return false;
    }

    let age = cutoff.getFullYear() - dobDate.getFullYear();
    let monthDiff = cutoff.getMonth() - dobDate.getMonth();
    let dayDiff = cutoff.getDate() - dobDate.getDate();

    if (monthDiff < 0 || (monthDiff === 0 && dayDiff < 0)) {
        age--;
    }

    if (age < 18) {
        alert('Age must be 18 years or above as on 01-07-2025.');
        return false;
    }

    if (age >= 35) {
        alert('Age must be less than 35 years as on 01-07-2025.');
        return false;
    }

    return true;
}
</script>

<script>
    // validation
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            var forms = document.getElementsByClassName('needs-validation');
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();

    $(document).ready(function() {

        $(".alpha").keypress(function(e) {
            return /[0-9 . ,a-z A-Z@ ]/i.test(event.key);
        });
        $(".num_digit").keypress(function(e) {
            return /[0-9.]/i.test(event.key);
        });
        $(".str").keypress(function(e) {
            return /[a-z A-Z .]/i.test(event.key);
        });


    });
</script>

<?php footer(); ?>

</body>

</html>