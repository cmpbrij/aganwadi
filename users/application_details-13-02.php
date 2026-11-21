<?php
   session_start();
  // if(!isset($_SESSION['log'])){
  //   header('Location: login.php');
  // }

  //echo $_SESSION['uid']; die;
?>
<?php
  include('../config/settings.php');
  include('../config/db_config.php');
  // if(!$_SESSION['log']){
  //   header('Location: login.php');
  // }
  if(isset($_SESSION['uid'])){
    $sql = "SELECT * FROM users WHERE `id`='".$_SESSION['uid']."'";
    $res = $conn -> query($sql);
    $data=mysqli_fetch_assoc($res);
    //print_r($data); die;
  }

  if(isset($_SESSION['personal-details-1'])){
    $sql = "SELECT * FROM personal_details WHERE `userid`='".$_SESSION['uid']."'";
    //echo $sql; die;
    $res = $conn -> query($sql);
    $pdata=mysqli_fetch_assoc($res);
   // print_r($pdata); die;
  }
  
  topheader();
?>
  <div class="screen" style="display: none"> <span class="loader"></span> </div>
    <header class="header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-2 text-center col-md-1 b-rights px-0">
            <img src="../public/images/logo.png" alt="" class="dash-logo" />
          </div>
          <div class="col-9 col-md-9 px-0">
            <h4 class="moudlename">Anganwadi Recruitment Uttar Pradesh</h4>      
          </div>
          <div class="col px-0 text-end" style="display: block ruby;">
            <a href="javascript::void(0)" class="profileicon">
              <!-- <img src="../public/images/profile2.png" /></a> -->
              <div class="dropdown">
                  <a class="dropdown-toggle profileicon" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                  <img src="../public/images/profile2.png" />
                  </a>

                  <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    
                  </ul>
                </div>

                
                </div>
              </div>
            </div>
        </header>
        <div class="contentwraper">
          <?php
          if(isset($_SESSION['success'])){
           echo '<div class="alert alert-success alert-dismissible">
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>'.$_SESSION['success'].'
            </div>';
          }
          unset($_SESSION['success']);
          ?>

          <div class="container-fluid">
               
        <div class="row">
          <div class="col-md-1 col-2"> 
				    <a title="Dashboard" href="student_dashboard.html" style="color: #282d6a;" class="intentbtn">
                  <span class="intenticon">
                  <span class="icons icon-home" style="font-size: 32px;"></span>
                  </span></a>
          </div>				
          <div class="col-md-3 col-10"> <a href="#"
                  class="intentbtn bg-c-yellow">
                  <span class="intenticon">
                      <img src="../public/images/icon1.png">
                  </span> <span class="intentdata"> <b class="intentno"></b> Anganwadi Application Form </span> </a>
          </div>
          <div class="col-md-7">
            <div class="row mt-4">
              <div class="col-md-4 col-12 text-center"> <strong> Applicant's Name </strong>: <?php echo $data['name']; ?> </div>
            <div class="col-md-4 col-12 text-center"> <strong>Mobile No.</strong> :  <?php echo $data['father_name']; ?></div>
            <div class="col-md-4 col-12 text-center"><strong>Category</strong>  : <?php echo $data['mobile']; ?></div>
        </div>
          </div> 
          </div>
        </div>
       
			<div class="border bg-light p-1 mb-1">
			
      </div>

<!-- start here -->
 <div id="multi-step-form-container">
        <!-- Form Steps / Progress Bar -->
        <ul class="form-stepper form-stepper-horizontal text-center mx-auto pl-0">
          <!-- Step 1 -->
          <li class="form-stepper-active text-center form-stepper-list" step="1">
            <a class="mx-1">
              <span class="form-stepper-circle">
                <span>1</span>
              </span>
              <div class="label">व्यक्तिगत विवरण - 1</div>
            </a>
          </li>
          <!-- Step 2 -->
          <li
            class="form-stepper-unfinished text-center form-stepper-list"
            step="2"
          >
            <a class="mx-2">
              <span class="form-stepper-circle text-muted">
                <span>2</span>
              </span>
              <div class="label text-muted">व्यक्तिगत विवरण - 2</div>
            </a>
          </li>
          <!--step3 -->
          <li
            class="form-stepper-unfinished text-center form-stepper-list"
            step="3"
          >
            <a class="mx-2">
              <span class="form-stepper-circle text-muted">
                <span>3</span>
              </span>
              <div class="label text-muted">पते का विवरण</div>
            </a>
          </li>

          <li
            class="form-stepper-unfinished text-center form-stepper-list"
            step="4"
          >
            <a class="mx-2">
              <span class="form-stepper-circle text-muted">
                <span>4</span>
              </span>
              <div class="label text-muted">शैक्षिक योग्यता</div>
            </a>
          </li>
          <!-- Step 3 -->
          <li
            class="form-stepper-unfinished text-center form-stepper-list"
            step="5"
          >
            <a class="mx-2">
              <span class="form-stepper-circle text-muted">
                <span>5</span>
              </span>
              <div class="label text-muted">अपलोड फोटो</div>
            </a>
          </li>
          <!-- Step 4 -->
          <li
            class="form-stepper-unfinished text-center form-stepper-list"
            step="6"
          >
            <a class="mx-2">
              <span class="form-stepper-circle text-muted">
                <span>6</span>
              </span>
              <div class="label text-muted">घोषणापत्र</div>
            </a>
          </li>
          <!-- Step 5 -->  
        </ul>
        <!-- Step Wise Form Content -->
        <!-- <form id="userAccountSetupForm" name="form1" id="form1" method="post" action=""> -->
          <!-- Step 1 Content -->
          <section id="step-1" class="form-step">               
            <div class="row">
              <center><h4><u>व्यक्तिगत विवरण - 1</u></h4></center>
              <form class="row g-3 needs-validation mt-2" onsubmit="return validateForm()" id="userAccountSetupForm" name="form1"  method="post" action="formSubmit.php" novalidate>
              <input type="hidden" name="uid" value="<?php echo $_SESSION['uid']; ?>">
                <div class="col-md-4">
                    <label for="validationCustom02" class="form-label">आवेदिका का नाम</label>
                    <div class="input-group has-validation">
                    <select name="pre_name">
                      <option value="" disable>चुने</option>
                      <option value="1" <?php if(isset($pdata)) { if($pdata['pre_name'] == '1'): ?> selected="selected"<?php  endif; }?>>श्रीमती </option>
                      <option value="2" <?php  if(isset($pdata)) {if($pdata['pre_name'] == '2'): ?> selected="selected"<?php endif; }?>>कुमारी</option>
                    </select>
                    <input type="text"  class="form-control" name="applicant_name" id="validationCustom02" value="<?php if(isset($pdata)){ echo $pdata['name']; }  ?>" required>
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="validationCustomUsername" class="form-label">वैवाहिक स्थिति </label>
                    <div class="input-group has-validation">
                        <select class="form-select" id="married_status" name="married_status" required>
                        <option disabled value="" selected>कृप्या विक्लप चुने </option>
                        <option value="M" <?php if(isset($pdata)) { if($pdata['married_status'] == 'M'): ?> selected="selected"<?php endif; } ?>>विवाहित</option>
                        <option value="UM" <?php if(isset($pdata)) {  if($pdata['married_status'] == 'UM'): ?> selected="selected"<?php endif; } ?>>अविवाहित</option>
                    </select>
                        
                    </div>
                </div>

                <div class="col-md-4" id="husbanddiv"  style='<?php if(isset($pdata)) { if($pdata['husband_name'] !=''){ echo "display:block"; } else { echo "display:none"; } }else { echo "display:none"; } ?>'>
                    <label for="validationCustom02" class="form-label">पति का नाम</label>
                    <input type="text" name="husband_name" class="form-control" id="husband_name" value="<?php if(isset($pdata)){ echo $pdata['husband_name']; }  ?>" required>
                    
                </div>

                <div class="col-md-4" id="fatherdiv"  style='<?php if(isset($pdata)) { if($pdata['father_name'] !=''){ echo "display:block"; } else { echo "display:none"; } } else { echo "display:none"; } ?>' >
                    <label for="validationCustom02" class="form-label">पिता का नाम</label>
                    <input type="text" name="father_name" class="form-control" id="father_name"  value="<?php if(isset($pdata)){ echo $pdata['father_name']; }  ?>"
                        required
                    >
                    
                </div>

                <div class="col-md-4">
                    <label for="validationCustomUsername" class="form-label">माता का नाम</label>
                    <div class="input-group has-validation">
                        <input type="text" name="mother_name" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend"  value="<?php if(isset($pdata)){ echo $pdata['mother_name']; }  ?>" required>
                        
                    </div>
                </div>

                <div class="col-md-4">
                    <label for="validationCustom02" class="form-label">आवेदिका का मोबाइल नंबर</label>
                    <input type="text" name="mobile" class="form-control" id="validationCustom02"  value="<?php echo $_SESSION['mobile']; ?>" disable readonly required>
                    
                </div>

                <div class="col-md-4">
                    <label for="validationCustom02" class="form-label">श्रेणी</label>
                    <select class="form-select" id="validationCustom04" name="category" required>
                        <option selected disabled value="">कृप्या विक्लप चुने</option>
                        <option value="1" <?php if(isset($pdata)) { if($pdata['category'] == '1'): ?> selected="selected"<?php endif; } ?>>अनुसूचित जाति</option>
                        <option value="2" <?php if(isset($pdata)) { if($pdata['category'] == '2'): ?> selected="selected"<?php endif; }?>>अनुसूचित जनजाति</option>
                        <option value="3" <?php if(isset($pdata)) { if($pdata['category'] == '3'): ?> selected="selected"<?php endif; } ?>>अन्य पिछड़ा वर्ग</option>
                        <option value="4" <?php if(isset($pdata)) { if($pdata['category'] == '4'): ?> selected="selected"<?php endif; } ?>>अनारक्षित</option>
                       
                    </select>
                    
                </div>

                <div class="col-md-4">
                    <label for="validationCustomUsername" class="form-label">उप श्रेणी</label>
                    <div class="input-group has-validation">
                        <select class="form-select" id="validationCustom04" name="subcategory" required>
                        <option selected disabled value="">कृप्या विक्लप चुने</option>
                        <option value="1" <?php if(isset($pdata)) { if($pdata['sub_category'] == '1'): ?> selected="selected"<?php endif; } ?>>अपंगता</option>
                        <option value="2" <?php if(isset($pdata)) { if($pdata['sub_category'] == '2'): ?> selected="selected"<?php endif; } ?>>स्वतंत्रता सेनानी</option>
                        <option value="3" <?php if(isset($pdata)) { if($pdata['sub_category'] == '3'): ?> selected="selected"<?php endif; } ?>>आर्थिक रूप से कमजोर वर्ग</option>
                    </select>
                        
                    </div>
                </div>

                <div class="col-md-3">
                    <label for="validationCustomUsername" class="form-label">जन्मतिथि </label>
                    <div class="input-group has-validation">
                        <input type="date" class="form-control" name="dob" id="dob" aria-describedby="inputGroupPrepend" value="<?php if(isset($pdata)){ echo $pdata['dob']; }  ?>" required>
                        
                    </div>
                </div>

                <?php
                  if(isset($pdata)){
                ?>
                  <div class="col-12">
                  <button class="button btn-navigate-form-step" type="submit"  step_number="2" name="pDetails-1">अपडेट</button>

                  <button class="button btn-navigate-form-step" type="submit"  step_number="2" name="save1">अगला</button>
              </div>
                <?php
                  }
                  else{
                ?>
                  <div class="col-12">
                  <button class="button btn-navigate-form-step" type="submit"  step_number="2" name="save1">अगला</button>
              </div>
                <?php
                  }
                ?>
                
                                
            </form>
        </div>
                     </div>
                     <!-- <div class="bhoechie-footer">
                       <div class="row justify-content-center">
                         <div class="col-md-2 d-grid"> 
                           <button type="submit" class="btn btn-primary">Save & Next</button>
                         </div>
                       </div>
                     </div> -->
                   </form>
            
          </section>
          
          <!-- Step 3 Content, default hidden on page load. -->
          <section id="step-3" class="form-step d-none">
            <h2 class="font-normal">Social Profiles</h2>
            <!-- Step 3 input fields -->
            <div class="mt-3">Step 3 input fields goes here..</div>
            <div class="mt-3">
              <button
                class="button btn-navigate-form-step"
                type="button"
                step_number="2"
              >
                Prev
              </button>
              <button
                class="button btn-navigate-form-step"
                type="button"
                step_number="4"
              >
                Next
              </button>
            </div>
          </section>
          <!-- Step 4 Content, default hidden on page load. -->
          <section id="step-4" class="form-step d-none">
            <h2 class="font-normal">Social Profiles</h2>
            <!-- Step 4 input fields -->
            <div class="mt-3">Step 4 input fields goes here..</div>
            <div class="mt-3">
              <button
                class="button btn-navigate-form-step"
                type="button"
                step_number="3"
              >
                Prev
              </button>
              <button
                class="button btn-navigate-form-step"
                type="button"
                step_number="5"
              >
                Next
              </button>
            </div>
          </section>
          <!-- Step 5 Content, default hidden on page load. -->
          <section id="step-5" class="form-step d-none">
            <h2 class="font-normal">Social Profiles</h2>
            <!-- Step 5 input fields -->
            <div class="mt-3">Step 5 input fields goes here..</div>
            <div class="mt-3">
              <button
                class="button btn-navigate-form-step"
                type="button"
                step_number="4"
              >
                Prev
              </button>
              <button
                class="button btn-navigate-form-step"
                type="button"
                step_number="6"
              >
                Next
              </button>
            </div>
          </section>
          <!-- Step 6 Content, default hidden on page load. -->
          <section id="step-6" class="form-step d-none">
            <h2 class="font-normal">Personal Details</h2>
            <!-- Step 6 input fields -->
            <div class="mt-3">Step 6 input fields goes here..</div>
            <div class="mt-3">
              <button
                class="button btn-navigate-form-step"
                type="button"
                step_number="5"
              >
                Prev
              </button>
              <button class="button submit-btn" type="submit">Save</button>
            </div>
          </section>
        </form>
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

<script>
$(function() {
    // $('#row_dim').hide(); 
    $('#married_status').change(function(){
        //alert($('#husband_name').val());
        if($('#married_status').val() == 'UM') {
            $('#fatherdiv').show(); 
            $('#husbanddiv').hide(); 
            //alert('1');
        }
        if($('#married_status').val() == 'M') {
            //alert('2');
            $('#fatherdiv').hide(); 
            $('#husbanddiv').show(); 
        } 
    });
});
</script>

<style>
 .ellipsis {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
</style>



       
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
   
    
</body>

</html>