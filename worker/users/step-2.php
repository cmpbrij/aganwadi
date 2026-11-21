<?php
include('../config/db_config.php');
include('../config/settings.php');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
require_once '../config/auth_check.php';
if (isset($_SESSION['uid'])) {
    $sql = "SELECT * FROM users WHERE `id`='" . $_SESSION['uid'] . "'";
    $res = $conn->query($sql);
    $data = mysqli_fetch_assoc($res);

    $q="select userid,rikt_aww_center from new_application_details where userid='" . $_SESSION['uid'] . "'";
    $resnew=execute_query($q);
    if(mysqli_num_rows($resnew) <= 0){
        header('Location: step-1.php');
        exit;
    }
     $newdata=mysqli_fetch_assoc($resnew);
    
    $q1="select userid from decleration where userid='".$data['id']."'";
    $res1=execute_query($q1);
    $countdata=mysqli_num_rows($res1);
    if($countdata >=1){
        header('Location: dashboard.php');
        exit;
    }


    $sql = "SELECT * FROM personal_details WHERE `userid`='" . $_SESSION['uid'] . "'";

    $res = $conn->query($sql);
    if (mysqli_num_rows($res) >= 1) {
        $sql = "SELECT * FROM personal_details WHERE `userid`='" . $_SESSION['uid'] . "'";
        $res = $conn->query($sql);
        $pdata = mysqli_fetch_assoc($res);
    }
   
} else {
    header('Location: login.php');
}

topheader();
// 
?>

<div class="screen" style="display: none"> <span class="loader"></span> </div>
<header class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 text-center col-md-1 b-rights px-0"><img src="../public/images/logo.png" alt="" class="dash-logo" /></div>
            <div class="col-9 col-md-9 px-0">
                <h4 class="moudlename">Anganwadi Recruitment Uttar Pradesh</h4>
                <h5 class="dash-head"> Government of Uttar Pradesh </h5>
            </div>
            <div class="col px-0 text-end" style="display: block ruby;">
                <a class="dropdown-toggle profileicon" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
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

    <div class="container-fluid mt-5">

        <div class="row">
            <div class="col-md-1 col-2">
                <a title="Dashboard" href="dashboard.php" style="color: #282d6a;" class="intentbtn">
                    <span class="intenticon">
                        <span class="icons icon-home" style="font-size: 32px;"></span>
                    </span></a>
                </div>
                <div class="col-md-3 col-10"> <a href="#" class="intentbtn bg-c-yellow">
                    <span class="intenticon">
                        <img src="../public/images/icon1.png">
                    </span> <span class="intentdata"> <b class="intentno"></b> Anganwadi Application Form </span> </a>
                </div>

                <div class="col-md-7">
                    <div class="row mt-4">
                        <div class="col-md-4 col-12 text-center"> <strong> Applicant's Name </strong>: <?php echo $data['name']; ?> </div>
                        <div class="col-md-4 col-12 text-center"> <strong>Father Name</strong> : <?php echo $data['father_name']; ?>
                    </div>
                    <div class="col-md-4 col-12 text-center"><strong>Mobile No.</strong> : <?php echo $data['mobile']; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="border bg-light p-1 mb-1">

    </div>

    <!-- start here -->
    <div id="multi-step-form-container">
        <!-- Form Steps / Progress Bar -->
        <ul class="form-stepper form-stepper-horizontal text-center mx-auto pl-0">
            <!-- Step 1 -->
            <li class="form-stepper-active text-center form-stepper-list" step="1">
                <a class="mx-2">
                    <span class="form-stepper-circle">
                        <span>1</span>
                    </span>
                    <div class="label">व्यक्तिगत विवरण - 1</div>
                </a>
            </li>

            <li class="form-stepper-active text-center form-stepper-list" step="3">
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
                        <span>3</span>
                    </span>
                    <div class="label text-muted">शैक्षिक योग्यता</div>
                </a>
            </li>
            <!-- Step 3 -->
            <li class="form-stepper-unfinished text-center form-stepper-list" step="5">
                <a class="mx-2">
                    <span class="form-stepper-circle text-muted">
                        <span>4</span>
                    </span>
                    <div class="label text-muted">अपलोड फोटो</div>
                </a>
            </li>
            <!-- Step 4 -->
            <li class="form-stepper-unfinished text-center form-stepper-list" step="6">
                <a class="mx-2">
                    <span class="form-stepper-circle text-muted">
                        <span>5</span>
                    </span>
                    <div class="label text-muted">घोषणापत्र</div>
                </a>
            </li>
            <!-- Step 5 -->


        </ul>
        <!-- Step Wise Form Content -->
        <!-- <form id="userAccountSetupForm" name="form1" id="form1" method="post" action=""> -->
            <!-- Step 1 Content -->
            <section id="step-1" class="form-step">
                 <?php if (isset($_SESSION['success'])) { ?>
                <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                    <strong><i class="bi bi-check-circle-fill"></i> Success!</strong>
                    <?php echo $_SESSION['success']; ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <?php unset($_SESSION['success']); } ?>
                <div class="heading-line mb-4">
                    <span>व्यक्तिगत विवरण - 2</span>
                </div>
                <div class="row">


                    <form class="row needs-validation" id=" userAccountSetupForm" name="form1" method="post" action="formSubmit.php" enctype="multipart/form-data" novalidate>

                        <div class="col-md-6">
                            <label for="category" class="form-label">श्रेणी<span class="text-danger">*</span></label>
                            <select class="form-select" id="category" name="category" required>
                                <option selected value="">कृप्या विकल्प चुने</option>
                                <option value="1" <?php if (isset($pdata)) {
                                    if ($pdata['category'] == '1') : ?> selected="selected" <?php endif;
                                } ?>>सामान्य (अनारक्षित)</option>
                                <option value="2" <?php if (isset($pdata)) {
                                    if ($pdata['category'] == '2') : ?> selected="selected" <?php endif;
                                } ?>>अन्य पिछड़ा वर्ग</option>
                                <option value="3" <?php if (isset($pdata)) {
                                    if ($pdata['category'] == '3') : ?> selected="selected" <?php endif;
                                } ?>>अनुसूचित जाति</option>
                                <option value="4" <?php if (isset($pdata)) {
                                    if ($pdata['category'] == '4') : ?> selected="selected" <?php endif;
                                } ?>>अनुसूचित जनजाति</option>
                                </select>
                                <div id="showcategory_alert" class="mt-2"></div>
                        </div>

                       

                        

                <div class="mt-4 pt-3">
                    <hr>
                </div>

                <div class="row">
                    <div class="col-md-4 mt-3">
                        <label for="positionofapplicant" class="form-label">आवेदिका की वर्तमान स्थिति<span class="text-danger">*</span></label>
                        <select class="form-select" onchange="checkAvedikaStatusRequired()" id="positionofapplicant" name="avedika_status" required>
                            <option selected value="">कृप्या विकल्प चुने </option>
                            <option value="1" <?php if (!empty($pdata['avedika_status']) && ($pdata['avedika_status'] == '1')) { ?> selected="selected" <?php  } ?>>विधवा</option>
                            <option value="2" <?php if (!empty($pdata['avedika_status']) && ($pdata['avedika_status'] == '2')) { ?> selected="selected" <?php  } ?>>तलाकशुदा / परित्यकता </option>
                                    <!-- <option value="3" <?php if (!empty($pdata['avedika_status']) && ($pdata['avedika_status'] == '3')) { ?> selected="selected" <?php  } ?>>विवाहित </option>
                                        <option value="4" <?php if (!empty($pdata['avedika_status']) && ($pdata['avedika_status'] == '4')) { ?> selected="selected" <?php  } ?>>अविवाहित </option> -->
                                        <option value="5" <?php if (!empty($pdata['avedika_status']) && ($pdata['avedika_status'] == '5')) { ?> selected="selected" <?php  } ?>>अन्य </option> 
                                    </select>
                                </div>
                                <div class="row mt-4" id="deth_v"   style="<?php if (!empty($pdata['avedika_status']) && $pdata['avedika_status']  == '1') {
                                } else {
                                    echo 'display:none';
                                }   ?>">
                                    <div class="col-md-4">
                                        <label for="drl_no" class="form-label">डी.आर.एल. नंबर </label>
                                        <input type="text" class="form-control" id="drl_no" name="drl_no" value="<?php echo !empty($pdata['drl_no']) ? $pdata['drl_no'] : ''; ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="deth_date" class="form-label">मृत्यु तिथि</label>
                                        <input type="date" class="form-control" id="deth_date" name="deth_date" value="<?php echo !empty($pdata['death_date']) ? $pdata['death_date'] : ''; ?>">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="death_person" class="form-label">मृतक का नाम</label>
                                        <input type="text" class="form-control" id="death_person" name="death_person" value="<?php echo !empty($pdata['death_person_name']) ? $pdata['death_person_name'] : ''; ?>">
                                    </div>
                                </div>
                                
                                <div class="row mt-4" id="current_status_ap" style="<?php if (!empty($pdata['avedika_status']) && $pdata['avedika_status']  != '5') {
                                } else {
                                    echo 'display:none';
                                }   ?>">

                                <div class="col-md-4">
                                    <label for="vidhwa_certificateno" class="form-label">विधवा/तलाकशुदा/पारित्यवता प्रमाण पत्र संख्या</label>
                                    <input type="text" class="form-control " id="vidhwa_certificateno" name="vidhwa_certificateno" value="<?php echo !empty($pdata['vidhwa_certificateno']) ? $pdata['vidhwa_certificateno'] : ''; ?>">
                                </div>

                                <div class="col-md-4">
                                    <label for="v_jarikrta_name" class="form-label">विधवा/तलाकशुदा/पारित्यवता प्रमाण पत्र जारीकर्ता का पदनाम</label>
                                    <input type="text" class="form-control" id="v_jarikrta_name" name="v_jarikrta_name" value="<?php if (isset($pdata)) {
                                        echo $pdata['v_jarikrta_name'];
                                    } ?>">
                                </div>

                                <div class="col-md-4" id="">
                                    <label for="cretificate_of_wido" class="form-label">विधवा/तलाकशुदा/पारित्यवता प्रमाण पत्र संलग्न करे (Max 200Kb - png,jpg,jpeg)</label>
                                    <input onchange="validateFileSize(this)" type="file" class="form-control" id="cretificate_of_wido" name="cretificate_of_wido" value="">

                                    <input type="hidden" id="old_cretificate_of_wido" name="old_cretificate_of_wido" value="<?= !empty($pdata['v_uploaddata']) ? $pdata['v_uploaddata'] : ''; ?>">

                                    <?php if (isset($pdata) && ($pdata['v_uploaddata'] != '')) {
                                        echo '<a href="' . $pdata['v_uploaddata'] . '" target="_blank"> View Privious uploaded file</a>';
                                    }  ?>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 pt-3">
                            <hr>
                        </div>

                        <div class="row">
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <label for="nivas_prmaanpatr_no" class="form-label">निवास प्रमाण पत्र संख्या <span class="text-danger">*</span> </label>
                                    <input type="text" name="nivas_prmaanpatr_no" class="form-control num_digit" id="nivas_prmaanpatr_no" value="<?php if (isset($pdata)) {
                                        echo $pdata['nivas_prmaanpatr_no'];
                                    } ?>" minlength="12" maxlength="12" required>
                                </div>

                                <div class="col-md-4">
                                    <label for="nivas_avedan_prmanpatr" class="form-label">निवास प्रमाण पत्र आवेदन संख्या<span class="text-danger">*</span> </label>
                                    <input type="text" name="nivas_avedan_prmanpatr" class="form-control num_digit" id="nivas_avedan_prmanpatr" value="<?php if (isset($pdata)) {
                                        echo $pdata['nivas_avedan_prmanpatr'];
                                    } ?>" minlength="15" maxlength="15" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="niwash_file" class="form-label">निवास प्रमाण पत्र संलग्न करे (Max 200KB - png,jpg,jpeg)<span class="text-danger">*</span> </label>
                                    <input onchange="validateFileSize(this)" type="file" name="niwash_file" class="form-control" id="niwash_file"  <?= empty($pdata['niwash_file']) ? 'required' : ''; ?>>
                                    <input type="hidden" id="old_niwash_file" name="old_niwash_file" value="<?= !empty($pdata['niwash_file']) ? $pdata['niwash_file'] : ''; ?>">

                                    <?php if (isset($pdata) && ($pdata['niwash_file'] != '')) {
                                        echo '<a href="' . $pdata['niwash_file'] . '" target="_blank"> View Privious uploaded file</a>';
                                    }  ?>
                                </div>
                                <div class="col-md-4 mt-3">
                                    <label for="grampanchayatname" class="form-label">ग्रामपंचायत/वार्ड का नाम(दस्तावेज़ के अनुसार)<span class="text-danger">*</span></label>
                                    <input type="text" required name="grampanchayatname" class="form-control" id="grampanchayatname" value="<?php if (isset($pdata)) {                                                                                                                                                echo $pdata['grampanchayatname'];
                                } ?>">
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="aganvadi_center" class="form-label">आंगनवाड़ी केंद्र का नाम(दस्तावेज़ के अनुसार)<span class="text-danger">*</span></label>
                                <input type="text" required name="aganvadi_center" class="form-control" id="aganvadi_center" value="<?php if (isset($pdata)) {                                                                                                                                            echo $pdata['aganvadi_center'];
                            } ?>">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <label for="jaant_prmaanpatr_no" class="form-label">जाति प्रमाण पत्र संख्या  </label>
                            <input type="text" name="jaant_prmaanpatr_no" class="form-control num_digit" id="jaant_prmaanpatr_no" value="<?php if (isset($pdata)) {
                                echo $pdata['jaant_prmaanpatr_no'];
                            } ?>" minlength="12" maxlength="12">
                        </div>
                        <div class="col-md-4">
                            <label for="jaati_avedan_prmanpatr" class="form-label">जाति प्रमाण पत्र आवेदन संख्या  </label>
                            <input type="text" name="jaati_avedan_prmanpatr" class="form-control num_digit" id="jaati_avedan_prmanpatr" value="<?php if (isset($pdata)) {
                                echo $pdata['jaati_avedan_prmanpatr'];
                            } ?>" minlength="14" maxlength="15">
                        </div>
                        <div class="col-md-4">
                            <label for="jaati_upload" class="form-label">जाति प्रमाण पत्र संलग्न करे (Max 200Kb - png,jpg,jpeg) </label>
                            <input onchange="validateFileSize(this)" type="file" name="jaati_upload" class="form-control" id="jaati_upload" value="" <?php empty($pdata['jaati_upload']) ? '' : ''; ?>>

                            <input type="hidden" id="old_jaati_upload" name="old_jaati_upload" value="<?= !empty($pdata['jaati_upload']) ? $pdata['jaati_upload'] : ''; ?>">

                            <?php if (isset($pdata) && ($pdata['jaati_upload'] != '')) {
                                echo '<a href="' . $pdata['jaati_upload'] . '" target="_blank"> View Privious uploaded file</a>';
                            }  ?>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label for="jaati" class="form-label">जाति (दस्तावेज़ के अनुसार)</label>
                            <input type="text" name="jaati" class="form-control" id="jaati" value="<?php if (isset($pdata)) {
                                echo $pdata['jaati'];
                            } ?>">
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-4">
                            <label for="aay_prmaanpatr_no" class="form-label">आय प्रमाण पत्र संख्या <span class="text-danger"></span></label>
                            <input type="text" name="aay_prmaanpatr_no" class="form-control num_digit" id="aay_prmaanpatr_no"  value="<?php if (isset($pdata)) {
                                echo $pdata['aay_prmaanpatr_no'];
                            } ?>" minlength="12" maxlength="12">
                        </div>
                        <div class="col-md-4">
                            <label for="aay_avedan_prmanpatr" class="form-label">आय प्रमाण पत्र आवेदन संख्या <span class="text-danger"></span> </label>
                            <input type="text" name="aay_avedan_prmanpatr" class="form-control num_digit" id="aay_avedan_prmanpatr" value="<?php if (isset($pdata)) {
                                echo $pdata['aay_avedan_prmanpatr'];
                            } ?>" minlength="15" maxlength="15">
                        </div>
                        <div class="col-md-4">
                            <label for="aay_upload" class="form-label">आय प्रमाण पत्र संलग्न करे (Max 200KB - png,jpg,jpeg)<span class="text-danger"></span> </label>
                            <input onchange="validateFileSize(this)" type="file" name="aay_upload" class="form-control" id="aay_upload" value="" <?php empty($pdata['aay_upload']) ? 'required' : ''; ?>>
                            <input type="hidden" id="old_aay_upload" name="old_aay_upload" value="<?= !empty($pdata['aay_upload']) ? $pdata['aay_upload'] : ''; ?>">

                            <?php if (isset($pdata) && ($pdata['aay_upload'] != '')) {
                                echo '<a href="' . $pdata['aay_upload'] . '" target="_blank"> View Privious uploaded file</a>';
                            }  ?>
                        </div>
                        <div class="col-md-4 mt-3">
                            <label for="varshik_aay" class="form-label">कुल वार्षिक आय (दस्तावेज़ के अनुसार)<span class="text-danger"></span></label>
                            <input type="text"  name="varshik_aay" class="form-control num_digit" id="varshik_aay" value="<?php echo !empty($pdata['varshik_aay']) ? $pdata['varshik_aay'] : ''; ?>">
                        </div>
                        <div class="col-md-4 mt-3">
                            <label for="aay_prmaanpatr_issue_date" class="form-label">जारी करने की तारीख (दस्तावेज़ के अनुसार)<span class="text-danger"></span></label>
                            <input type="date" name="aay_prmaanpatr_issue_date" class="form-control" id="aay_prmaanpatr_issue_date" value="<?php echo !empty($pdata['aay_prmaanpatr_issue_date']) ? $pdata['aay_prmaanpatr_issue_date'] : ''; ?>">
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <label for="bpl" class="form-label">क्या आप BPL श्रेणी मे है</label>
                            <select class="form-select" id="bpl" name="bpl" required>
                                <option selected disabled value="">कृप्या विकल्प चुने </option>
                                <option value="1" <?php if (isset($pdata)) {
                                    if ($pdata['bpl_card'] == '1') : ?> selected="selected" <?php endif;
                                } ?>> हाँ </option>
                                <option value="0" <?php if (isset($pdata)) {
                                    if ($pdata['bpl_card'] == '0') : ?> selected="selected" <?php endif;
                                } ?>> नहीं </option>
                            </select>
                            <br><br>
                        </div>
                    </div>
                                             <input type="hidden" value="<?php echo $newdata['rikt_aww_center'] ?>" id="applyCenter">
                    <?php if (isset($pdata)) { ?>
                        <div class="col-12">
                            <a href="step-1.php"><button class="btn btn-primary" type="button">पिछला</button></a>
                            <button class="button btn-navigate-form-step" type="submit" step_number="2" name="save2">अगला</button>
                        </div>
                    <?php } else { ?>
                        <div class="col-12">
                            <a href="step-1.php"><button class="btn btn-primary" type="button">पिछला</button></a>
                            <button class="button btn-navigate-form-step" type="submit" step_number="2" name="save2"> अगला
                            </button>
                        </div>
                    <?php } ?>

                </form>
            </div>
            <div class="col-12" style="color:red">
                <br> Note:<br><span >* शाशन स्तर से निर्गत प्रमाण-पत्र संलग्न करे। </span><br>
               
            </div>
        </div>
     </div>
    </section>
   

</div>
<!-- end code exam form details after submit -->

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

   // checkSubCategoryRequired();

    function checkSubCategoryRequired() {
        var subCategory = document.getElementById('sub_category').value;
        var senaniSambandh = document.getElementById('f_senani_sambandh');
        var senaniPrmanptr = document.getElementById('f_senani_prmanptr');
        var oldSenaniPrmanptrValue = document.getElementById('old_senani_prmanptr').value;

        var divangta_avedan_krmank = document.getElementById('divangta_avedan_krmank');
        var divangta_pramnpatr_kramank = document.getElementById('divangta_pramnpatr_kramank');
        var percentage = document.getElementById('percentage');
        var divangta_pramnpatr = document.getElementById('divangta_pramnpatr');
        var old_divangta_pramnpatr = document.getElementById('old_divangta_pramnpatr').value;

        var sports_details  = document.getElementById('sports_details');
        var sports_doc  = document.getElementById('sports_doc');
        var old_sports_details  = document.getElementById('old_sports_doc').value;

       
        // Handling required attributes based on subCategory
        if (subCategory === '1') {
            divangta_avedan_krmank.setAttribute('required', true);
            divangta_pramnpatr_kramank.setAttribute('required', true);
            percentage.setAttribute('required', true);

            if (!old_divangta_pramnpatr) {
                divangta_pramnpatr.setAttribute('required', true);
            } else {
                divangta_pramnpatr.removeAttribute('required');
            }

            senaniSambandh.removeAttribute('required');
            senaniPrmanptr.removeAttribute('required');

            sports_details.removeAttribute('required');
            sports_doc.removeAttribute('required');
            old_sports_details.removeAttribute('required');
            
        } else if (subCategory === '2') {
            senaniSambandh.setAttribute('required', true);

            if (!oldSenaniPrmanptrValue) {
                senaniPrmanptr.setAttribute('required', true);
            } else {
                senaniPrmanptr.removeAttribute('required');
            }

            

            divangta_avedan_krmank.removeAttribute('required');
            divangta_pramnpatr_kramank.removeAttribute('required');
            percentage.removeAttribute('required');
            divangta_pramnpatr.removeAttribute('required');

             sports_details.removeAttribute('required');
            sports_doc.removeAttribute('required');
            old_sports_details.removeAttribute('required');
        }else if (subCategory === '3') {
           sports_details.setAttribute('required', true);

            if (!old_sports_doc) {
                sports_doc.setAttribute('required', true);
                sports_doc.style.border = '2px solid red';
                 sports_doc.focus();
            } else {
                sports_doc.removeAttribute('required');
            }

            divangta_avedan_krmank.removeAttribute('required');
            divangta_pramnpatr_kramank.removeAttribute('required');
            percentage.removeAttribute('required');
            divangta_pramnpatr.removeAttribute('required');

             senaniSambandh.removeAttribute('required');
            senaniPrmanptr.removeAttribute('required');
        } else {
            // If subCategory is neither '1' nor '2', clear the required attributes
            // senaniSambandh.removeAttribute('required');
            // senaniPrmanptr.removeAttribute('required');

            // divangta_avedan_krmank.removeAttribute('required');
            // divangta_pramnpatr_kramank.removeAttribute('required');
            // percentage.removeAttribute('required');
            // divangta_pramnpatr.removeAttribute('required');
        }
    }

    checkAvedikaStatusRequired();

    function checkAvedikaStatusRequired() {
        var positionofapplicant = document.getElementById('positionofapplicant').value;

        var drl_no = document.getElementById('drl_no');
        var deth_date = document.getElementById('deth_date');
        var death_person = document.getElementById('death_person');
        var vidhwa_certificateno = document.getElementById('vidhwa_certificateno');
        var v_jarikrta_name = document.getElementById('v_jarikrta_name');

        var cretificate_of_wido = document.getElementById('cretificate_of_wido');
        var old_cretificate_of_wido = document.getElementById('old_cretificate_of_wido').value;

        if (positionofapplicant == '1') {
            drl_no.setAttribute('required', true);
            deth_date.setAttribute('required', true);
            death_person.setAttribute('required', true);
            vidhwa_certificateno.setAttribute('required', true);
            v_jarikrta_name.setAttribute('required', true);
            if (!old_cretificate_of_wido) {
                cretificate_of_wido.setAttribute('required', true);
            } else {
                cretificate_of_wido.removeAttribute('required');
            }

        } else if (positionofapplicant == '2') {

            vidhwa_certificateno.setAttribute('required', true);
            v_jarikrta_name.setAttribute('required', true);
            if (!old_cretificate_of_wido) {
                cretificate_of_wido.setAttribute('required', true);
            } else {
                cretificate_of_wido.removeAttribute('required');
            }

            drl_no.removeAttribute('required');
            deth_date.removeAttribute('required');
            death_person.removeAttribute('required');

        } else {
            drl_no.removeAttribute('required');
            deth_date.removeAttribute('required');
            death_person.removeAttribute('required');
            vidhwa_certificateno.removeAttribute('required');
            v_jarikrta_name.removeAttribute('required');
            cretificate_of_wido.removeAttribute('required');
        }
    }

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
<script>
    $(function() {

        $('#sub_category').change(function() {
            if ($('#sub_category').val() == '1') {
                $('#ff_div').hide();
                 $('#sports_div').hide();
                $('#handicap').show();
                $('#f_senani_sambandh').val('');
                $('#f_senani_prmanptr').val('');
                $('#sports_details').val('');
                $('#sports_doc').val('');

            } else if ($('#sub_category').val() == '2') {
                $('#ff_div').show();
                $('#handicap').hide();
                  $('#sports_div').hide();
                 $('#divangta_avedan_krmank').val('');
                $('#divangta_pramnpatr_kramank').val('');
                $('#divangta_avedan_krmank').val('');
                $('#percentage').val('');
                $('#divangta_pramnpatr').val('');
                 $('#sports_details').val('');
                $('#sports_doc').val('');
                

             } else if ($('#sub_category').val() == '3') {
                $('#sports_div').show();
                $('#handicap').hide();
                 $('#ff_div').hide();
                  $('#divangta_avedan_krmank').val('');
                $('#divangta_pramnpatr_kramank').val('');
                $('#divangta_avedan_krmank').val('');
                $('#percentage').val('');
                $('#divangta_pramnpatr').val('');
                $('#f_senani_sambandh').val('');
                $('#f_senani_prmanptr').val('');
            }else {
                $('#ff_div').hide();
                $('#handicap').hide();
                $('#sports_div').hide();
            }

        });
    });


    $(function() {
        // $('#row_dim').hide(); 
        $('#married_status').change(function() {
            //alert($('#husband_name').val());
            if ($('#married_status').val() == 'UM') {
                $('#fatherdiv').show();
                $('#husbanddiv').hide();
                //alert('1');
            }
            if ($('#married_status').val() == 'M') {
                //alert('2');
                $('#fatherdiv').hide();
                $('#husbanddiv').show();
            }
        });
    });

    $(function() {
        // $('#row_dim').hide(); 
        $('#positionofapplicant').change(function() {
            //alert($('#husband_name').val());
            if ($('#positionofapplicant').val() == '2') {
                $('#current_status_ap').show();
                $('#deth_v').hide();
                $('#drl_no').val('');
                 $('#deth_date').val('');
                  $('#death_person').val('');
                   $('#vidhwa_certificateno').val('');
                    $('#v_jarikrta_name').val('');
                    $('#cretificate_of_wido').val('');

            } else if ($('#positionofapplicant').val() == '1') {
                $('#deth_v').show();
                $('#current_status_ap').show();
            } else {
                $('#current_status_ap').hide();
                $('#deth_v').hide();
            }

        });
    });
</script>

<script type="text/javascript">
    function valueChanged() {
        if ($('.dcheck').is(":checked")) {
            $("#d_serial").show();
            $("#d_per").show();
        } else {
            $("#d_serial").hide();
            $("#d_per").hide();
        }

    }

    function ffvalueChanged() {
        if ($('.ff').is(":checked")) {
            $("#ffdiv").show();

        } else {
            $("#ffdiv").hide();

        }

    }
</script>

<style>
    .ellipsis {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>

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

     $(document).ready(function () {

    $("#category").on("change", function () {

        var category = $(this).val();
        var center_id = $("#applyCenter").val();

        $("#showcategory_alert").html("");

        if (category == "") {
            return;
        }

        $.ajax({
            url: "ajax.php",
            type: "POST",
            dataType: "json",
            data: {
                action: "checkCategory",
                category: category,
                center_id: center_id
            },
            beforeSend: function () {
                $("#showcategory_alert").html("");
            },
            success: function (res) {

                console.log(res);

                if (res.status == 1) {

                    $("#showcategory_alert").html(
                        '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
                        res.message +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '</div>'
                    );

                } else {

                    $("#showcategory_alert").html(
                        '<div class="alert alert-danger alert-dismissible fade show" role="alert">' +
                        res.message +
                        '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>' +
                        '</div>'
                    );

                    $("#category").val("");
                }

            },
            error: function (xhr, status, error) {

                console.log("Status :", status);
                console.log("Error :", error);
                console.log("Response :", xhr.responseText);

                $("#showcategory_alert").html(
                    '<div class="alert alert-danger">' +
                    'Server Error! Please try again.' +
                    '</div>'
                );
            }
        });

    });

});
</script>

<?php footer(); ?>
</body>

</html>