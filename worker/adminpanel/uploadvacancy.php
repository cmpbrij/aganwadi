<?php
include 'master.php';
ob_start();

if(!checkLogin()){
    header('Location: login.php');
}

page_header_start('Admin Dashboard | ICDS | AWW Recruitment');
?>
<script type="text/javascript" src="../public/js/jquery-min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.css" integrity="sha512-0TsYUclL0x2HXTMBHTQyrsFGsELlmYZRsmq8OG1SkV6V2lRzsZoFEddMf1dsqySJIegvLmrowaeiA9HNop2dXA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.min.css" integrity="sha512-gpqtQIgLIXYBimyliA0xmgme7m5coXHQhscvqhAZcOoPlKOmEzPg2BhYIYV/d39j7fEkXh42UeVt7g5PzUtfSg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<style>
    #otpSection {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        margin-top: 20px;
    }
    .input-group {
        margin-bottom: 10px;
    }
    #timer, #resendTimer {
        font-weight: bold;
        color: #dc3545;
    }
    .text-danger {
        color: #dc3545 !important;
    }
    .form-text {
        margin-top: 5px;
    }
</style>
<?php
page_header_end();
navigation();

if(isset($_SESSION['adminid'])){
    $q="select * from admin_users where id='".$_SESSION['sid']."'";
    $res= execute_query($q);
    $adata=mysqli_fetch_assoc($res);
}
?>

<!-- partial -->
<div class="container-fluid page-body-wrapper">
    <!-- partial:../../partials/_settings-panel.html -->
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
                        <div class="card-body">
                            <h4 class="card-title">Upload Advertisement PDF file</h4>
                            <p class="card-description" style="color:red;">
                                On Public Domain
                            </p>
                            
                            <?php if (isset($_SESSION['success'])): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="bi bi-check-circle-fill me-2"></i>
                                    <?= htmlspecialchars($_SESSION['success']) ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <?php unset($_SESSION['success']); ?>
                            <?php endif; ?>

                            <?php if (isset($_SESSION['error'])): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    <?= htmlspecialchars($_SESSION['error']) ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                <?php unset($_SESSION['error']); ?>
                            <?php endif; ?>
                            
                            <form class="forms-sample" action="dpouploaddoc.php" method="post" enctype='multipart/form-data' id="uploadForm">
                                <!-- Add CSRF Token -->
                                <input type="hidden" name="csrf_token" value="<?php 
                                    if(!isset($_SESSION['csrf_token'])) {
                                        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                                    }
                                    echo $_SESSION['csrf_token']; 
                                ?>">
                                
                                <div class="form-group row">
                                    <label for="pdffile" class="col-sm-3 col-form-label">Upload Document</label>
                                    <div class="col-sm-9">
                                        <input type="file" name="pdffile" class="form-control mt-2" id="pdffile" placeholder="Attach PDF" required accept=".pdf">
                                        <small class="form-text text-muted">Only PDF files are allowed. Max size: 5MB</small>
                                    </div> 
                                </div>
                                
                                <div class="form-group row">
                                    <label for="cutoff_date" class="col-sm-3 col-form-label">Cut off date</label>
                                    <div class="col-sm-9 mt-3">
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="cutoff_date" class="form-check-input" id="cutoff_jan" value="jan" required>
                                            <label class="form-check-label" for="cutoff_jan">1st Jan</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input type="radio" name="cutoff_date" class="form-check-input" id="cutoff_july" value="july">
                                            <label class="form-check-label" for="cutoff_july">1st July</label>
                                        </div>
                                    </div> 
                                </div>
                                
                                <div class="form-group row">
                                    <label for="last_date" class="col-sm-3 col-form-label">Last Date</label>
                                    <div class="col-sm-9">
                                        <input type="date" name="last_date" class="form-control mt-2" id="last_date" placeholder="Vacancy Last Date" required min="<?php echo date('Y-m-d'); ?>">
                                        
                                        <br>
                                        <button type="button" id="uploadBtn" class="btn btn-danger btn-icon-text mt-2">
                                            <i class="mdi mdi-upload btn-icon-prepend"></i>                                                    
                                            Upload
                                        </button>
                                    </div> 
                                </div>
                                
                                <!-- OTP Section (Initially hidden) -->
                                <div id="otpSection" style="display: none;">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label for="uotp" class="form-label">Enter OTP <span class="text-danger">*</span></label>
                                            <div class="">
                                                <input type="text" class="form-control" id="uotp" name="uotp" 
                                                       maxlength="6" placeholder="Enter 4-digit OTP"><br>
                                                <button type="button" class="btn btn-outline-secondary" id="resendOtpBtn">
                                                    Resend OTP (<span id="resendTimer">180</span>s)
                                                </button>
                                                <button type="button" class="btn btn-outline-danger" id="cancelOtpBtn">
                                                    Cancel
                                                </button>
                                            </div>
                                            <div class="form-text">Enter the 4-digit OTP sent to your registered mobile number.</div>
                                            <div id="otpTimer" class="mt-2">
                                                <small class="text-muted">OTP expires in: <span id="timer">03:00</span></small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-8">
                                            <button type="submit" id="otpSubmitBtn" class="btn btn-success btn-icon-text mt-2" name="saveuploadOrder">
                                                <i class="mdi mdi-check-circle btn-icon-prepend"></i>
                                                Verify OTP & Submit
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Uploaded Details</h4>
                            <p class="card-description" style="color:red;">
                               
                            </p>
                            <div class="row">
                                <table class="table">
                                    <tr>
                                        <th>Uploaded Date</th>
                                        <th>Attached PDF</th>
                                        <th>Last Date</th>
                                    </tr>
                                    <?php
                                        $sql1="SELECT * FROM `vacancy_order` WHERE dist_id='".$_SESSION['distid']."'";
                                        $res1=execute_query($sql1);
                                        if(mysqli_num_rows($res1) > 0){
                                            $rowdata=mysqli_fetch_array($res1);
                                            echo'<tr>
                                                    <td>'.date('d-m-Y H:i:s', strtotime($rowdata['created'])).'</td>
                                                    <td><a target="_blank" href="'.$rowdata['pdf_name'].'">View File</a></td>
                                                    <td>'.date('d-m-Y', strtotime($rowdata['last_date'])).'</td>
                                                </tr>';
                                        } else {
                                            echo'<tr><td colspan="3" class="text-center">No records found</td></tr>';
                                        }
                                    ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
        $(document).ready(function(){  
            // Clear OTP storage on every page load
            localStorage.removeItem('otpRequestTime');
            localStorage.removeItem('otpActive');
            
            // Also hide OTP section on page load
            $('#otpSection').hide();
            $('#uploadBtn').show();
            
            var otpTimer;
            var timeLeft = 180; // 3 minutes in seconds
            var otpSent = false;
            
            // Function to start OTP timer
            function startOtpTimer() {
                clearInterval(otpTimer);
                
                updateTimerDisplay();
                $('#resendOtpBtn').prop('disabled', true);
                
                otpTimer = setInterval(function() {
                    timeLeft--;
                    updateTimerDisplay();
                    
                    if(timeLeft <= 0) {
                        clearInterval(otpTimer);
                        hideOtpSection();
                        otpSent = false;
                        swal("OTP Expired!", "OTP has expired. Please request again.", "warning");
                        return;
                    }
                }, 1000);
            }
            
            // Function to update timer display
            function updateTimerDisplay() {
                var minutes = Math.floor(timeLeft / 60);
                var seconds = timeLeft % 60;
                var timerText = minutes.toString().padStart(2, '0') + ':' + seconds.toString().padStart(2, '0');
                $('#timer').text(timerText);
                $('#resendTimer').text(timeLeft);
                
                if(timeLeft <= 30) {
                    $('#timer').addClass('text-danger');
                    $('#resendTimer').addClass('text-danger');
                } else {
                    $('#timer').removeClass('text-danger');
                    $('#resendTimer').removeClass('text-danger');
                }
            }
            
            // Function to validate form
            function validateForm() {
                var pdf = $('#pdffile').val();
                var lastDate = $('#last_date').val();
                var cutoffDate = $('input[name="cutoff_date"]:checked').val();
                
                if(pdf == '') {
                    swal("Warning!", "Please attach PDF file", "warning");
                    return false;
                }
                
                var fileExt = pdf.split('.').pop().toLowerCase();
                if(fileExt !== 'pdf') {
                    swal("Warning!", "Only PDF files are allowed", "warning");
                    return false;
                }
                
                if($('#pdffile')[0].files[0]) {
                    var fileSize = $('#pdffile')[0].files[0].size;
                    var maxSize = 5 * 1024 * 1024;
                    if(fileSize > maxSize) {
                        swal("Warning!", "File size exceeds 5MB limit", "warning");
                        return false;
                    }
                }
                
                if(lastDate == '') {
                    swal("Warning!", "Please select last date", "warning");
                    return false;
                }
                
                if(!cutoffDate) {
                    swal("Warning!", "Please select cutoff date", "warning");
                    return false;
                }
                
                var selectedDate = new Date(lastDate);
                var today = new Date();
                today.setHours(0, 0, 0, 0);
                
                if(selectedDate < today) {
                    swal("Warning!", "Last date cannot be in the past", "warning");
                    return false;
                }
                
                return true;
            }
            
            // Function to send OTP
            function sendOTP() {
                if(!validateForm()) {
                    return false;
                }
                
                var uploadBtn = $('#uploadBtn');
                var originalText = uploadBtn.html();
                uploadBtn.html('<i class="mdi mdi-loading mdi-spin btn-icon-prepend"></i> Sending OTP...');
                uploadBtn.prop('disabled', true);
                
                // Create FormData object to include file
                var formData = new FormData();
                formData.append('uploadOTP', '1');
                formData.append('last_date', $('#last_date').val());
                formData.append('cutoff_date', $('input[name="cutoff_date"]:checked').val());
                
                // Append file
                var fileInput = $('#pdffile')[0];
                if(fileInput.files[0]) {
                    formData.append('pdffile', fileInput.files[0]);
                }
                
                $.ajax({  
                    url: "ajaxotpsend.php", 
                    method: "POST",  
                    data: {
                        uploadOTP: 1
                    },
                    dataType: "json",  
                    success: function(response){   
                       // console.log("OTP Response:", response);
                        
                        // If OTP is sent successfully OR OTP already exists and is valid
                        if((response && response.status === 'success') || 
                           (response && response.status === 'error' && response.show_otp_input)) {
                            
                            showOtpSection();
                            
                            // Start OTP timer with remaining time
                            if(response.remaining_time) {
                                timeLeft = response.remaining_time;
                            } else {
                                timeLeft = 180;
                            }
                            startOtpTimer();
                            otpSent = true;
                            
                            localStorage.setItem('otpRequestTime', Date.now());
                            localStorage.setItem('otpActive', 'true');
                            
                            swal({
                                title: response.status === 'success' ? "Success!" : "Info",
                                text: response.message,
                                icon: response.status === 'success' ? "success" : "info",
                                timer: 2000,
                                buttons: false
                            });
                            
                            setTimeout(function() {
                                $('#uotp').focus();
                            }, 500);
                            
                        } else {
                            swal("Error!", response.message, "error");
                            uploadBtn.html(originalText);
                            uploadBtn.prop('disabled', false);
                        }
                    },
                    error: function(xhr, status, error) {
                       // console.log("AJAX Error:", status, error);
                        swal("Error!", "Failed to send OTP. Please check your connection.", "error");
                        uploadBtn.html(originalText);
                        uploadBtn.prop('disabled', false);
                    }
                });  
            }
            
            // Function to resend OTP
            function resendOTP() {
                if(timeLeft > 0) {
                    swal("Info", "Please wait for the current OTP to expire before resending.", "info");
                    return;
                }
                sendOTP();
            }
            
            // Function to cancel OTP
            function cancelOTP() {
                hideOtpSection();
                otpSent = false;
                localStorage.removeItem('otpRequestTime');
                localStorage.removeItem('otpActive');
                swal("Cancelled", "OTP request cancelled", "info");
            }
            
            // Function to show OTP section
            function showOtpSection() {
                $('#otpSection').show();
                $('#uploadBtn').hide();
                $('#otpTimer').show();
            }
            
            // Function to hide OTP section
            function hideOtpSection() {
                $('#otpSection').hide();
                $('#uploadBtn').show();
                $('#uploadBtn').prop('disabled', false).html('<i class="mdi mdi-upload btn-icon-prepend"></i> Upload');
                $('#otpTimer').hide();
                $('#uotp').val('');
                
                if (otpTimer) {
                    clearInterval(otpTimer);
                    otpTimer = null;
                }
                
                // Reset timer display
                $('#timer').text('03:00');
                $('#resendTimer').text('180');
            }
            
            // Upload button click handler
            $(document).on('click', '#uploadBtn', function(){  
                sendOTP();
            });
            
            // Resend OTP button click handler
            $(document).on('click', '#resendOtpBtn', function(){  
                resendOTP();
            });
            
            // Cancel OTP button click handler
            $(document).on('click', '#cancelOtpBtn', function(){  
                cancelOTP();
            });
            
            // OTP input validation
            $('#uotp').on('input', function() {
                var otp = $(this).val();
                $(this).val(otp.replace(/\D/g, ''));
                if(otp.length > 6) {
                    $(this).val(otp.substring(0, 6));
                }
            });
            
            // Enable resend button when timer expires
            setInterval(function() {
                if(timeLeft <= 0 && $('#resendOtpBtn').prop('disabled')) {
                    $('#resendOtpBtn').prop('disabled', false).html('Resend OTP');
                }
            }, 1000);
        });
        </script>

        <!-- content-wrapper ends -->
        <?php page_footer(); ?>
    </div>
</div>