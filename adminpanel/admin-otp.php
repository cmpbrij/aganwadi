<?php
  include 'master.php';
  ob_start();
  
  if(!checkLogin()){
    header('Location: login.php');

  }

  page_header_start('Admin Dashboard | ICDS | AWW Recruitment');
?>
  <?php

  page_header_end();

  navigation();
  
  if(isset($_SESSION['adminid'])){
    $q="select * from admin_users where id='".$_SESSION['sid']."'";
    $res= execute_query($q);
    $adata=mysqli_fetch_assoc($res);
  }

  if(isset($_GET['id'])){
    $sql="select * from setting where id='".$_GET['id']."'";
    $re=execute_query($sql);
    $udata=mysqli_fetch_assoc($re);
  }
  ?>


        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:../../partials/_settings-panel.html -->
           
            <?php
                if(isset($_SESSION['success'])){
                ?>
                    <script>
                    swal("success!", " OTP send on register mobile number", "success")
                    </script>
                <?php
                unset($_SESSION['success']);
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
                  <h4 class="card-title">Verify OTP</h4>
                  <p class="card-description" style="color:red;">
                Please verify OTP
                  </p>
                    <form class="forms-sample" action="dataSubmit.php" method="post" enctype='multipart/form-data'>
                        <div class="form-group row">
                        <label for="exampleInputUsername2" class="col-sm-3 col-form-label">OTP </label>
                        <div class="col-sm-9">
                            <input type="text" name="otp" class="form-control" placeholder="Enter OTP">
                        </div> 
                        </div>
                        <div class="form-group row">
                       
                        <div class="col-sm-9">
                        
                           <br>
                            <button type="submit" class="btn btn-success  mt-4" name="save_subCategory">
                                                                                  
                            Submit
                            </button>
                        </div> 
                     
                    </form>
                    </div>
                 </div>
                </div>
                <div class="col-md-6 grid-margin stretch-card">
                
            </div>
        </div>
                <!-- content-wrapper ends -->
                <?php page_footer(); ?>