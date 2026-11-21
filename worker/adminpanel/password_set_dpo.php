<?php session_start();
if(!isset($_SESSION['otp-set-dpo']) && !isset($_SESSION['forgotpass'])){
    echo"Can't Access";
    die;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Dashboard | ICDS | Forgot Password</title>
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
                            <form class="pt-3" method="post" action="submitLogin.php">

                                <div class="form-group">
                                    <label for="exampleInputEmail">Set New Password</label>
                                    <div class="input-group">
                                       
                                        <input type="text" name="pass"
                                            class="form-control form-control-lg border-left-0" id="exampleInputEmail"
                                            placeholder="Please enter new password" required>
                                    </div>
                                </div>
                                
                               
                                <div class="my-3">
                                    <button type="submit" id="login"
                                        class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                                        name="update_dpo_pass">Updated</button>
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

</html>