<?php
include('../config/db_config.php');
include('../config/settings.php');

if (!checkLogin()) {
    header('Location: login.php');
}
if (isset($_SESSION['uid'])) {
    $sql = "SELECT * FROM users WHERE `id`='" . $_SESSION['uid'] . "'";
    $res = $conn->query($sql);
    $data = mysqli_fetch_assoc($res);
    $sql = "SELECT * FROM academic_details WHERE `userid`='" . $_SESSION['uid'] . "'";
    //echo $sql; die;
    $res = $conn->query($sql);
    if (mysqli_num_rows($res) >= 1) {
        $pdata = mysqli_fetch_assoc($res);
        $status = '1';
    }
    //print_r($data); die;
}

topheader();



?>
<div class="screen" style="display: none"> <span class="loader"></span> </div>
<header class="header">
    <div class="container-fluid ">
        <div class="row">
            <div class="col-2 text-center col-md-1 b-rights px-0"><img src="../public/images/logo.png" alt="" class="dash-logo" /></div>
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
<div class="contentwraper mt-5">
    <?php
    if (isset($_SESSION['success'])) {
        echo '<div class="alert alert-success alert-dismissible">
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>' . $_SESSION['success'] . '
            </div>';
    }
    unset($_SESSION['success']);
    ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-1 col-2">
                <a title="Dashboard" href="dashboard.php" style="color: #282d6a;" class="intentbtn">
                    <span class="intenticon">
                        <span class="icons icon-home" style="font-size: 32px;"></span>
                    </span></a>
            </div>

            <div class="col-md-3 col-10"> <a href="academic_details.php" class="intentbtn bg-c-yellow">
                    <span class="intenticon">
                        <img src="../public/images/icon1.png">
                    </span> <span class="intentdata"> <b class="intentno"></b> Anganwadi Application Form </span> </a>
            </div>
            <div class="col-md-7">
                <div class="row mt-4">
                    <div class="col-md-4 col-12 text-center"> <strong> Applicant's Name </strong>: <?php echo $data['name']; ?> </div>
                    <div class="col-md-4 col-12 text-center"> <strong>Father Name</strong> : <?php echo $data['father_name']; ?>
                    </div>
                    <div class="col-md-4 col-12 text-center"><strong>Mobile No.</strong> : <?php echo $data['mobile']; ?>
                    </div>
                </div>


            </div>

            <div class="border bg-light p-2 mb-2">

            </div>
        </div>

        <!-- start here -->
        <div id="multi-step-form-container">
            <!-- Form Steps / Progress Bar -->
            <ul class="form-stepper form-stepper-horizontal text-center mx-auto pl-0">
                <!-- Step 1 -->
                <li class="form-stepper-active text-center form-stepper-list" step="1">
                    <a class="mx-2">
                        <span class="form-stepper-circle">
                            <span>1</span>
                        </span>
                        <div class="label">व्यक्तिगत विवरण - 1 </div>
                    </a>
                </li>
                <!-- Step 2 -->
                <!-- <li class="form-stepper-active text-center form-stepper-list" step="2">
                    <a class="mx-2">
                        <span class="form-stepper-circle text-muted">
                            <span>2</span>
                        </span>
                        <div class="label text-muted">यक्तिगत विवरण - 2</div>
                    </a>
                </li> -->
                <!--step3 -->
                <li class="form-stepper-active text-center form-stepper-list" step="3">
                    <a class="mx-2">
                        <span class="form-stepper-circle text-muted">
                            <span>2</span>
                        </span>
                        <div class="label text-muted">व्यक्तिगत विवरण - 2</div>
                    </a>
                </li>

                <li class="form-stepper-active text-center form-stepper-list" step="4">
                    <a class="mx-2">
                        <span class="form-stepper-circle text-muted">
                            <span>3</span>
                        </span>
                        <div class="label text-muted">शैक्षिक योग्यता</div>
                    </a>
                </li>
                <!-- Step 3 -->
                <li class="form-stepper-unfinished text-center form-stepper-list" step="5">
                    <a class="mx-2">
                        <span class="form-stepper-circle text-muted">
                            <span>4</span>
                        </span>
                        <div class="label text-muted">अपलोड फोटो</div>
                    </a>
                </li>
                <!-- Step 4 -->
                <li class="form-stepper-unfinished text-center form-stepper-list" step="6">
                    <a class="mx-2">
                        <span class="form-stepper-circle text-muted">
                            <span>5</span>
                        </span>
                        <div class="label text-muted">घोषणापत्र</div>
                    </a>
                </li>
            </ul>


            </section>
            <!-- Step 3 Content, default hidden on page load. -->
            <section id="step-3" class="form-step">
                <form  class="needs-validation  g-3 mt-2" name="form1" method="post" action="formSubmitTest.php"  enctype="multipart/form-data" id="userAccountSetupForm" novalidate >
                    <center>
                        <h2 class="mb-3"><u>शैक्षिक योग्यता का विवरण( अंग्रेजी के अंको में भरें)</u></h2>
                    </center>
                    <table class="table table-bordered border-primary mt-3">
                        <thead>
                            <tr>
                                <th scope="col" style="font-size:13px;">क्रम.स०</th>
                                <th scope="col" style="font-size:13px;">कक्षा</th>
                                <th scope="col" style="font-size:13px;">विद्यालय का नाम</th>
                                <th scope="col" style="font-size:13px;">बोर्ड का नाम</th>
                                <th scope="col" style="font-size:13px;">उत्तीर्ण वर्ष</th>
                                <th scope="col" style="font-size:13px;">पूर्णांक </th>
                                <th scope="col" style="font-size:13px;">प्राप्तांक</th>
                                <th scope="col" style="font-size:13px;">प्रतिशत</th>
                                <!-- <th scope="col" style="font-size:13px;">श्रेणी/ग्रेड/सीजीपीए</th> -->
                                <th scope="col" style="font-size:13px;text-align:center" colspan="2">जरुरी दस्तावेज़ अपलोड करें<span style="color:red;">(Max upload size 35KB - Only image format  png,jpg,jpeg) </span></th>

                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>
                                    हाईस्कूल
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="h_school" value="<?php if (isset($pdata)) {
                                                  echo $pdata['h_school'];
                                             } ?>" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="h_board" value="<?php if (isset($pdata)) {
                                                                                                        echo $pdata['h_board'];
                                                                                                    } ?>" required>
                                </td>
                                <td>
                                    <input type="text" minlength="4" maxlength="4" class="form-control" name="h_year" value="<?php if (isset($pdata)) {
                                                                                                        echo $pdata['h_year'];
                                                                                                    } ?>" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="h_maxmarks" value="<?php if (isset($pdata)) {
                                                                                                            echo $pdata['h_maxmarks'];
                                                                                                        } ?>" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="h_totalmarks" value="<?php if (isset($pdata)) {
                                                                                                            echo $pdata['h_totalmarks'];
                                                                                                        } ?>" required>
                                </td> 
                                 <td>
                                    <input type="text" class="form-control" name="h_present" value="<?php if (isset($pdata)) {
                                                                                                        echo $pdata['h_present'];
                                                                                                    } ?>" required>
                                </td>


                                <td><input type="file" class="form-control" name="h_marksheetdoc" value="<?php if (isset($pdata)) {
                                                echo $pdata['h_marksheetdoc'];
                                                                      } ?>" required>हाईस्कूल  मार्कशीट 
                                                                                    <br>
                         <?php if (isset($pdata)) { if($pdata['h_marksheetdoc'] !=''){ echo '<a href="'.$pdata['h_marksheetdoc'].'" target="_blank"> View Privious uploaded file</a>';} }?>
                                                                                                            </td>
                                <td>
                                    <input type="file" class="form-control" name="h_otherdoc" value="<?php if (isset($pdata)) {
                                                                                                            echo $pdata['h_otherdoc'];
                                                                                                        } ?>">हाईस्कूल प्रमाणपत्र 
<br>  <?php if (isset($pdata)) { if($pdata['h_otherdoc'] !=''){ echo '<a href="'.$pdata['h_otherdoc'].'" target="_blank"> View Privious uploaded file</a>';} }?>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>
                                    इंटरमीडिएट
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="i_school" value="<?php if (isset($pdata)) {
                                                                                                        echo $pdata['i_school'];
                                                                                                    } ?>" requied>
                                                                                                    <br>
                       
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="i_board" value="<?php if (isset($pdata)) {
                                              echo $pdata['i_board'];
                                 } ?>" requied><br>
                                
                                </td>
                                <td>
                                    <input type="text" class="form-control" minlength="4" maxlength="4" name="i_year" value="<?php if (isset($pdata)) {
                                                                                                        echo $pdata['i_year'];
                                                                                                    } ?>" requied>
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="i_maxmarks" value="<?php if (isset($pdata)) {
                                                                        echo $pdata['i_maxmarks'];
                                          } ?>" requied>
                                          <br>
                                         
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="i_totalmarks" value="<?php if (isset($pdata)) {
                                                                                                            echo $pdata['i_totalmarks'];
                                                                                                        } ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="i_present" value="<?php if (isset($pdata)) {
                                                                                                        echo $pdata['i_present'];
                                                                                                    } ?>">
                                </td>

                                <td>
                                    <input type="file" class="form-control" name="i_marksheetdoc" value="<?php if (isset($pdata)) {
                                                                                                                echo $pdata['i_marksheetdoc'];
                                     } ?>" required>इंटरमीडिएट मार्कशीट
                                     <br> <?php if (isset($pdata)) { if($pdata['i_marksheetdoc'] !=''){ echo '<a href="'.$pdata['i_marksheetdoc'].'" target="_blank"> View Privious uploaded file</a>';} }?>
                                </td>
                                <td>
                                    <input type="file" class="form-control" name="i_otherdoc" value="<?php if (isset($pdata)) {
                                                  echo $pdata['i_otherdoc'];
                                      } ?>">इंटरमीडिएट प्रमाणपत्र  <br>
                                    <?php if (isset($pdata)) { if($pdata['i_otherdoc'] !=''){ echo '<a href="'.$pdata['i_otherdoc'].'" target="_blank"> View Privious uploaded file</a>';} }?>

                                </td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>
                                    स्नातक
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="g_school" value="<?php if (isset($pdata)) {
                                                                                                        echo $pdata['g_school'];
                                                                                                    } ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="g_board" value="<?php if (isset($pdata)) {
                                                                                                        echo $pdata['g_board'];
                                                                                                    } ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" minlength="4" maxlength="4" name="g_year" value="<?php if (isset($pdata)) {
                                                                                                        echo $pdata['g_year'];
                                                                                                    } ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="g_maxmarks" value="<?php if (isset($pdata)) {
                                                                                                            echo $pdata['g_maxmarks'];
                                                                                                        } ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="g_totalmarks" value="<?php if (isset($pdata)) {
                                                                                                            echo $pdata['g_totalmarks'];
                                                                                                        } ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="g_present" value="<?php if (isset($pdata)) {
                                                                                                        echo $pdata['g_present'];
                                                                                                    } ?>">
                                </td>

                                <td>
                                    <input type="file" class="form-control" name="g_marksheetdoc" value="<?php if (isset($pdata)) {
                                                                                                                echo $pdata['g_marksheetdoc'];
                                     } ?>" >स्नातक फाइनल ईयर मार्कशीट
                                     <br>
                                     <?php if (isset($pdata)) { if($pdata['g_marksheetdoc'] !=''){ echo '<a href="'.$pdata['g_marksheetdoc'].'" target="_blank"> View Privious uploaded file</a>';} }?>
                                </td>
                                <td>
                                    <input type="file" class="form-control" name="g_otherdoc" value="<?php if (isset($pdata)) {
                                                     echo $pdata['g_otherdoc'];
                                 } ?>">स्नातक डिग्री <br>
                                 <?php if (isset($pdata)) { if($pdata['g_otherdoc'] !=''){ echo '<a href="'.$pdata['g_otherdoc'].'" target="_blank"> View Privious uploaded file</a>';} }?>

                                </td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>
                                    स्नातकोत्तर
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="pg_school" value="<?php if (isset($pdata)) {
                                                                                                        echo $pdata['pg_school'];
                                                                                                    } ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="pg_board" value="<?php if (isset($pdata)) {
                                                                                                        echo $pdata['pg_board'];
                                                                                                    } ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" minlength="4" maxlength="4" name="pg_year" value="<?php if (isset($pdata)) {
                                                                                                        echo $pdata['pg_year'];
                                                                                                    } ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="pg_maxmarks" value="<?php if (isset($pdata)) {
                                                                                     echo $pdata['pg_maxmarks'];
                                                                                                        } ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="pg_totalmarks" value="<?php if (isset($pdata)) {
                                                                                                            echo $pdata['pg_totalmarks'];
                                                                                                        } ?>">
                                </td>
                                <td>
                                    <input type="text" class="form-control" name="pg_present" value="<?php if (isset($pdata)) {
                                                                                                            echo $pdata['pg_present'];
                                                                                                        } ?>">
                                </td>

                                <td>
                                    <input type="file" class="form-control" name="pg_marksheetdoc" value="<?php if (isset($pdata)) {
                                                                                                                echo $pdata['pg_marksheetdoc'];
                                    } ?>" >स्नातकोत्तर फाइनल ईयर मार्कशीट <br>
                                      <?php if (isset($pdata)) { if($pdata['pg_marksheetdoc'] !=''){ echo '<a href="'.$pdata['pg_marksheetdoc'].'" target="_blank"> View Privious uploaded file</a>';} }?>
                                </td>
                                <td>
                                    <input type="file" class="form-control" name="pg_otherdoc" value="<?php if (isset($pdata)) {
                                              echo $pdata['pg_otherdoc'];
                           } ?>">स्नातकोत्तर डिग्री <br>
                           <?php if (isset($pdata)) { if($pdata['pg_otherdoc'] !=''){ echo '<a href="'.$pdata['pg_otherdoc'].'" target="_blank"> View Privious uploaded file</a>';} }?>

                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <a href="personal_details.php"><button class="btn btn-primary" type="button">पिछला</button></a>
                    <button class="btn btn-primary" type="submit" name="academicSubmit">अगला</button>
                </form>
                <!-- <div class="mt-3">
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
              </button> -->

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
<?php footer(); ?>


<script>
    $(document).ready(function() {

        $("#greivance_details").on('keyup', function() {
            var words = this.value.match(/\S+/g).length;

            if (words > 200) {
                // Split the string on first 100 words and rejoin on spaces
                var trimmed = $(this).val().split(/\s+/, 200).join(" ");
                // Add a space at the end to keep new typing making new words
                $(this).val(trimmed + " ");
            } else {
                $('#display_count').text(words + ' Words Count');
                $('#greivance_details').text(200 - words);
            }
        });
    });




    $(document)
        .ajaxStart(function() {
            $(".screen").show();
        })
        .ajaxStop(function() {
            $(".screen").hide();
        });
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

</body>

</html>