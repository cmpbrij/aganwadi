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
        font-size: 18px !important;
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
                            <h4 class="card-title">Distric Wise Vacancy List</h4>
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="table_id" class="table">
                                            <thead>
                                                <tr>
                                                    <th width="20%">Serial</th>
                                                    <th>District Name</th>
                                                    <th>Total Vacancies</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i=1;
                                                
                                                $sql = "SELECT district_id, COUNT(DISTINCT unique_code) AS count
                                                FROM `new_vacancy`
                                                
                                                GROUP BY district_id";

                                                // $sql = "SELECT district_id,count(vacancy_available) as count FROM `aaganwadi_center` where vacancy_available='Yes' group by district_id";
                                                $res=execute_query($sql);
                                                while ($data = mysqli_fetch_assoc($res)) {

                                                    echo '<tr>
                                                        <td>'. $i++.'</td>
                                                        <td>'.getDistname($data['district_id']).'</td> 
                                                        <td>'.$data['count'].'</td> 
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
                
    
                <!-- content-wrapper ends -->
                <?php page_footer(); ?>

                <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.js"></script>

    <!-- Datatable Dependency end -->
                <script>
                    $(document).ready(function() {
            $('#table_id').DataTable({

                dom: 'Bfrtip',
                responsive: false,
                pageLength: 25,
                // lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],

                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]

            });
        });
                </script>