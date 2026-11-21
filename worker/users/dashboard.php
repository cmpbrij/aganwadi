<?php
include('../config/db_config.php');
include('../config/settings.php');
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if (!checkLogin()) {
  header('Location: login.php');
}

if (isset($_SESSION['uid'])) {
  $sql = "SELECT * FROM users WHERE `id`='" . $_SESSION['uid'] . "'";
  $res = $conn->query($sql);
  $data = mysqli_fetch_assoc($res);

  $sql = "SELECT district,project,gram_panchayat FROM new_application_details WHERE `userid`='" . $_SESSION['uid'] . "'";

  $res = execute_query($sql);
  if (mysqli_num_rows($res) >= 1) {
    $pdata = mysqli_fetch_array($res);
    $pnaid = $pdata['gram_panchayat'];
  }

  $sql = "SELECT * FROM personal_details WHERE `userid`='" . $_SESSION['uid'] . "'";

  $res = execute_query($sql);
  if (mysqli_num_rows($res) >= 1) {
    $pd = mysqli_fetch_array($res);
  }

  $sql1 = "SELECT last_date FROM vacancy_order WHERE `dist_id`='" . $data['district'] . "'";

  $res1 = execute_query($sql1);
  if (mysqli_num_rows($res1) >= 1) {
    $vdata = mysqli_fetch_array($res1);
  } else {
    echo "Not Valid";
    die;
  }
}


topheader();
?>
<style>
  .box1 {
    background-color: #ff562f;
    min-height: 50px;
    width: 90%;
  }
</style>
<div class="screen" style="display: none"> <span class="loader"></span> </div>
<header class="header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-2 text-center col-md-1 b-rights px-0"><img
          src="../public/images/logo.png" alt="" class="dash-logo" /></div>
      <div class="col-9 col-md-9 px-0">
        <h4 class="moudlename">Anganwadi Recruitment Uttar Pradesh </h4>
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
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-1 col-2">
        <a title="Dashboard" href="dashboard.php" style="color: #282d6a;" class="intentbtn">
          <span class="intenticon">
            <span class="icons icon-home" style="font-size: 32px;"></span>
          </span>
        </a>
      </div>
      <div class="col-md-1 col-2"></div>
      <div class="col-md-3 col-10"> <a href="#"
          class="intentbtn bg-c-yellow">
          <span class="intenticon">
            <img src="../public/images/icon1.png">
          </span> <span class="intentdata"> <b class="intentno"></b>Hello, <?php echo $data['name']; ?> Welcome </span> </a>
      </div>
      <div class="col-md-3 col-10"> <a href="#"
          class="intentbtn bg-c-yellow">
          <span class="intenticon">
            <img src="../public/images/icon1.png">
          </span> <span class="intentdata">
            <div id="myDiv"></div>
          </span>
        </a>
      </div>
    </div>
     <?php
                            $success_msg = $_SESSION['success'] ?? '';
                            $error_msg   = $_SESSION['error'] ?? '';
                            $errorMessages = $_SESSION['errorMessages'] ?? [];
                        ?>
                          <!-- Display Success Message -->
                    <?php if (!empty($success_msg)): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success_msg); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Display Error Message -->
                    <?php if (!empty($error_msg)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle"></i> <?php echo htmlspecialchars($error_msg); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($errorMessages)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <h6 class="alert-heading">कृपया निम्नलिखित त्रुटियाँ सुधारें:</h6>
                            <ul class="mb-0">
                                <?php foreach ($errorMessages as $error): ?>
                                    <li><?php echo htmlspecialchars($error); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>
                    <?php
                        unset($_SESSION['success'], $_SESSION['error'], $_SESSION['errorMessages']);
                    ?>
    <div class="row mt-4">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">
            <h3>Applied Details</h3>
          </div>
          <div class="card-body">
            <table class="table no-border">
              <style>
                .font-weight-600 {
                  font-weight: 700;
                  font-size: 16px;
                }

                .appno {
                  color: #0052cc;
                }

                .recv {
                  color: #04a08b;
                }

                .down {
                  color: #ff9920;
                }
              </style>
              <?php
              $appl=[];
              $sql = "SELECT * FROM `decleration` where userid='" . $_SESSION['uid'] . "'";
              $res = execute_query($sql);
              $rowchecck=mysqli_num_rows($res);
              if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_array($res)) {
                      $appl[]=$row['aganwadi_center'];
                  echo '<tr>
                        <td width="8%"> <img src="../images/aganwadi.png" class="" alt="" width="60"></td>
                        <td><p class="font-weight-600">Application No:<br><span class="appno">' . $row['application_no'] . '<span></p></td>
                        <td><p class="font-weight-600">Category:<br><span class="appno">' . getCategoryText($row['category']) . '<span></p></td>
                        <td><p class="font-weight-600">Received on:<br><span class="recv">' . date('d-m-Y',strtotime($row['filled_date'])) . '</span></p></td>
                        <td><div class="text-md-right font-weight-600">
                            <p class="mb-40"></p>
                            <a href="viewDetails.php?appNo=' . $row['application_no'] . '" class="text-primary" target="_blank">VIEW DETAILS</a><br>
                          </div>
                        </td>
                      </tr>';
                }
              } else {
                if ($data['application_no'] == 'R') {
                  echo "<div style='color:red;'>Can not apply</div>";
                } else {
                  echo "<tr><td> No data found - <a href='step-1.php'>Fill full form</a>";
                }
              }

              ?>
              <!-- <a href="download.php?appNo='.$row['application_no'].'" target="_blank" ><span class="down" > Download</span></a> -->
              <hr>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      
      <div class="col-md-4">
        <div class="card">
          <div class="card-header">
            <h3>Details</h3>
          </div>
          <div class="card-body">

            Registered Mobile Number : <b> <?php echo $data['mobile']; ?></b><br>
            District Name : <b> <?php echo getdistName($data['district']); ?> </b><br>
            Project: <?php echo getBlockname($pdata['project']); ?> <br>
            Grampanchyat/Ward: <?php echo $pdata['gram_panchayat']; ?> <br>
            Last Date: <b><?php echo date('d/m/Y', strtotime($vdata['last_date'])); ?></b>

          </div>
        </div>
      </div>
    
      <div class="col-md-8">
        <div class="card">
          <?php if ($vdata['last_date'] >= date('Y-m-d')) { ?>
            <div class="card-header">
              <h3>Apply in more than one places in same gram panchyat/ward</h3>
            </div>
            <div class="card-body">
              <form method="post" action="formSubmit.php">
                <div class="row">
                  <div class="col-md-4" id="gramp">
                    <div class="form-group mb-3">
                      <label for="gram_pan" class="placeholder"> ग्राम पंचायत <span class="text-danger">*</span></label>
                      <input type="text" class="form-control" name="gram_panchayat" id="gram_pan" value="<?php if ($pdata['gram_panchayat'] != '') { echo $pdata['gram_panchayat']; } ?>" disabled>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <label for="rikt_center" class="form-label">रिक्त आंगनवाड़ी केंद्र का नाम</label>
                     <?php
                      // $gp = $pdata['gram_panchayat'];
                      // $sql1 = "select awc_name,id from new_vacancy where district_id='" . $pdata['district'] . "' AND project_id='" . $pdata['project'] . "' AND gp_name='" . $pdata['gram_panchayat'] . "' AND vacancy_available='Yes'";

                      // $sql1 = "SELECT awc_name, id 
                      //     FROM new_vacancy
                      //     WHERE district_id = '" . $pdata['district'] . "'
                      //       AND project_id = '" . $pdata['project'] . "'
                      //       AND vacancy_available = 'Yes'
                      //       AND (
                      //             LOWER(gp_name) = LOWER('$gp')
                      //             OR LOWER(ward_name) LIKE LOWER('%$gp%')
                      //           )
                      // ";
                      // echo  $sql1; die;
                      ?>
                    <select class="form-control form-select" name="rikt_aww_center" id="rikt_center" required>
                      <option value="">कृप्या विक्लप चुने</option>
                      <?php
                      $gp = $pdata['gram_panchayat'];
                      // $sql1 = "select awc_name,id from new_vacancy where district_id='" . $pdata['district'] . "' AND project_id='" . $pdata['project'] . "' AND gp_name='" . $pdata['gram_panchayat'] . "' AND vacancy_available='Yes'";

                      $sql1 = "SELECT awc_name, id 
                          FROM new_vacancy
                          WHERE district_id = '" . $pdata['district'] . "'
                            AND project_id = '" . $pdata['project'] . "'
                            AND vacancy_available = 'Yes'
                            AND (
                                  LOWER(gp_name) = LOWER('$gp')
                                  OR LOWER(ward_name) LIKE LOWER('%$gp%')
                                )
                      ";
                //  echo $sql1;

                      
                      $res1 = execute_query($sql1);
                      if (mysqli_num_rows($res1) > 0) {
                        while ($center = mysqli_fetch_array($res1)) {
                          if (!in_array($center['id'], $appl)) {
                                echo '<option value="' . $center['id'] . '">' . $center['awc_name'] . '</option>';
                            }
                        }
                      }
                      ?>

                    </select>
                  </div>

              <!--<div class="col-md-4">
                      <div class="form-group mb-3">
                          <label for="district" class="placeholder"> रिक्त पद का नाम <span class="text-danger">*</span></label>
                          <select class="form-control form-select" name="rikt_pd" id="" required>
                          <option value="">कृप्या विक्लप चुने</option>
                              <option value="1">आंगनवाड़ी कार्यकत्री</option>
                              <option value="2"> सहायिका</option>
                          </select>
                      </div>
                  </div>-->

                  <div class="col-md-4">
                    <label for="category" class="form-label">श्रेणी</label>
                    <select class="form-select" id="category" name="category" required>
                      <option selected disabled value="">कृप्या विक्लप चुने</option>
                      <option value="<?php echo $pd['category']; ?>"><?php echo getCategoryText($pd['category']); ?></option>
                     
                      
                    </select>
                  </div>
                  <div class=" col-4 mt-4">
                    <button type="submit" class="btn btn-success" name="apply_more">Apply</button></div>
                </div>

              </form>
              <div><br>
            Note:
                <span style="color:red"> 
                    <br>* एक ही ग्रामपंचयत में, एक से जादा रिक्त पद होने पे आवेदन करें।<br> 
                    * एक आँगनवाड़ी पे एक ही बार आवेदन करे।<br>
                 </span>
        </div>
            </div>
        </div>
      <?php } else {
            echo "<div style='padding:30px;text-align:center;color:red;'>Form date expire</div>";
          } ?>
      </div>

    </div>
  </div>
</div>
</div>



<!-- end code exam form details after submit -->

</div>
</div>

<script>
  <?php

  if (isset($_SESSION['success']) && !empty($_SESSION['success'])) {
    echo "showToastMsg('" . $_SESSION['success'] . "' , 'Success' , 'success');";
    unset($_SESSION['success']);
  }
  if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
    echo "showToastMsg('" . $_SESSION['error'] . "' , 'Error' , 'error');";
    unset($_SESSION['error']);
  }
  ?>
</script>
<script>
  function showDateTime() {
    var myDiv = document.getElementById("myDiv");

    var date = new Date();
    var dayList = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
    var monthNames = [
      "January","February","March","April","May","June","July","August","September","October","November","December"
    ];
    var dayName = dayList[date.getDay()];
    var monthName = monthNames[date.getMonth()];
    var today = `${dayName}, ${monthName} ${date.getDate()}, ${date.getFullYear()}`;

    var hour = date.getHours();
    var min = date.getMinutes();
    var sec = date.getSeconds();

    var time = hour + ":" + min + ":" + sec;
    myDiv.innerText = `${today} - ${time}`;
  }
  setInterval(showDateTime, 1000);
</script>

<script type="text/javascript">
  function valueChanged() {
    if ($('.dcheck').is(":checked")) {
      $("#d_serial").show();
      $("#d_per").show();
    } else {
      $("#d_serial").hide();
      $("#d_per").hide();
    }

  }

  function ffvalueChanged() {
    if ($('.ff').is(":checked")) {
      $("#ffdiv").show();
    } else {
      $("#ffdiv").hide();
    }
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