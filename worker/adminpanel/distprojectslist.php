<?php
  include 'master.php';
  ob_start();
  
  if(!checkLogin()){
    header('Location: login.php');

  }

  page_header_start('Admin Dashboard | ICDS | AWH Recruitment');
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
                            <!-- <h4 class="card-title">GP/Ward Name</h4> -->
                              <h4 class="card-title">Project Name  - <span class="info"><?php echo getBlockName($_GET['pid']); ?></span></h4>
                            <!-- <h4 class="card-title">Project  - <?php echo getProjectname($_GET['pid']); ?></h4> -->
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="table_id" class="table">
                                            <thead>
                                                <tr>
                                                    <th width="20%">Serial</th>
                                                    <th>Gram Panchayat/Ward Name</th>
                                                    <th>Total AWC Vacancy</th>
                                                    <!-- <th>Total AWC Vacancy</th> -->
                                                   
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                
                                               
                                        // $sql="SELECT sector,MIN(id) AS id,  COUNT(unique_code) AS count FROM new_vacancy WHERE district_id='".$_SESSION['distid']."' AND project_id='".$_GET['pid']."' AND vacancy_available='Yes' group by sector";
                                      $sql = "SELECT 
                                        COALESCE(NULLIF(gp_name, ''), ward_name) AS gp_or_ward_name,
                                        MIN(id) AS id,
                                        COUNT(unique_code) AS count
                                    FROM new_vacancy
                                    WHERE district_id = '".$_SESSION['distid']."'
                                    AND project_id = '".$_GET['pid']."'
                                    AND vacancy_available = 'Yes'
                                    GROUP BY gp_or_ward_name";
                                       // echo $sql; die;
                                                     
                                               $gres=execute_query($sql);
                                                $i=1;
                                                $t=0;
                                                while ($data = mysqli_fetch_assoc($gres)) {
                                                    // $sql11="SELECT COUNT(DISTINCT unique_code) AS num_awc
                                                    // FROM new_vacancy
                                                    // WHERE gram_panchayat_id ='".$data['gram_panchayat_id']."' and district_id='".$_SESSION['distid']."'";
                                                    // $res11=execute_query($sql11);
                                                    // $cxdata=mysqli_fetch_array($res11);

                                                    
                                                    echo '<tr>
                                                        <td>'. $i++.'</td>
                                                        <td><a href="vacancylistdetails.php?gp_name='.$data['gp_or_ward_name'].'&pid='.$_GET['pid'].'">'. strtoupper($data['gp_or_ward_name']).'</a></td> 
                                                        <td>'.$data['count'].'</td> 
                                                    
                                                       
                                                    </tr>';
                                                    $t+=$data['count'];
                                                  
                                                } ?>
                                                <tr style="background-color:#CCC;"><td colspan="2" style="text-align:right"><b>Total</b></td><td><b><?php echo $t; ?></b></td></tr>

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
$(document).ready(function () {
    $('#table_id').DataTable({
        dom: 'Bfrtip',
        responsive: false,
        pageLength: 25,
        lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],
        buttons: [
            'copy', 'csv', 'excel', 'pdf',
            {
                extend: 'print',
                title: '', // Custom print title
                messageTop: 'Grampanchyat/Ward Wise Vacancy',
                exportOptions: {
                    columns: ':visible' // Only export visible columns
                },
                customize: function (win) {
                    $(win.document.body)
                        .css('font-size', '10pt')
                        .prepend(
                            '<h2 style="text-align:center;">Anganwadi Helper Recruitment - 2025</h2>'
                        );

                    $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');

                    // Optional: update column headers
                    $(win.document.body).find('thead th').each(function (i) {
                        // Replace default titles with custom ones
                        const customHeaders = ['Serial', 'Grampanchyta/Ward Name', 'Total Vacancy'];
                        if (customHeaders[i]) {
                            $(this).text(customHeaders[i]);
                        }
                    });
                }
            }
        ]
    });
});
</script>
