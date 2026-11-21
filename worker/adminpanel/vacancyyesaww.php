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
    $q = "select * from admin_users where id='" . $_SESSION['sid'] . "'";
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

<!-- partial -->
<div class="container-fluid page-body-wrapper" style="padding-left: 0px; padding-right:0px;">

    <div id="right-sidebar" class="settings-panel">
        <i class="settings-close mdi mdi-close"></i>
        <ul class="nav nav-tabs" id="setting-panel" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="todo-tab" data-bs-toggle="tab" href="#todo-section" role="tab" aria-controls="todo-section" aria-expanded="true">TO DO LIST</a>
            </li>

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
                     <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="card-title mb-0">AWW Center List - <?php echo $adata['district']; ?></h4>
                    <a href="manageawwcenter.php" class="btn btn-primary text-white" style="font-size: 12px;">Add AWW Center</a>
                </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="table-responsive">
                                <table id="tbl" class="table">
                                    <thead>
                                        <tr>
                                            <th >Serial</th>
                                            <th>AWW Center Name</th>
                                            <th>Project Name</th>
                                            <th>Gram Panchayat Name</th>
                                            <th>Is Vacancy</th>
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
                                         WHERE new_vacancy.district_id ='" . $district_id . "' AND new_vacancy.vacancy_available='Yes' order by new_vacancy.project_name";

                                        $res = execute_query($sql);
                                        while ($data = mysqli_fetch_assoc($res)) {

                                            echo '<tr id="row_' . $data['id'] . '">
                                            <td>' . $i++ . '</td>
                                            <td> <b>' . trim($data['awc_name']) . ' </b>
                                            <br><br> Unique Code :' . trim($data['unique_code']) . '<br>
                                            Center Type: '.$data['awc_urban_rural'].'</td> 
                                            <td>' . $data['project_name']. '</td> 
                                            <td>' . $data['gram_panchayat_name']. '</td> 
                                            <td>' . $data['vacancy_available'] . '<br>
                                                    '.getCategoryTexteng($data['category']).'
                                            </td> 
                                            <th>
                                            <div class="d-flex">
                                                    <a href="manageawwcenter.php?id=' . $data['id'] . '"  class="btn btn-primary" >Edit</a> 
                                            &nbsp;
                                            </th>
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
                        'copy', 'csv', 'excel', 'pdf', 'print'
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