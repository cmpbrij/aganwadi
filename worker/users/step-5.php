<?php
$msg = '';
include('../config/db_config.php');
include('../config/settings.php');

if (!checkLogin()) {
  header('Location: login.php');
}
if (isset($_SESSION['uid'])) {
  $sql = "SELECT * FROM users WHERE `id`='" . $_SESSION['uid'] . "'";
  $res = $conn->query($sql);
  $data = mysqli_fetch_assoc($res);
}

if (isset($_SESSION['photoupdatedid'])) {
  $sql = "SELECT * FROM uploaded_documents WHERE `userid`='" . $_SESSION['uid'] . "'";

  $res = $conn->query($sql);
  $pdata = mysqli_fetch_assoc($res);
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
          <div class="col-md-4 col-12 text-center"> <strong>Father Name</strong> : <?php echo $data['father_name']; ?>
          </div>
          <div class="col-md-4 col-12 text-center"><strong>Mobile No.</strong> : <?php echo $data['mobile']; ?>
          </div>
        </div>
      </div>
    </div>

    <div class="border bg-light p-1 mb-1"></div>
  </div>

  <!-- start here -->
  <div id="multi-step-form-container">
    <!-- Form Steps / Progress Bar -->
    <ul class="form-stepper form-stepper-horizontal text-center mx-auto pl-0">
      <!-- Step 1 -->
      <!-- Step 1 -->
      <li class="form-stepper-active text-center form-stepper-list" step="1">
        <a class="mx-2">
          <span class="form-stepper-circle">
            <span>1</span>
          </span>
          <div class="label">व्यक्तिगत विवरण - 1</div>
        </a>
      </li>
      <!-- Step 2 -->
      <li class="form-stepper-active text-center form-stepper-list" step="2">
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
      <li class="form-stepper-active text-center form-stepper-list" step="5">
        <a class="mx-2">
          <span class="form-stepper-circle text-muted">
            <span>4</span>
          </span>
          <div class="label text-muted">अपलोड फोटो</div>
        </a>
      </li>
      <!-- Step 4 -->
      <li class="form-stepper-active text-center form-stepper-list" step="6">
        <a class="mx-2">
          <span class="form-stepper-circle text-muted">
            <span>5</span>
          </span>
          <div class="label text-muted">घोषणापत्र</div>
        </a>
      </li>
    </ul>

    </section>

    <section id="step-2" class="form-step">
      <form method="post" action="formSubmit.php" enctype='multipart/form-data'>
        <div class="col-md-6 offset-3">
         
          <div class="heading-line mb-4">
                <span>घोषणा</span>
            </div>
          <div class="text-left">
            <p style="color:red;line-height:30px;"><input type="checkbox" name="dec" id="dec" value="dec" style="width: 30px;height:30px;" ;> &nbsp; &nbsp;
            <br>"मैं घोषणा करती हूँ कि मैंने उक्त पद से संबंधित प्रकाशित विज्ञप्ति को ध्यानपूर्वक पढ़ा है तथा चयन से संबंधित सभी शर्तें मुझे मान्य हैं। मेरे द्वारा आवेदन पत्र में अंकित सभी सूचनाएँ और विवरण सत्य हैं। भविष्य में यदि कोई तथ्य/विवरण गलत अथवा असत्य पाया जाता है या छिपाया गया है, तो मेरी अभ्यर्थना/नियुक्ति निरस्त समझी जाएगी।"
</p>
          </div>
          <br>
          <div class="col-12 text-center">
          <a href="step-4.php"><button class="btn btn-primary" type="button">पिछला</button></a> &nbsp;&nbsp;&nbsp;&nbsp;
          <button class="button btn-navigate-form-step" type="submit" name="declerationSubmit" id="decl" disabled>अगला</button>
        </div>
        </div>
      </form>
    </section>
  </div>
</div>
</div>


<script type="text/javascript">
  var checkboxes = $("#dec"),
    submitButt = $("#decl");

  checkboxes.click(function() {
    submitButt.attr("disabled", !checkboxes.is(":checked"));
  });
</script>


<?php footer(); ?>

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
  $(document)
    .ajaxStart(function() {
      $(".screen").show();
    })
    .ajaxStop(function() {
      $(".screen").hide();
    });
</script>
</body>

</html>