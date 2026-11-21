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
    $q = "select * from admin_users where id='" . $_SESSION['sid'] . "'";
    $res = execute_query($q);
    $adata = mysqli_fetch_assoc($res);
}
?>
<!-- partial -->
<div class="container-fluid page-body-wrapper">
    <?php if (isset($_SESSION['error-msg'])) { ?>
        <script>
            swal("Warning!", "<?php echo !empty($_SESSION['error-msg']) ? $_SESSION['error-msg'] : ''; ?>", "warning")
        </script>
    <?php unset($_SESSION['error-msg']);
    } ?>

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
                </div>
            </div>
            <!-- To do section tab ends -->
        </div>
    </div>
    <!-- partial -->
    <?php sidebar(); ?>

    <?php
    $project_id = !empty($_GET['projectid']) ? $_GET['projectid'] : '';

    if (isset($project_id)) {
        $projectQuery = "select * from block_master where id='" . $project_id . "'";
        $project_result = execute_query($projectQuery);
        $projectRowData = mysqli_fetch_assoc($project_result);
    }

    ?>

    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title" style="line-height: 35px;"><?php echo !empty($project_id) ? 'Update' : 'Add'; ?> Project - <?php echo !empty($adata['district']) ? $adata['district'] : ''; ?>

                                <a href="projectslist.php" class="btn btn-primary text-white" style="float: right;font-size: 12px;">List</a>

                            </h4>


                            <form class="forms-sample" action="saveDataRecords.php" method="post" enctype='multipart/form-data'>
                                <input type="hidden" name="project_id" value="<?php echo !empty($project_id) ? $project_id : ''; ?>">
                                <div class="form-group row">
                                    <label for="projectName" class="">Project Name</label>
                                    <div class="">
                                        <input type="text" value="<?= !empty($projectRowData['project_name']) ? $projectRowData['block_name'] : ''; ?>" name="projectName" class="form-control mt-2" id="projectName" placeholder="Enter project name" required>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    
                                    <div class="">
                                        <button type="submit" name="saveProject" id="saveProject" class="btn btn-danger btn-icon-text mt-2">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- content-wrapper ends -->
            <?php page_footer(); ?>