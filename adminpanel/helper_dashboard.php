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
                    <p class="mb-md-0">ANGANWADI RECRUITMENT 2025</p>
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
            
          <!-- <div class="col-lg-12 grid-margin stretch-card"> -->

         <div class="card mb-3" >
                <div class="card-body">
                 
          <div class="row ml-2">
               <div class="col-md-4">
                    <div class="card text-white bg-info2 shadow-lg">
                        <div class="card-body">
                        <h5 class="card-title" style="color:black;">AWH-Total Vacancy Feeded </h5><hr>
                        
                        <a href="helper_viewvacancyfeed.php" class="btn btn-light btn-sm">View feeding  vacancy</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card text-white bg-info1 shadow-lg">
                        <div class="card-body">
                        <h5 class="card-title" style="color:black;">AWH-Pending For Feeding</h5><hr>
                       
                        <a href="helper_pendenciesfeeding.php" class="btn btn-light btn-sm">View Pendencies</a>
                        </div>
                    </div>
                </div>

                 <div class="col-md-4">
                    <div class="card text-white bg-info1 shadow-lg">
                        <div class="card-body">
                        <h5 class="card-title" style="color:black;">AWH-Vacancy Published</h5><hr>
                       
                        <a href="helper_vacancypub.php" class="btn btn-light btn-sm">View Details</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


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
