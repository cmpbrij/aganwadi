<?php
  include 'admin_master.php';
  ob_start();
  
  if(!checkLogin()){
    header('Location: login.php');

  }

  page_header_start('Admin Dashboard | ICDS | AWW Recruitment');
?>

  
  <style> 
    .info{color:#ffc100;}
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


        <div class="container-fluid page-body-wrapper">
         
            <?php sidebar(); ?>
                        <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="card">
                        <div class="card-body">
                              <h4>Uploaded Eligible List by Districts - <span style="color:green"><?php echo getdistName($_GET['did']); ?></span></h4>
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                       <table id="table_id" class="table">
                                            <thead>
                                                <tr>
                                                    <th width="20%">SNO.</th>
                                                    <th>Uploaded Date & Time</th>
                                                    <th>Remarks</th>
                                                    <th>Attached PDF</th>
                                            
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i=1;
                                                $sql = "SELECT d.district_name,b.districtid,b.attached_pdf,b.timestamp,b.remarks FROM districts d JOIN uploaded_broadsheet b ON d.id = b.districtid where b.districtid='".$_GET['did']."'
                                            ";
                                                //echo $sql; 
                                                $res=execute_query($sql);
                                                while ($data = mysqli_fetch_assoc($res)) {
                                                    echo '<tr>
                                                        <td>'. $i++.'</td>
                                                         <td>'.date('d-m-Y H:i:s',strtotime($data['timestamp'])).'
                                                           <td>'.$data['remarks'].'
                                                         <td><a target="_blank" href="../uploadedBroadsheet/'.$data['attached_pdf'].'">View File</a></td> 
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
              
  
<!-- <td><a href="admin_user_update.php?id='.$data['id'].'">Update</a></td> -->
                
                <!-- content-wrapper ends -->
        <?php page_footer(); ?>

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.js"></script>

    <!-- Datatable Dependency end -->
                <script>
                    $(document).ready(function() {
            $('#tbl').DataTable({

                dom: 'Bfrtip',
                responsive: false,
                pageLength: 25,
                 lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],

                buttons: [
                    'copy', 'csv', 'excel',
                    {
                        extend: 'pdf',
                        title: 'DPO Login Details', // Set your custom title here
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