<?php
  include 'admin_master.php';
  ob_start();
  //echo checkLogin(); die;
 
  if(!checkLogin()){
    header('Location: login.php');

  }
  page_header_start('Admin Dashboard | ICDS | AWW Recruitment');
?>
  
<!-- ----------------------------------------------------------------------------------------- -->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.css" />
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


<!-- ----------------------------------------------------------------------------------------- -->
<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.css" />
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<style>
.dataTables_wrapper .dataTable tbody tr td {
    border: 2px solid rgba(151, 151, 151, 0.18);
    color: #000000;
   
    font-size: 17px;
}
</style>

<style>
    .text-red{color:red;}

    .bg-info1{ background: linear-gradient(90deg, rgba(131, 58, 180, 1) 0%, rgba(253, 29, 29, 1) 0%, rgba(22, 175, 217, 1) 100%); }
    .bg-info2{ background: linear-gradient(90deg, rgba(131, 58, 180, 1) 0%, rgba(253, 29, 29, 1) 0%, rgba(252, 176, 69, 1) 100%); }
</style>

    
<!------ Include the above in your HEAD tag ----------> 
  <?php
  page_header_end();

  navigation();
  
  ?>
    
    <!-- partial -->
    <div class="container-fluid page-body-wrapper" style="padding-left: 0px;padding-right:0px;">

      <div id="right-sidebar" class="settings-panel">
      <i class="settings-close mdi mdi-close"></i>
      <ul class="nav nav-tabs" id="setting-panel" role="tablist">
       
        <!-- <li class="nav-item">
          <a class="nav-link" id="chats-tab" data-bs-toggle="tab" href="#chats-section" role="tab" aria-controls="chats-section">CHATS</a>
        </li> -->
      </ul>
      <div class="tab-content" id="setting-content">
        <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel" aria-labelledby="todo-section">
         
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
          
          <ul class="chat-list">
           
           
           
            
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
                    <h2>Admin Dashboard</h2>
                    <p class="mb-md-0">ANGANWADI RECRUITMENT 2024</p>
                  </div>
                 
                </div>
                <div class="d-flex justify-content-between align-items-end flex-wrap">
                <div class="col-12"> 
                      
                        <div id="myDiv"></div>
                         
                </div>
                  <!-- <button class="btn btn-primary mt-2 mt-xl-0">Download report</button> -->
                </div>
              </div>
            </div>
          </div>
        
          <div class="row">
            
  

         <div class="card mb-3" >
                <div class="card-body">
                 
          <div class="row ml-2">
               <div class="col-md-4">
                    <div class="card text-white bg-info2 shadow-lg">
                        <div class="card-body">
                        <h5 class="card-title" style="color:black;">Helper(AWH) Dashboard</h5><hr>
                        <p class="card-text">Manage helper vacancies </p>
                        <a href="../helper/adminpanel/admin_dashboard.php" class="btn btn-light btn-sm">Open Helper Dashboard</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-white bg-info1 shadow-lg">
                        <div class="card-body">
                        <h5 class="card-title" style="color:black;">Worker(AWW) Dashboard</h5><hr>
                        <p class="card-text">Manage helper vacancies </p>
                        <a href="../worker/adminpanel/admin_dashboard.php" class="btn btn-light btn-sm">Open Worker Dashboard</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

<div class="col-md-12 grid-margin stretch-card">

              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Statistics</h4>
                  <div class="row">
                    <div class="col-9">
                    <canvas id="piChart" width="" height="160px;"></canvas>
                    </div>
                    <div class="col-3 mt-5 pt-5">
                    <div id="pidata"></div>
                    </div>
                  </div>
                 
                 
                </div>
              <!-- </div> -->
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
                                                <!-- <canvas id="monthly-income-chart"></canvas> -->
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
                                                <p>All Districts <span
                                                        class="color:red !important;"><?php ?></span>
                                                </p>
                                                <h2 class="mb-0">

                                                    <?php
                                 $sql1="SELECT count(vacancy_available) as  count FROM `new_vacancy` WHERE  vacancy_available = 'Yes'";
                                  //echo $sql; die;
                                  $res1=execute_query($sql1);
                                  if(mysqli_num_rows($res1) > 0){
                                      $rowdata=mysqli_fetch_array($res1);
                                      // echo $rowdata['count'];
                                  }

                                  ?>
                                                </h2>
                                                <div class="d-flex align-items-center mt-2">
                                                    <!-- <small>0.754%</small> -->
                                                    <!-- <i class="mdi mdi-chevron-up"></i> -->
                                                </div>
                                            </div>
                                            <div>
                                                <div class="icon-box-warning icon-box-lg" style="color:white;">
                                                    <!-- <i class="mdi mdi-map"></i> -->
                                                    <?php echo $rowdata['count']; ?>
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
                            <h2 class="mb-0"></h2>
                            <div class="d-flex align-items-center mt-2">
                              <!-- <small>0.0%</small> -->
                              <!-- <i class="mdi mdi-chevron-down"></i> -->
                            </div>
                          </div>
                          <div>
                            <div class="icon-box-info icon-box-lg" style="color:white;">
                              <!-- <i class="mdi mdi-cart"></i> -->
                              <?php echo $total; ?>
                            </div>
                          </div>
                        </div>
                        <h5>Total Advertisement</h5>
                        <!-- <p class="text-muted mb-0">Total Applications Received in a Month</p> -->
                      </div>
                    </div>
              </div>
            </div>
            <div class="col-md-6 col-xl-3 grid-margin stretch-card">
              <div class="card">
                
                    <div class="carousel-item active">
                      <div class="card-body border-bottom">
                        <p class="card-title">Inactive District</p>
                        <div class="row">
                          
                          
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                          <div>
                            <p>District</p>
                            <?php
                               $sql = "SELECT * FROM `vacancy_order`";
                               $res=execute_query($sql);
                               $total=mysqli_num_rows($res);
                            ?>
                            <h2 class="mb-0"></h2>
                            <div class="d-flex align-items-center mt-2">
                              <!-- <small>0.0%</small> -->
                              <!-- <i class="mdi mdi-chevron-down"></i> -->
                            </div>
                          </div>
                          <div>
                            <div class="icon-box-info icon-box-lg" style="color:white;">
                              <!-- <i class="mdi mdi-cart"></i> -->
                              <?php echo 75-$total; ?>
                            </div>
                          </div>
                        </div>
                        <h5>Not Published</h5>
                        <!-- <p class="text-muted mb-0">Total Applications Received in a Month</p> -->
                      </div>
                    </div>
              </div>
            </div>
            <div class="col-md-6 col-xl-3 grid-margin stretch-card">
                 <div class="card">
                
                    <div class="carousel-item active">
                      <div class="card-body border-bottom">
                        <p class="card-title">Received Application</p>
                        <div class="row">
                          
                          
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                          <div>
                            <p>Application</p>
                            <?php
                              $sql="SELECT  COUNT(id) AS total
                              FROM decleration";
                            
                              $res=execute_query($sql);
                              $data=mysqli_fetch_assoc($res);

                            ?>
                            <h2 class="mb-0"></h2>
                            <div class="d-flex align-items-center mt-2">
                              <!-- <small>0.0%</small> -->
                              <!-- <i class="mdi mdi-chevron-down"></i> -->
                            </div>
                          </div>
                          <div>
                            <div class="icon-box-info icon-box-lg" style="color:white;">
                              <!-- <i class="mdi mdi-cart"></i> -->
                              <?php echo $data['total']; ?>
                            </div>
                          </div>
                        </div>
                        <h5>Total Received Application</h5>
                        <!-- <p class="text-muted mb-0">Total Applications Received in a Month</p> -->
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
          <!-- <div class="col-lg-12 grid-margin stretch-card"> -->
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Bar chart Applications Received per Day</h4>
                  <div class="google-chart-container d-flex align-items-center justify-content-center">
                    <!-- <div id="Bar-chart" class="google-charts"></div> -->
                    <div id="chart_div" style="width:95%"></div>
                  </div>
                </div>
              <!-- </div> -->
            </div>
            </div>
          </div>

           <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
          <!-- <div class="col-lg-12 grid-margin stretch-card"> -->
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Bar chart No. of Registrations per day</h4>
                  <div class="google-chart-container d-flex align-items-center justify-content-center">
                    <!-- <div id="Bar-chart" class="google-charts"></div> -->
                    <div id="reg_data" style="width:90%"></div>
                  </div>
                </div>
              <!-- </div> -->
            </div>
            </div>
          </div>
         
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <p class="card-title">Release Details of all district</p>
                  <div class="table-responsive">
                    <table class="table " id="table_id" >
                      <thead>
                        <tr>
                        <th width="20%">Serial</th>
                        <th>District Name</th>
                        <th>Uploaded Date</th>
                        <th>Last Date</th>
                        <th>Extend Days</th>
                        <th>No. of Times</th>
                        <th>Uploaded File</th>
                        </tr>
                      </thead>
                      <tbody>
                    <?php                  
                         $sql = "SELECT * FROM `vacancy_order` order by created DESC";
                          $res=execute_query($sql);
                          $i=1;
                          while ($data = mysqli_fetch_assoc($res)) { 
                          //  print_r($data); 
                          if($data['last_date'] <= date('Y-m-d')){
                            $co='style="background-color:#ff8080; font-size:18px;"';
                        }
                        else{
                            $co='';
                        }
                            ?>                      
                          <tr <?php echo $co; ?>>
                              <td width="6%"><?php echo $i++; ?></td>
                              <td> <?php echo getDistname($data['dist_id']); ?></td>
                              <td> <?php echo date('d-m-Y',strtotime($data['uploaded_date'])); ?>
                               </td> 
                               <td> <?php echo date('d-m-Y',strtotime($data['last_date'])); ?>
                               </td> 
                              
                              
                              
                               <td> <?php if (!empty($data['extend_day'])) { ?>
                                      <?php echo $data['extend_day'] * $data['extend_days']; ?> Days
                                  <?php } else { ?>
                                    <?php  echo "NA"; ?>
                                <?php   } ?></td> 
                                <td><?php echo $data['extend_days']; ?> </td>
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
    <script>
        // Function to fetch data from PHP script using AJAX
        function fetchData1() {
            fetch('pichartdata.php')
            .then(response => response.json())
            .then(data => {
                renderChart(data);
                renderChartData(data);
            });
        }

        // Function to render the chart
        function renderChart(data) {
            const ctx = document.getElementById('piChart').getContext('2d');
            const myChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ['Total Vacancies','Users Registered',  'Total Advertisements', 'Applications Submitted', 'Applications Started'],
                    datasets: [{
                        label: 'Statistics',
                        data: [data.totalvacancy, data.user_reg,  data.totaladv, data.application, data.appstarted],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(153, 102, 255, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)'
                        ],
                        borderWidth: 2
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        function renderChartData(data) {
            const chartDataDiv = document.getElementById('pidata');
            chartDataDiv.innerHTML = `
                <h2>Chart Data</h2>
                <ul>
                    <li style="color:#3366CC;font-size:18px;">Total Vacancies: ${data.totalvacancy}</li>
                    <li style="color:#3366CC;font-size:18px;">Users Registered: ${data.user_reg}</li>
                    <li style="color:#3366CC;font-size:18px;">Total Advertisements: ${data.totaladv}</li>
                    <li style="color:#3366CC;font-size:18px;">Applications Submitted: ${data.application}</li>
                    <li style="color:#3366CC;font-size:18px;">Applications Started: ${data.appstarted}</li>
                </ul>`;
        }



        // Call the fetchData function to fetch data and render the chart
        fetchData1();
    </script>

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

              
<script>
        google.charts.load('current', {packages: ['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var jsonData = null;

            // Fetch data from PHP script using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "data.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                  console.log(xhr.responseText);
                  jsonData = JSON.parse(xhr.responseText);
                  drawBarChart(jsonData);
                }
            };
            xhr.send();

            function drawBarChart(jsonData) {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Date');
                data.addColumn('number', 'APPLICATIONS RECEIVED');

                // Add data to the DataTable
                jsonData.forEach(function(row) {
                    data.addRow([row.filled_date, parseInt(row.count)]);
                });

                var options = {
                    title: 'APPLICATION RECEIVED PER DAY',
                    legend: { position: 'none' },
                    height: 400
                };

                var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
                chart.draw(data, options);
            }
        }
    </script>

                 
<script>
        google.charts.load('current', {packages: ['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var jsonData = null;

            // Fetch data from PHP script using AJAX
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "ajaxregperDay.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                  console.log(xhr.responseText);
                  jsonData = JSON.parse(xhr.responseText);
                  drawBarChart(jsonData);
                }
            };
            xhr.send();

            function drawBarChart(jsonData) {
                var data = new google.visualization.DataTable();
                data.addColumn('string', 'Date');
                data.addColumn('number', 'Registrations Done');

                // Add data to the DataTable
                jsonData.forEach(function(row) {
                    data.addRow([row.regdate, parseInt(row.count)]);
                });

                var options = {
                    title: 'NUMBER OF REGISTRATIONS PER DAY',
                    legend: { position: 'none' },
                    height: 400
                };

                var chart = new google.visualization.BarChart(document.getElementById('reg_data'));
                chart.draw(data, options);
            }
        }
    </script>
    <script>
function showDateTime() {
  var myDiv = document.getElementById("myDiv");

  var date = new Date();
  var dayList = ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
  var monthNames = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December"
  ];
  var dayName = dayList[date.getDay()];
  var monthName = monthNames[date.getMonth()];
  var today = `${dayName}, ${monthName} ${date.getDate()}, ${date.getFullYear()}`;

  var hour = date.getHours();
  var min = date.getMinutes();
  var sec = date.getSeconds();

  var time = hour + ":" + min + ":" + sec;
  myDiv.innerText = `${today} - ${time}`;
}
setInterval(showDateTime, 1000);

</script>
