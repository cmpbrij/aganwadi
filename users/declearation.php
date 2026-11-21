
<?php
  $msg='';
  include('../config/db_config.php');
  include('../config/settings.php');
 
    if(!checkLogin()){
        header('Location: login.php');
    }
  if(isset($_SESSION['uid'])){
    $sql = "SELECT * FROM users WHERE `id`='".$_SESSION['uid']."'";
    $res = $conn -> query($sql);
    $data=mysqli_fetch_assoc($res);

   
    //print_r($data); die;
  }

  if(isset($_SESSION['photoupdatedid'])){
    $sql = "SELECT * FROM uploaded_documents WHERE `userid`='".$_SESSION['uid']."'";
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
          <?php
          if(isset($_SESSION['success'])){
           echo '<div class="alert alert-success alert-dismissible">
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              <strong>फोटो और हस्ताक्षर</strong> का डेटा सहेजा गया
            </div>';
          }
          unset($_SESSION['success']);
          ?>

         

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
        <!-- Form Steps / Progress Bar -->
        <ul
          class="form-stepper form-stepper-horizontal text-center mx-auto pl-0"
        >
          <!-- Step 1 -->
         <!-- Step 1 -->
         <li
            class="form-stepper-active text-center form-stepper-list"
            step="1"
          >
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
            step="4"
          >
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
            step="5"
          >
            <a class="mx-2">
              <span class="form-stepper-circle text-muted">
                <span>4</span>
              </span>
              <div class="label text-muted">अपलोड फोटो</div>
            </a>
          </li>
          <!-- Step 4 -->
          <li
            class="form-stepper-active text-center form-stepper-list"
            step="6"
          >
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
             <form  method="post" action="formSubmit.php" enctype='multipart/form-data'>
              <div class="col-md-6 offset-3">
                <center>
                  <h2 class="mb-3">
                      <u>घोषणा</u>
                  </h2>
                </center>
                <div class="">
                
                  <p style="color:red;line-height:30px;"><input type="checkbox" name="dec" id="dec" value="dec" style="width: 30px;height:30px;";> &nbsp; &nbsp; मैं घोषणा करती हूँ कि मैने उक्त पद से सम्मान्धित प्रकाशित विज्ञप्ति को ध्यानपूर्वक पढ़ा है चयन से सम्बन्धित सभी शर्ते मुझे मान्य हैं। आवेदन-पत्र में अंकित सभी सूचना व आवेदन-पत्र के साथ सभी विवरण सत्य एवं सही है। भविष्य में यदि कोई तथ्य फर्जी/ असत्य पाये जाते हैं या छिपाया गया पाया जाता है, तो आवेदिका का अभ्यर्थन/निपुक्ति निरस्त कर समुचित वैधानिक कार्यवाही की जाएगी।</p>
                </div>

                <br>

                  <a href="upload_document.php"><button class="btn btn-primary" type="button">पिछला</button></a> &nbsp;&nbsp;&nbsp;&nbsp;
                <button class="btn btn-success" type="submit" name="declerationSubmit" id="decl" disabled>अगला</button>
        </div>
            </form>
            
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

<script type="text/javascript">
  var checkboxes = $("#dec"),
    submitButt = $("#decl");

checkboxes.click(function() {
    submitButt.attr("disabled", !checkboxes.is(":checked"));
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
        // let dist = document.forms["form1"]["dist_name"].value;
        // if (dist == "") {
        //   document.getElementById("e_dist").innerHTML = "Select district name";
        //   return false;
        // }


       }
       

      
    </script>
</body>

</html>
  