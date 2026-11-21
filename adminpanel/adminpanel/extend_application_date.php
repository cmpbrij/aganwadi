<?php
  include 'master.php';
  ob_start();
  
  if(!checkLogin()){
    header('Location: login.php');

  }
echo "Not allowed! Can not open"; die;
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
                if(isset($_SESSION['success'])){
                ?>
                    <script>
                    swal("Success!", "Date extended successfully !", "success")
                    </script>
                <?php
                unset($_SESSION['success']);
                }
                ?>
                 <?php
                if(isset($_SESSION['error'])){
                ?>
                    <script>
                    swal("Warning!", "Extend Application Date Already Updated !", "success")
                    </script>
                <?php
                unset($_SESSION['error']);
                }
                ?>
                 <?php
                if(isset($_SESSION['max-days'])){
                ?>
                    <script>
                    swal("Warning!", "Maximum extension upto 10 days", "warning")
                    </script>
                <?php
                unset($_SESSION['max-days']);
                }
                ?>
                 <?php
                if(isset($_SESSION['onetime'])){
                ?>
                    <script>
                    swal("Warning!", "Date can be extended only once", "warning")
                    </script>
                <?php
                unset($_SESSION['onetime']);
                }
                ?>
                 <?php
                if(isset($_SESSION['extendpdf'])){
                ?>
                    <script>
                    swal("Warning!", "extend pdf Not Upload", "warning")
                    </script>
                <?php
                unset($_SESSION['extendpdf']);
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
                            <form class="form w-100">
                                <div class="form-group d-flex">
                                    <input type="text" class="form-control todo-list-input" placeholder="Add To-do">
                                    <button type="submit" class="add btn btn-primary todo-list-add-btn" id="add-task">Add</button>
                                </div>
                            </form>
                        </div>
                        <div class="list-wrapper px-3">
                            <ul class="d-flex flex-column-reverse todo-list">
                                
                                <li>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox">
                                         <!-- Resolve all the low priority tickets due today -->
                                        </label>
                                    </div>
                                    <i class="remove mdi mdi-close-circle-outline"></i>
                                </li>
                                
                            </ul>
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
                  <h4 class="card-title">Extend Application Date</h4>
                  <p class="card-description" style="color:red;">
                  Maximum extension upto 10 days<br>
                    <?php
                        $sql="SELECT * FROM `vacancy_order` WHERE dist_id='".$_SESSION['distid']."'";
                        $r=execute_query($sql);
                        if(mysqli_num_rows($r) > 0){
                            $pdata=mysqli_fetch_assoc($r);
                        
                    ?>
                  <br><span style="font-size: 20px; font-wigth:700;"> Uploaded Date : <?php echo date('d-m-Y',strtotime($pdata['uploaded_date'])) ?></span>
                  </p>
                    <form class="forms-sample" action="dataSubmit.php" method="post" enctype='multipart/form-data'>
                        <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">No. of days </label>
                        <div class="col-sm-9">
                            <input type="text" name="days" class="form-control mt-4" required id="days">
                          </div> 
                        </div>
                        <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Extend order </label>
                        <div class="col-sm-9">
                            <input type="file" name="extend_order_pdf" class="form-control mt-4" id="pdf" required>
                          </div> 
                          <!-- <small></small> -->
                        </div>
                        <div class="form-group row" style="display:none" id="otpdiv">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">OTP</label>
                        <div class="col-sm-9">
                            <input type="text" name="uotp" class="form-control mt-2" id="uotp" placeholder="Please enter OTP" required style="border: 1px solid black;">

                           <br>
                            <button type="submit" id="" class="btn btn-success btn-icon-text mt-2" name="extenddate">
                                                                             
                            Verify
                            </button>
                            
                        </div> 
                        </div>
                        <div class="form-group row">
                        
                        <div class="col-sm-9 text-right">
                            <button type="button" class="btn btn-danger btn-icon-text mt-4" name="extenddate" id="ext">
                               Save
                            </button>
                        </div> 
                        </div>
                        <input type="hidden" name="id" value="<?php if(isset($udata)){ echo $_GET['id']; } ?> ">
                    </form>
                    <?php } else{?>
                        <P> First Upload advertisement</p>

                   <?php }?>
                    </div>
                 </div>
                </div>
                <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">EXTEND APPLICATION  Details</h4>
                        <p class="card-description" style="color:red;">
                           
                        </p>
                        <div class="row">
                            <?php
                                 $sql="select * from vacancy_order where dist_id='".$_SESSION['distid']."'";
                                 $resu=execute_query($sql);
                                 if(mysqli_num_rows($resu) > 0){
                                     $row=mysqli_fetch_assoc($resu);
                            ?>
                            <h4>Extended Days: <?php echo $row['extend_day']; ?></h4><br><br>
                            <h4>Last Date: <span style="color:green"><?php echo date('d-m-Y',strtotime($row['last_date'])); ?></span></h4>
                            <p> <a href="<?php echo $row['extend_order_pdf']; ?>" target="_blank">Extend Order View</a></p>
                            
                                <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

<script>
    $(document).ready(function(){  
      $(document).on('click', '#ext', function(){  
           var days= $('#days').val();
            var pdf= $('#pdf').val();
            if(days==''){
                //   swal("Warning!", "Please attached PDF file", "Warning") ;
                alert('Please enter number of days');
            }
            else if(pdf==''){
                // swal("Warning!", "Please select last date", "Warning") ;
                alert('Please attach PDF file');
            }
            else{
                $('#otpdiv').show();
                $('#ext').hide();
           $.ajax({  
                url:"ajax.php",  
                method:"POST",  
                data:{uploadOTP:'1'},  
                dataType:"json",  
                success:function(data){   
                    // swal("Success!", "OTP Send on registred mobile number!", "Success") ;
                    swal("Success!", "Successfully OTP SEND!", "success")
                }  
           });  
        }
      });  
    });
 </script>
                <!-- content-wrapper ends -->
                <?php page_footer(); ?>