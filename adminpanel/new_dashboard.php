<?php
include 'admin_master.php';
ob_start();

// if (!checkLogin()) {
//     header('Location: login.php');
//     exit;
// }

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

page_header_start('Admin Dashboard | ICDS | AWW Recruitment');
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/line-awesome/1.3.0/line-awesome/css/line-awesome.min.css">

<?php
page_header_end();
navigation();

if (isset($_SESSION['adminid'])) {
    $q = "SELECT district FROM admin_users WHERE id='" . $_SESSION['sid'] . "'";
    $res = execute_query($q);
    $adata = mysqli_fetch_assoc($res);
}
?>

<?php if (isset($_SESSION['success-msg'])) { ?>
    <script>
        swal("Success!", "<?php echo $_SESSION['success-msg']; ?>", "success");
    </script>
<?php unset($_SESSION['success-msg']);
} ?>

<div class="container-fluid " style="padding-left:0; padding-right:0;">
    <?php// sidebar(); ?>

    <div class="">
        <div class="">

            <div class="container" style="margin-top:90px;">
                <div class="dashboard-section fancy-section animate__animated animate__fadeInUp" >
                    <div class="main-heading mb-5  section-heading">
                        <h2 class="fw-bold display-5 text-dark position-relative">
                            Admin Dashboard
                        </h2>
                        <p class="text-muted mt-0">Monitor and manage Worker & Helper dashboards efficiently</p>
                    </div>

                    <div class="row justify-content-center g-4">
                        <div class="col-md-5">
                            <div class="card glass-card border-0 h-100 text-center animate__animated animate__zoomIn">
                                <div class="card-body">
                                    <div class="icon-circle bg-success mb-3">
                                        <i class="las la-user-tie"></i>
                                    </div>
                                    <h4 class="fw-bold text-dark mb-3">AWW Dashboard</h4>
                                    <p class="text-muted fs-6" style="text-shadow: none;">Access and manage Worker-related data, reports, and insights.</p>
                                    <a href="../worker/adminpanel/admin_dashboard.php" class="btn w-100 fw-bold shadow mt-3 dashboard-btn text-white">
                                        Go to Worker Dashboard
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-5">
                            <div class="card glass-card border-0 h-100 text-center animate__animated animate__zoomIn">
                                <div class="card-body">
                                    <div class="icon-circle bg-info mb-3">
                                        <i class="las la-hands-helping"></i>
                                    </div>
                                    <h3 class="fw-bold text-dark mb-3">AWH Dashboard</h3>
                                    <p class="text-muted fs-6" style="text-shadow: none;">Access and manage Helper-related data, reports, and insights.</p>
                                    <a href="../helper/adminpanel/admin_dashboard.php" class="btn w-100 fw-bold shadow mt-3 dashboard-btn text-white">
                                        Go to Helper Dashboard
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="dashboard-section">
                    <h4 class="fw-bold text-secondary mb-4 mt-2 animate__animated animate__fadeInDown">
                        WORKER DASHBOARD STATISTICS
                    </h4>
                    <?php
                               $sql = "SELECT * FROM `vacancy_order`";
                               $res=execute_query($sql);
                               $total=mysqli_num_rows($res);
                            ?>
                    <div class="row g-4 justify-content-center">
                        <div class="col-md-3 col-sm-6">
                            <div class="card stat-card theme-orange animate__animated animate__zoomIn">
                                <div class="card-header">TOTAL VACANCIES IN UP</div>
                                <div class="card-body">
                                    <p>All Districts Available Vacancies</p>
                                    <div class="count-box" id="worker_total"><?php echo $total; ?></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="card stat-card theme-orange animate__animated animate__zoomIn">
                                <div class="card-header">ACTIVE DISTRICT</div>
                                <div class="card-body">
                                    <p>Total Vacancy Published</p>
                                    <div class="count-box" id="worker_active">0</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="card stat-card theme-orange animate__animated animate__zoomIn">
                                <div class="card-header">INACTIVE DISTRICT</div>
                                <div class="card-body">
                                    <p>Not Published Districts</p>
                                    <div class="count-box" id="worker_pending">0</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="card stat-card theme-orange animate__animated animate__zoomIn">
                                <div class="card-header">RECEIVED APPLICATION</div>
                                <div class="card-body">
                                    <p>Total Received Applications</p>
                                    <div class="count-box" id="worker_completed">0</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

                <!-- <div class="dashboard-section">
                    <h4 class="fw-bold text-secondary mb-4 mt-2 animate__animated animate__fadeInDown">
                        HELPER DASHBOARD STATISTICS
                    </h4>
                    <div class="row g-4 justify-content-center">
                     
                        <div class="col-md-3 col-sm-6">
                            <div class="card stat-card theme-orange animate__animated animate__zoomIn">
                                <div class="card-header">TOTAL VACANCIES IN UP</div>
                                <div class="card-body">
                                    <p>All Districts Available Vacancies</p>
                                    <div class="count-box" id="helper_total">0</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="card stat-card theme-orange animate__animated animate__zoomIn">
                                <div class="card-header">ACTIVE DISTRICT</div>
                                <div class="card-body">
                                    <p>Total Vacancy Published</p>
                                    <div class="count-box" id="helper_active">0</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="card stat-card theme-orange animate__animated animate__zoomIn">
                                <div class="card-header">INACTIVE DISTRICT</div>
                                <div class="card-body">
                                    <p>Not Published Districts</p>
                                    <div class="count-box" id="helper_pending">0</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <div class="card stat-card theme-orange animate__animated animate__zoomIn">
                                <div class="card-header">RECEIVED APPLICATION</div>
                                <div class="card-body">
                                    <p>Total Received Applications</p>
                                    <div class="count-box" id="helper_completed">0</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->

            </div>
        </div>
        <?php page_footer(); ?>
    </div>
</div>

<style>

    .main-panel {
        background-color: rgba(255, 165, 0, 0.1);
    }

    .main-heading  h1 {
        font-size: 2.2rem;
        text-transform: uppercase;
    }

    .dashboard-section {
        background: #fff;
        padding: 25px 15px;
        margin-bottom: 50px;
        /* border-radius: 20px; */
        box-shadow: 0 5px 15px rgba(192, 192, 192, 0.1);
        transition: box-shadow 0.3s ease;
    }

    .dashboard-section:hover {
        box-shadow: 0 8px 20px rgba(121, 121, 121, 0.15);
    }

    .dashboard-section h4 {
        border-bottom: 2px solid #e08d8dff;
        padding-bottom: 10px;
    }

    /* Keep existing styling untouched */
    .row.g-4 {
        display: flex;
        flex-wrap: wrap;
        align-items: stretch;
    }

    .dashboard-main,
    .stat-card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }

    .row.g-4 {
        display: flex;
        flex-wrap: wrap;
        align-items: stretch;
    }

    .dashboard-main,
    .stat-card {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: 100%;
    }

    .dashboard-main .card-body,
    .stat-card .card-body {
        flex-grow: 1;
        background: radial-gradient(circle at 10% 20%, #e8bf67ff 0%, #db4736ff 100%);
    }


    .main-title h1 {
        font-size: 2.5rem;
        text-shadow: 1px 1px 2px rgba(85, 85, 85, 0.3);
    }

    .dashboard-main {
        border-radius: 20px;
        background: #fff;
        transition: transform 0.6s cubic-bezier(0.23, 1, 0.32, 1);
    }

    .dashboard-main:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
    }

    /* .dashboard-btn {
        border-radius: 12px;
        padding: 12px;
        font-size: 1rem;
    } */

    .stat-card {
        border-radius: 18px;
        overflow: hidden;
        color: #fff;
        text-align: center;
        transition: all 0.4s ease;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }

    .stat-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .stat-card .card-header {
        font-weight: 700;
        text-transform: uppercase;
        padding: 15px;
        font-size: 1rem;
        color: #fff;
        text-shadow: 1px 1px 2px rgba(85, 85, 85, 0.3);
    }

    .theme-orange .card-body {
        background-color: #fdcea4ff;
    }

    .theme-blue .card-body {
        background-color: #b8c0ff;
    }

    .theme-teal .card-body {
        background-color: #e0e9a0ff;
    }

    .theme-green .card-body {
        background-color: #98f5e1;
    }

    .theme-pink .card-body {
        background-color: #e4b4c2;
    }

    .theme-royal-blue .card-body {
        background-color: #bcd4e6;
    }

    .theme-olive .card-body {
        background-color: #d4e2bc;
    }

    .theme-blue-teal .card-body {
        background-color: #add2c2;
    }

    .stat-card .card-body {
        border-top: none;
        transition: background-color 0.3s ease;
    }

    /* .stat-card:hover .card-body {
    background-color: #ffffff;
} */

    .card-body {
        height: auto;
    }

    .card-body p {
        font-size: 1.2rem;
        margin-bottom: 10px;
        text-shadow: 1px 1px 2px rgba(41, 41, 41, 0.5);
    }

    .stat-card p {
        color: #fff;
        font-weight: 500;
        margin-bottom: 15px;
    }

    .count-box {
        font-size: 1.8rem;
        font-weight: 700;
        background: rgba(37, 37, 37, 0.25);
        display: inline-block;
        padding: 12px 25px;
        border-radius: 12px;
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {

        0%,
        100% {
            transform: scale(1);
            opacity: 1;
        }

        50% {
            transform: scale(1.1);
            opacity: 0.9;
        }
    }


    .theme-orange {
        background: #fda95fff;
    }

    .theme-blue {
        background: #7686ffff;
    }

    .theme-peach {
        background: #e2ad70ff;
    }

    .theme-green {
        background: #5bf0cfff;
    }

    .theme-pink {
        background: #e086a0ff;
    }

    .theme-teal {
        background: #d2e986ff;
    }

    .theme-royal-blue {
        background: #87bbe4ff;
    }

    .theme-olive {
        background: rgba(144, 197, 97, 1)
    }

    .theme-blue-teal {
        background: #74d1a9ff;
    }

    @media (max-width: 768px) {
        .count-box {
            font-size: 1.4rem;
            padding: 10px 20px;
        }

        .stat-card .card-header {
            font-size: 0.9rem;
        }

        .dashboard-btn {
            font-size: 0.9rem;
            padding: 10px;
        }
    }

    .fancy-section {
        /* background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%); */
        /* border-radius: 25px; */
        padding: 60px 40px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
        margin-bottom: 60px;
        position: relative;
        overflow: hidden;
    }

    .fancy-section::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        /* border-radius: 25px; */
        /* background: linear-gradient(90deg, #00bfa5, #4facfe, #00bfa5); */
        z-index: 0;
        background-size: 300% 300%;
        animation: moveGradient 8s ease infinite;
        opacity: 0.3;
    }

    @keyframes moveGradient {
        0% {
            background-position: 0% 50%;
        }

        50% {
            background-position: 100% 50%;
        }

        100% {
            background-position: 0% 50%;
        }
    }

    /* Heading with underline animation */
    .section-heading {
        display: inline-block;
        position: relative;
    }

    .section-heading::after {
        content: '';
        position: absolute;
        width: 180px;
        height: 4px;
        background: rgba(255, 165, 0, 1.0);
        left: 16%;
        bottom: -10px;
        transform: translateX(-50%);
        border-radius: 5px;
        animation: underlineGlow 2s ease-in-out infinite;
    }

    @keyframes underlineGlow {

        0%,
        100% {
            width: 80px;
            opacity: 1;
        }

        50% {
            width: 120px;
            opacity: 0.7;
        }
    }

    .glass-card {
        background: radial-gradient(circle at 10% 20%, #e8bf67ff 0%, #db4736ff 100%);
        backdrop-filter: blur(10px);
        border-radius: 20px;
        transition: all 1s ease;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    }

    .glass-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }

    .icon-circle {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto;
        color: #fff;
        font-size: 2rem;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    .icon-circle.bg-success {
        background: linear-gradient(135deg, #43cea2, #185a9d);
    }

    .icon-circle.bg-info {
        background: linear-gradient(135deg, #2193b0, #6dd5ed);
    }

    .dashboard-btn {
        border-radius: 12px;
        padding: 12px;
        font-size: 1rem;
        background-color: rgba(255, 165, 0, 0.5);
        text-shadow: 1px 1px 2px rgba(85, 85, 85, 0.3);
    }

    .dashboard-btn:hover {
        border-radius: 12px;
        padding: 12px;
        font-size: 1rem;
        background: linear-gradient(135deg, rgba(255, 165, 0, 0.5), rgba(255, 165, 0, 0.7));
    }

    @media (max-width: 768px) {
        .fancy-section {
            padding: 40px 20px;
        }

        .icon-circle {
            width: 60px;
            height: 60px;
            font-size: 1.6rem;
        }
    }
</style>