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

  topheader();
 
?>

<!doctype html>
<!-- <html lang="{{str_replace('_', '-', app()->getLocale())}}"> -->
<html>
        <title>Registration : Anganwadi Recruitment 2024, Lucknow, India</title>
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
        <link href="../public/css/dataTables.bootstrap5.min.css" rel='stylesheet' />
        <link href="../public/css/draggle.css" rel="stylesheet">
        <link rel="stylesheet" href="../public/css/multilevel-form.css">
      
   

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
.loader {
    width: 48px;
    height: 48px;
    border: 2px solid #128cbc;
    border-radius: 50%;
    display: inline-block;
    position: absolute;
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

@keyframes rotation {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}

.screen {
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

a.not-allowed {
    cursor: not-allowed !important;
    pointer-events: none;
}
.active-tab {
    background: #ffdebb;
    border-bottom: 1px solid #ef8937;
}
</style>


<body class="dashbg">
   
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
                        <a href="javascript::void(0)" class="profileicon"><img
                                src="../public/images/profile2.png" /></a>
                        <div class="sidebar">
                            <div class="profiletitle"> <span
                                    class="text-uppercase">Applicant Name</span> <span>Last Login :
                                    
                                </span></div>
                            <div class="scrollwrap">
                                <div class="nano-content">
                                    <ul class="navsidebar">

                                        <li class="nav-item"> 
                                                <a  href=""><span
                                class="icons icon-speedometer"></span> Dashboard </a>

                                </li>
                                        <li class="nav-item"> <a
                                                href=""><span
                                                    class="icons icon-user"></span> Profile</a> </li>
                                        <li class="nav-item"> <a
                                                href=""><span
                                                    class="icons icon-lock-open"></span>Change
                                                Password</a> </li>

                                    </ul>
                                </div>
                            </div>
                            <div class="logoutbutton"><a href="{{route('student.logout')}}"><span
                                        class="fas fa-power-off"></span>&nbsp;&nbsp;Logout</a></div>
                        </div>
                    
                    </div>
                </div>
            </div>
        </header>
        <div class="contentwraper">
          <?php
          if(isset($_SESSION['success'])){
           echo '<div class="alert alert-success alert-dismissible">
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              <strong>Successfully!</strong> Login
            </div>';
          }
          unset($_SESSION['success']);
          ?>

          <div class="container-fluid">
               
        <div class="row">
            <div class="col-md-1 col-2"> 
				<a title="Dashboard" href="student_dashboard.html" style="color: #282d6a;"
                        class="intentbtn">
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
            </div>
       
			<div class="border bg-light p-2 mb-2">
			<div class="row">
                <div class="col-md-4 col-12 text-center"> <strong> Applicant's Name </strong>:   Sanchita Gupta </div>
		
                
                <div class="col-md-4 col-12 text-center"> <strong>Mobile No.</strong> : 9140942152</div>
			
                <div class="col-md-4 col-12 text-center"><strong>Category</strong>  : Backward </div>
			
            </div> 
            </div> 
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
              <div class="label">व्यक्तिगत विवरण</div>
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
              <div class="label text-muted">रिक्ति विवरण</div>
            </a>
          </li>
          <!--step3 -->
          <li
            class="form-stepper-unfinished text-center form-stepper-list"
            step="3"
          >
            <a class="mx-2">
              <span class="form-stepper-circle text-muted">
                <span>2</span>
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
                <span>2</span>
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
                <span>3</span>
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
                <span>4</span>
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
                <center><h4><u>रिक्ति विवरण</u></h4></center>
            <form class="row g-3 needs-validation mt-4" onsubmit="return validateForm()   id="userAccountSetupForm" name="form1"  method="post" action="formSubmit.php" novalidate>
            
            <div class="col-md-6">
                    <label for="validationCustom02" class="form-label">आवेदिका की स्थिति</label>
                    <select class="form-select" id="positionofapplicant" name="category" required>
                        <option selected disabled value="">SELECT</option>
                        <option value="V">विधवा</option>
                        <option value="D">तलाकशुदा</option>
                        <option value="other">अन्य</option>
                    </select>
                    
                </div>
                <div class="col-md-6">
                    <label for="validationCustom02" class="form-label"> प्रमाण पत्र संलग्न करे</label>
                    <input
                        type="file"
                        class="form-control"
                        id="validationCustom02"
                        name="married_status"
                       value=""
                        required
                    >
                    
                </div>
                 <!-- <div class="col-md-6">
                    <label for="validationCustom02" class="form-label">विधवा/तलाकशुदा/पारित्यवता प्रमाण पत्र जरीकर्ता का पदनाम</label>
                    <input
                        type="text"
                        class="form-control"
                        id="validationCustom02"
                        name="married_status"
                       value=""
                        required
                    >
                    
                </div> -->

                
                <div class="row mt-2">
                        <div class="col-md-4">
                            <label for="validationCustom04" class="form-label">क्या आप विकलांग  हैं?
                            <input type="checkbox" class="dcheck mt-3" id="dcheck" name="" value="D" style="width:50px" onchange="valueChanged()"> </label>
                            
                        </div>

                        <div class="col-md-4" id="d_serial" style="display:none;>
                            <label for="validationCustom04" class="form-label">क्रमांक</label>
                            <input type="textbox"class="form-control" name="" value=""> 
                            
                        </div>
                        <div class="col-md-4" id="d_per" style="display:none;>
                            <label for="validationCustom05" class="form-label">प्रतिशत</label>
                            <input
                                type="text" name="percentage"
                                class="form-control"
                                id="validationCustom05"
                                required
                            >
                            
                        </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label for="validationCustom04" class="form-label">क्या आप स्वतंत्रता सेनानी हैं?
                        <input type="checkbox" class="ff mt-3" id="dcheck" name="" value="D" style="width:50px" onchange="ffvalueChanged()"> </label>
                        
                    </div>
                    <div class="col-md-4" id="ffdiv" style="display:none">
                        <label for="validationCustom02" class="form-label">दस्तावेज़ अपलोड करें</label>
                        <input type="file" name="ff_serial" class="form-control" id="validationCustom02">
                        
                    </div>
                </div>

                <div class="row mt-3">
                    
                    <div class="col-md-4">
                        <label for="validationCustom01" class="form-label">निवास प्रमाण क्रमांक </label>
                        <input type="text" name="" class="form-control" id="" value="" required>
                        
                    </div>

                    <div class="col-md-4">
                        <label for="validationCustom01" class="form-label">जाति प्रमाण पत्र  क्रमांक </label>
                        <input type="text" name="" class="form-control" id="" value="" required>
                        
                    </div>

                    <div class="col-md-4 mt-3">
                        <label for="validationCustom01" class="form-label">आय प्रमाण पत्र  क्रमांक </label>
                        <input type="text" name="" class="form-control" id="" value="" required>
                        
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <label for="validationCustom04" class="form-label">क्या आप BPL श्रेणी मे है</label>
                        <select class="form-select" id="validationCustom04" name="is_bpl" required>
                            <option selected disabled value="">SELECT</option>
                            <option>...</option>
                        </select>
                        
                    </div>
                    <div class="col-md-4">
                        <label for="validationCustom02" class="form-label">आधार नंबर(अंग्रेजी के अंको मे भरे)</label>
                        <input
                            type="text" name="aadhar_no" class="form-control" id="validationCustom02" value=""
                            required>
                        
                    </div>
                </div>
                    <div class="col-12">
                         
                           <!-- <button class="btn btn-success" type="submit">Save</button>  -->
                          <button
                class="button btn-navigate-form-step" type="submit"
                step_number="2" name="save2">
                अगला
              </button>
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
            
          </section>
          <!-- Step 2 Content, default hidden on page load. -->
          <section id="step-2" class="form-step d-none">
            <h2 class="font-normal">Social Profiles</h2>
            <!-- Step 2 input fields -->
            <div class="mt-3">Step 2 input fields goes here..</div>
            <div class="mt-3">
              <button
                class="button btn-navigate-form-step"
                type="button"
                step_number="1"
              >
                Prev
              </button>
              <button
                class="button btn-navigate-form-step"
                type="button"
                step_number="3"
              >
                Next
              </button>
            </div>
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