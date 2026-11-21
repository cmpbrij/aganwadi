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
  
  if(isset($_GET['id'])){
        $sql1="SELECT * FROM `aaganwadi_center` WHERE id='".$_GET['id']."'";
        //echo $sql1; die;
        $gres=execute_query($sql1);
        
  }
  if(isset($_POST['submit'])){
    $sql="UPDATE `aaganwadi_center` SET `vacancy_available`='".$_POST['vacancy']."' WHERE id='".$_POST['id']."'";
    $res=execute_query($sql);
    if($res){
        
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
                            <h4 class="card-title">Center Name - <span class="info"><?php echo ($_GET['id']); ?></span></h4>
                                                       <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                    <div class="card-header">Header


                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                        <form class="cmxform" id="signupForm" method="get" action="">
                                            <input type="text" name="id" value="<?php if(isset($_GET['id'])){ echo $_GET['id']; } ?>">
                                            <fieldset>
                                            <div class="form-group col-6">
                                                <label for="firstname">Firstname</label>
                                                <select name="vacancy" class="form-control">
                                                    <option>Please select </option>
                                                    <option value="Yes">YES</option>
                                                    <option value="No">NO</option>
                                                </select>
                                            </div>
                                            <div class="form-group col-6">
                                            <input class="btn btn-primary" name="submit" type="submit" value="Submit"> 
                                            </div>
                                        
                                        </form>

                                    </div>

                                    </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="order-listing" class="table">
                                            <thead>
                                                <tr>
                                                    <th width="20%">Serial</th>
                                                    <th>Aganwadi Center Name</th>
                                                    
                                                    <th>Category</th>
                                                    <th>EWS</th>
                                                    <th>Vacancy Available</th>
                                                    <th style="background-color:antiquewhite;">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i=1;
                                                while ($data = mysqli_fetch_assoc($gres)) {

                                                    echo '<tr>
                                                        <td>'. $i++.'</td>
                                                        <td><a href="vacancylistdetails.php?pid='.$data['id'].'">'. $data['awc_name'].'</a></td>
                                                        
                                                        <td>'.$data['category'].'</td> 
                                                        <td>'.$data['ews'].'</td> 
                                                        <td>'.$data['vacancy_available'].'</td> 
                                                        <td  style="background-color:antiquewhite;"> 
                                                        <a href="revise_vacancy.php?id='.$data['id'].'" class="btn btn-primary">Revise Vacancy</a></td>
                                                    </tr>';
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                     $(document).ready(function() {
                        $('.savedata').on('click', function() {
                            alert('test');
                        
                        });
                     });
                </script>
                <!-- content-wrapper ends -->
        <?php page_footer(); ?>