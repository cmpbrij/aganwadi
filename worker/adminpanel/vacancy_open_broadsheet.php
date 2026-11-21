<?php
  include 'master.php';
  ob_start();
  
  if(!checkLogin()){
    header('Location: login.php');

  }

  page_header_start('Admin Dashboard | ICDS | AWW Recruitment');
?>
<script type="text/javascript" src="../public/js/jquery-min.js"></script>

  
  <style> 
    .info{color:#ffc100;}
  </style>
  <?php

  page_header_end();

  navigation();
  
  if(isset($_SESSION['adminid'])){
    $q="select * from admin_users where id='".$_SESSION['sid']."'";
    $res= execute_query($q);
    $adata=mysqli_fetch_assoc($res);
  }
  if(isset($_GET['gpid'])){
        $sql1="SELECT * FROM `aaganwadi_center` WHERE gram_panchayat_id='".$_GET['gpid']."'";
        //echo $sql1; die;
        $gres=execute_query($sql1);
        
  }
  ?>

<?php
if(isset($_POST['vacancy_open'])){
    $dist_id = $_SESSION['distid'];
    $vacancy_open_otp = mysqli_real_escape_string($conn,$_POST['vacancy_open_otp']);
    $randotp = rand(1000,9999);
    // $update = "UPDATE `vacancy_order` SET `vacancy_open_otp`='$randotp'";
    // $res($conn,$randotp);
    $sql = "SELECT * FROM vacancy_order WHERE vacancy_open_otp='$vacancy_open_otp' AND dist_id = '$dist_id'";
    $stmt = $conn -> query($sql);
    $count=mysqli_num_rows($stmt); 
    if($count >=1){
        $row=mysqli_fetch_assoc($stmt);
            header('Location: projectwise_broadsheet.php');
        
    }
}
?>






        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:../../partials/_settings-panel.html -->
           
           
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
                                            Resolve all the low priority tickets due today
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
                    <div class="card">
                        <div class="card-body">
                           
                            <div class="row">
                                <div class="col-12">
                                <form action="" method="post">
                                     <div class="form-group">
                                      
                                          <label for="exampleInputEmail1">OTP</label>
                                          <input type="text" class="form-control" id="exampleInputEmail1" name="vacancy_open_otp" placeholder="OTP">
                                       </div>
                                     <button type="submit" name="vacancy_open" class="btn btn-primary">Submit</button>
                                </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
      
                
                <!-- content-wrapper ends -->
        <?php page_footer(); ?>