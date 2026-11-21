<?php
include 'master.php';
ob_start();

if (!checkLogin()) {
    header('Location: login.php');
}

page_header_start('Admin Dashboard | ICDS | AWW Recruitment');
?>

<?php

page_header_end();

navigation();

if (isset($_SESSION['adminid'])) {
    $q = "select district from admin_users where id='" . $_SESSION['sid'] . "'";
    $res = execute_query($q);
    $adata = mysqli_fetch_assoc($res);
}
?>

<?php if (isset($_SESSION['success-msg'])) { ?>
    <script>
        swal("Success!", "<?php echo !empty($_SESSION['success-msg']) ? $_SESSION['success-msg'] : ''; ?>", "success")
    </script>
<?php unset($_SESSION['success-msg']);
} ?>

<style>
.dataTables_wrapper .dataTable .btn, .dataTables_wrapper .dataTable .fc button, .fc .dataTables_wrapper .dataTable button, .dataTables_wrapper .dataTable .ajax-upload-dragdrop .ajax-file-upload, .ajax-upload-dragdrop .dataTables_wrapper .dataTable .ajax-file-upload, .dataTables_wrapper .dataTable .swal2-modal .swal2-buttonswrapper .swal2-styled, .swal2-modal .swal2-buttonswrapper .dataTables_wrapper .dataTable .swal2-styled, .dataTables_wrapper .dataTable .wizard > .actions a, .wizard > .actions .dataTables_wrapper .dataTable a{
    padding: 0.3rem .6rem !important;
}
</style>
<!-- partial -->
<div class="container-fluid page-body-wrapper" style="padding-left: 0px; padding-right:0px;">

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
                     <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">AWW Center List - <?php echo $adata['district']; ?></h4>
                     <!-- <a href="vacancyyesaww.php" style="font-size: 16px;"><b>AWH VACANCY YES</b><i class="bi bi-arrow-right"></i></a> &nbsp;&nbsp; -->
                    <a href="managenewvacancy.php" class="btn btn-primary text-white" style="font-size: 12px;">Add New Center<span class="mdi mdi-arrow-right-thin"></span></a>
                </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="tbl" class="table">
                                    <thead>
                                        <tr>
                                            <th>Sno.</th>
                                            <th>Project Name</th>
                                            <th>GP/Ward Name</th>
                                            <th>Center Code</th>
                                            <th>Center Name</th>
                                            <th>Reservation</th>
                                            <th>Action</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $district_id = !empty($_SESSION['distid']) ? $_SESSION['distid'] : 0;
                                        // $sql = "SELECT nv.*,bm.block_name FROM new_vacancy as nv
                                        //  JOIN block_master as bm ON bm.id = nv.project_id 
                                        //  WHERE nv.district_id ='" . $district_id . "' and nv.vacancy_available='Yes'  order by bm.block_name desc";

                                        // $sql = "SELECT 
                                        // nv.*, 
                                        // bm.block_name,
                                        // COALESCE(NULLIF(nv.gp_name, ''), nv.ward_name) AS gp_or_ward_name
                                        // FROM new_vacancy nv
                                        // JOIN block_master bm ON bm.id = nv.project_id
                                        // WHERE nv.district_id = '".$district_id."' 
                                        // AND nv.vacancy_available = 'Yes'
                                        // ORDER BY bm.block_name DESC";

                                      $qr = "SELECT dist_id FROM vacancy_order WHERE dist_id = '".$district_id."'";
                                     // echo $qr;
                                        $r = execute_query($qr);
                                        $vcheck = mysqli_num_rows($r);

                                        //echo $check; die;



                                        $sql = "SELECT 
                                            nv.project_name,
                                            nv.gp_name,
                                            nv.ward_name,
                                            nv.unique_code,
                                            nv.awc_name,
                                            nv.awc_urban_rural,
                                            nv.category,
                                            nv.awc_master_id,
                                            bm.block_name,
                                             COALESCE(NULLIF(TRIM(nv.gp_name), ''), nv.ward_name) AS gp_or_ward_name
                                        FROM new_vacancy nv
                                        JOIN block_master bm 
                                            ON bm.id = nv.project_id
                                        WHERE nv.district_id = '".$district_id."' 
                                       
                                        ORDER BY bm.block_name DESC";
                                       // echo $sql; die;


                                        $res = execute_query($sql);
                                        while ($data = mysqli_fetch_assoc($res)) {

                                            echo '<tr>
                                            <td>' . $i++ . '</td>
                                             <td>' . $data['project_name']. '</td> 
                                            <td>' .$data['gp_or_ward_name'].'</td> 
                                             <td>'.trim($data['unique_code']).'</td>
                                            <td> <b>' . trim($data['awc_name']) . ' </b>('.$data['awc_urban_rural'].')</td> 
                                           
                                           
                                            <td>
                                                    '.getCategoryTexteng($data['category']).'
                                            </td> ';

                                            if($vcheck > 0){
                                                echo'<td><button class="btn btn-danger">Vacancy Locked</button></td>';
                                            }
                                            else{

                                            echo'<td>
                                                    <a href="editNewVacancy.php?id=' . $data['unique_code'] . '" class="btn btn-info"> Edit </a>
                                           
                                                    &nbsp; <a href="ActionremoveOldVacancy.php?id=' . $data['awc_master_id'] . '" class="btn btn-danger"> Remove  </a>
                                            </td>';
                                            }

                                            echo'</tr>';
                                        } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- <a href="manageawwcenter.php?id=' . $data['id'] . '"  class="btn btn-primary" >Edit</a> -->

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
        pageLength: 50,
        lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],

        buttons: [
            {
                extend: 'copy',
                exportOptions: {
                    columns: ':not(:last-child)' // hide last column
                }
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'excel',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':not(:last-child)'
                }
            }
        ]
    });
});

          
            function deleteRowRecord(row_id = '') {
                if (!row_id) {
                    swal({
                        title: "Error!",
                        text: "Invalid row ID.",
                        icon: "error"
                    });
                    return;
                }

                swal({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }, function(isConfirmed) {
                    if (isConfirmed) {
                        $.ajax({
                            url: 'saveAwwCenter.php',
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                row_id: row_id,
                                action: 'delete_awwcenter'
                            },
                            success: function(response) {
                                if (response.success) {
                                    $('#row_' + row_id).remove();

                                    swal({
                                        title: "Deleted!",
                                        text: "Your file has been deleted.",
                                        icon: "success"
                                    });

                                } else {
                                    swal({
                                        title: "Error!",
                                        text: response.message || "There was a problem deleting the file.",
                                        icon: "error"
                                    });
                                }
                            },
                            error: function() {
                                swal({
                                    title: "Error!",
                                    text: "There was a problem with the request.",
                                    icon: "error"
                                });
                            }
                        });
                    }
                });
            }
        </script>

