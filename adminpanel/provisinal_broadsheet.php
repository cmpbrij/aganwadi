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
<!-- Datatable CSS -->
<!-- <link href='https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css' rel='stylesheet' type='text/css'>
<link href='https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css' rel='stylesheet' type='text/css'> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src = "https://ajax.googleapis.com/ajax/libs/jQuery/3.3.1/jQuery.min.js"></script>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper" style="font-size:20px;">
            <!-- partial:../../partials/_settings-panel.html -->
           
            <?php
                if(isset($_SESSION['error'])){
                ?>
                    <script>
                    swal("Warning!", "Somthing is wrong!", "warning")
                    </script>
                <?php
                unset($_SESSION['error']);
                }
                ?>
           
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
                            <!-- <form class="form w-100">
                                <div class="form-group d-flex">
                                    <input type="text" class="form-control todo-list-input" placeholder="Add To-do">
                                    <button type="submit" class="add btn btn-primary todo-list-add-btn" id="add-task">Add</button>
                                </div>
                            </form> -->
                        </div>
                        <div class="list-wrapper px-3">
                            <ul class="d-flex flex-column-reverse todo-list">
                                
                                <li>
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input class="checkbox" type="checkbox">
                                            <!-- Resolve all the low priority tickets due today -->
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
                <h4 class="card-title">Provisional Broadsheet - <?php echo $data['district']; ?></h4>
                <?php
                $sql="select * from vacancy_order where dist_id='".$_SESSION['distid']."'";
                $res=execute_query($sql);
                $data=mysqli_fetch_array($res);
                $cdate=date('Y-m-d');
                if(1 ==0){
                    $_SESSION['otp']=rand('1000','9999');
                ?>
                    <div class="row grid-margin">
                        <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                            <h4 class="card-title">Verify OTP</h4>
                            <form name="" method="post" action="dataSubmit.php">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" name="otp" class="form-control form-control-sm">
                                    </div>
                                    <div class="col-md-6">
                                       <button type="submit" name="verifyotp_brodsheet" class="btn btn-success" >Submit</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                        
                <?php
                }
                else{
                ?>
                    <div class="row grid-margin">
                        <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                            <h4 class="card-title">Filter Data</h4>
                            <form name="" method="post" action="provisinal_broadsheet.php">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group mb-3">
                                            <label > Project Name<span class="text-danger">*</span></label>
                                            <select class="form-control form-select select2-single" name="project" id="project" required>
                                                <option value="">Please Select</option>
                                                <?php
                                                $q="SELECT * FROM `projects` where district_id='".$_SESSION['distid']."' ORDER BY `project_name`";
                                                //echo $sql; die;
                                                $result = execute_query($q);
                                                while ($row = mysqli_fetch_array($result)) {
                                                   
                                                   echo'<option value="'.$row['id'].'">'.$row['project_name'].' </option>';
                                                }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                         <div class="form-group mb-3">
                                            <label >Gram Panchyat/Ward</label>
                                            <select class="form-control form-select" name="gramp" id="gramp"  >
                                                <option value="">Please Select</option>
                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4" >
                                    <div class="form-group mb-3">
                                        <label >Aganwadi Center </label>
                                        <select class="form-control form-select" name="aganwadi" id="aganwadi" >
                                            <option value="">Please Select </option>
                                        

                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-5">
                                    <div class="col-4 offset-4">
                                        <button class="btn btn-success" class="form-control" type="submit" name="search" >Search</button>
                                    </div>
                                </div>
                             </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                    <?php
                    
                        if(isset($_POST['search']) || isset($_GET['page']) || isset($_GET['spage']) || isset($_GET['apage'])){
                            
                            if(isset($_GET['page'])){
                                $gram='';
                                $aganwadi='';
                                $project=$_GET['project'];
                            }
                            else if(isset($_GET['spage'])){
                                $gram=$_GET['gramp'];
                                $aganwadi='';
                                $project=$_GET['project'];
                            }
                            else if( isset($_GET['apage'])){
                                $gram=$_GET['gramp'];
                                $aganwadi=$_GET['aganwadi'];
                                $project=$_GET['project'];
                            }
                            else{
                                $project=$_POST['project'];
                                $gram=$_POST['gramp'];
                                $aganwadi=$_POST['aganwadi'];
                            }
                           
                            if(($gram=='' && $aganwadi=='') || (isset($_GET['page']))){  
                                
                            ?>
                            <div class="row">
                             <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h3>Project- <span style="color:red"><?php echo getProjectname($project); ?></span></h3>
                                    <div class="fixTableHead"> 
                                        <table class="table">
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
                                            <th>Remarks</th>
                                            <th>Selected</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        
                                    <?php
                                        $i=1;
                                        $j=1;
                                        // Pagination parameters
                                            $records_per_page = 1; // Number of records to display per page
                                            $current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number

                                            // Calculate offset
                                            $offset = ($current_page - 1) * $records_per_page;
                                        
                                         $nq="SELECT DISTINCT(gram_panchyat_id) from decleration where project_id='".$project."' and district_id='".$_SESSION['distid']."' LIMIT $offset, $records_per_page";
                                        // echo $nq; 
                                            $nres=execute_query($nq);
                                           
                                            while($ndata=mysqli_fetch_assoc($nres)){
                                            // print_r($row); die;
                                            echo '<tr  style="background-color:#e4ffff;font-weight:600;font-size:18px;">
                                                    <td colspan="14"> Gram Panchyat/Ward -  : '.getGrampanchayatName($ndata['gram_panchyat_id']).'</td>
                                                </tr>';
                                            $q="select nad.gram_panchayat,nad.word_name,nad.pre_name,nad.name_hi,nad.rikt_aww_center,nad.fname,nad.mname,nad.hname,nad.mobile,nad.year,nad.month,nad.day,pd.category,pd.sub_category,pd.avedika_status,pd.bpl_card,ad.i_present,ad.g_present,ad.pg_present,ad.merit,d.application_no FROM new_application_details nad INNER JOIN personal_details pd ON nad.userid=pd.userid INNER JOIN academic_details ad ON ad.userid = pd.userid  INNER JOIN decleration d ON d.userid=ad.userid WHERE d.gram_panchyat_id='".$ndata['gram_panchyat_id']."'AND  d.project_id='".$project."' ORDER BY pd.bpl_card desc,pd.avedika_status,ad.merit desc,nad.year DESC,nad.month DESC,nad.day DESC,pd.sub_category DESC ";
                                            //echo $q; die;
                                            $r=execute_query($q);
                                            while($adata=mysqli_fetch_array($r)){
                                                // print_r($adata); die;
                                                echo' <tr>
                                        
                                                <td>'.$adata['application_no'].'</td>';
                                                
                                                echo'
                                                <td>'.$adata['rikt_aww_center'].'</td>
                                                <td>'.$adata['name_hi'].'</td>
                                                <td>'.$adata['fname'].'</td>
                                                <td>'.$adata['mname'].'</td>
                                                <td>'.$adata['hname'].'</td>
                                                <td>'.$adata['mobile'].'</td>
                                                <td>'.getCategoryText($adata['category']).'</td>';
                                                if($catstatus==1){
                                                    echo  '<td> '.getSubcategoryText($adata['sub_category']).'</td>';
                                                   }
                                                if($adata['avedika_status'] =='1'){
                                                    echo '<td><div class="tooltip-inner bgcolor-1">'.getCurrentsituation($adata['avedika_status']).'</div></td>';
                                                }
                                                else if($adata['avedika_status'] =='2'){
                                                    echo '<td><div class="tooltip-inner bgcolor-2">'.getCurrentsituation($adata['avedika_status']).'</div></td>';
                                                }
                                                else{
                                                    echo '<td><div class="tooltip-inner bgcolor-3">अन्य </td>';
                                                }

                                                if($adata['bpl_card'] =='1'){
                                                    echo '<td><div class="tooltip-inner bgcolor-4">BPL</div></td>';
                                                }
                                                else{
                                                    echo '<td><div class="tooltip-inner bgcolor-1">NON-BPL</div></td>';
                                                }
                                                
                                                echo'
                                                <td>Year-'.$adata['year'].' Month-'.$adata['month'].' Day-'.$adata['day'].'</td>
                                                <td>'.$adata['merit'].'</td>
                                                <td><textarea class="form-control"></textarea></td>
                                                <td> <input class="form-check-input text-center" type="checkbox" id="checkboxNoLabel" value="" aria-label="...">
                                                </td>
                                                
                                            </tr>';
                                            }
                                        
                                    }
                                    ?>
                                      
                                </table>

                                <?php
                              
                                    // Pagination links
                                    // $sql_count = "SELECT COUNT(*) AS total FROM your_table";
                                    // $result_count = $conn->query($sql_count);
                                    $cnq="SELECT DISTINCT(gram_panchyat_id) as total from decleration where project_id='".$project."' and district_id='".$_SESSION['distid']."'";
                                  //echo $cnq; die;
                                    $result_count=execute_query($cnq);
                                           
                                    $row_count = mysqli_fetch_assoc($result_count);
                                    $total_records = $row_count['total'];

                                    $total_pages = ceil($total_records / $records_per_page);
                                    //echo   $total_pages;
                                ?>
                               
                                <div class="">
                                    <ul class="pagination pagination-lg">
                                     <li class="page-item"><a class="page-link" href="#">First</a></li>
                                                <?php
                                            for ($i = 1; $i <= $total_pages; $i++) {
                                                //  echo "<a href='?page=$i'>$i</a> ";
                                            echo'<li class="page-item"><a class="page-link" href="?page='.$i.'&project='.$project.'">'.$i.'</a></li>';
                                            }
                                                
                                            ?>
                                              
                                            </ul>
                                                </div>
                                 
                                                </div>  
                                </div>
                            </div>
                                
                             </div>
                            </div>
                            <?php
                            }

                            else if($aganwadi=='' || isset($_GET['gram'])){
                                 // Pagination parameters
                                 $records_per_page = 1; // Number of records to display per page
                                 $current_page = isset($_GET['spage']) ? $_GET['spage'] : 1; // Current page number

                                 // Calculate offset
                                 $offset = ($current_page - 1) * $records_per_page;
                                ?>
                            <div class="row">
                             <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h3>Project- <span style="color:red"><?php echo getProjectname($project); ?></span></h3>

                                        <h3 >Gram Panchyat/Ward Name- <span style="color:red"><?php echo getGrampanchayatName($gram); ?></span></h3>
                                    <div class="fixTableHead"> 
                                        <table class="table">
                                         <thead style="background-color: #CCC;">
                                         <tr>
                                            <th>Application No.</th>
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
                                            <th>Selected</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        
                                    <?php
                                        $i=1;
                                       
                                            $j=1;
                                            $nq="SELECT DISTINCT(aganwadi_center) from decleration where project_id='".$project."' and district_id='".$_SESSION['distid']."' AND gram_panchyat_id='".$gram."' LIMIT $offset, $records_per_page";
                                            // echo $nq; 
                                            $nres=execute_query($nq);
                                            while($ndata=mysqli_fetch_assoc($nres)){
                                            // print_r($row); die;
                                            echo '<tr  style="background-color:#e4ffff;font-weight:600;font-size:18px;">
                                                    <td colspan="14"> Center Name -  : '.getcenterName($ndata['aganwadi_center']).'</td>
                                                </tr>';
                                            $q="select nad.gram_panchayat,nad.word_name,nad.pre_name,nad.name_hi,nad.rikt_aww_center,nad.fname,nad.mname,nad.hname,nad.mobile,nad.year,nad.month,nad.day,pd.category,pd.sub_category,pd.avedika_status,pd.bpl_card,ad.i_present,ad.g_present,ad.pg_present,ad.merit,d.application_no FROM new_application_details nad INNER JOIN personal_details pd ON nad.userid=pd.userid INNER JOIN academic_details ad ON ad.userid = pd.userid  INNER JOIN decleration d ON d.userid=ad.userid WHERE d.gram_panchyat_id='".$gram."'AND  d.project_id='".$project."' AND aganwadi_center='".$ndata['aganwadi_center']."' ORDER BY pd.bpl_card desc,pd.avedika_status,ad.merit desc,nad.year DESC,nad.month DESC,nad.day DESC,pd.sub_category DESC ";
                                           // echo $q; die;
                                            $r=execute_query($q);
                                            while($adata=mysqli_fetch_array($r)){
                                                // print_r($adata); die;
                                                echo' <tr>
                                        
                                                <td>'.$adata['application_no'].'</td>';
                                                
                                                echo'
                                               
                                                <td>'.$adata['name_hi'].'</td>
                                                <td>'.$adata['fname'].'</td>
                                                <td>'.$adata['mname'].'</td>
                                                <td>'.$adata['hname'].'</td>
                                                <td>'.$adata['mobile'].'</td>
                                                <td>'.getCategoryText($adata['category']).'</td>';
                                                if($catstatus==1){
                                                    echo  '<td>'.getSubcategoryText($adata['sub_category']).'</td>';
                                                   }
                                                if($adata['avedika_status'] =='1'){
                                                    echo '<td><div class="tooltip-inner bgcolor-1">'.getCurrentsituation($adata['avedika_status']).'</div></td>';
                                                }
                                                else if($adata['avedika_status'] =='2'){
                                                    echo '<td><div class="tooltip-inner bgcolor-2">'.getCurrentsituation($adata['avedika_status']).'</div></td>';
                                                }
                                                else{
                                                    echo '<td><div class="tooltip-inner bgcolor-3">'.getCurrentsituation($adata['avedika_status']).'</div></td>';
                                                }

                                                if($adata['bpl_card'] =='1'){
                                                    echo '<td><div class="tooltip-inner bgcolor-4">BPL</div></td>';
                                                }
                                               else{
                                                    echo '<td><div class="tooltip-inner bgcolor-5">NON-BPL</div></td>';
                                                }
                                                
                                                echo'
                                                <td>Year-'.$adata['year'].' Month-'.$adata['month'].' Day-'.$adata['day'].'</td>
                                                <td>'.$adata['merit'].'</td>
                                                <td> <input class="form-check-input text-center" type="checkbox" id="checkboxNoLabel" value="" aria-label="...">
                                                </td>
                                            </tr>';
                                            }
                                        
                                    }
                                    ?>
                                      
                                </table>
                                </div>
                                <?php
                              
                                    // Pagination links
                                    // $sql_count = "SELECT COUNT(*) AS total FROM your_table";
                                    // $result_count = $conn->query($sql_count);
                                    $cnq="SELECT DISTINCT(gram_panchyat_id) as total from decleration where project_id='".$project."' and district_id='".$_SESSION['distid']."'";
                                  //echo $cnq; die;
                                    $result_count=execute_query($cnq);
                                           
                                    $row_count = mysqli_fetch_assoc($result_count);
                                    $total_records = $row_count['total'];

                                    $total_pages = ceil($total_records / $records_per_page);
                                    //echo   $total_pages;
                                ?>
                               
                                <div class="">
                                    <ul class="pagination pagination-lg">
                                     <li class="page-item"><a class="page-link" href="#">First</a></li>
                                                <?php
                                            for ($i = 1; $i <= $total_pages; $i++) {
                                                //  echo "<a href='?page=$i'>$i</a> ";
                                            echo'<li class="page-item"><a class="page-link" href="?spage='.$i.'&project='.$project.'&gram='.$gram.'">'.$i.'</a></li>';
                                            }
                                                
                                            ?>
                                              
                                            </ul>
                                                </div>
                            </div>
                            </div>
                             </div>
                        </div>
                                <?php
                               
                            }
                            else if($project !='' && $gram !='' && $aganwadi!=''){
                                  // Pagination parameters
                                  $records_per_page = 1; // Number of records to display per page
                                  $current_page = isset($_GET['apage']) ? $_GET['apage'] : 1; // Current page number
 
                                  // Calculate offset
                                  $offset = ($current_page - 1) * $records_per_page;
                            ?>
                        <div class="row">
                             <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4>Project- <span style="color:red"><?php echo getProjectname($project); ?></span></h4>

                                        <h4>Gram Panchyat/Ward Name- <span style="color:red"><?php echo getGrampanchayatName($gram); ?></span></h4>

                                        <h4>Center Name- <span style="color:red"><?php echo getcenterName($aganwadi); ?></span></h4>
                                    <div class="fixTableHead"> 
                                        <table class="table">
                                         <thead style="background-color: #CCC;">
                                         <tr>
                                            <th>Application No.</th>
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
                                            <th>Selected</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                        
                                    <?php
                                        $i=1;
                                       
                                           
                                            $q="select nad.gram_panchayat,nad.word_name,nad.pre_name,nad.name_hi,nad.rikt_aww_center,nad.fname,nad.mname,nad.hname,nad.mobile,nad.year,nad.month,nad.day,pd.category,pd.sub_category,pd.avedika_status,pd.bpl_card,ad.i_present,ad.g_present,ad.pg_present,ad.merit,d.application_no FROM new_application_details nad INNER JOIN personal_details pd ON nad.userid=pd.userid INNER JOIN academic_details ad ON ad.userid = pd.userid  INNER JOIN decleration d ON d.userid=ad.userid WHERE d.gram_panchyat_id='".$gram."'AND  d.project_id='".$project."' AND aganwadi_center='".$aganwadi."' ORDER BY pd.bpl_card desc,pd.avedika_status,ad.merit desc,nad.year DESC,nad.month DESC,nad.day DESC,pd.sub_category DESC LIMIT $offset, $records_per_page";
                                           // echo $q; die;
                                            $r=execute_query($q);
                                            while($adata=mysqli_fetch_array($r)){
                                                // print_r($adata); die;
                                                echo' <tr>
                                        
                                                <td>'.$adata['application_no'].'</td>';
                                                
                                                echo'
                                               
                                                <td>'.$adata['name_hi'].'</td>
                                                <td>'.$adata['fname'].'</td>
                                                <td>'.$adata['mname'].'</td>
                                                <td>'.$adata['hname'].'</td>
                                                <td>'.$adata['mobile'].'</td>
                                                <td>'.getCategoryText($adata['category']).'</td>';
                                                if($catstatus==1){
                                                    echo  '<td>'.getSubcategoryText($adata['sub_category']).'</td>';
                                                   }
                                                if($adata['avedika_status'] =='1'){
                                                    echo '<td><div class="tooltip-inner bgcolor-1">'.getCurrentsituation($adata['avedika_status']).'</div></td>';
                                                }
                                                else if($adata['avedika_status'] =='2'){
                                                    echo '<td><div class="tooltip-inner bgcolor-2">'.getCurrentsituation($adata['avedika_status']).'</div></td>';
                                                }
                                                else{
                                                    echo '<td><div class="tooltip-inner bgcolor-3">'.getCurrentsituation($adata['avedika_status']).'</div></td>';
                                                }

                                                if($adata['bpl_card'] =='1'){
                                                    echo '<td><div class="tooltip-inner bgcolor-4">BPL</div></td>';
                                                }
                                                else if($adata['bpl_card'] =='2'){
                                                    echo '<td><div class="tooltip-inner bgcolor-5">NON-BPL</div></td>';
                                                }
                                                
                                                echo'<td>Year-'.$adata['year'].' Month-'.$adata['month'].' Day-'.$adata['day'].'</td>
                                                <td>'.$adata['merit'].'</td>
                                                <td> <input class="form-check-input text-center" type="checkbox" id="checkboxNoLabel" value="" aria-label="...">
                                                </td>
                                            </tr>';
                                            }
                                    ?>
                                      
                                </table>
                                </div>
                                <?php
                              
                                    // Pagination links
                                    // $sql_count = "SELECT COUNT(*) AS total FROM your_table";
                                    // $result_count = $conn->query($sql_count);
                                    $cnq="SELECT DISTINCT(gram_panchyat_id) as total from decleration where project_id='".$project."' and district_id='".$_SESSION['distid']."'";
                                  //echo $cnq; die;
                                    $result_count=execute_query($cnq);
                                           
                                    $row_count = mysqli_fetch_assoc($result_count);
                                    $total_records = $row_count['total'];

                                    $total_pages = ceil($total_records / $records_per_page);
                                    //echo   $total_pages;
                                ?>
                               
                                <div class="">
                                    <ul class="pagination pagination-lg">
                                     <li class="page-item"><a class="page-link" href="#">First</a></li>
                                                <?php
                                            for ($i = 1; $i <= $total_pages; $i++) {
                                                //  echo "<a href='?page=$i'>$i</a> ";
                                            echo'<li class="page-item"><a class="page-link" href="?apage='.$i.'&project='.$project.'&gram='.$gram.'&aganwadi='.$aganwadi.'">'.$i.'</a></li>';
                                            }
                                                
                                            ?>
                                              
                                            </ul>
 
                            </div>
                            </div>
                             </div>
                        </div>

                            <?php
                            }
                            else{

                            }
                        }
                        else{
                    ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                <div class="fixTableHead"> 
                                <table class="table">
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
                                                    <th>Remarks</th>
                                                    <th>Selected</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Pagination parameters
                                            $records_per_page = 1; // Number of records to display per page
                                            $current_page = isset($_GET['outerpage']) ? $_GET['outerpage'] : 1; // Current page number

                                            // Calculate offset
                                            $offset = ($current_page-1) * $records_per_page;
                                        
                                                    $i=1;
                                                    $sql="SELECT DISTINCT(project_id) from decleration where district_id='".$_SESSION['distid']."'  LIMIT $offset, $records_per_page";
                                                  // echo $sql;
                                                    $res=execute_query($sql);
                                                    while($row=mysqli_fetch_array($res)){

                                                        $j=1;
                                                        echo '<tr  style="background-color:#e4ffe5;font-weight:600;font-size:18px;">
                                                        <td colspan="14"> Project - '.$i++.' : '.getProjectname($row['project_id']).'</td>';

                                                        $nq="SELECT DISTINCT(gram_panchyat_id) from decleration where project_id='".$row['project_id']."' ";
                                                       // echo $nq; die;
                                                        $nres=execute_query($nq);
                                                        while($ndata=mysqli_fetch_assoc($nres)){
                                                       // print_r($row); die;
                                                        echo '<tr  style="background-color:#e4ffff;font-weight:600;font-size:18px;">
                                                                <td colspan="14"> Gram Panchyat/Ward -  : '.getGrampanchayatName($ndata['gram_panchyat_id']).'</td>
                                                            </tr>';
                                                        $q="select nad.gram_panchayat,nad.word_name,nad.pre_name,nad.name_hi,nad.rikt_aww_center,nad.fname,nad.mname,nad.hname,nad.mobile,nad.year,nad.month,nad.day,pd.category,pd.sub_category,pd.avedika_status,pd.bpl_card,ad.i_present,ad.g_present,ad.pg_present,ad.merit,d.application_no FROM new_application_details nad INNER JOIN personal_details pd ON nad.userid=pd.userid INNER JOIN academic_details ad ON ad.userid = pd.userid  INNER JOIN decleration d ON d.userid=ad.userid WHERE d.gram_panchyat_id='".$ndata['gram_panchyat_id']."'AND  d.project_id='".$row['project_id']."' ORDER BY pd.bpl_card desc,pd.avedika_status,ad.merit desc,nad.year DESC,nad.month DESC,nad.day DESC,pd.sub_category DESC ";
                                                        //echo $q; die;
                                                        $r=execute_query($q);
                                                        while($adata=mysqli_fetch_array($r)){
                                                           // print_r($adata); die;
                                                            echo'<tr>
                                                    
                                                            <td>'.$adata['application_no'].'</td>';
                                                            
                                                           echo'
                                                            <td>'.getcenterName($adata['rikt_aww_center']).'</td>
                                                            <td>'.$adata['name_hi'].'</td>
                                                            <td>'.$adata['fname'].'</td>
                                                            <td>'.$adata['mname'].'</td>
                                                            <td>'.$adata['hname'].'</td>
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
                                                                echo '<td><div class="tooltip-inner bgcolor-3">'.getCurrentsituation($adata['avedika_status']).'</div></td>';
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
                                                            <td><textarea class="form-control"></textarea></td>
                                                            <td> <input class="form-check-input text-center" type="checkbox" id="checkboxNoLabel" value="" aria-label="...">
                                                            </td>
                                                        </tr>';
                                                        }
                                                    }
                                                }
                                                ?>
                                               
                                       
                                          
                                           <tr>
                                            
                                           </tr>
                                            
                                            </tbody>
                                            
                                        </table>
                                    
                                    
                                </div>

                                <?php
                               
                                    // Pagination links
                                    // $sql_count = "SELECT COUNT(*) AS total FROM your_table";
                                    // $result_count = $conn->query($sql_count);
                                    $cnq="SELECT DISTINCT(project_id) as total from decleration where district_id='".$_SESSION['distid']."'";
                                 // echo $cnq; 
                                    $result_count=execute_query($cnq);
                                           
                                    $row_count = mysqli_fetch_assoc($result_count);
                                    $total_records = $row_count['total'];

                                   //// echo $total_records;
                                    $total_pages = ceil($total_records / $records_per_page);
                                    //echo   $total_pages;
                                ?>
                               
                                <div class="">
                                    <ul class="pagination pagination-lg">
                                     <li class="page-item"><a class="page-link" href="broadsheet-dist.php">First</a></li>
                                                <?php
                                            for ($i = 1; $i <= $total_pages; $i++) {
                                                //  echo "<a href='?page=$i'>$i</a> ";
                                            echo'<li class="page-item"><a class="page-link" href="?outerpage='.$i.'">'.$i.'</a></li>';
                                            }
                                                
                                            ?>
                                              
                                            </ul>
                                </div>
                                
                                                
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php }} ?>
                </div>
        <script>
            $('#project').on('change', function() {
                var adminprojeectID = $('#project').val();
                $.ajax({
                    url: "../ajax.php",
                    type: "POST",
                    data: {
                        adminprojeectID: adminprojeectID
                    },
                    cache: false,
                    success: function(result) {
                        $('#gramp').html('');
                        $('#gramp').html(result);
                        
                      
                    }
                });
            });

            $('#gramp').on('change', function() {
            var gramp = this.value;
            var projectid = $('#project').val();
            $.ajax({
                url: "../ajax.php",
                type: "POST",
                data: {
                    grampanchayatID: gramp,
                    pid: projectid

                },
                cache: false,
                success: function(result) {
                    $("#aganwadi").html('');
                  
                    $("#aganwadi").html(result);
                }
            });


        });
        </script>
                <!-- content-wrapper ends -->
                <?php page_footer(); ?>

               