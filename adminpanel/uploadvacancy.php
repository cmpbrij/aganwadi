<?php
  include 'master.php';
  ob_start();
  
  if(!checkLogin()){
    header('Location: login.php');

  }

  page_header_start('Admin Dashboard | ICDS | AWW Recruitment');
?>
<script type="text/javascript" src="../public/js/jquery-min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.css" integrity="sha512-0TsYUclL0x2HXTMBHTQyrsFGsELlmYZRsmq8OG1SkV6V2lRzsZoFEddMf1dsqySJIegvLmrowaeiA9HNop2dXA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.min.css" integrity="sha512-gpqtQIgLIXYBimyliA0xmgme7m5coXHQhscvqhAZcOoPlKOmEzPg2BhYIYV/d39j7fEkXh42UeVt7g5PzUtfSg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <?php

  page_header_end();

  navigation();
  
  if(isset($_SESSION['adminid'])){
    $q="select * from admin_users where id='".$_SESSION['sid']."'";
    $res= execute_query($q);
    $adata=mysqli_fetch_assoc($res);
  }
  ?>


        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:../../partials/_settings-panel.html -->
            <?php
                if(isset($_SESSION['success-1'])){
                ?>
                    <script>
                    swal("Success!", "Vacancy uploaded! Vacancy Locked", "success")
                    </script>
                <?php
                unset($_SESSION['success-1']);
                }
                ?>
           
           <?php
                if(isset($_SESSION['error'])){
                ?>
                    <script>
                    swal("Success!", "Vacancy already uploaded!", "success")
                    </script>
                <?php
                unset($_SESSION['error']);
                }
                ?>
                <?php
                if(isset($_SESSION['w-otp'])){
                ?>
                    <script>
                    swal("Warning!", "Can not verify OTP! Please tye again", "warning")
                    </script>
                <?php
                unset($_SESSION['w-otp']);
                }
                ?>
           
               <div id="right-sidebar" class="settings-panel">
                <i class="settings-close mdi mdi-close"></i>
                <ul class="nav nav-tabs" id="setting-panel" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="todo-tab" data-bs-toggle="tab" href="#todo-section" role="tab" aria-controls="todo-section" aria-expanded="true">TO DO LIST</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" id="chats-tab" data-bs-toggle="tab" href="#chats-section" role="tab" aria-controls="chats-section">CHATS</a>
                    </li> -->
                </ul>
                <div class="tab-content" id="setting-content">
                    <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel" aria-labelledby="todo-section">
                        <div class="add-items d-flex px-3 mb-0">
                           
                        </div>
                        <div class="list-wrapper px-3">
                          
                        </div>
                        
                    </div>
                    <!-- To do section tab ends -->
                    
                    <!-- chat tab ends -->
                </div>
            </div>
            <!-- partial -->
            <?php sidebar(); ?>
                        <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Upload Advertisement PDF file</h4>
                  <p class="card-description" style="color:red;">
                   On Public Domain
                  </p>
                    <form class="forms-sample" action="dataSubmit.php" method="post" enctype='multipart/form-data'>
                        <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Upload Document</label>
                        <div class="col-sm-9">
                            <input type="file" name="pdffile" class="form-control mt-2" id="pdffile" placeholder="Attach PDF" required>
                        </div> 
                        </div>
                        <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Cut off date</label>
                        <div class="col-sm-9 mt-3">
                        <input type="radio" name="cutoff_date" class="form-check-input mt-2" id="" value="jan"> 1st Jan &nbsp;&nbsp; &nbsp;&nbsp;  &nbsp;&nbsp; 

                        
                        <input type="radio" name="cutoff_date" class="form-check-input mt-2" id="" value="july"> 1st July &nbsp;&nbsp; 
                           
                        </div> 
                        </div>
                        <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Last Date</label>
                        <div class="col-sm-9">
                            <input type="date" name="last_date" class="form-control mt-2" id="last_date" placeholder="Vacancy Last Date" required>

                           <br>
                            <button type="button" id="upload" class="btn btn-danger btn-icon-text mt-2" name="uploadOrder">
                                <i class="mdi mdi-upload btn-icon-prepend"></i>                                                    
                            Upload
                            </button>
                            
                        </div> 
                        </div>
                        <div class="form-group row" style="display:none" id="otpdiv">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">OTP</label>
                        <div class="col-sm-9">
                            <input type="text" name="uotp" class="form-control mt-2" id="uotp" placeholder="Please enter OTP" required style="border: 1px solid black;">

                           <br>
                            <button type="submit" id="" class="btn btn-success btn-icon-text mt-2" name="saveuploadOrder">                                       
                            Verify
                            </button>
                            
                        </div> 
                        </div>
                    </form>
                    </div>
                 </div>
                </div>
                <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Uploaded Details</h4>
                        <p class="card-description" style="color:red;">
                           
                        </p>
                        <div class="row">
                            <table class="table">
                                <tr>
                                    <th>Uploaded Date</th>
                                    <th>Attached PDF</th>
                                    <th>Last Date</th>
                                </tr>
                                <?php
                                    $sql1="SELECT * FROM `vacancy_order` WHERE dist_id='".$_SESSION['distid']."'";
                                    //echo $sql; die;
                                    $res1=execute_query($sql1);
                                    if(mysqli_num_rows($res1) > 0){
                                        $rowdata=mysqli_fetch_array($res1);
                                        echo'<tr>
                                                <td>'.$rowdata['uploaded_date'].'
                                                <td><a target="_blank" href="'.$rowdata['pdf_name'].'">View File</a></td>
                                                <td>'.date('d-m-Y', strtotime($rowdata['last_date'])).'</td>
                                            </tr>';
                                    }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
    $(document).ready(function(){  
      $(document).on('click', '#upload', function(){  
          
           
           var pdf= $('#pdffile').val();
            var ldate= $('#lastdate').val();
            if(pdf==''){
                //   swal("Warning!", "Please attached PDF file", "Warning") ;
                alert('Please attached PDF file');
            }
            else if(ldate==''){
                // swal("Warning!", "Please select last date", "Warning") ;
                alert('Please select last date');
            }
            else{
                $('#otpdiv').show();
                $('#upload').hide();
           $.ajax({  
                url:"ajax.php",  
                method:"POST",  
                data:{uploadOTP:'1'},  
                dataType:"json",  
                success:function(data){   
                    // swal("Success!", "OTP Send on registred mobile number!", "Success") ;
                    alert('OTP send on register mobile number');
                }  
           });  
        }
      });  
    });
 </script>
                <!-- content-wrapper ends -->
                <?php page_footer(); ?>