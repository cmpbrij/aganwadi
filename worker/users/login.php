<?php
  session_start();
  
?>
<!doctype html>
<!-- <html lang="en"> -->
<html>

<!-- Mirrored from apps.bhatkhandeuniversity.ac.in/student/login by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 28 Jan 2024 14:20:20 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
<?php 
    header("X-XSS-Protection: 1; mode=block");
    header("X-Content-Type-Options: nosniff");
    header("X-Frame-Options: SAMEORIGIN");

  ?>
    <title>Login : Anganwadi Recruitment, Uttar Pradesh</title>
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
    .error{
      color: red;
    }
    .succ{
      color:green;
    }
.loader {
  width: 48px ;
  height: 48px;
  border: 2px solid #128cbc;
  border-radius: 50%;
  display: inline-block;
  position: absolute ;
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

@keyframes  rotation {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
.screen{
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
.auth .login-half-bg {
  background: url(../public/images/aww-image.jpg);
    background-size: cover;
}
  
/* =========================================================
   RESPONSIVE UI IMPROVEMENTS
   PHP / form logic / session alerts are intentionally untouched.
   These styles only improve layout, spacing, images and responsiveness.
   ========================================================= */

html, body {
    width: 100%;
    min-height: 100%;
    margin: 0;
    padding: 0;
    overflow-x: hidden;
    background: #f5f7fb;
}

body {
    font-family: Arial, Helvetica, sans-serif;
}

.container-fluid {
    padding: 0 !important;
}

.container-fluid > .row {
    min-height: calc(100vh - 52px);
    margin: 0 !important;
}

/* Left image/banner area */
.loginsidebar {
    width: 58.333333%;
    min-height: calc(100vh - 52px);
    padding: 0 !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    position: relative !important;
    overflow: hidden !important;
    background: #fff !important;
    border-right: 1px solid #e5e7eb;
}

.loginsidebar .banner-img {
    width: 100%;
    height: 100%;
    min-height: calc(100vh - 52px);
    object-fit: cover !important;
    object-position: center center !important;
    display: block;
}

/* Keep the existing title/content positioned cleanly over the image */
.loginsidebar > .row {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    margin: 0 !important;
    display: flex;
    align-items: flex-end !important;
    justify-content: center !important;
    pointer-events: none;
}

.loginsidebar .deptname {
    width: 100%;
    margin: 0 0 45px !important;
    padding: 0 20px;
    text-align: center !important;
}

.loginsidebar .leftTitle {
    display: inline-block;
    margin: 0 0 8px !important;
    padding: 10px 18px;
    border-radius: 8px;
    background: rgba(255,255,255,.90);
    color: #111827 !important;
    font-size: clamp(20px, 2.2vw, 30px) !important;
    font-weight: 800 !important;
    box-shadow: 0 6px 20px rgba(0,0,0,.12);
}

.loginsidebar .deptname h3 {
    margin: 0 !important;
    font-size: clamp(16px, 1.6vw, 24px) !important;
    line-height: 1.4;
    color: #111827 !important;
    text-shadow: 0 1px 3px rgba(255,255,255,.8);
}

/* Existing department/logo images */
.loginsidebar > .row > .col-3 {
    position: absolute;
    top: 20px;
    left: 20px;
    width: 95px !important;
    max-width: 95px !important;
    padding: 0 !important;
    margin: 0 !important;
}

.loginsidebar > .row > .col-3:nth-child(2) {
    left: 125px;
}

.loginsidebar > .row > .col-3 img {
    position: static !important;
    width: 100% !important;
    max-height: 78px;
    object-fit: contain;
    padding: 8px;
}

/* Right login area */
.loginsidebar + .col {
    width: 41.666667%;
    min-height: calc(100vh - 52px);
    padding: 0 !important;
    background: #fff;
}

.login-form {
    width: 100%;
    max-width: 620px;
    min-height: calc(100vh - 52px);
    margin: 0 auto;
    padding: 45px clamp(22px, 4vw, 65px) 35px !important;
    justify-content: center !important;
    align-items: stretch !important;
}

.login-form > div:first-child {
    margin-bottom: 20px !important;
}

.login-form h3 {
    color: #172033;
    line-height: 1.25;
    font-size: clamp(24px, 2.3vw, 32px) !important;
}

.login-form .form-group {
    width: 100%;
}

.login-form label {
    color: #273449;
    margin-bottom: 7px;
    font-size: 15px;
}

.login-form .form-control {
    min-height: 48px;
    border: 1px solid #d6dbe4;
    border-radius: 8px;
    padding: 10px 14px;
    font-size: 16px;
    box-shadow: none;
    transition: border-color .2s ease, box-shadow .2s ease;
}

.login-form .form-control:focus {
    border-color: #128cbc;
    box-shadow: 0 0 0 3px rgba(18,140,188,.12);
}

/* Captcha section */
.login-form .captcha img#captcha {
    width: 100%;
    max-width: 180px;
    height: 52px;
    object-fit: contain;
    object-position: left center;
    border: 1px solid #d9dee7;
    border-radius: 7px;
    background: #fff;
    display: block;
}

.login-form .refresh {
    min-height: 52px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.login-form .refresh a {
    width: 42px !important;
    height: 42px !important;
    min-width: 42px;
    border-radius: 50% !important;
    display: inline-flex !important;
    align-items: center !important;
    justify-content: center !important;
    padding: 0 !important;
    margin: 0 !important;
    background: #eef7fb !important;
    color: #128cbc !important;
    border: 1px solid #cde8f2;
    cursor: pointer;
    text-decoration: none !important;
    transition: background .2s ease, color .2s ease, transform .35s ease;
}

.login-form .refresh a:hover {
    background: #128cbc !important;
    color: #fff !important;
    border-color: #128cbc;
    transform: rotate(180deg);
}

.login-form #captcha-input {
    height: 52px;
}

.login-form .error {
    display: block;
    margin-top: 5px;
    font-size: 13px;
}

.login-form form > .form-group {
    margin-bottom: 18px !important;
}

/* Reset password links */
.login-form form a {
    color: #087da9;
    text-decoration: none;
}

.login-form form a:hover {
    text-decoration: underline;
}

/* Login button */
.login-form .cstm-btn {
    width: 100%;
    min-height: 50px;
    border: 0;
    border-radius: 8px;
    font-size: 17px;
    font-weight: 700;
    color: #fff;
    background: linear-gradient(135deg, #128cbc, #075b80);
    box-shadow: 0 7px 18px rgba(18,140,188,.22);
    transition: transform .2s ease, box-shadow .2s ease;
}

.login-form .cstm-btn:hover {
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 10px 22px rgba(18,140,188,.30);
}

/* Footer */
footer {
    min-height: 52px;
    background: #172033;
    color: #fff;
    padding: 12px 25px;
}

footer .row {
    margin: 0 !important;
    align-items: center;
}

footer .foot-list {
    margin: 0;
    padding: 0;
    list-style: none;
}

footer .copyright {
    text-align: center;
    font-size: 13px;
    line-height: 1.5;
}

footer a {
    color: #fff;
    text-decoration: none;
}

/* Existing loading screen */
.screen {
    justify-content: center !important;
    background: rgba(255,255,255,.45);
}

/* Tablets */
@media (max-width: 991.98px) {
    .container-fluid > .row {
        min-height: auto;
    }

    .loginsidebar {
        width: 50%;
        min-height: 560px;
    }

    .loginsidebar .banner-img {
        min-height: 560px;
    }

    .loginsidebar + .col {
        width: 50%;
        min-height: 560px;
    }

    .login-form {
        min-height: 560px;
        padding: 35px 28px !important;
    }

    .loginsidebar .deptname {
        margin-bottom: 35px !important;
    }

    .loginsidebar > .row > .col-3 {
        top: 15px;
        left: 15px;
        width: 75px !important;
        max-width: 75px !important;
    }

    .loginsidebar > .row > .col-3:nth-child(2) {
        left: 100px;
    }

    .login-form .captcha img#captcha {
        max-width: 150px;
    }
}

/* Mobile */
@media (max-width: 767.98px) {
    .container-fluid > .row {
        display: flex;
        flex-direction: column;
        min-height: auto;
    }

    .loginsidebar {
        width: 100%;
        min-height: 285px;
        height: 285px;
        position: relative !important;
        border-right: 0;
        border-bottom: 1px solid #e5e7eb;
    }

    .loginsidebar .banner-img {
        width: 100%;
        height: 285px;
        min-height: 285px;
        object-fit: cover !important;
        object-position: center center !important;
    }

    .loginsidebar .deptname {
        margin: 0 10px 18px !important;
        padding: 0 8px;
    }

    .loginsidebar .leftTitle {
        font-size: 18px !important;
        padding: 7px 12px;
        margin-bottom: 5px !important;
    }

    .loginsidebar .deptname h3 {
        font-size: 14px !important;
    }

    .loginsidebar > .row > .col-3 {
        top: 10px;
        left: 10px;
        width: 58px !important;
        max-width: 58px !important;
    }

    .loginsidebar > .row > .col-3:nth-child(2) {
        left: 78px;
    }

    .loginsidebar > .row > .col-3 img {
        max-height: 52px;
        padding: 4px;
    }

    .loginsidebar + .col {
        width: 100%;
        min-height: auto;
    }

    .login-form {
        min-height: auto;
        max-width: 100%;
        padding: 30px 20px 28px !important;
    }

    .login-form h3 {
        font-size: 23px !important;
    }

    .login-form .text-center {
        margin-bottom: 8px !important;
    }

    .login-form form {
        margin-top: 12px !important;
    }

    .login-form .form-control {
        min-height: 46px;
        font-size: 15px;
    }

    .login-form .captcha img#captcha {
        max-width: 100%;
        width: 100%;
        height: 50px;
    }

    .login-form .refresh {
        min-height: 50px;
    }

    .login-form .refresh a {
        width: 36px !important;
        height: 36px !important;
        min-width: 36px;
        border-radius: 50% !important;
    }

    .login-form #captcha-input {
        height: 50px;
    }

    .login-form .row > .col-md-5,
    .login-form .row > .col-md-6 {
        margin-bottom: 12px;
    }

    footer {
        min-height: auto;
        padding: 10px 15px;
    }

    footer .copyright {
        font-size: 11px;
    }
}

/* Small mobile */
@media (max-width: 420px) {
    .loginsidebar {
        min-height: 245px;
        height: 245px;
    }

    .loginsidebar .banner-img {
        height: 245px;
        min-height: 245px;
    }

    .loginsidebar .leftTitle {
        font-size: 16px !important;
    }

    .loginsidebar .deptname h3 {
        font-size: 13px !important;
    }

    .login-form {
        padding: 24px 16px 22px !important;
    }

    .login-form h3 {
        font-size: 21px !important;
    }

    .login-form .form-control {
        min-height: 44px;
    }

    footer .copyright {
        font-size: 10px;
    }
}

/* Prevent accidental horizontal overflow from old inline styles */
img {
    max-width: 100%;
}

  
/* ===== Final height fix: fit login page to viewport without page scrolling ===== */

html, body {
    height: 100%;
    min-height: 100%;
    margin: 0;
    padding: 0;
    overflow: hidden !important;
}

body {
    display: flex;
    flex-direction: column;
}

.container-fluid {
    flex: 1 1 auto;
    height: calc(100vh - 52px);
    min-height: 0 !important;
    overflow: hidden;
}

.container-fluid > .row {
    height: 100%;
    min-height: 0 !important;
    margin: 0 !important;
}

.loginsidebar {
    height: 100%;
    min-height: 0 !important;
    max-height: 100%;
}

.loginsidebar .banner-img {
    height: 100%;
    min-height: 0 !important;
    max-height: 100%;
    object-fit: cover !important;
}

.loginsidebar > .row {
    height: 100%;
    max-height: 100%;
}

.loginsidebar .deptname {
    margin-bottom: 25px !important;
}

.loginsidebar + .col {
    height: 100%;
    min-height: 0 !important;
    max-height: 100%;
    overflow: hidden;
}

.login-form {
    height: 100%;
    min-height: 0 !important;
    max-height: 100%;
    overflow-y: auto;
    overflow-x: hidden;
    padding: 22px clamp(20px, 3vw, 55px) 20px !important;
    box-sizing: border-box;
}

/* Keep the form compact enough for normal desktop heights */
.login-form > div:first-child {
    margin-bottom: 8px !important;
}

.login-form h3 {
    margin-bottom: 4px !important;
}

.login-form form {
    margin-top: 12px !important;
}

.login-form .form-group {
    margin-bottom: 10px !important;
}

.login-form .form-control {
    min-height: 43px;
    height: 43px;
}

.login-form #captcha-input {
    height: 46px;
}

.login-form .captcha img#captcha {
    height: 46px;
}

.login-form .refresh {
    min-height: 46px;
}

.login-form .refresh a {
    width: 38px !important;
    height: 38px !important;
    min-width: 38px;
    border-radius: 50% !important;
}

.login-form .cstm-btn {
    min-height: 45px;
}

.login-form .d-grid.mb-3 {
    margin-bottom: 8px !important;
}

footer {
    flex: 0 0 52px;
    height: 52px;
    min-height: 52px !important;
    box-sizing: border-box;
}

/* Short desktop/laptop screens */
@media (max-height: 750px) and (min-width: 768px) {
    .container-fluid {
        height: calc(100vh - 46px);
    }

    .login-form {
        padding-top: 12px !important;
        padding-bottom: 10px !important;
    }

    .login-form > div:first-child {
        margin-bottom: 3px !important;
    }

    .login-form h3 {
        font-size: 24px !important;
    }

    .login-form form {
        margin-top: 7px !important;
    }

    .login-form .form-group {
        margin-bottom: 7px !important;
    }

    .login-form label {
        margin-bottom: 3px;
        font-size: 13px;
    }

    .login-form .form-control {
        min-height: 38px;
        height: 38px;
        padding: 6px 10px;
    }

    .login-form .captcha img#captcha {
        height: 40px;
    }

    .login-form .refresh {
        min-height: 40px;
    }

    .login-form .refresh a {
        width: 34px !important;
        height: 34px !important;
        min-width: 34px;
    }

    .login-form #captcha-input {
        height: 40px;
    }

    .login-form .cstm-btn {
        min-height: 40px;
    }

    .loginsidebar .deptname {
        margin-bottom: 15px !important;
    }

    footer {
        flex-basis: 46px;
        height: 46px;
        min-height: 46px !important;
        padding: 8px 15px !important;
    }
}

/* Mobile: natural vertical flow, because the complete form needs more than one viewport */
@media (max-width: 767.98px) {
    html, body {
        height: auto;
        min-height: 100%;
        overflow-x: hidden !important;
        overflow-y: auto !important;
    }

    body {
        display: block;
    }

    .container-fluid {
        height: auto;
        min-height: 0 !important;
        overflow: visible;
    }

    .container-fluid > .row {
        height: auto;
        min-height: 0 !important;
    }

    .loginsidebar {
        height: 245px;
        min-height: 245px !important;
        max-height: 245px;
    }

    .loginsidebar .banner-img {
        height: 245px;
        min-height: 245px !important;
        max-height: 245px;
    }

    .loginsidebar + .col {
        height: auto;
        min-height: 0 !important;
        max-height: none;
        overflow: visible;
    }

    .login-form {
        height: auto;
        min-height: 0 !important;
        max-height: none;
        overflow: visible;
        padding: 24px 16px !important;
    }

    footer {
        height: auto;
        min-height: 0 !important;
    }
}

</style>
</head>
   <body>
   
   <?php
      if(isset($_SESSION['regsuccess'])){
      ?>
        <script>
         swal("Success!", "आपने सफलतापूर्वक पंजीकरण कर लिया|", "success")
          </script>
      <?php
      unset($_SESSION['regsuccess']);
      }
    ?>

<?php
      if(isset($_SESSION['resetsucc'])){
      ?>
        <script>
         swal("Success!", "Password reset successfully!", "success")
          </script>
      <?php
      unset($_SESSION['resetsucc']);
      }
    ?>

<?php
      if(isset($_SESSION['errorlogin'])){
      ?>
        <script>
         swal("Wrong !", "आपके द्वारा दर्ज  किया गया मोबाइल नंबर अमान्य है!", "warning")
          </script>
      <?php
      unset($_SESSION['errorlogin']);
      }
    ?>

<?php
      if(isset($_SESSION['errorpass'])){
      ?>
        <script>
         swal("Wrong !", "आपके द्वारा दर्ज  किया गया पासवर्ड अमान्य है!", "warning")
          </script>
      <?php
      unset($_SESSION['errorpass']);
      }
    ?>

<?php
      if(isset($_SESSION['Lmsg'])){
      ?>
        <script>
         swal("Wrong !", "To many failed login attempts. Please login after 1 hours", "warning")
          </script>
      <?php
      unset($_SESSION['Lmsg']);
      }
    ?>
   <div class="container-fluid">
   <!-- <a href="#" title="Instruction" class="help" data-bs-toggle="modal" data-bs-target="#myModal"> -->
   </span class="item">
      <!-- <img src="../public/images/instruction.png" //> -->
      <!-- </span> -->
      <!-- <div class="circle" style="animation-delay: 0s"></div>
      <div class="circle" style="animation-delay: 1s"></div>
      <div class="circle" style="animation-delay: 2s"></div>
      <div class="circle" style="animation-delay: 3s"></div> -->
   <!-- </a> -->
   <div class="row">
   <div class="col-md-8 loginsidebar" style="display: flex;align-items: center;justify-content: center;object-fit: cover;overflow: hidden;position: sticky;top:0px;background:white;">
                <img src="../public/images/img2.png"
                 class="banner-img img-fluid"
                 alt="Anganwadi Recruitment">
                <div class="row justify-content-center align-items-center">
                    <div class="col-3 col-lg-3">
                        <img src="../public/images/images.png" class="img-fluid" style="filter: invert(1); position:  absolute;top: -3px; width:15%;" />
                    </div>
                    <div class="col-3 col-lg-3" style="margin-left: 10px;">
                        <img src="../public/images/icds.png" class="img-fluid" style="filter: invert(1); position:  absolute;top: -3px; width:15%;" />
                    </div>
                    <div class="deptname" style="text-align: center; margin-bottom:285px; ">
                        <h5 class="leftTitle">Anganwadi Recruitment 2026</h5>
                        <h3 style="color: black !important;font-weight: 800 !important; font-size: 24px; ">Uttar Pradesh, Lucknow</h3>
                        <h4 class="ums-name"></h4>
                        <!-- <img class="img-resp pos01" src="../public/images/output01.png" /> -->
                        
                    </div>
                </div>
            </div>
      
            <div class="col">
                <div class="p-3 p-lg-3 login-form d-flex flex-column justify-content-center align-items-center">
                  <div class="text-center text-md-center  mt-md-0">
                    <h3 class="mb-0" style="font-size: 30px;font-weight: 800;">Worker Applicant Login</h3>
                    <div class="d-flex justify-content-center align-items-center mt-2">                        
                        <span class="fw-normal">Don’t have an Account?/अकाउंट नहीं है? <br> <a href="registration.php" class="fw-bold">Click to Register/पंजीकरण हेतु क्लिक करें</a>
					
                        </span>
                        
                    </div> 
                    
                  </div>
                  <form action="submit_login.php" method="post"  class="mt-4 needs-validation" novalidate>
                    <input type="hidden" name="_token" value="O9mUTOIwJ98dHE8ncyPuGeXHGQNe6Ctjpf9lCdBX"> 
                    <div class="form-group mb-3">
                        <label for="user_id" style="display: flex;font-weight: 700;">Mobile No./मोबाइल नंबर<span class="text-danger">*</span></label>
                       <input type="text" class="form-control num_digit"  name="user_id" maxlength="10" minlength="10" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="user_id" style="display: flex;font-weight: 700;">Password/पासवर्ड <span class="text-danger">*</span></label>
                       <input type="password" class="form-control"  name="pass" maxlength="14" minlength="6" autocomplete="off" required>
                    </div>
                    <span class="error"><?php if(isset($_SESSION['lmsg'])){ echo $_SESSION['lmsg']; unset($_SESSION['lmsg']);} ?></span>
                   <!-- <div class="form-group mb-4">
                        <label for="password-field" style="display: flex;font-weight: 700;">Password/पासवर्ड<span class="text-danger">*</span></label>
                      <input type="password"  class="form-control" id="password-field" maxlength="30" name="password" required="">
                       <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                    
                    </div>                    -->
                       <div class="form-group">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-5 col-10">
                                    <div class="captcha">
                                        <label class="btn-block">Captcha/कैप्चा</label>
									<!--span class="unselectable" id="p_refresh"></span-->
										                  <img src="../captcha.php" alt="Captcha" title="Captcha" id="captcha">
                                        <input name="captchacode" type="hidden" class="form-control captchacode unselectable h4" value="" readonly>
										
                                    </div>
                                    <span class="error"><?php if(isset($_SESSION['cerror'])){ echo $_SESSION['cerror']; unset($_SESSION['cerror']);} ?></span>
                                </div>
                               
                                <div class="col-md-1 col-2">
                                    <div class="refresh"><a onClick="refreshCaptcha();" title="Refresh Captcha"><span class="fas fa-redo" id="refreshCaptcha"></span></a></div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label style="display: flex;font-weight: 700;">Enter Captcha/कैप्चा भरें<span class="text-danger">*</span></label>
                                    <input name="captcha" type="text"  maxlength="5" minlength="5" id="captcha-input" class="form-control num_digit" placeholder="Enter Captcha" required>
                                  </div>
                                  <br>
                                  <span><a href="resetPass.php">Reset Password</a></span>
                               
                            </div>
                            
                        </div>
                       
						
                        <div class="clearfix"></div>                       
                    </div>
					
                    <div class="d-grid mb-3"> 
                        <button class="cstm-btn btn" type="submit" name="login_submit">Login/लॉगिन करें</button></div>
                    <div class="clearfix"></div>
                      <div class="d-flex justify-content-sm-center align-items-top"> 
                      <!-- <span class="fw-normal"><a href="forgot-password.html" class="fw-bold">Forgot Password?/पासवर्ड भूल गए?</a> -->
                    </div>
                 
                     
                  </form>
                </div>
              </div>
              <script type="text/javascript">
                  function refreshCaptcha() {
                       var captcha = document.getElementById('captcha');

                       if (captcha) {
                           var baseUrl = '../captcha.php';
                           var separator = baseUrl.indexOf('?') === -1 ? '?' : '&';

                           // Force browser to request a fresh captcha.
                           captcha.src = baseUrl + separator + '_=' + new Date().getTime();
                       }

                       return false;
                  }
              </script>
        
     </div>
        </div>
    </div>
    <footer>
        <div class="row">
            <div class="col-md-9">
                <ul class="foot-list">
                    <li><div class="copyright">
                    Copyright © ICDS | Developed by <a href="https://techsseract.com" taget="_blank">CMP Techsseract LLP
                    </a> | Powered by UPDESCO
                </div></li>
                </ul>
            </div>
            <div class="col-md-3">
                <ul class="foot-list">
                    <!-- <li>Powered by <a href="#" target="_blank"></a></li> -->
                </ul>
            </div>
        </div>
    </footer>


 

    <script type="text/javascript">
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      </script>
<script type="text/javascript" src="../public/js/bootstrap.js"></script>

<script type="text/javascript" src="../public/js/select2.min.js"></script>
<script type="text/javascript" src="../public/js/js_latest_toastr.min.js"></script>  
<script>

    $(".toggle-password").click(function () {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });

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

$(document).ready(function () {

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
function success(msg)
{
 toastr.options = {
 "closeButton": false,
 "debug": false,
 "newestOnTop": true,
 "progressBar": true,
 "positionClass": "toast-top-right",
 "preventDuplicates": false,
 "showDuration": "300",
 "hideDuration": "1000",
 "timeOut": "3000",
 "extendedTimeOut": "1000",
 "showEasing": "swing",
 "hideEasing": "linear",
 "showMethod": "fadeIn",
 "hideMethod": "fadeOut"
}
 toastr.success(msg);   
}
function error(msg)
{
 toastr.options = {
 "closeButton": false,
 "debug": false,
 "newestOnTop": true,
 "progressBar": true,
 "positionClass": "toast-top-right",
 "preventDuplicates": false,
 "showDuration": "300",
 "hideDuration": "2000",
 "timeOut": "3000",
 "extendedTimeOut": "1000",
 "showEasing": "swing",
 "hideEasing": "linear",
 "showMethod": "fadeIn",
 "hideMethod": "fadeOut"
}
 toastr.error(msg)
}

$(document)
    .ajaxStart(function () {
       $(".screen").show();
    })
    .ajaxStop(function () {
      $(".screen").hide();
    });
 </script>  
  <div class="modal fade" id="query_form_reply" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabels" aria-hidden="true">
    <div class="modal-dialog modal-lg" id="prodiv" style="max-width: 1020px;">
        <div class="modal-content" id="query_form_reply_append">
            
        </div>
    </div>
</div>

 
</body>

<!-- Mirrored from apps.bhatkhandeuniversity.ac.in/student/login by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 28 Jan 2024 14:20:21 GMT -->
</html>