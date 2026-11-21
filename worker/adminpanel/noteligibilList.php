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
        <h4 class="card-title">Not Eligible List - <span style="color:green"><?php echo getdistName($_SESSION['distid']); ?> - <?php echo getProjectname($_GET['pid']); ?></span></h4>
            <div class="card">
           
            <div style="width:210px;">
            <a target="_blank" href="finalselectedlist_project.php?pid=<?php echo $_GET['pid']; ?>" style="text-decoration:none;color:white;">
            <button type="button" class="btn btn-success">
                                        <b>Final Selected List </b>
                                    </button></a>
</div>
            
                <!-- <div class="card-body">
                   <div class="" style="color:red">
                    *Top candidate eligible from each Anganwadi center. <br>
                    *Download the broadsheet in front of the committee, mark it with a signature and stamp, then <a href="uploadbroadsheet.php">upload it</a>.<br>
                     *Only one candidate is marked from each Anganwadi center after document verification.<br> 
                    *A candidate can only be marked as 'eligible' or 'Not eligible' at one time.<br> -->
                </div><br>

                    <!-- <span style="fornt-size:18px;"><a href="pdf.php?id=<?php echo $_GET['pid']; ?>">Download PDF</a></span> &nbsp;  &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp; -->
                    <!-- <span><a href="excelexport.php?id=<?php echo $data['district_id']; ?>">EXCEL</a></span> -->
                    <span style="fornt-size:20px;"><a href="download_noteligibilList.php?pid=<?php echo $_GET['pid']; ?>" target="_blank"><b>Download List</b></a></span> &nbsp;&nbsp;&nbsp;&nbsp;

                    <!-- <span style="fornt-size:20px;"><a href="csv-downlaod.php?district_id=<?php echo $_SESSION['distid'] ?>&project_id=<?php echo $_GET['pid']; ?>" target="_blank"><b>Download Broadsheet(CSV)</b></a></span> -->


                    <div class=" row">
                        <div class="col-12">
                            <div class="card">

                                <div class="fixTableHead">
                                    <table class="table" id="">
                                        <thead style="background-color: #CCC;font-size:14px !important;">
                                           <tr>

                                                <th>Application No.</th>
                                                <th>GP/Ward & NP & AWW Center</th>
                                                <th>Applicant Details</th>
                                               
                                                <th>Mobile & DOB</th>
                                               
                                                <th>Residency Application No. & CertificateID & View</th>
                                                <th>Cast Application No. & CertificateID & View</th>
                                                <th>Income Application No. & CertificateID & View</th>
                                                <!-- <th>Widow Details</th> -->
                                                <!-- <th>High School</th> -->
                                                <th>Intermediate</th>
                                                <th>Graduation</th>
                                                <th>Post Graduation</th>
                                                <th>Current Status</th>
                                               
                                                <th>Merit</th>
                                                <th>Download</th>
                                                <th>Remarks</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                         <?php
                                       
                                            $districtId = $_SESSION['distid'];
                                            $projectId = $_GET['pid'];
                                            $i = 1;
                                            $j = 1;
                                            $totalforms =0;
                                            $nq = "SELECT MIN(nv.gp_id ) AS gram_panchayat_id , gp.gram_panchayat_name
                                            FROM new_vacancy nv
                                            JOIN gram_panchayat gp ON nv.gp_id  = gp.id
                                            WHERE nv.district_id = '".$_SESSION['distid']."'
                                            AND nv.project_id = '".$_GET['pid']."'
                                            
                                            AND nv.is_old = '1'
                                            GROUP BY nv.gp_id,gp.gram_panchayat_name 
                                            ORDER BY gp.gram_panchayat_name
                                            ";
                                            $stmt =execute_query($nq);
                                          
                                            $numRows = mysqli_num_rows($stmt);
                                            if($numRows > 0){
                                              
                                            $cen=1;
                                            while ($ndata =mysqli_fetch_assoc($stmt)) {
                                               
                                                echo '<tr style="background-color:#e4ffff;font-weight:600;font-size:18px;">
                                                        <td colspan="27"> Gram Panchyat/Ward - : ' . $ndata['gram_panchayat_name'] . '</td>
                                                    </tr>';
                                                $gramPanchyatId = $ndata['gram_panchayat_id'];
                                                $q = "SELECT nad.userid,nad.permanent_full_address,nad.permanent_full_address_pincode, nad.grameen_sehri,nv.awc_urban_rural,nad.pre_name,nad.nay_panchayat,
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
                                                d.niwash_v_status, d.id AS did, d.remarks, d.selection_status, nv.awc_name, nv.unique_code, nv.vacancy_available, nv.category,
                                             d.income_issue_date,d.created,pd.niwash_file,pd.jaati_upload,pd.aay_upload,pd.jaati,pd.varshik_aay,pd.aay_prmaanpatr_issue_date,nad.h_marksheet,pd.grampanchayatname,pd.aganvadi_center,d.final_selection
                                            FROM decleration d
                                            INNER JOIN new_application_details nad ON d.userid = nad.userid
                                            INNER JOIN personal_details pd ON nad.userid = pd.userid
                                            INNER JOIN academic_details ad ON ad.userid = pd.userid
                                            JOIN new_vacancy nv ON nv.id = d.aganwadi_center
                                            WHERE d.district_id = '".$_SESSION['distid']."' 
                                            AND d.project_id = '".$_GET['pid']."'
                                            AND d.gram_panchyat_id = '".$gramPanchyatId."'
                                           AND selection_status = 0 
                                             
                                            ORDER BY 
                                                d.aganwadi_center
                                              
                                               
                                            ";
                                           // echo  $q; 
                                                $res = execute_query($q);
                                                
                                                $r = mysqli_num_rows($res);
                                                $ucode='';
                                                $pre='';
                                                $num=1;
                                                while ($adata = mysqli_fetch_assoc($res)) {

                                                    if ($adata['final_selection'] == '1') {
                                                        $sbg = '#3CB371';
                                                    } else if ($adata['final_selection'] == '0') {
                                                        $sbg = '#ffb3b3';
                                                    } else {
                                                        $sbg = '';
                                                    }
                                                    $ucode=$adata['unique_code'];
                                                   
                                                    if($pre !=$ucode && $ucode !=''){
                                                        $num=1;
                                                        echo'<tr style="background-color:#FCB1DC"><td colspan="27"><b>'.$cen++.'. Center Name: </b>'. strtoupper($adata['awc_name']).' <b>Unique Code: </b> '.$adata['unique_code'].'('.$adata['awc_urban_rural'].') <b>Reserved For:</b>'.getCategoryText($adata['category']).'</td></tr>';
                                                    }
                                                 

                                                   
                                                        $baseurl="";
                                                    $awc_name = isset($adata['awc_name']) ? strtoupper($adata['awc_name']) : 'N/A';
                                                    if($adata['nay_panchayat'] ==''){
                                                        $np='';
                                                      }else{
                                                        $np='<br><b>NP:</b>'.$adata['nay_panchayat'];
                                                      } 


                                                    echo ' <tr style="background-color:' . $sbg . '">
                                                    
                                                            <td><b>'.$num++.'.</b> '  . $adata['application_no'] . '<br>'.getcolocated($adata['awc_urban_rural']).'</td>';
                                                    echo '<td><b>G.P./Ward: </b>' . strtoupper($ndata['gram_panchayat_name']) . $np. '<br><b>Center:</b> ' . $awc_name . '<br>' . $adata['unique_code'] . '
                                                    <br><b>Address:</b>'.$adata['permanent_full_address'].',' .$adata['permanent_full_address_pincode'].'
                                                    </td>';
                                                   
                                                    // echo '<td>' . $awc_name . '<br>' . $adata['unique_code'] . '</td>';
                                                   
                                                  
                                                    echo '<td><b>Name: </b>'. $adata['name_hi'] . '<br>' . $adata['name_en'] . '
                                                    <br><b>F:</b>'.$adata['fname'].'
                                                   <br><b> M:</b>'.$adata['mname'].'
                                                   <br><b> H:</b>'.$adata['hname'].'
                                                   <br><b> Cat:</b>'.getCategoryText($adata['cast']).'

                                                    </td>
                                                    ';
                                                   

                                                    // echo'<td>' . $adata['fname'] . '</td>
                                                    //         <td>' . $adata['mname'] . '</td>
                                                    //         <td>' . $adata['hname'] . '</td>
                                                    //         <td>' . $adata['mobile'] . '</td>
                                                    //         <td>' . $adata['date_of_birth'] . '</td>';
                                                    // echo '<td>Years:' . $adata['age_years'] . '<br> Months:' . $adata['age_months'] . '<br>Days:' . $adata['age_days'] . '</td>
                                                    //       ';
$catstatus='';
                                                    echo '<td><b>Mob:</b>' .  $adata['mobile'].'
                                                            <br><b>DOB:</b>'.date("d-m-Y",strtotime($adata['date_of_birth'])).'
                                                            <br><a href="'.$baseurl.'' . $adata['h_marksheet'] . '" target="_blank">H. Marksheet</a>
                                                    
                                                    </td>';
                                                    

                                                    echo '<td>' . $adata['nivas_avedan_prmanpatr'] . '<br>' . $adata['nivas_prmaanpatr_no'].'
                                                    <br>
                                                    <b>AWC:</b>'.$adata['aganvadi_center'].'<br>
                                                    <b>GP/Ward:</b>'.$adata['grampanchayatname'].'<br>
                                                    
                                                    <a target="_blank" href="'.$adata['niwash_file'].'">Uploaded Doc</a></td>';
                                                   
                                                  
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
                                                    // if ($adata['vidhwa_certificateno'] != '') {
                                                    //     echo '<td>' . $adata['vidhwa_certificateno'] . '<br>Jarikrta-' . $adata['v_jarikrta_name'] . '<br><a href="'.$baseurl.''.$adata['v_uploaddata'].'" target="_blank">View </a></td>';
                                                    // } else {
                                                    //     echo '<td>NA</td>';
                                                    // }

                                                    // echo '<td><a href="'.$baseurl.'' . $adata['h_marksheetdoc'] . '" target="_blank">H. Marksheet</a><br> <a href="'.$baseurl.'' . $adata['h_otherdoc'] . '" target="_blank">H. Other Doc</a> </td>';

                                                    echo '<td>' . $adata['i_totalmarks'] . '/' . $adata['i_maxmarks'] . '<br>' . $adata['i_present'] . '%<br><a href="'.$baseurl.'' . $adata['i_marksheetdoc'] . '" target="_blank">Marksheet</a> <a href="'.$baseurl.'' . $adata['i_otherdoc'] . '" target="_blank">Other Doc</a> </td>';

                                                    if ($adata['g_present'] != '' || $adata['g_totalmarks'] !='') {
                                                        echo '<td>' . $adata['g_totalmarks'] . '/' . $adata['g_maxmarks'] . '<br>' . $adata['g_present'] . '%<br><a href="'.$baseurl.'' . $adata['g_marksheetdoc'] . '"  target="_blank">Marksheet</a> <a  href="'.$baseurl.'' . $adata['g_otherdoc'] . '"  target="_blank">Other Doc</a> </td>';
                                                    } else {
                                                        echo '<td>NA</td>';
                                                    }
                                                    if ($adata['pg_present'] != '' || $adata['pg_present'] !='') {
                                                        echo '<td>' . $adata['pg_totalmarks'] . '/' . $adata['pg_maxmarks'] . '<br>' . $adata['pg_present'] . '%<br><a href="'.$baseurl.'' . $adata['pg_marksheetdoc'] . '" target="_blank">Marksheet</a> <a href="'.$baseurl.'' . $adata['pg_otherdoc'] . '"  target="_blank">Other Doc</a> </td>
                                                            ';
                                                    } else {
                                                        echo '<td>NA</td>';
                                                    }

                                                    if ($adata['avedika_status'] == '1') {
                                                        echo '<td>
                                                                <div class="tooltip-inner bgcolor-1"> 
                                                                ' . getCurrentsituation($adata['avedika_status']) . '
                                                            </div>
                                                            ' . $adata['vidhwa_certificateno'] . '<br>Jarikrta-' . $adata['v_jarikrta_name'] . '<br><a href="'.$baseurl.''.$adata['v_uploaddata'].'" target="_blank">View </a></td>';
                                                    } else if ($adata['avedika_status'] == '2') {
                                                        echo '<td> <div class="tooltip-inner bgcolor-2">' . getCurrentsituation($adata['avedika_status']) . '</div>' . $adata['vidhwa_certificateno'] . '<br>Jarikrta-' . $adata['v_jarikrta_name'] . '<br><a href="'.$baseurl.''.$adata['v_uploaddata'].'" target="_blank">View </a></td>';
                                                    } else {
                                                        echo '<td><div class="tooltip-inner color-3">' . getCurrentsituation($adata['avedika_status']) . '</div></td>';
                                                    }

                                                    echo '<td>' . $adata['merit'] . '</td>
                                                         <td><a href="viewallfiles.php?id='.$adata['userid'].'" target="_blank">View All Doc</a><br><br><a href="../users/adminformview.php?appNo='. $adata['application_no'].'" target="_blank">View Form</a><br><br><a href="pdf-generator.php?dir='.$adata['userid'].'&appNo='. $adata['application_no'].'" target="_blank">Download DOC(PDF)</a></td>
                                                                    <td><textarea class="form-control" name="reason" id="reason_' . $adata['did'] . '" style="border:2px solid black;width:160px;">' . $adata['remarks'] . '</textarea></td>
                                                                    
                                                        </tr>';
                                                        $pre=$adata['unique_code'];
                                                        $totalforms++;
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
                    //alert(did);
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
                                selectedreasonfinal: reason,
                                finalMarkid: did,
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