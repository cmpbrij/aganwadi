<?php
  include 'master.php';
  ob_start();
  
  if(!checkLogin()){
    header('Location: login.php');

  }

  page_header_start('Admin Dashboard | ICDS | AWW Recruitment');
?>
  
  <?php

  page_header_end();

  navigation();
  if(isset($_SESSION['adminid'])){
    $q="select * from admin_users where id='".$_SESSION['sid']."'";
    $res= execute_query($q);
    $data=mysqli_fetch_assoc($res);
  }
  
  ?>
<!-- Datatable CSS -->
<!-- <link href='https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
<link href='https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css' rel='stylesheet' type='text/css'> -->


        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:../../partials/_settings-panel.html -->
           
           
            <div id="right-sidebar" class="settings-panel">
                <i class="settings-close mdi mdi-close"></i>
                <ul class="nav nav-tabs" id="setting-panel" role="tablist">
                   
                    <!-- <li class="nav-item">
                        <a class="nav-link" id="chats-tab" data-bs-toggle="tab" href="#chats-section" role="tab" aria-controls="chats-section">CHATS</a>
                    </li> -->
                </ul>
                <div class="tab-content" id="setting-content">
                    <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel" aria-labelledby="todo-section">
                        <div class="add-items d-flex px-3 mb-0">
                            <!-- <form class="form w-100">
                                <div class="form-group d-flex">
                                    <input type="text" class="form-control todo-list-input" placeholder="Add To-do">
                                    <button type="submit" class="add btn btn-primary todo-list-add-btn" id="add-task">Add</button>
                                </div>
                            </form> -->
                        </div>
                        <div class="list-wrapper px-3">
                            <ul class="d-flex flex-column-reverse todo-list">
                                
                               
                                
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

                        <?php
                if(isset($_SESSION['otperror'])){
                ?>
                    <script>
                    swal("Warning!", "OTP is wrong! Please try again...", "warning")
                    </script>
                <?php
                unset($_SESSION['otperror']);
                }
                
                ?>

<?php
                if(isset($_SESSION['success'])){
                ?>
                    <script>
                    swal("Success!", "Broadsheet Opened Successfully!", "success")
                    </script>
                <?php
                unset($_SESSION['success']);
                }
                ?>
           <div class="loader3" style="display: none;">
                <span></span>
                <span></span>

            </div>
            <div class="main-panel">
                <div class="content-wrapper">
                <?php
                $sql="select * from vacancy_order where dist_id='".$_SESSION['distid']."'";
                $res=execute_query($sql);
                $data=mysqli_fetch_array($res);
                // 
              
                if($data['vacancy_open_status'] ==0 && $data['last_date'] < date('Y-m-d')){
                  
                 ?>
                <div class="row grid-margin">
                        <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                            <h4 class="card-title">Send OTP</h4>
                            <button type="button" id="sendotp" name="" class="btn btn-primary" >SEND OTP</button>
                            <p style="color:red;margin-top:10px;">*Click on 'SEND OTP' button to send OTP</p><br><hr>
                            <h4 class="card-title">Verify OTP</h4>
                            <form name="" method="post" action="dataSubmit.php">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" name="otp" class="form-control form-control-sm" placeholder="Enter OTP">
                                        <span class="" id="otptext" style="font-size:14px;color:green;"></span>
                                       <br> 
                                    </div>
                                    <div class="col-md-6">
                                       <button type="submit" name="verifyotp_brodsheet" class="btn btn-success" >Submit</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                        </div>
                    </div>


                <?php }else{ ?>
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Provisional Broadsheet - <?php echo getdistName($_SESSION['distid']); ?></h4>
                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table id="tbl" class="table">
                                            <thead>
                                                <tr>
                                                    <th >Serial</th>
                                                    <th>Project Name</th>
                                                    <!-- <th>Download Selected List</th> -->
                                                  
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $i=1;
                                                    $sql="SELECT * from block_master where district_id='".$_SESSION['distid']."'";
                                                
                                                    $res=execute_query($sql);
                                                    $i=1;
                                                    while($row=mysqli_fetch_array($res)){
                                                      echo'<tr><td>'.$i++.'</td><td><a href="provisinal_broadsheetB1.php?pid='.$row['id'].'">'.strtoupper($row['block_name']).'</a></td>
                                                      
                                                      </tr>';
                                                    }
                                                ?>
                                               <!-- <td><a href="downloadfinal_list.php?pid='.$row['project_id'].'">Download<i class="fa fa-download" aria-hidden="true"></i> </a> </td> -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <?php } ?>                           
                </div>
                <!-- content-wrapper ends -->
                <?php page_footer(); ?>

                <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-colvis-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.js"></script>

    <!-- Datatable Dependency end -->
                <script>
                    $(document).ready(function() {
            $('#tbl').DataTable({

                dom: 'Bfrtip',
                responsive: false,
                pageLength: 25,
                 lengthMenu: [0, 5, 10, 20, 50, 100, 200, 500],

                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]

            });
        });
                </script>

<script>
    $(document).ready(function(){  
      $(document).on('click', '#sendotp', function(){  
        $(".loader3").show();
           $.ajax({  
                url:"ajax.php",  
                method:"POST",  
                data:{sendotpforbroadsheet:'1'},
                success: function(data) {
                    $("#otptext").text('Otp send on registered mobile number');
                    $(".loader3").hide();
                    swal("Success!", "Successfully OTP SEND!", "success")
                },
                error: function() {
                        alert("An error occurred.");
                }  
                
           });  
        
      });  
    });
 </script>