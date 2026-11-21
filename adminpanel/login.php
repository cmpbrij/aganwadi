<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

session_start([
    'cookie_httponly' => true,
    'cookie_secure' => true,
    'cookie_samesite' => 'Strict'
]);
ob_start();

// cors_and_security_headers.php

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    header("Access-Control-Allow-Origin: https://upanganwadibharti.in/");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("Access-Control-Max-Age: 900");
    header("Access-Control-Allow-Credentials: true");
    exit(0);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login | ICDS | AWW Recruitment</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css">
    <!-- <link rel="stylesheet" href="vendors/css/vendor.bundle.base.css"> -->
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="css/vertical-layout-light/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="images/favicon.ico" />
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.css" integrity="sha512-0TsYUclL0x2HXTMBHTQyrsFGsELlmYZRsmq8OG1SkV6V2lRzsZoFEddMf1dsqySJIegvLmrowaeiA9HNop2dXA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.min.css" integrity="sha512-gpqtQIgLIXYBimyliA0xmgme7m5coXHQhscvqhAZcOoPlKOmEzPg2BhYIYV/d39j7fEkXh42UeVt7g5PzUtfSg==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->

    <script type="text/javascript" src="../public/css/alert/sweet-alert.min.js"></script>
    <link href="../public/css/alert/sweet-alert.css" rel="stylesheet" />
    <link href="../public/css/alert/sweet-alert.min.css" rel="stylesheet" />
</head>

<body class="boxed-layout" style="position: relative;">
    <style>
        .error {
            color: red;
        }

        .auth .login-half-bg {
            position: relative;
            overflow: hidden;
            background-size: cover;
        }

        .auth .login-half-bg::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
                url(../public/images/login-bg.jpeg) no-repeat center center;
            background-size: cover;
            filter: blur(5px);
            transform: scale(1.1);
            z-index: 1;
        }

        .auth .login-half-bg>* {
            position: relative;
            z-index: 2;
        }

        .auth form .form-group {
            margin-bottom: 0.5rem;
        }

        .container-scroller {
            position: relative;
            z-index: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container-scroller {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
        }

        .auth-form-transparent {
            background: #ffffff !important;
            padding: 40px 45px;
            border-radius: 14px;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.02);
            width: 500px !important;
            max-width: 100%;
            transition: 0.3s;
        }

        .auth-form-transparent:hover {
            box-shadow: 0 18px 45px rgba(0, 0, 0, 0.1);
        }

        .brand-logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .brand-logo img {
            height: 50px !important;
            width: 50px !important;
        }

        .auth h4 {
            font-weight: 700;
            text-align: center;
            margin-top: 10px;
        }

        .auth h6 {
            text-align: center;
            color: #6c757d;
            margin-bottom: 10px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 6px;
        }

        .input-group {
            border-radius: 8px;
            /* overflow: hidden; */
        }

        .input-group-text {
            background: #f3f6fb;
            border: 1px solid #dfe4ea;
            border-right: 0;
            color: #4e73df;
        }

        .form-control {
            height: 46px;
            border-radius: 0 8px 8px 0;
            border: 1px solid #dfe4ea;
            transition: all .25s;
            font-size: 14px;
        }

        .form-control:focus {
            border-color: #4e73df;
            box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.12);
        }

        .auth-form-btn {
            margin-top: 15px;
            height: 46px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            background: #4e73df;
            border: none;
            transition: all .3s;
        }

        .auth-form-btn:hover {
            background: #3759d7;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
        }

        .refresh {
            background: none;
            border: none;
            cursor: pointer;
        }

        .refresh i {
            font-size: 26px;
            color: #4e73df;
            transition: .3s;
        }

        .refresh i:hover {
            transform: rotate(120deg);
        }

        .form-check {
            margin-top: 0px !important;
            margin-bottom: 0px !important;
        }

        .form-check-label {
            font-size: 14px;
            color: #555;
        }

        .auth-link {
            font-size: 14px;
            color: #537eff !important;
        }

        .auth-link:hover {
            text-decoration: underline;
            color: #2559f3 !important;
        }

        .alert {
            border-radius: 8px;
            font-size: 14px;
        }

        .error {
            font-size: 13px;
        }

        p[style*="Copyright"] {
            background: #f4a9b6 !important;
            font-size: 14px;
            font-weight: 500;
        }

        @media(max-width:768px) {

            .auth-form-transparent {
                padding: 25px;
            }

        }

        .input-group-append .input-group-text,
        .input-group-prepend .input-group-text {
            border-color: #f3f3f3;
            padding: 0.9rem 0.75rem !important;
            color: #c9c8c8;
        }

        .auth form .auth-form-btn {
            height: 50px;
            line-height: 1.5;
            width: 100%;
        }

        .auth .auth-form-transparent .form-control,
        .input-group-text {
            border-color: #6c757d34 !important;
        }

        .form-control-lg {
            min-height: 0rem !important;
        }
    </style>



    <div class="container-scroller" style="padding: 0px;">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg">
                <div class="row flex-grow login-half-bg">
                    <div class="d-flex align-items-center justify-content-center login-half p-2 pb-5">
                        <div class="auth-form-transparent text-left p-4">
                            <div class="brand-logo">
                                <img src="../assets/img/icds.png" alt="logo">
                            </div>
                            <h2 class="text-center fw-semibold">Welcome Back!</h2>
                            <h6 class="font-weight-light">Authorized for Admin & DPO only</h6>
                            <h6 class="font-weight-light" style="color:green;">
                                <?php if (isset($_SESSION['logout']))
                                    echo $_SESSION['logout']; ?>
                            </h6>
                            <form method="post" autocomplete="off" action="submitLogin.php"
                                onsubmit="return encodeLogin();">
                                <!-- Add this where you want to show the warning message -->
                                <div class="text-center mb-2">
                                    <?php if (isset($_SESSION['warning'])): ?>
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <?php
                                            echo htmlspecialchars($_SESSION['warning'], ENT_QUOTES, 'UTF-8');
                                            unset($_SESSION['warning']);
                                            ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (isset($_SESSION['wpass'])): ?>
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            User name or password is wrong, Please try again!
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                        <?php unset($_SESSION['wpass']); ?>
                                    <?php endif; ?>

                                    <?php if (isset($_SESSION['cerror'])): ?>
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <?php
                                            echo htmlspecialchars($_SESSION['cerror'], ENT_QUOTES, 'UTF-8');
                                            unset($_SESSION['cerror']);
                                            ?>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="form-group">
                                    <label style="display: flex;font-weight: 700;">Enter Username<span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="mdi mdi-account-outline text-primary"></i>
                                            </span>
                                        </div>
                                        <input type="text" name="uname" id="uname"
                                            class="form-control form-control-lg border-left-0" id=""
                                            placeholder="Username" maxlength="45" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="display: flex;font-weight: 700;">Enter Password<span
                                            class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <div class="input-group-prepend bg-transparent">
                                            <span class="input-group-text bg-transparent border-right-0">
                                                <i class="mdi mdi-lock-outline text-primary"></i>
                                            </span>
                                        </div>
                                        <input type="password" name="pass" id="pass"
                                            class="form-control form-control-lg border-left-0" id="exampleInputPassword"
                                            placeholder="Password" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label style="display: flex;font-weight: 700;">Enter Captcha<span
                                            class="text-danger">*</span></label>
                                    <input name="captcha" type="text" id="captcha-input" maxlength="5" minlength="5"
                                        id="captcha-input" class="form-control num_digit" required>

                                </div>
                                <div class="form-group" style="margin: 0px !important;">
                                    <label class="btn-block">Captcha/कैप्चा</label>
                                    <!--span class="unselectable" id="p_refresh"></span-->
                                    <div class="row justify-content-between">
                                        <div class="col-sm-5">

                                            <div class="input-group">
                                                <img src="../captcha.php" id="captcha1">
                                                <input name="captchacode" type="hidden"
                                                    class="form-control captchacode unselectable h4 num_digit" value=""
                                                    readonly>
                                            </div>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" class="refresh" id="refresh" style="border:none"
                                                title="Refresh Captcha"><i class="mdi mdi-refresh"
                                                    style="font-size: 30px;"></i></button>

                                        </div>
                                        <span class="error"><?php if (isset($_SESSION['cerror'])) {
                                            echo $_SESSION['cerror'];
                                            unset($_SESSION['cerror']);
                                        } ?></span>

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
                                <div class="text-center">
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
                    <!-- <div class="col-lg-6 login-half-bg d-flex flex-row">

                    </div> -->
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
    <script>
        function encodeLogin() {
            var u = document.getElementById("uname").value;
            var p = document.getElementById("pass").value;
            // alert(u);

            // Prevent empty submission
            if (!u || !p) {
                alert("Username and password required");
                return false;
            }

            // UTF-8 safe Base64
            document.getElementById("uname").value =
                btoa(unescape(encodeURIComponent(u)));

            document.getElementById("pass").value =
                btoa(unescape(encodeURIComponent(p)));

            return true; // ✅ REQUIRED
        }
    </script>


    <script>
        $(document).ready(function () {
            function sanitizeInput(input) {
                return input.replace(/[&<>"'\/]/g, function (s) {
                    var entityMap = {
                        '&': '&amp;',
                        '<': '&lt;',
                        '>': '&gt;',
                        '"': '&quot;',
                        "'": '&#39;',
                        '/': '&#x2F;'
                    };
                    return entityMap[s];
                });
            }

            $('input').on('input', function () {

                var sanitized = sanitizeInput($(this).val());
                // alert(sanitized);
                $(this).val(sanitized);
            });
        });
    </script>
    <script>

        $("#refresh").on("click", function () {
            $("#refresh").hide();
            $('#captcha1').attr('src', '../captcha.php');
            $("#refresh").show();
        });

    </script>
    <script>
        // validation
        (function () {
            'use strict';
            window.addEventListener('load', function () {
                var forms = document.getElementsByClassName('needs-validation');
                var validation = Array.prototype.filter.call(forms, function (form) {
                    form.addEventListener('submit', function (event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        $(document).ready(function () {

            $(".alpha").keypress(function (e) {
                return /[0-9 . ,a-z A-Z@ ]/i.test(event.key);
            });
            $(".num_digit").keypress(function (e) {
                return /[0-9.]/i.test(event.key);
            });
            $(".str").keypress(function (e) {
                return /[a-z A-Z .]/i.test(event.key);
            });


        });
    </script>
</body>

</html>