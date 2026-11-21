<?php include('../config/db_config.php'); session_start();?>
<!doctype html>
<!-- <html lang="en"> -->
<html>
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
 
<head>

    <title>Registration : Anganwadi Recruitment 2024, Lucknow, India</title>
    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="O9mUTOIwJ98dHE8ncyPuGeXHGQNe6Ctjpf9lCdBX" />
    <link rel="shortcut icon" href="../public/images/favicon.png" />
    <link href="../public/css/bootstrap.css" rel='stylesheet' />
    <link href="../public/css/all.css" rel="stylesheet" />
    <link href="../public/css/custom_theme_student.css" rel="stylesheet" />
    <!-- <link href="https://apps.bhatkhandeuniversity.ac.in/public/css/default.css" rel="stylesheet" /> -->
    <link href="../public/css/responsive.css" rel="stylesheet" />
    <link href="../public/css/select2.min.css" rel="stylesheet" />
    <script type="text/javascript" src="../public/js/jquery-min.js"></script>
    <link href="../public/css/js_latest_toastr.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.css" integrity="sha512-0TsYUclL0x2HXTMBHTQyrsFGsELlmYZRsmq8OG1SkV6V2lRzsZoFEddMf1dsqySJIegvLmrowaeiA9HNop2dXA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.min.css" integrity="sha512-gpqtQIgLIXYBimyliA0xmgme7m5coXHQhscvqhAZcOoPlKOmEzPg2BhYIYV/d39j7fEkXh42UeVt7g5PzUtfSg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .error {
            color: red;
        }

        .leftTitle {
            font-weight: 900 !important;
            font-size: 45px;
        }

        @media only screen and (max-width:900px) {
            .leftTitle {
                font-weight: 800 !important;
                font-size: 35px;
            }

            .loginsidebar {
                height: 40vh;

            }
        }

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
    </style>
    <style>
        .leftTitle{
            font-weight: 900 !important; font-size: 45px;
        }
        .leftSubtitle{
          color: black !important;
        font-weight: 800 !important;
        font-size: 24px !important;
        }
        .deptname{
          text-align: center; 
          margin-bottom:285px; 
        }
        .loginImg{
           width:100%; 
           height:60%; 
           object-fit: cover; 
           position: absolute;
           top: 250px;
        }
        @media only screen and (max-width:900px){
            .leftTitle{
            font-weight: 800 !important;
             font-size: 35px;
            margin-top: -20% !important;
        }
        .leftSubtitle{
          position: relative;
          font-size: 16px !important;
          z-index: 9999;
          display: block !important;
        }
        .loginsidebar{
            height: 40vh;

        }
        .deptname{
          text-align: center; 
          margin-bottom:0px; 
        }
         .leftSubtitle{
          color: black !important;
          font-weight: 800 !important; 
          font-size: 24px; 
        }
        .loginImg{
          width: 100%;
          height: 60%;
          object-fit: cover;
          position: absolute;
          top: 136px;

        }
      }
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
    </style>
</head>

<body>
    <div class="screen" style="display: none">
        <span class="loader"></span>
    </div>
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-7 loginsidebar" style="display: flex;align-items: center;justify-content: center;object-fit: cover;overflow: hidden;position: sticky;top:0px;background:white;">
            <img src="../public/images/aww-image.jpg" alt="" class="loginImg">
                <div class="row justify-content-center align-items-center">
                    <div class="col-3 col-lg-3">
                        <img src="../public/images/images.png" class="img-fluid" style="filter: invert(1); position:  absolute;top: -3px; width:15%;" />
                    </div>
                    <div class="col-3 col-lg-3" style="margin-left: 10px;">
                        <img src="../public/images/icds.png" class="img-fluid" style="filter: invert(1); position:  absolute;top: -3px; width:15%;" />
                    </div>
                    <div class="deptname">
                        <h5 class="leftTitle">Anganwadi Recruitment 2024</h5>
                        <h3 class="leftSubtitle">Uttar Pradesh, Lucknow</h3>
                        <h4 class="ums-name"></h4>
                        <!-- <img class="img-resp pos01" src="../public/images/output01.png" /> -->
                        <div class="pos02">
                            <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="carousel-item active" data-bs-interval="2000">
                                        <!-- <img src="../public/images/output02.png" class="d-block w-100" alt="..."> -->
                                    </div>
                                    <div class="carousel-item" data-bs-interval="2000">
                                        <!-- <img src="../public/images/output030.png" class="d-block w-100" alt="..."> -->
                                    </div>
                                    <div class="carousel-item" data-bs-interval="2000">
                                        <!-- <img src="../public/images/indian-street-02-new.png" class="d-block w-100" alt="..."> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5" style="display: flex !important;position: relative; z-index: 2999;background-color: #fff;position: sticky;top:0px">
                <div class="p-4 p-lg-3 login-form d-flex flex-column justify-content-center align-items-center">
                    <div class="text-center text-md-center mt-md-0">
                        <h3 class="mb-0" style="font-size: 30px;font-weight: 800;">Applicant Registration</h3>
                        <div class="d-flex justify-content-center align-items-center mt-2">
                            <span class="fw-normal">Already Registered? Click Here to <a href="../users/login.php" class="fw-bold">Login</a><br>पहले से पंजीकृत? लॉगिन करने हेतु <a href="../users/login.php" class="fw-bold">यहां क्लिक करें</a>
                            </span>
                        </div>
                    </div>
                    <form action="submit_login.php" method="post" class="mt-4 row needs-validation" novalidate>

                        <!-- novalidate -->
                        <div class="form-group col-12 col-md-12 mb-2">
                            <label for="stud_name">Applicant's Name/आवेदक का नाम <span class="text-danger">*</span></label>
                            <input type="text" name="applicant_name" class="form-control str" id="stud_name" required>
                        </div>
                        <div class="form-group col-12 col-md-12 mb-2">
                            <label for="stud_name">Father's Name/पिता का नाम <span class="text-danger">*</span></label>
                            <input type="text" name="father_name" class="form-control str" id="father_name" required>
                        </div>
                        <div class="col-md-6 hiding_other">
                            <div class="form-group mb-3">
                            <?php
                                    
                                   // echo $sql;

                            ?>
                                <label for="district" class="placeholder"> District/जिला <span class="text-danger">*</span></label>
                                <select class="form-control form-select" name="district" id="" required>
                                    
                                    <?php
                                //   $sql = "SELECT districts.id,districts.district_name  FROM `districts` JOIN `vacancy_order` ON districts.id=vacancy_order.dist_id ORDER BY districts.district_name";
                                //     $result = execute_query($sql);
                                //     while ($row = mysqli_fetch_array($result)) {
                                //         echo "<option value='" . $row['id'] . "'>" . $row['district_name'] . "</option>";
                                //     }

                                    ?>
                                    <option value>कृप्या विकल्प चुने</option>
                                    <option value="2">Aligarh</option><option value="6">Auraiya</option><option value="7">Ayodhya</option><option value="15">Bareilly</option><option value="18">Bijnor</option><option value="19">Budaun</option><option value="22">Chitrakoot</option><option value="25">Etawah</option><option value="27">Fatehpur</option><option value="37">Hathras</option><option value="43">Kanpur Nagar</option><option value="44">Kasganj</option><option value="48">Lalitpur</option><option value="50">Maharajganj</option><option value="54">Mau</option><option value="56">Mirzapur</option><option value="63">Rampur</option><option value="66">Sant Kabir Nagar</option><option value="69">Shrawasti</option><option value="71">Sitapur</option><option value="72">Sonbhadra</option>


                                </select>
                            </div>
                        </div>
<!-- 
                        <div class="col-md-6">
                            <label for="validationCustom02" class="form-label">Category/श्रेणी <span class="text-danger">*</span></label>
                            <select class="form-select" id="validationCustom04" name="category" required>
                                <option selected disabled value="">कृप्या विकल्प चुने</option>
                                <option value="1" <?php if (isset($pdata)) {
                                                        if ($pdata['category'] == '1') : ?> selected="selected" <?php endif;
                                                                                                        } ?>>अनुसूचित जाति</option>
                                <option value="2" <?php if (isset($pdata)) {
                                                        if ($pdata['category'] == '2') : ?> selected="selected" <?php endif;
                                                                                                        } ?>>अनुसूचित जनजाति</option>
                                <option value="3" <?php if (isset($pdata)) {
                                                        if ($pdata['category'] == '3') : ?> selected="selected" <?php endif;
                                                                                                        } ?>>अन्य पिछड़ा वर्ग</option>
                                <option value="4" <?php if (isset($pdata)) {
                                                        if ($pdata['category'] == '4') : ?> selected="selected" <?php endif;
                                                                                                        } ?>>अनारक्षित</option>

                            </select>

                        </div> -->
                        <div class="form-group col-12 col-md-6 mb-2">
                            <label for="">Mobile No./मोबाइल नंबर <span class="text-danger">*</span></label>
                            <input type="text" name="mobile_no" maxlength="10" class="form-control num_digit" id="mobile_no" required>
                            <span class="error" id="mobmsg">
                                <?php
                                if(isset($_SESSION['mobval'])){
                                    echo'यह नंबर पहले से मौजूद है।';
                                    unset($_SESSION['mobval']);
                                }
                                ?>
                            </span>
                        </div>
                        <div class="form-group col-12 col-md-6 mb-2">
                            <label for="">Password/पासवर्ड <span class="text-danger">*</span></label>
                            <input type="password" name="pass" maxlength="14" minlength="6" class="form-control" id="pass" required>
                            <span class="error" id="mobmsg">
                                <?php
                                if(isset($_SESSION['mobval'])){
                                    echo'यह नंबर पहले से मौजूद है।';
                                    unset($_SESSION['mobval']);
                                }
                                ?>
                            </span>
                        </div>

                       

                        <div class="form-group col-12 col-md-6 mb-2">
                            <label for="mobile_no">Aadhar No./आधार नंबर <span class="text-danger"></span></label>
                            <input type="text" name="aadhar" maxlength="12" class="form-control num_digit" id="mobile_no">
                        </div>
                        <!-- <div class="form-group col-12 col-md-6 mb-2">
                            <label for="Age">उम्र  <span class="text-danger">*</span></label>
                            <input type="text" name="age" maxlength="10" class="form-control num_digit"
                                id="mobile_no" required>
                        </div> -->

                        <div class="form-group col-12 col-md-6 mb-2">
                            <label for="email_id">Email ID/ईमेल आईडी <span class="text-danger"></span></label>
                            <input type="email" maxlength="30" name="emailid" class="form-control" id="email_id">
                        </div>
                        <div class="form-group">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-5 col-5">
                                        <div class="captcha">
                                            <label class="btn-block">Captcha/कैप्चा</label>
                                            <img src="../captcha.php" id="captcha1">
                                            <input name="captchacode" type="hidden" class="form-control captchacode unselectable h4" value="" readonly>
                                            <span class="error"><?php if (isset($_SESSION['cerror'])) {
                                                                    echo $_SESSION['cerror'];
                                                                    unset($_SESSION['cerror']);
                                                                } ?></span>
                                        </div>
                                    </div>
                                    <div class="col-md-1 col-2">
                                        <div class="refresh" id="refresh"><a onClick="refreshCaptcha();" title="Refresh Captcha" id="refreshCaptcha"><span class="fas fa-redo"></span></a></div>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Enter Captcha/कैप्चा भरें<span class="text-danger">*</span></label>
                                        <input name="captcha" type="text" id="captcha-input" oninput="this.value = this.value.replace(/[^0-9]/g, '').replace(/(\..*)\./g, '$1');" maxlength="5" id="captcha-input" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="d-grid col-12 col-md-12">
                            <button type="submit" class="cstm-btn btn" name="registration_submit">Register/पंजीकरण करें
                                <span class="fa fa-arrow-right">
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    </div>
    <footer>
        <div class="row">
            <div class="col-md-9">
                <ul class="foot-list">
                    <li><div class="copyright">
                    Copyright © ICDS | Developed by <a href="" taget="_blank">CMP Techsseract LLP
                    </a> | Powered by UPDESCO
                </div></li>
                </ul>
            </div>
            <div class="col-md-3">
                <ul class="foot-list">

                </ul>
            </div>
        </div>
    </footer>

    <script type="text/javascript" src="../public/js/bootstrap.js"></script>

    <script type="text/javascript" src="../public/js/select2.min.js"></script>
    <script type="text/javascript" src="../public/js/js_latest_toastr.min.js"></script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script type="text/javascript">
        function refreshCaptcha() {
            $("#captcha1").attr('src', '../captcha.php');
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
            $('.js-example-basic-single').select2();
            $(".js-example-placeholder-single").select2({
                placeholder: "- Select -"
            });

        });
    </script>

    <script>
         $('#mobile_no').on('change', function() {
            var mob = this.value;
          
            $.ajax({
                url: "../ajax.php",
                type: "POST",
                data: {
                    mobileVal: mob,
                   
                },
                cache: false,
                success: function(result) {
                   //console.log(result);
                   //alert(result);
                   if(result=='1'){
                    $('#mobmsg').html('यह नंबर पहले से मौजूद है।');
                   }
                   else{
                    $('#mobmsg').html('');
                   }
                   
                }
            });


        });
    </script>
 <script>
        $('#submitForm').submit(function(e, params) {
            var localParams = params || {};
            if (!localParams.send) {
                e.preventDefault();
            }
            //additional input validations can be done hear
            swal({
                title: "क्या आप सहमत है?",
                text: "कृपया फॉर्म को सबमिट करने से पहले सभी दस्तावेज को पुनः जाँच ले, इसके बाद फॉर्म कोई बदलवा नही कर पाएंगे।",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#6A9944",
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
                closeOnConfirm: true
            }, function(isConfirm) {
                if (isConfirm) {
                    //console.log('test');
                    $('#submitForm').submit();
                    $(e.currentTarget).trigger(e.type, {
                        'send': true
                    });

                } else {
                    //additional run on cancel  functions can be done hear
                }
            });
        });
    </script>

</body>

</html>