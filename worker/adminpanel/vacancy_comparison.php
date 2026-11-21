<?php
  include 'admin_master.php';
  ob_start();
  
  if(!checkLogin()){
    header('Location: login.php');

  }

  page_header_start('Admin Dashboard | ICDS | AWH Recruitment');

  function districtVacancy_Count_old($id){
    $sql="SELECT COUNT(unique_code) as count from new_vacancy_v1 where district_id='".$id."'  AND is_old='1' group by district_id;";
    $res=execute_query($sql);
    $row=mysqli_fetch_array($res);
    return $row['count'];

}

function checkVacancyOrder_old($distid)
{
    $stmt="SELECT id FROM vacancy_order WHERE dist_id ='$distid' LIMIT 1";
    $res=execute_query($stmt);

    if(mysqli_num_rows($res) >=1){
        return 1;
    }
    else{
        return 0;
    }
}
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
                            <h4 class="card-title"> District-wise Old vs New Vacancy Comparison</h4>
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                    <table class="table table-bordered table-hover" id="table_id">
                                            <thead>
                                                <tr>
                                                    <th width="10%">Serial</th>
                                                    <th>District Name</th>
                                                    <th>Total Old Vacancies</th>
                                                    <th>Pending in Old Vacancies</th>
                                                    <th>New Vacancies</th>
                                                    <th>Total Advertisements</th>
                                                    
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                
                                                $sql = "SELECT
                                                    district_id,
                                                    SUM(CASE WHEN is_old = 1 THEN 1 ELSE 0 END) AS old_vacancy_count,
                                                    SUM(CASE WHEN is_old = 0 THEN 1 ELSE 0 END) AS new_vacancy_count,
                                                    COUNT(*) AS total_vacancy
                                                FROM new_vacancy
                                                GROUP BY district_id
                                                ORDER BY district_id";
                                                $res=execute_query($sql);
                                                $i=1;
                                                $totalold=0;
                                                $totalnew=0;
                                                $overall=0;
                                                $totaloldvac=0;
                                                while ($data = mysqli_fetch_assoc($res)) { 
                                                   if($data['district_id'] < 76 && checkVacancyOrder_old($data['district_id'])){
                                                    $totalold+=$data['old_vacancy_count'];
                                                    $totalnew+=$data['new_vacancy_count'];
                                                    $overall+=$data['total_vacancy'];
                                                    $oldvac=districtVacancy_Count_old($data['district_id']);
                                                   $totaloldvac+=  $oldvac;
                                                    ?>
                                                
                                                     <tr>
                                                        <td><?php echo $i++; ?></td>
                                                        <td> <?php echo getDistname($data['district_id']); ?></td>
                                                         <td> <?php echo $oldvac; ?></td>
                                                        <td><?php echo $data['old_vacancy_count']; ?> 
                                                        <td> <?php echo $data['new_vacancy_count']; ?></td> 
                                                        <td> <?php echo $data['total_vacancy']; ?></td> 
                                                        
                                                    </tr>
                                               <?php }} ?>
                                               <tr>
                                                    <th colspan=""></th>
                                                    <th colspan="">TOTAL</th>
                                                     <th><?php echo $totaloldvac; ?></th>
                                                    <th><?php echo $totalold; ?></th>
                                                    <th><?php echo $totalnew; ?></th>
                                                    <th><?php echo $overall; ?></th>
                                                   
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

        buttons: [
            'copy', 'csv', 'excel',

            {
                extend: 'pdf',
                title: 'Distric Wise Published Advertisement',
                messageTop: 'ICDS admin report',
                exportOptions: {
                    columns: ':not(:last-child)'   // Hide last column in PDF
                }
            },

            {
                extend: 'print',
                // exportOptions: {
                //     columns: ':not(:last-child)'  
                // }
            }
        ]

    });
});
</script>
