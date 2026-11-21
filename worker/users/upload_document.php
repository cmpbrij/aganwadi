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

  //print_r($data); die;
}

if (isset($_SESSION['photoupdatedid'])) {
  $sql = "SELECT * FROM uploaded_documents WHERE `userid`='" . $_SESSION['uid'] . "'";
  //echo $sql; die;
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
</header>
<div class="contentwraper mt-5"> 
  

  <div class="container-fluid">

    <div class="row">
      <div class="col-md-1 col-2">
        <a title="Dashboard" href="dashboard.php" style="color: #282d6a;"
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

    <div class="border bg-light p-1 mb-1">

    </div>
  </div>

  <!-- start here -->
  <div id="multi-step-form-container">
    <!-- Form Steps / Progress Bar -->
    <ul
      class="form-stepper form-stepper-horizontal text-center mx-auto pl-0">
      <!-- Step 1 -->
      <li
        class="form-stepper-active text-center form-stepper-list"
        step="1">
        <a class="mx-2">
          <span class="form-stepper-circle">
            <span>1</span>
          </span>
          <div class="label">व्यक्तिगत विवरण - 1</div>
        </a>
      </li>
      <!-- Step 2 -->
      <li
        class="form-stepper-active text-center form-stepper-list"
        step="2">
        <a class="mx-2">
          <span class="form-stepper-circle text-muted">
            <span>2</span>
          </span>
          <div class="label text-muted">व्यक्तिगत विवरण - 2</div>
        </a>
      </li>
      <!--step3 -->
      <!-- <li
            class="form-stepper-active text-center form-stepper-list"
            step="3"
          >
            <a class="mx-2">
              <span class="form-stepper-circle text-muted">
                <span>3</span>
              </span>
              <div class="label text-muted">पते का विवरण</div>
            </a>
          </li> -->

      <li
        class="form-stepper-active text-center form-stepper-list"
        step="4">
        <a class="mx-2">
          <span class="form-stepper-circle text-muted">
            <span>3</span>
          </span>
          <div class="label text-muted">शैक्षिक योग्यता</div>
        </a>
      </li>
      <!-- Step 3 -->
      <li
        class="form-stepper-active text-center form-stepper-list"
        step="5">
        <a class="mx-2">
          <span class="form-stepper-circle text-muted">
            <span>4</span>
          </span>
          <div class="label text-muted">अपलोड फोटो</div>
        </a>
      </li>
      <!-- Step 4 -->
      <li
        class="form-stepper-unfinished text-center form-stepper-list"
        step="6">
        <a class="mx-2">
          <span class="form-stepper-circle text-muted">
            <span>5</span>
          </span>
          <div class="label text-muted">घोषणापत्र</div>
        </a>
      </li>
    </ul>

    </section>
    <!-- Step 2 Content, default hidden on page load. -->
    <section id="step-2" class="form-step">

      <!-- Step 2 input fields -->
      <form onsubmit="return validateForm()" id="" name="form3" method="post" action="formSubmit.php" enctype="multipart/form-data">
        <center>
          <h2 class="mb-3">
            <u>अपलोड फोटो</u>
          </h2>
        </center>
        <div class="row offset-3">
          <div class="col-md-5">
            <div class="">
              <label for="validationCustom02" class="form-label">आवेदिका नवीनतम हस्ताक्षरिक फोटो <span style="color:red;">(Max 200KB)</span></label>
              <input type="file" id="imgpath" name="photo_graph" accept="image/*" <?= !empty($pdata['photo']) ? '' : 'required'; ?>>
              <input type="hidden" name="old_photo_graph" value="<?= !empty($pdata['photo']) ? $pdata['photo'] : ''; ?>"><br>
              <span style="color:red;"> Best size of photo height:170px and width:180px</span>
            </div>
          </div>
          <div class="col-5">
            <div class="">
              <div class="holder" style="width:180px; height:170px; border:3px solid red;">
                <div class=" ffset-2">
                  <img id="passport_photo" alt="image" style="width:178px;height:168px;" src="<?= !empty($pdata['photo']) ? $pdata['photo'] : ''; ?>">
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="row offset-3 mt-5">
          <div class="col-md-5">
            <div class="">
              <label for="validationCustom02" class="form-label">आवेदिका के हस्ताक्षर<span style="color:red;">(max 200KB)</span></label>
              <input type="file" id="signatureupload" name="signature" accept="image/*" <?= !empty($pdata['signature']) ? '' : 'required'; ?>><br>
              <input type="hidden" name="old_signature" value="<?= !empty($pdata['signature']) ? $pdata['signature'] : ''; ?>"><br>

              <span style="color:red;"> Best size of photo height:70px and width:180px</span>
            </div>
          </div>
          <div class="col-5">
            <div class="">
              <div class="holder" style="width:180px; height:70px; border:3px solid red;">
                <div class="">
                  <img id="signimg" style="width:178px;height:68px;" src="<?= !empty($pdata['signature']) ? $pdata['signature'] : ''; ?>">

                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="col-6 offset-3 text-center "><br>
          <a href="academic_details.php"><button class="btn btn-primary" type="button">पिछला</button></a> &nbsp;&nbsp;&nbsp;
          <button class="btn btn-primary" type="submit" name="uploadPhoto">अगला</button>
      </form>
    </section>
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
  function validateFileSizeAndDimensions(inputElement, height = '', width = '') {
    const file = inputElement.files[0];
    const maxSize = 200 * 1024; // 200 KB in bytes

    if (file) {

      if (file.size > maxSize) {
        alert("File size exceeds the 200KB limit.");
        inputElement.value = '';
        return;
      }

      const img = new Image();

      img.onload = function() {

        var minwidth = width - 30;
        var minheight = height - 30;

        if (img.width < minwidth || img.width > width || img.height < minheight || img.height > height) {
          alert("Image width must be between " + minwidth + "px and " + width + "px, and image height must be between " + minheight + "px and " + height + "px.");
          inputElement.value = '';
        }
      };

      img.onerror = function() {
        alert("This is not a valid image.");
        inputElement.value = '';
      };

      const reader = new FileReader();
      reader.onload = function(e) {
        img.src = e.target.result;
      };
      reader.readAsDataURL(file); // Load the file as a data URL
    }
  }

  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#passport_photo')
          .attr('src', e.target.result)
          .width(180)
          .height('170');
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
  $("#imgpath").change(function() {

    readURL(this);
    validateFileSizeAndDimensions(this, 200, 200);
  });
</script>

 

<script>
  function readURLSign(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      // alert(reader);

      reader.onload = function(e) {
        $('#signimg')
          .attr('src', e.target.result)
          .width(180)
          .height('70');
      };

      reader.readAsDataURL(input.files[0]);
    }
  }
  $("#signatureupload").change(function() {
    readURLSign(this);
    validateFileSizeAndDimensions(this, 100, 200);
  });
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
  function validateForm() {

  }

  const navigateToFormStep = (stepNumber) => {
    document.querySelectorAll(".form-step").forEach((formStepElement) => {
      formStepElement.classList.add("d-none");
    });

    document
      .querySelectorAll(".form-stepper-list")
      .forEach((formStepHeader) => {
        formStepHeader.classList.add("form-stepper-unfinished");
        formStepHeader.classList.remove(
          "form-stepper-active",
          "form-stepper-completed"
        );
      });

    document
      .querySelector("#step-" + stepNumber)
      .classList.remove("d-none");

    const formStepCircle = document.querySelector(
      'li[step="' + stepNumber + '"]'
    );

    formStepCircle.classList.remove(
      "form-stepper-unfinished",
      "form-stepper-completed"
    );
    formStepCircle.classList.add("form-stepper-active");

    for (let index = 0; index < stepNumber; index++) {
      const formStepCircle = document.querySelector(
        'li[step="' + index + '"]'
      );

      if (formStepCircle) {
        formStepCircle.classList.remove(
          "form-stepper-unfinished",
          "form-stepper-active"
        );
        formStepCircle.classList.add("form-stepper-completed");
      }
    }
  };

  document
    .querySelectorAll(".btn-navigate-form-step")
    .forEach((formNavigationBtn) => {
      formNavigationBtn.addEventListener("click", () => {
        const stepNumber = parseInt(
          formNavigationBtn.getAttribute("step_number")
        );

        navigateToFormStep(stepNumber);
      });
    });
</script>
</body>

</html>