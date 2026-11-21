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
  </style>
</head>
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
                <img src="../public/images/aww-image.jpg" alt="" style=" width:100%; height:60%; object-fit: cover; position: absolute;top: 250px;">
                <div class="row justify-content-center align-items-center">
                    <div class="col-3 col-lg-3">
                        <img src="../public/images/images.png" class="img-fluid" style="filter: invert(1); position:  absolute;top: -3px; width:15%;" />
                    </div>
                    <div class="col-3 col-lg-3" style="margin-left: 10px;">
                        <img src="../public/images/icds.png" class="img-fluid" style="filter: invert(1); position:  absolute;top: -3px; width:15%;" />
                    </div>
                    <div class="deptname" style="text-align: center; margin-bottom:285px; ">
                        <h5 class="leftTitle">Anganwadi Recruitment 2024</h5>
                        <h3 style="color: black !important;font-weight: 800 !important; font-size: 24px; ">Uttar Pradesh, Lucknow</h3>
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
      
            <div class="col">
                <div class="p-4 p-lg-3 login-form d-flex flex-column justify-content-center align-items-center">
                  <div class="text-center text-md-center mb-4 mt-md-0">
                    <h3 class="mb-0" style="font-size: 30px;font-weight: 800;">Reset Password</h3>
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
                        <label for="user_id" style="display: flex;font-weight: 700;">New Password<span class="text-danger">*</span></label>
                       <input type="password" class="form-control"  name="pass" maxlength="12" minlength="6" required>
                    </div>
                 
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
                                    <input name="captcha" type="text"  maxlength="5" id="captcha-input" class="form-control num_digit" placeholder="Enter Captcha" required>
                                  </div>
                                  <br>
                                  <!-- <span><a href="resetPass.php">Reset Password</a></span> -->
                               
                            </div>
                            
                        </div>
                        <div class="col-12"> <span class="error"><?php if(isset($_SESSION['msg'])){ echo $_SESSION['msg']; unset($_SESSION['msg']); } ?></div>
						
						
                        <div class="clearfix"></div>                       
                    </div>
					
                    <div class="d-grid mb-3"> 
                        <button class="cstm-btn btn" type="submit" name="reset_pass">Reset</button></div>
                    <div class="clearfix"></div>
                      <div class="d-flex justify-content-sm-center align-items-top"> 
                      <!-- <span class="fw-normal"><a href="forgot-password.html" class="fw-bold">Forgot Password?/पासवर्ड भूल गए?</a> -->
                    </div>
                 
                     
                  </form>
                </div>
              </div>
              <script type="text/javascript">
                  function refreshCaptcha() {
                   // alert('test');
                      $("#captcha").attr('src', '../captcha.php');
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