<?php session_start(); ?>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.css" integrity="sha512-0TsYUclL0x2HXTMBHTQyrsFGsELlmYZRsmq8OG1SkV6V2lRzsZoFEddMf1dsqySJIegvLmrowaeiA9HNop2dXA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.min.css" integrity="sha512-gpqtQIgLIXYBimyliA0xmgme7m5coXHQhscvqhAZcOoPlKOmEzPg2BhYIYV/d39j7fEkXh42UeVt7g5PzUtfSg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="boxed-layout">
    <style>
    .auth .login-half-bg {
        background: url(../public/images/aww-image.jpg);
        background-size: cover;
    }
    </style>
    <?php
                if(isset($_SESSION['warning'])){
                ?>
                    <script>
                    swal("Warning!", "User ID or Password is wrong!", "warning")
                    </script>
                <?php
                unset($_SESSION['warning']);
                }
                ?>
    <div class="container-scroller" style="padding: 0px;">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
                <div class="row flex-grow">
                    <div class="col-lg-6 d-flex align-items-center justify-content-center">
                        <div class="auth-form-transparent text-left p-3">
                            <div class="brand-logo">
                                <img style="margin-left: 25%;" src="../assets/img/icds.png" alt="logo">
                            </div>
                            <h4>Welcome back!</h4>
                            <h6 class="font-weight-light">Happy to see you again!</h6>
                            <h6 class="font-weight-light" style="color:green;">
                                <?php if(isset($_SESSION['logout'])) echo $_SESSION['logout']; ?></h6>
                            <form class="pt-3" method="post" action="submitLogin.php">

                                <div class="form-group">
                                    <label for="exampleInputEmail">Username</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="mdi mdi-account-outline text-primary"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="uname"
                                            class="form-control form-control-lg border-left-0" id="exampleInputEmail"
                                            placeholder="Username" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword">Password</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="mdi mdi-lock-outline text-primary"></i>
                                            </span>
                                        </div>
                                        <input type="password" name="pass"
                                            class="form-control form-control-lg border-left-0" id="exampleInputPassword"
                                            placeholder="Password" required>
                                    </div>
                                </div>
                                <div class="my-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <label class="form-check-label text-muted">
                                            <input type="checkbox" class="form-check-input">
                                            Keep me signed in
                                        </label>
                                    </div>
                                    <a href="forget_password.php" class="auth-link text-black">Forgot password?</a>
                                </div>
                                <div class="my-3">
                                    <button type="submit"
                                        class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                                        name="login">LOGIN</button>
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