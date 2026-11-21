<?php
include 'master.php';
ob_start();

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
                    <h4 class="card-title">Provisional Broadsheet - <?php echo getdistName($data['district_id']); ?> - <?php echo getProjectname($_GET['pid']); ?></h4>

                    <span style="fornt-size:18px;"><a href="pdf.php?id=<?php echo $_GET['pid']; ?>">Download PDF</a></span> &nbsp;  &nbsp;  &nbsp; &nbsp; &nbsp; &nbsp;
                    <!-- <span><a href="excelexport.php?id=<?php echo $data['district_id']; ?>">EXCEL</a></span> -->
                    <span style="fornt-size:18px;"><a href="htmlpage.php?pid=<?php echo $_GET['pid']; ?>">Download Wide</a></span>

                    <div class=" row">
                        <div class="col-12">
                            <div class="card">

                                <div class="fixTableHead">
                                    <table class="table" id="">
                                        <thead style="background-color: #CCC;">
                                            <tr>

                                                <th>Application No.</th>
                                                <th>Aganwadi Center</th>
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
                                                <th>Residency Application No. & CertificateID & View</th>
                                                <th>Cast Application No. & CertificateID & View</th>
                                                <th>Income Application No. & CertificateID & View</th>
                                                <th>Handicapped Application No. & CertificateID</th>


                                                <th>Widow Details</th>

                                                <th>Intermediate</th>
                                                <th>Graduation</th>
                                                <th>Post Graduation</th>
                                                <th>Current Status</th>
                                                <th>BPL</th>
                                                <th>Reserved & EWS Info</th>
                                                <th>Merit</th>
                                                <th>Reject Reason</th>
                                                <th width="120px">Action</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $districtId = $_SESSION['distid'];
                                            $projectId = $_GET['pid'];

                                            $i = 1;

                                            $j = 1;

                                            $nq = "SELECT DISTINCT d.gram_panchyat_id,gram_panchayat_name FROM decleration d JOIN gram_panchayat gp ON d.gram_panchyat_id=gp.id WHERE d.district_id = ? AND d.project_id = ?";
                                            $stmt = $conn->prepare($nq);
                                            $stmt->bind_param("ss", $districtId, $projectId);
                                            $stmt->execute();
                                            $nres = $stmt->get_result();

                                            while ($ndata = $nres->fetch_assoc()) {
                                                echo '<tr style="background-color:#e4ffff;font-weight:600;font-size:18px;">
                                                                <td colspan="24"> Gram Panchyat/Ward - : ' . $ndata['gram_panchayat_name'] . '</td>
                                                            </tr>';

                                                $gramPanchyatId = $ndata['gram_panchyat_id'];

                                                $q = "SELECT nad.userid,nad.grameen_sehri,
                                                                    nad.gram_panchayat, nad.pre_name, nad.name_hi, nad.name_en, nad.rikt_aww_center,nad.date_of_birth,
                                                                    nad.fname, nad.mname, nad.hname, nad.mobile, nad.age_years, nad.age_months, nad.age_days, 
                                                                    pd.category as cast, pd.sub_category, pd.avedika_status, pd.bpl_card, 
                                                                    ad.i_present, ad.g_present, ad.pg_present, ad.merit, 
                                                                    d.application_no, d.aganwadi_center
                                                                    ,pd.drl_no,pd.death_date,pd.death_person_name,
                                                                    pd.divangta_pramnpatr_kramank,pd.divangta_avedan_krmank,
                                                                    pd.f_senani_sambandh,pd.f_senani_prmanptr,
                                                                    pd.avedika_status,pd.vidhwa_certificateno,
                                                                    pd.nivas_prmaanpatr_no,pd.nivas_avedan_prmanpatr,
                                                                    pd.nivas_upload,pd.jaant_prmaanpatr_no,pd.jaati_avedan_prmanpatr,pd.jaati_upload,pd.aay_prmaanpatr_no,pd.aay_avedan_prmanpatr,pd.aay_upload, ad.i_school,ad.i_board,ad.i_year,ad.i_maxmarks,ad.i_totalmarks,ad.i_present,ad.g_present,ad.pg_present,pd.v_jarikrta_name,pd.v_uploaddata,ad.i_marksheetdoc,ad.i_otherdoc,ad.g_totalmarks,ad.g_maxmarks,ad.g_present,ad.g_marksheetdoc,ad.g_otherdoc,ad.pg_totalmarks,ad.pg_maxmarks,ad.pg_marksheetdoc,ad.pg_otherdoc,d.niwash_v_status,d.id as did, d.remarks,d.selection_status,nv.awc_name,nv.unique_code,nv.vacancy_available,nv.category,nv.ews,d.income_v_status,d.cast_v_status
                                                                FROM 
                                                                    decleration d
                                                                INNER JOIN 
                                                                    new_application_details nad ON d.userid = nad.userid
                                                                INNER JOIN 
                                                                    personal_details pd ON nad.userid = pd.userid
                                                                INNER JOIN 
                                                                    academic_details ad ON ad.userid = pd.userid

                                                                Left JOIN new_vacancy nv ON nv.id=d.aganwadi_center
                                                                WHERE 
                                                                d.district_id = ? AND 
                                                                d.project_id = ? AND
                                                                d.gram_panchyat_id = ?
                                                            ORDER BY 
                                                            CASE 
                                                                WHEN CAST(nad.age_years AS UNSIGNED) >= 35 OR CAST(nad.age_years AS UNSIGNED) <= 18 THEN 1 
                                                                    ELSE 0 
                                                            END ASC,
                                                            nv.awc_name IS NULL ASC, 
                                                            d.niwash_v_status DESC,
                                                            CASE 
                                                                WHEN nad.grameen_sehri = 1 AND CAST(d.income_v_status AS UNSIGNED) < 60000 THEN 1
                                                                WHEN nad.grameen_sehri = 2 AND CAST(d.income_v_status AS UNSIGNED) < 720000 THEN 1
                                                                ELSE 0
                                                            END DESC, 
                                                            CASE
                                                                     WHEN nv.ews = 1 AND pd.category = 5 THEN 1 
                                                                        ELSE 0
                                                                    END DESC,
                                                            CASE 
                                                                    WHEN pd.avedika_status != 3 THEN 1 
                                                                    ELSE 0 
                                                                END DESC,
                                                                
                                                            CASE 
                                                                    WHEN nv.category = pd.category THEN 1 
                                                                    ELSE NULL 
                                                            END DESC,
                                                                pd.bpl_card DESC, 
                                                                pd.sub_category ASC, 
                                                                CAST(ad.merit AS DECIMAL(5,3)) DESC, 
                                                                CAST(nad.age_years AS UNSIGNED) DESC,
                                                                CAST(nad.age_months AS UNSIGNED) DESC,
                                                                CAST(nad.age_days AS UNSIGNED) DESC";

                                                                // 

                                                $stmt = $conn->prepare($q);
                                                $stmt->bind_param("sss", $districtId, $projectId, $gramPanchyatId);
                                                $stmt->execute();
                                                $r = $stmt->get_result();

                                                while ($adata = $r->fetch_assoc()) {
                                                    if ($adata['selection_status'] == 1) {
                                                        $sbg = '#3CB371';
                                                    } else if ($adata['selection_status'] == 2) {
                                                        $sbg = '#ffb3b3';
                                                    } else {
                                                        $sbg = '';
                                                    }
                                                    // echo $sbg; continue;
                                                    // print_r($adata); die;
                                                    echo ' <tr style="background-color:' . $sbg . '">
                                                    
                                                            <td>' . $adata['application_no'] . '</td>';
                                                    echo '<td>' . strtoupper($adata['awc_name']) . '<br>' . $adata['unique_code'] . '<br><span style="color:red">' . $adata['vacancy_available'] . '</sapn></td>';
                                                    echo '<td>' . $adata['name_hi'] . '<br>' . $adata['name_en'] . '</td>
                                                            <td>' . strtoupper($adata['fname']) . '</td>
                                                            <td>' . strtoupper($adata['mname']) . '</td>
                                                            <td>' . strtoupper($adata['hname']) . '</td>
                                                            <td>' . $adata['mobile'] . '</td>
                                                            <td>' . $adata['date_of_birth'] . '</td>';
                                                    // echo '<td>Years:' . $adata['age_years'] . '<br> Months:' . $adata['age_months'] . '<br>Days:' . $adata['age_days'] . '</td>
                                                    //       ';

                                                    echo '<td>' . getCategoryText($adata['cast']) . '</td>';
                                                    if ($catstatus == 1) {
                                                        echo  '<td>' . getSubcategoryText($adata['sub_category']) . '</td>';
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
                                                        echo '<td>' . $adata['aay_avedan_prmanpatr'] . '<br>' . $adata['aay_prmaanpatr_no'] . '<br>';
                                                        //<a href="'.$adata['aay_upload'].'">View</a>
                                                        if ($adata['income_v_status'] != '' && $adata['income_v_status'] != 0) {
                                                            echo '<div class="tooltip-inner bg-success">Verified- ₹' . $adata['income_v_status'] . '</div></td>';
                                                        } else {
                                                            echo '<div class="tooltip-inner bg-danger">Not Verified</div></td>';
                                                        }
                                                    } else {
                                                        echo '<td>NA</td>';
                                                    }
                                                    if ($adata['divangta_pramnpatr_kramank'] != '') {
                                                        echo '<td>' . $adata['divangta_pramnpatr_kramank'] . '<br>' . $adata['divangta_avedan_krmank'] . '</td>';
                                                    } else {
                                                        echo '<td>NA</td>';
                                                    }

                                                    if ($adata['drl_no'] != '') {
                                                        echo '<td>DRL No.:' . $adata['drl_no'] . '-' . $adata['death_date'] . '<br>' . $adata['death_person_name'] . '<br>' . $adata['v_jarikrta_name'] . '<br><a href="' . $adata['v_uploaddata'] . '">View</a></td>';
                                                    } else {
                                                        echo '<td>NA</td>';
                                                    }



                                                    echo '<td>' . $adata['i_totalmarks'] . '/' . $adata['i_maxmarks'] . '<br>' . $adata['i_present'] . '%<br><a href="' . $adata['i_marksheetdoc'] . '">Marksheet</a> <a href="' . $adata['i_otherdoc'] . '">Other Doc</a> </td>';

                                                    if ($adata['g_maxmarks'] != '') {

                                                        echo '<td>' . $adata['g_totalmarks'] . '/' . $adata['g_maxmarks'] . '<br>' . $adata['g_present'] . '%<br><a href="' . $adata['g_marksheetdoc'] . '"  target="_blank">Marksheet</a> <a  href="' . $adata['g_otherdoc'] . '"  target="_blank">Other Doc</a> </td>';
                                                    } else {
                                                        echo '<td>NA</td>';
                                                    }
                                                    if ($adata['pg_maxmarks'] != '') {

                                                        echo '<td>' . $adata['pg_totalmarks'] . '/' . $adata['pg_maxmarks'] . '<br>' . $adata['pg_present'] . '%<br><a href="' . $adata['pg_marksheetdoc'] . '" target="_blank">Marksheet</a> <a href="' . $adata['pg_otherdoc'] . '"  target="_blank">Other Doc</a> </td>
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

                                                    if ($adata['bpl_card'] == '1') {
                                                        echo '<td><div class="tooltip-inner bgcolor-4">BPL</div></td>';
                                                    } else {
                                                        echo '<td>
                                                                <div class="tooltip-inner bgcolor-5">NON-BPL</div>
                                                                </td>';
                                                    }
                                                    echo '<td><b>Reserved For: </b>' . getCategoryText(getCategoryText($adata['category'])) . '<br><b>EWS: </b>' .  getewsText($adata['ews']) . '</td>';


                                                    echo '<td>' . $adata['merit'] . '</td>
                                                                    <td><textarea class="form-control" name="reason" id="reason_' . $adata['did'] . '" style="border:2px solid black;width:160px;">' . $adata['remarks'] . '</textarea></td><td>
                                                                    <select class="form-control" id="cselected_' . $adata['did'] . '" style="width:120px;border:2px solid red;">
                                                                        <option value="">Please select</option>
                                                                        <option value="1"' . ($adata['selection_status'] == 1 ? ' selected' : '') . ' > Selected</option>
                                                                        <option value="0" ' . ($adata['selection_status'] == 0 ? ' selected' : '') . '>Not Selected</option>
                                                                    </select><br>
                                                                    <button class="btn btn-primary" id="save" data-did="' . $adata['did'] . '" ' . ($adata['selection_status'] != '' ? 'disabled' : '') . ' >Save</button>

                                                                    </td>
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


        <script>
            $(document).ready(function() {
                $(document).on('click', '#save', function() {
                    var did = $(this).data('did');
                    alert(did);
                    var res = 'reason_' + did;
                    var reason = $('#reason_' + did).val();
                    var selectval = $(this).val();

                    if (reason == '') {
                        swal("Warning!", "Please text select/reject reason!", "warning")
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
                                // swal("Success!", "OTP Send on registred mobile number!", "Success") ;
                                swal("Success!", "Data saved", "success")
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
        </script>