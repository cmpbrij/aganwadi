<?php
include('../config/db_config.php');
include('../config/settings.php');
session_start();

    if(!checkLogin()){
        header('Location: login.php');
    }
if (isset($_SESSION['uid'])) {
    $sql = "SELECT * FROM users WHERE `id`='" . $_SESSION['uid'] . "'";
    $res = $conn->query($sql);
    $data1 = mysqli_fetch_assoc($res);
    if(isset($_GET['appNo'])){
        $q="select `date_of_birth`,pd.`category`, pd.`sub_category`, pd.`divangta_avedan_krmank`, pd.`divangta_pramnpatr_kramank`,
        pd.`percentage`,pd.`f_senani_sambandh`,pd.`f_senani_prmanptr`,pd.`avedika_status`,pd.`vidhwa_certificateno`,pd.`v_jarikrta_name`,pd.`v_uploaddata`,
        pd.`nivas_prmaanpatr_no`, pd.`nivas_avedan_prmanpatr`,pd.`nivas_upload`,pd.`jaant_prmaanpatr_no`,pd.`jaati_avedan_prmanpatr`,
        pd.`jaati_upload`, pd.`aay_prmaanpatr_no`, pd.`aay_avedan_prmanpatr`, pd.`aay_upload`,pd.`bpl_card`,
        ad.`id` as academic_id, ad.`userid` as academic_userid, ad.`h_school`, ad.`i_school`, ad.`g_school`, ad.`h_board`,ad.`h_year`,ad.`h_maxmarks`,
        ad.`h_typeofmarks`, ad.`h_totalmarks`,ad.`h_marksheetdoc`,ad.`h_otherdoc`,ad.`h_present`,ad.`i_board`,ad.`i_year`,ad.`i_maxmarks`,ad.`i_typeofmarks`,
        ad.`i_totalmarks`, ad.`i_present`,ad.`g_board`,ad.`g_year`,ad.`g_maxmarks`,ad.`g_typeofmarks`,ad.`g_marksheetdoc`,ad.`g_otherdoc`,ad.`g_present`,ad.`g_totalmarks`,
        nad.`id` as application_id, nad.`userid` as application_userid, nad.`district`, nad.`tehseel`, nad.`vikas_khand`, nad.`grameen_sehri`
        , nad.`gram_panchayat` , nad.`word_name`, nad.`nay_panchayat`, nad.`rikt_pd`, nad.`rikt_aww_center`, nad.`name_hi`, nad.`pre_name`
        , nad.`name_en` , nad.`isthiti`, nad.`fname`, nad.`mname`, nad.`hname`, nad.`mobile`, nad.`category`, nad.`sub_category`
        , nad.`sub_category` , nad.`age`,D.application_no,D.category,D.filled_date, D.application_type,D.aganwadi_center
        FROM decleration D
        JOIN
        `new_application_details` nad ON nad.`userid` = D.`userid`
        JOIN
        `personal_details` pd ON pd.`userid` = nad.`userid`
        JOIN 
        `academic_details` ad ON pd.`userid` = ad.`userid`
        JOIN 
        `uploaded_documents` ud ON ad.userid=ud.userid
        WHERE 
        D.`application_no` ='".$_GET['appNo']."' and D.userid='".$_SESSION['uid']."'";
       // echo $q; die;
        $res = $conn->query($q);
        $data = mysqli_fetch_assoc($res);
        //print_r($data); die;
    }

}

topheader();

// $query = "SELECT  `date_of_birth`,pd.`category`, pd.`sub_category`, pd.`divangta_avedan_krmank`, pd.`divangta_pramnpatr_kramank`,
// pd.`percentage`,pd.`f_senani_sambandh`,pd.`f_senani_prmanptr`,pd.`avedika_status`,pd.`vidhwa_certificateno`,pd.`v_jarikrta_name`,pd.`v_uploaddata`,
// pd.`nivas_prmaanpatr_no`, pd.`nivas_avedan_prmanpatr`,pd.`nivas_upload`,pd.`jaant_prmaanpatr_no`,pd.`jaati_avedan_prmanpatr`,
// pd.`jaati_upload`, pd.`aay_prmaanpatr_no`, pd.`aay_avedan_prmanpatr`, pd.`aay_upload`,pd.`bpl_card`,
// ad.`id` as academic_id, ad.`userid` as academic_userid, ad.`h_school`, ad.`i_school`, ad.`g_school`, ad.`h_board`,ad.`h_year`,ad.`h_maxmarks`,
// ad.`h_typeofmarks`, ad.`h_totalmarks`,ad.`h_marksheetdoc`,ad.`h_otherdoc`,ad.`h_present`,ad.`i_board`,ad.`i_year`,ad.`i_maxmarks`,ad.`i_typeofmarks`,
// ad.`i_totalmarks`, ad.`i_present`,ad.`g_board`,ad.`g_year`,ad.`g_maxmarks`,ad.`g_typeofmarks`,ad.`g_marksheetdoc`,ad.`g_otherdoc`,ad.`g_present`,ad.`g_totalmarks`,
// nad.`id` as application_id, nad.`userid` as application_userid, nad.`district`, nad.`tehseel`, nad.`vikas_khand`, nad.`grameen_sehri`
// , nad.`gram_panchayat` , nad.`word_name`, nad.`nay_panchayat`, nad.`rikt_pd`, nad.`rikt_aww_center`, nad.`name_hi`, nad.`pre_name`
// , nad.`name_en` , nad.`isthiti`, nad.`fname`, nad.`mname`, nad.`hname`, nad.`mobile`, nad.`category`, nad.`sub_category`
// , nad.`sub_category` , nad.`age`
// FROM 
// `personal_details` pd
// JOIN 
// `academic_details` ad ON pd.`userid` = ad.`userid`
// JOIN 
// `new_application_details` nad ON pd.`userid` = nad.`userid`
// WHERE 
// nad.`userid` ='".$_SESSION['uid']."'";
// //echo $query;
// $res = $conn->query($query);
// $data = mysqli_fetch_assoc($res);
// //print_r($data); die;

// $sql="SELECT * FROM `uploaded_documents` WHERE userid='".$_SESSION['uid']."'";
// $row=execute_query($sql);
// $udata= mysqli_fetch_array($row);


?>
<!doctype html>
<!-- <html lang="{{str_replace('_', '-', app()->getLocale())}}"> -->
<html>
<title>Registration : Anganwadi Recruitment 2024, Lucknow, India</title>
<meta charset="utf-8">
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
<style>
    body {
  width: 230mm;
  height: 100%;
  margin: 0 auto;
  padding: 0;
  font-size: 12pt;
  background: rgb(204,204,204); 
}
* {
  box-sizing: border-box;
  -moz-box-sizing: border-box;
}
.main-page {
  width: 210mm;
  min-height: 297mm;
  margin: 10mm auto;
  background: white;
  box-shadow: 0 0 0.5cm rgba(0,0,0,0.5);
}
.sub-page {
  padding: 1cm;
  height: 297mm;
}
@page {
  size: A4;
  margin: 0;
}
@media print {
  html, body {
    width: 210mm;
    height: 297mm;        
  }
  .main-page {
    margin: 0;
    border: initial;
    border-radius: initial;
    width: initial;
    min-height: initial;
    box-shadow: initial;
    background: initial;
    page-break-after: always;
  }
}
</style>
</head>


<body class="dashbg">

    <div class="contentwraper">

        <div class="container-fluid">

    <div class="main-page">
        <div class="card-body" id="print">

            <!-- <h2>Preview Form</h2> -->
            <div class="headingTopMain">
                <b>आवेदन पत्र</b><br>
                <br />
                बाल विकास परियोजना : <?php echo $data['vikas_khand']; ?>
            </div>
            <div class="headingTop">
                <div class="left">पंजीकरण संख्या: <?php echo $_SESSION['app_no']; ?></div>
                <div class="right">आवेदन तिथि: <?php echo date('d/m/Y'); ?></div>
            </div>
            <?php

           
            // print_r($data);   
            // die;              
            ?>




            <table style="width: 100%">
                <thead>
                    <tr>
                        <td style="width: 5%"></td>
                        <td style="width: 30%">पद का नाम</td>
                        <td style="width: 60%"><?php echo padName($data['rikt_pd']);  ?></td>
                        <td rowspan="6" style="width: fit-content !important">
                            <img src="<?php echo $udata['photo']; ?>" style="width:180px;height: 140px;padding:2px; border: 2px solid #ccc;" />
                            
                            <img src="../images/signat.png"  style="width:180px;height: 50px;padding:2px; border: 1px solid #ccc;">
                        </td>
                        
                    </tr>
                    <tr>
                        <td style="width: 5%"></td>
                        <td style="width: 30%">रिक्त केंद्रो का कोड</td>
                        <td>9183070257</td>
                    </tr>
                    <tr>
                        <td style="width: 5%"></td>
                        <td style="width: 30%">रिक्त केंद्रो का नाम</td>
                        <td><?php echo $data['rikt_aww_center']; ?></td>
                    </tr>
                    <tr>
                        <td style="width: 5%">1</td>
                        <td style="width: 30%">ग्राम सभा/वार्ड का नाम</td>
                        <td><?php echo $data['gram_panchayat']; echo $data['word_name']; ?></td>
                    </tr>
                    <tr>
                        <td style="width: 5%">2</td>
                        <td style="width: 30%">आवेदिका का नाम</td>
                        <td><?php echo $data['name_hi']; ?></td>
                    </tr>
                    <tr>
                        <td style="width: 5%"></td>
                        <td style="width: 30%">वैवाहिक स्थिति</td>
                        <td><?php  echo marriedStatus($data['pre_name']); ?></td>
                    </tr>
                    <tr>
                        <td style="width: 5%">3</td>
                        <td style="width: 30%">पति का नाम</td>
                        <td colspan="2"><?php echo $data['hname']; ?></td>
                    </tr>
                    <tr>
                        <td style="width: 5%">4</td>
                        <td style="width: 30%">पति का नाम</td>
                        <td colspan="2"><?php echo $data['fname']; ?></td>
                    </tr>
                    <tr>
                        <td style="width: 5%">5</td>
                        <td style="width: 30%">माता का नाम</td>
                        <td colspan="2"><?php echo $data['mname']; ?></td>
                    </tr>
                    <tr>
                        <td style="width: 5%">6</td>
                        <td style="width: 30%">श्रेणी</td>
                        <td colspan="2"><?php echo $data['category']; ?></td>
                    </tr>
                    <tr>
                        <td style="width: 5%"></td>
                        <td style="width: 30%">मोबाइल नंबर</td>
                        <td colspan="2"><?php echo $data1['mobile']; ?></td>
                    </tr>
                    <tr>
                        <td style="width: 5%">7</td>
                        <td colspan="3" style="font-weight: 700 !important">विधवा/तलाकशुदा/परित्यकता प्रमाण पत्र का विवरण</td>
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
                        <td style="width: 5%">8</td>
                        <td colspan="3" style="font-weight: 700 !important">विकलांगता प्रमाण पत्र का विवरण :</td>
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
                        <td style="width: 5%">9</td>
                        <td colspan="3" style="font-weight: 700 !important">स्वतंत्रता सेनानी प्रमाण पत्र का विवरण</td>
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
                        <td style="width: 5%">12</td>
                        <td colspan="3" style="font-weight: 700 !important">निवास प्रमाण पत्र विवरण</td>
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
                        <td style="width: 5%">13</td>
                        <td colspan="3" style="font-weight: 700 !important">जाति प्रमाण पत्र विवरण</td>
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
                        <td style="width: 5%">14</td>
                        <td colspan="3" style="font-weight: 700 !important">आय प्रमाण पत्र का विवरण</td>
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


                    <td style="width: 5%">15</td>
                    <td colspan="1" style=""><b>जन्मतिथि:</b><?php echo $data['date_of_birth']; ?></td>
                    <!-- <td colspan="2" style="">जन्मतिथि (शब्दों में)</td> -->
                    </tr>
                    <tr>
                        <td style="width: 5%">16</td>
                        <td colspan="1" style="font-weight: 700 !important">आधार नंबर: <?php echo $data1['aadhar_no'] ?></td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td style="width: 5%"></td>
                        <td colspan="3" style="font-weight: 700 !important">दिनांक 1 जनवरी 2021 को आवेदिका की आयु</td>
                    </tr>
                    <tr>
                        <td colspan="4">
                            <div style="display: flex; justify-content: space-around">
                                <div>वर्ष: 30</div>
                                <div>माह: 1 </div>
                                <div>दिन: 16</div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 5%"></td>
                        <td colspan="3" style="font-weight: 700 !important">शैक्षणिक योग्यता का विवरण</td>
                    </tr>
                    <tr>
                        <table style="width: 100%; border: none !important">
                            <thead style="font-weight: 700 !important">
                                <tr>
                                    <td>क्र. स.</td>
                                    <td>कक्षा</td>
                                    <td style="width: 25%">विद्यालय का नाम</td>
                                    <td>बोर्ड का नाम</td>
                                    <td>उत्तीर्ण वर्ष</td>
                                    <td>पूर्णांक</td>
                                    <td>प्राप्तांक</td>
                                    <td>ग्रेड  / श्रेणी</td>
                                    <td>प्रतिशत</td>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>1</td>
                                    <td>हाईस्कूल</td>
                                    <td style="width: 25%"><?php echo $data['h_school']; ?></td>
                                    <td><?php echo $data['h_board']; ?></td>
                                    <td><?php echo $data['h_year']; ?></td>
                                    <td><?php echo $data['h_maxmarks']; ?></td>
                                    <td><?php echo $data['h_totalmarks']; ?></td>
                                    <td><?php echo typeofMark($data['h_typeofmarks']); ?></td>
                                    <td><?php echo $data['h_present']; ?></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>इंटर</td>
                                    <td style="width: 25%"><?php echo $data['i_school']; ?></td>
                                    <td><?php echo $data['i_board']; ?></td>
                                    <td><?php echo $data['i_year']; ?></td>
                                    <td><?php echo $data['i_maxmarks']; ?></td>
                                    <td><?php echo $data['i_totalmarks']; ?></td>
                                    <td><?php echo typeofMark($data['i_typeofmarks']); ?></td>
                                    <td><?php echo $data['i_present']; ?></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>स्नातक</td>
                                    <td style="width: 25%"><?php echo $data['g_school']; ?></td>
                                    <td><?php echo $data['g_board']; ?></td>
                                    <td><?php echo $data['g_year']; ?></td>
                                    <td><?php echo $data['g_maxmarks']; ?></td>
                                    <td><?php echo $data['g_totalmarks']; ?></td>
                                    <td><?php echo typeofMark($data['g_typeofmarks']); ?></td>
                                    <td><?php echo $data['g_present']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </tr>
                </thead>
            </table>
           <br> 
            <div class="col-12"><br>
             
            </div>
        </div>
    </div>

    </div>
    </div>


</body>

</html>