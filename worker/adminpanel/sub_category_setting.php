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
                    swal("Success!", " Sub Category setting done Successfully", "success")
                    </script>
                <?php
                unset($_SESSION['success']);
                }
                ?>

<?php
                if(isset($_SESSION['success-update'])){
                ?>
                    <script>
                    swal("Success!", " Sub Category setting updated Successfully", "success")
                    </script>
                <?php
                unset($_SESSION['success-update']);
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
                        <!-- <div class="add-items d-flex px-3 mb-0">
                            <form class="form w-100">
                                <div class="form-group d-flex">
                                    <input type="text" class="form-control todo-list-input" placeholder="Add To-do">
                                    <button type="submit" class="add btn btn-primary todo-list-add-btn" id="add-task">Add</button>
                                </div>
                            </form>
                        </div> -->
                        <div class="list-wrapper px-3">
                            <ul class="d-flex flex-column-reverse todo-list">
                                
                                <li>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox" id="">
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
                  <h4 class="card-title">Setting for Subcategory</h4>
                  <p class="card-description" style="color:red;">
                  Enable subcategory in application form
                  </p>
                    <form class="forms-sample" action="dataSubmit.php" method="post" enctype='multipart/form-data'>
                        <div class="form-group row">
                        <label for="handicap" class="col-sm-3 col-form-label">Handicap </label>
                        <div class="col-sm-9">
                            <input type="checkbox" name="handicap" id="handicap" class="form-check-input mt-4" <?php if(isset($udata) && $udata['sub_category_hadnicap'] ==1){ ?>checked <?php }?>>
                        </div> 
                        </div>
                        <div class="form-group row">
                        <label for="ff" class="col-sm-3 col-form-label">Freedom Fighters</label>
                        <div class="col-sm-9">
                        <input type="checkbox" name="ff" id="ff"  class="form-check-input mt-4" <?php if(isset($udata) && $udata['sub_category_ff'] ==1){ ?>checked <?php }?> >

                           <br>
                            <button type="submit" class="btn btn-danger btn-icon-text mt-4" name="save_subCategory">
                                                                                 
                            Save
                            </button>
                        </div> 
                        </div>
                        <input type="hidden" name="editid" value="<?php if(isset($udata)){echo $_GET['id'];}else{echo"";}?>">
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
                                    <th>Setting Date</th>
                                    <th>Handicap Status</th>
                                    <th>Freedom Fighters Status</th>
                                    <th>Action</th>
                                </tr>
                                <?php
                                    $sql1="SELECT * FROM `setting` WHERE district_id='".$_SESSION['distid']."'";
                                    //echo $sql; die;
                                    $res1=execute_query($sql1);
                                    if(mysqli_num_rows($res1) > 0){
                                        $rowdata=mysqli_fetch_array($res1);
                                        echo'<tr>
                                                <td>'.date("d-m-Y H:i:s", strtotime($rowdata['created'])).'<td>';
                                                if($rowdata['sub_category_hadnicap'] ==1){
                                                    echo'<label class="badge badge-success">ENABLE</label>';
                                                }
                                                else{
                                                    echo'<label class="badge badge-danger">DISABLE</label>';
                                                }
                                                echo'</td><td>';

                                                if($rowdata['sub_category_ff'] ==1){
                                                    echo'<label class="badge badge-success">ENABLE</label>';
                                                }
                                                else{
                                                    echo'<label class="badge badge-danger">DISABLE</label>';
                                                }

                                                echo '</td><td><a href="sub_category_setting.php?id='.$rowdata['id'].'">Update</a></td>
                                            </tr>';
                                    }
                                    else{
                                        echo'<tr><td colspan="3">No setting Data found</td></tr>';
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