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

$query = "SELECT  `date_of_birth`,pd.`category`, pd.`sub_category`, pd.`divangta_avedan_krmank`, pd.`divangta_pramnpatr_kramank`,
pd.`percentage`,pd.`f_senani_sambandh`,pd.`f_senani_prmanptr`,pd.`avedika_status`,pd.`vidhwa_certificateno`,pd.`v_jarikrta_name`,pd.`v_uploaddata`,
pd.`nivas_prmaanpatr_no`, pd.`nivas_avedan_prmanpatr`,pd.`nivas_upload`,pd.`jaant_prmaanpatr_no`,pd.`jaati_avedan_prmanpatr`,
pd.`jaati_upload`, pd.`aay_prmaanpatr_no`, pd.`aay_avedan_prmanpatr`, pd.`aay_upload`,pd.`bpl_card`,
ad.`id` as academic_id, ad.`userid` as academic_userid, ad.`h_school`, ad.`i_school`, ad.`g_school`, ad.`h_board`,ad.`h_year`,ad.`h_maxmarks`,
ad.`h_totalmarks`,ad.`h_marksheetdoc`,ad.`h_otherdoc`,ad.`h_present`,ad.`i_board`,ad.`i_year`,ad.`i_maxmarks`,
ad.`i_totalmarks`, ad.`i_present`,ad.`g_board`,ad.`g_year`,ad.`g_maxmarks`,ad.`g_marksheetdoc`,ad.`g_otherdoc`,ad.`g_present`,ad.`g_totalmarks`,
nad.`id` as application_id, nad.`userid` as application_userid, nad.`district`, nad.`tehseel`, nad.`project`, nad.`grameen_sehri`
, nad.`gram_panchayat` , nad.`word_name`, nad.`nay_panchayat`, nad.`rikt_pd`, nad.`rikt_aww_center`, nad.`name_hi`, nad.`pre_name`,nad.`year`,nad.`month`,nad.`day`
, nad.`name_en` ,  nad.`fname`, nad.`mname`, nad.`hname`, nad.`mobile`,ad.pg_board,ad.pg_year,ad.pg_maxmarks,ad.pg_totalmarks,ad.pg_present
FROM 
`personal_details` pd
JOIN 
`academic_details` ad ON pd.`userid` = ad.`userid`
JOIN 
`new_application_details` nad ON pd.`userid` = nad.`userid`
WHERE 
nad.`userid` ='" . $_SESSION['uid'] . "'";
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
<title>Registration : Anganwadi Recruitment 2024, Lucknow, India</title>
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



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    .loader {
        width: 48px;
        height: 48px;
        border: 2px solid #128cbc;
        border-radius: 50%;
        display: inline-block;
        position: absolute;
        box-sizing: border-box;
        animation: rotation 1s linear infinite;
        z-index: 9999999999;
        top: 50%;
        left: 50%;
        transform: translate(-50%)
    }

    .loader::after,
    .loader::before {
        content: '';
        box-sizing: border-box;
        position: absolute;
        left: 0;
        top: 0;
        background: #FF3D00;
        width: 6px;
        height: 6px;
        transform: translate(150%, 150%);
        border-radius: 50%;
    }

    .loader::before {
        left: auto;
        top: auto;
        right: 0;
        bottom: 0;
        transform: translate(-150%, -150%);
    }

    @keyframes rotation {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .screen {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        display: flex;
        align-items: center;
        backdrop-filter: blur(1.5px);
        z-index: 99999;
    }

    a.not-allowed {
        cursor: not-allowed !important;
        pointer-events: none;
    }

    .active-tab {
        background: #ffdebb;
        border-bottom: 1px solid #ef8937;
    }

    #print {

        width: 8.5in;
        margin-left: 20%;

    }


    @page {
        size: A4;
    }
    .padding-4{
        padding-left:14px;
    }
</style>


<body class="dashbg">

    <div class="screen" style="display: none"> <span class="loader"></span> </div>

    <header class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-2 text-center col-md-1 b-rights px-0"><img src="../public/images/logo.png" alt="" class="dash-logo" /></div>
                <div class="col-9 col-md-9 px-0">
                    <h4 class="moudlename">Anganwadi Recruitment Uttar Pradesh</h4>
                    <h5 class="dash-head"> Government of Uttar Pradesh </h5>
                </div>
                <div class="col px-0 text-end" style="display: block ruby;">
                    <a href="preview_form.php" class="profileicon"><img src="../public/images/profile2.png" /></a>
                    <div class="sidebar">
                        <div class="profiletitle"> <span class="text-uppercase">Applicant Name</span> <span>Last Login :
                            </span></div>
                        <div class="scrollwrap">
                            <div class="nano-content">
                                <ul class="navsidebar">
                                    <li class="nav-item">
                                        <a href="dashboard.php"><span class="icons icon-speedometer"></span> Dashboard </a>
                                    </li>
                                    <li class="nav-item"> <a href=""><span class="icons icon-user"></span> Profile</a> </li>
                                    <li class="nav-item"> <a href=""><span class="icons icon-lock-open"></span>Change
                                            Password</a> </li>
                                </ul>
                            </div>
                        </div>
                        <div class="logoutbutton"><a href="logout.php"><span class="fas fa-power-off"></span>&nbsp;&nbsp;Logout</a></div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <div class="contentwraper mt-5">


        <div class="container-fluid">

            <div class="row mt-3">
                <br>
                <div class="col-md-1 col-2 ">
                    <a title="Dashboard" href="dashboard.php" style="color: #282d6a;" class="intentbtn">
                        <span class="intenticon">
                            <span class="icons icon-home" style="font-size: 32px;"></span>
                        </span></a>
                </div>

                <div class="col-md-3 col-10"> <a href="preview_form.php" class="intentbtn bg-c-yellow">
                        <span class="intenticon">
                            <img src="../public/images/icon1.png">
                        </span> <span class="intentdata"> <b class="intentno"></b> Anganwadi Application Form </span> </a>
                </div>



            </div>

            <div class="border bg-light p-2 mb-2">
                <div class="row">
                    <div class="col-md-4 col-12 text-center"> <strong> Applicant's Name </strong>: <?php echo $data1['name']; ?> </div>
                    <div class="col-md-4 col-12 text-center"> <strong>Father Name</strong> : <?php echo $data1['father_name']; ?>
                    </div>
                    <div class="col-md-4 col-12 text-center"><strong>Mobile No.</strong> : <?php echo $data1['mobile']; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body" id="print">
            <!-- <h2>Preview Form</h2> -->
            <div class="headingTopMain">
                <b>अंतिम पूर्वावलोकन - आवेदन पत्र</b><br>
                <!-- आंगनबाड़ी कार्यकत्रियों, मिनी आंगनबाड़ी कार्यकत्रियों. एवं सहायिकाओं की
                मानदेय पर संविदा आधारित नियुक्ति -->
                <br />
                बाल विकास परियोजना : <?php echo getProjectname($data['project']); ?>
            </div>
            <div class="headingTop">
                <!-- <div class="left">पंजीकरण संख्या: <?php echo $_SESSION['app_no']; ?></div> -->
                <div class="right"><b>आवेदन तिथि: <?php echo date('d/m/Y'); ?></b></div>
            </div>
            <?php
            // print_r($data);   
            // die;              
            ?>
            <table style="width: 100%">
                <thead>
                    <tr>
                        <!-- <td style="width: 5%"></td> -->
                        <td style="width: 30%" class="text-center"><b>पद का नाम</b></td>
                        <td style="width: 60%" class="padding-4">आंगनवाड़ी कार्यकत्री</td>
                        <td rowspan="6" style="width: fit-content !important">
                            <img src="<?php echo $udata['photo']; ?>" style="width:180px;height: 140px;padding:2px; border: 2px solid #ccc;" />

                            <img src="<?php echo $udata['signature']; ?>" style="width:180px;height: 50px;padding:2px; border: 1px solid #ccc;">
                        </td>

                    </tr>
                    <!-- <tr>
                        <td style="width: 5%"></td>
                        <td style="width: 30%">रिक्त केंद्रो का कोड</td>
                        <td>9183070257</td>
                    </tr> -->
                    <tr>
                        <!-- <td style="width: 5%"></td> -->
                        <td style="width: 30%" class="text-center"><b>रिक्त केंद्र का नाम</b></td>
                        <td class="padding-4"> <?php echo getawwCenter($data['rikt_aww_center']); ?></td>
                    </tr>
                    <tr>
                        <!-- <td style="width: 5%">1</td> -->
                        <td style="width: 30%" class="text-center"><b>ग्राम सभा/वार्ड का नाम</b></td>
                        <td class="padding-4"><?php 
                            echo getGrampanchayatName($data['gram_panchayat']);
                        
                      
                           ?></td>
                    </tr>
                    <tr>
                        <!-- <td style="width: 5%">2</td> -->
                        <td style="width: 30%" class="text-center"><b>आवेदिका का नाम</b></td>
                        <td class="padding-4"><?php echo getPrename($data['pre_name']); ?>  <?php echo $data['name_hi']; ?></td>
                    </tr>
                    <tr>
                        <!-- <td style="width: 5%"></td> -->
                        <td style="width: 30%" class="text-center"><b>वैवाहिक स्थिति</b></td>
                        <td class="padding-4"><?php echo marriedStatus($data['pre_name']); ?></td>
                    </tr>
                    <tr>
                        <!-- <td style="width: 5%">3</td> -->
                        <td style="width: 30%" class="text-center"><b>पति का नाम</b></td>
                        <td colspan="2" class="padding-4"><?php echo $data['hname']; ?></td>
                    </tr>
                    <tr>
                        <!-- <td style="width: 5%">4</td> -->
                        <td style="width: 30%" class="text-center"><b>पिता का नाम</b></td>
                        <td colspan="2" class="padding-4"><?php echo $data['fname']; ?></td>
                    </tr>
                    <tr>
                        <!-- <td style="width: 5%">5</td> -->
                        <td style="width: 30%" class="text-center"><b>माता का नाम</b></td>
                        <td colspan="2" class="padding-4"><?php echo $data['mname']; ?></td>
                    </tr>
                    <tr>
                        <!-- <td style="width: 5%">6</td> -->
                        <td style="width: 30%" class="text-center"><b>श्रेणी</b> </td>
                        <td colspan="2" class="padding-4"><?php echo getCategoryText($data['category']); ?></td>
                    </tr>
                    <tr>
                        <!-- <td style="width: 5%"></td> -->
                        <td style="width: 30%" class="text-center"><b>मोबाइल नंबर</b></td>
                        <td colspan="2" class="padding-4"><?php echo $data1['mobile']; ?></td>
                    </tr>
                    <tr>
                        <!-- <td style="width: 5%">7</td> -->
                        <td colspan="3" class="text-center"><b>विधवा/तलाकशुदा/परित्यकता प्रमाण पत्र का विवरण</b></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div style="display: flex; justify-content: space-around">
                                <div>जरीकर्ता का पदनाम: <?php echo $data['v_jarikrta_name']; ?></div>
                                <div>क्रमांक: <?php echo $data['vidhwa_certificateno']; ?></div>

                            </div>
                        </td>
                    </tr>
                    <tr>
                        <!-- <td style="width: 5%">8</td> -->
                        <td colspan="3" class="text-center"><b>विकलांगता प्रमाण पत्र का विवरण </b></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div style="display: flex; justify-content: space-around">
                                <div>दिव्यांगता आवेदन क्रमांक: <?php echo $data['divangta_avedan_krmank']; ?></div>
                                <div>दिव्यांगता प्रमाण पत्र क्रमांक: <?php echo $data['divangta_pramnpatr_kramank']; ?></div>
                                <div>दिव्यांगता प्रतिशत: <?php echo $data['percentage']; ?></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <!-- <td style="width: 5%">9</td> -->
                        <td colspan="3" class="text-center"><b>स्वतंत्रता सेनानी प्रमाण पत्र का विवरण</b></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div style="display: flex; justify-content: space-around">
                                <div>स्वतन्त्रता संग्राम सेनानी आश्रित से संबंध: <?php echo $data['f_senani_sambandh']; ?></div>
                                <!-- <div>क्रमांक:</div>
                                <div>दिनांक:</div> -->
                            </div>
                        </td>
                    </tr>
                    <!-- <tr>
                        <td style="width: 5%">10</td>
                        <td colspan="3" style="font-weight: 700 !important">यदि आवेदिका सहायिका के पद पर कार्यरत है तो उसका विवरण</td>
                    </tr> -->
                    <!-- <tr>
                        <td colspan="4">
                            <div style="display: flex; justify-content: space-around">
                                <div>योगदान का दिनांक:</div>
                                <div>केंद्र का नाम:</div>
                                <div>ग्राम सभा / वार्ड का नाम:</div>
                            </div>
                        </td>
                    </tr> -->
                    <!-- <tr>
                        <td style="width: 5%">11</td>
                        <td colspan="3" style="font-weight: 700 !important">स्थाई पता</td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div style="display: flex; justify-content: space-around">
                                <div>मकान नंबर: <?php echo $data['']  ?></div>
                                <div>ग्राम/ मोहल्ला: <?php echo $data['']  ?></div>
                                <div>पोस्ट:</div>
                                <div>जनपद:</div>
                            </div>
                        </td>
                    </tr> -->
                    <tr>
                        <!-- <td style="width: 5%">12</td> -->
                        <td colspan="3" class="text-center"><b>निवास प्रमाण पत्र विवरण</b></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div style="display: flex; justify-content: space-around">
                                <div>निवास प्रमाण पत्र नंबर :<?php echo $data['nivas_prmaanpatr_no']; ?></div>
                                <div>निवास आवेदन प्रमाण पत्र:<?php echo $data['nivas_avedan_prmanpatr']; ?></div>
                                <!-- <div>दिनांक:</div> -->
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <!-- <td style="width: 5%">13</td> -->
                        <td colspan="3" class="text-center"><b>जाति प्रमाण पत्र विवरण</b></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div style="display: flex; justify-content: space-around">
                                <div>जाति प्रमाण पत्र नंबर:<?php echo $data['jaant_prmaanpatr_no']; ?></div>
                                <div>जाति आवेदन प्रमाण पत्र:<?php echo $data['jaati_avedan_prmanpatr']; ?></div>
                                <!-- <div>दिनांक:</div> -->
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <!-- <td style="width: 5%">14</td> -->
                        <td colspan="3" class="text-center"><b>आय प्रमाण पत्र का विवरण</b></td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div style="display: flex; justify-content: space-around">
                                <div>आय प्रमाण पत्र नंबर:<?php echo $data['aay_prmaanpatr_no']; ?></div>
                                <div>आय आवेदन प्रमाण पत्र:<?php echo $data['aay_avedan_prmanpatr']; ?></div>
                                <!-- <div>दिनांक:</div> -->
                            </div>
                        </td>
                    </tr>


                    <!-- <td style="width: 5%">15</td> -->
                    <td colspan="1" class="text-center"><b>जन्मतिथि:</b></td>
                    <td colspan="2"><?php echo $data['date_of_birth']; ?></td>
                    </tr>
                    <tr>
                        <!-- <td style="width: 5%">16</td> -->
                        <td colspan="1" class="text-center"><b>आधार नंबर:</b> </td>
                        <td colspan="2"><?php echo $data1['aadhar_no'] ?></td>
                    </tr>
                    <tr>
                        
                        <td colspan="3" class="text-center" style="font-weight: 700 !important">आवेदिका की आयु</td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div style="display: flex; justify-content: space-around">
                                <div><b> वर्ष   : </b> <?php echo $data['year'];  ?></div>
                                <div><b> माह  : </b><?php echo $data['month'];  ?> </div>
                                <div><b> दिन  : </b><?php echo $data['day'];  ?> </div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        
                        <td colspan="3" class="text-center" style="font-weight: 700 !important">शैक्षणिक योग्यता का विवरण</td>
                    </tr>
                    <tr>
                        <table style="width: 100%; border: 0px solid black !important">
                            <thead style="font-weight: 700 !important">
                                <tr>
                                    <td class="text-center">क्र. स.</td>
                                    <td class="text-center">कक्षा</td>
                                    <td  class="text-center" style="width: 25%">विद्यालय का नाम</td>
                                    <td class="text-center" >बोर्ड का नाम</td>
                                    <td class="text-center">उत्तीर्ण वर्ष</td>
                                    <td class="text-center">पूर्णांक</td>
                                    <td class="text-center">प्राप्तांक</td>

                                    <td class="text-center">प्रतिशत</td>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td class="text-center">1</td>
                                    <td class="text-center">हाईस्कूल</td>
                                    <td class="text-center" style="width: 25%"><?php echo $data['h_school']; ?></td>
                                    <td class="text-center" ><?php echo $data['h_board']; ?></td>
                                    <td class="text-center" ><?php echo $data['h_year']; ?></td>
                                    <td class="text-center" ><?php echo $data['h_maxmarks']; ?></td>
                                    <td class="text-center" ><?php echo $data['h_totalmarks']; ?></td>

                                    <td class="text-center"><?php echo $data['h_present']; ?></td>
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td class="text-center">इंटर</td>
                                    <td  class="text-center" style="width: 25%"><?php echo $data['i_school']; ?></td>
                                    <td class="text-center"><?php echo $data['i_board']; ?></td>
                                    <td class="text-center"><?php echo $data['i_year']; ?></td>
                                    <td class="text-center"><?php echo $data['i_maxmarks']; ?></td>
                                    <td class="text-center"><?php echo $data['i_totalmarks']; ?></td>

                                    <td class="text-center"><?php echo $data['i_present']; ?></td>
                                </tr>
                                <tr>
                                    <td class="text-center">3</td>
                                    <td class="text-center">ग्रेजुएशन</td>
                                    <td class="text-center" style="width: 25%"><?php echo $data['g_school']; ?></td>
                                    <td class="text-center"><?php echo $data['g_board']; ?></td>
                                    <td class="text-center"><?php echo $data['g_year']; ?></td>
                                    <td class="text-center"><?php echo $data['g_maxmarks']; ?></td>
                                    <td class="text-center"><?php echo $data['g_totalmarks']; ?></td>

                                    <td class="text-center"><?php echo $data['g_present']; ?></td>
                                </tr>
                                <tr>
                                    <td class="text-center">3</td>
                                    <td class="text-center">पोस्ट ग्रेजुएशन</td>
                                    <td class="text-center" style="width: 25%"><?php echo $data['g_school']; ?></td>
                                    <td class="text-center"><?php echo $data['pg_board']; ?></td>
                                    <td class="text-center"><?php echo $data['pg_year']; ?></td>
                                    <td class="text-center"><?php echo $data['pg_maxmarks']; ?></td>
                                    <td class="text-center"><?php echo $data['pg_totalmarks']; ?></td>

                                    <td class="text-center"><?php echo $data['pg_present']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </tr>
                </thead>
            </table>
            <br>
            <div style="color:red;">
                *मैं  घोषणा करती हूँ कि मैने उक्त पद से सम्मान्धित प्रकाशित विज्ञप्ति को ध्यानपूर्वक पढ़ा है चयन से सम्बन्धित
                सभी शर्ते मुझे मान्य हैं। आवेदन-पत्र के में अंकित सभी सूचना व आवेदन-पत्र के साथ सभी विवरण सत्य एवं सही है। भविष्य में
                यदि कोई तथ्य फर्जी/ असत्य पाये जाते हैं या छिपाया गया पाया जाता है, तो आवेदिका का अभ्यर्थन/निपुक्ति निरस्त कर समुचित
                वैधानिक कार्यवाही की जाय।<br>
                <!-- <p>इस आवेदन पत्र के साथ समस्त सलग्नकों की स्वप्रमाणित छायाप्रति सहित सक्षम नियुक्ति प्रधिकारी को भेजें।</p> -->
            </div>
            <div class="col-12"><br>
                <form method="POST" action="formSubmit.php?user=<?php echo $_SESSION['uid']; ?>" id="submitForm">
                    <a href="decleration.php"><button class="btn btn-danger" type="button">पिछला</button></a>
                    &nbsp;&nbsp;&nbsp; <button class="btn btn-success" type="submit" name="finalSubmit">अगला</button>
                </form>
            </div>
        </div>
    </div>

    <!-- <script>
   $('#submitForm').on('submit',function(e){
        e.preventDefault();
        var form = $('#submitForm');
        swal({
            title: "क्या आप सहमत है?",
            text: "कृपया फॉर्म को सबमिट करने से पहले सभी दस्तावेज को पुनः जाँच ले, इसके बाद फॉर्म कोई बदलवा नही कर पाएंगे।",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, submit it!",
            closeOnConfirm: false,
            html: false

        }, function(isConfirm){
           // alert('test');
            $('#submitForm').submit()
               // console.log("sdfsf");
            if (isConfirm){
                $('#submitForm').submit();
                
            }
            else{
                alert('test');
            }
        });
    });
</script> -->

    <script>
        $('#submitForm').submit(function(e, params) {
            var localParams = params || {};
            if (!localParams.send) {
                e.preventDefault();
            }
            //additional input validations can be done hear
            swal({
                title: "क्या आप सहमत है?",
                text: "कृपया फॉर्म को सबमिट करने से पहले सभी दस्तावेज को पुनः जाँच ले, इसके बाद फॉर्म कोई बदलवा नही कर पाएंगे।",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#6A9944",
                confirmButtonText: "Confirm",
                cancelButtonText: "Cancel",
                closeOnConfirm: true
            }, function(isConfirm) {
                if (isConfirm) {
                    //console.log('test');
                    $('#submitForm').submit();
                    $(e.currentTarget).trigger(e.type, {
                        'send': true
                    });

                } else {
                    //additional run on cancel  functions can be done hear
                }
            });
        });
    </script>

    </div>
    </div>


</body>

</html>