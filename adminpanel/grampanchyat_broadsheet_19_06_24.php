<?php
  include 'master.php';
  ob_start();
  
  if(!checkLogin()){
    header('Location: login.php');

  }
  
  page_header_start('Admin Dashboard | ICDS | AWW Recruitment');
?>
  <style> 
    .fixTableHead { 
      overflow-y: auto; 
      height: 600px; 
    } 
    .fixTableHead thead th { 
      position: sticky; 
      top: 0; 
      background-color: #CCC;
    } 
    table { 
      border-collapse: collapse;         
      width: 100%; 
    } 
    th, 
    td { 
      padding: 8px 15px; 
      border: 2px solid #529432; 
    } 
    th { 
      background: #ABDD93; 
    } 
    .bgcolor-1{
        background-color: #a3f307;
    }
    .bgcolor-2{
        background-color: #f50b86;
    }
    .bgcolor-3{
        background-color:#ff6f00;
    }
    .bgcolor-4{
        background-color: #e2f705;
    }
    .bgcolor-5{
        background-color: #2b0b5c;
    }
    
  </style> 
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

  
<!-- ----------------------------------------------------------------------------------------- -->



        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:../../partials/_settings-panel.html -->
           
           
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
                                
                                <li>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox">
                                            Resolve all the low priority tickets due today
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
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Provisional Broadsheet - <?php echo $data['district']; ?> <?php echo getProjectname($_GET['pid']); ?></h4>
                            <div class="row">
                        <div class="col-12">
                            <div class="card">
                               
                                <div class="fixTableHead"> 
                                <table class="table" id="tbl">
                                            <thead style="background-color: #CCC;">
                                                <tr>
                                    
                                                    <th>Application No.</th>
                                                    <th>Aganwadi Center</th>
                                                    <th>Applicant Name</th>
                                                    <th>Father Name</th>
                                                    <th>Mother Name</th>
                                                    <th>Husband Name</th>
                                                    <th>Mobile No.</th>
                                                    <th>Category</th>
                                                    <?php
                                                   
                                                        $catstatus=subcategoryEnable();
                                                        if($catstatus==1){
                                                            echo ' <th>Sub category</th>';
                                                        }
                                                    ?>
                                                   
                                                    <th>Current Status</th>
                                                    <th>BPL</th>
                                                    <th>Age</th>
                                                    <th>Merit</th>
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                          
                                                    $i=1;

                                                        $j=1;
                                                       
                                                        $nq="SELECT DISTINCT(gram_panchyat_id) from decleration where district_id='".$_SESSION['distid']."' AND project_id='".$_GET['pid']."' ";
                                                       // echo $nq; die;
                                                        $nres=execute_query($nq);
                                                        while($ndata=mysqli_fetch_assoc($nres)){
                                                      //  print_r($row); 
                                                      echo '<tr  style="background-color:#e4ffff;font-weight:600;font-size:18px;">
                                                      <td colspan="13"> Gram Panchyat/Ward -  : '.getGrampanchayatName($ndata['gram_panchyat_id']).'</td>
                                                  </tr>';
                                                        $q="select nad.gram_panchayat,nad.pre_name,nad.name_hi,nad.name_en,nad.rikt_aww_center,nad.fname,nad.mname,nad.hname,nad.mobile,nad.year,nad.month,nad.day,pd.category,pd.sub_category,pd.avedika_status,pd.bpl_card,ad.i_present,ad.g_present,ad.pg_present,ad.merit,d.application_no,d.aganwadi_center FROM new_application_details nad INNER JOIN personal_details pd ON nad.userid=pd.userid INNER JOIN academic_details ad ON ad.userid = pd.userid  INNER JOIN decleration d ON d.userid=ad.userid WHERE d.gram_panchyat_id='".$ndata['gram_panchyat_id']."'AND  d.project_id='".$_GET['pid']."' ORDER BY pd.bpl_card desc,pd.avedika_status DESC,ad.merit desc,nad.year DESC,nad.month DESC,nad.day DESC,pd.sub_category DESC limit 100";
                                                       // echo $q; 
                                                        $r=execute_query($q);
                                                        while($adata=mysqli_fetch_array($r)){
                                                           // print_r($adata); die;
                                                            echo' <tr>
                                                    
                                                            <td>'.$adata['application_no'].'</td>';
                                                            
                                                           if($adata['aganwadi_center'] !=''){
                                                            echo'<td>'.getcenterName($adata['aganwadi_center']).'- '.getcenterName($adata['rikt_aww_center']).'</td>';
                                                           }
                                                           else{
                                                            echo'<td>'.getcenterName($adata['rikt_aww_center']).'-.'.getcenterName($adata['aganwadi_center']).'</td>';
                                                           }

                                                            echo'<td>'.$adata['name_hi'].'<br>'.$adata['name_en'].'</td>
                                                            <td>'.strtoupper($adata['fname']).'</td>
                                                            <td>'.strtoupper($adata['mname']).'</td>
                                                            <td>'.strtoupper($adata['hname']).'</td>
                                                            <td>'.$adata['mobile'].'</td>
                                                            <td>'.getCategoryText($adata['category']).'</td>';
                                                           if($catstatus==1){
                                                            echo  '<td>'.getSubcategoryText($adata['sub_category']).'</td>';
                                                           }

                                                           
                                                            if($adata['avedika_status'] =='1'){
                                                                echo '<td>
                                                                <div class="tooltip-inner bgcolor-1"> 
                                                                '.getCurrentsituation($adata['avedika_status']).'
                                                           
                                                        
                                                                 </div></td>';
                                                            }
                                                            else if($adata['avedika_status'] =='2'){
                                                                echo '<td> <div class="tooltip-inner bgcolor-2">'.getCurrentsituation($adata['avedika_status']).'</div></td>';
                                                            }
                                                            else{
                                                                echo '<td><div class="tooltip-inner color-3">'.getCurrentsituation($adata['avedika_status']).'</div></td>';
                                                            }

                                                            if($adata['bpl_card'] =='1'){
                                                                echo '<td><div class="tooltip-inner bgcolor-4">BPL</div></td>';
                                                            }
                                                            else {
                                                                echo '<td>
                                                                <div class="tooltip-inner bgcolor-5">NON-BPL</div>
                                                                </td>';
                                                            }
                                                            
                                                            echo'
                                                            <td>Year-'.$adata['year'].' Month-'.$adata['month'].' Day-'.$adata['day'].'</td>
                                                            <td>'.$adata['merit'].'</td>
                                                            
                                                        </tr>';
                                                        }
                                                    }
                                                
                                                ?>
                                              
                                            </tbody>
                                            
                                        </table>
                                    
                                    
                                </div>

                            </div>
                        </div>
                    </div>
                        </div>
                    </div>
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