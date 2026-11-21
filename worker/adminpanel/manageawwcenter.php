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
                                <a href="awwcenterlist.php" class="btn btn-primary text-white" style="float: right;font-size: 12px;">List</a>
                            </h4>
                            <form class="forms-sample" action="saveAwwCenter.php" method="post" enctype='multipart/form-data'>
                                <input type="hidden" name="row_id" value="<?php echo !empty($row_id) ? $row_id : ''; ?>">

                                <div class="row">
                                     <div class="form-group col-6">
                                        <label for="unique_code" class="">Unique Code</label>
                                        <div class="">
                                            <select style="height: 52px;" class="form-control mt-2" name="unique_code" id="unique_code" required>
                                            <option value="">-- Select AWC Code --</option>
                                            <?php 
                                                // Make sure $district_id is properly sanitized to prevent SQL injection
                                                $district_id = intval($district_id);
                                                $qry = "SELECT * FROM awc_master_new WHERE district_id='$district_id'";
                                                $resd = execute_query($qry);
                                                while($awwd = mysqli_fetch_assoc($resd)){
                                                    echo '<option value="'.$awwd['id'].'">'.$awwd['awc_code'].'</option>';
                                                }
                                            ?>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="awc_name" class="">Aww center</label>
                                        <div class="">
                                            <input type="text" value="<?= !empty($row_data['awc_name']) ? $row_data['awc_name'] : ''; ?>" name="awc_name" class="form-control mt-2" id="awc_name" placeholder="Enter Aww center name" required>
                                        </div>
                                    </div>
                                   
                                    <div class="form-group col-6">
                                        <label for="project_id" class="">Select Project</label>
                                        <div class="">
                                            <select style="height: 52px;" name="project_id" id="project_id" onchange="fetchGramPanchayat(this.value)" class="form-control mt-2" required>
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
                                        <label for="gram_panchayat_id" class="">Select Gram Pachayat</label>
                                        <div class="">
                                            <select style="height: 52px;" name="gram_panchayat_id" id="gram_panchayat_id" class="form-control mt-2" required>
                                                <option value="">Select Gram Pachayat</option>
                                            </select>
                                        </div>
                                    </div>
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
                                    <!-- <div class="form-group col-6">
                                        <label for="type" class="">Type Of Anganwadi</label>
                                        <div class="">
                                            <div class="form-check form-check-inline">
                                                <input type="radio" <?= empty($row_data['type_of_anganwadi']) ? 'checked' : ''; ?> <?= !empty($row_data['type_of_anganwadi']) && $row_data['type_of_anganwadi'] == 'Main Anganwadi' ? 'checked' : ''; ?> name="type_of_anganwadi"  id="type1" value="Main Anganwadi">
                                                <label class="form-check-labels" for="type1">Main Anganwadi</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" <?= !empty($row_data['type_of_anganwadi']) && $row_data['type_of_anganwadi'] == 'Mini Anganwadi' ? 'checked' : ''; ?> name="type_of_anganwadi"  id="type2" value="Mini Anganwadi">
                                                <label class="form-check-labels" for="type2">Mini Anganwadi</label>
                                            </div>
                                        </div>
                                    </div> -->
                                    <!-- <div class="form-group col-6">
                                        <label for="vacancy_available" class="">Vacancy Available</label>
                                        <div class="">
                                            <div class="form-check form-check-inline">
                                                <input type="radio" <?= empty($row_data['vacancy_available']) ? 'checked' : ''; ?> <?= !empty($row_data['vacancy_available']) && $row_data['vacancy_available'] == 'No' ? 'checked' : ''; ?> name="vacancy_available"  id="vacancy_available1" value="No">
                                                <label class="form-check-labels" for="vacancy_available1">No</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input type="radio" <?= !empty($row_data['vacancy_available']) && $row_data['vacancy_available'] == 'Yes' ? 'checked' : ''; ?> name="vacancy_available"  id="vacancy_available2" value="Yes">
                                                <label class="form-check-labels" for="vacancy_available2">Yes</label>
                                            </div>
                                        </div>
                                    </div> -->

                                    <div class="form-group col-12">
                                         
                                        <div class="">
                                            <button type="submit" name="saveAwwCenter" id="saveAwwCenter" class="btn btn-danger btn-icon-text mt-2">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                <?php
                if (!empty($row_data['project_id']) && !empty($row_data['gram_panchayat_id'])) {
                    echo "fetchGramPanchayat('" . $row_data['project_id'] . "' , '" . $row_data['gram_panchayat_id'] . "');";
                }
                ?>

                function isNumberKey(evt) {
                    var charCode = (evt.which) ? evt.which : evt.keyCode
                    if (charCode > 31 && (charCode < 48 || charCode > 57))
                        return false;
                    return true;
                }

                function fetchGramPanchayat(project_id, gram_panchayat_id = '') {

                    $.ajax({
                        url: 'ajax.php',
                        type: 'POST',
                        data: {
                            action: 'fetchGramPanchayat',
                            project_id: project_id,
                            gram_panchayat_id: gram_panchayat_id
                        },
                        success: function(response) {
                            $('#gram_panchayat_id').html(response);
                        }
                    });
                }
            </script>

 <script>
    $(document).ready(function() {
    
        // Auto-fill form when AWC code is selected
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