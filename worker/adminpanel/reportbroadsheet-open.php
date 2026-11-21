<?php
  include 'admin_master.php';
  ob_start();
  
  if(!checkLogin()){
    header('Location: login.php');

  }

  page_header_start('Expected Broadsheet Opening Date');
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
                 
                    <!-- <li class="nav-item">
                        <a class="nav-link" id="chats-tab" data-bs-toggle="tab" href="#chats-section" role="tab" aria-controls="chats-section">CHATS</a>
                    </li> -->
                </ul>
                <div class="tab-content" id="setting-content">
                    <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel" aria-labelledby="todo-section">
                        <div class="add-items d-flex px-3 mb-0">
                            
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
                            <h4 class="card-title"> Expected Broadsheet Opening Date</h4>
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="table_id">
                                            <thead style="">
                                                <tr>
                                                    <th width="10%">Serial</th>
                                                    <th>District</th>
                                                    <th>Application <br>Last Date</th>
                                                     <th>Expected API <br>Verification Date</th>
                                                    <th>Expected Broadsheet <br>Opening Last Date</th>
                
                                                    <th>API Verification<br> Status</th>
                                                    <th>Broadsheet Opened</th>
                                                     <th>Selection Process</th>
                                                    <th>Documnet Verification<br> Last Date</th>
                                                   
                                                    <th>Deadline for <br>Letter Generation</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                
                                                $sql = "SELECT * FROM `vacancy_order`";
                                                $res=execute_query($sql);
                                                $i=1;
                                                while ($data = mysqli_fetch_assoc($res)) { 
                                                   
                                                    ?>
                                                
                                                     <tr >
                                                        <td><?php echo $i++; ?></td>
                                                        <td> <?php echo getDistname($data['dist_id']); ?></td>
                                                        
                                                        <td> <?php echo date('d-m-Y', strtotime($data['last_date'])); ?></td> 
                                                        <td>
                                                            <?php 
                                                                $last_date = $data['last_date'];
                                                                $new_date = date('Y-m-d', strtotime($last_date . ' +5 days'));
                                                                 echo date('d-m-Y', strtotime($new_date));
                                                             ?>
                                                        </td> 
                                                        <td>
                                                            <?php 
                                                                $last_date = $data['last_date'];
                                                                $new_date = date('Y-m-d', strtotime($last_date . ' +10 days'));
                                                                 echo date('d-m-Y', strtotime($new_date));
                                                             ?>
                                                        </td> 
                                                         <td>
                                                            <?php 
                                                               if($data['api_verified'] == '1'){
                                                                echo'<button class="btn btn-success">Verified</button>';
                                                               }
                                                               else{
                                                                 echo'<button class="btn btn-danger">Not Verified</button>';
                                                               }
                                                             ?>
                                                        </td> 
                                                         <td>
                                                            <?php 
                                                               if($data['vacancy_open_status'] == '1'){
                                                                echo'<button class="btn btn-success">Opened</button><br>Date:'.
                                                                date('d-m-Y H:i:s',strtotime($data['open_date']));
                                                               }
                                                               else{
                                                                 echo'<button class="btn btn-danger">Not Opened</button>';
                                                               }
                                                             ?>
                                                        </td> 
                                                         <td>
                                                            <?php 
                                                            //selection process
                                                                //$last_date = $data['open_date']; // original last date
                                                                 $last_date = $data['last_date'];
                                                                $currdate = date('Y-m-d');

                                                                // add 33 days
                                                                $new_date = date('Y-m-d', strtotime($last_date . ' +17 days'));

                                                                if ($currdate > $new_date) {
                                                                    // date expired → red color
                                                                    echo '<span style="color:red">' . date('d-m-Y', strtotime($new_date)) . '<br><b> Date exceeded</b></span>';
                                                                } else {
                                                                    // date not expired
                                                                    echo date('d-m-Y', strtotime($new_date));
                                                                }
                                                            ?>

                                                        </td>
                                                         <td>
                                                            <?php 
                                                                 $last_date = $data['last_date'];
                                                                //$last_date = $data['open_date']; // original last date
                                                                $currdate = date('Y-m-d');

                                                                // add 33 days
                                                                $new_date = date('Y-m-d', strtotime($last_date . ' +32 days'));

                                                                if ($currdate > $new_date) {
                                                                    // date expired → red color
                                                                    echo '<span style="color:red">' . date('d-m-Y', strtotime($new_date)) . '<br><b> Date exceeded</b></span>';
                                                                } else {
                                                                    // date not expired
                                                                    echo date('d-m-Y', strtotime($new_date));
                                                                }
                                                            ?>

                                                        </td>
                                                         <td>
                                                                <?php 
                                                                 $last_date = $data['last_date'];
                                                              //  $last_date = $data['open_date']; // original last date
                                                                $currdate = date('Y-m-d');

                                                                // add 33 days
                                                                $new_date = date('Y-m-d', strtotime($last_date . ' +39 days'));

                                                                if ($currdate > $new_date) {
                                                                    // date expired → red color
                                                                    echo '<span style="color:red">' . date('d-m-Y', strtotime($new_date)) . ' <br><b> Date exceeded</b></span>';
                                                                } else {
                                                                    // date not expired
                                                                    echo date('d-m-Y', strtotime($new_date));
                                                                }
                                                            ?>
                                                        </td>
                                                       
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
                responsive: false,
                pageLength: 25,
                // lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],

                buttons: [
                    'copy', 'csv', 'excel',
                    {
                        extend: 'print',
                        title: 'Expected Broadsheet Opening Date', // Set your custom title here
                        messageTop: 'ICDS Admin Report', // Optional message/heading
                        // customize: function (doc) {
                        //     doc.content[1].table.widths = ['10%', '15%', '15%','15%','15%','15%','15%']; // Optional column width customization
                        // }
                    },
                    'print',
                ]

            });
        });
        </script>