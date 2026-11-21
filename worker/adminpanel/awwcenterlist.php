<?php
include 'master.php';
ob_start();

if (!checkLogin()) {
    header('Location: login.php');
}

page_header_start('Admin Dashboard | ICDS | AWW Recruitment');
?>
<script type="text/javascript" src="../public/js/jquery-min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.css" integrity="sha512-0TsYUclL0x2HXTMBHTQyrsFGsELlmYZRsmq8OG1SkV6V2lRzsZoFEddMf1dsqySJIegvLmrowaeiA9HNop2dXA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.min.css" integrity="sha512-gpqtQIgLIXYBimyliA0xmgme7m5coXHQhscvqhAZcOoPlKOmEzPg2BhYIYV/d39j7fEkXh42UeVt7g5PzUtfSg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                    <h4 class="card-title mb-0">Added Aganwadi Center List - <?php echo $adata['district']; ?></h4>
                     <!-- <a href="vacancyyesaww.php" style="font-size: 16px;"><b>AWH VACANCY YES</b><i class="bi bi-arrow-right"></i></a> &nbsp;&nbsp; -->
                    <a href="manageawwcenter.php" class="btn btn-primary text-white" style="font-size: 12px;">Add New Center<span class="mdi mdi-arrow-right-thin"></span></a>
                </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="">
                                <table id="tbl" class="table">
                                    <thead>
                                        <tr>
                                            <th >Sno.</th>
                                            <th>Center Name</th>
                                            <th>Center Code</th>
                                            <th>Project Name</th>
                                            <th>GP/Ward Name</th>
                                            <th>Category</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        $district_id = !empty($_SESSION['distid']) ? $_SESSION['distid'] : 0;

                                        $sql = "SELECT new_vacancy.vacancy_available,new_vacancy.category ,new_vacancy.unique_code,new_vacancy.id,new_vacancy.awc_name,new_vacancy.awc_urban_rural, projects.project_name, gram_panchayat.gram_panchayat_name FROM new_vacancy 
                                        Left JOIN gram_panchayat ON gram_panchayat.id = new_vacancy.gram_panchayat_id 
                                        Left JOIN projects ON projects.id = new_vacancy.project_id 
                                         WHERE new_vacancy.district_id ='" . $district_id . "' order by new_vacancy.id desc";

                                        $res = execute_query($sql);
                                        while ($data = mysqli_fetch_assoc($res)) {

                                             if($data['vacancy_available']=='Yes'){
                                               $bg='background-color:#65a765;';
                                           }
                                            else{
                                               $bg='';
                                            }

                                         
                                          echo '<tr id="row_' . $data['id'] . '" style="' . $bg . '">
                                            <td>' . $i++ . '</td>
                                            <td> <b>' . trim($data['awc_name']) . ' </b>('.$data['awc_urban_rural'].')</td> 
                                            <td>'.trim($data['unique_code']).'</td>
                                            <td>' . $data['project_name']. '</td> 
                                            <td>' . $data['gram_panchayat_name']. '</td> 
                                            <td>
                                                    '.getCategoryTexteng($data['category']).'
                                            </td> 
                                            <th>
                                            
                                                    <a href="manageawwcenter.php?id=' . $data['id'] . '"  class="btn btn-primary" >Edit</a> <br>

                                                   
                                           <br>';
                                         
                                           if($data['vacancy_available']=='No'){
                                                echo '<button type="button" id="" class="btn btn-success addvacancy" title="Add in vacancy of this center" data-id="' . $data['id'] . '" data-status="Yes">Add</button>';
                                           }
                                            else{
                                                echo '<button type="button" id="addvacancy" class="btn btn-danger addvacancy" title="Add in vacancy of this center" data-id="' . $data['id'] . '" data-status="No">Remove</button>';
                                            }
                                          

                                            echo'</th>
                                            </div>
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

<script>
$(document).ready(function() {
    $('.addvacancy').click(function() {
        var row_id = $(this).data('id');
        var status = $(this).data('status'); 
        $.ajax({  
            url: "ajax.php",  
            method: "POST",  
            data: { 
                 action: 'addvacancy',
                 row_id: row_id,
                 status: status
             },  
            dataType: "json",  
            success: function(response) {   
                if (response.success) {
                    swal("Success!", "Vacancy updated successfully!", "success");
                   setTimeout(function() {
                        location.reload(); // reloads page after 5 seconds
                    }, 2000);
                } else {
                   swal("Faild!", "Some error occure!", "warning")
                }
            },
            error: function(xhr, status, error) {
                console.error(error);
                alert('Something went wrong!');
            }
        });
    });
});
</script>