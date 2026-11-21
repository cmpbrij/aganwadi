<?php
include 'master.php';
ob_start();

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

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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
        <h3>Anganwadi Recruitment 2025</h3>
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
                <?php echo getdistName($_SESSION['distid']); ?> &nbsp;&nbsp;
                <b>Project</b> : 
                <span class="fw-normal"><?php echo getBlockname($_GET['pid']); ?></span>
            </span>
        </div>
        </div>
        <div class="">
            <table class="styled-table">
                <thead style="background-color: #CCC;">
                    <tr>
                        <th>Application No.</th>
                        <th>Aganwadi Center</th>
                        <th>AWC & G.P./Ward & add</th>               
                        
                        
                        <th>Applicant Details</th>
                       
                        <th>Mobile No. & DOB</th>
                        <th >Residency Application No.<br> & CertificateID </th>
                        <th >Cast Application No. <br>& CertificateID </th>
                        <th>Income Application No.<br> & CertificateID</th>
                         <th>Current<br> Status</th>
                         <th>Intermediate</th>
                        <th>Graduation</th>
                        <th>Post Graduation</th>
                        <th>Merit</th>
                        <th>Remarks</th>
                      
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
                    
                    $center=1;
                    $nq = "SELECT id,unique_code,COALESCE(NULLIF(TRIM(nv.gp_name), ''), nv.ward_name) AS gp_or_ward_name,awc_urban_rural,category
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
                        $sno=1;
                       
                        echo '<tr style="background-color:#e4ffff;font-weight:600;font-size:18px;">
                                                        <td colspan="27">Center Code: '.$ndata['unique_code'].' Grampanchyat/Ward: ' . $ndata['gp_or_ward_name'] . '('.$ndata['awc_urban_rural'].') <b> Reserved For: </b>'.getCategoryText($ndata['category']).'</td>
                                                    </tr>';
                                                
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
                                                d.niwash_v_status, d.id AS did, d.remarks, d.selection_status, nv.awc_name, nv.unique_code, nv.vacancy_available, nv.category,  
                                                d.income_issue_date,d.created,pd.varshik_aay,nad.permanent_full_address,pd.grampanchayatname,pd.jaati,pd.aay_prmaanpatr_issue_date
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
                                                    
                                <td><b>'.$num++.'.</b> '  . $adata['application_no'] . '<br>'.getcolocated($adata['awc_urban_rural']).'</td>';

                                  echo '<td>' . strtoupper($adata['awc_name']) . '<br>' . $adata['unique_code'] . '<br></td>';
                                  
                                  echo '<td><b>G.P./Ward-</b>' . $ndata['gp_or_ward_name'] . '<br><b>N.P.-</b>' . $adata['nay_panchayat'] . '<br><b>add:</b>'.$adata['permanent_full_address'].'</td>';
                          
                           
                            echo '<td>'.strtoupper($adata['name_en']) .'('.$adata['name_hi'].')<br>'.getCategoryText($adata['cast']).'<br><b>F: </b>' . strtoupper($adata['fname']) . '<br><b>M: </b> 
                                ' . strtoupper($adata['mname']) . '<br><b>H: </b>'.strtoupper($adata['hname']).'</td>
                              
                                 <td>Mob: ' . strtoupper($adata['mobile']) . '<br> DOB: ' . date('d-m-Y',strtotime($adata['date_of_birth'])) . '</td>';
                            // echo '<td>Years:' . $adata['age_years'] . '<br> Months:' . $adata['age_months'] . '<br>Days:' . $adata['age_days'] . '</td>
                            //       ';

                         
                            
                            echo '<td>' . $adata['nivas_avedan_prmanpatr'] . '<br>' . $adata['nivas_prmaanpatr_no'].'
                            <br><b>GP/Ward:</b>'.$adata['grampanchayatname'].'</td>';
                            

                         
                            if ($adata['jaati_avedan_prmanpatr'] != '') {
                                echo '<td>'. trim($adata['jaati_avedan_prmanpatr']) . '<br>' . trim($adata['jaant_prmaanpatr_no']) .'<br>
                                <b>Cast:</b> '.$adata['jaati'].'</td>';
                                
                            } else {
                                echo '<td>NA</td>';
                            }
                           
                            if ($adata['aay_avedan_prmanpatr'] != '') {
                                echo '<td>' . $adata['aay_avedan_prmanpatr'] . '<br>' . $adata['aay_prmaanpatr_no'].'
                                Income:'.$adata['varshik_aay'].'
                                Issue Date:'.date('d-m-Y',strtotime($adata['aay_prmaanpatr_issue_date'])).'
                                </td>';
                              
                            } else {
                                echo '<td>NA</td>';
                            }

                            if ($adata['avedika_status'] == 1) {
                                echo '<td>
                                    <div class="tooltip-inner bgcolor-1"> 
                                    ' . getCurrentsituation($adata['avedika_status']) . '
                               
                            
                                     </div><br>DRL No.:' . $adata['drl_no'] . '-' . $adata['death_date'] . '<br>' . $adata['death_person_name'] . '<br></td>';
                            } else if ($adata['avedika_status'] == 2) {
                                echo '<td> ' . getCurrentsituation($adata['avedika_status']) . '</td>';
                            } else {
                                echo '<td><div class="tooltip-inner color-3">' . getCurrentsituation($adata['avedika_status']) . '</div></td>';
                            }

                            echo '<td>' . $adata['i_totalmarks'] . '/' . $adata['i_maxmarks'] . '<br>' . $adata['i_present'] . ' </td>';

                            if ($adata['g_maxmarks'] != '' || $adata['g_present'] !='') {
                                echo '<td>' . $adata['g_totalmarks'] . '/' . $adata['g_maxmarks'] . '<br>' . $adata['g_present'] . '%<br>  </td>';
                            } else {
                                echo '<td>NA</td>';
                            }
                            if ($adata['pg_maxmarks'] != '' || $adata['pg_present'] !='') {
                                echo '<td>' . $adata['pg_totalmarks'] . '/' . $adata['pg_maxmarks'] . '<br>' . $adata['pg_present'] . '%<br> </td>
                                    ';
                            } else {
                                echo '<td>NA</td>';
                            }
                           

                            echo '<td>' . $adata['merit'] . '</td>';
                            
                                        
                    echo'<td> </td></tr>';
                    $pre=$adata['unique_code'];
                        }
                    }
                }



                    ?>
                </tbody>
            </table>
            <div style="display:flex;justify-content:space-around;margin-top:50px;margin-bottom:50px;">
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