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
    $row_id = !empty($_GET['id']) ? $_GET['id'] : '';

    if (isset($row_id)) {
        $query = "select * from gram_panchayat where id='" . $row_id . "'";
        $row_result = execute_query($query);
        $row_data = mysqli_fetch_assoc($row_result);
    }

    $district_id = $_SESSION['distid'] ?? 0;
    $queryProjects = "select * from projects where district_id='" . $district_id . "'";
    $projects_result = execute_query($queryProjects);
    $projects = mysqli_fetch_all($projects_result, MYSQLI_ASSOC);


    ?>

    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title" style="line-height: 35px;"><?php echo !empty($row_id) ? 'Update' : 'Add'; ?> Gram Panchayat/Ward - <?php echo !empty($adata['district']) ? $adata['district'] : ''; ?>

                                <a href="grampanchayatlist.php" class="btn btn-primary text-white" style="float: right;font-size: 12px;">List</a>

                            </h4>



                            <form class="forms-sample" action="saveDataRecords.php" method="post" enctype='multipart/form-data'>
                                <input type="hidden" name="row_id" value="<?php echo !empty($row_id) ? $row_id : ''; ?>">
                                
                                <div class="row">
                                <div class="form-group col-6">
                                    <label for="gram_panchayat_name" class="">Gram Panchayat/ward</label>
                                    <div class="">
                                        <input type="text" value="<?= !empty($row_data['gram_panchayat_name']) ? $row_data['gram_panchayat_name'] : ''; ?>" name="gram_panchayat_name" class="form-control mt-2" id="gram_panchayat_name" placeholder="Enter gram panchayat name" required>
                                    </div>
                                </div>

                                <div class="form-group col-6">
                                    <label for="project_id"  class="">Select Project</label>
                                    <div class="">
                                        <select style="height: 52px;" name="project_id" id="project_id" class="form-control mt-2" required>
                                            <option value="">Select Project</option>
                                            <?php
                                            if (!empty($projects)) {

                                                foreach ($projects as $project) {  ?>
                                                    <option value="<?= $project['id'] ?>" <?= !empty($row_data['project_id']) && $row_data['project_id'] == $project['id'] ? 'selected' : ''; ?>><?= $project['project_name'] ?></option>
                                            <?php }
                                            } ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group col-6">
                                    <label for="type" class="">Type</label>
                                    <div class="col-sm-8">
                                        <div class=" ">
                                            <input type="radio" <?= empty($row_data['type']) ? 'checked' : ''; ?> <?= !empty($row_data['type']) && $row_data['type'] == 'Rural' ? 'checked' : ''; ?> name="type" class="" id="type1" value="Rural">
                                            <label class="" for="type1">Rural</label>
                                        </div>
                                        <div class=" ">
                                            <input type="radio" <?= !empty($row_data['type']) && $row_data['type'] == 'Urban' ? 'checked' : ''; ?> name="type" class="" id="type2" value="Urban">
                                            <label class="" for="type2">Urban</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group col-12">
                                    
                                    <div class="">
                                        <button type="submit" name="saveGramPanchayat" id="saveGramPanchayat" class="btn btn-danger btn-icon-text mt-2">
                                            Save
                                        </button>
                                    </div>
                                </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <!-- content-wrapper ends -->
            <?php page_footer(); ?>