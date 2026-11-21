<?php 
    session_start();
 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Dashboard | ICDS | AWW Recruitment</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.ico" />
</head>

<body class="boxed-layout">
    <style>
    .auth .login-half-bg {
        background: url(../public/images/aww-image.jpg);
        background-size: cover;
    }
    </style>
   
    <div class="container-scroller" style="padding: 0px;">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
                <div class="row flex-grow">
                    <div class="col-lg-6 d-flex align-items-center justify-content-center">
                        <div class="auth-form-transparent text-left p-3">
                            <div class="brand-logo">
                                <img style="margin-left: 25%;" src="../assets/img/icds.png" alt="logo">
                            </div>
                            <h4>Reset Password!</h4>
                            <h6 class="font-weight-light"></h6>
                            <h6 class="font-weight-light" style="color:green;">
                            <?php if(isset($_SESSION['logout'])) echo $_SESSION['logout']; ?></h6>

                            <form class="pt-3" method="POST" action="submitLogin.php">
                                <div style="color:red;">
                                    <?php
                                   
                                        if(isset($_SESSION['err'])){
                                            echo $_SESSION['err'];
                                        }
                                        unset($_SESSION['err']);
                                    ?>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail">Mobile number</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="mdi mdi-account-outline text-primary"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="mobile"
                                            class="form-control form-control-lg border-left-0" id="exampleInputEmail"
                                            placeholder="Please enter mobile number" required maxlength="10">
                                    </div>
                                </div>
                                <div class="form-group">
                                <label style="display: flex;font-weight: 700;">Enter Captcha<span class="text-danger">*</span></label>
                                    <input name="captcha" type="text" id="captcha-input"
                                            maxlength="5" minlength="5" id="captcha-input" class="form-control num_digit" required>
                                            
                                </div>
                                <div class="form-group">
                                     <label class="btn-block">Captcha/कैप्चा</label>
									<!--span class="unselectable" id="p_refresh"></span-->
                                    <div class="row">
                                        <div class="col-sm-5">

                                         <div class="input-group">
                                            <img src="../captcha.php" id="captcha1">
                                             <input name="captchacode" type="hidden" class="form-control captchacode unselectable h4 num_digit" value="" readonly>
                                         </div>
                                        </div>
                                        <div class="col-sm-2">
                                        <button type="button" class="refresh" id="refresh" style="border:none"  title="Refresh Captcha"><i class="mdi mdi-refresh" style="font-size: 30px;"></i></button>
                                    
                                    </div>
                                    <span class="error"><?php if(isset($_SESSION['cerror'])){ echo $_SESSION['cerror']; unset($_SESSION['cerror']);} ?></span>
                                       
                                </div>
                                    </div>
                                
                               
                                <div class="my-3">
                                    <button type="submit" id="login" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                                        name="forgot_pass_submit">Submit</button>
                                </div>
                                <!-- <div class="mb-2 d-flex">
                  <button type="button" class="btn btn-facebook auth-form-btn flex-grow me-1">
                    <i class="mdi mdi-facebook me-2"></i>Facebook
                  </button>
                  <button type="button" class="btn btn-google auth-form-btn flex-grow ms-1">
                    <i class="mdi mdi-google me-2"></i>Google
                  </button>
                </div> -->

                            </form>
                        </div>
                    </div>
                    <div class="col-lg-6 login-half-bg d-flex flex-row">

                    </div>
                    <p class=" font-weight-medium text-center flex-grow align-self-center"
                        style="color:white !important ;margin:0px;padding:0px;position:absolute;bottom:0px;left:0px;right:0px;width:100%;background: pink;padding:5px;width:100%">
                        Copyright © ICDS |
                        Developed by
                        <a href="https://techsseract.com/create/" target="_blank">CMP Techsseract LLP </a>.| Powered
                        by UPDESCO
                    </p>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    <script src="js/off-canvas.js"></script>
    <script src="js/hoverable-collapse.js"></script>
    <script src="js/template.js"></script>
    <script src="js/settings.js"></script>
    <script src="js/todolist.js"></script>
    <!-- endinject -->
</body>
<script>
 $("#refresh").on("click", function () {
    $("#refresh").hide();
    $('#captcha1').attr('src', '../captcha.php');
    $("#refresh").show();
    });
    
</script>

</html>