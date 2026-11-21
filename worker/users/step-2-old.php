<?php
include('../config/db_config.php');
include('../config/settings.php');

if (!checkLogin()) {
    header('Location: login.php');
}

$session_user_id = !empty($_SESSION['uid']) ? $_SESSION['uid'] : '';

if (isset($session_user_id)) {
    $sql = "SELECT * FROM users WHERE `id`='" . $session_user_id . "'";
    $res = $conn->query($sql);
    $data = mysqli_fetch_assoc($res);

    $sql = "SELECT * FROM personal_details WHERE `userid`='" . $session_user_id . "'";
    $res = $conn->query($sql);
    if (mysqli_num_rows($res) >= 1) {
        $sql = "SELECT * FROM personal_details WHERE `userid`='" . $session_user_id . "'";
        $res = $conn->query($sql);
        $pdata = mysqli_fetch_assoc($res);
        $_SESSION['personal-details-2'] = 'yes';
    }
} else {
    header('Location: login.php');
}

topheader();

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
        <?php
        if (isset($_SESSION['success'])) {
            echo '<div class="alert alert-success alert-dismissible">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>' . $_SESSION['success'] . '</div>';
            unset($_SESSION['success']);
        }
        if (isset($_SESSION['error'])) {
            echo '<div class="alert alert-danger alert-dismissible">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']);
        }
        ?>
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
                    <div class="col-md-4 col-12 text-center"> <strong>Father Name</strong> : <?php echo $data['father_name']; ?></div>
                    <div class="col-md-4 col-12 text-center"><strong>Mobile No.</strong> : <?php echo $data['mobile']; ?></div>
                </div>
            </div>
        </div>

        <div class="border bg-light p-1 mb-1"></div>

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

            
            <section id="step-1" class="form-step">
                <div class="row">
                    <center>
                        <h4><u>व्यक्तिगत विवरण - 2</u></h4>
                    </center>
                    <form class="row needs-validation" id=" userAccountSetupForm" name="form1" method="post" action="formSubmit.php" enctype="multipart/form-data" novalidate>
                        <div class="col-md-4 mt-4">
                            <label for="category" class="form-label">श्रेणी</label>
                            <select class="form-select" id="category" name="category" required>
                                <option selected value="">कृप्या विकल्प चुने</option>
                                <option value="1" <?php if (isset($pdata)) { if ($pdata['category'] == '1') : ?> selected="selected" <?php endif; } ?>>सामान्य (अनारक्षित)</option>
                                <option value="2" <?php if (isset($pdata)) { if ($pdata['category'] == '2') : ?> selected="selected" <?php endif; } ?>>अन्य पिछड़ा वर्ग</option>
                                <option value="3" <?php if (isset($pdata)) { if ($pdata['category'] == '3') : ?> selected="selected" <?php endif; } ?>>अनुसूचित जाति</option>
                                <option value="4" <?php if (isset($pdata)) { if ($pdata['category'] == '4') : ?> selected="selected" <?php endif; } ?>>अनुसूचित जनजाति</option>
                                <option value="5" <?php if (isset($pdata)) { if ($pdata['sub_category'] == '5') : ?> selected="selected" <?php endif; } ?>>आर्थिक रूप से कमजोर वर्ग(EWS)</option>
                            </select>

                        </div>
                        <?php
                        $sql_1 = "select district from new_application_details where userid='" . $session_user_id . "'";
                        $res_1 = execute_query($sql_1);
                        $rdata = mysqli_fetch_assoc($res_1);
                        $qry = "select * from setting where district_id='" . $rdata['district'] . "'";
                         
                        $re = execute_query($qry);
                        if (mysqli_num_rows($re) > 0) {
                            $setrow = mysqli_fetch_assoc($re);
                            if (($setrow['sub_category_hadnicap'] == 1) || ($setrow['sub_category_ff'] == 1)) {
                        ?>
                                <div class="col-md-4 mt-4">
                                    <label for="sub_category" class="form-label">उप श्रेणी</label>
                                    <div class="input-group has-validation">
                                        <select class="form-select" id="sub_category" name="sub_category">
                                            <option selected value="">कृप्या विकल्प चुने</option>
                                            <?php if ($setrow['sub_category_hadnicap'] == 1) { ?>
                                                <option value='1' <?php if (isset($pdata)) { if ($pdata['sub_category'] == '1') : ?> selected="selected" <?php endif; } ?>>दिव्यांगता</option>
                                            <?php } ?>
                                            <?php if ($setrow['sub_category_ff'] == 1) { ?>
                                                <option value='2' <?php if (isset($pdata)) { if ($pdata['sub_category'] == '2') : ?> selected="selected" <?php endif; } ?>>स्वतन्त्रता संग्राम सेनानी के आश्रित</option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                        <?php } } ?>


                        <div class="row mt-4 mb-2" id="handicap" style="<?php if (isset($pdata)) { if ($pdata['sub_category']  == '1') { } else { echo 'display:none'; } } else { echo 'display:none'; } ?>">
                            <div class="col-md-4">
                                <label for="divangta_avedan_krmank" class="form-label">दिव्यांगता आवेदन क्रमांक </label>
                                <input type="textbox" class="form-control" name="divangta_avedan_krmank" value="<?php if (isset($pdata)) { echo $pdata['divangta_avedan_krmank']; } ?>">
                            </div>

                            <div class="col-md-4">
                                <label for="divangta_pramnpatr_kramank" class="form-label">दिव्यांगता प्रमाण पत्र क्रमांक</label>
                                <input type="textbox" class="form-control" name="divangta_pramnpatr_kramank" value="<?php if (isset($pdata)) { echo $pdata['divangta_pramnpatr_kramank']; } ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="percentage" class="form-label">प्रतिशत</label>
                                <input type="text" name="percentage" class="form-control" id="validationCustom05" value="<?php if (isset($pdata)) { echo $pdata['percentage']; } ?>">
                            </div>
                            
                        </div>
                        <div class="row mt-4" id="ff_div" style="<?php if (isset($pdata)) { if ($pdata['sub_category']  == '2') { } else { echo 'display:none'; }} else { echo 'display:none'; } ?>">
                            <div class="col-md-4 mt-4">
                                <label for="f_senani_sambandh" class="form-label">स्वतन्त्रता संग्राम सेनानी आश्रित से संबंध </label>
                                <input type="text" class="form-control" id="f_senani_sambandh" name="f_senani_sambandh" value="<?php if (isset($pdata)) { echo $pdata['f_senani_sambandh']; } ?>">
                            </div>
                            <div class="col-md-4 mt-2">
                                <label for="f_senani_prmanptr" class="form-label">स्वतन्त्रता संग्राम सेनानी आश्रित से संबंध प्रमाण पत्र संलग्न करे(Max 100Kb - png,jpg,jpeg)</label>
                                <input type="file" class="form-control" id="f_senani_prmanptr" name="f_senani_prmanptr" value="<?php if (isset($pdata)) { echo $pdata['f_senani_prmanptr']; } ?>">
                                <?php if (isset($pdata)) {
                                    if ($pdata['f_senani_prmanptr'] != '') {
                                        echo '<a href="' . $pdata['f_senani_prmanptr'] . '" target="_blank"> View Privious uploaded file</a>';
                                    }
                                } ?>
                            </div>

                            <div class="col-md-4  mt-4">
                                <label for="percentage" class="form-label">प्रतिशत</label>
                                <input type="text" name="percentage" class="form-control" id="percentage" value="<?php if (isset($pdata)) { echo $pdata['percentage']; } ?>">
                            </div>
                        </div>

                        <div class="col-md-4 mt-4">
                            <label for="positionofapplicant" class="form-label">आवेदिका की वर्तमान स्थिति</label>
                            <select class="form-select" id="positionofapplicant" name="avedika_status" required>
                                <option selected value="">कृप्या विकल्प चुने </option>
                                <option value="1" <?php if (isset($pdata)) { if ($pdata['avedika_status'] == '1') : ?> selected="selected" <?php endif; } ?>>विधवा</option>
                                <option value="2" <?php if (isset($pdata)) { if ($pdata['avedika_status'] == '2') : ?> selected="selected" <?php endif; } ?>>तलाकशुदा / परित्यकता </option>
                                <option value="3" <?php if (isset($pdata)) { if ($pdata['avedika_status'] == '3') : ?> selected="selected" <?php endif; } ?>>अन्य </option>
                            </select>

                        </div>
                        <div class="row mt-4" id="deth_v" style="display:none">
                            <div class="col-md-4">
                                <label for="drl_no" class="form-label">डी.आर.एल. नंबर </label>
                                <input type="text" class="form-control" id="drl_no" name="drl_no" value="<?php if (isset($pdata)) { echo $pdata['drl_no']; } ?>">

                            </div>
                            <div class="col-md-4">
                                <label for="deth_date" class="form-label">मृत्यु तिथि</label>
                                <input type="date" class="form-control" id="deth_date" name="deth_date" value="<?php if (isset($pdata)) { echo $pdata['deth_date']; } ?>">

                            </div>
                            <div class="col-md-4">
                                <label for="death_person" class="form-label">मृतक का नाम</label>
                                <input type="text" class="form-control" id="death_person" name="death_person" value="<?php if (isset($pdata)) { echo $pdata['death_person']; } ?>">

                            </div>
                        </div>

                        <div class="row mt-4" id="current_status_ap" style="<?php if (isset($pdata)) { if ($pdata['avedika_status']  != '4') { } else { echo 'display:none'; } } else { echo 'display:none'; } ?>">

                            <div class="col-md-4">
                                <label for="vidhwa_certificateno" class="form-label">विधवा/तलाकशुदा/पारित्यवता प्रमाण पत्र क्रमांक</label>
                                <input type="text" class="form-control" id="vidhwa_certificateno" name="vidhwa_certificateno" value="<?php if (isset($pdata)) { echo $pdata['vidhwa_certificateno']; } ?>">

                            </div>

                            <div class="col-md-4">
                                <label for="v_jarikrta_name" class="form-label">विधवा/तलाकशुदा/पारित्यवता प्रमाण पत्र जरीकर्ता का पदनाम</label>
                                <input type="text" class="form-control" id="v_jarikrta_name" name="v_jarikrta_name" value="<?php if (isset($pdata)) { echo $pdata['v_jarikrta_name']; } ?>">

                            </div>

                            <div class="col-md-4" id="">
                                <label for="cretificate_of_wido" class="form-label">विधवा/तलाकशुदा/पारित्यवता प्रमाण पत्र संलग्न करे(Max 20Kb - png,jpg,jpeg)</label>
                                <input type="file" class="form-control" id="cretificate_of_wido" name="cretificate_of_wido" value="<?php if (isset($pdata)) { echo $pdata['v_uploaddata']; } ?>">
                                <?php if (isset($pdata)) {
                                    if ($pdata['v_uploaddata'] != '') {
                                        echo '<a href="' . $pdata['v_uploaddata'] . '" target="_blank"> View Privious uploaded file</a>';
                                    }
                                } ?>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-4">
                                <label for="nivas_prmaanpatr_no" class="form-label">निवास प्रमाण पत्र क्रमांक </label>
                                <input type="text" name="nivas_prmaanpatr_no" class="form-control" id="nivas_prmaanpatr_no" value="<?php if (isset($pdata)) { echo $pdata['nivas_prmaanpatr_no']; } ?>" required>
                            </div>

                            <div class="col-md-4">
                                <label for="nivas_avedan_prmanpatr" class="form-label">निवास प्रमाण पत्र आवेदन क्रमांक </label>
                                <input type="text" name="nivas_avedan_prmanpatr" class="form-control" id="nivas_avedan_prmanpatr" value="<?php if (isset($pdata)) { echo $pdata['nivas_avedan_prmanpatr']; } ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label for="niwash_file" class="form-label">निवास प्रमाण पत्र संलग्न करे(Max 100Kb - png,jpg,jpeg) </label>
                                <input type="file" name="niwash_file" class="form-control" id="niwash_file" value="" required>
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="grampanchayatname" class="form-label">ग्रामपंचायत का नाम (दस्तावेज़ के अनुसार)</label>
                                <input type="text" name="grampanchayatname" class="form-control" id="grampanchayatname" value="<?php if (isset($pdata)) { echo $pdata['grampanchayatname']; } ?>">
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="aganvadi_center" class="form-label">आंगनवाड़ी केंद्र का नाम (दस्तावेज़ के अनुसार)</label>
                                <input type="text" name="aganvadi_center" class="form-control" id="aganvadi_center" value="<?php if (isset($pdata)) { echo $pdata['aganvadi_center']; } ?>">
                            </div>

                        </div>
                        <div class="row mt-4">
                            <div class="col-md-4">
                                <label for="jaant_prmaanpatr_no" class="form-label">जाति प्रमाण पत्र क्रमांक </label>
                                <input type="text" name="jaant_prmaanpatr_no" class="form-control" id="jaant_prmaanpatr_no" value="<?php if (isset($pdata)) { echo $pdata['jaant_prmaanpatr_no']; } ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="jaati_avedan_prmanpatr" class="form-label">जाति प्रमाण पत्र आवेदन क्रमांक </label>
                                <input type="text" name="jaati_avedan_prmanpatr" class="form-control" id="jaati_avedan_prmanpatr" value="<?php if (isset($pdata)) { echo $pdata['jaati_avedan_prmanpatr']; } ?>">
                            </div>

                            <div class="col-md-4">
                                <label for="jaati_upload" class="form-label">जाति प्रमाण पत्र संलग्न करे(Max 100Kb - png,jpg,jpeg) </label>
                                <input type="file" name="jaati_upload" class="form-control" id="jaati_upload" value="" required>
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="jaati" class="form-label">जाति (दस्तावेज़ के अनुसार)</label>
                                <input type="text" name="jaati" class="form-control" id="" value="<?php if (isset($pdata)) { echo $pdata['jaati']; } ?>">
                            </div>
                        </div>
                        <div class="row mt-4">

                            <div class="col-md-4">
                                <label for="aay_prmaanpatr_no" class="form-label">आय प्रमाण पत्र क्रमांक </label>
                                <input type="text" name="aay_prmaanpatr_no" class="form-control" id="aay_prmaanpatr_no" required value="<?php if (isset($pdata)) { echo $pdata['aay_prmaanpatr_no']; } ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="aay_avedan_prmanpatr" class="form-label">आय प्रमाण पत्र आवेदन क्रमांक </label>
                                <input type="text" name="aay_avedan_prmanpatr" class="form-control" id="aay_avedan_prmanpatr" value="<?php if (isset($pdata)) { echo $pdata['aay_avedan_prmanpatr']; } ?>">
                            </div>
                            <div class="col-md-4">
                                <label for="aay_upload" class="form-label">आय प्रमाण पत्र संलग्न करे(Max 100Kb - png,jpg,jpeg) </label>
                                <input type="file" name="aay_upload" class="form-control" id="aay_upload" value="" required>
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="varshik_aay" class="form-label">कुल वार्षिक आय (दस्तावेज़ के अनुसार)</label>
                                <input type="text" name="varshik_aay" class="form-control" id="varshik_aay" value="<?php if (isset($pdata)){ echo $pdata['varshik_aay']; } ?>">
                            </div>
                            <div class="col-md-4 mt-3">
                                <label for="aay_prmaanpatr_issue_date" class="form-label">जारी करने की तारीख (दस्तावेज़ के अनुसार)</label>
                                <input type="date" name="aay_prmaanpatr_issue_date" class="form-control" id="aay_prmaanpatr_issue_date" value="<?php if (isset($pdata)){ echo $pdata['aay_prmaanpatr_issue_date']; } ?>">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-4">
                                <label for="bpl" class="form-label">क्या आप BPL श्रेणी मे है</label>
                                <select class="form-select" id="bpl" name="bpl" required>
                                    <option selected disabled value="">कृप्या विकल्प चुने </option>
                                    <option value="1" <?php if (isset($pdata)) { if ($pdata['bpl_card'] == '1') : ?> selected="selected" <?php endif; } ?>> हाँ </option>
                                    <option value="0" <?php if (isset($pdata)) { if ($pdata['bpl_card'] == '0') : ?> selected="selected" <?php endif; } ?>> नहीं </option>
                                </select>
                                <br><br>
                            </div>



                        </div>
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
        </div>
         
        
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


 
</div>
</div>
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
        $('.js-example-basic-single').select2();
        $(".js-example-placeholder-single").select2({
            placeholder: "- Select -"
        });

    });
</script>
<script>
    $(function() {
        // $('#row_dim').hide(); 
        $('#sub_category').change(function() {
            //alert($('#husband_name').val());
            if ($('#sub_category').val() == '1') {

                $('#handicap').show();

            } else if ($('#sub_category').val() == '2') {
                $('#ff_div').show();
                $('#handicap').hide();
            } else {
                $('#ff_div').hide();
                $('#handicap').hide();
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
    </script>
    <?php footer(); ?>
    </body>
    </html>