<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'master.php';
ob_start();

if (!checkLogin()) {
    header('Location: login.php');
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
        $query = "select * from new_vacancy where id='" . $row_id . "'";
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
                            <h4 class="card-title " style="line-height: 35px;"><?php echo !empty($row_id) ? 'Update' : 'Add'; ?> Aww center - <?php echo !empty($adata['district']) ? $adata['district'] : ''; ?>
                                <a href="old-vacancies.php" class="btn btn-primary text-white" style="float: right;font-size: 12px;">Old Center List</a>
                            </h4>
                            <form class="forms-sample" action="submitVacancy.php" method="post" enctype='multipart/form-data'>
                                <input type="hidden" name="row_id" value="<?php echo !empty($row_id) ? $row_id : ''; ?>">
                                 <input type="hidden" name="old" value="1">

                               <div class="card shadow-sm mt-3">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Anganwadi Center Information</h5>
                                </div>
                                <div class="card-body">
                                    <?php 
                                    $sql = "SELECT ov.*, bm.block_name, gp.gram_panchayat_name  
                                            FROM old_vacancy AS ov
                                            JOIN block_master AS bm ON bm.id = ov.project_id
                                            JOIN gram_panchayat AS gp ON gp.id = ov.gp_id
                                            WHERE ov.id = '" . $_GET['id'] . "'";
                                    $res = execute_query($sql);
                                    $data = mysqli_fetch_assoc($res);
                                    ?>
                                        <input type="hidden" name="awc_code" value="<?php echo $data['awc_name']; ?>"> 
                                        <input type="hidden" name="center_name" value="<?php echo $data['unique_code']; ?>"> 
                                        <input type="hidden" name="project_id" value="<?php echo $data['project_id']; ?>"> 
                                        <input type="hidden" name="gram_panchayat_id" value="<?php echo $data['gp_id']; ?>">
                                        <input type="hidden" name="row_id" value="<?php echo $data['id']; ?>"> 
                                        <input type="hidden" name="project_name" value="<?php echo $data['block_name']; ?>">


                                    <div class="row">
                                    <div class="col-md-6 col-lg-3 mb-3">
                                        <strong>Unique Code</strong><br>
                                        <span class="text-muted"><?php echo $data['unique_code']; ?></span>
                                    </div>
                                    <div class="col-md-6 col-lg-3 mb-3">
                                        <strong>Center Name</strong><br>
                                        <span class="text-muted"><?php echo $data['awc_name']; ?></span>
                                    </div>
                                    <div class="col-md-6 col-lg-3 mb-3">
                                        <strong>Project Name</strong><br>
                                        <span class="text-muted"><?php echo $data['block_name']; ?></span>
                                    </div>
                                    <div class="col-md-6 col-lg-3 mb-3">
                                        <strong>Gram Panchayat Name</strong><br>
                                        <span class="text-muted"><?php echo $data['gram_panchayat_name']; ?></span><br>
                                    </div>
                                </div>


                                <div class="row mt-3">
                            
                                    <div class="form-group col-6">
                                        <label for="category" class="">Select Category</label>
                                        <div class="">
                                            <select style="height: 52px;" name="category" id="category" class="form-control mt-2" required>
                                                <option value="">Select Category</option>

                                                <option value="1" <?= !empty($row_data['category']) && $row_data['category'] == '1' ? 'selected' : ''; ?>>Unreserved(UR)</option>
                                                <option value="2" <?= !empty($row_data['category']) && $row_data['category'] == '2' ? 'selected' : ''; ?>>Other Backward Class(OBC)</option>
                                                <option value="3" <?= !empty($row_data['category']) && $row_data['category'] == '3' ? 'selected' : ''; ?>>Scheduled Caste(SC)</option>
                                                <option value="4" <?= !empty($row_data['category']) && $row_data['category'] == '4' ? 'selected' : ''; ?>>Scheduled Tribe(ST)</option>
                                                <!-- <option value="5" <?= !empty($row_data['category']) && $row_data['category'] == '5' ? 'selected' : ''; ?>>EWS</option> -->

                                            </select>
                                        </div>
                                    </div>

                                     <div class="form-group col-6">
                                        <label for="category" class="">Select Center Type</label>
                                        <div class="">
                                            <select style="height: 52px;" name="centertype" id="centertype" class="form-control mt-2" required>
                                                <option value="">Select Urabn/Rural</option>

                                                <option value="Urban" >Urban</option>
                                                <option value="Rural">Rural</option>
                                                

                                            </select>
                                        </div>
                                    </div>
                                   
                                    <div class="form-group col-12">
                                         
                                        <div class="">
                                            <button type="submit" name="saveAwwCenter" id="saveAwwCenter" class="btn btn-danger btn-icon-text mt-2">Save Vacancy</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

<script>
    $(document).ready(function() {
        $('#unique_code').change(function() {
            var awcId = $(this).val();
            if (awcId) {
                $('#loadingCode').show(); 
                $.ajax({
                    url: 'ajax_aww.php',
                    type: 'POST',
                    data: {
                        action: 'get_awc_details',
                        awc_id: awcId
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#loadingCode').hide();
                        if (response.success) {
                            // Auto-fill the form fields
                            $('#awc_name').val(response.data.awc_name);
                            $('#project_id').val(response.data.project_id);
                            $('#category').val(response.data.category);
                            
                            // Load Gram Panchayat for the selected project
                            loadGramPanchayat(response.data.project_id, response.data.gram_panchayat_id);
                            
                            showMessage('Form auto-filled successfully!', 'success');
                        } else {
                            showMessage(response.message, 'danger');
                        }
                    },
                    error: function() {
                        $('#loadingCode').hide();
                        showMessage('Error loading AWC details', 'danger');
                    }
                });
            }
        });
    }):
        </script>
            <!-- content-wrapper ends -->
            <?php page_footer(); ?>