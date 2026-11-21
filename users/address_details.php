<?php
  session_start();
  // if(!isset($_SESSION['log'])){
  //   header('Location: login.php');
  // }
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

    $sql = "SELECT * FROM address_details WHERE `userid`='".$_SESSION['uid']."'";
    //echo $sql; die;
    $res = $conn -> query($sql);
    if(mysqli_num_rows($res)>= 1){
      $_SESSION['addressformid']='yes';
    }
    //print_r($data); die;
  }

  if(isset($_SESSION['addressformid'])){
    $sql = "SELECT * FROM address_details WHERE `userid`='".$_SESSION['uid']."'";
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
                    <div class="col-2 text-center col-md-1 b-rights px-0"><img
                            src="../public/images/logo.png" alt="" class="dash-logo" /></div>
                    <div class="col-9 col-md-9 px-0">
                        <h4 class="moudlename">Anganwadi Recruitment Uttar Pradesh</h4>
                        <!-- <h5 class="dash-head">Previously known as Bhatkhande Music Institute Deemed to be University, -->
                            <!-- Lucknow</h5> -->
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
                  <div class="col-md-4 col-12 text-center"> <strong>Father Name</strong> :  <?php echo $data['father_name']; ?>
                </div>
                  <div class="col-md-4 col-12 text-center"><strong>Mobile</strong>  : <?php echo $data['mobile']; ?>
                </div>
              </div>
            </div> 	
            </div>
       
			<div class="border bg-light p-1 mb-1">
		
        </div>

<!-- start here -->
 <div id="multi-step-form-container">
        <!-- Form Steps / Progress Bar -->
        <ul
          class="form-stepper form-stepper-horizontal text-center mx-auto pl-0"
        >
          <!-- Step 1 -->
          <li
            class="form-stepper-active text-center form-stepper-list"
            step="1"
          >
            <a class="mx-2">
              <span class="form-stepper-circle">
                <span>1</span>
              </span>
              <div class="label">व्यक्तिगत विवरण -1 </div>
            </a>
          </li>
          <!-- Step 2 -->
          <li
            class="form-stepper-active text-center form-stepper-list"
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
            class="form-stepper-active text-center form-stepper-list"
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
                <center><h4><u>पते का विवरण</u></h4></center>
            <form class="row g-3 needs-validation mt-4" onsubmit="return validateForm()   id="userAccountSetupForm" name="form1"  method="post" action="formSubmit.php" novalidate>
                <div class="row"> 
                <div class="col-md-4 hiding_other">
                    <div class="form-group mb-3">
                        <label for="district" class="placeholder"> ज़िला <span class="text-danger">*</span></label>
                        <select class="form-control form-select" name="district" id="district1" required>
                            <option value="">कृप्या विक्लप चुने</option>
                              <option value="1">Lucknow</option>
                        </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group mb-3">
                          <label for="district" class="placeholder"> तहसील <span class="text-danger">*</span></label>
                          <select class="form-control form-select" name="tahsil" id="tahsil" required>
                            <option value="">कृप्या विक्लप चुने</option>
							              <option value="bkt">Sadar</option>
							
                          </select>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="form-group mb-3">
                          <label for="district" class="placeholder"> परियोजना/विकासखंड  <span class="text-danger">*</span></label>
                          <select class="form-control form-select" name="project" id="tahsil" required>
                            <option value="">कृप्या विक्लप चुने</option>
							              <option value="bkt">Sadar</option>
							
                          </select>
                        </div>
                      </div>
                       
                      <div class="col-md-4">
                        <label for="validationCustom04" class="form-label">पोस्ट</label>
                        <input type="text" class="form-control" id="validationCustom05" name="post" value="<?php if(isset($pdata)){echo $pdata['post'];} ?>" required>
                        
                        </div>
                       
                        <div class="col-md-4" >
                            <div class="form-group mb-3">
                                <label for="district" class="placeholder"> शहरी/ग्रामीण  <span class="text-danger">*</span></label>
                                <select class="form-control form-select" name="urban_rural" id="r_b" required>
                                    <option value="">कृप्या विक्लप चुने</option>
                                    <option value="urban" <?php if(isset($pdata)){ if($pdata['urban_rural'] == 'urban'): ?> selected="selected"<?php endif; }?> >शहरी</option>
                                    <option value="rural" <?php if(isset($pdata)){ if($pdata['urban_rural'] == 'rural'): ?> selected="selected"<?php endif; } ?>>ग्रामीण</option>
                                
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4" id="gramp" style="display:none;">
                         <div class="form-group mb-3">
                           <label> ग्रामपंचायत <span class="text-danger">*</span></label>
                           <input  type="text" id="permanent_address" name="grampanchyat" class="form-control alpha" maxlength="150" placeholder="Enter  Address" value="<?php if(isset($pdata)){echo $pdata['grampanchyat'];} ?>" required>
                         </div>
                    </div>

                    <div class="col-md-4" id="ward" style="display:none;">
                         <div class="form-group mb-3">
                           <label> वार्ड <span class="text-danger">*</span></label>
                           <input  type="text" id="permanent_address" name="ward_no" class="form-control alpha" maxlength="150" placeholder="Enter  Address" value="<?php if(isset($pdata)){echo $pdata['ward_no'];} ?>" required>
                         </div>
                    </div>
                    <div class="col-md-4">
                    <label for="validationCustom04" class="form-label">मकान नंबर</label>
                   <input type="text" class="form-control" id="validationCustom05" name="house_no" value="<?php if(isset($pdata)){echo $pdata['house_no'];} ?>" required
                    >
                    
                </div>

                <div class="col-md-4">
                    <label for="validationCustom04" class="form-label">ग्राम/मोहल्ला</label>
                    <input type="text" class="form-control" name="village" value="<?php if(isset($pdata)){echo $pdata['village'];} ?>" id="validationCustom05"
                        required
                    >
                    
                </div>
                <div class="col-md-4">
                    <label for="validationCustom04" class="form-label">रिक्त आंगनवाड़ी केंद्र का नाम</label>
                    <input type="text" class="form-control" id="validationCustom05" name="vacant_aaganwadi_name" value="<?php if(isset($pdata)){echo $pdata['vacant_aaganwadi_name'];} ?>" required>
                    
                </div>
                     </div>
                </div>
                
                    <div class="col-12 mt-3">
                    <a href="personal_details.php"><button class="btn btn-primary" type="button">पिछला</button></a>
                           <!-- <button class="btn btn-success" type="submit">Save</button>  -->
                    <button class="button btn-success btn-navigate-form-step" type="submit" name="addressSubmit">अगला</button>
                    </div>
                                
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
    $('#r_b').change(function(){
        //alert($('#husband_name').val());
        if($('#r_b').val() == 'rural') {
            $('#gramp').show(); 
            $('#ward').hide(); 
            //alert('1');
        }
        if($('#r_b').val() == 'urban') {
           // alert('2');
            $('#gramp').hide(); 
            $('#ward').show(); 
        } 
    });
});

$(function() {
    // $('#row_dim').hide(); 
    $('#positionofapplicant').change(function(){
        //alert($('#husband_name').val());
        if($('#positionofapplicant').val() == 'V') {
            $('#fatherdiv').show(); 
            $('#husbanddiv').hide(); 
            //alert('1');
        }
        if($('#positionofapplicant').val() == 'D') {
            //alert('2');
            $('#fatherdiv').hide(); 
            $('#husbanddiv').show(); 
        } 
        if($('#positionofapplicant').val() == 'other') {
            //alert('2');
            $('#fatherdiv').hide(); 
            $('#husbanddiv').show(); 
        } 
    });
});

</script>

<script type="text/javascript">
    function valueChanged(){
        if($('.dcheck').is(":checked")) {  
            $("#d_serial").show();
            $("#d_per").show();
        }
        else{
            $("#d_serial").hide();
            $("#d_per").hide();
        }
            
    }

    function ffvalueChanged(){
        if($('.ff').is(":checked")) {  
            $("#ffdiv").show();
            
        }
        else{
            $("#ffdiv").hide();
           
        }
            
    }
</script>
<select class="form-select" id="positionofapplicant" name="category" required>

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