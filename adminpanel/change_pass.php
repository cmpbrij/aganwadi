<?php
  include 'master.php';
  ob_start();
  
  if(!checkLogin()){
    header('Location: login.php');

  }

  page_header_start('Admin Dashboard | ICDS | AWW Recruitment');
?>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
 <style>
    .error{
        color: red;
    }
    .form-control{
        border:2px solid #dee2e6;
    }
</style>
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
                    swal("Success!", "Password changed successfully!", "success")
                    </script>
                <?php
                unset($_SESSION['success']);
                }
                ?>

<?php
                if(isset($_SESSION['error_in_change'])){
                ?>
                    <script>
                    swal("Warning!", "Something wrong please try again!", "warning")
                    </script>
                <?php
                unset($_SESSION['error_in_change']);
                }
                ?>
                <?php
                if(isset($_SESSION['warning'])){
                ?>
                    <script>
                    swal("Warning!", "Current password is incorrect!", "warning")
                    </script>
                <?php
                unset($_SESSION['warning']);
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
                  <h4 class="card-title">Change Password</h4>
                  <p class="card-description" style="color:red;">

                  </p>
                    <form class="forms-sample" action="submitLogin.php" method="post" enctype='multipart/form-data' id="changePasswordForm">
                        <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Current password</label>
                        <div class="col-sm-9">
                            <input type="password" name="old_pass" class="form-control" >
                        </div> 
                        </div>

                        <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">New Password</label>
                        <div class="col-sm-9">
                        <input type="password" name="new_pass" id="new_pass" class="form-control" >

                          
                        </div> 
                        </div>
                        <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">Conifrm New Password</label>
                        <div class="col-sm-9">
                        <input type="text" name="c_new_pass" id="c_new_pass" class="form-control" >

                           <br>
                            <button type="submit" class="btn btn-danger btn-icon-text mt-4" name="changePass">
                                                                                 
                            Save
                            </button>
                        </div> 
                        </div>
                       
                    </form>
                    </div>
                 </div>
                </div>
                <!-- <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                   
                </div>
            </div> -->
        </div>

        <script>
   
        </script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

                <!-- content-wrapper ends -->
                <?php page_footer(); ?>
                <script>
                      $(document).ready(function() {
    $('#changePasswordForm').validate({
        rules: {
            old_pass: {
                required: true
            },
            new_pass: {
                required: true,
                minlength: 6
            },
            c_new_pass: {
                required: true,
                equalTo: '#new_pass'
            },
            otp: {
                required: true
            }
        },
        messages: {
            old_pass: {
                required: "Please enter your current password"
            },
            new_pass: {
                required: "Please enter a new password",
                minlength: "Password must be at least 6 characters long"
            },
            c_new_pass: {
                required: "Please confirm your new password",
                equalTo: "Passwords do not match"
            },
            otp: {
                required: "Please enter the OTP"
            }
        },
        submitHandler: function(form) {
           $('#changePasswordForm').submit();
        }
    });
});
                </script>