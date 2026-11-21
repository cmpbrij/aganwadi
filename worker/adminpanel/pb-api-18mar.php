<?php
include 'master.php';
ob_start();
error_reporting(1);
if (!checkLogin()) {
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

    .bgcolor-1 {
        background-color: #a3f307;
    }

    .bgcolor-2 {
        background-color: #f50b86;
    }

    .bgcolor-3 {
        background-color: #ff6f00;
    }

    .bgcolor-4 {
        background-color: #e2f705;
    }

    .bgcolor-5 {
        background-color: #2b0b5c;
    }
    /* Loader CSS */
.loader {
  position: fixed;
  left: 50%;
  top: 50%;
  z-index: 9999;
  border: 16px solid #f3f3f3; /* Light grey */
  border-top: 16px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 120px;
  height: 120px;
  animation: spin 2s linear infinite;
  transform: translate(-50%, -50%);
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

</style>
<?php

page_header_end();

navigation();

if (isset($_SESSION['adminid'])) {
    $q = "select * from admin_users where id='" . $_SESSION['sid'] . "'";
    // echo $q; die;
    $res = execute_query($q);
    $data = mysqli_fetch_assoc($res);
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
            
            <!-- <li class="nav-item">
                        <a class="nav-link" id="chats-tab" data-bs-toggle="tab" href="#chats-section" role="tab" aria-controls="chats-section">CHATS</a>
                    </li> -->
        </ul>
        <div class="tab-content" id="setting-content">
            <div class="tab-pane fade show active scroll-wrapper" id="todo-section" role="tabpanel" aria-labelledby="todo-section">
                <div class="add-items d-flex px-3 mb-0">
                   
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
    <div class="main-panel">
        <!-- Loader HTML -->
        <div id="loader" class="loader"></div>

        <div class="content-wrapper">
        <h4 class="card-title">Provisional Broadsheet - <span style="color:green"><?php echo getdistName($_SESSION['distid']); ?> - <?php echo getBlockname($_GET['pid']); ?></span></h4>
            <div class="card">
                <div class="card-header float-right">
                    <div>
                    <a target="_blank" href="eligibilList.php?pid=<?php echo $_GET['pid']; ?>" style="text-decoration:none;color:white;"> <button type="button" class="btn btn-success">
                                        <b> Selected List <img src="right.png" width="18"></b>
                    </button>
                    </a> &nbsp; &nbsp; &nbsp; &nbsp;
                    <a target="_blank" href="noteligibilList.php?pid=<?php echo $_GET['pid']; ?>" style="text-decoration:none;color:white;">
                                    <button type="button" class="btn btn-success">
                                       <b>Not Selected List <img src="right.png" width="18"></b> 
                                    </button>
                    </a>
                    </div>
                </div>
                <div class="card-body">
                <div class="" style="color:red">
                <!-- Broadsheet based on Merit Score without API Feedback -->
                </div>
                   <!-- <div class="" style="color:red">
                    *Top candidate eligible from each Anganwadi center. <br>
                    *Download the broadsheet in front of the committee, mark it with a signature and stamp, then <a href="uploadbroadsheet.php">upload it</a>.<br>
                   
                    *A candidate can only be marked as 'eligible' or 'Not eligible' at one time.<br>
                </div><br> --><br>

                     <span style="fornt-size:20px;"><a href="downloadBsheet-api.php?pid=<?php echo $_GET['pid']; ?>" target="_blank"><b>Download Broadsheet(PDF)</b></a></span> &nbsp;&nbsp;&nbsp;&nbsp;

                    <span style="fornt-size:20px;"><a href="csv-download-api.php?district_id=<?php echo $data['district_id']; ?>&project_id=<?php echo $_GET['pid']; ?>" target="_blank"><b>Download Broadsheet(CSV)</b></a></span> &nbsp;&nbsp;&nbsp;&nbsp;

                    <!-- <span style="fornt-size:20px;"><a href="finalmarkall.php?pid=<?php echo $_GET['pid']; ?>">Download Final Marked PDF List</a> </a> -->



                    <div class=" row">
                        <div class="col-12">
                            <div class="card">

                                <div class="fixTableHead">
                                    <table class="table" id="">
                                        <thead style="background-color: #CCC;font-size:14px !important;">
                                            <tr>

                                                <th>Application No.</th>
                                                <th>GP/Ward & NP</th>
                                                <th>AWW Center</th>
                                                
                                                <th>Applicant Details</th>
                                                
                                                <th>Mobile No. & DOB</th>
                                                
                                                <th>Residency Application No. & CertificateID & View</th>
                                                <th>Cast Application No. & CertificateID & View</th>
                                                <th>Income Application No. & CertificateID & View</th>
                                                
                                                
                                                <th>Intermediate</th>
                                                <th>Graduation</th>
                                                <th>Post Graduation</th>
                                                <th>Current Status</th>
                                                <!-- <th>BPL</th> -->
                                               
                                                <th>API Residency Details</th>
                                                <th>API Cast Details</th>
                                                 <th>API Income Details</th>

                                                <th>Merit</th>
                                                <th>Download</th>
                                                <th> Reason</th>
                                                <th width="120px">Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                       
                                        $districtId = $_SESSION['distid'];
                                        $projectId = $_GET['pid'];
                                        $i = 1;
                                        $j = 1;
                                        $nq = "SELECT id,awc_urban_rural,awc_name,unique_code,category,COALESCE(NULLIF(TRIM(nv.gp_name), ''), nv.ward_name) AS gp_or_ward_name
                                        FROM new_vacancy nv
                                        WHERE nv.district_id = '".$_SESSION['distid']."'
                                        AND nv.project_id = '".$_GET['pid']."'
                                        ORDER BY gp_name,ward_name
                                        ";
                                        
                                        $stmt=execute_query($nq);
                                        
                                        $numRows = mysqli_num_rows($stmt);
                                        if($numRows > 0){
                                            
                                        $cen=1;
                                        while ($ndata = mysqli_fetch_assoc($stmt)) {
                                               
                                            echo '<tr style="background-color:#e4ffff;font-size:18px;">
                                                <td colspan="26"><b>Center Name:</b> '.$ndata['awc_name'].'('.$ndata['awc_urban_rural'].') <b>Center Code: </b>'.$ndata['unique_code'].' <b>Grampanchyat/Ward:</b> ' . $ndata['gp_or_ward_name'] . '<b> Reserved For: </b>'.getCategoryText($ndata['category']).'</td>
                                            </tr>';
                                                
                                        $q = "SELECT nad.userid, nad.grameen_sehri,nv.awc_urban_rural,nad.pre_name,nad.nay_panchayat,COALESCE(NULLIF(TRIM(nv.gp_name), ''), nv.ward_name) AS gram_panchayat_name,
                                        nad.gram_panchayat, nad.pre_name, nad.name_hi, nad.name_en, nad.rikt_aww_center, nad.date_of_birth,
                                                nad.fname, nad.mname, nad.hname, nad.mobile, nad.age_years, nad.age_months, nad.age_days,
                                                pd.category AS cast, pd.sub_category, pd.avedika_status, pd.bpl_card, 
                                                ad.i_present, ad.g_present, ad.pg_present, ad.merit,
                                                d.application_no, d.aganwadi_center, pd.drl_no, pd.death_date, pd.death_person_name,
                                                pd.divangta_pramnpatr_kramank, pd.divangta_avedan_krmank,
                                                pd.f_senani_sambandh, pd.f_senani_prmanptr,
                                                pd.avedika_status, pd.vidhwa_certificateno,
                                                pd.nivas_prmaanpatr_no, pd.nivas_avedan_prmanpatr,
                                                pd.nivas_upload, pd.jaant_prmaanpatr_no, pd.jaati_avedan_prmanpatr, pd.jaati_upload, pd.aay_prmaanpatr_no, pd.aay_avedan_prmanpatr, pd.aay_upload, 
                                                ad.i_school, ad.i_board, ad.i_year, ad.i_maxmarks, ad.i_totalmarks, ad.i_present, ad.g_present, ad.pg_present, 
                                                pd.v_jarikrta_name, pd.v_uploaddata,ad.h_marksheetdoc,ad.h_otherdoc, ad.i_marksheetdoc, ad.i_otherdoc, ad.g_totalmarks, ad.g_maxmarks, ad.g_present, ad.g_marksheetdoc, ad.g_otherdoc, 
                                                ad.pg_totalmarks, ad.pg_maxmarks, ad.pg_marksheetdoc, ad.pg_otherdoc, 
                                                 d.id AS did, d.remarks, d.selection_status, nv.awc_name, nv.unique_code, nv.vacancy_available, nv.category,  
                                                d.income_issue_date,d.created,pd.varshik_aay,nad.permanent_full_address,nad.permanent_full_address_pincode,
                                                d.income_issue_date,d.created,pd.niwash_file,pd.jaati_upload,pd.aay_upload,pd.jaati,pd.varshik_aay,pd.aay_prmaanpatr_issue_date,nad.h_marksheet,pd.grampanchayatname,pd.aganvadi_center, d.niwash_cert_ststus,d.niwash_issue_date,d.niwash_details,d.cast_cert_status,d.cast_issue_date,d.cast_details,d.income_cert_status,d.income_value,d.income_details,d.cast_v_status
                                            FROM decleration d
                                            INNER JOIN new_application_details nad ON d.userid = nad.userid
                                            INNER JOIN personal_details pd ON nad.userid = pd.userid
                                            INNER JOIN academic_details ad ON ad.userid = pd.userid
                                            LEFT JOIN new_vacancy nv ON nv.id = d.aganwadi_center
                                            WHERE d.district_id = '".$_SESSION['distid']."' 
                                            AND d.project_id = '".$_GET['pid']."'
                                            AND d.aganwadi_center = '".$ndata['id']."'
                                            ORDER BY 
                                                CASE 
                                                    WHEN d.selection_status = 1 THEN 0
                                                    WHEN d.selection_status = 2 THEN 1
                                                    ELSE 2
                                                END,
                                                CAST(ad.merit AS DECIMAL(5,3)) DESC
                                               
                                            ";
                                               // echo $q;
                                                $r = execute_query($q);
                                                $ucode='';
                                                $pre='';
                                                $num=1;
                                                while ($adata = mysqli_fetch_assoc($r)) {
                                                    $reservation_applied = $adata['category']; 
                                                
                                                    if ($adata['selection_status'] == 1) {
                                                        $sbg = '#3CB371';
                                                    } else if ($adata['selection_status'] == 2) {
                                                        $sbg = '#ffb3b3';
                                                    }
                                                    else if($adata['selection_status'] == '0'){
                                                        $sbg = '#e62323ff';
                                                    
                                                    }
                                                    else if(($adata['varshik_aay'] < 46080 && $adata['varshik_aay'] > 100) && $ndata['awc_urban_rural']=='Rural'){
                                                        $sbg = 'rgba(231, 215, 40, 1)';
                                                        }
                                                    else if(($adata['varshik_aay'] < 56460 && $adata['varshik_aay'] > 100) && $ndata['awc_urban_rural']=='Urban'){
                                                        $sbg = 'rgba(231, 215, 40, 1)';
                                                        }
                                                     else {
                                                        $sbg = '';
                                                    }
                                                    $ucode=$adata['unique_code'];
                                                
                                                   
                                            echo '<tr style="background-color:' . $sbg . '">
                                                    
                                                <td><b>'.$num++.'.</b> '  . $adata['application_no'] .'</td>';
                                                    echo '<td> <b>G.P./Ward-</b>' . $adata['gram_panchayat_name'] . '<br><b>N.P.-</b>' . $adata['nay_panchayat'] . '<br><b>Add:</b>'.$adata['permanent_full_address'].','.$adata['permanent_full_address_pincode'].'</td>';
                                                    $awc_name = isset($adata['awc_name']) ? strtoupper($adata['awc_name']) : 'N/A';
                                                    echo '<td>' . $adata['awc_name'] . '<br>' . $adata['unique_code'] . '</td>';
                                                   
                                                    // echo '<td><b>Reserved For: </b>' . getCategoryText($adata['category']) . '<br><b>EWS: </b>' .  getewsText($adata['ews']) . '</td>';

                                                      echo '<td><b>Name: </b>'. $adata['name_hi'] . '<br>' . $adata['name_en'] . '
                                                    <br><b>F:</b>'.$adata['fname'].'
                                                   <br><b> M:</b>'.$adata['mname'].'
                                                   <br><b> H:</b>'.$adata['hname'].'
                                                   <br><b> Cat:</b>'.getCategoryText($adata['cast']).'

                                                    </td>
                                                    ';

                                                  echo '<td><b>Mob:</b>' .  $adata['mobile'].'
                                                            <br><b>DOB:</b>'.date("d-m-Y",strtotime($adata['date_of_birth'])).'
                                                            <br><a href="'.$baseurl.'' . $adata['h_marksheet'] . '" target="_blank">H. Marksheet</a>
                                                    
                                                    </td>';

                                                   
                                                    echo '<td>' . $adata['nivas_avedan_prmanpatr'] . '<br>' . $adata['nivas_prmaanpatr_no'].'
                                                    <br>
                                                    <b>AWC:</b>'.$adata['aganvadi_center'].'<br>
                                                    <b>GP/Ward:</b>'.$adata['grampanchayatname'].'<br>
                                                    
                                                    <a target="_blank" href="'.$adata['niwash_file'].'">Uploaded Doc</a></td>';

                                                    echo '</td>';
                                                    if ($adata['jaati_avedan_prmanpatr'] != '') {
                                                        echo '<td>' . $adata['jaati_avedan_prmanpatr'] . '<br>' . $adata['jaant_prmaanpatr_no'] . '<br>
                                                        <b>Cast:</b>'.$adata['jaati'].'<br>
                                                        <a target="_blank" href="'.$adata['jaati_upload'].'">Uploaded Doc</a>';
                                                       
                                                    } else {
                                                        echo '<td>NA</td>';
                                                    }
                                                    if ($adata['aay_avedan_prmanpatr'] != '') {
                                                        echo '<td>' . $adata['aay_avedan_prmanpatr'] . '<br>' . $adata['aay_prmaanpatr_no'] . '<br>
                                                            <b>Income:</b>'.$adata['varshik_aay'].'<br>
                                                            <b>issue on:</b>'.date('d-m-Y',strtotime($adata['aay_prmaanpatr_issue_date'])).'<br>
                                                          <a target="_blank" href="'.$adata['aay_upload'].'">Uploaded Doc</a>';
                                                       
                                                    } else {
                                                        echo '<td>NA</td>';
                                                    }

                                                    echo '<td>' . $adata['i_totalmarks'] . '/' . $adata['i_maxmarks'] . '<br>' . $adata['i_present'] . '%<br><a href="' . $adata['i_marksheetdoc'] . '" target="_blank">Marksheet</a> <a href="' . $adata['i_otherdoc'] . '" target="_blank">Other Doc</a> </td>';

                                                    if ($adata['g_present'] != '') {
                                                        echo '<td>' . $adata['g_totalmarks'] . '/' . $adata['g_maxmarks'] . '<br>' . $adata['g_present'] . '%<br><a href="' . $adata['g_marksheetdoc'] . '"  target="_blank">Marksheet</a> <a  href="' . $adata['g_otherdoc'] . '"  target="_blank">Other Doc</a> </td>';
                                                    } else {
                                                        echo '<td>NA</td>';
                                                    }
                                                    if ($adata['pg_present'] != '') {
                                                        echo '<td>' . $adata['pg_totalmarks'] . '/' . $adata['pg_maxmarks'] . '<br>' . $adata['pg_present'] . '%<br><a href="'.$baseurl.'' . $adata['pg_marksheetdoc'] . '" target="_blank">Marksheet</a> <a href="'.$baseurl.'' . $adata['pg_otherdoc'] . '"  target="_blank">Other Doc</a> </td>
                                                            ';
                                                    } else {
                                                        echo '<td>NA</td>';
                                                    }

                                                //  if ($adata['vidhwa_certificateno'] != '') {
                                                //         echo '<td>' . $adata['vidhwa_certificateno'] . '<br>Jarikrta-' . $adata['v_jarikrta_name'] . '<br><a href="'.$baseurl.''.$adata['v_uploaddata'].'" target="_blank">View </a></td>';
                                                //     } else {
                                                //         echo '<td>NA</td>';
                                                //     }
                                                    
                                                    if ($adata['avedika_status'] == '1') {
                                                        echo '<td>
                                                                <div class="tooltip-inner bgcolor-1"> 
                                                                ' . getCurrentsituation($adata['avedika_status']) . '
                                                            </div>' . $adata['vidhwa_certificateno'] . '<br>Jarikrta-' . $adata['v_jarikrta_name'] . '<br><a href="'.$baseurl.''.$adata['v_uploaddata'].'" target="_blank">View </a></td>';
                                                    } else if ($adata['avedika_status'] == '2') {
                                                        echo '<td> <div class="tooltip-inner bgcolor-2">' . getCurrentsituation($adata['avedika_status']) . '</div>' . $adata['vidhwa_certificateno'] . '<br>Jarikrta-' . $adata['v_jarikrta_name'] . '<br><a href="'.$baseurl.''.$adata['v_uploaddata'].'" target="_blank">View </a></td>';
                                                    } else {
                                                        echo '<td><div class="tooltip-inner color-3">' . getCurrentsituation($adata['avedika_status']) . '</div></td>';
                                                    }

                                                if($adata['niwash_cert_ststus'] =='' || $adata['niwash_cert_ststus'] == NULL){
                                                        $nstatus='<div class="tooltip-inner bg-danger">Not Found</div>';
                                                    }
                                                    else if(trim($adata['niwash_cert_ststus']) == "Certificate Issued"){
                                                        $nstatus='<div class="tooltip-inner bg-success">'.$adata['niwash_cert_ststus'].'</div>';

                                                         $nstatus.='<br>
                                Issue Date: '. $adata['niwash_issue_date'].'
                                <br>Details: '.$adata['niwash_details'];
                                                        //$nstatus=$adata['niwash_cert_ststus'];
                                                    }
                                                     else if($adata['niwash_cert_ststus'] =='0'){
                                $nstatus='<div class="tooltip-inner bg-danger">Invalid Input</div>';
                            }
                                                    else{
                                                        $nstatus='<div class="tooltip-inner bg-info">'.$adata['niwash_cert_ststus'].'</div>';
                                                         $nstatus.='<br>
                                Issue Date: '. $adata['niwash_issue_date'].'
                                <br>Details: '.$adata['niwash_details'];
                                                       // $nstatus=$adata['niwash_cert_ststus'];
                                                    }
                                                    echo'<td>'.$nstatus.'
                                                    
                                                    </td>';

                                                    if($adata['cast_cert_status'] =='' || $adata['cast_cert_status'] == NULL){
                                                        $cstatus='<div class="tooltip-inner bg-danger">Not Found</div>';
                                                    }
                                                    else if(trim($adata['cast_cert_status']) == "Certificate Issued"){
                                                        $cstatus='<div class="tooltip-inner bg-success">'.$adata['cast_cert_status'].'</div>';
                                                        //$nstatus=$adata['niwash_cert_ststus'];
                                                    }
                                                    else{
                                                        $cstatus='<div class="tooltip-inner bg-info">'.$adata['cast_cert_status'].'</div>';
                                                       // $nstatus=$adata['niwash_cert_ststus'];
                                                    }

                                                    echo'<td>
                                                    '.$cstatus.'<br>
                                                        Issue Date: '. $adata['cast_issue_date'].'
                                                        <br>Cast: '.$adata['cast_v_status'].'
                                                    </td>';

                                                     if($adata['income_cert_status'] =='' || $adata['income_cert_status'] == NULL){
                                                        $istatus='<div class="tooltip-inner bg-danger">Not Found</div>';
                                                    }
                                                    else if(trim($adata['income_cert_status']) == "Certificate Issued"){
                                                        $istatus='<div class="tooltip-inner bg-success">'.$adata['income_cert_status'].'</div>';
                                                        //$nstatus=$adata['niwash_cert_ststus'];
                                                    }
                                                    else{
                                                        $istatus='<div class="tooltip-inner bg-info">'.$adata['income_cert_status'].'</div>';
                                                    }


                                                    echo'<td>
                                                    '.$istatus.'<br>
                                                        Income : '. $adata['income_value'].'
                                                         <br>Issue Date: '. $adata['income_issue_date'].'
                                                        Details: '.$adata['income_details'].'
                                                    </td>';
                                                    

                                                    
                                                    echo '<td>' . $adata['merit'] . '</td>
                                                         <td><a href="viewallfiles.php?id='.$adata['userid'].'" target="_blank">View All Doc</a><br><br><a href="../users/adminformview.php?appNo='. $adata['application_no'].'" target="_blank">View Form</a><br><br><a href="pdf-generator.php?dir='.$adata['userid'].'&appNo='. $adata['application_no'].'" target="_blank">Download DOC(PDF)</a></td>
                                                                    <td><textarea class="form-control" name="reason" id="reason_' . $adata['did'] . '" style="border:2px solid black;width:160px;">' . $adata['remarks'] . '</textarea></td><td>
                                                                    <select class="form-control" id="cselected_' . $adata['did'] . '" style="width:120px;border:2px solid red;" required>
                                                                        <option value="">Please select</option>';
                                                                    ?>
                                                                        <option value="1" <?php echo ($adata['selection_status'] == 1 ? 'selected' : ''); ?>>First</option>
                                                                        <option value="2" <?php echo ($adata['selection_status'] == 2 ? 'selected' : ''); ?>>Second</option>
                                                                        <option value="0" <?php echo ($adata['selection_status'] == 0 ? 'selected' : ''); ?>>Not Selected</option>
                                                                    </select><br>
                                                                    <?php

                                                                    if($adata['selection_status'] == '' || $adata['selection_status'] ==NULL){
                                                                        echo'<button class="btn btn-primary" id="save" data-did="' . $adata['did'] . '" >Save</button>';
                                                                    }
                                                                    else{
                                                                     echo'<button class="btn btn-success" >Saveed!</button>';
                                                                    }
                                                                    

                                                                   echo' </td>
                                                                    
                                                        </tr>';
                                                        $pre=$adata['unique_code'];
                                                        $totalforms++;
                                                }
                                            }
                                        }
                                           
                                            ?>

                                        </tbody>

                                    </table>

                                    


                                </div>

                            </div>
                        </div>

                        <div class="">
                                        <span style="color:green">Total Forms: <?php echo $totalforms; ?></span>
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


        <script>
            $(document).ready(function() {
                $(document).on('click', '#save', function() {
                    var did = $(this).data('did');
                    var res = 'reason_' + did;
                    var reason = $('#reason_' + did).val();
                    
                    var selectval = $('#cselected_' + did).val();
                

                    if (reason == '') {
                        swal("Warning!", "Please text select/reject reason!", "warning");
                    } else {
                        $.ajax({
                            url: "ajax.php",
                            method: "POST",
                            data: {
                                selectedreason: reason,
                                did: did,
                                selectval: selectval
                            },
                            dataType: "json",
                            success: function(data) {
                                swal("Success!", "Marked Successfully!", "success")
                            },
                            error: function() {
                                    alert("An error occurred.");
                            }
                        });
                    }

                    // Disable select box if selection status is not empty
                    if (selectedValue == '1' || selectedValue == '0') {
                        selectBox.prop('disabled', true);
                    } else {
                        selectBox.prop('disabled', false);
                    }
                });
            });

            // Hide loader once the page is fully loaded
window.onload = function() {
  document.getElementById("loader").style.display = "none";
};

        </script>