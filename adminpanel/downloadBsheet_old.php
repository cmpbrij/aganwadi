<?php
include 'master.php';
ob_start();
error_reporting(0);

if (!checkLogin()) {
    header('Location: login.php');
    exit;
}

if (isset($_SESSION['adminid'])) {
    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['sid']);
    $stmt->execute();
    $res = $stmt->get_result();
    $data = $res->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Broadsheet-ICDS</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> -->
    <style>
     @media print {
    body {
        margin: 0;
        padding: 0;
    }

    

    .printable-table th, .printable-table td {
        border: 1px solid #000;
        padding: 6px;
        text-align: left;
    }

    .printable-table th {
        background-color: #f2f2f2;
    }

    /* .printable-table td {
        word-wrap: break-word;
    } */

    
}


        .print-button {
            margin: 20px 0;
            text-align: center;
        }

        .print-button button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .print-button button:hover {
            background-color: #0056b3;
        }

        .row img {
            height: 100px;
        }

        

        @media print {
            .print-button {
                display: none;
            }
        }

        body {
    font-family: Arial, sans-serif;
}

.row {
    display: flex;
    margin-top: 20px;
    justify-content: space-between;
    align-items: center;
}

.logo {
    width: 30%;
    text-align: center;
}

.logo img {
    max-width: 100%;
    height: auto;
}

.content {
    width: 40%;
    text-align: center;
}

h3, h4 {
    margin: 10px 0;
}

p {
    margin: 5px 0;
}

.fw-normal {
    font-weight: normal;
}


.styled-table {
    width: 100%;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
    font-size: 10px;
    margin: 18px 0;
    border: 1px solid #ddd;
}

/* Table Header Styling */
.styled-table thead {
    background-color: #f4f4f4;
}

.styled-table th {
    padding: 9px;
    text-align: center;
    border-bottom: 2px solid #ddd;
    font-weight: bold;
}


/* Table Row Styling */
.styled-table tbody tr {
    border-bottom: 2px solid #ddd;
}

/* Alternating Row Colors */
.styled-table tbody tr:nth-of-type(even) {
    background-color: #f9f9f9;
}

.styled-table td{
    border: 2px solid #CCC;
    padding: 1px 2px;
}

.styled-table tr{
    padding:6px;
}



    </style>
</head>

<body>
    <div class="a3-landscape">
      
    <div class="row mt-3">
    <div class="logo">
        <img src="https://upanganwadibharti.in/assets/img/icds.png" alt="ICDS Logo" width="20%">
    </div> 
    <div class="content text-center">
        <h3>Anganwadi Recruitment 2024</h3>
        <p>Government of Uttar Pradesh</p>
        <h4>Provisional Broadsheet</h4>
        
    </div>
     <div class="logo">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Seal_of_Uttar_Pradesh.svg/200px-Seal_of_Uttar_Pradesh.svg.png" alt="Seal of Uttar Pradesh" width="20%">
    </div>
</div>


        <div class="print-button">
            <button onclick="window.print()">Print</button>
        </div>

        <div style="display:flex;align-items:center;justify-content:space-around">
        <div>
             <b>Date & Time: </b><?php echo date("d-m-Y H:i:s"); ?>
        </div>
        <div class="">
            <b>District: </b> 
            <span class="fw-normal">
                <?php echo getdistName($data['district_id']); ?> &nbsp;&nbsp;
                <b>Project</b> : 
                <span class="fw-normal"><?php echo getProjectname($_GET['pid']); ?></span>
            </span>
        </div>
        </div>
        <div class="">
            <table class="styled-table">
                <thead style="background-color: #CCC;">
                    <tr>
                        <th>Application No.</th>
                        <th>Aganwadi Center</th>
                        <th>Applicant Name</th>
                        <th>Parents</th>
                        <th>Husband Name</th>
                        <th>Mobile No. & DOB</th>
                        <th>Category/Sub category</th>
                        <th> Sub category details</th> 
                       

                        <th>Residency Application No. & CertificateID & View</th>
                        <th>Cast Application No. & CertificateID & View</th>
                        <th>Income Application No. & CertificateID & View</th>
                        
                         <th>Current Status</th>
                         <th>Intermediate</th>
                         
                        <th>Graduation</th>
                        <th>Post Graduation</th>
                        
                        <th>Merit</th>
                        <th>Reserved & EWS Info</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $districtId = $_SESSION['distid'];
                    $projectId = $_GET['pid'];

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
                        echo '<tr style="background-color:#e4ffff;font-weight:600;font-size:14px;padding:10px">
                                    <td colspan="19" style="padding:18px 13px;"> Gram Panchyat/Ward: ' . $ndata['gram_panchayat_name'] . '</td>
                                </tr>';



                        $gramPanchyatId = $ndata['gram_panchyat_id'];

                        $q = "SELECT nad.userid, nad.grameen_sehri,nad.pre_name,
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
                                                pd.v_jarikrta_name, pd.v_uploaddata, ad.i_marksheetdoc, ad.i_otherdoc, ad.g_totalmarks, ad.g_maxmarks, ad.g_present, ad.g_marksheetdoc, ad.g_otherdoc, 
                                                ad.pg_totalmarks, ad.pg_maxmarks, ad.pg_marksheetdoc, ad.pg_otherdoc, 
                                                d.niwash_v_status, d.id AS did, d.remarks, d.selection_status, nv.awc_name, nv.unique_code, nv.vacancy_available, nv.category, nv.ews, 
                                                d.income_v_status, d.cast_v_status
                                            FROM decleration d
                                            INNER JOIN new_application_details nad ON d.userid = nad.userid
                                            INNER JOIN personal_details pd ON nad.userid = pd.userid
                                            INNER JOIN academic_details ad ON ad.userid = pd.userid
                                            LEFT JOIN new_vacancy nv ON nv.id = d.aganwadi_center
                                            WHERE d.district_id = ? 
                                            AND d.project_id = ? 
                                            AND d.gram_panchyat_id = ?
                                            ORDER BY 
                                           d.aganwadi_center,
                                            nv.awc_name IS NULL ASC, 
                                            d.niwash_v_status IS NULL ASC,
                                            CASE 
                                                WHEN CAST(nad.age_years AS UNSIGNED) >= 35 OR CAST(nad.age_years AS UNSIGNED) <= 18 THEN 1 
                                                ELSE 0 
                                            END ASC,
                                           
                                           
                                            CASE
                                                WHEN nv.ews = 1 AND pd.category = 5 AND CAST(d.income_v_status AS UNSIGNED) < 800000 THEN 1
                                                ELSE 0
                                            END DESC,
                                            CASE 
                                            WHEN nv.category = pd.category   THEN 1  -- High priority when categories match
                                            ELSE 0  -- Low priority when they don't match
                                            END DESC,
                                            CASE 
                                                WHEN nv.category = pd.category AND pd.avedika_status != 3 THEN 1
                                                ELSE 0
                                            END DESC,
                                            CASE 
                                                WHEN nv.category = pd.category THEN 
                                                    CASE 
                                                    
                                                       WHEN d.cast_v_status IS NOT NULL THEN 1
                                                       WHEN d.verify_bpl = 1 THEN 2
                                                       WHEN pd.avedika_status != 3 THEN 3
                                                        WHEN pd.sub_category != 0  THEN 4
                                                        
                                                        ELSE 5
                                                    END 
                                                ELSE 
                                                    CASE 
                                                        WHEN d.verify_bpl = 1 THEN 2
                                                        WHEN pd.avedika_status != 3 THEN 3
                                                        WHEN pd.sub_category != 0  THEN 4

                                                        ELSE 5
                                                 END 
                                            END,
                                           
                                            CAST(ad.merit AS DECIMAL(5,3)) DESC,
                                            CAST(nad.age_years AS UNSIGNED) DESC,
                                            CAST(nad.age_months AS UNSIGNED) DESC,
                                            CAST(nad.age_days AS UNSIGNED) DESC ";

                        // 

                        $stmt = $conn->prepare($q);
                        $stmt->bind_param("sss", $districtId, $projectId, $gramPanchyatId);
                        $stmt->execute();
                        $r = $stmt->get_result();
                        $ucode='';
                        $pre='';
                        while ($adata = $r->fetch_assoc()) {
                            if ($adata['selection_status'] == 1) {
                                $sbg = '#3CB371';
                            } else if ($adata['selection_status'] == 2) {
                                $sbg = '#ffb3b3';
                            } else {
                                $sbg = '';
                            }
                            $ucode=$adata['unique_code'];
                                                   
                            if($pre !=$ucode && $ucode !=''){
                                echo'<tr style="background-color:#FCB1DC;"><td colspan="19" style="padding:13px;"><b>Center Name: </b>'. strtoupper($adata['awc_name']).' <b>Unique Code: </b> '.$adata['unique_code'].'</td></tr>';
                            }
                            // echo $sbg; continue;
                            // print_r($adata); die;
                            echo ' <tr style="background-color:' . $sbg . '">
                        
                                <td>' . $adata['application_no'] . '</td>';
                            echo '<td>' . strtoupper($adata['awc_name']) . '<br>' . $adata['unique_code'] . '<br></td>';
                            echo '<td>'.getPrename($adata['pre_name']).' '. $adata['name_hi'] . '<br>' . $adata['name_en'] . '
                                <td><b>F:</b>' . strtoupper($adata['fname']) . '<br><b>M:</b> 
                                ' . strtoupper($adata['mname']) . '</td>
                                <td>' . strtoupper($adata['hname']) . '</td>
                                 <td>Mob: ' . strtoupper($adata['mobile']) . '<br> DOB: ' . $adata['date_of_birth'] . '</td>';
                            // echo '<td>Years:' . $adata['age_years'] . '<br> Months:' . $adata['age_months'] . '<br>Days:' . $adata['age_days'] . '</td>
                            //       ';

                            echo '<td>' . getCategoryText($adata['cast']) . ' /<br> ' . getSubcategoryText($adata['sub_category']) . '</td>';
                            if ($adata['divangta_pramnpatr_kramank'] != '') {
                                echo '<td>' . $adata['divangta_pramnpatr_kramank'] . '<br>' . $adata['divangta_avedan_krmank'] . '</td>';
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
                            

                           

                            if ($adata['avedika_status'] == 1) {
                                echo '<td>
                                    <div class="tooltip-inner bgcolor-1"> 
                                    ' . getCurrentsituation($adata['avedika_status']) . '
                               
                            
                                     </div><br>DRL No.:' . $adata['drl_no'] . '-' . $adata['death_date'] . '<br>' . $adata['death_person_name'] . '<br></td>';
                            } else if ($adata['avedika_status'] == 2) {
                                echo '<td> <div class="tooltip-inner bgcolor-2">' . getCurrentsituation($adata['avedika_status']) . '</div></td>';
                            } else {
                                echo '<td><div class="tooltip-inner color-3">' . getCurrentsituation($adata['avedika_status']) . '</div></td>';
                            }

                            echo '<td>' . $adata['i_totalmarks'] . '/' . $adata['i_maxmarks'] . '<br>' . $adata['i_present'] . ' </td>';

                            if ($adata['g_maxmarks'] != '') {
                                echo '<td>' . $adata['g_totalmarks'] . '/' . $adata['g_maxmarks'] . '<br>' . $adata['g_present'] . '%<br>  </td>';
                            } else {
                                echo '<td>NA</td>';
                            }
                            if ($adata['pg_maxmarks'] != '') {
                                echo '<td>' . $adata['pg_totalmarks'] . '/' . $adata['pg_maxmarks'] . '<br>' . $adata['pg_present'] . '%<br> </td>
                                    ';
                            } else {
                                echo '<td>NA</td>';
                            }
                           

                            echo '<td>' . $adata['merit'] . '</td>';
                            echo '<td><b>Reserved For: </b>' . getCategoryText($adata['category']) . '<br><b>EWS: </b>' .  getewsText($adata['ews']) . '</td>';
                                        
                    echo'</tr>';
                    $pre=$adata['unique_code'];
                        }
                    }



                    ?>
                </tbody>
            </table>
            <div style="display:flex;justify-content:space-around;margin-top:50px;margin-bottom:100px;">
                <div>
                Authorized Signatory<br><br>
                .........................................
                </div>
                <div>
                    Stamp
                </div>
            </div>
        </div>
    </div>
</body>

</html>