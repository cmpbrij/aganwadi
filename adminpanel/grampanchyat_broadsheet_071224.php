<?php
include 'master.php';
ob_start();
error_reporting(0);
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
        <h4 class="card-title">Provisional Broadsheet - <span style="color:green"><?php echo getdistName($data['district_id']); ?> - <?php echo getProjectname($_GET['pid']); ?></span></h4>
            <div class="card">
                <div class="card-header float-right">
                    <div>
                                    <button type="button" class="btn btn-success">
                                        <a target="_blank" href="eligibilList.php?pid=<?php echo $_GET['pid']; ?>" style="text-decoration:none;color:white;"><b> Eligible List </b></a>
                                    </button> &nbsp; &nbsp; &nbsp; &nbsp;
                    
                                    <button type="button" class="btn btn-success">
                                        <a target="_blank" href="noteligibilList.php?pid=<?php echo $_GET['pid']; ?>"  style="text-decoration:none;color:white;"><b>Not Eligible List</b> </a>
                                    </button>
                    </div>
                </div>
                <div class="card-body">
                   <div class="" style="color:red">
                    *Top candidate eligible from each Anganwadi center. <br>
                    *Download the broadsheet in front of the committee, mark it with a signature and stamp, then <a href="uploadbroadsheet.php">upload it</a>.<br>
                    <!-- *Only one candidate is marked from each Anganwadi center after document verification.<br> -->
                    *A candidate can only be marked as 'eligible' or 'Not eligible' at one time.<br>
                </div><br>

                    <!-- <span style="fornt-size:18px;"><a href="pdf.php?id=<?php echo $_GET['pid']; ?>">Download PDF</a></span> &nbsp;  &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; -->
                    <!-- <span><a href="excelexport.php?id=<?php echo $data['district_id']; ?>">EXCEL</a></span> -->
                    <span style="fornt-size:20px;"><a href="downloadBsheet.php?pid=<?php echo $_GET['pid']; ?>" target="_blank"><b>Download Broadsheet(PDF)</b></a></span> &nbsp;&nbsp;&nbsp;&nbsp;

                    <span style="fornt-size:20px;"><a href="csv-downlaod.php?district_id=<?php echo $data['district_id']; ?>&project_id=<?php echo $_GET['pid']; ?>" target="_blank"><b>Download Broadsheet(CSV)</b></a></span>


                    <div class=" row">
                        <div class="col-12">
                            <div class="card">

                                <div class="fixTableHead">
                                    <table class="table" id="">
                                        <thead style="background-color: #CCC;font-size:14px !important;">
                                            <tr>

                                                <th>Application No.</th>
                                                <th>Grampanchyat/Ward & NyayPanchyat</th>
                                                
                                                <th>AWW Center</th>
                                                <th>Reservation & EWS Info</th>
                                                <th>Applicant Name</th>
                                                <th>Father Name</th>
                                                <th>Mother Name</th>
                                                <th>Husband Name</th>
                                                <th>Mobile No.</th>
                                                <th>DOB</th>
                                                <!-- <th>Age</th> -->

                                                <th>Category</th>
                                                <?php

                                                $catstatus = subcategoryEnable();
                                                if ($catstatus == 1) {
                                                    echo ' <th>Sub category</th>';
                                                }
                                                ?>
                                                 <th>Handicapped Application No. & CertificateID</th>
                                                 <th>F.F. Relation & Details</th>
                                                <th>Residency Application No. & CertificateID & View</th>
                                                <th>Cast Application No. & CertificateID & View</th>
                                                <th>Income Application No. & CertificateID & View</th>
                                                <th>BPL/APL</th>
                                                <th>Widow Details</th>
                                                <th>High School</th>
                                                <th>Intermediate</th>
                                                <th>Graduation</th>
                                                <th>Post Graduation</th>
                                                <th>Current Status</th>
                                                <!-- <th>BPL</th> -->
                                               
                                                
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
                                            $nq = "SELECT MIN(nv.gram_panchayat_id ) AS gram_panchayat_id , gp.gram_panchayat_name
                                            FROM new_vacancy nv
                                            JOIN gram_panchayat gp ON nv.gram_panchayat_id  = gp.id
                                            WHERE nv.district_id = ?
                                            AND nv.project_id = ?
                                            AND nv.vacancy_available = 'Yes'
                                            GROUP BY nv.gram_panchayat_id,gp.gram_panchayat_name 
                                            ORDER BY gp.gram_panchayat_name
                                            ";
                                            $stmt = $conn->prepare($nq);
                                            $stmt->bind_param("ss", $districtId, $projectId);
                                            $stmt->execute();
                                            $nres = $stmt->get_result();
                                            $numRows = $nres->num_rows;
                                            if($numRows > 0){
                                              
                                                $cen=1;
                                            while ($ndata = $nres->fetch_assoc()) {
                                               
                                               
                                                // if($ndata['isreserve'] != NULL){
                                                //     $rval=' AND pd.category='.$ndata['isreserve'];
                                                // }
                                                // else{
                                                //     $rval='';
                                                // }
                                                echo '<tr style="background-color:#e4ffff;font-weight:600;font-size:18px;">
                                                        <td colspan="26"> Gram Panchyat/Ward - : ' . $ndata['gram_panchayat_name'] . '</td>
                                                    </tr>';
                                                $gramPanchyatId = $ndata['gram_panchayat_id'];
                                                $q = "SELECT nad.userid, nad.grameen_sehri,nv.awc_urban_rural,nad.pre_name,nad.nay_panchayat,
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
                                                d.niwash_v_status, d.id AS did, d.remarks, d.selection_status, nv.awc_name, nv.unique_code, nv.vacancy_available, nv.category, nv.ews, 
                                                d.income_v_status, d.cast_v_status,d.income_issue_date,d.created
                                            FROM decleration d
                                            INNER JOIN new_application_details nad ON d.userid = nad.userid
                                            INNER JOIN personal_details pd ON nad.userid = pd.userid
                                            INNER JOIN academic_details ad ON ad.userid = pd.userid
                                            LEFT JOIN new_vacancy nv ON nv.id = d.aganwadi_center
                                            WHERE d.district_id = ? 
                                            AND d.project_id = ? 
                                            AND d.gram_panchyat_id = ?
                                            AND d.aganwadi_center !=''
                                            AND nv.vacancy_available='Yes'
                                           
                                            ORDER BY 
                                               nv.unique_code,
                                                CASE 
                                                    WHEN nad.age_years < 36 AND nad.age_years >= 18 THEN 1 
                                                    ELSE 0
                                                END DESC,
                                                CASE 
                                                    WHEN pd.bpl_card= 1 THEN 1
                                                    ELSE 0
                                                END DESC,
                                                CASE 
                                                    WHEN pd.avedika_status = 1 OR pd.avedika_status = 2 THEN 1 
                                                    ELSE 0
                                                END DESC,
                                                CASE
                                                    WHEN nv.ews = 1 AND pd.category = 5 THEN 1
                                                    ELSE 0
                                                END DESC,
                                                CASE 
                                                    WHEN nv.category=pd.category AND pd.category NOT IN (1, 5)  THEN 1
                                                    ELSE 2
                                                END,
                                                CAST(ad.merit AS DECIMAL(5,3)) DESC,
                                                CAST(nad.age_years AS UNSIGNED) DESC,
                                                CAST(nad.age_months AS UNSIGNED) DESC,
                                                CAST(nad.age_days AS UNSIGNED) DESC
                                                ";
                                                

                                                $stmt = $conn->prepare($q);
                                                $stmt->bind_param("sss", $districtId, $projectId, $gramPanchyatId);
                                                $stmt->execute();
                                                $r = $stmt->get_result();
                                                $ucode='';
                                                $pre='';
                                                $num=1;
                                                while ($adata = $r->fetch_assoc()) {

                                                    $reservation_applied = $adata['category']; 
                                                    if($reservation_applied == '2' || $reservation_applied == '3' ) { 
                                                        if($adata['cast'] != $reservation_applied) {
                                                            
                                                            continue;
                                                        }
                                                    } 
                                                    elseif ($reservation_applied == '4') {
                                                        if ($adata['cast'] != '3' && $adata['cast'] != '4') {
                                                            continue;
                                                        }
                                                    } 

                                                   

                                                    if ($adata['selection_status'] == 1) {
                                                        $sbg = '#3CB371';
                                                    } else if ($adata['selection_status'] == 2) {
                                                        $sbg = '#ffb3b3';
                                                    } else {
                                                        $sbg = '';
                                                    }
                                                    $ucode=$adata['unique_code'];
                                                   
                                                    if($pre !=$ucode && $ucode !=''){
                                                        echo'<tr style="background-color:#FCB1DC"><td colspan="26"><b>'.$cen++.'. Center Name: </b>'. strtoupper($adata['awc_name']).' <b>Unique Code: </b> '.$adata['unique_code'].'('.$adata['awc_urban_rural'].')</td></tr>';
                                                    }
                                                    // echo $sbg; continue;
                                                    // print_r($adata); die;

                                                    $dateTimeStored = new DateTime($adata['created']); // Example stored datetime
                                                    $comparisonDate = new DateTime('2024-09-01'); // Date to compare with

                                                    if ($dateTimeStored > $comparisonDate) {
                                                      $baseurl='/';
                                                    } else {
                                                        $baseurl="http://34.116.192.0/";
                                                    }
                                                    echo ' <tr style="background-color:' . $sbg . '">
                                                    
                                                            <td><b>'.$num++.'.</b> '  . $adata['application_no'] . '<br>'.getcolocated($adata['grameen_sehri']).'</td>';
                                                    echo '<td><b>G.P./Ward-</b>' .$ndata['gram_panchayat_name'] . '<br><b>N.P.-</b>' .  $adata['nay_panchayat'] . '</td>';
                                                    $awc_name = isset($adata['awc_name']) ? strtoupper($adata['awc_name']) : 'N/A';
                                                    echo '<td>' . $awc_name . '<br>' . $adata['unique_code'] . '</td>';
                                                   
                                                    echo '<td><b>Reserved For: </b>' . getCategoryText($adata['category']) . '<br><b>EWS: </b>' .  getewsText($adata['ews']) . '</td>';
                                                    echo '<td>'.getPrename($adata['pre_name']).' ' . $adata['name_hi'] . '<br>' . $adata['name_en'] . '</td>';
                                                   

                                                    echo'<td>' . $adata['fname'] . '</td>
                                                            <td>' . $adata['mname'] . '</td>
                                                            <td>' . $adata['hname'] . '</td>
                                                            <td>' . $adata['mobile'] . '</td>
                                                            <td>' . $adata['date_of_birth'] . '</td>';
                                                    // echo '<td>Years:' . $adata['age_years'] . '<br> Months:' . $adata['age_months'] . '<br>Days:' . $adata['age_days'] . '</td>
                                                    //       ';

                                                    echo '<td>' . getCategoryText($adata['cast']) . '</td>';
                                                    if ($catstatus == 1) {
                                                        echo  '<td>' . getSubcategoryText($adata['sub_category']) . '</td>';
                                                    }
                                                    if ($adata['divangta_pramnpatr_kramank'] != '') {
                                                        echo '<td>' . $adata['divangta_pramnpatr_kramank'] . '<br>' . $adata['divangta_avedan_krmank'] . '</td>';
                                                    } else {
                                                        echo '<td>NA</td>';
                                                    }
                                                    if ($adata['f_senani_sambandh'] != '') {
                                                        echo '<td>' . $adata['f_senani_sambandh'] . '<br><a href="'.$baseurl.''.$adata['f_senani_prmanptr']. '" target="_blank">View File</a></td>';
                                                    } else {
                                                        echo '<td>NA</td>';
                                                    }

                                                    echo '<td>' . $adata['nivas_avedan_prmanpatr'] . '<br>' . $adata['nivas_prmaanpatr_no'];
                                                    if ($adata['niwash_v_status'] == '1') {
                                                        echo '<div class="tooltip-inner bg-success">Verified</div>';
                                                    } else {
                                                        echo '<div class="tooltip-inner bg-danger">Not Verified</div>';
                                                    }

                                                    echo '</td>';
                                                    if ($adata['jaati_avedan_prmanpatr'] != '') {
                                                        echo '<td>' . $adata['jaati_avedan_prmanpatr'] . '<br>' . $adata['jaant_prmaanpatr_no'] . '<br>';
                                                        if ($adata['cast_v_status'] != '') {
                                                            echo '<div class="tooltip-inner bg-success">Verified Cast:' . $adata['cast_v_status'] . '</div></td>';
                                                        } else {
                                                            echo '<div class="tooltip-inner bg-danger">Not Verified</div></td>';
                                                        }
                                                    } else {
                                                        echo '<td>NA</td>';
                                                    }
                                                    if ($adata['aay_avedan_prmanpatr'] != '') {
                                                        echo '<td>' . $adata['aay_avedan_prmanpatr'] . '<br>' . $adata['aay_prmaanpatr_no'] . '<br><span style="color:blue;">'.$adata['income_issue_date'].'</span>';
                                                        //<a href="'.$adata['aay_upload'].'">View</a>
                                                        if ($adata['income_v_status'] != '' && $adata['income_v_status'] != 0) {
                                                            echo '<div class="tooltip-inner bg-success">Verified- ₹' . $adata['income_v_status'] . '</div></td>';
                                                        } else {
                                                            echo '<div class="tooltip-inner bg-danger">Not Verified</div></td>';
                                                        }
                                                      
                                                    } else {
                                                        echo '<td>NA</td>';
                                                    }

                                                    if($adata['bpl_card']==1){
                                                                echo'<td><div class="tooltip-inner bg-success"><b>BPL</b></div></td>';
                                                        }
                                                        else{
                                                            echo'<td><div class="tooltip-inner bg-success"><b>NON-BPL</b></div></td>';
                                                        }

                                                    if ($adata['vidhwa_certificateno'] != '') {
                                                        echo '<td>' . $adata['vidhwa_certificateno'] . '<br>Jarikrta-' . $adata['v_jarikrta_name'] . '<br><a href="'.$baseurl.''.$adata['v_uploaddata'].'" target="_blank">View </a></td>';
                                                    } else {
                                                        echo '<td>NA</td>';
                                                    }

                                                    echo '<td><a href="'.$baseurl.'' . $adata['h_marksheetdoc'] . '" target="_blank">H. Marksheet</a><br> <a href="'.$baseurl.'' . $adata['h_otherdoc'] . '" target="_blank">H. Other Doc</a> </td>';

                                                    echo '<td>' . $adata['i_totalmarks'] . '/' . $adata['i_maxmarks'] . '<br>' . $adata['i_present'] . '%<br><a href="'.$baseurl.'' . $adata['i_marksheetdoc'] . '" target="_blank">Marksheet</a> <a href="'.$baseurl.'' . $adata['i_otherdoc'] . '" target="_blank">Other Doc</a> </td>';

                                                    if ($adata['g_maxmarks'] != '') {
                                                        echo '<td>' . $adata['g_totalmarks'] . '/' . $adata['g_maxmarks'] . '<br>' . $adata['g_present'] . '%<br><a href="'.$baseurl.'' . $adata['g_marksheetdoc'] . '"  target="_blank">Marksheet</a> <a  href="'.$baseurl.'' . $adata['g_otherdoc'] . '"  target="_blank">Other Doc</a> </td>';
                                                    } else {
                                                        echo '<td>NA</td>';
                                                    }
                                                    if ($adata['pg_maxmarks'] != '') {
                                                        echo '<td>' . $adata['pg_totalmarks'] . '/' . $adata['pg_maxmarks'] . '<br>' . $adata['pg_present'] . '%<br><a href="'.$baseurl.'' . $adata['pg_marksheetdoc'] . '" target="_blank">Marksheet</a> <a href="'.$baseurl.'' . $adata['pg_otherdoc'] . '"  target="_blank">Other Doc</a> </td>
                                                            ';
                                                    } else {
                                                        echo '<td>NA</td>';
                                                    }

                                                    if ($adata['avedika_status'] == '1') {
                                                        echo '<td>
                                                                <div class="tooltip-inner bgcolor-1"> 
                                                                ' . getCurrentsituation($adata['avedika_status']) . '
                                                            </div></td>';
                                                    } else if ($adata['avedika_status'] == '2') {
                                                        echo '<td> <div class="tooltip-inner bgcolor-2">' . getCurrentsituation($adata['avedika_status']) . '</div></td>';
                                                    } else {
                                                        echo '<td><div class="tooltip-inner color-3">' . getCurrentsituation($adata['avedika_status']) . '</div></td>';
                                                    }

                                                    // if ($adata['bpl_card'] == '1') {
                                                    //     echo '<td><div class="tooltip-inner bgcolor-4">BPL</div></td>';
                                                    // } else {
                                                    //     echo '<td>
                                                    //             <div class="tooltip-inner bgcolor-5">NON-BPL</div>
                                                    //             </td>';
                                                    // }
                                                 
                                                    
                                                    echo '<td>' . $adata['merit'] . '</td>
                                                         <td><a href="viewallfiles.php?id='.$adata['userid'].'" target="_blank">Download Doc</a><br><br><a href="../users/adminformview.php?appNo='. $adata['application_no'].'" target="_blank">View Form</a></td>
                                                                    <td><textarea class="form-control" name="reason" id="reason_' . $adata['did'] . '" style="border:2px solid black;width:160px;">' . $adata['remarks'] . '</textarea></td><td>
                                                                    <select class="form-control" id="cselected_' . $adata['did'] . '" style="width:120px;border:2px solid red;" required>
                                                                        <option value="">Please select</option>';
                                                                    ?>
                                                                        <option value="1" <?php echo ($adata['selection_status'] == 1 ? 'selected' : ''); ?>>Eligible</option>
                                                                        <option value="0" <?php echo ($adata['selection_status'] == 0 ? 'selected' : ''); ?>>Not Eligible</option>
                                                                    </select><br>
                                                                    <?php
                                                                    echo'<button class="btn btn-primary" id="save" data-did="' . $adata['did'] . '" ' . ($adata['selection_status'] != '' ? 'disabled' : '') . ' >Save</button>

                                                                    </td>
                                                                    
                                                        </tr>';
                                                        $pre=$adata['unique_code'];
                                                }
                                            }
                                        }
                                           
                                            ?>

                                        </tbody>

                                    </table>

                                    <div class="">
                                        
                                    </div>


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