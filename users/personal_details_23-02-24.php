<?php
include('../config/settings.php');
//session_start();
    if(!checkLogin()){
        header('Location: login.php');
    }
if (isset($_SESSION['uid'])) {
    $sql = "SELECT * FROM users WHERE `id`='" . $_SESSION['uid'] . "'";
    $res = $conn->query($sql);
    $data = mysqli_fetch_assoc($res);

    $sql = "SELECT * FROM personal_details_2 WHERE `userid`='" . $_SESSION['uid'] . "'";
    //echo $sql; die;
    $res = $conn->query($sql);
    if (mysqli_num_rows($res) >= 1) {
        $_SESSION['personal-details-2'] = 'yes';
    }

    //print_r($data); die;
}


if (isset($_SESSION['personal-details-2'])) {
    $sql = "SELECT * FROM personal_details_2 WHERE `userid`='" . $_SESSION['uid'] . "'";
    //echo $sql; die;
    $res = $conn->query($sql);
    $pdata = mysqli_fetch_assoc($res);
    //print_r($pdata); die;
}

$sql = "INSERT INTO `form-2-data`(`id`, `formid-first`, `userid`, `category`, `subcategory`, `divyan_parman_patra`, `divyan_percentage`, `ff_relation`, `ff_relation_certificate`, `current_status`, `address_certificate_no`, `cast_certificate_no`, `age_certificate_no`, `is_bpl`, `created`, `updated`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]','[value-9]','[value-10]','[value-11]','[value-12]','[value-13]','[value-14]','[value-15]','[value-16]')";


topheader();
// 
?>

<?php

// if (isset($_POST['save2'])) {
//     $category = mysqli_real_escape_string($conn, $_POST['category']);
//     $sub_category = mysqli_real_escape_string($conn, $_POST['sub_category']);
//     $divangta_avedan_krmank = mysqli_real_escape_string($conn, $_POST['divangta_avedan_krmank']);
//     $divangta_pramnpatr_kramank = mysqli_real_escape_string($conn, $_POST['divangta_pramnpatr_kramank']);
//     $percentage = mysqli_real_escape_string($conn, $_POST['percentage']);
//     $f_senani_sambandh = mysqli_real_escape_string($conn, $_POST['f_senani_sambandh']);
//     $f_senani_prmanptr = mysqli_real_escape_string($conn, $_POST['f_senani_prmanptr']);
//     $avedika_status = mysqli_real_escape_string($conn, $_POST['avedika_status']);
//     $vidhwa_certificateno = mysqli_real_escape_string($conn, $_POST['vidhwa_certificateno']);
//     $v_jarikrta_name = mysqli_real_escape_string($conn, $_POST['v_jarikrta_name']);
//     $v_uploaddata = mysqli_real_escape_string($conn, $_POST['v_uploaddata']);
//     $nivas_prmaanpatr_no = mysqli_real_escape_string($conn, $_POST['nivas_prmaanpatr_no']);
//     $nivas_avedan_prmanpatr = mysqli_real_escape_string($conn, $_POST['nivas_avedan_prmanpatr']);
//     $nivas_upload = mysqli_real_escape_string($conn, $_POST['nivas_upload']);
//     $jaant_prmaanpatr_no = mysqli_real_escape_string($conn, $_POST['jaant_prmaanpatr_no']);
//     $jaati_avedan_prmanpatr = mysqli_real_escape_string($conn, $_POST['jaati_avedan_prmanpatr']);
//     $jaati_upload = mysqli_real_escape_string($conn, $_POST['jaati_upload']);
//     $aay_prmaanpatr_no = mysqli_real_escape_string($conn, $_POST['aay_prmaanpatr_no']);
//     $aay_avedan_prmanpatr = mysqli_real_escape_string($conn, $_POST['aay_avedan_prmanpatr']);
//     $aay_upload = mysqli_real_escape_string($conn, $_POST['aay_upload']);
//     $bpl_card = mysqli_real_escape_string($conn, $_POST['bpl_card']);



//     $sql = "INSERT INTO `personal_details`(`category`, `sub_category`, `divangta_avedan_krmank`, `divangta_pramnpatr_kramank`, 
//     `percentage`, `f_senani_sambandh`, `f_senani_prmanptr`, `avedika_status`, `vidhwa_certificateno`, 
//     `v_jarikrta_name`, `v_uploaddata`, `nivas_prmaanpatr_no`, `nivas_avedan_prmanpatr`, `nivas_upload`, `jaant_prmaanpatr_no`,
//      `jaati_avedan_prmanpatr`, `jaati_upload`, `aay_prmaanpatr_no`, `aay_avedan_prmanpatr`, `aay_upload`, `bpl_card`)
//      VALUES 
//      ('$category','$sub_category','$divangta_avedan_krmank','$divangta_pramnpatr_kramank','$percentage','$f_senani_sambandh','$f_senani_prmanptr',
//      '$avedika_status' '$vidhwa_certificateno','$v_jarikrta_name','$v_uploaddata','$nivas_prmaanpatr_no','$nivas_avedan_prmanpatr','$nivas_upload',
//      '$jaant_prmaanpatr_no','$jaati_avedan_prmanpatr','$jaati_upload','$aay_prmaanpatr_no','$aay_avedan_prmanpatr','$aay_upload','$bpl_card')";

//     $res = mysqli_query($conn, $sql);
// }

?>

<div class="screen" style="display: none"> <span class="loader"></span> </div>
<header class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-2 text-center col-md-1 b-rights px-0"><img src="../public/images/logo.png" alt="" class="dash-logo" /></div>
            <div class="col-9 col-md-9 px-0">
                <h4 class="moudlename">Anganwadi Recruitment Uttar Pradesh</h4>
                <!-- <h5 class="dash-head">Previously known as Bhatkhande Music Institute Deemed to be University, -->
                <!-- Lucknow</h5> -->
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
    <?php
    if (isset($_SESSION['success'])) {
        echo '<div class="alert alert-success alert-dismissible">
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>' . $_SESSION['success'] . '
            </div>';
    }
    unset($_SESSION['success']);
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1 col-2">
                <a title="Dashboard" href="student_dashboard.html" style="color: #282d6a;" class="intentbtn">
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
                    <div class="col-md-4 col-12 text-center"> <strong>Mobile No.</strong> : <?php echo $data['father_name']; ?>
                    </div>
                    <div class="col-md-4 col-12 text-center"><strong>Category</strong> : <?php echo $data['mobile']; ?>
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
                <!-- Step 2 -->
                <!-- <li class="form-stepper-active text-center form-stepper-list" step="2">
                    <a class="mx-2">
                        <span class="form-stepper-circle text-muted">
                            <span>2</span>
                        </span>
                        <div class="label text-muted">व्यक्तिगत विवरण - 2</div>
                    </a>
                </li> -->
                <!--step3 -->
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
                <div class="row">
                    <center>
                        <h4><u>व्यक्तिगत विवरण - 2</u></h4>
                    </center>
                    <form class="row g-3 needs-validation mt-" onsubmit="return validateForm()" id=" userAccountSetupForm" name="form1" method="post" action="formSubmit.php" novalidate>
                        <div class="col-md-6">
                            <label for="validationCustom02" class="form-label">श्रेणी</label>
                            <select class="form-select" id="validationCustom04" name="category" required>
                                <option selected disabled value="">कृप्या विक्लप चुने</option>
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
                                <option value="5" <?php if (isset($pdata)) {
                                                        if ($pdata['sub_category'] == '5') : ?> selected="selected" <?php endif;
                                                                                                            } ?>>आर्थिक रूप से कमजोर वर्ग(EWS)</option>



                            </select>

                        </div>
                        <div class="col-md-6">
                            <label for="validationCustomUsername" class="form-label">उप श्रेणी</label>
                            <div class="input-group has-validation">
                                <select class="form-select" id="sub_category" name="sub_category" required>
                                    <option selected disabled value="">कृप्या विक्लप चुने</option>
                                    <option value="1" <?php if (isset($pdata)) {
                                                            if ($pdata['sub_category'] == '1') : ?> selected="selected" <?php endif;
                                      } ?>>दिव्यांगता</option>
                                    <option value="2" <?php if (isset($pdata)) {
                                                            if ($pdata['sub_category'] == '2') : ?> selected="selected" <?php endif;
                                             } ?>>स्वतन्त्रता संग्राम सेनानी के आश्रित</option>
                                </select>

                            </div>
                        </div>

                        <div class="row mt-4 mb-2">

                            <div class="col-md-4" id="d_serial">
                                <label for="validationCustom04" class="form-label">दिव्यांगता आवेदन क्रमांक </label>
                                <input type="textbox" class="form-control" name="divangta_avedan_krmank" value="<?php if (isset($pdata)) {
                                                            echo $pdata['handicap_cerno'];
                                                     } ?>">

                            </div>
                            <div class="col-md-4" id="d_parman">
                                <label for="validationCustom04" class="form-label">दिव्यांगता प्रमाण पत्र क्रमांक</label>
                                <input type="textbox" class="form-control" name="divangta_pramnpatr_kramank" value="<?php if (isset($pdata)) {
                                                                                                                        echo $pdata['handicap_cerno'];
                                                                                                                    } ?>">

                            </div>
                            <div class="col-md-4" id="d_per">
                                <label for="validationCustom05" class="form-label">प्रतिशत</label>
                                <input type="text" name="percentage" class="form-control" id="validationCustom05" required>

                            </div>

                            <div class="col-md-6 mt-4" id="ff_rel">
                                <label for="validationCustom02" class="form-label">स्वतन्त्रता संग्राम सेनानी आश्रित से संबंध </label>
                                <input type="text" class="form-control" id="validationCustom02" name="f_senani_sambandh" value="" required>

                            </div>
                            <div class="col-md-6 mt-4" id="ff_cert">
                                <label for="validationCustom02" class="form-label">स्वतन्त्रता संग्राम सेनानी आश्रित से संबंध प्रमाण पत्र संलग्न करे</label>
                                <input type="file" class="form-control" id="validationCustom02" name="f_senani_prmanptr" value="" required>

                            </div>

                        </div>

                        <div class="col-md-4">
                            <label for="validationCustom02" class="form-label">आवेदिका की वर्तमान स्थिति</label>
                            <select class="form-select" id="positionofapplicant" name="avedika_status" required>
                                <option selected disabled value="">कृप्या विक्लप चुने </option>
                                <option value="1" <?php if (isset($pdata)) {
                                                        if ($pdata['current_situation'] == '1') : ?> selected="selected" <?php endif;
                                                                                                                    } ?>>विधवा</option>
                                <option value="2" <?php if (isset($pdata)) {
                                                        if ($pdata['current_situation'] == '2') : ?> selected="selected" <?php endif;
                                                                                                                    } ?>>तलाकशुदा</option>
                                <option value="3" <?php if (isset($pdata)) {
                                                        if ($pdata['current_situation'] == '3') : ?> selected="selected" <?php endif;
                                                                                                                    } ?>>परित्यकता </option>
                            </select>

                        </div>

                        <div class="col-md-4">
                            <label for="validationCustom02" class="form-label">विधवा/तलाकशुदा/पारित्यवता प्रमाण पत्र क्रमांक</label>
                            <input type="text" class="form-control" id="validationCustom02" name="vidhwa_certificateno" value="" required>

                        </div>

                        <div class="col-md-4">
                            <label for="validationCustom02" class="form-label">विधवा/तलाकशुदा/पारित्यवता प्रमाण पत्र जरीकर्ता का पदनाम</label>
                            <input type="text" class="form-control" id="validationCustom02" name="v_jarikrta_name" value="" required>

                        </div>
                        <div class="col-md-6 mt-4" id="ff_cert">
                                <label for="validationCustom02" class="form-label">विधवा/तलाकशुदा/पारित्यवता प्रमाण पत्र संलग्न करे</label>
                                <input type="file" class="form-control" id="validationCustom02" name="cretificate_of_wido" value="" required>

                        </div>

                        <div class="col-md-6" id="ffdiv" style='<?php if (isset($pdata)) {
                                                                    if ($pdata['handicap_cerno'] != '') {
                                                                        echo "display:block";
                                                                    } else {
                                                                        echo "display:none";
                                                                    }
                                                                } else {
                                                                    echo "display:none";
                                                                }  ?>'>
                            <label for="validationCustom02" class="form-label">विधवा/तलाकशुदा/पारित्यवता दस्तावेज़ अपलोड करें</label>
                            <input type="file" name="v_uploaddata" class="form-control" id="validationCustom02" value="<?php if (isset($pdata)) {
                                                                                                                            echo $pdata['ff_document'];
                                                                                                                        } ?>">

                        </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-4">
                        <label for="validationCustom01" class="form-label">निवास प्रमाण पत्र क्रमांक </label>
                        <input type="text" name="nivas_prmaanpatr_no" class="form-control" id="" value="<?php if (isset($pdata)) {
                                                                                                            echo $pdata['address_cerno'];
                                                                                                        } ?>" required>
                    </div>

                    <div class="col-md-4">
                        <label for="validationCustom01" class="form-label">निवास प्रमाण पत्र आवेदन क्रमांक </label>
                        <input type="text" name="nivas_avedan_prmanpatr" class="form-control" id="" value="<?php if (isset($pdata)) {
                                                                                                                echo $pdata['address_cerno'];
                                                                                                            } ?>" required>
                    </div>
                    <div class="col-md-4">
                        <!-- <label for="validationCustom01" class="form-label">निवास प्रमाण पत्र अपलोड करें</label> -->
                        <input type="hidden" name="nivas_upload" class="form-control" id="" value="<?php if (isset($pdata)) {
                                                                                                        echo $pdata['address_cerno'];
                                                                                                    } ?>" required>
                    </div>
                    <div class="col-md-4 mt-4">
                        <label for="validationCustom01" class="form-label">जाति प्रमाण पत्र क्रमांक </label>
                        <input type="text" name="jaant_prmaanpatr_no" class="form-control" id="" value="<?php if (isset($pdata)) {
                                                                                                            echo $pdata['cast_cerno'];
                                                                                                        } ?>" required>
                    </div>
                    <div class="col-md-4 mt-4">
                        <label for="validationCustom01" class="form-label">जाति प्रमाण पत्र आवेदन क्रमांक </label>
                        <input type="text" name="jaati_avedan_prmanpatr" class="form-control" id="" value="<?php if (isset($pdata)) {
                                                                                                                echo $pdata['cast_cerno'];
                                                                                                            } ?>" required>
                    </div>
                    <div class="col-md-4 mt-4">
                        <!-- <label for="validationCustom01" class="form-label">जाति प्रमाण पत्र अपलोड करें </label> -->
                        <input type="hidden" name="jaati_upload" class="form-control" id="" value="<?php if (isset($pdata)) {
                                                                                                        echo $pdata['cast_cerno'];
                                                                                                    } ?>" required>
                    </div>
                    <div class="col-md-4 mt-4">
                        <label for="validationCustom01" class="form-label">आय प्रमाण पत्र क्रमांक </label>
                        <input type="text" name="aay_prmaanpatr_no" class="form-control" id="" value="<?php if (isset($pdata)) {
                                                                                                            echo $pdata['income_cerno'];
                                                                                                        } ?>" required>

                    </div>
                    <div class="col-md-4 mt-4">
                        <label for="validationCustom01" class="form-label">आय प्रमाण पत्र आवेदन क्रमांक </label>
                        <input type="text" name="aay_avedan_prmanpatr" class="form-control" id="" value="<?php if (isset($pdata)) {
                                                                                                                echo $pdata['income_cerno'];
                                                                                                            } ?>" required>

                    </div>
                    <div class="col-md-4 mt-4">
                        <!-- <label for="validationCustom01" class="form-label">आय प्रमाण पत्र अपलोड करें </label> -->
                        <input type="hidden" name="aay_upload" class="form-control" id="" value="<?php if (isset($pdata)) {
                                                                                                    echo $pdata['income_cerno'];
                                                                                                } ?>" required>

                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label for="validationCustom04" class="form-label">क्या आप BPL श्रेणी मे है</label>
                        <select class="form-select" id="validationCustom04" name="bpl_card" required>
                            <option selected disabled value="">कृप्या विक्लप चुने </option>
                            <option value="Y" <?php if (isset($pdata)) {
                                                    if ($pdata['is_bpl'] == 'Y') : ?> selected="selected" <?php endif;
                                                                                                    } ?>> हाँ </option>
                            <option value="N" <?php if (isset($pdata)) {
                                                    if ($pdata['is_bpl'] == 'N') : ?> selected="selected" <?php endif;
                                                                                                    } ?>> नहीं </option>
                        </select>
                        <br><br>
                    </div>



                </div>
                <?php
                if (isset($pdata)) {
                ?>
                    <div class="col-12">
                        <a href="application_details.php"><button class="btn btn-primary" type="button">पिछला</button></a>

                        <button class="button btn-navigate-form-step" type="submit" step_number="2" name="save2">अगला</button>
                    </div>
                <?php
                } else {
                ?>
                    <div class="col-12">
                        <a href="application_details.php"><button class="btn btn-primary" type="button">पिछला</button></a>
                        <!-- <button class="btn btn-success" type="submit">Save</button>  -->
                        <button class="button btn-navigate-form-step" type="submit" step_number="2" name="save2"> अगला
                        </button>
                    </div>
                <?php } ?>

                </form>
        </div>
    </div>
    <!-- <div class="bhoechie-footer">
                       <div class="row justify-content-center">
                         <div class="col-md-2 d-grid"> 
                           <button type="submit" class="btn btn-primary">Save & Next</button>
                         </div>
                       </div>
                     </div> -->
    </form>

    </section>
    <!-- Step 2 Content, default hidden on page load. -->
    <section id="step-2" class="form-step d-none">
        <h2 class="font-normal">Social Profiles</h2>
        <!-- Step 2 input fields -->
        <div class="mt-3">Step 2 input fields goes here..</div>
        <div class="mt-3">
            <button class="button btn-navigate-form-step" type="button" step_number="1">
                Prev
            </button>
            <button class="button btn-navigate-form-step" type="button" step_number="3" name="update">
                Next
            </button>
        </div>
    </section>
    <!-- Step 3 Content, default hidden on page load. -->
    <section id="step-3" class="form-step d-none">
        <h2 class="font-normal">Social Profiles</h2>
        <!-- Step 3 input fields -->
        <div class="mt-3">Step 3 input fields goes here..</div>
        <div class="mt-3">
            <button class="button btn-navigate-form-step" type="button" step_number="2">
                Prev
            </button>
            <button class="button btn-navigate-form-step" type="button" step_number="4">
                Next
            </button>
        </div>
    </section>
    <!-- Step 4 Content, default hidden on page load. -->
    <section id="step-4" class="form-step d-none">
        <h2 class="font-normal">Social Profiles</h2>
        <!-- Step 4 input fields -->
        <div class="mt-3">Step 4 input fields goes here..</div>
        <div class="mt-3">
            <button class="button btn-navigate-form-step" type="button" step_number="3">
                Prev
            </button>
            <button class="button btn-navigate-form-step" type="button" step_number="5">
                Next
            </button>
        </div>
    </section>
    <!-- Step 5 Content, default hidden on page load. -->
    <section id="step-5" class="form-step d-none">
        <h2 class="font-normal">Social Profiles</h2>
        <!-- Step 5 input fields -->
        <div class="mt-3">Step 5 input fields goes here..</div>
        <div class="mt-3">
            <button class="button btn-navigate-form-step" type="button" step_number="4">
                Prev
            </button>
            <button class="button btn-navigate-form-step" type="button" step_number="6">
                Next
            </button>
        </div>
    </section>
    <!-- Step 6 Content, default hidden on page load. -->
    <section id="step-6" class="form-step d-none">
        <h2 class="font-normal">Personal Details</h2>
        <!-- Step 6 input fields -->
        <div class="mt-3">Step 6 input fields goes here..</div>
        <div class="mt-3">
            <button class="button btn-navigate-form-step" type="button" step_number="5">
                Prev
            </button>
            <button class="button submit-btn" type="submit">Save</button>
        </div>
    </section>
    </form>
</div>





<!-- <div class="custom-card mb-3">
			<div class="custom-active">

               <h5> Application Status</h5>
					<div class="arrow-steps clearfix">
						<div class="step  current"> <span> <i class="fas fa-check"></i> </span> Application Details </span> </div>
						<div class="step @if ($step!=null && $step->form_step >= 4) current @endif"> <span><i class="fa fa-check"></i> </span>Upload Document</span> </div>
						<div class="step @if ($step!=null && $step->form_step >= 5) current @endif"> <span><i class="fas fa-check"></i> <i class="fa fa-hourglass-end" aria-hidden="true"></i></span>Application Preview</span>
						</div>
					</div>

			</div>
	    </div> -->
<div class="card">
    <div class="card-body">



    </div>
</div>



<!-- end code exam form details after submit -->

</div>
</div>

<script>

$(function() {
        // $('#row_dim').hide(); 
        $('#sub_category').change(function() {
            //alert($('#husband_name').val());
            if ($('#sub_category').val() == '1') {
                $('#d_serial').show();
                $('#d_parman').show();
                $('#d_per').show();
                $('#ff_rel').hide();
                $('#ff_cert').hide();
                //alert('1');
            }
            else{
                $('#d_serial').hide();
                $('#d_parman').hide();
                $('#d_per').hide();
                $('#ff_rel').show();
                $('#ff_cert').show();
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
            if ($('#positionofapplicant').val() == 'V') {
                $('#fatherdiv').show();
                $('#husbanddiv').hide();
                //alert('1');
            }
            if ($('#positionofapplicant').val() == 'D') {
                //alert('2');
                $('#fatherdiv').hide();
                $('#husbanddiv').show();
            }
            if ($('#positionofapplicant').val() == 'other') {
                //alert('2');
                $('#fatherdiv').hide();
                $('#husbanddiv').show();
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
<select class="form-select" id="positionofapplicant" name="category" required>

    <style>
        .ellipsis {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>




    <script>
        var ajaxUrl = "{{ url('') }}";
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
    <?php footer(); ?>


    </body>

    </html>