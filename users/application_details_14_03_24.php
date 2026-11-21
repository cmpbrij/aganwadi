<?php
include('../config/db_config.php');
include('../config/settings.php');

if (!checkLogin()) {
    header('Location: login.php');
}
if (isset($_SESSION['uid'])) {
    $query = "SELECT * FROM users WHERE `id`='".$_SESSION['uid']."'";
    $res =$conn->query($query);
    $data = $res->fetch_assoc();
   // print_r($row); die;

   // $result = mysqli_query($conn, $query);
    // $result = $mysqli->query("SELECT * FROM piu_mix_design_details");
    // print_r($result);
    //     if ( false===$result ) {
    //     printf("error: %s\n", mysqli_error($conn));
    //     }
    //     else {
    //     echo 'done.';
    //     }
   

    $sql1 = "select id from new_application_details where `userid`='" . $_SESSION['uid'] . "'";

    $r = execute_query($sql1);
    $check = mysqli_fetch_array($r);
    if (mysqli_num_rows($r) > 0) {
        $sql = "SELECT * FROM new_application_details WHERE `userid`='" . $_SESSION['uid'] . "'";
        //echo $sql; die;
        $res = $conn->query($sql);
        $pdata = mysqli_fetch_assoc($res);
        //print_r($pdata); die;
        $_SESSION['personal-details-1'] = $check['id'];
    }


    // print_r($data);
    // die;
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
                <h5 class="dash-head"> Government of Uttar Pradesh </h5>
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
    if (isset($_SESSION['success'])) {
        echo '<div class="alert alert-success alert-dismissible">
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>' . $_SESSION['success'] . '
            </div>';
    }
    unset($_SESSION['success']);
    ?>

    <div class="container-fluid mt-5">

        <div class="row">
            <div class="col-md-1 col-2">
                <a title="Dashboard" href="dashboard.php" style="color: #282d6a;" class="intentbtn">
                    <span class="intenticon">
                        <span class="icons icon-home" style="font-size: 32px;"></span>
                    </span></a>
            </div>
            <div class="col-md-3 col-10"> <a href="application_details.php" class="intentbtn bg-c-yellow">
                    <span class="intenticon">
                        <img src="../public/images/icon1.png">
                    </span> <span class="intentdata"> <b class="intentno"></b> Anganwadi Application Form </span> </a>
            </div>
            <div class="col-md-7">
                <div class="row mt-4">
                    <div class="col-md-4 col-12 text-center"> <strong> Applicant's Name </strong>: <?php echo $data['name']; ?> </div>
                    <div class="col-md-4 col-12 text-center"> <strong>Father Name</strong> : <?php echo $data['father_name']; ?></div>
                    <div class="col-md-4 col-12 text-center"><strong>Mobile No.</strong> : <?php echo $data['mobile']; ?></div>
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
            <li class="form-stepper-unfinished text-center form-stepper-list" step="2">
                <a class="mx-2">
                    <span class="form-stepper-circle text-muted">
                        <span>2</span>
                    </span>
                    <div class="label text-muted">व्यक्तिगत विवरण - 2</div>
                </a>
            </li>
            <!--step3 -->
            <!-- <li class="form-stepper-unfinished text-center form-stepper-list" step="3">
                <a class="mx-2">
                    <span class="form-stepper-circle text-muted">
                        <span>3</span>
                    </span>
                    <div class="label text-muted">पते का विवरण</div>
                </a>
            </li> -->

            <li class="form-stepper-unfinished text-center form-stepper-list" step="4">
                <a class="mx-2">
                    <span class="form-stepper-circle text-muted">
                        <span>4</span>
                    </span>
                    <div class="label text-muted">शैक्षिक योग्यता</div>
                </a>
            </li>
            <!-- Step 3 -->
            <li class="form-stepper-unfinished text-center form-stepper-list" step="5">
                <a class="mx-2">
                    <span class="form-stepper-circle text-muted">
                        <span>5</span>
                    </span>
                    <div class="label text-muted">अपलोड फोटो</div>
                </a>
            </li>
            <!-- Step 4 -->
            <li class="form-stepper-unfinished text-center form-stepper-list" step="6">
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
                <center>
                    <h4><u>व्यक्तिगत विवरण - 1</u></h4>
                </center>
                <form class="row g-3 needs-validation mt-2" onsubmit="return validateForm()" id="userAccountSetupForm" name="form1" method="post" action="formSubmit.php" novalidate>
                    <input type="hidden" name="uid" value="<?php echo $_SESSION['uid']; ?>">
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="district" class="placeholder"> जनपद का नाम <span class="text-danger">*</span></label>
                            <select class="form-control form-select" name="district_name" id="district" required>
                                <option value="">कृप्या विकल्प चुने</option>
                                <?php
                                $result = mysqli_query($conn, "SELECT * FROM `districts` ORDER BY `district_name`");
                                while ($row = mysqli_fetch_array($result)) {
                                    $selected = (isset($pdata) && $pdata['district'] == $row['id']) ? 'selected="selected"' : '';
                                ?>
                                    <option value="<?php echo $row['id']; ?>" <?php echo $selected; ?>>
                                        <?php echo $row['district_name']; ?>
                                    </option>
                                <?php
                                } ?>
                            </select>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="district" class="placeholder"> परियोजना<span class="text-danger">*</span></label>
                            <select class="form-control form-select" name="project" id="project" required>
                                <option value="">कृप्या विकल्प चुने</option>
                                <?php
                                $result = mysqli_query($conn, "SELECT * FROM `projects` ORDER BY `project_name`");
                                while ($row = mysqli_fetch_array($result)) {
                                    $selected = (isset($pdata) && $pdata['project'] == $row['id']) ? 'selected="selected"' : '';
                                ?>
                                    <option value="<?php echo $row['id']; ?>" <?php echo $selected; ?>>
                                        <?php echo $row['project_name']; ?>
                                    </option>
                                <?php
                                } ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="district" class="placeholder"> शहरी/ग्रामीण <span class="text-danger">*</span></label>
                            <select class="form-control form-select" name="grameen_sehri" id="r_b" required>
                                <option value="" disable>कृप्या विकल्प चुने</option>
                                <option value="1" <?php if (isset($pdata)) {
                                                        if ($pdata['grameen_sehri'] == '1') : ?> selected="selected" <?php endif;
                                                     } ?>>शहरी</option>
                                <option value="2" <?php if (isset($pdata)) {
                                                        if ($pdata['grameen_sehri'] == '2') : ?> selected="selected" <?php endif;
                                                    } ?>>ग्रामीण</option>

                             
                            </select>
                        </div>
                    </div>

                    
                        <div class="col-md-4" id="gramp" style="<?php  if(isset($pdata)){
                    if($pdata['grameen_sehri'] == 2) { echo 'display:block'; } else{ echo 'display:none';}} ?>">
                            <div class="form-group mb-3">
                                <label for="district" class="placeholder" > <span id="lablegram" > </span> <span id="lableward">ग्राम पंचायत/वार्ड का नाम </span><span class="text-danger">*</span></label>
                                <select class="form-control form-select" name="gram_panchayat" id="gram_p" required>
                                    <option value="">कृप्या विकल्प चुने</option>
                                    <!-- <option value="bkt">ग्राम पंचायत-1</option> -->
                                    <?php
                                    if (isset($pdata)) {
                                        $q = "SELECT * FROM `gram_panchayat` where project_id='" . $pdata['project'] . "'";
                                        $result = mysqli_query($conn, $q);
                                        while ($row = mysqli_fetch_array($result)) {
                                            $selected = (isset($pdata) && $pdata['gram_panchayat'] == $row['id']) ? 'selected="selected"' : '';
                                    ?>
                                            <option value="<?php echo $row['id']; ?>" <?php echo $selected; ?>>
                                                <?php echo $row['gram_panchayat']; ?>
                                            </option>
                                    <?php
                                        }
                                    } ?>

                                </select>
                            </div>
                        </div>
                   
                       
                    
                    <div class="col-md-4" id="nyap">
                        <div class="form-group mb-3">
                            <label for="district" class="placeholder"> न्याय पंचायत का नाम <span class="text-danger">*</span></label>
                            <input type="text" name="nya_panchyat" class="form-control str" value="<?php if (isset($pdata)) {
                                                                                                                            echo $pdata['name_hi'];
                                                                                                                        }  ?>" x>
                        </div>
                    </div>
                    <!-- <div class="col-md-4">
                        <div class="form-group mb-3">
                            <label for="district" class="placeholder"> रिक्त पद का नाम <span class="text-danger">*</span></label>
                            <select class="form-control form-select" name="rikt_pd" id="tahsil" required>
                                <option value="">कृप्या विकल्प चुने</option>
                                <option value="1" <?php if (isset($pdata)) {
                                                        if ($pdata['rikt_pd'] == '1') : ?> selected="selected" <?php endif;
                                                                                                        } ?>>आंगनवाड़ी कार्यकत्री</option>
                                <option value="2" <?php if (isset($pdata)) {
                                                        if ($pdata['rikt_pd'] == '2') : ?> selected="selected" <?php endif;
                                                                                                        } ?>> सहायिका</option>

                            </select>
                        </div>
                    </div> -->

                    <div class="col-md-4">
                        <label for="validationCustom04" class="form-label">रिक्त आंगनवाड़ी केंद्र का नाम<span class="text-danger">*</span></label>
                        <select class="form-control form-select" name="rikt_aww_center" id="rikt_center" required>
                            <!-- <option value="">कृप्या विकल्प चुने</option> -->
                            <?php
                          
                               echo'<option value="'.$pdata['rikt_aww_center'].'">'.getawwCenter($pdata['rikt_aww_center']). '</option>';
                            ?>
                        </select>


                    </div>
                    <div class="row"></div>
                    <div class="col-md-4">
                        <label for="validationCustom02" class="form-label">आवेदिका का हिंदी में नाम <span class="text-danger">*</span></label>
                        <div class="input-group has-validation">
                            <select name="pre_name" id="pre_name">
                                <option value="" disable>चुने</option>
                                <option value="1" <?php if (isset($pdata)) {
                                                        if ($pdata['pre_name'] == '1') : ?> selected="selected" <?php endif;
                                                                                                        } ?>>श्रीमती </option>
                                <option value="2" <?php if (isset($pdata)) {
                                                        if ($pdata['pre_name'] == '2') : ?> selected="selected" <?php endif;
                                                                                                        } ?>>कुमारी</option>
                            </select>
                            <input type="text" class="form-control" name="applicant_name" id="validationCustom02" value="<?php if (isset($pdata)) {
                                                                                                                                echo $pdata['name_hi'];
                                                                                                                            }  ?>" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="validationCustom02" class="form-label">आवेदिका का अंग्रेजी में नाम<span class="text-danger">*</span></label>
                        <div class="input-group has-validation">

                            <input type="text" class="form-control" name="applicant_name_en" id="validationCustom02" value="<?php if (isset($pdata)) {
                                                                                                                                echo $pdata['name_en'];
                                                                                                                            }  ?>" required>
                        </div>


                    </div>

                    <!-- <div class="col-md-4">
                        <label for="validationCustomUsername" class="form-label">वैवाहिक स्थिति </label>
                        <div class="input-group has-validation">
                            <select class="form-select" id="married_status" name="married_status" required>
                                <option disabled value="" selected>कृप्या विकल्प चुने </option>
                                <option value="M" <?php if (isset($pdata)) {
                                                        if ($pdata['married_status'] == 'M') : ?> selected="selected" <?php endif;
                                                                                                                } ?>>विवाहित</option>
                                <option value="UM" <?php if (isset($pdata)) {
                                                        if ($pdata['married_status'] == 'UM') : ?> selected="selected" <?php endif;
                                                                                                                } ?>>अविवाहित</option>
                            </select>

                        </div>
                    </div>

 -->

                    <div class="col-md-4">
                        <label for="validationCustom02" class="form-label">पिता का नाम<span class="text-danger">*</span></label>
                        <input type="text" name="father_name" class="form-control" value="<?php if (isset($pdata)) {
                                                                                                echo $pdata['fname'];
                                                                                            }  ?>" required>

                    </div>

                    <div class="col-md-4">
                        <label for="validationCustomUsername" class="form-label">माता का नाम</label>
                        <div class="input-group has-validation">
                            <input type="text" name="mother_name" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" value="<?php if (isset($pdata)) {
                                                                                                                                                                        echo $pdata['mname'];
                                                                                                                                                                    }  ?>" required>

                        </div>
                    </div>
                    <div class="col-md-4" id="husbanddiv">
                        <label for="validationCustom02" class="form-label">पति का नाम</label>
                        <input type="text" name="husband_name" class="form-control" id="husband_name" value="<?php if (isset($pdata)) {
                                                                                                                    echo $pdata['hname'];
                                                                                                                }  ?>" required>

                    </div>

                    <div class="col-md-4">
                        <label for="validationCustom02" class="form-label">आवेदिका का मोबाइल नंबर<span class="text-danger">*</span></label>
                        <input type="text" name="mobile" class="form-control" id="validationCustom02" value="<?php echo $_SESSION['mobile']; ?>" disabled required>

                    </div>


                    <div class="col-md-3">
                        <label for="validationCustomUsername" class="form-label">जन्मतिथि </label>
                        <div class="input-group has-validation">
                            <input type="date" class="form-control" name="dob" id="dob" aria-describedby="inputGroupPrepend" value="<?php if (isset($pdata)) {
                                                                                                                                        echo $pdata['date_of_birth'];
                                                                                                                                    }  ?>" >
                        </div>
                    </div>
                    <div class=" col-md-6">
                        <div class="row">

                            <div class="col-2">
                                <label for="validationCustomUsername" class="form-label">वर्ष <span class="text-danger">*</span></label>
                                <div class="input-group has-validation">
                                    <input type="text" class="form-control" name="year" id="year" aria-describedby="inputGroupPrepend" required value="<?php if (isset($pdata)) {
                                                                                                                                                            echo $pdata['year'];
                                                                                                                                                        }  ?>">

                                </div>
                            </div>
                            <div class="col-2">
                                <label for="validationCustomUsername" class="form-label">माह<span class="text-danger">*</span></label>
                                <div class="input-group has-validation">
                                    <input type="text" class="form-control" name="month" id="month" aria-describedby="inputGroupPrepend" required value="<?php if (isset($pdata)) {
                                                                                                                                                        echo $pdata['month'];
                                                                                                                                                    }  ?>">

                                </div>
                            </div>
                            <div class="col-2">
                                <label for="validationCustomUsername" class="form-label"> दिन</label>
                                <div class="input-group has-validation">
                                    <input type="text" class="form-control" name="day" id="day" aria-describedby="inputGroupPrepend" required value="<?php if (isset($pdata)) {
                                                                                                                                                    echo $pdata['day'];
                                                                                                                                                }  ?>">

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-4">
                        <label for="validationCustomUsername" class="form-label">दिनांक 01 जनवरी, 2024 को आवेदिका की आयु</label>
                    </div>

                    <?php
                    if (isset($pdata)) {
                    ?>
                        <div class="col-12">
                            
                            <button class="button btn-navigate-form-step" type="submit" step_number="2" name="save1">अपडेट & अगला</button>
                        </div>
                    <?php
                    } else {
                    ?>
                        <div class="col-12">
                            <button class="button btn-navigate-form-step" type="submit" step_number="2" name="save1">अगला</button>
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
            <button class="button btn-navigate-form-step" type="button" step_number="2">
                Prev
            </button>
            <button class="button btn-navigate-form-step" type="button" step_number="4">
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
            <button class="button btn-navigate-form-step" type="button" step_number="3">
                Prev
            </button>
            <button class="button btn-navigate-form-step" type="button" step_number="5">
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
            <button class="button btn-navigate-form-step" type="button" step_number="4">
                Prev
            </button>
            <button class="button btn-navigate-form-step" type="button" step_number="6">
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
            <button class="button btn-navigate-form-step" type="button" step_number="5">
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
    $(document).ready(function() {
        $("#dob").change(function() {
            var mdate = $("#dob").val().toString();
            // alert(mdate);
            //console.log(mdate);
            var yearThen = parseInt(mdate.substring(0, 4), 10);
            var monthThen = parseInt(mdate.substring(5, 7), 10);
            var dayThen = parseInt(mdate.substring(8, 10), 10);
            var today = new Date();
           // alert(today);
            var birthday = new Date(yearThen, monthThen - 1, dayThen);

            var differenceInMilisecond = today.valueOf() - birthday.valueOf();

            var year_age = Math.floor(differenceInMilisecond / 31536000000);
            var day_age = Math.floor((differenceInMilisecond % 31536000000) / 86400000);

            if ((today.getMonth() == birthday.getMonth()) && (today.getDate() == birthday.getDate())) {
                alert("Happy B'day!!!");
            }
            var month_age = Math.floor(day_age / 30);
            day_age = day_age % 30;
            if (isNaN(year_age) || isNaN(month_age) || isNaN(day_age)) {
                $("#exact_age").text("Invalid birthday - Please try again!");
            } else {
                // alert(day_age);
                $("#year").val(year_age);
                $("#month").val(month_age);
                $("#day").val(day_age);
                // $("#exact_age").html("You are<br/><span id=\"age\">" + year_age + " years " + month_age + " months " + day_age + " days</span> old");
            }
            //alert(year_age);
        });
    });
</script>


<script>
    $(function() {
        // $('#row_dim').hide(); 
        $('#pre_name').change(function() {
            //alert($('#husband_name').val());
            if ($('#pre_name').val() == '1') {
                $('#husbanddiv').show();
            } else {
                $('#husbanddiv').hide();
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
            data: 'distid=' + val,
            success: function(data) {
                $("#block").html('');
                $("#block").html(data);
            }
        });
    }
</script>

<script>
    $(document).ready(function() {
        $('#district').on('change', function() {
            var district_name = this.value;
            $.ajax({
                url: "../ajax.php",
                type: "POST",
                data: {
                    district_id: district_name
                },
                cache: false,
                success: function(result) {
                    $("#tehsil").html(result);


                }
            });


        });

        $('#district').on('change', function() {
            var project_name = this.value;
            $.ajax({
                url: "../ajax.php",
                type: "POST",
                data: {
                    project_name: project_name
                },
                cache: false,
                success: function(result) {
                    $("#project").html(result);

                }
            });


        });

        $('#r_b').on('change', function() {
            var ru = $('#r_b').val();
            if(ru=='1'){
                    $('#nyap').hide();
                }
                else{
                    $('#nyap').show();
                }
        });

        $('#project').on('change', function() {
            var ru = $('#r_b').val();
            
          
                var projectid = $('#project').val();
                var distid = $('#district').val();
                $.ajax({
                    url: "../ajax.php",
                    type: "POST",
                    data: {
                        gramp: ru,
                        projectID: projectid,
                        distID: distid
                    },
                    cache: false,
                    success: function(result) {
                      
                        $('#gram_p').html('');
                        if (gramp == '1') {
                            $('#gram_p').html(result);
                            
                          
                        } else {
                            $('#gram_p').html(result);
                            $('#gramp').show();
                            

                        }
                        // $('#gram_p').html('<option value="">कृप्या विकल्प चुने</option>');


                    }
                });
           


        });


        // $('#r_b').on('change', function() {
        //     var gramp = this.value;
        //     var projectid = $('#project').val();
        //     $.ajax({
        //         url: "../ajax.php",
        //         type: "POST",
        //         data: {
        //             gramp: gramp,
        //             projectID: projectid
        //         },
        //         cache: false,
        //         success: function(result) {
        //             $('#gram_p').html('');
        //             if (gramp == '1') {
        //                 $('#gram_p').html(result);
                       
        //             } else {
        //                 $('#gram_p').html(result);


        //             }
        //             // $('#gram_p').html('<option value="">कृप्या विक्लप चुने</option>');


        //         }
        //     });


        // });



        $('#gram_p').on('change', function() {
            var gramp = this.value;
            var projectid = $('#project').val();
            var dist = $('#district').val();
            $.ajax({
                url: "../ajax.php",
                type: "POST",
                data: {
                    grampanchayatID: gramp,
                    pid: projectid,
                    distID:dist
                },
                cache: false,
                success: function(result) {
                    $("#rikt_center").html('');
                    $("#ward_name").html('');
                    $("#rikt_center").html(result);
                }
            });


        });

        $('#ward_name').on('change', function() {
            var ward_name = this.value;
            var projectid = $('#project').val();
            $.ajax({
                url: "../ajax.php",
                type: "POST",
                data: {
                    grampanchayatID: ward_name,
                    pid: projectid

                },
                cache: false,
                success: function(result) {
                    $("#gram_p").html('');
                    $("#rikt_center").html('');
                    $("#rikt_center").html(result);
                }
            });


        });

        // $('#r_b').on('change', function() {
        //     var gramp = this.value;
        //     var project = $('#project').val();
        //     $.ajax({
        //         url: "../ajax.php",
        //         type: "POST",
        //         data: {
        //             project_id: gramp

        //         },
        //         cache: false,
        //         success: function(result) {
        //             $("#rikt_center").html(result);


        //         }
        //     });


        // });
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
            data: 'distid=' + val,
            success: function(data) {
                $("#block").html('');
                $("#block").html(data);
            }
        });
    }
</script>
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

<?php footer(); ?>


</body>

</html>