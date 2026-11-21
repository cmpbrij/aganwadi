<?php
include('../config/db_config.php');
include('../config/settings.php');
if (!checkLogin()) {
    header('Location: login.php');
}
if (isset($_SESSION['uid'])) {
    $sql = "SELECT * FROM users WHERE `id`='" . $_SESSION['uid'] . "'";
    $res = $conn->query($sql);
    $data1 = mysqli_fetch_assoc($res);
}


if (isset($_SESSION['declearation'])) {
    $sql = "";
}
if (isset($_POST['finalSubmit'])) {
    echo "submit";
    die;
}
topheader();


$query = "SELECT  `date_of_birth`,pd.`category`, pd.`sub_category`,pd.death_date,pd.drl_no,pd.sports_details,nad.marital_status,pd.sub_category, pd.`divangta_avedan_krmank`, pd.`divangta_pramnpatr_kramank`,
pd.`percentage`,pd.`f_senani_sambandh`,pd.`f_senani_prmanptr`,pd.`avedika_status`,pd.`vidhwa_certificateno`,pd.`v_jarikrta_name`,pd.`v_uploaddata`,
pd.`nivas_prmaanpatr_no`, pd.`nivas_avedan_prmanpatr`,pd.`nivas_upload`,pd.`jaant_prmaanpatr_no`,pd.`jaati_avedan_prmanpatr`,
pd.`jaati_upload`, pd.`aay_prmaanpatr_no`, pd.`aay_avedan_prmanpatr`, pd.`aay_upload`,pd.`bpl_card`,
ad.`id` as academic_id, ad.`userid` as academic_userid, ad.`h_school`, ad.`i_school`, ad.`g_school`, ad.`h_board`,ad.`h_year`,ad.`h_maxmarks`,
ad.`h_totalmarks`,ad.`h_marksheetdoc`,ad.`h_otherdoc`,ad.`h_present`,ad.`i_board`,ad.`i_year`,ad.`i_maxmarks`,
ad.`i_totalmarks`, ad.`i_present`,ad.`g_board`,ad.`g_year`,ad.`g_maxmarks`,ad.`g_marksheetdoc`,ad.`g_otherdoc`,ad.`g_present`,ad.`g_totalmarks`,
nad.`id` as application_id, nad.`userid` as application_userid, nad.`district`, nad.`tehseel`, nad.`project`, nad.`grameen_sehri`
, nad.`gram_panchayat` , nad.`word_name`, nad.`nay_panchayat`, nad.`rikt_pd`, dd.`aganwadi_center`, nad.`name_hi`, nad.`pre_name`,nad.`year`,nad.`month`,nad.`day`
, nad.`name_en` ,  nad.`fname`, nad.`mname`, nad.`hname`, nad.`mobile`,ad.pg_board,ad.pg_school,ad.pg_year,ad.pg_maxmarks,ad.pg_totalmarks,ad.pg_present,dd.filled_date,dd.filled_date ,rikt_aww_center,nad.permanent_full_address,nad.permanent_full_address_pincode,dd.district_id
FROM 
`personal_details` pd
JOIN 
`academic_details` ad ON pd.`userid` = ad.`userid`
JOIN 
`new_application_details` nad ON pd.`userid` = nad.`userid`
JOIN 
`decleration` dd ON nad.`userid` = dd.`userid`
WHERE 
dd.`application_no` ='" . $_GET['appNo'] . "'";
//echo $query; die;
$res = $conn->query($query);
$data = mysqli_fetch_assoc($res);
//print_r($data); die;

$sql = "SELECT * FROM `uploaded_documents` WHERE userid='" . $_SESSION['uid'] . "'";
$row = execute_query($sql);
$udata = mysqli_fetch_array($row);




?>
<!doctype html>
<!-- <html lang="{{str_replace('_', '-', app()->getLocale())}}"> -->
<html>
<title>Application Form : Anganwadi Recruitment UP 2026</title>
<meta charset="utf-8">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.css" integrity="sha512-0TsYUclL0x2HXTMBHTQyrsFGsELlmYZRsmq8OG1SkV6V2lRzsZoFEddMf1dsqySJIegvLmrowaeiA9HNop2dXA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.min.css" integrity="sha512-gpqtQIgLIXYBimyliA0xmgme7m5coXHQhscvqhAZcOoPlKOmEzPg2BhYIYV/d39j7fEkXh42UeVt7g5PzUtfSg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<!-- <script src="
https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.all.min.js
"></script>
<link href="
https://cdn.jsdelivr.net/npm/sweetalert2@11.10.5/dist/sweetalert2.min.css
" rel="stylesheet"> -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="csrf-token" content="O9mUTOIwJ98dHE8ncyPuGeXHGQNe6Ctjpf9lCdBX" />
<link rel="shortcut icon" href="../public/images/favicon.png" />
<link href="../public/css/bootstrap.css" rel='stylesheet' />
<link href="../public/css/all.css" rel="stylesheet" />
<link href="../public/css/custom_theme_student.css" rel="stylesheet" />
<link href="../public/css/preview-form.css" rel="stylesheet" />
<!-- <link href="https://apps.bhatkhandeuniversity.ac.in/public/css/default.css" rel="stylesheet" /> -->
<link href="../public/css/responsive.css" rel="stylesheet" />
<link href="../public/css/select2.min.css" rel="stylesheet" />
<script type="text/javascript" src="../public/js/jquery-min.js"></script>
<link href="../public/css/js_latest_toastr.min.css" rel="stylesheet" />
<link href="../public/css/dataTables.bootstrap5.min.css" rel='stylesheet' />
<link href="../public/css/draggle.css" rel="stylesheet">
<link rel="stylesheet" href="../public/css/multilevel-form.css">
<script type="text/javascript" src="../public/js/bootstrap.bundle.min.js"></script>

</head>
<style>
  


    @page {
        size: A4;
    }

    .padding-4 {
        padding-left: 10px;
    }

   

        .logo1 {
            width: 100px;
        }

        .text-section {
            text-align: right;
        }

        .title {
            font-size: 22px;
            font-weight: bold;
        }

        .subtitle {
            font-size: 12px;
            color: #555;
        }
</style>

<style>
    /* Print-specific styles */
    @media print {
        body * {
            visibility: hidden;
        }
        #print-section, #print-section * {
            visibility: visible;
        }
        #print-section {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            margin: 0;
            padding: 16px;
            font-size: 12px;
        }
        .no-print {
            display: none !important;
        }
        table, th, td {
            border: 1px solid black !important;
            border-collapse: collapse !important;
            padding: 2px;
        }
        .card-body {
            padding: 10px !important;
        }
        @page {
            size: A4;
            margin: 1mm;
        }
    }
    
    /* Screen styles */
    @media screen {
        #print-section {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 10px;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    }
    
    /* Common styles */
    .header-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 6px 0px;
        border-bottom: 2px solid #ccc;
        margin-bottom: 5px;
    }
    .logo1 {
        width: 80px;
        height: auto;
    }
    .text-section {
        text-align: right;
    }
    .title {
        font-size: 18px;
        font-weight: bold;
    }
    .subtitle {
        font-size: 14px;
        color: #555;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 10px;
    }
    th, td {
        padding: 1px;
        text-align: left;
        vertical-align: top;
    }
    .text-center {
        text-align: center;
    }
    .padding-4 {
        padding-left: 4px;
    }
    .headingTopMain {
        font-size: 18px;
        font-weight: bold;
        text-align: center;
        margin-top: 12px;
        margin-bottom: 6px;
    }
    .headingTop {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }
    .photo-signature {
        text-align: center;
    }
    .photo-signature img {
        max-width: 100%;
        height: auto;
        border: 1px solid #ccc;
        margin-bottom: 5px;
    }
    .declaration {
        font-size: 12px;
        color: red;
        margin-top: 15px;
    }
</style>
<style>
    /* Print-specific styles */
    @media print {
        body * {
            visibility: hidden;
        }
        #print-section, #print-section * {
            visibility: visible;
        }
        #print-section {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            margin: 0;
            padding: 12px;
            font-size: 12px;
        }
        .no-print {
            display: none !important;
        }
        table, th, td {
            border: 1px solid black !important;
            border-collapse: collapse !important;
            padding: 2px;
            font-size:12px;
        }
        .card-body {
            padding: 10px !important;
        }
        @page {
            size: A4;
            margin: 1mm;
        }
    }
    
    /* Screen styles */
    @media screen {
        #print-section {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 16px;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
    }
    
    /* Common styles */
    .header-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 2px solid #ccc;
        margin-bottom: 10px;
    }
  
   
   
</style>
<body class="dashbg">
   
    <!-- Screen header (won't print) -->
    <header class="header no-print">
        <div class="container-fluid">
            <div class="row">
                <div class="col-2 text-center col-md-1 b-rights px-0"><img src="../public/images/logo.png" alt="" class="dash-logo" /></div>
                <div class="col-9 col-md-9 px-0">
                    <h4 class="moudlename">Anganwadi Recruitment Uttar Pradesh</h4>
                    <h5 class="dash-head"> Government of Uttar Pradesh </h5>
                </div>
                <div class="col px-0 text-end" style="display: block ruby;">
                    <a class="dropdown-toggle profileicon" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../public/images/profile2.png" />
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    
    <!-- Screen navigation (won't print) -->
    <div class="contentwraper mt-5 no-print">
        <div class="container-fluid">
            <div class="row mt-3">
                <br>
                <div class="col-md-1 col-2 ">
                    <a title="Dashboard" href="dashboard.php" style="color: #282d6a;" class="intentbtn">
                        <span class="intenticon">
                            <span class="icons icon-home" style="font-size: 32px;"></span>
                        </span></a>
                </div>
                <div class="col-md-3 col-10"> <a href="#" class="intentbtn bg-c-yellow">
                        <span class="intenticon">
                            <img src="../public/images/icon1.png">
                        </span> <span class="intentdata"> <b class="intentno"></b> Anganwadi Application Form </span> </a>
                </div>
                <div class="col-6 text-center">
                    <div class="row">
                        <div class="no-print" style="margin-top: 20px;">
                            <button class="btn btn-success" type="button" onclick="window.print()"> &nbsp;&nbsp; Print  &nbsp;&nbsp;</button>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Printable content -->
    <div id="print-section">
        <div class="headingTopMain">
            <b>आँगनवाड़ी कार्यकत्री आवेदन पत्र</b>
        </div>
        <div class="header-container">
            <img src="../public/images/logo.png" alt="Logo" class="logo1">
            
            <div class="text-section">
                <div class="title">Anganwadi Recruitment Uttar Pradesh 2026</div>
                <div class="subtitle">Government of Uttar Pradesh</div>
            </div>
        </div>
        <div class="text-center" style="font-size:14px;font-weight:600;">
            जिला: <?php echo strtoupper(getdistName($data['district_id'])); ?> &nbsp;&nbsp;&nbsp;&nbsp; बाल विकास परियोजना: <?php echo strtoupper(getBlockName($data['project'])); ?><br><br>
        </div>
        <div class="headingTop">
            <div class="right"><b>आवेदन तिथि: <?php echo date('d-m-Y',strtotime($data['filled_date'])); ?></b></div>
            <div class="left"><b>आवेदन संख्या: <?php echo $_GET['appNo']; ?></b></div>
        </div>

        <table>
            <tbody>
                <tr>
                    <td style="width: 30%" class="text-center"><b>पद का नाम</b></td>
                    <td style="width: 60%" class="padding-4">आंगनवाड़ी कार्यकत्री</td>
                    <td rowspan="6" style="width: fit-content !important">
                            <img src="<?php echo $udata['photo']; ?>" style="width:180px;height: 140px;padding:2px; border: 2px solid #ccc;" />

                            <img src="<?php echo $udata['signature']; ?>" style="width:180px;height: 50px;padding:2px; border: 1px solid #ccc;">
                        </td>
                </tr>
                <tr>
                    <td style="width: 30%" class="text-center"><b>रिक्त केंद्र का नाम</b></td>
                    <td class="padding-4"> <?php echo strtoupper(getawwCenter($data['aganwadi_center'])); ?></td>
                </tr>
                <tr>
                    <td style="width: 30%" class="text-center"><b>ग्राम सभा/वार्ड का नाम</b></td>
                    <td class="padding-4"><?php echo $data['gram_panchayat']; ?></td>
                </tr>
                <tr>
                    <td style="width: 30%" class="text-center"><b>आवेदिका का नाम</b></td>
                    <td class="padding-4"><?php echo getPrename($data['pre_name']); ?> <?php echo $data['name_hi']; ?>(<?php echo $data['name_en']; ?>)</td>
                </tr>
                <tr>
                    <td style="width: 30%" class="text-center"><b>वैवाहिक स्थिति</b></td>
                    <td class="padding-4"><?php echo marriedStatus($data['marital_status']);  ?></td>
                </tr>
                <tr>
                    <td style="width: 30%" class="text-center"><b>पति का नाम</b></td>
                    <td colspan="2" class="padding-4"><?php echo $data['hname']; ?></td>
                </tr>
                <tr>
                    <td style="width: 30%" class="text-center"><b>पिता का नाम</b></td>
                    <td colspan="2" class="padding-4"><?php echo $data['fname']; ?></td>
                </tr>
                <tr>
                    <td style="width: 30%" class="text-center"><b>माता का नाम</b></td>
                    <td colspan="2" class="padding-4"><?php echo $data['mname']; ?></td>
                    
                </tr>
                <tr>
                    <td style="width: 30%" class="text-center"><b>श्रेणी</b> </td>
                    <td colspan="2" class="padding-4"><?php echo getCategoryText($data['category']); ?></td>
                </tr>
                <tr>
                    <td style="width: 30%" class="text-center"><b>मोबाइल नंबर</b></td>
                    <td colspan="2" class="padding-4"><?php echo $data1['mobile']; ?></td>
                </tr>
                 <tr> 
                    <td colspan="3">
                        <div style="display: flex; justify-content: space-around">
                           <!-- <div> <b>उप श्रेणी:</b> <?php echo getSubcategory($data['sub_category']); ?></div> -->
                           <div> <b>आवेदिका की वर्तमान स्थिति:</b> <?php echo getCurrentsituation($data['avedika_status']); ?></div>
                          
                            
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="text-center"><b>विधवा/तलाकशुदा/परित्यकता प्रमाण पत्र का विवरण</b></td>
                </tr>
                <tr> 
                    <td colspan="3">
                        <div style="display: flex; justify-content: space-around">
                            <?php 
                            if($data['avedika_status']==1){ ?>
                           <div> डी आर एल संख्या: <?php echo $data['drl_no']; ?></div>
                           <div> मृत्यु की तिथि: <?php  echo (!empty($data['death_date']) && $data['death_date'] != '0000-00-00') 
            ? date('d/m/Y', strtotime($data['death_date'])) 
            : '';  ?> </div>
                             <div>प्रमाणपत्र संख्या: <?php echo $data['vidhwa_certificateno']; ?></div>
                            <div>जारीकर्ता का पदनाम: <?php echo $data['v_jarikrta_name']; ?></div>
                            <?php }else if($data['avedika_status']==2){ ?>
                               
                             <div>प्रमाणपत्र संख्या: <?php echo $data['vidhwa_certificateno']; ?></div>
                            <div>जारीकर्ता का पदनाम: <?php echo $data['v_jarikrta_name']; ?></div>
                            <?php }else{ ?>

                                 <div>N/A</div>

                          <?php  } ?>
                           
                        </div>
                    </td>
                </tr>
                <?php if($data['sub_category']=='1'){ ?>
                <!-- <tr>
                    <td colspan="3" class="text-center"><b>विकलांगता प्रमाण पत्र का विवरण </b></td>
                </tr> -->
                <!-- <tr>
                    <td colspan="3">
                        <div style="display: flex; justify-content: space-around">
                            <div>दिव्यांगता आवेदन संख्या: <?php echo $data['divangta_avedan_krmank']; ?></div>
                            <div>दिव्यांगता प्रमाण पत्र संख्या: <?php echo $data['divangta_pramnpatr_kramank']; ?></div>
                            <div>दिव्यांगता प्रतिशत: <?php echo $data['percentage']; ?></div>
                        </div>
                    </td>
                </tr> -->
                <?php }else  if($data['sub_category']=='2') { ?>
                <!-- <tr>
                    <td colspan="3" class="text-center"><b>स्वतंत्रता सेनानी प्रमाण पत्र का विवरण</b></td>
                </tr> -->
                <!-- <tr>
                    <td colspan="3">
                        <div style="display: flex; justify-content: space-around">
                            <div>स्वतन्त्रता संग्राम सेनानी आश्रित से संबंध: <?php echo $data['f_senani_sambandh']; ?></div>
                        </div>
                    </td>
                </tr> -->
               
                 <?php }else  if($data['sub_category']=='3') { ?>
                <!-- <tr>
                    <td colspan="3" class="text-center"><b>स्पोर्ट्स-वूमेंस का विवरण</b></td>
                </tr> -->
                <!-- <tr>
                    <td colspan="3">
                        <div style="display: flex; justify-content: space-around">
                            <div>विवरण: <?php echo $data['sports_details']; ?></div>
                        </div>
                    </td>
                </tr> -->
                <?php } ?>
                
                <tr>
                    <td colspan="3" class="text-center"><b>निवास प्रमाण पत्र विवरण</b></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div style="display: flex; justify-content: space-around">
                            <div>निवास प्रमाण पत्र नंबर :<?php echo $data['nivas_prmaanpatr_no']; ?></div>
                            <div>निवास आवेदन प्रमाण पत्र:<?php echo $data['nivas_avedan_prmanpatr']; ?></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div style="display: flex; justify-content: space-around">
                            <div>पूरा पता: <?php echo $data['permanent_full_address']; ?></div>
                            <div> पिन कोड: <?php echo $data['permanent_full_address_pincode']; ?></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="text-center"><b>जाति प्रमाण पत्र विवरण</b></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div style="display: flex; justify-content: space-around">
                            <div>जाति प्रमाण पत्र नंबर:<?php echo $data['jaant_prmaanpatr_no']; ?></div>
                            <div>जाति आवेदन प्रमाण पत्र:<?php echo $data['jaati_avedan_prmanpatr']; ?></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="text-center"><b>आय प्रमाण पत्र का विवरण</b></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div style="display: flex; justify-content: space-around">
                            <div>आय प्रमाण पत्र नंबर:<?php echo $data['aay_prmaanpatr_no']; ?></div>
                            <div>आय आवेदन प्रमाण पत्र:<?php echo $data['aay_avedan_prmanpatr']; ?></div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="1" class="text-center"><b>जन्मतिथि:</b></td>
                    <td colspan="2"><?php echo date('d-m-Y',strtotime($data['date_of_birth'])); ?></td>
                </tr>
                <tr>
                    <td colspan="1" class="text-center"><b>आधार नंबर:</b> </td>
                    <td colspan="2"><?php echo $data1['aadhar_no'] ?></td>
                </tr>
                <tr>
                    <td colspan="3" class="text-center" style="font-weight: 700 !important">आवेदिका की आयु</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div style="display: flex; justify-content: space-around">
                            <div><b> वर्ष : </b> <?php echo $data['year'];  ?></div>
                            <div><b> माह : </b><?php echo $data['month'];  ?> </div>
                            <div><b> दिन : </b><?php echo $data['day'];  ?> </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" class="text-center" style="font-weight: 700 !important">शैक्षणिक योग्यता का विवरण</td>
                </tr>
            </tbody>
        </table>
        
        <table style="margin-bottom: 15px;">
            <thead style="font-weight: 700 !important">
                <tr>
                    <td class="text-center" style="width: 5%">क्र. स.</td>
                    <td class="text-center" style="width: 15%">कक्षा</td>
                    <td class="text-center" style="width: 25%">विद्यालय का नाम</td>
                    <td class="text-center" style="width: 15%">बोर्ड का नाम</td>
                    <td class="text-center" style="width: 10%">उत्तीर्ण वर्ष</td>
                    <td class="text-center" style="width: 10%">पूर्णांक</td>
                    <td class="text-center" style="width: 10%">प्राप्तांक</td>
                    <td class="text-center" style="width: 10%">प्रतिशत</td>
                </tr>
            </thead>
            <tbody>
                <tr style="display: none;">
                    <td class="text-center">1</td>
                    <td class="text-center">हाईस्कूल</td>
                    <td class="text-center"><?php echo $data['h_school']; ?></td>
                    <td class="text-center"><?php echo $data['h_board']; ?></td>
                    <td class="text-center"><?php echo $data['h_year']; ?></td>
                    <td class="text-center"><?php echo $data['h_maxmarks']; ?></td>
                    <td class="text-center"><?php echo $data['h_totalmarks']; ?></td>
                    <td class="text-center"><?php echo $data['h_present']; ?></td>
                </tr>
                <tr>
                    <td class="text-center">2</td>
                    <td class="text-center">इंटर</td>
                    <td class="text-center"><?php echo $data['i_school']; ?></td>
                    <td class="text-center"><?php echo $data['i_board']; ?></td>
                    <td class="text-center"><?php echo $data['i_year']; ?></td>
                    <td class="text-center"><?php echo $data['i_maxmarks']; ?></td>
                    <td class="text-center"><?php echo $data['i_totalmarks']; ?></td>
                    <td class="text-center"><?php echo $data['i_present']; ?></td>
                </tr>
                <tr>
                    <td class="text-center">3</td>
                    <td class="text-center">ग्रेजुएशन</td>
                    <td class="text-center"><?php echo $data['g_school']; ?></td>
                    <td class="text-center"><?php echo $data['g_board']; ?></td>
                    <td class="text-center"><?php echo $data['g_year']; ?></td>
                    <td class="text-center"><?php echo $data['g_maxmarks']; ?></td>
                    <td class="text-center"><?php echo $data['g_totalmarks']; ?></td>
                    <td class="text-center"><?php echo $data['g_present']; ?></td>
                </tr>
                <tr>
                    <td class="text-center">4</td>
                    <td class="text-center">पोस्ट ग्रेजुएशन</td>
                    <td class="text-center"><?php echo $data['pg_school']; ?></td>
                    <td class="text-center"><?php echo $data['pg_board']; ?></td>
                    <td class="text-center"><?php echo $data['pg_year']; ?></td>
                    <td class="text-center"><?php echo $data['pg_maxmarks']; ?></td>
                    <td class="text-center"><?php echo $data['pg_totalmarks']; ?></td>
                    <td class="text-center"><?php echo $data['pg_present']; ?></td>
                </tr>
            </tbody>
        </table>
        
        <!-- <div class="declaration">
            * मैं घोषणा करती हूँ कि मैने उक्त पद से सम्मान्धित प्रकाशित विज्ञप्ति को ध्यानपूर्वक पढ़ा है। चयन से सम्बंधित सभी शर्ते मुझे मान्य हैं।
            मेरे द्वारा आवेदन पत्र में अंकित सभी सूचनाएं और विवरण सत्य हैं।
            भविष्य में यदि कोई तथ्य/विवरण गलत अथवा असत्य पाया जाता है या छिपाया गया है , तो आवेदिका का अभ्यर्थन/निपुक्ति निरस्त समझा जायेगा।
        </div> -->
        
        <!-- Print button (won't print) -->
        <div class="no-print" style="margin-top: 20px;">
            <button class="btn btn-success" type="button" onclick="window.print()"> &nbsp;&nbsp; Print  &nbsp;&nbsp;</button>
          
        </div>
        
    </div>

    
    </div>
    </div>
</body>

</html>