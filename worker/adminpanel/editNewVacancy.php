<?php

// error_reporting(E_ALL);
// ini_set('display_errors', 1);
include 'master.php';
ob_start();

if (!checkLogin()) {
    header('Location: login.php');
    exit;
}

page_header_start('Edit Vacancy | ICDS | AWW Recruitment');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.min.js"></script>
<?php

page_header_end();
navigation();



if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid Request');window.location='viewallvacancy.php';</script>";
    exit;
}

$id = $_GET['id'];

$sql = "SELECT * FROM new_vacancy WHERE unique_code = $id";
$res = execute_query($sql);
$data = mysqli_fetch_assoc($res);

$is_old = $data['is_old']; // 1 or 0 from databas

if (!$data) {
    echo "<script>alert('Record not found!');window.location='viewallvacancy.php';</script>";
    exit;
}

if (isset($_POST['update_vacancy'])) {
    $category = mysqli_real_escape_string($conn, $_POST['category'] ?? '');
    $centertype = mysqli_real_escape_string($conn, $_POST['centertype'] ?? '');

    $is_old = $_POST['is_old'];

    $update_sql = "UPDATE new_vacancy 
                   SET category = '$category', awc_urban_rural = '$centertype', is_old = '$is_old'
                   WHERE unique_code = $id";

    if (mysqli_query($conn, $update_sql)) {
        $_SESSION['success-msg'] = "Vacancy updated successfully!";
        echo "<script>
           
            setTimeout(function(){ window.location='viewallvacancy.php'; }, 1500);
        </script>";
    } else {
        echo "<script>swal('Error', 'Update failed. Please try again.', 'error');</script>";
    }
}
?>

<div class="container-fluid page-body-wrapper" style="padding-left:0px; padding-right:0px;">
    <?php sidebar(); ?>

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4 text-primary">Edit Vacancy</h4>
                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label><b>Unique Code</b></label><br>
                                <span class="text-muted"><?php echo $data['unique_code'] ?? '-'; ?></span>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label><b>Center Name</b></label><br>
                                <span class="text-muted"><?php echo $data['awc_name'] ?? '-'; ?></span>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label><b>Project Name</b></label><br>
                                <span class="text-muted"><?php echo $data['project_name'] ?? '-'; ?></span>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label><b>Gram Panchayat Name</b></label><br>
                                <span class="text-muted"><?php echo $data['gp_name'] ?? '-'; ?></span>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><b>Select Category</b></label>
                                <select class="form-control" name="category" required>
                                    <option value="">Select Category</option>
                                    <option value="1" <?= ($data['category'] ?? '') == '1' ? 'selected' : ''; ?>>Unreserved (UR)</option>
                                    <option value="2" <?= ($data['category'] ?? '') == '2' ? 'selected' : ''; ?>>Other Backward Class (OBC)</option>
                                    <option value="3" <?= ($data['category'] ?? '') == '3' ? 'selected' : ''; ?>>Scheduled Caste (SC)</option>
                                    <option value="4" <?= ($data['category'] ?? '') == '4' ? 'selected' : ''; ?>>Scheduled Tribe (ST)</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label><b>Select Center Type</b></label>
                                <select class="form-control" name="centertype" required>
                                    <option value="">Select Urban/Rural</option>
                                    <option value="Urban" <?= ($data['awc_urban_rural'] ?? '') == 'Urban' ? 'selected' : ''; ?>>Urban</option>
                                    <option value="Rural" <?= ($data['awc_urban_rural'] ?? '') == 'Rural' ? 'selected' : ''; ?>>Rural</option>
                                </select>
                            </div>

                            <div class="form-group col-6">
                                <label>Is pending from previous selection?</label>
                                <div>
                                    <input type="hidden" name="is_old" value="0">
                                    
                                    <input type="checkbox" name="is_old" value="1"
                                        <?php if($is_old == 1) echo 'checked'; ?>>
                                </div>
                            </div>
                        </div>

                        <div class="text-end mt-4">
                            <button type="submit" name="update_vacancy" class="btn btn-success px-4">Update Vacancy</button>
                            <a href="viewallvacancy.php" class="btn btn-secondary px-4">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php page_footer(); ?>
