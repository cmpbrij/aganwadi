<?php
include 'master.php';
ob_start();

if(!checkLogin()){
  header('Location: login.php');

}

page_header_start('Admin Dashboard | ICDS | AWW Recruitment');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toaster/4.0.1/css/bootstrap-toaster.min.css" integrity="sha512-RLiJ5uLcu8jWxsJBevOZWLU0zWv51vwpha0Gh4jRKOqkcWbVR7+U8kKaiGsMhSua3fIkviCHRClSH+XZYKIoZA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toaster/4.0.1/css/bootstrap-toaster.css" integrity="sha512-BqX9iUcQY8V8QeSbSjk/vL2CQk8TT5SEp8OeuRO6MMSYfRtVE0DW4eqjmD7Iew2XAoa+iEXIkJQPYXaP0FqWrA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toaster/4.0.1/js/bootstrap-toaster.js" integrity="sha512-4JwsWzz1l6JIsCUPi1bopU+79qHRCUlOJhYapg5dRuXjFFgXPazVnoOgrvrUMckjJl6LPOM4GncDv3ilou8avQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toaster/4.0.1/js/bootstrap-toaster.min.js" integrity="sha512-YmkrdAXo8RdHV1JFfepR7QWLDfF7vs8Mc/t+6qKIxrEFeWbi0u/lajryYSPK6GC5nupW5t6XfPdxQpIY79+USg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
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
                            <h4 class="card-title">All received application Project wise</h4>
                            <div class="row">
                                <div class="col-12">
                                <div class="table-responsive">
                                    <table id="order-listing" class="table">
                                    <thead>
                                        <tr>
                                            <th>Serial No.</th>
                                            <th>Project Name</th>
                                            <th>Recived Application</th>
                                            <th>View</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $sql="SELECT d.project_id, COUNT(d.id) AS count, p.project_name 
                                            FROM decleration d
                                            INNER JOIN projects p ON p.id = d.project_id AND p.district_id=d.district_id
                                            WHERE d.district_id = '".$_SESSION['distid']."'
                                            GROUP BY d.project_id, p.project_name";
                                            // $sql="SELECT d.project_id, COUNT(d.id) AS count
                                            // FROM decleration d
                                            // INNER JOIN users u ON u.district = d.district_id 
                                            // INNER JOIN projects p ON p.id=d.project_id
                                            // WHERE d.district_id='".$_SESSION['distid']."'
                                            // GROUP BY project_id";

                                            // $sql="select project_id,count(id) as total from decleration where district_id='".$_SESSION['distid']."' group by project_id";
                                            $res=execute_query($sql);
                                            //echo $sql; die;
                                            $i=1;
                                            while($row=mysqli_fetch_assoc($res)){
                                                echo'<tr>
                                                        <td>'.$i++.'</td>
                                                        <td>'.getProjectname($row['project_id']).'</td>
                                                        <td><div class="badge badge-pill badge-primary">'.$row['count'].'</div></td>
                                                        <td><a href="application_grampanchyat.php?pid='.$row['project_id'].'"><button class="btn btn-outline-primary">View</button><a/></td>
                                                    </tr>';


                                            }
                                        ?>
                                        <tr>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
              
              <!-- content-wrapper ends -->
              <?php page_footer(); ?>
              <script>
                // $(document).ready(function() {
                //     $('#applicationlist').dataTable({
                //     });
                // });
              </script>