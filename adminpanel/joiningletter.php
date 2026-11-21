
<?php
header("Access-Control-Allow-Origin: *");
include('../config/db_config.php');
include('../config/settings.php');
if(!isset($_SESSION['adminid'])){
    echo"Can't view login again"; die;
}

$sql="select district,joining_date from uploaded_final_list where district='".$_SESSION['distid']."'";
//echo $sql;
$r=execute_query($sql);
if(mysqli_num_rows($r) <= 0 ){
    echo "Upload Final selection List"; die;
}
else{
    $jdata=mysqli_fetch_assoc($r);
    if($jdata['joining_date'] !=''){
        $date=$jdata['joining_date'];
      
        $day = date('d', strtotime($date));
        $month= date('m', strtotime($date));
        if($month =='03'){
            $month='मार्च';
        }
        else if($month =='04'){
            $month='अप्रैल';
        }
        else if($month =='05'){
            $month='मई';
        }
         else if($month =='06'){
            $month='जून';
        }
         else if($month =='07'){
            $month='जुलाई ';
        }
         else if($month =='08'){
            $month='अगस्त';
        }
        else{
            $month='';
        }
       
    }
    else{
        $day= date('d');
        $date= date('Y/m/d');
        $month= date('m', strtotime($date));
        if($month =='03'){
            $month='मार्च';
        }
        else if($month =='04'){
            $month='अप्रैल';
        }
        else if($month =='05'){
            $month='मई';
        }
         else if($month =='06'){
            $month='जून';
        }
        else if($month =='07'){
            $month='जुलाई ';
        }
        else if($month =='08'){
            $month='अगस्त';
        }
        else{
            $month='';
        }


    }
}
// if (!checkLogin()) {
//     header('Location: login.php');
// }
// if (isset($_SESSION['uid'])) {
//     $sql = "SELECT * FROM users WHERE `id`='" . $_SESSION['uid'] . "'";
//     $res = $conn->query($sql);
//     $data1 = mysqli_fetch_assoc($res);
// }


//topheader();

$query = "SELECT  `date_of_birth`,pd.`category`, pd.`sub_category`, pd.`divangta_avedan_krmank`, pd.`divangta_pramnpatr_kramank`,
pd.`percentage`,pd.`f_senani_sambandh`,pd.`f_senani_prmanptr`,pd.`avedika_status`,pd.`vidhwa_certificateno`,pd.`v_jarikrta_name`,pd.`v_uploaddata`,
pd.`nivas_prmaanpatr_no`, pd.`nivas_avedan_prmanpatr`,pd.`nivas_upload`,pd.`jaant_prmaanpatr_no`,pd.`jaati_avedan_prmanpatr`,
pd.`jaati_upload`, pd.`aay_prmaanpatr_no`, pd.`aay_avedan_prmanpatr`, pd.`aay_upload`,pd.`bpl_card`,
ad.`id` as academic_id, ad.`userid` as academic_userid, ad.`h_school`, ad.`i_school`, ad.`g_school`, ad.`h_board`,ad.`h_year`,ad.`h_maxmarks`,
ad.`h_totalmarks`,ad.`h_marksheetdoc`,ad.`h_otherdoc`,ad.`h_present`,ad.`i_board`,ad.`i_year`,ad.`i_maxmarks`,
ad.`i_totalmarks`, ad.`i_present`,ad.`g_board`,ad.`g_year`,ad.`g_maxmarks`,ad.`g_marksheetdoc`,ad.`g_otherdoc`,ad.`g_present`,ad.`g_totalmarks`,
nad.`id` as application_id, nad.`userid` as application_userid, nad.`district`, nad.`tehseel`, nad.`project`, nad.`grameen_sehri`
, nad.`gram_panchayat` , nad.`word_name`, nad.`nay_panchayat`, nad.`rikt_pd`, dd.`aganwadi_center`, nad.`name_hi`, nad.`pre_name`,nad.`year`,nad.`month`,nad.`day`
, nad.`name_en` ,  nad.`fname`, nad.`mname`, nad.`hname`, nad.`mobile`,ad.pg_board,ad.pg_school,ad.pg_year,ad.pg_maxmarks,ad.pg_totalmarks,ad.pg_present,dd.filled_date,dd.aganwadi_center,ud.signature,ud.photo,nad.isnew
FROM 
`personal_details` pd
JOIN 
`academic_details` ad ON pd.`userid` = ad.`userid`
JOIN 
`new_application_details` nad ON pd.`userid` = nad.`userid`
JOIN 
`decleration` dd ON nad.`userid` = dd.`userid`
JOIN 
`uploaded_documents` ud ON ud.`userid` = dd.`userid`
WHERE 
dd.`application_no` ='" . $_GET['appNo'] . "'
AND dd.district_id='".$_SESSION['distid']."'

";
//echo $query; die;
$res = $conn->query($query);
$data = mysqli_fetch_assoc($res);

$sql1="INSERT INTO `downloaded_letter`(`district_id`, `app_no`, `userid`, `timestamp`) VALUES ('".$_SESSION['distid']."','" . $_GET['appNo'] . "','".$_SESSION['adminid']."','".date('Y-m-d H:i:s')."')";
execute_query($sql1);

?>

<!DOCTYPE html>
<html lang="hi">
<head>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joining Letter - AWW UP</title>
    <style>
        
        body {
            font-family: 'Noto Sans Devanagari', sans-serif;
            line-height: 1.5;
            margin: 0;
            padding: 0;
          

        }
        .container {
            width: 210mm;
            height: 297mm;
            margin: auto;
            padding: 1px;
            border: 4px solid orange; 
            box-sizing: border-box;
            
        }
         .content {
            margin-bottom: 20px;
            text-align: justify;
        }
        .header {
                display: flex;
                align-items: center;
                justify-content: space-between;
               
              
                text-align: center;
                position: relative;
            }

            .logo {
                width: 80px; /* Adjust size if needed */
                height: auto;
            }

            .header-content {
                flex-grow: 1;
                text-align: center;
            }

            .office-name {
                font-size: 19px;
                font-weight: bold;
            }

            .details {
                font-size: 14px;
            }

            .order-title {
                font-size: 22px;
                font-weight: bold;
                text-decoration: underline;
            }

        .print-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            font-size: 16px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        .inner-border {
            position: relative;
            height: 288mm;
            padding:10px;
            border: 2px solid orange; /* Inner thin border */
        }
        .signature{
            float: right;
        }
        .last{
            float: right;
        }
        .text1{
            font-size: 18px;
            font-weight: bold;
            text-align: center;
            width:100%;
            display: block;
        }
        .pd{
            padding-left:5px;
        }

        @media print {
            .print-btn {
                display: none;
            }
        }

        @page {
            size: A4;
            margin: 0; /* Removes extra margins */
            padding:20px;
        }

        /* Ensure everything stays within one printed page */
@media print {
    .print-btn {
        display: none;
    }
    
    .container {
        page-break-inside: avoid; /* Prevent content from splitting */
    }

    .header, .inner-border, .content {
        page-break-inside: avoid; /* Prevent splitting of elements */
    }
}
    </style>
</head>
<body>
    <button class="print-btn" onclick="window.print()">Print</button>
    <div class="container">
        <div class="inner-border">
            <div class="header">
                <img src="../images/upgovt.png" class="logo left-logo" alt="Left Logo" >
                <div class="header-content">
                    <p class="office-name">कार्यालय-जिला कार्यक्रम अधिकारी, <?php echo strtoupper(getdistNamehindi($_SESSION['distid'])); ?>।</p>
                    <p class="details">पत्रांक— &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/बा0वि0परि0/आ0बा0स्था0/नियुक्ति/2025-26 &nbsp;&nbsp;दिनांक— &nbsp;&nbsp; <?php echo $day; ?> <?php echo $month; ?>  2025</p>
                
                </div>
                <img src="../images/icdslogo.png" class="logo right-logo" alt="Right Logo" >
            </div>
            <div class="text1">
                <u>नियुक्ति आदेश</u>
             </div><br>
            <div class="content">
                <p>आंगनबाड़ी कार्यकत्री की मानदेय आधारित सेवा हेतु नियुक्ति बाल विकास एवं पुष्टाहार विभाग उ0प्र0 शासन द्वारा निर्गत शासनादेश संख्या-19/2023/3975/58-1-2022-2/1(22)10टी.सी.। दिनांक 21 मार्च, 2023 में वर्णित व्यवस्थानुसार जनपद स्तर पर गठित चयन समिति की संस्तुति पर जिलाधिकारी .................................................. के अनुमोदन दिनांक-........................... के क्रम में  सुश्री/श्रीमती <b><?php echo $data['name_hi']; ?> </b> पुत्री/पत्नी <b> <?php if($data['pre_name'] == 1){ echo strtoupper($data['hname']); }else{ echo strtoupper($data['fname']); } ?> </b> निवासी ग्राम/मोहल्ला.....................................ग्राम पंचायत/वार्ड <b>
                <?php  echo strtoupper(getGrampanchayatName($data['gram_panchayat']));
                ?> </b> को आंगनबाड़ी केन्द्र <b> <?php echo strtoupper(getawwCenter($data['aganwadi_center'])); ?> </b> बाल विकास परियोजना <b> <?php echo strtoupper(getProjectname($data['project'])); ?> </b> जनपद <b><?php echo strtoupper(getdistNamehindi($_SESSION['distid'])); ?> </b>पर योगदान तिथि से आंगनबाड़ी कार्यकत्री के पद पर मानदेय के आधार पर नियुक्त किया जाता है।</p>
                <p>उक्त नियुक्ति पूर्णतः मानदेय आधारित है, जिस पर राजकीय कर्मचारी सम्बन्धित कोई भी सेवा शर्ते व नियमावली लागू नहीं होगी। इन्हें भारत सरकार एवं उ0प्र0 सरकार द्वारा समय-समय पर निर्धारित मानदेय ही देय होगा। </p>
                <p>चयनित अभ्यर्थी द्वारा प्रस्तुत निर्धारित अर्हता सम्बन्धित शैक्षिक अभिलेख, अन्य प्रमाण पत्र एवं सूचनाएं जिनके आधार पर चयन समिति द्वारा उनका उक्त पद पर चयन किया गया है, के भविष्य में असत्य/फर्जी एवं कूटरचित पाये जाने अथवा जॉचोंपरान्त उचित प्राधिकारी द्वारा निरस्त कर दिये जाने अथवा चयनित अभ्यर्थी द्वारा पद के अनुरूप कार्य न करने की दशा में बिना किसी पूर्व सूचना/नोटिस के उनकी मानदेय आधारित सेवाएं समाप्त की जा सकती हैं। ऐसी स्थिति में अभ्यर्थी का कोई भी दावा मान्य नहीं होगा।</p>
                <p>चयनित अभ्यर्थी को विभाग द्वारा प्रशिक्षण हेतु उत्तर प्रदेश में संचालित प्रशिक्षण केन्द्रों पर प्रशिक्षण प्राप्त करने हेतु निर्धारित समयावधि हेतु भेजा जायेगा। अभ्यर्थी द्वारा उक्त प्रशिक्षण प्राप्त किया जाना आवश्यक होगा। </p>
                <p>अभ्यर्थी द्वारा योगदान के समय इस आशय का नोटरीयुक्त शपथ पत्र देना होगा, जिसमें घोषणा की जायेगी कि आंगनबाड़ी कार्यकत्री के पद पर चयन हेतु आवेदन के समय पोर्टल पर एवं भौतिक सत्यापन के दौरान प्रस्तुत किये गये समस्त अभिलेख/प्रपत्र एवं सूचनाएं सत्य हैं। कोई भी तथ्य छिपाया नहीं गया है। भविष्य में यदि कोई अभिलेख/प्रपत्र/ सूचना असत्य/फर्जी/कूटरचित पायी जाती है, तो नियुक्ति निरस्त कर दी जाये।</p>
            </div>
            <div class="signature">
                <b>जिला कार्यक्रम अधिकारी</b><br>
                <b>जनपद- <?php echo strtoupper(getdistNamehindi($_SESSION['distid'])); ?></b>
            </div>
            <br><br>
            <div>
                <p>&nbsp;&nbsp;&nbsp;पृष्ठांकन संख्या-  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/बा0वि0परि0/आ0बा0स्था0/2025-26 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; दिनांक- <?php echo date('d/m/Y',strtotime($date)); ?> </P>
                <br><p>प्रतिलिपि-निम्नलिखित को सूचनार्थ एवं आवष्यक कार्य वाही हेतु प्रेषित।</p>
            </div>
            <div class="pd">
                <div class="point">1. निदेशक, बाल विकास सेवा एवं पुष्टाहार उ0प्र0 लखनऊ।</div>
                <div class="point">2. जिलाधिकारी...............................</div>
                <div class="point">3. मुख्य विकास अधिकारी..........................</div>
                <div class="point">4. बाल विकास परियोजना अधिकारी......................................</div>
                <div class="point">5. सुश्री/श्रीमती ...................... पुत्री/पत्नी श्री .............................. निवासी ....................... को अनुपालनार्थ।</div>
                <div class="point">6. कार्यालय प्रति।</div>
            </div><br>

            <div class="last"><b>जिला कार्यक्रम अधिकारी</b><br><b>जनपद- <?php echo strtoupper(getdistNamehindi($_SESSION['distid'])); ?></b></div>
        </div>
    </div>
</body>
</html>
