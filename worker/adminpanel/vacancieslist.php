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
  ?>
 <style>
 .circle-number {
      width: 50px;              /* circle width */
      height: 50px;             /* circle height */
      background-color: #007bff; /* circle color */
      color: white;             /* number color */
      border-radius: 50%;       /* makes it round */
      display: flex;            /* center the number */
      align-items: center;      /* vertical center */
      justify-content: center;  /* horizontal center */
      font-weight: bold;
      font-size: 18px;
    }
</style>
        <!-- partial -->
    <div class="container-fluid page-body-wrapper">
            <?php sidebar(); ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Vacancy List - <?php echo $adata['district']; ?></h4>
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="tbl" class="table">
                                            <thead>
                                                <tr>
                                                    <th width="20%">Serial</th>
                                                    <th>Project</th>
                                                    <th>Total Vacancy</th>
                                                    <th>Download(Yes)</th>
                                                    
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i=1;
                                                $total=0;
                                                $sql = "SELECT project_id, COUNT(unique_code) AS count FROM new_vacancy WHERE district_id ='" .$_SESSION['distid'] . "'   group by project_id";
                                               // echo $sql; die;
                                                $res=execute_query($sql);
                                                while ($data = mysqli_fetch_assoc($res)) {
                                                    $total+=$data['count'];
                                                    echo '<tr>
                                                        <td>'. $i++.'</td>
                                                        <td><a href="distprojectslist.php?pid='.$data['project_id'].'">'.strtoupper(getBlockname($data['project_id'])).'</a></td> 
                                                        <td><div class="circle-number">'.$data['count'].'</div></td>
                                                        <th><a href="vacancy_csv_download.php?pid='.$data['project_id'].'">Download CSV</a></th>
                                                       
                                                    </tr>';
                                                } ?>

                                              
                                            </tbody>
                                            <tr style="background-color:#FCAF45;text-align:center;"><th colspan="2">Total</th><th colspan="2"><?php echo $total; ?></th></tr>
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
            $('#tbl').DataTable({

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