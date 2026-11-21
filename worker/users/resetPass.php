<?php
  session_start();
  
?>
<!doctype html>
<!-- <html lang="en"> -->
<html>

<!-- Mirrored from apps.bhatkhandeuniversity.ac.in/student/login by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 28 Jan 2024 14:20:20 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
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
*{box-sizing:border-box}
html,body{margin:0;padding:0;width:100%;min-height:100%}
body{
    min-height:100vh;
    background:linear-gradient(135deg,#eef5f8 0%,#f8fafc 100%);
    font-family:"Segoe UI",Arial,Helvetica,sans-serif;
    color:#1f2937;
    overflow-x:hidden;
}
.screen{
    position:fixed;inset:0;display:none;align-items:center;justify-content:center;
    background:rgba(255,255,255,.65);backdrop-filter:blur(2px);z-index:99999;
}
.loader{
    width:44px;height:44px;border:3px solid #128cbc;border-top-color:#ff3d00;
    border-radius:50%;animation:rotation 1s linear infinite;
}
@keyframes rotation{to{transform:rotate(360deg)}}
.error{color:#dc3545;font-size:12px;line-height:1.35}
.succ{color:#198754;font-size:12px}

 .login-page{
    min-height:calc(100vh - 44px);
    display:flex;
    align-items:flex-start;
    justify-content:center;
    padding:16px 15px 18px;
}
.login-card{
    width:100%;
    max-width:570px;
    background:#fff;
    border:1px solid #e3edf2;
    border-radius:20px;
    padding:20px 30px 22px;
    box-shadow:0 12px 35px rgba(31,72,91,.12);
}
.logo-area{
    width:100%;height:82px;display:flex;align-items:center;justify-content:center;
    gap:24px;padding:8px 20px;margin-bottom:13px;
    background:linear-gradient(135deg,#f1f9fc 0%,#f8fbfd 100%);
    border:1px solid #d9edf4;border-radius:13px;
}
.logo-area img{
    width:auto;height:58px;max-width:110px;object-fit:contain;display:block;
}
.page-title{
    margin:0;text-align:center;color:#12263a;font-size:23px;
    line-height:1.25;font-weight:750;
}
.page-subtitle{
    margin:5px 0 0;text-align:center;color:#667085;font-size:14px;line-height:1.4;
}
.divider{
    width:55px;height:3px;border-radius:10px;background:#128cbc;margin:10px auto 15px;
}
.form-heading{text-align:center;margin-bottom:14px}
.form-heading h3{
    margin:0 0 5px;color:#128cbc;font-size:25px;line-height:1.2;font-weight:800;
}
.form-heading p{margin:0;color:#555f6d;font-size:14px;line-height:1.45}
.form-heading a{color:#128cbc;text-decoration:none}
.form-group{margin-bottom:12px!important}
.form-label{
    display:block;margin:0 0 6px;color:#273444;font-size:14px;
    line-height:1.35;font-weight:700;
}
.form-control{
    width:100%;height:45px;min-height:45px;
    border:1px solid #d4dee5!important;border-radius:9px!important;
    background:#fff;color:#202b36;padding:9px 13px;font-size:15px;
    box-shadow:none!important;outline:none;
}
.form-control:focus{
    border-color:#128cbc!important;
    box-shadow:0 0 0 3px rgba(18,140,188,.10)!important;
}
.password-wrap{position:relative}
.password-wrap .form-control{padding-right:44px}
.toggle-password{
    position:absolute;right:13px;top:50%;transform:translateY(-50%);
    color:#7b8794;cursor:pointer;z-index:2;
}
.captcha-row{
    display:grid;grid-template-columns:minmax(0,1fr) 45px minmax(0,1.18fr);
    align-items:end;gap:10px;
}
.captcha-box,.captcha-input-box{min-width:0}
.captcha-image-wrap{
    width:100%;
    height:52px;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:4px 8px;
    overflow:hidden;
    background:#f8fafc;
    border:1px solid #d4dee5;
    border-radius:9px;
}
#captcha{
    display:block;
    width:auto;
    max-width:100%;
    height:44px;
    min-height:44px;
    object-fit:contain;
}
.refresh{
    width:45px;
    height:52px;
    display:flex;
    align-items:center;
    justify-content:center;
}
.refresh a{
    width:40px;
    height:40px;
    display:flex;
    align-items:center;
    justify-content:center;
    border-radius:50%;
    background:#128cbc;
    color:#fff!important;
    text-decoration:none;
    cursor:pointer;
    box-shadow:0 5px 12px rgba(18,140,188,.20);
    transition:transform .25s ease,background .25s ease;
}
.refresh a:hover{background:#0b7098;transform:rotate(180deg)}
.message-area{min-height:8px;margin:-2px 0 5px}
.message-area .error{display:block;font-size:12px}
.cstm-btn{
    display:flex;
    align-items:center;
    justify-content:center;
    width:100%;
    height:45px;
    min-height:45px;
    margin-top:2px;
    border:0!important;border-radius:9px!important;background:#128cbc!important;
    color:#fff!important;font-size:15px;font-weight:700;
    box-shadow:0 6px 15px rgba(18,140,188,.20);
    transition:transform .2s ease,background .2s ease;
}
.cstm-btn:hover{background:#0b7098!important;transform:translateY(-1px)}
footer{
    min-height:44px;width:100%;display:flex;align-items:center;justify-content:center;
    padding:7px 15px;background:#fff;border-top:1px solid #e5e7eb;
}
.copyright{text-align:center;color:#667085;font-size:11px;line-height:1.5}
.copyright a{color:#128cbc;text-decoration:none;font-weight:700}
.loginImg,.loginsidebar,.deptname,.leftTitle,.leftSubtitle,.pos02,.ums-name{display:none!important}

@media(max-width:767px){
    .login-page{
        min-height:calc(100vh - 44px);
        padding:10px 10px 14px;
        align-items:flex-start;
    }
    .login-card{
        max-width:100%;
        padding:16px 17px 18px;
        border-radius:16px;
    }
    .logo-area{height:76px;gap:18px;padding:7px 15px;margin-bottom:11px}
    .logo-area img{height:53px;max-width:100px}
    .page-title{font-size:20px}
    .page-subtitle{font-size:13px}
    .divider{margin:11px auto 17px}
    .form-heading{margin-bottom:16px}
    .form-heading h3{font-size:23px}
    .form-heading p{font-size:13px}
    .captcha-row{grid-template-columns:minmax(0,1fr) 43px;gap:8px}
    .captcha-input-box{grid-column:1/-1}
    .captcha-image-wrap{height:50px}
    #captcha{height:42px;min-height:42px}
    .refresh{width:43px;height:50px}
    .refresh a{width:38px;height:38px}
}
@media(max-width:400px){
    .login-card{padding:16px 13px 18px}
    .logo-area{height:76px;gap:14px}
    .logo-area img{height:53px;max-width:95px}
    .page-title{font-size:18px}
}
</style></head>
   <body>
   <?php
      if(isset($_SESSION['success'])){
      ?>
        <script>
         swal("Success!", "आपने सफलतापूर्वक पंजीकरण कर लिया|", "success")
          </script>
      <?php
      unset($_SESSION['nototp']);
      }
    ?>

<?php
      if(isset($_SESSION['r_wrong'])){
      ?>
        <script>
         swal("Wrong!", "आपके द्वारा दर्ज  किया गया मोबाइल नंबर अमान्य है!", "warning")
          </script>
      <?php
      unset($_SESSION['r_wrong']);
      }
    ?>
<div class="login-page">

    <div class="login-card">

        <div class="logo-area">
            <img src="../public/images/upgovt_logo.svg" alt="Logo 1">
            <img src="../public/images/ICDS_1.svg" alt="ICDS Logo">
        </div>

        <h1 class="page-title">Anganwadi Worker Recruitment</h1>
        <p class="page-subtitle">Uttar Pradesh, Lucknow</p>
        <div class="divider"></div>

        <div class="form-heading">
            <h3>Reset Password</h3>
            <p>
                Don’t have an Account?/अकाउंट नहीं है?
                <a href="registration.php" class="fw-bold">
                    Click to Register/पंजीकरण हेतु क्लिक करें
                </a>
            </p>
        </div>

        <form action="submit_login.php"
              method="post"
              class="needs-validation"
              novalidate>

            <input type="hidden"
                   name="_token"
                   value="O9mUTOIwJ98dHE8ncyPuGeXHGQNe6Ctjpf9lCdBX">

            <div class="form-group">
                <label for="user_id" class="form-label">
                    Mobile No./मोबाइल नंबर <span class="text-danger">*</span>
                </label>
                <input type="text"
                       class="form-control num_digit"
                       name="user_id"
                       id="user_id"
                       maxlength="10"
                       minlength="10"
                       inputmode="numeric"
                       required>
            </div>

            <div class="form-group">
                <label for="password" class="form-label">
                    New Password <span class="text-danger">*</span>
                </label>

                <div class="password-wrap">
                    <input type="password"
                           class="form-control"
                           name="pass"
                           id="password"
                           maxlength="12"
                           minlength="6"
                           required>

                    <span class="fa fa-fw fa-eye toggle-password"
                          toggle="#password"
                          title="Show/Hide Password"></span>
                </div>
            </div>

            <div class="form-group">
                <div class="captcha-row">

                    <div class="captcha-box">
                        <label class="form-label">
                            Captcha/कैप्चा
                        </label>

                        <div class="captcha-image-wrap">
                            <img src="../captcha.php"
                                 alt="Captcha"
                                 title="Captcha"
                                 id="captcha">
                        </div>

                        <input name="captchacode"
                               type="hidden"
                               class="form-control captchacode unselectable h4"
                               value=""
                               readonly>
                    </div>

                    <div class="refresh">
                        <a href="javascript:void(0);"
                           onclick="refreshCaptcha();"
                           title="Refresh Captcha"
                           id="refreshCaptcha">
                            <span class="fas fa-redo"></span>
                        </a>
                    </div>

                    <div class="captcha-input-box">
                        <label class="form-label">
                            Enter Captcha/कैप्चा भरें
                            <span class="text-danger">*</span>
                        </label>

                        <input name="captcha"
                               type="text"
                               maxlength="5"
                               id="captcha-input"
                               class="form-control num_digit"
                               placeholder="Enter Captcha"
                               required>
                    </div>

                </div>
            </div>

            <div class="message-area">
                <span class="error">
                    <?php
                    if(isset($_SESSION['cerror'])){
                        echo $_SESSION['cerror'];
                        unset($_SESSION['cerror']);
                    }
                    ?>
                </span>

                <span class="error">
                    <?php
                    if(isset($_SESSION['msg'])){
                        echo $_SESSION['msg'];
                        unset($_SESSION['msg']);
                    }
                    ?>
                </span>
            </div>

            <div class="d-grid">
                <button class="cstm-btn btn"
                        type="submit"
                        name="reset_pass">
                    Reset
                </button>
            </div>

        </form>

    </div>

</div>

    <footer>
    <div class="copyright">
        Copyright © ICDS |
        Developed by
        <a href="https://techsseract.com" target="_blank">
            CMP Techsseract LLP
        </a>
        | Powered by UPDESCO
    </div>
</footer>


 

    <script type="text/javascript">
function refreshCaptcha() {
    var captcha = document.getElementById('captcha');

    if (captcha) {
        captcha.src = '../captcha.php?refresh=' + new Date().getTime();
    }

    var input = document.getElementById('captcha-input');

    if (input) {
        input.value = '';
        input.focus();
    }
}
</script>

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
<style>
.login-card,
.login-card form,
.d-grid {
    overflow: visible !important;
}

.cstm-btn {
    position: relative;
    z-index: 2;
}
</style>
