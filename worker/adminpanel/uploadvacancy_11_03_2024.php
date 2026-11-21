<?php
  include 'master.php';
  ob_start();
  
  if(!checkLogin()){
    header('Location: login.php');

  }

  page_header_start('Admin Dashboard | ICDS | AWW Recruitment');
?>
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
                            <input type="file" name="pdffile" class="form-control mt-2" id="" placeholder="Attach PDF" required>
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
                            <input type="date" name="last_date" class="form-control mt-2" id="" placeholder="Vacancy Last Date" required>

                           <br>
                            <button type="submit" class="btn btn-danger btn-icon-text mt-2" name="uploadOrder">
                                <i class="mdi mdi-upload btn-icon-prepend"></i>                                                    
                            Upload
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
                <!-- content-wrapper ends -->
                <?php page_footer(); ?>