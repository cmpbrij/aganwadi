<?php
ob_start();
include 'master.php';

if (!checkLogin()) {
    header('Location: login.php');
    exit;
}

page_header_start('Admin Dashboard | ICDS | AWW Recruitment');
page_header_end();
navigation();

if (isset($_SESSION['adminid']) && isset($_SESSION['sid'])) {
    $sid = (int) $_SESSION['sid'];
    $q = "SELECT * FROM admin_users WHERE id = $sid";
    $res = execute_query($q);
    if ($res && mysqli_num_rows($res) > 0) {
        $adata = mysqli_fetch_assoc($res);
    }
}
?>

<div class="container-fluid page-body-wrapper">
    <?php sidebar(); ?>

    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">

                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Date Set for Letter AWW Generation</h4>

                            <form id="uploadForm" method="post">
                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><b>Set Date</b></label>
                            <div class="col-sm-9">
                                <input name="letter_date" type="date" id="letter_date" class="form-control" required>
                            </div>
                        </div>

                         <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><b>Set Anumodan Date</b></label>
                            <div class="col-sm-9">
                                <input name="anumodan_date" type="date" id="anumodan_date" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3 col-form-label"><b>Remarks</b></label>
                            <div class="col-sm-9">
                                <textarea name="remarks" id="remarks" class="form-control"></textarea>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-3 offset-3">
                                <button type="button" id="uploadBtn" class="btn btn-danger btn-icon-text mt-2">
                                    <i class="mdi mdi-content-save btn-icon-prepend"></i> Submit
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-9 offset-3">
                                <div id="uploadStatus" class="mt-2"></div>
                            </div>
                        </div>
                    </form>

                        </div>
                    </div>
                </div>

                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Date Set Details</h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Submit Date</th>
                                            <th>Set Date</th>
                                             <th>Anumodan Date</th>
                                            <th>Remarks</th>
                                        </tr>

                                        <?php
                                        $distid = $_SESSION['distid'];
                                        $sql1 = "SELECT * FROM letter_date_setting WHERE dist_id = '$distid' ORDER BY id DESC";

                                        $res1 = execute_query($sql1);

                                        $i = 0; // counter

                                        if ($res1 && mysqli_num_rows($res1) > 0) {
                                            while ($rowdata = mysqli_fetch_assoc($res1)) {

                                                // first row = latest row
                                                if ($i == 0) {
                                                    $row_style = "style='background-color:#d4edda; font-weight:bold;'"; // green
                                                    $status = "<span style='color:green; font-weight:bold;'>Active</span>";
                                                } else {
                                                    $row_style = "";
                                                    $status = "<span style='color:#999;'>Old</span>";
                                                }

                                                echo '<tr ' . $row_style . '>
                                                    <td>' . date('d-m-Y H:i:s', strtotime($rowdata['created_at'])) . '</td>
                                                    <td>' . date('d-m-Y', strtotime($rowdata['letter_date'])) . '</td>
                                                     <td>' . date('d-m-Y', strtotime($rowdata['anumodan_date'])) . '</td>
                                                    <td>' . htmlspecialchars($rowdata['remarks']) . '</td>
                                                </tr>';

                                                $i++;
                                            }
                                        } else {
                                            echo '<tr><td colspan="3" class="text-center">No date set yet.</td></tr>';
                                        }
                                        ?>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {

    $('#uploadBtn').on('click', function () {

        var letter_date = $('#letter_date').val();
        var anumodan_date = $('#anumodan_date').val();
        var remarks = $('#remarks').val();

        if (letter_date === '') {
            $('#uploadStatus').html('<span style="color:red;">Please select date.</span>');
            return;
        }

        $('#uploadBtn').prop('disabled', true).html('Submitting...');
        $('#uploadStatus').html('<span style="color:#555;">Saving, please wait...</span>');

        $.ajax({
            url: 'ajax_dateset.php',
            type: 'POST',
            data: {
                save_letter_date: 1,
                letter_date: letter_date,
                anumodan_date: anumodan_date,
                remarks: remarks
            },
            dataType: 'json',
            success: function (response) {
                $('#uploadBtn').prop('disabled', false).html('<i class="mdi mdi-content-save btn-icon-prepend"></i> Submit');

                if (response.status === 'success') {
                    $('#uploadStatus').html('<span style="color:green;">' + response.message + '</span>');
                    setTimeout(function () {
                        window.location.reload();
                    }, 1000);
                } else {
                    $('#uploadStatus').html('<span style="color:red;">' + response.message + '</span>');
                }
            },
            error: function (xhr) {
                $('#uploadBtn').prop('disabled', false).html('<i class="mdi mdi-content-save btn-icon-prepend"></i> Submit');
                console.log(xhr.responseText);
                $('#uploadStatus').html('<span style="color:red;">Error: ' + xhr.responseText + '</span>');
            }
        });
    });

});
</script>

<?php page_footer(); ?>