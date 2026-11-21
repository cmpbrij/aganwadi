<?php 
    include'../config/db_config.php';
    session_start(); 
    $sql="select * from users where mobile='".$_SESSION['reset_mobile']."'";
    $res=execute_query($sql);
    if(mysqli_num_rows($res) > 0){

    }
    else{
      echo "Can not access"; 
      exit();
    }
      // Set the initial countdown time (in seconds)
    $initialCountdownTime = 300; // 5 minutes

    // Store the initial countdown time in a session variable
    if (!isset($_SESSION['countdown_time'])) {
        $_SESSION['countdown_time'] = time() + $initialCountdownTime;
    }

    // Calculate the remaining time
    $currentTime = time();
    $remainingTime = $_SESSION['countdown_time'] - $currentTime;
    if ($remainingTime < 0) {
        $remainingTime = 0;
    }

    //echo $remainingTime; die;
?>
<!doctype html>
<html>
<head>
    <title>Login-OTP : Anganwadi Recruitment, Uttar Pradesh</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="csrf-token" content="O9mUTOIwJ98dHE8ncyPuGeXHGQNe6Ctjpf9lCdBX" />

    <link rel="shortcut icon" href="../public/images/favicon.png" />
    <link href="../public/css/bootstrap.css" rel="stylesheet" />
    <link href="../public/css/all.css" rel="stylesheet" />
    <link href="../public/css/custom_theme_student.css" rel="stylesheet" />
    <link href="../public/css/responsive.css" rel="stylesheet" />
    <link href="../public/css/select2.min.css" rel="stylesheet" />
    <link href="../public/css/js_latest_toastr.min.css" rel="stylesheet" />

    <script type="text/javascript" src="../public/js/jquery-min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.min.js"></script>
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.min.css"
          integrity="sha512-gpqtQIgLIXYBimyliA0xmgme7m5coXHQhscvqhAZcOoPlKOmEzPg2BhYIYV/d39j7fEkXh42UeVt7g5PzUtfSg=="
          crossorigin="anonymous"
          referrerpolicy="no-referrer" />

<style>
* {
    box-sizing: border-box;
}

html,
body {
    margin: 0;
    padding: 0;
    width: 100%;
    min-height: 100%;
}

body {
    min-height: 100vh;
    background: linear-gradient(135deg, #eef5f8 0%, #f8fafc 100%);
    font-family: "Segoe UI", Arial, Helvetica, sans-serif;
    color: #1f2937;
    overflow-x: hidden;
}

.screen {
    position: fixed;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255,255,255,.65);
    backdrop-filter: blur(2px);
    z-index: 99999;
}

.loader {
    width: 44px;
    height: 44px;
    border: 3px solid #128cbc;
    border-top-color: #ff3d00;
    border-radius: 50%;
    animation: rotation 1s linear infinite;
}

@keyframes rotation {
    to {
        transform: rotate(360deg);
    }
}

/* Main area */
.otp-page {
    min-height: calc(100vh - 58px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 24px 15px;
}

/* Main card */
.otp-card {
    width: 100%;
    max-width: 570px;
    background: #ffffff;
    border: 1px solid #e3edf2;
    border-radius: 20px;
    padding: 24px 30px 26px;
    box-shadow: 0 12px 35px rgba(31, 72, 91, .12);
}

/* Logo section */
.logo-area {
    width: 100%;
    height: 92px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 24px;
    padding: 10px 20px;
    margin-bottom: 17px;
    background: linear-gradient(135deg, #f1f9fc 0%, #f8fbfd 100%);
    border: 1px solid #d9edf4;
    border-radius: 13px;
}

.logo-area img {
    width: auto;
    height: 66px;
    max-width: 120px;
    object-fit: contain;
    display: block;
}

/* Heading */
.page-title {
    margin: 0;
    text-align: center;
    color: #12263a;
    font-size: 23px;
    line-height: 1.25;
    font-weight: 750;
}

.page-subtitle {
    margin: 5px 0 0;
    text-align: center;
    color: #667085;
    font-size: 14px;
    line-height: 1.4;
}

.divider {
    width: 58px;
    height: 3px;
    border-radius: 10px;
    background: #128cbc;
    margin: 13px auto 19px;
}

/* OTP heading */
.otp-heading {
    text-align: center;
    margin-bottom: 18px;
}

.otp-heading h3 {
    margin: 0 0 4px;
    color: #128cbc;
    font-size: 25px;
    line-height: 1.2;
    font-weight: 800;
}

.otp-heading p {
    margin: 0;
    color: #555f6d;
    font-size: 14px;
    line-height: 1.45;
    font-weight: 600;
}

/* Form */
.form-group {
    margin-bottom: 15px !important;
}

.form-label {
    display: block;
    margin: 0 0 6px;
    color: #273444;
    font-size: 14px;
    line-height: 1.35;
    font-weight: 700;
}

.form-control {
    width: 100%;
    height: 45px;
    min-height: 45px;
    border: 1px solid #d4dee5 !important;
    border-radius: 9px !important;
    background: #fff;
    color: #202b36;
    padding: 9px 13px;
    font-size: 15px;
    box-shadow: none !important;
    outline: none;
}

.form-control:focus {
    border-color: #128cbc !important;
    box-shadow: 0 0 0 3px rgba(18,140,188,.10) !important;
}

/* OTP */
.otp-input {
    text-align: center;
    letter-spacing: 7px;
    font-size: 19px;
    font-weight: 700;
}

.otp-input::placeholder {
    letter-spacing: normal;
    font-size: 14px;
    font-weight: 400;
    color: #9aa3ad;
}

/* Captcha */
.captcha-row {
    display: grid;
    grid-template-columns: minmax(0, 1fr) 45px minmax(0, 1fr);
    align-items: end;
    gap: 10px;
}

.captcha-box,
.captcha-input-box {
    min-width: 0;
}

.captcha-image-wrap {
    height: 45px;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3px 8px;
    overflow: hidden;
    background: #f8fafc;
    border: 1px solid #d4dee5;
    border-radius: 9px;
}

#captcha1 {
    display: block;
    width: 100%;
    max-width: 170px;
    height: 39px;
    object-fit: contain;
}

/* Refresh */
.refresh {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.refresh a {
    width: 39px;
    height: 39px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #128cbc;
    color: #fff !important;
    text-decoration: none;
    cursor: pointer;
    box-shadow: 0 5px 12px rgba(18,140,188,.20);
    transition: transform .25s ease, background .25s ease;
}

.refresh a:hover {
    background: #0b7098;
    transform: rotate(180deg);
}

/* Error */
.error {
    display: block;
    min-height: 0;
    margin-top: 3px;
    color: #dc3545;
    font-size: 11px;
    line-height: 1.25;
}

/* Verify */
.cstm-btn {
    width: 100%;
    height: 47px;
    min-height: 47px;
    margin-top: 3px;
    border: 0 !important;
    border-radius: 9px !important;
    background: #128cbc !important;
    color: #fff !important;
    font-size: 15px;
    font-weight: 700;
    box-shadow: 0 6px 15px rgba(18,140,188,.20);
    transition: transform .2s ease, background .2s ease;
}

.cstm-btn:hover {
    background: #0b7098 !important;
    transform: translateY(-1px);
}

/* Prevent unused timer placeholders from creating visible space */
#resenddiv,
#timer,
#time {
    display: none !important;
}

/* Footer */
footer {
    min-height: 58px;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px 15px;
    background: #fff;
    border-top: 1px solid #e5e7eb;
}

.copyright {
    text-align: center;
    color: #667085;
    font-size: 11px;
    line-height: 1.5;
}

.copyright a {
    color: #128cbc;
    text-decoration: none;
    font-weight: 700;
}

/* Tablet / mobile */
@media (max-width: 767px) {
    .otp-page {
        min-height: calc(100vh - 58px);
        padding: 14px 10px;
        align-items: center;
    }

    .otp-card {
        max-width: 100%;
        padding: 19px 17px 21px;
        border-radius: 16px;
    }

    .logo-area {
        height: 82px;
        gap: 18px;
        padding: 8px 15px;
        margin-bottom: 14px;
    }

    .logo-area img {
        height: 58px;
        max-width: 105px;
    }

    .page-title {
        font-size: 20px;
    }

    .page-subtitle {
        font-size: 13px;
    }

    .divider {
        margin: 11px auto 16px;
    }

    .otp-heading {
        margin-bottom: 16px;
    }

    .otp-heading h3 {
        font-size: 23px;
    }

    .otp-heading p {
        font-size: 13px;
    }

    .captcha-row {
        grid-template-columns: minmax(0, 1fr) 43px;
        gap: 8px;
    }

    .captcha-input-box {
        grid-column: 1 / -1;
    }

    .refresh {
        width: 43px;
        height: 43px;
    }

    .refresh a {
        width: 38px;
        height: 38px;
    }
}

@media (max-width: 400px) {
    .otp-card {
        padding: 16px 13px 18px;
    }

    .logo-area {
        height: 76px;
        gap: 14px;
    }

    .logo-area img {
        height: 53px;
        max-width: 95px;
    }

    .page-title {
        font-size: 18px;
    }

    .otp-input {
        letter-spacing: 5px;
    }

    .otp-input::placeholder {
        font-size: 13px;
    }
}
</style>
</head>

<body>

<div class="screen" style="display: none">
    <span class="loader"></span>
</div>

<div class="otp-page">
    <div class="otp-card">

        <?php
        if(isset($_SESSION['otp-w'])){
        ?>
            <script>
                swal("Wrong!", "Wrong OTP!", "warning");
            </script>
        <?php
        unset($_SESSION['otp-w']);
        }
        ?>

        <?php
        if(isset($_SESSION['nototp'])){
        ?>
            <script>
                swal("Wrong !", "आपके द्वारा डाला गया ओ.टी.पी. गलत है !", "warning");
            </script>
        <?php
        unset($_SESSION['nototp']);
        }
        ?>

        <?php
        if(isset($_SESSION['no_match'])){
        ?>
            <script>
                swal("Wrong !", "आपके द्वारा डाला गया ओ.टी.पी. गलत है !", "warning");
            </script>
        <?php
        unset($_SESSION['no_match']);
        }
        ?>

        <div class="logo-area">
            <img src="../public/images/upgovt_logo.svg" alt="Logo 1">
            <img src="../public/images/ICDS_1.svg" alt="ICDS Logo">
        </div>

        <h1 class="page-title">Anganwadi Worker Recruitment</h1>
        <p class="page-subtitle">Uttar Pradesh, Lucknow</p>
        <div class="divider"></div>

        <div class="otp-heading">
            <h3>OTP</h3>
            <p>आप अपना ओटीपी दर्ज कराये</p>
        </div>

        <form action="submit_login.php" method="post" class="needs-validation" novalidate>

            <div class="form-group mb-3">
                <label for="user_id" class="form-label">
                    OTP/ओटीपी <span class="text-danger">*</span>
                </label>

                <input type="text"
                       class="form-control num_digit otp-input"
                       name="otp"
                       placeholder="कृप्या ओटीपी दर्ज करे"
                       maxlength="4"
                       minlength="4"
                       required>
            </div>

            <div class="form-group mb-3">

                <div class="captcha-row">

                    <div class="captcha-box">
                        <label class="form-label">
                            Captcha/कैप्चा
                        </label>

                        <div class="captcha-image-wrap">
                            <img src="../captcha.php" id="captcha1" alt="Captcha">
                        </div>

                        <input name="captchacode"
                               type="hidden"
                               class="form-control captchacode unselectable h4"
                               value=""
                               readonly>

                        <span class="error">
                            <?php
                            if(isset($_SESSION['cerror'])){
                                echo $_SESSION['cerror'];
                                unset($_SESSION['cerror']);
                            }
                            ?>
                        </span>
                    </div>

                    <div class="refresh" id="refresh">
                        <a onClick="refreshCaptcha();"
                           title="Refresh Captcha"
                           id="refreshCaptcha">
                            <span class="fas fa-redo"></span>
                        </a>
                    </div>

                    <div class="captcha-input-box">
                        <label class="form-label">
                            Enter Captcha/कैप्चा भरें
                            <span class="text-danger">*</span>
                        </label>

                        <input name="captcha"
                               type="text"
                               id="captcha-input"
                               maxlength="5"
                               minlength="5"
                               class="form-control"
                               required>
                    </div>

                </div>

            </div>

            <div class="d-grid mb-3">
                <button class="cstm-btn btn"
                        type="submit"
                        name="resetotpVerify">
                    Verify/सत्यापित करें
                </button>
            </div>

        </form>

        <script>
function get_captcha() {
    var captcha = document.getElementById('captcha1');

    if (captcha) {
        captcha.src = '../captcha.php?_=' + new Date().getTime();
    }
}

function refreshCaptcha() {
    get_captcha();

    var input = document.getElementById('captcha-input');

    if (input) {
        input.value = '';
        input.focus();
    }
}

$(document).ready(function () {
    get_captcha();

    $('#refreshCaptcha').off('click').on('click', function (e) {
        e.preventDefault();
        refreshCaptcha();
    });
});
</script>

    </div>
</div>

<footer>
    <div class="copyright">
        Copyright © ICDS |
        Developed by
        <a href="https://techsseract.com" target="_blank">
            CMP Techsseract LLP
        </a>
        | Powered by UPDESCO
    </div>
</footer>

<script>
    var counter = <?php echo $remainingTime; ?>;

    var interval = setInterval(function() {
        counter--;

        if (counter <= 0) {
            clearInterval(interval);
            $('#resenddiv').show();
            $('#timer').html("<h6>OTP Expire Resend</h6>");
            return;
        } else {
            $('#time').text(counter);
            $('#resenddiv').hide();
            console.log("Timer --> " + counter);
        }
    }, 1000);
</script>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<script>
    function resendOtp(val) {
        $.ajax({
            type: "POST",
            url: "../ajax.php",
            data: 'mob=' + val,
            success: function(data) {
                $("#block").html('');
                $("#block").html(data);
            }
        });
    }
</script>

<script type="text/javascript" src="../public/js/bootstrap.js"></script>
<script type="text/javascript" src="../public/js/select2.min.js"></script>
<script type="text/javascript" src="../public/js/js_latest_toastr.min.js"></script>

<script>
    // validation
    (function() {
        'use strict';

        window.addEventListener('load', function() {

            var forms = document.getElementsByClassName('needs-validation');

            var validation = Array.prototype.filter.call(forms, function(form) {

                form.addEventListener('submit', function(event) {

                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }

                    form.classList.add('was-validated');

                }, false);

            });

        }, false);

    })();

    $(document).ready(function() {

        $(".alpha").keypress(function(e) {
            return /[0-9 . ,a-z A-Z@ ]/i.test(event.key);
        });

        $(".num_digit").keypress(function(e) {
            return /[0-9.]/i.test(event.key);
        });

        $(".str").keypress(function(e) {
            return /[a-z A-Z .]/i.test(event.key);
        });

        $('.js-example-basic-single').select2();

        $(".js-example-placeholder-single").select2({
            placeholder: "- Select -"
        });

    });
</script>

</body>
</html>
