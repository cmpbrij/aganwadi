<?php
  include 'admin_master.php';
  ob_start();
  //echo checkLogin(); die;
 
  if(!checkLogin()){
    header('Location: login.php');

  }
  page_header_start('Admin Dashboard | ICDS | AWW Recruitment');
?>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toaster/4.0.1/css/bootstrap-toaster.min.css" integrity="sha512-RLiJ5uLcu8jWxsJBevOZWLU0zWv51vwpha0Gh4jRKOqkcWbVR7+U8kKaiGsMhSua3fIkviCHRClSH+XZYKIoZA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toaster/4.0.1/css/bootstrap-toaster.css" integrity="sha512-BqX9iUcQY8V8QeSbSjk/vL2CQk8TT5SEp8OeuRO6MMSYfRtVE0DW4eqjmD7Iew2XAoa+iEXIkJQPYXaP0FqWrA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toaster/4.0.1/js/bootstrap-toaster.js" integrity="sha512-4JwsWzz1l6JIsCUPi1bopU+79qHRCUlOJhYapg5dRuXjFFgXPazVnoOgrvrUMckjJl6LPOM4GncDv3ilou8avQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-toaster/4.0.1/js/bootstrap-toaster.min.js" integrity="sha512-YmkrdAXo8RdHV1JFfepR7QWLDfF7vs8Mc/t+6qKIxrEFeWbi0u/lajryYSPK6GC5nupW5t6XfPdxQpIY79+USg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  
<!-- ----------------------------------------------------------------------------------------- -->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.css" />
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ----------> 
  <?php
  page_header_end();

  navigation();
  
  ?>
    
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">

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
            <form class="form w-100">
              <div class="form-group d-flex">
                <input type="text" class="form-control todo-list-input" placeholder="Add To-do">
                <button type="submit" class="add btn btn-primary todo-list-add-btn" id="add-task">Add</button>
              </div>
            </form>
          </div>
          <div class="list-wrapper px-3">
            <ul class="d-flex flex-column-reverse todo-list">
              
             
             
              <!-- <li class="completed">
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="checkbox" type="checkbox" checked>
                    Schedule meeting for next week
                  </label>
                </div>
                <i class="remove mdi mdi-close-circle-outline"></i>
              </li> -->
              <!-- <li class="completed">
                <div class="form-check">
                  <label class="form-check-label">
                    <input class="checkbox" type="checkbox" checked>
                    Project review
                  </label>
                </div>
                <i class="remove mdi mdi-close-circle-outline"></i>
              </li> -->
            </ul>
          </div>
         
          
        </div>
        <!-- To do section tab ends -->
        <div class="tab-pane fade" id="chats-section" role="tabpanel" aria-labelledby="chats-section">
          <div class="d-flex align-items-center justify-content-between border-bottom">
            <p class="settings-heading border-top-0 mb-3 pl-3 pt-0 border-bottom-0 pb-0">Friends</p>
            <small class="settings-heading border-top-0 mb-3 pt-0 border-bottom-0 pb-0 pr-3 font-weight-normal">See All</small>
          </div>
          <ul class="chat-list">
           
            <li class="list">
              <div class="profile"><img src="images/faces/face3.jpg" alt="image"><span class="online"></span></div>
              <div class="info">
                <p>Daniel Russell</p>
                <p>Available</p>
              </div>
              <small class="text-muted my-auto">14 min</small>
            </li>
           
            
          </ul>
        </div>
        <!-- chat tab ends -->
      </div>
      </div>
            <!-- partial -->
          <?php sidebar(); ?>
      <!-- partial -->
      <div class="main-panel">
        <div class="content-wrapper">

          <div class="row">
            <div class="col-md-12 grid-margin">
              <div class="d-flex justify-content-between flex-wrap">
                <div class="d-flex align-items-end flex-wrap">
                  <div class="mr-md-3 me-xl-5">
                    <h2>Welcome <?php echo $_SESSION['role']; ?>,</h2>
                    <p class="mb-md-0">Analytics for AWW Appointment Management System.</p>
                  </div>
                 
                </div>
                <div class="d-flex justify-content-between align-items-end flex-wrap">
                  <button type="button" class="btn btn-light bg-white btn-icon me-3 d-none d-md-block ">
                    <i class="mdi mdi-download text-muted"></i>
                  </button>
                  <button type="button" class="btn btn-light bg-white btn-icon me-3 mt-2 mt-xl-0">
                    <i class="mdi mdi-clock-outline text-muted"></i>
                  </button>
                  <button type="button" class="btn btn-light bg-white btn-icon me-3 mt-2 mt-xl-0">
                    <i class="mdi mdi-plus text-muted"></i>
                  </button>
                  <!-- <button class="btn btn-primary mt-2 mt-xl-0">Download report</button> -->
                </div>
              </div>
            </div>
          </div>
           <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body dashboard-tabs p-0">
                  <ul class="nav nav-tabs px-4 border-left-0 border-top-0 border-right-0" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="overview-tab" data-bs-toggle="tab" href="#overview" role="tab" aria-controls="overview" aria-selected="true">Overview</a>
                    </li>
                    <!-- <li class="nav-item">
                      <a class="nav-link" id="sales-tab" data-bs-toggle="tab" href="#sales" role="tab" aria-controls="sales" aria-selected="false">Applications</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="purchases-tab" data-bs-toggle="tab" href="#purchases" role="tab" aria-controls="purchases" aria-selected="false">Interviews</a>
                    </li> -->
                  </ul>
                  <div class="tab-content py-0 px-0 border-left-0 border-bottom-0 border-right-0">
                    <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                      <div class="d-flex flex-wrap justify-content-xl-between">
                        <div class="d-none d-xl-flex border-md-right flex-grow-1 align-items-center justify-content-left justify-content-md-center px-4 px-md-0 mx-1 mx-md-0 p-3 item">
                          
                          
                        </div>
                        
                        <!-- <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-left justify-content-md-center px-4 px-md-0 mx-1 mx-md-0 p-3 item">
                          <div class="icon-box-secondary me-3">
                            <i class="mdi mdi-eye"></i>
                          </div>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Processed</small>
                            <h5 class="me-2 mb-0">0</h5>
                          </div>
                        </div> -->
                       
                       
                      </div>
                    </div>
                    <div class="tab-pane fade" id="sales" role="tabpanel" aria-labelledby="sales-tab">
                      <div class="d-flex flex-wrap justify-content-xl-between">
                        <div class="d-none d-xl-flex border-md-right flex-grow-1 align-items-center justify-content-left justify-content-md-center px-4 px-md-0 mx-1 mx-md-0 p-3 item">
                          <div class="icon-box-secondary me-3">
                            <i class="mdi mdi-calendar-heart"></i>
                          </div>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Start date</small>
                            <div class="dropdown">
                              <a class="btn btn-secondary dropdown-toggle p-0 bg-transparent border-0 text-dark shadow-none font-weight-medium" href="#" role="button" id="dropdownMenuLinkA" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <h5 class="mb-0 d-inline-block">06 March 2024</h5>
                              </a>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuLinkA">
                                <a class="dropdown-item" href="#">06 March 2024</a>
                                <a class="dropdown-item" href="#">06 March 2024</a>
                                <a class="dropdown-item" href="#">06 March 2024</a>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-left justify-content-md-center px-4 px-md-0 mx-1 mx-md-0 p-3 item">
                          <div class="icon-box-secondary me-3">
                            <i class="mdi mdi-currency-usd"></i>
                          </div>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Received</small>
                            <h5 class="me-2 mb-0">20</h5>
                          </div>
                        </div>
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-left justify-content-md-center px-4 px-md-0 mx-1 mx-md-0 p-3 item">
                          <div class="icon-box-secondary me-3">
                            <i class="mdi mdi-eye"></i>
                          </div>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Processed</small>
                            <h5 class="me-2 mb-0">0</h5>
                          </div>
                        </div>
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-left justify-content-md-center px-4 px-md-0 mx-1 mx-md-0 p-3 item">
                          <div class="icon-box-secondary me-3">
                            <i class="mdi mdi-download"></i>
                          </div>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Pending</small>
                            <h5 class="me-2 mb-0">20</h5>
                          </div>
                        </div>
                        <div class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-left justify-content-md-center px-4 px-md-0 mx-1 mx-md-0 p-3 item">
                          <div class="icon-box-secondary me-3">
                            <i class="mdi mdi-flag"></i>
                          </div>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Flagged</small>
                            <h5 class="me-2 mb-0">0</h5>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="purchases" role="tabpanel" aria-labelledby="purchases-tab">
                      <div class="d-flex flex-wrap justify-content-xl-between">
                        <div class="d-none d-xl-flex border-md-right flex-grow-1 align-items-center justify-content-left justify-content-md-center px-4 px-md-0 mx-1 mx-md-0 p-3 item">
                          <div class="icon-box-secondary me-3">
                            <i class="mdi mdi-calendar-heart"></i>
                          </div>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Start date</small>
                            <div class="dropdown">
                              <a class="btn btn-secondary dropdown-toggle p-0 bg-transparent border-0 text-dark shadow-none font-weight-medium" href="#" role="button" id="dropdownMenuLinkA" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <h5 class="mb-0 d-inline-block">26 Jul 2023</h5>
                              </a>
                              <div class="dropdown-menu" aria-labelledby="dropdownMenuLinkA">
                                <a class="dropdown-item" href="#">12 Aug 2023</a>
                                <a class="dropdown-item" href="#">22 Sep 2023</a>
                                <a class="dropdown-item" href="#">21 Oct 2023</a>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-left justify-content-md-center px-4 px-md-0 mx-1 mx-md-0 p-3 item">
                          <div class="icon-box-secondary me-3">
                            <i class="mdi mdi-currency-usd"></i>
                          </div>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Received</small>
                            <h5 class="me-2 mb-0">7545</h5>
                          </div>
                        </div>
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-left justify-content-md-center px-4 px-md-0 mx-1 mx-md-0 p-3 item">
                          <div class="icon-box-secondary me-3">
                            <i class="mdi mdi-eye"></i>
                          </div>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Processed</small>
                            <h5 class="me-2 mb-0">3550</h5>
                          </div>
                        </div>
                        <div class="d-flex border-md-right flex-grow-1 align-items-center justify-content-left justify-content-md-center px-4 px-md-0 mx-1 mx-md-0 p-3 item">
                          <div class="icon-box-secondary me-3">
                            <i class="mdi mdi-download"></i>
                          </div>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Pending</small>
                            <h5 class="me-2 mb-0">3783</h5>
                          </div>
                        </div>
                        <div class="d-flex py-3 border-md-right flex-grow-1 align-items-center justify-content-left justify-content-md-center px-4 px-md-0 mx-1 mx-md-0 p-3 item">
                          <div class="icon-box-secondary me-3">
                            <i class="mdi mdi-flag"></i>
                          </div>
                          <div class="d-flex flex-column justify-content-around">
                            <small class="mb-1 text-muted">Flagged</small>
                            <h5 class="me-2 mb-0">843</h5>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div> 
          <div class="row">
          <div class="col-md-6 col-xl-3 grid-margin stretch-card">
                    <div class="card">
                        <div id="monthlyIncomeCarousel" class="carousel slide card-carousel" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="card-body border-bottom">
                                        <p class="card-title">Total Vacancies in UP</p>
                                        <div class="row">
                                            <div class="col-6">
                                                <canvas id="monthly-income-chart"></canvas>
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex align-items-center ml-2">
                                                    <!-- <h2 class="font-weight-bold mb-0 me-1">16%</h2>
                              <i class="mdi mdi-chevron-up text-warning icon-md"></i> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <div>
                                                <p>District <span
                                                        class="color:red !important;"><?php ?></span>
                                                </p>
                                                <h2 class="mb-0">

                                                    <?php
                                 $sql1="SELECT count(vacancy_available) as  count FROM `aaganwadi_center` WHERE  vacancy_available = 'Yes'";
                                  //echo $sql; die;
                                  $res1=execute_query($sql1);
                                  if(mysqli_num_rows($res1) > 0){
                                      $rowdata=mysqli_fetch_array($res1);
                                      echo $rowdata['count'];
                                  }

                                  ?>
                                                </h2>
                                                <div class="d-flex align-items-center mt-2">
                                                    <!-- <small>0.754%</small> -->
                                                    <i class="mdi mdi-chevron-up"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <div class="icon-box-warning icon-box-lg">
                                                    <i class="mdi mdi-map"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <h5>Available Vacancies</h5>
                                        <p class="text-muted mb-0"></p>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <!-- <div class="col-md-6 col-xl-3 grid-margin stretch-card">
                    <div class="card">
                       
                    </div>
                </div> -->
            <div class="col-md-6 col-xl-3 grid-margin stretch-card">
              <div class="card">
                <div id="yearlySalesCarousel" class="carousel slide card-carousel" data-ride="carousel">
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                      <div class="card-body border-bottom">
                        <p class="card-title">Active District</p>
                        <div class="row">
                          
                          
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                          <div>
                            <p>Vacncy published</p>
                            <?php
                               $sql = "SELECT * FROM `vacancy_order`";
                               $res=execute_query($sql);
                               $total=mysqli_num_rows($res);
                            ?>
                            <h2 class="mb-0"><?php echo $total; ?></h2>
                            <div class="d-flex align-items-center mt-2">
                              <!-- <small>0.0%</small> -->
                              <i class="mdi mdi-chevron-down"></i>
                            </div>
                          </div>
                          <div>
                            <div class="icon-box-info icon-box-lg">
                              <i class="mdi mdi-cart"></i>
                            </div>
                          </div>
                        </div>
                        <h5>Total active district</h5>
                        <!-- <p class="text-muted mb-0">Total Applications Received in a Month</p> -->
                      </div>
                    </div>
                    <div class="carousel-item">
                      <div class="card-body border-bottom">
                        <p class="card-title">Yearly Report</p>
                        <div class="row">
                          <div class="col-6">
                            <canvas id="yearly-sales-chart-b"></canvas>
                          </div>
                          <div class="col-6">
                            <div class="d-flex align-items-center ml-2">
                              <h2 class="font-weight-bold mb-0 me-1">20%</h2>
                              <i class="mdi mdi-chevron-down text-danger icon-md"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                          <div>
                            <p>Processed</p>
                            <h2 class="mb-0">0</h2>
                            <div class="d-flex align-items-center mt-2">
                              <small>0.0%</small>
                              <i class="mdi mdi-chevron-down"></i>
                            </div>
                          </div>
                          <div>
                            <div class="icon-box-info icon-box-lg">
                              <i class="mdi mdi-cart"></i>
                            </div>
                          </div>
                        </div>
                        <h5>Monthly Applications</h5>
                        <p class="text-muted mb-0">Total Applications Received in a Month</p>
                      </div>
                    </div>
                  </div>
                 
                </div>    
              </div>
            </div>
            <!-- <div class="col-md-6 col-xl-3 grid-margin stretch-card">
              <div class="card">
                <div id="dailyDepositsCarousel" class="carousel slide card-carousel" data-ride="carousel">
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                      <div class="card-body border-bottom">
                        <p class="card-title">Daily Report</p>
                        <div class="row">
                          <div class="col-6">
                            <canvas id="daily-deposits-chart"></canvas>
                          </div>
                          <div class="col-6">
                            <div class="d-flex align-items-center ml-2">
                              <h2 class="font-weight-bold mb-0 me-1">19%</h2>
                              <i class="mdi mdi-chevron-up text-success icon-md"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                          <div>
                            <p>Applications</p>
                            <h2 class="mb-0">20</h2>
                            <div class="d-flex align-items-center mt-2">
                              <small>0.0%</small>
                              <i class="mdi mdi-chevron-up"></i>
                            </div>
                          </div>
                          <div>
                            <div class="icon-box-success icon-box-lg">
                              <i class="mdi mdi-calendar-heart"></i>
                            </div>
                          </div>
                        </div>
                        <h5>Monthly Applications</h5>
                        <p class="text-muted mb-0">Total Applications Received in a Month</p>
                      </div>
                    </div>
                    <div class="carousel-item">
                      <div class="card-body border-bottom">
                        <p class="card-title">Daily Report</p>
                        <div class="row">
                          <div class="col-6">
                            <canvas id="daily-deposits-chart-b"></canvas>
                          </div>
                          <div class="col-6">
                            <div class="d-flex align-items-center ml-2">
                              <h2 class="font-weight-bold mb-0 me-1">0%</h2>
                              <i class="mdi mdi-chevron-up text-success icon-md"></i>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                          <div>
                            <p>Processed</p>
                            <h2 class="mb-0">0</h2>
                            <div class="d-flex align-items-center mt-2">
                              <small>0.0%</small>
                              <i class="mdi mdi-chevron-up"></i>
                            </div>
                          </div>
                          <div>
                            <div class="icon-box-success icon-box-lg">
                              <i class="mdi mdi-calendar-heart"></i>
                            </div>
                          </div>
                        </div>
                        <h5>Monthly Applications</h5>
                        <p class="text-muted mb-0">Total Applications Received in a Month</p>
                      </div>
                    </div>
                  </div>
                  <a class="carousel-control-prev bg-white" href="#dailyDepositsCarousel" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  </a>
                  <a class="carousel-control-next bg-white" href="#dailyDepositsCarousel" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  </a>
                </div>    
              </div>
            </div> -->
          </div>
         
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Release Details of all district</p>
                  <div class="table-responsive">
                    <table class="table " id="table_id">
                      <thead>
                        <tr>
                        <th width="20%">Serial</th>
                        <th>District Name</th>
                        <th>Uploaded Date</th>
                        <th>Last Date</th>
                        <th>Extend Days</th>
                        <th>Uploaded File</th>
                        </tr>
                      </thead>
                      <tbody>
                    <?php                  
                         $sql = "SELECT * FROM `vacancy_order` order by id";
                          $res=execute_query($sql);
                          $i=1;
                          while ($data = mysqli_fetch_assoc($res)) { 
                          //  print_r($data); 
                            ?>                      
                          <tr>
                              <td><?php echo $i++; ?></td>
                              <td> <?php echo getDistname($data['dist_id']); ?></td>
                              <td> <?php echo date('d-m-Y',strtotime($data['uploaded_date'])); ?>
                               </td> 
                               <td> <?php echo date('d-m-Y',strtotime($data['last_date'])); ?>
                               </td> 
                              
                              
                              
                              <td> <?php if (isset($data['extend_day'])) { ?>
                                      <?php echo $data['extend_day']; ?>
                                  <?php } else { ?>
                                    <?php  echo "No"; ?>
                                <?php   } ?></td> 
                                <td><a href="<?php echo $data['pdf_name']; ?>" target="_blank"
                                                    class="btn btn-primary">View Pdf</a></td>

                          </tr>
                       <?php } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- <div class="row">
            <div class="col-md-4 grid-margin grid-margin-md-0 stretch-card">
              <div class="card border-0 bg-primary text-white">
                <div id="downloads-carousel" class="carousel slide card-carousel" data-ride="carousel">
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                      <div class="card-body pb-0">
                        <p class="card-title text-white">Trend</p>
                        <h1>8543</h1>
                        <h4>Growth 58%</h4>
                      </div>
                      <canvas height="110" id="downloads-chart-a"></canvas>
                    </div>
                    <div class="carousel-item">
                      <div class="card-body pb-0">
                        <p class="card-title text-white">Uploads</p>
                        <h1>4533</h1>
                        <h4>Growth 32%</h4>
                      </div>
                      <canvas height="110" id="downloads-chart-b"></canvas>
                    </div>
                  </div>
                  <a class="carousel-control-prev control-light" href="#downloads-carousel" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  </a>
                  <a class="carousel-control-next control-light" href="#downloads-carousel" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  </a>
                </div>  
              </div>
            </div>
            <div class="col-md-4 grid-margin grid-margin-md-0 stretch-card">
              <div class="card border-0 bg-warning text-white">
                <div id="feedbacks-carousel" class="carousel slide card-carousel" data-ride="carousel">
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                      <div class="card-body pb-0">
                        <p class="card-title text-white">Flags</p>
                        <h1>3568</h1>
                        <h4>Growth 12%</h4>
                      </div>
                      <canvas height="110" id="feedbacks-chart-a"></canvas>
                    </div>
                    <div class="carousel-item">
                      <div class="card-body pb-0">
                        <p class="card-title text-white">Flags</p>
                        <h1>8290</h1>
                        <h4>Growth 11%</h4>
                      </div>
                      <canvas height="110" id="feedbacks-chart-b"></canvas>
                    </div>
                  </div>
                  <a class="carousel-control-prev control-light" href="#feedbacks-carousel" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  </a>
                  <a class="carousel-control-next control-light" href="#feedbacks-carousel" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  </a>
                </div>  
              </div>
            </div>
            <div class="col-md-4 grid-margin grid-margin-md-0 stretch-card">
              <div class="card border-0 bg-success text-white">
                <div id="customers-carousel" class="carousel slide card-carousel" data-ride="carousel">
                  <div class="carousel-inner">
                    <div class="carousel-item active">
                      <div class="card-body pb-0">
                        <p class="card-title text-white">AWW Workers</p>
                        <h1>4567</h1>
                        <h4>Growth 31%</h4>
                      </div>
                      <canvas height="110" id="customers-chart-a"></canvas>
                    </div>
                    <div class="carousel-item">
                      <div class="card-body pb-0">
                        <p class="card-title text-white">Users</p>
                        <h1>1782</h1>
                        <h4>Growth 62%</h4>
                      </div>
                      <canvas height="110" id="customers-chart-b"></canvas>
                    </div>
                  </div>
                  <a class="carousel-control-prev control-light" href="#customers-carousel" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  </a>
                  <a class="carousel-control-next control-light" href="#customers-carousel" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  </a>
                </div>  
              </div>
            </div>
          </div> -->
          
        </div>
       <?php page_footer(); ?>
       
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.js"></script>

    <!-- Datatable Dependency end -->
                <script>
                    $(document).ready(function() {
            $('#table_id').DataTable({

                dom: 'Bfrtip',
                responsive: false,
                pageLength: 25,
                // lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],

                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]

            });
        });
                </script>