<?php
  include 'admin_master.php';
  ob_start();
  //echo checkLogin(); die;
 
  if(!checkLogin()){
    header('Location: login.php');

  }
  page_header_start('Admin Dashboard | ICDS | AWW Recruitment');
?>
  

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<style>
.dataTables_wrapper .dataTable tbody tr td {
    border: 2px solid rgba(151, 151, 151, 0.18);
    color: #000000;
   
    font-size: 17px;
}
.white-color{
  color:white !important;
}
</style>
    <style>
    .text-red{color:red;}

    .bg-info1{ background: linear-gradient(90deg, rgba(131, 58, 180, 1) 0%, rgba(253, 29, 29, 1) 0%, rgba(22, 175, 217, 1) 100%); }
    .bg-info2{ background: linear-gradient(90deg, rgba(131, 58, 180, 1) 0%, rgba(253, 29, 29, 1) 0%, rgba(252, 176, 69, 1) 100%); }
</style>
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
            
          <!-- <div class="col-lg-12 grid-margin stretch-card"> -->
             <div class="col-12 text-right mb-2"> 
                       <a href="/../adminpanel/new_dashboard.php"><button class="btn btn-primary mt-2 mt-xl-0">Back to Main Dashboard</button></a>
                        <div id="myDiv"></div>
                         
                </div>

         <div class="card mb-3" >
                <div class="card-body">
                 <h5> New Vacancy Admin Dashboard 2026</h5>
                </div>
                 
          <div class="row ml-2">
              
            </div>
        </div>
    </div>
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title" Style="color: #F12B11">Statistics</h4>
                  <div class="row">
                    <div class="col-9">
                    <canvas id="piChart" width="" height="200px;"></canvas>
                    </div>
                    <div class="col-3">
                    <div id="pidata"></div>
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
                                    <div class="card-body border-bottom" style="background-color:#F4895F;color:white;">
                                        <p class="card-title white-color" >Total Vacancies</p>
                                        <div class="row">
                                            <div class="col-6">
                                               
                                            </div>
                                            <div class="col-6">
                                                <div class="d-flex align-items-center ml-2">
                                                   
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
                                 $sql1="SELECT count(id) as  count FROM `new_vacancy` ";
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
                                                <div class="icon-box-warning icon-box-lg" style="color:white;background-color:#f4895f !important">
                                                    <!-- <i class="mdi mdi-map"></i> -->
                                                    <?php echo $rowdata['count']; ?>
                                                </div>
                                            </div>
                                        </div>
                                        <a href="helper_viewvacancyfeed.php"><h5>Available Vacancies</h5></a>
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
                      <div class="card-body border-bottom" style="background-color:#F12B11;">
                        <p class="card-title white-color">Active District</p>
                        <div class="row">
                          
                          
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                          <div>
                            <p >Vacncy published</p>
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
                            <div class="icon-box-info icon-box-lg" style="color:white;background-color:#F12B11 !important">
                              <!-- <i class="mdi mdi-cart"></i> -->
                              <?php echo $total; ?>
                            </div>
                          </div>
                        </div>
                        <a href="activedistrictvacancy.php"><h5>Total Advertisement</h5></a>
                        <!-- <p class="text-muted mb-0">Total Applications Received in a Month</p> -->
                      </div>
                    </div>
              </div>
            </div>
            <div class="col-md-6 col-xl-3 grid-margin stretch-card">
              <div class="card">
                
                    <div class="carousel-item active">
                      <div class="card-body border-bottom"  style="background-color:#369ACC;color:white;">
                        <p class="card-title white-color">Inactive District</p>
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
                            <div class="icon-box-info icon-box-lg" style="color:white;background-color:#369acc !important">
                              <!-- <i class="mdi mdi-cart"></i> -->
                              <?php echo 75-$total; ?>
                            </div>
                          </div>
                        </div>
                        <a href="pendingadtv.php"><h5>Not Published</h5></a>
                        <!-- <p class="text-muted mb-0">Total Applications Received in a Month</p> -->
                      </div>
                    </div>
              </div>
            </div>
            <div class="col-md-6 col-xl-3 grid-margin stretch-card">
                 <div class="card">
                
                    <div class="carousel-item active">
                      <div class="card-body border-bottom"  style="background-color:#7859DF;color:white;">
                        <p class="card-title white-color">Received Application</p>
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
                        <a href="admindistrictwiseapplication.php"><h5>Total Received Application</h5></a>
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
                  <!-- <h4 class="card-title" style="color:#F12B11;">Bar chart Applications Received per Day</h4> -->
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
                  <!-- <h4 class="card-title">Bar chart No. of Registrations per day</h4> -->
                  <div class="google-chart-container d-flex align-items-center justify-content-center">
                    <!-- <div id="Bar-chart" class="google-charts"></div> -->
                    <div id="reg_data" style="width:95%"></div>
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
                  <p class="card-title" style="color:#F12B11">Release Details of all district</p>
                  <div class="table-responsive ">
                    <table class="table table-bordered" id="table_id" >
                      <thead>
                        <tr style="color:#ff6361">
                        <th width="7%">Serial</th>
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
                            $co='style="background-color:#de324c; font-size:18px;color:white;"';
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
                                                    class="btn btn-success">View Pdf</a></td>

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
    function fetchData1() {
        fetch('pichartdata.php')
        .then(response => response.json())
        .then(data => {
            renderVibrantChart(data);
            renderChartData(data);
        });
    }

    function renderVibrantChart(data) {
        const ctx = document.getElementById('piChart').getContext('2d');
        
        // Using the specified 6-color palette (repeating last color if needed)
        const colorPalette = [
            '#de324c', // Red
            '#f4895f', // Orange
            '#f8e16f', // Yellow
            '#95cf92', // Green
            '#369acc', // Blue
            '#9656a2'  // Purple
        ];
        
        // Since we have 5 data points, we'll use the first 5 colors
        const backgroundColors = colorPalette.slice(0, 5).map(color => `${color}cc`); // Add alpha
        const borderColors = colorPalette.slice(0, 5);
        const hoverColors = colorPalette.slice(0, 5).map(color => `${color}ff`);

        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Total Vacancies', 'Registered Users', 'Total Advertisements', 'Applications Submitted', 'Applications Started'],
                datasets: [{
                    label: 'Dashboard Stats',
                    data: [data.totalvacancy, data.user_reg, data.totaladv, data.application, data.appstarted],
                    backgroundColor: backgroundColors,
                    borderColor: borderColors,
                    borderWidth: 1,
                    hoverBackgroundColor: hoverColors,
                    hoverBorderWidth: 2,
                    
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                height: 220,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(20, 20, 20, 0.95)',
                        titleColor: '#ffffff',
                        bodyColor: '#e0e0e0',
                        borderColor: 'rgba(255,255,255,0.15)',
                        borderWidth: 1,
                        padding: 12,
                        callbacks: {
                            label: function(context) {
                                return `${context.label}: ${context.raw.toLocaleString()}`;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { 
                            color: 'rgba(255,255,255,0.08)',
                            drawTicks: false
                        },
                        ticks: { 
                            color: '#a0a0a0',
                            precision: 0,
                            padding: 8
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { 
                            color: '#c0c0c0',
                            font: {
                                weight: '500'
                            }
                        }
                    }
                },
                animation: {
                    duration: 1200,
                    easing: 'easeOutQuart'
                }
            }
        });
    }

    function renderChartData(data) {
        const chartDataDiv = document.getElementById('pidata');
        chartDataDiv.innerHTML = `
            <div class="vibrant-data-container">
                <div class="vibrant-data-item" style="--accent-color: #de324c">
                    <div class="vibrant-data-label">Total Vacancies</div>
                    <div class="vibrant-data-value">${data.totalvacancy.toLocaleString()}</div>
                </div>
                <div class="vibrant-data-item" style="--accent-color: #f4895f">
                    <div class="vibrant-data-label">Registered Users</div>
                    <div class="vibrant-data-value">${data.user_reg.toLocaleString()}</div>
                </div>
                <div class="vibrant-data-item" style="--accent-color: #f8e16f">
                    <div class="vibrant-data-label">Total Advertisements</div>
                    <div class="vibrant-data-value">${data.totaladv.toLocaleString()}</div>
                </div>
                <div class="vibrant-data-item" style="--accent-color: #95cf92">
                    <div class="vibrant-data-label">Applications Submitted</div>
                    <div class="vibrant-data-value">${data.application.toLocaleString()}</div>
                </div>
                <div class="vibrant-data-item" style="--accent-color: #369acc">
                    <div class="vibrant-data-label">Applications Started</div>
                    <div class="vibrant-data-value">${data.appstarted.toLocaleString()}</div>
                </div>
            </div>
            <style>
                .vibrant-data-container {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 10px;
                    margin-top: 18px;
                }
                .vibrant-data-item {
                    flex: 1;
                    min-width: 110px;
                    background: #332D56;
                    border-left: 4px solid var(--accent-color);
                    border-radius: 5px;
                    padding: 12px 14px;
                    backdrop-filter: blur(3px);
                    transition: transform 0.2s;
                }
                .vibrant-data-item:hover {
                    transform: translateY(-2px);
                    background: rgba(35, 35, 35, 0.8);
                }
                .vibrant-data-label {
                    color: #bbb;
                    font-size: 0.82rem;
                    margin-bottom: 6px;
                    letter-spacing: 0.5px;
                }
                .vibrant-data-value {
                    color: #fff;
                    font-size: 1.25rem;
                    font-weight: 600;
                    letter-spacing: 0.3px;
                }
                @media (max-width: 600px) {
                    .vibrant-data-item {
                        min-width: calc(50% - 10px);
                    }
                }
            </style>`;
    }

    fetchData1();
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
            data.addColumn('number', 'Applications Received');
            data.addColumn({type: 'string', role: 'style'});  // Add style column for colors

            // Pastel color palette
            var pastelColors = [
                '#FF9AA2', '#FFB7B2', '#FFDAC1', '#E2F0CB', 
                '#B5EAD7', '#C7CEEA', '#F8B195', '#F67280',
                '#C06C84', '#6C5B7B', '#355C7D', '#A8E6CE',
                '#DCEDC2', '#FFD3B5', '#FFAAA6', '#FF8C94'
            ];

            // Add data to the DataTable with alternating colors
            jsonData.forEach(function(row, index) {
                var color = pastelColors[index % pastelColors.length];
                data.addRow([
                    row.filled_date, 
                    parseInt(row.count),
                    'fill-color: ' + color + '; stroke-color: #555; stroke-width: 0.5'
                ]);
            });

            var options = {
                title: 'APPLICATIONS RECEIVED PER DAY',
                titleTextStyle: {
                    fontSize: 14,
                    bold: true,
                    color: '#F12B11'
                },
                
                legend: { position: 'none' },
                height: 500,
                width: '100%',
                chartArea: {
                    width: '85%',
                    height: '75%',
                    backgroundColor: {
                        stroke: '#ddd',
                        strokeWidth: 1
                    }
                },
                backgroundColor: {
                    fill: '#f9f9f9',
                    stroke: '#ddd',
                    strokeWidth: 1
                },
                hAxis: {
                    title: 'Date',
                    titleTextStyle: {
                        color: '#555',
                        italic: false
                    },
                    textStyle: {
                        color: '#555'
                    },
                    gridlines: {
                        color: '#eee'
                    }
                },
                vAxis: {
                    title: 'Number of Applications',
                    titleTextStyle: {
                        color: '#555',
                        italic: false
                    },
                    textStyle: {
                        color: '#555'
                    },
                    gridlines: {
                        color: '#eee'
                    },
                    minValue: 0
                },
                animation: {
                    duration: 1000,
                    easing: 'out',
                    startup: true
                },
                bar: {
                    groupWidth: '80%'
                }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
            chart.draw(data, options);
            
            // Add responsive behavior
            window.addEventListener('resize', function() {
                chart.draw(data, options);
            });
        }
    }
</script>

<script>
    google.charts.load('current', { packages: ['corechart'] });
    google.charts.setOnLoadCallback(drawChart);

    function drawChart() {
        var jsonData = null;

        // Fetch data from PHP script using AJAX
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "ajaxregperDay.php", true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                try {
                    jsonData = JSON.parse(xhr.responseText);
                    console.log("Data loaded successfully:", jsonData);
                    drawBarChart(jsonData);
                } catch (error) {
                    console.error("Error parsing JSON:", error);
                }
            }
        };
        xhr.send();

        function drawBarChart(jsonData) {
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Date');
            data.addColumn('number', 'Registrations Done');
            data.addColumn({ type: 'string', role: 'style' }); // For bar colors

            // Pastel color palette (cycled for each bar)
            var pastelColors = [
                '#FFB6C1', '#FFD700', '#98FB98', '#87CEFA',
                '#FFA07A', '#DDA0DD', '#FFDEAD', '#B0E0E6',
                '#F0E68C', '#9ACD32', '#FFA500', '#20B2AA'
            ];

            // Add data with alternating pastel colors
            jsonData.forEach(function(row, index) {
                var color = pastelColors[index % pastelColors.length];
                data.addRow([
                    row.regdate,
                    parseInt(row.count),
                    `fill-color: ${color}; stroke-color: #555; stroke-width: 0.5`
                ]);
            });

            var options = {
                title: 'NUMBER OF REGISTRATIONS PER DAY',
                titleTextStyle: {
                    fontSize: 14,
                    bold: true,
                    color: '#F12B11'
                },
                legend: { position: 'none' },
                height: 500,
                width: '100%',
                chartArea: {
                    width: '85%',
                    height: '70%',
                    backgroundColor: '#f9f9f9'
                },
                backgroundColor: '#ffffff',
                hAxis: {
                    title: 'Date',
                    titleTextStyle: { color: '#555' },
                    textStyle: { color: '#555' },
                    gridlines: { color: '#eee' }
                },
                vAxis: {
                    title: 'Registrations',
                    titleTextStyle: { color: '#555' },
                    textStyle: { color: '#555' },
                    minValue: 0,
                    gridlines: { color: '#eee' }
                },
                animation: {
                    duration: 1000,
                    easing: 'out',
                    startup: true
                },
                bar: { groupWidth: '75%' }
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('reg_data'));
            chart.draw(data, options);

            // Make chart responsive on window resize
            window.addEventListener('resize', function() {
                chart.draw(data, options);
            });
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


