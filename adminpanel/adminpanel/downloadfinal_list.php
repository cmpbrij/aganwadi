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

    .printable-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 12px; /* Adjust font size as needed */
    }

    .printable-table th, .printable-table td {
        border: 1px solid #000;
        padding: 8px;
        text-align: left;
    }

    .printable-table th {
        background-color: #f2f2f2;
    }

    .printable-table td {
        word-wrap: break-word;
    }

    @page {
        size: A4 landscape; /* Or A4 portrait if you prefer */
        margin: 20mm; /* Adjust margins as needed */
    }
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
            @page {
                size: A4 !important;
                margin: 10px;
            }

            table * {
                font-size: 11px !important;
                max-width: 100px;
            }
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
    font-size: 14px;
    margin: 20px 0;
    border: 1px solid #ddd;
}

/* Table Header Styling */
.styled-table thead {
    background-color: #f4f4f4;
}

.styled-table th {
    padding: 12px;
    text-align: center;
    border-bottom: 2px solid #ddd;
    font-weight: bold;
}

/* Table Row Styling */
.styled-table tbody tr {
    border-bottom: 4px solid #ddd;
}

/* Alternating Row Colors */
.styled-table tbody tr:nth-of-type(even) {
    background-color: #f9f9f9;
}

.styled-table td{
    border: 2px solid #CCC;
}

.styled-table tr{
    padding:10px;
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
        <b>District</b> 
        <span class="fw-normal">
            <?php echo getdistName($data['district_id']); ?> &nbsp;&nbsp;
            <b>Project</b> : 
            <span class="fw-normal"><?php echo getProjectname($_GET['pid']); ?></span>
        </span>
    </div>
    <div class="logo">
        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Seal_of_Uttar_Pradesh.svg/200px-Seal_of_Uttar_Pradesh.svg.png" alt="Seal of Uttar Pradesh" width="20%">
    </div>
</div>


        <div class="print-button">
            <button onclick="window.print()">Print</button>
        </div>
        <div > <b>Date & Time: </b><?php echo date("d-m-Y H:i:s"); ?></div>
        <div class="">
            <table class="styled-table">
                <thead style="background-color: #CCC;">
                    <tr>
                        <th>Application No.</th>
                        <th>Aganwadi Center</th>
                        <th>Applicant Name</th>
                        <th>Father</th>
                        <th>Mother</th>
                        <th>Husband</th>
                        <th>Mobile No.</th>
                        <th>Category</th>
                        <th>Address</th>
                       
                    </tr>
                </thead>
                <tbody>
                    <?php
                   
                     $districtId = $_SESSION['distid'];
                     $projectId = $_GET['pid'];
                     $i = 1;
                     $j = 1;
                     $nq = "SELECT DISTINCT d.gram_panchyat_id,gram_panchayat_name FROM decleration d JOIN gram_panchayat gp ON d.gram_panchyat_id=gp.id WHERE d.district_id = '".$districtId."' AND d.project_id = '".$projectId."'  AND d.selection_status = '1' order by gram_panchayat_name";
                  
                     $r=execute_query($nq);
                    //  $stmt = $conn->prepare($nq);
                    //  $stmt->bind_param("ssi", $districtId, $projectId,1);
                    //  $stmt->execute();
                   
                     while ($ndata = mysqli_fetch_assoc($r)) {
                         echo '<tr style="background-color:#e4ffff;font-weight:600;font-size:18px;">
                                 <td colspan="24"> Gram Panchyat/Ward - : ' . $ndata['gram_panchayat_name'] . '</td>
                             </tr>';
                         $gramPanchyatId = $ndata['gram_panchyat_id'];
                         $q = "SELECT nad.userid, nad.pre_name,
                                nad.gram_panchayat, nad.name_hi, nad.name_en, nad.rikt_aww_center, nad.date_of_birth,
                                nad.fname, nad.mname, nad.hname, nad.mobile, 
                                pd.category AS cast, pd.sub_category, pd.avedika_status, 
                                ad.i_present, ad.g_present, ad.pg_present, ad.merit,
                                d.application_no, d.aganwadi_center
                                FROM decleration d
                                INNER JOIN new_application_details nad ON d.userid = nad.userid
                                INNER JOIN personal_details pd ON nad.userid = pd.userid
                                INNER JOIN academic_details ad ON ad.userid = pd.userid
                                LEFT JOIN new_vacancy nv ON nv.id = d.aganwadi_center
                                WHERE d.district_id = '".$districtId."'
                                AND d.project_id = '".$projectId."' 
                                AND d.gram_panchyat_id = '".$gramPanchyatId."'
                                AND d.selection_status = '1'
                                ORDER BY  nad.name_en";
                               // echo $q;
                                $res=execute_query($q);
                        // $stmt = $conn->prepare($q);
                        // $stmt->bind_param("sssi", $districtId, $projectId, $gramPanchyatId,1);
                        // $stmt->execute();
                       // $r = $stmt->get_result();
                      
                        while ($adata = mysqli_fetch_assoc($res)) {
                            echo ' <tr>
                                <td>' . $adata['application_no'] . '</td>';
                            echo '<td>' . strtoupper($adata['awc_name']) . '<br>' . $adata['unique_code'] . '<br></td>';
                            echo '<td>'.getPrename($adata['pre_name']).' '. $adata['name_hi'] . '<br>' . $adata['name_en'] . '
                                <td>' . strtoupper($adata['fname']) . '</td><td> 
                                ' . strtoupper($adata['mname']) . '</td>
                                <td>' . strtoupper($adata['hname']) . '</td>
                                 <td>' . strtoupper($adata['mobile']) . '</td>';
                          
                            echo '<td>' . getCategoryText($adata['cast']) . '</td>';
                            echo'<td></td>';
                                        
                    echo'</tr>';
                     }
                    
                    }



                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>