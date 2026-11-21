<?php
include 'master.php';
  ob_start();
  //echo "test"; die;
  if(!checkLogin()){
    header('Location: login.php');
    

  }
  $tz = 'Asia/Kolkata';   
  date_default_timezone_set($tz);
  page_header_start('Admin Dashboard | ICDS | AWW Recruitment');
?>
<?php
  page_header_end();

  
  ?>
    <style>
    /* Top Bar */
    .top-bar {
      background: linear-gradient(90deg, #00b4db, #0083b0, #ff7e5f);
      color: white;
      padding: 20px 0;
      text-align: center;
      font-size: 1.8rem;
      font-weight: 600;
      letter-spacing: 1px;
      border-radius: 0 0 20px 20px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 1000;
    }

    /* Card */
    .card {
      border: none;
      border-radius: 20px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.25);
    }

    .card-body {
      border-radius: 20px;
    }

    .bg-helper {
      background: linear-gradient(135deg, #89f7fe, #66a6ff);
    }

    .bg-worker {
      background: linear-gradient(135deg, #f6d365, #fda085);
    }

    /* Button hover */
    .btn-custom {
      border: 2px solid #333;
      color: #333;
      background-color: #fff;
      transition: all 0.3s ease;
    }

    .btn-custom:hover {
      background-color: #333;
      color: #fff;
    }

    /* Footer */
    footer {
      position: fixed;
      bottom: 0;
      width: 100%;
      background: linear-gradient(90deg, #0083b0, #00b4db, #ff7e5f);
      color: white;
      text-align: center;
      padding: 10px 0;
      font-size: 0.95rem;
      letter-spacing: 0.5px;
    }

    body {
      background-color: #f9fafc;
      padding-top: 100px; /* to prevent overlap with fixed top bar */
      padding-bottom: 60px; /* to prevent overlap with footer */
    }
  </style>
</head>
<body>

  <!-- Top Bar -->
  <div class="top-bar">
    Welcome, DPO Main Dashboard
    <div class="position-absolute top-0 end-0 mt-3 me-4">
  <a href="../logout.php" class="btn btn-light btn-sm fw-semibold px-3" style="border-radius: 20px;">
    Logout
  </a>
</div>
  </div>

  <!-- Main Content -->
  <div class="container mt-5 pt-4">
    <div class="row justify-content-center g-4">
      
      <!-- Helper Dashboard Card -->
      <div class="col-md-4">
        <div class="card text-dark bg-helper shadow-lg">
          <div class="card-body text-center">
            <h4 class="card-title fw-bold">Helper(AWH) Dashboard</h4>
            <hr>
            <p class="card-text">Manage all helper-related vacancies and records.</p>
            <a href="../helper/adminpanel/dashboard.php" class="btn btn-custom btn-sm mt-2">Open Helper Dashboard</a>
          </div>
        </div>
      </div>

      <!-- Worker Dashboard Card -->
      <div class="col-md-4">
        <div class="card text-dark bg-worker shadow-lg">
          <div class="card-body text-center">
            <h4 class="card-title fw-bold">Worker(AWW) Dashboard</h4>
            <hr>
            <p class="card-text">Access worker details, reports, and related data.</p>
            <a href="/adminpanel/dashboard.php" class="btn btn-custom btn-sm mt-2">Open Worker Dashboard</a>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Footer -->
  <footer>
    © ICDS | Developed by <strong>CMP Techsseract LLP</strong> | Powered by <strong>UPDESCO</strong>
  </footer>