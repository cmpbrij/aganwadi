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
                <div class="content-wrapper" style="padding-right:0px;padding-left:0px;">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"> Distric Wise Opened Broadsheet</h4>
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="table_id" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th width="10%">Serial</th>
                                                    <th width="25%">District Name</th>
                                                    <th width="25%">Total Vacancy</th>
                                                    <th width="25%">Opened Date</th>
                                                    <th width="15%">View</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                
                                                $sql = "SELECT * FROM `vacancy_order` where vacancy_open_status='1'";
                                                $res=execute_query($sql);
                                                $i=1;
                                                while ($data = mysqli_fetch_assoc($res)) { 
                                                    // if($data['last_date'] <= date('Y-m-d')){
                                                    //     $co='style="background-color:#FF474C;"';
                                                    // }
                                                    // else{
                                                    //     $co='';
                                                    // }
                                                    ?>
                                                
                                                     <tr>
                                                        <td><?php echo $i++; ?></td>
                                                        <td> <?php echo getDistname($data['dist_id']); ?></td>
                                                        <td><?php echo districtVacancy_Count($data['dist_id']); ?> </td>
                                                        <td> <?php echo $data['open_date']; ?></td> 
                                                        
                                                         <td><a href="<?php echo $data['pdf_name']; ?>" target="_blank"
                                                    class="btn btn-primary">View </a></td>
                                                    </tr>
                                               <?php } ?>
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
                <!-- Datatable Dependency start -->
    
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.js"></script>

    <!-- Datatable Dependency end -->
    <script>
        $(document).ready(function() {
            $('#table_id').DataTable({

                dom: 'Bfrtip',
                responsive: true,
                pageLength: 25,
                // lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],

                buttons: [
                    'copy', 'csv', 'excel',
                    {
                        extend: 'pdf',
                        title: 'Distric Wise Opened Broadsheet', // Set your custom title here
                        messageTop: 'ICDS admin report', // Optional message/heading
                        // customize: function (doc) {
                        //     doc.content[1].table.widths = ['10%', '25%', '25%', '25%', '15%'];  
                        //     doc.defaultStyle.fontSize = 10; // Set font size
                        // }
                    },
                    'print'
                ]

            });
        });
                </script>