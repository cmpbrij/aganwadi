<?php
include 'admin_master.php';
ob_start();

if (!checkLogin()) {
    header('Location: login.php');
}

page_header_start('Admin Dashboard | ICDS | AWW Recruitment');
?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">
<style>
    .error {
        color: red;
    }
</style>
<?php

page_header_end();

navigation();

if (isset($_GET['id'])) {
    $q = "select * from admin_users where id='" . $_GET['id'] . "'";
    $res = execute_query($q);
    $adata = mysqli_fetch_assoc($res);
}
// else{
//     echo'Somting went wrong'; die;
// }

?>


<!-- partial -->
<div class="container-fluid page-body-wrapper">
    <!-- partial:../../partials/_settings-panel.html -->

    <?php
    if (isset($_SESSION['success'])) {
    ?>
        <script>
            swal("Success!", "User details changed successfully!", "success")
        </script>
    <?php
        unset($_SESSION['success']);
    }
    ?>

    <?php
    if (isset($_SESSION['error_in_change'])) {
    ?>
        <script>
            swal("Warning!", "Something wrong please try again!", "warning")
        </script>
    <?php
        unset($_SESSION['error_in_change']);
    }
    ?>
    <?php
    if (isset($_SESSION['warning'])) {
    ?>
        <script>
            swal("Warning!", "Something Went Wrong!", "warning")
        </script>
    <?php
        unset($_SESSION['warning']);
    }
    ?>


    <div id="right-sidebar" class="settings-panel">
        <i class="settings-close mdi mdi-close"></i>
        <ul class="nav nav-tabs" id="setting-panel" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="todo-tab" data-bs-toggle="tab" href="#todo-section" role="tab" aria-controls="todo-section" aria-expanded="true">TO DO LIST</a>
            </li>
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

                        <li>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input class="checkbox" type="checkbox">
                                    <!-- Resolve all the low priority tickets due today -->
                                </label>
                            </div>
                            <i class="remove mdi mdi-close-circle-outline"></i>
                        </li>

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
            <div class="row">
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-header">
                        
                        <div class="card-body">
                            <h4 class="card-title">Update DPO Details</h4>
                            <p class="card-description" style="color:red;">

                            </p>
                            <form class="forms-sample" action="admin_user_up_submit.php" method="post" id="changeDetails">
                                <input type="hidden" name="user_id" value="<?php echo isset($adata['id'])?$adata['id']:''; ?>" class="form-control">
                                <div class="form-group row">
                                    <label for="name" class="col-sm-3 col-form-label">Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="name" value="<?php echo isset($adata['name'])?$adata['name']:''; ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="mobile" class="col-sm-3 col-form-label">Mobile No.</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="mobile" id="mobile" value="<?php echo isset($adata['mobile'])?$adata['mobile']:''; ?>" class="form-control">

                                        <br>
                                        <button type="submit" class="btn btn-danger btn-icon-text mt-4" name="changeUserDetails">

                                            Save
                                        </button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
                </div>
                <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                    <a href="admin_user_up_list.php" class="btn btn-info">View Updated Details</a>
                    </div>
                </div>
                </div>
            </div>

            <script>

            </script>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>

            <!-- content-wrapper ends -->
            <?php page_footer(); ?>
            <script>
                $(document).ready(function() {
                    $('#changeDetails').validate({
                        rules: {
                            name: {
                                required: true
                            },
                            mobile: {
                                required: true,
                            }
                        },
                        messages: {
                            name: {
                                required: "Please Enter Your Name"
                            },
                            Mobile: {
                                required: "Please Enter Your Mobile Number"
                            }
                        },
                        submitHandler: function(form) {
                            $('#changeDetails').submit();
                        }
                    });
                });
            </script>