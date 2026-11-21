<?php 
    include'../config/db_config.php';
    session_start(); 
    $sql="select * from users where mobile='".$_SESSION['mobile']."'";
    $res=execute_query($sql);
    if(mysqli_num_rows($res) > 0){

    }
    else{
      echo "Can not access directly"; 
      exit();
    }
      // Set the initial countdown time (in seconds)
    $initialCountdownTime = 300; // 5 minutes

    // Store the initial countdown time in a session variable
    if (!isset($_SESSION['countdown_time'])) {
        $_SESSION['countdown_time'] = time() + $initialCountdownTime;
    }

    // Calculate the remaining time
    $currentTime = time();
    $remainingTime = $_SESSION['countdown_time'] - $currentTime;
    if ($remainingTime < 0) {
        $remainingTime = 0;
    }

    //echo $remainingTime; die;
?>
<!doctype html>
<!-- <html lang="en"> -->
<html>

<!-- Mirrored from apps.bhatkhandeuniversity.ac.in/student/login by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 28 Jan 2024 14:20:20 GMT -->
<!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
<head>
    <title>Login-OTP : Anganwadi Recruitment, Uttar Pradesh</title>
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
.success{
  color:green;
  font-weight: bold;
}
  </style>
</head>
   <body>
   <div class="screen" style="display: none">
      <span class="loader"></span>
   </div>
   <div class="container-fluid">

    <?php
      if(isset($_SESSION['msg'])){
      ?>
        <script>
         swal("Success !", "Successfully OTP SEND!", "success")
          </script>
      <?php
      unset($_SESSION['msg']);
      }
    ?>
     <?php
      if(isset($_SESSION['nototp'])){
      ?>
        <script>
         swal("Wrong !", "आपके द्वारा डाला गया ओ.टी.पी. गलत है !", "warning")
          </script>
      <?php
      unset($_SESSION['nototp']);
      }
    ?>
    


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
                <img src="../public/images/aww-image.jpg" alt="" style=" width:100%; height:60%; object-fit: cover; position: absolute;top: 280px;">
                <div class="row justify-content-center align-items-center">
                    <div class="col-3 col-lg-3">
                        <img src="../public/images/images.png" class="img-fluid" style="filter: invert(1); position:  absolute;top: -3px; width:15%;" />
                    </div>
                    <div class="col-3 col-lg-3" style="margin-left: 10px;">
                        <img src="../public/images/icds.png" class="img-fluid" style="filter: invert(1); position:  absolute;top: -3px; width:15%;" />
                    </div>
                    <div class="deptname" style="text-align: center; margin-bottom:240px; ">
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
                    <h3 class="mb-0" style="font-size: 30px;font-weight: 800;">OTP</h3>
                    <div class="d-flex justify-content-center align-items-center mt-2">                        
                        <span class="fw-normal"><b>आप अपना ओटीपी दर्ज कराये </b> <br> 
                        </span>
                        
                    </div> 
                   
                  </div>
                  <form action="submit_login.php" method="post"  class="mt-4 needs-validation" novalidate>
                    <!-- <input type="hidden" name="_token" value="O9mUTOIwJ98dHE8ncyPuGeXHGQNe6Ctjpf9lCdBX">  -->
                    <span class="success"><?php if(isset($_SESSION['msg'])){ echo  $_SESSION['msg']; unset($_SESSION['msg']); }?></span>
                    <div class="form-group mb-3">
                        <label for="user_id" style="display: flex;font-weight: 700;">OTP/ओटीपी<span class="text-danger">*</span></label>
                       <input type="text" class="form-control num_digit"  name="otp"  placeholder="कृप्या ओटीपी दर्ज करे" maxlength="4" minlength="4" required>
                    </div>
                   
                        
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
                                      <img src="../captcha.php" id="captcha1">
                                        <input name="captchacode" type="hidden" class="form-control captchacode unselectable h4" value="" readonly>
                                        <span class="error"><?php if(isset($_SESSION['cerror'])){ echo $_SESSION['cerror']; unset($_SESSION['cerror']);} ?></span>
										
                                    </div>
                                </div>
                                <div class="col-md-1 col-2">
                                <div class="refresh" id="refresh"><a onClick="refreshCaptcha();" title="Refresh Captcha" id="refreshCaptcha"><span class="fas fa-redo"></span></a></div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label style="display: flex;font-weight: 700;">Enter Captcha/कैप्चा भरें<span class="text-danger">*</span></label>
                                    <input name="captcha" type="text" id="captcha-input"
                                            maxlength="5" minlength="5" id="captcha-input" class="form-control" required>
                                </div>
                                <div class="col-12">
                                <div>
                                    <span id="timer" style="color: red;">
                                      <span id="time"></span> Seconds      
                                    </span>
                                  </div>
                                </div>
                               
                            </div>
                        </div>
						
						
                        <div class="clearfix"></div>   
                        <div class="d-flex justify-content-center align-items-center mt-2 text-center mb-3">
                            <span class="fw-normal text-black-50">
                                <span id="resenddiv" >
                                <a href="submit_login.php?mob=<?php echo $_SESSION['mobile']; ?>" type="submit" class="fw-bold after-time-out" >Resend</a>
                                </span>
                                
                                
                            </span>
                        </div>                    
                    </div>
					
                    <div class="d-grid mb-3"> 
                        <button class="cstm-btn btn" type="submit" name="loginotpVerify">Verify/सत्यापित करें</button></div>
                    <div class="clearfix"></div>
                      <div class="d-flex justify-content-sm-center align-items-top"> 
                      <!-- <span class="fw-normal"><a href="forgot-password.html" class="fw-bold">Forgot Password?/पासवर्ड भूल गए?</a> -->
                    </div>
                 
                     
                  </form>
                </div>
              </div>
   <script>
     $(document).ready(function () {
        get_captcha();
   })
   $(".refresh").on("click", function () {
    get_captcha();
    });
    
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
    <script>
      var counter = <?php echo  $remainingTime; ?>; 
      var interval = setInterval(function() {
          counter--;
          // Display 'counter' wherever you want to display it.
          if (counter <= 0) {
              clearInterval(interval);
              $('#resenddiv').show();
              $('#timer').html("<h6>OTP Expire Resend</h6>");  
              return;
          }else{
            $('#time').text(counter);
            $('#resenddiv').hide();
            console.log("Timer --> " + counter);
          }
      }, 1000);
    </script>

 

    <script type="text/javascript">
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      </script>

<script>
      function resendOtp(val) {
        $.ajax({
          type: "POST",
          url: "../ajax.php",
          data:'mob='+val,
          success: function(data){
            $("#block").html('');
          $("#block").html(data);
          }
        });
      }
</script>
<script type="text/javascript" src="../public/js/bootstrap.js"></script>

<script type="text/javascript" src="../public/js/select2.min.js"></script>
<script type="text/javascript" src="../public/js/js_latest_toastr.min.js"></script>  

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

 
</body>

<!-- Mirrored from apps.bhatkhandeuniversity.ac.in/student/login by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 28 Jan 2024 14:20:21 GMT -->
</html>