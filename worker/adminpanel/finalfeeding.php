<?php
include 'admin_master.php';
ob_start();

if(!checkLogin()){
  header('Location: login.php');

}

page_header_start('Admin Dashboard | ICDS | AWW Recruitment');
?>

<style>
   .dataTables_wrapper .dataTable tbody tr td {
        font-weight: 400 !important;
        font-size: 20px !important;
   }
   .container-fluid {
        padding-left:0px;
        padding-right:0px;
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
                            <h4 class="card-title">Final Candidate Feeding (District-wise)</h4>
                            <div class="row">
                                <div class="col-12">
                                <div class="table-responsive">
                                    <table id="table" class="table">
                                    <thead>
                                        <tr>
                                            <th>Serial No.</th>
                                            <th>District Name</th>
                                            <th>Total Vacancy</th>
                                            <th>No. of final selected candidates</th>
                                            
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                       
                                          
                                                    $sql="SELECT 
                                                        district_id,
                                                        COUNT(final_selection) AS total_selected
                                                    FROM decleration
                                                    WHERE final_selection = 1
                                                    GROUP BY district_id
                                                        ";
                                                  
                                                    $res=execute_query($sql);
                                                    $i=1;
                                                    $total=0;
                                                    $totalv=0;
                                                   
                                                    while($row=mysqli_fetch_assoc($res)){
                                                         $count=districtVacancy_Count($row['district_id']);
                                                         $totalv+=$count;
                                                         $total+=$row['total_selected'];

                                                echo'<tr>
                                                        <td>'.$i++.'</td>
                                                        <td>'.getdistName($row['district_id']).'</td>
                                                         <td>'.$count.'</td>
                                                        <td><div class="badge badge-pill badge-primary">'.$row['total_selected'].'</div></td>
                                                       
                                                    </tr>';

                                                    }
                                               
                                        ?>
                                        <tr>
                                            <th></th>
                                              <th>Total:</th>
                                                <th><?php echo $totalv; ?></th>
                                                  <th><?php echo $total; ?></th>
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
              <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.js"></script>

    <!-- Datatable Dependency end -->
                <script>
                    $(document).ready(function() {
            $('#table').DataTable({

                dom: 'Bfrtip',
                responsive: false,
                pageLength: 25,
                 lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],

                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]

            });
        });
                </script>