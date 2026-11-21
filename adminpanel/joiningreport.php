<?php
  include 'admin_master.php';
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
  
  ?>


        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:../../partials/_settings-panel.html -->
           
           
            <div id="right-sidebar" class="settings-panel">
                <i class="settings-close mdi mdi-close"></i>
                <div class="tab-content" id="setting-content">
                    <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel" aria-labelledby="todo-section">
                        <div class="add-items d-flex px-3 mb-0">
                           
                        </div>
                        <div class="list-wrapper px-3">
                            <ul class="d-flex flex-column-reverse todo-list">
                                
                               
                                
                            </ul>
                        </div>
                        
                    </div>
                   
                </div>
            </div>
            <!-- partial -->
            <?php sidebar(); ?>
                        <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="card">
                        <div class="card-body">
                           <h4>District Wise Report of Joining Letter</h4>
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                    <table id="table" class="table">
                                            <thead>
                                                <tr>
                                                    <th width="20%">Serial</th>
                                                    <th>District Name</th>
                                                    <th>Total Vacancy</th>
                                                    <th>Total Letter Distributed</th>
                                                    <!-- <th>View Details</th> -->
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i=1;
                                                $sql = "SELECT `id`, `district_name` FROM `districts`";
                                                
                                                $res=execute_query($sql);
                                                while ($data = mysqli_fetch_assoc($res)) {

                                                    $q="select count(vacancy_available) as total_v from new_vacancy where district_id='".$data['id']."' AND vacancy_available = 'Yes'";
                                                   
                                                    $vres=execute_query($q);
                                                    $vdata=mysqli_fetch_assoc($vres);

                                                    $q1="select count(final_selection) as total_j from decleration where district_id='".$data['id']."' AND final_selection='1'";
                                                   
                                                    $jres=execute_query($q1);
                                                    $jdata=mysqli_fetch_assoc($jres);

                                                    echo '<tr>
                                                        <td>'. $i++.'</td>
                                                        <td>'.$data['district_name'].'</td> 
                                                         <td>'.$vdata['total_v'].'</td> 
                                                          <td>'.$jdata['total_j'].'</td> 
                                                        
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
              
  
<!-- <td><a href="uploade_elist.php?did='.$data['districtid'].'">View Document</a></td>  -->
                
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
                    'copy', 'csv', 'excel',
                    {
                        extend: 'pdf',
                        title: 'Letter Generated Report', // Set your custom title here
                        messageTop: 'ICDS Admin Report', // Optional message/heading
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