
<?php
  $msg='';
  include('../config/db_config.php');
  include('../config/settings.php');
 
    if(!checkLogin()){
        header('Location: login.php');
    }
  if(isset($_SESSION['uid'])){
    $sql = "SELECT `name`,father_name,mobile FROM users WHERE `id`='".$_SESSION['uid']."'";
    $res = $conn -> query($sql);
    $data=mysqli_fetch_assoc($res);

   
    //print_r($data); die;
  }

  topheader();
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.css" integrity="sha512-0TsYUclL0x2HXTMBHTQyrsFGsELlmYZRsmq8OG1SkV6V2lRzsZoFEddMf1dsqySJIegvLmrowaeiA9HNop2dXA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.min.css" integrity="sha512-gpqtQIgLIXYBimyliA0xmgme7m5coXHQhscvqhAZcOoPlKOmEzPg2BhYIYV/d39j7fEkXh42UeVt7g5PzUtfSg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  
 <?php
      if(isset($_SESSION['otp-finalmsg'])){
      ?>
        <script>
         swal("Success!", "Successfully OTP SEND!", "success")
          </script>
      <?php
      unset($_SESSION['otp-finalmsg']);
      }
    ?>
     <?php
      if(isset($_SESSION['nototp1'])){
      ?>
        <script>
         swal("Wrong !", "आपके द्वारा डाला गया ओ.टी.पी. गलत है !", "warning")
          </script>
      <?php
      unset($_SESSION['nototp1']);
      }
    ?>
  <div class="screen" style="display: none"> <span class="loader"></span> </div>
    <header class="header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-2 text-center col-md-1 b-rights px-0">
            <img src="../public/images/logo.png" alt="" class="dash-logo" /></div>
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
        </header>
        <div class="contentwraper">
         
         

        <div class="container-fluid mt-5"> 
          <div class="row">
            <div class="col-md-1 col-2"> 
               <a title="Dashboard" href="dashboard.php" style="color: #282d6a;"
                        class="intentbtn">
                        <span class="intenticon">
                        <span class="icons icon-home" style="font-size: 32px;"></span>
                        </span></a>
                </div>        
      
                <div class="col-md-3 col-10"> <a href="declearation.php"
                        class="intentbtn bg-c-yellow">
                        <span class="intenticon">
                            <img src="../public/images/icon1.png">
                        </span> <span class="intentdata"> <b class="intentno"></b> Anganwadi Application Form </span> </a>
                </div>
                <div class="col-md-7">
                  <div class="row mt-4">
                    <div class="col-md-4 col-12 text-center"> <strong> Applicant's Name </strong>: <?php echo $data['name']; ?> </div>
                  <div class="col-md-4 col-12 text-center"> <strong>Father Name</strong> :  <?php echo $data['father_name']; ?>
                </div>
                  <div class="col-md-4 col-12 text-center"><strong>Mobile No.</strong>  : <?php echo $data['mobile']; ?>
                </div>
              </div>
            </div> 	
        
        
          
            </div>
       
            <div class="border bg-light p-1 mb-1">
      
            </div> 
        </div>

<!-- start here -->
 <div id="multi-step-form-container">
     
            
          </section>
          <!-- Step 2 Content, default hidden on page load. -->
          <section id="step-2" class="form-step">
           <div class="col-6 offset-3">
            <!-- Step 2 input fields -->
            <form action="formSubmit.php" method="post"  class="mt-4 needs-validation" novalidate>
                    <!-- <input type="hidden" name="_token" value="O9mUTOIwJ98dHE8ncyPuGeXHGQNe6Ctjpf9lCdBX">  -->
                    <span class="success"><?php if(isset($_SESSION['msg'])){ echo  $_SESSION['msg']; unset($_SESSION['msg']); }?></span>
                    <div class="form-group mb-3">
                        <label for="user_id" style="display: flex;font-weight: 700;">OTP/ओटीपी<span class="text-danger">*</span></label>
                       <input type="text" class="form-control num_digit"  name="otp"  placeholder="कृप्या ओटीपी दर्ज करे" maxlength="4" minlength="4" required>
                    </div>
                    <div class="fw-normal text-black-50" style="float:right">
                               
                                <a href="formSubmit.php?userOTP=<?php echo  $_SESSION['uid']; ?>" type="submit" class="fw-bold after-time-out" >Resend OTP</a>
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
                                      <img src="../captcha.php" id="captcha">
                                        <input name="captchacode" type="hidden" class="form-control captchacode unselectable h4" value="" readonly>
                                        <span class="error"><?php if(isset($_SESSION['cerror'])){ echo $_SESSION['cerror']; unset($_SESSION['cerror']);} ?></span>
										
                                          
                                    </div>
                                </div>
                                <div class="col-md-1 col-2">
                                    <div class="refresh"><a onClick="refreshCaptcha();" title="Refresh Captcha"><span class="fas fa-redo" id="refreshCaptcha"></span></a></div>
                                </div>
                                <div class="col-md-6 col-12">
                                    <label style="display: flex;font-weight: 700;">Enter Captcha/कैप्चा भरें<span class="text-danger">*</span></label>
                                    <input name="captcha" type="text" id="captcha-input"
                                            maxlength="5" minlength="5" id="captcha-input" class="form-control" required>
                                </div>
                                <!-- <div class="col-12">
                                <div>
                                    <span id="timer" style="color: red;">
                                      <span id="time"></span> Seconds      
                                    </span>
                                  </div>
                                </div>
                                -->
                            </div>
                        </div>
						
						
                        <div class="clearfix"></div>   
                        <!-- <div class="d-flex justify-content-center align-items-center mt-2 text-center mb-3">
                            <span class="fw-normal text-black-50">
                                <span id="resenddiv" >
                                <a href="submit_login.php?mob=<?php echo $_SESSION['mobile']; ?>" type="submit" class="fw-bold after-time-out" >Resend</a>
                                </span>
                                
                                
                            </span>
                        </div>                     -->
                    </div>
					
                    <div class="d-grid mb-3"> 
                        <button class="cstm-btn btn" type="submit" name="finalotpVerify">Verify/सत्यापित करें</button></div>
                    <div class="clearfix"></div>
                      <div class="d-flex justify-content-sm-center align-items-top"> 
                      <!-- <span class="fw-normal"><a href="forgot-password.html" class="fw-bold">Forgot Password?/पासवर्ड भूल गए?</a> -->
                    </div>
                 
                     
                  </form>
              </div>
            
          </section>
          
      </div>
  
    

        <!-- <div class="custom-card mb-3">
      <div class="custom-active">

               <h5> Application Status</h5>
          <div class="arrow-steps clearfix">
            <div class="step  current"> <span> <i class="fas fa-check"></i> </span> Application Details </span> </div>
            <div class="step @if ($step!=null && $step->form_step >= 4) current @endif"> <span><i class="fa fa-check"></i> </span>Upload Document</span> </div>
            <div class="step @if ($step!=null && $step->form_step >= 5) current @endif"> <span><i class="fas fa-check"></i> <i class="fa fa-hourglass-end" aria-hidden="true"></i></span>Application Preview</span>
            </div>
          </div>

      </div>
      </div> -->
        <div class="card">
        <div class="card-body">
          
                 
                  
                 </div>
        </div>


           
             <!-- end code exam form details after submit -->

   </div>
</div>

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
    var ajaxUrl = "{{ url('') }}";
    </script>
    <script>
      function getdistrict(val) {
        $.ajax({
          type: "POST",
          url: "../ajax.php",
          data:'distid='+val,
          success: function(data){
            $("#block").html('');
          $("#block").html(data);
          }
        });
      }
</script>
   <?php footer(); ?>
   
    
    
<script type="text/javascript">
    function refreshCaptcha() {
      // alert('test');
        $("#captcha").attr('src', '../captcha.php');
    }
</script>
</body>

</html>
  