<?php

header("Access-Control-Allow-Origin: *");
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include('../config/db_config.php');
include('../config/settings.php');

if (!isset($_SESSION['adminid'])) {
    echo "Can't view login again";
    die;
}

if (!isset($_SESSION['distid'])) {
    header("Location: https://upanganwadibharti.in/");
    exit;
}

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

/*
|--------------------------------------------------------------------------
| Common function for Hindi month name
|--------------------------------------------------------------------------
*/
function getHindiMonthName($month)
{
    $months = [
        '01' => 'जनवरी',
        '02' => 'फ़रवरी',
        '03' => 'मार्च',
        '04' => 'अप्रैल',
        '05' => 'मई',
        '06' => 'जून',
        '07' => 'जुलाई',
        '08' => 'अगस्त',
        '09' => 'सितम्बर',
        '10' => 'अक्टूबर',
        '11' => 'नवंबर',
        '12' => 'दिसंबर'
    ];

    return isset($months[$month]) ? $months[$month] : '';
}

/*
|--------------------------------------------------------------------------
| Check uploaded final list
|--------------------------------------------------------------------------
*/
$sql = "SELECT district, `date` 
        FROM uploaded_final_list 
        WHERE district='" . $_SESSION['distid'] . "'";

$r = execute_query($sql);

if (mysqli_num_rows($r) <=0) {
    echo "Upload Final selection List";
    die;
} else {

    /*
    |--------------------------------------------------------------------------
    | Get latest letter date setting
    |--------------------------------------------------------------------------
    */
    $qr = "SELECT * 
           FROM letter_date_setting 
           WHERE dist_id = '" . $_SESSION['distid'] . "' 
           ORDER BY id DESC 
           LIMIT 1";

    $res1 = execute_query($qr);
    $jdata = mysqli_fetch_assoc($res1);

    if (!empty($jdata['letter_date'])) {
        $date  = $jdata['letter_date'];
        $day   = date('d', strtotime($date));
        $month = date('m', strtotime($date));
        $year  = date('Y', strtotime($date));

        $monthname = getHindiMonthName($month);

        $dateset = $day . ' ' . $monthname . ' ' . $year;
       
    } else {
         $date  = date('Y/m/d');
        $day   = date('d');
       
        $month = date('m', strtotime($date));
        $year  = date('Y', strtotime($date));

        $month = getHindiMonthName($month);

       $dateset = $day . ' ' . $month . ' ' . $year;
    }
}

/*
// if (!checkLogin()) {
//     header('Location: login.php');
// }
// if (isset($_SESSION['uid'])) {
//     $sql = "SELECT * FROM users WHERE `id`='" . $_SESSION['uid'] . "'";
//     $res = $conn->query($sql);
//     $data1 = mysqli_fetch_assoc($res);
// }

// topheader();
*/

/*
|--------------------------------------------------------------------------
| Main applicant data query
|--------------------------------------------------------------------------
*/
$sql = "SELECT 
            nad.userid,
            nad.grameen_sehri,
            nv.awc_urban_rural,
            nad.pre_name,
            nad.nay_panchayat,
            COALESCE(NULLIF(TRIM(nv.gp_name), ''), nv.ward_name) AS gram_panchayat_name,
            nad.gram_panchayat,
            nad.pre_name,
            nad.name_hi,
            nad.name_en,
            nad.rikt_aww_center,
            nad.date_of_birth,
            nad.fname,
            nad.mname,
            nad.hname,
            nad.mobile,
            nad.age_years,
            nad.age_months,
            nad.age_days,
            pd.category AS cast,
            pd.sub_category,
            pd.avedika_status,
            pd.bpl_card,
            ad.i_present,
            ad.g_present,
            ad.pg_present,
            ad.merit,
            d.application_no,
            d.aganwadi_center,
            pd.drl_no,
            pd.death_date,
            pd.death_person_name,
            pd.divangta_pramnpatr_kramank,
            pd.divangta_avedan_krmank,
            pd.f_senani_sambandh,
            pd.f_senani_prmanptr,
            pd.avedika_status,
            pd.vidhwa_certificateno,
            pd.nivas_prmaanpatr_no,
            pd.nivas_avedan_prmanpatr,
            pd.nivas_upload,
            pd.jaant_prmaanpatr_no,
            pd.jaati_avedan_prmanpatr,
            pd.jaati_upload,
            pd.aay_prmaanpatr_no,
            pd.aay_avedan_prmanpatr,
            pd.aay_upload,
            ad.i_school,
            ad.i_board,
            ad.i_year,
            ad.i_maxmarks,
            ad.i_totalmarks,
            ad.i_present,
            ad.g_present,
            ad.pg_present,
            pd.v_jarikrta_name,
            pd.v_uploaddata,
            ad.h_marksheetdoc,
            ad.h_otherdoc,
            ad.i_marksheetdoc,
            ad.i_otherdoc,
            ad.g_totalmarks,
            ad.g_maxmarks,
            ad.g_present,
            ad.g_marksheetdoc,
            ad.g_otherdoc,
            ad.pg_totalmarks,
            ad.pg_maxmarks,
            ad.pg_marksheetdoc,
            ad.pg_otherdoc,
            d.id AS did,
            d.remarks,
            d.selection_status,
            nv.awc_name,
            nv.unique_code,
            nv.vacancy_available,
            nv.category,
            d.income_issue_date,
            d.created,
            pd.varshik_aay,
            nad.permanent_full_address,
            nad.permanent_full_address_pincode,
            d.income_issue_date,
            d.created,
            pd.niwash_file,
            pd.jaati_upload,
            pd.aay_upload,
            pd.jaati,
            pd.varshik_aay,
            pd.aay_prmaanpatr_issue_date,
            nad.h_marksheet,
            pd.grampanchayatname,
            pd.aganvadi_center,
            d.final_remarks,
            d.final_selection,
            d.project_id,
            nad.marital_status,
            d.letter_date
        FROM decleration d
        INNER JOIN new_application_details nad ON d.userid = nad.userid
        INNER JOIN personal_details pd ON nad.userid = pd.userid
        INNER JOIN academic_details ad ON ad.userid = pd.userid
        LEFT JOIN new_vacancy nv ON nv.id = d.aganwadi_center
        WHERE d.district_id = '" . $_SESSION['distid'] . "'
          AND d.application_no = '" . $_GET['appNo'] . "'";

// echo $sql; die;

$res  = $conn->query($sql);
$data = mysqli_fetch_assoc($res);

/*
|--------------------------------------------------------------------------
| Insert download log
|--------------------------------------------------------------------------
*/
$sql1 = "INSERT INTO downloaded_letter (district_id, app_no, userid, timestamp)
         VALUES (
             '" . $_SESSION['distid'] . "',
             '" . $_GET['appNo'] . "',
             '" . $_SESSION['adminid'] . "',
             '" . date('Y-m-d H:i:s') . "'
         )";
execute_query($sql1);

/*
|--------------------------------------------------------------------------
| Set letter date and approval date
|--------------------------------------------------------------------------
*/
if (empty($jdata['letter_date'])) {
     $date  = date('Y/m/d');
    $letterdate    = date('d/m/Y', strtotime($date));
    $anumodan_date = date('d/m/Y', strtotime($date));
} else {
   
    $anumodan_date = date('d/m/Y', strtotime($jdata['anumodan_date']));
    $letterdate    = date('d/m/Y', strtotime($jdata['letter_date']));
}

?>

<!DOCTYPE html>
<html lang="hi">
<head>
<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Devanagari&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Joining Letter - AWH UP</title>
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
                font-size: 26px;
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
            padding:15px;
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
                <img src="/images/upgovt.png" class="logo left-logo" alt="Left Logo" >
                <div class="header-content">
                    <p class="office-name">कार्यालय-जिला कार्यक्रम अधिकारी, <?php echo getdistNamehindi($_SESSION['distid']); ?></p>
                    <p class="details">पत्रांक— &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/बा0वि0परि0/आ0बा0स्था0/नियुक्ति/2026-27 &nbsp;&nbsp;दिनांक— &nbsp;&nbsp; <?php echo $dateset; ?>  </p>
                
                </div>
                <img src="/images/icdslogo.png" class="logo right-logo" alt="Right Logo" >
            </div>
            <div class="text1">
                <u>नियुक्ति आदेश</u>
             </div>
            <div class="content">
               <p>आंगनबाड़ी कार्यकत्री की मानदेय आधारित सेवा हेतु नियुक्ति बाल विकास एवं पुष्टाहार विभाग उ0प्र0 शासन द्वारा निर्गत शासनादेश संख्या-54/4/2025-महिला एवं बाल विकास अनुभाग-२ I/1092245/2025/3313/58-1-2025(1917687) दिनांक 17 सितम्बर, 2025 में वर्णित व्यवस्थानुसार जनपद स्तर पर गठित चयन समिति की संस्तुति पर जिलाधिकारी <?php echo strtoupper(getdistNamehindi($_SESSION['distid'])); ?>  के अनुमोदन दिनांक- <?php echo $anumodan_date; ?> के क्रम में  सुश्री/श्रीमती <b><?php echo $data['name_hi']; ?> </b>   <?php if($data['marital_status'] == 1){ echo "पत्नी <b>". strtoupper($data['hname']); }else{ echo "</b>पुत्री <b>". strtoupper($data['fname']); } ?> </b> निवासी ग्राम/मोहल्ला ................................................................ ग्राम पंचायत/वार्ड <b>
                <?php  echo strtoupper($data['gram_panchayat_name']);
                ?> </b> को आंगनबाड़ी केन्द्र <b> <?php echo strtoupper(getawwCenter($data['aganwadi_center'])); ?>(सेंटर कोड: <?php echo strtoupper(getawwCode($data['aganwadi_center'])); ?>) </b> बाल विकास परियोजना <b> <?php echo strtoupper(getBlockName($data['project_id'])); ?> </b> जनपद <b><?php echo strtoupper(getdistNamehindi($_SESSION['distid'])); ?> </b>पर योगदान तिथि से आंगनबाड़ी कार्यकत्री  के पद पर मानदेय के आधार पर नियुक्त किया जाता है।</p>
                <p>उक्त नियुक्ति पूर्णतः मानदेय आधारित है, जिस पर राजकीय कर्मचारी सम्बन्धित कोई भी सेवा शर्ते व नियमावली लागू नहीं होगी। इन्हें भारत सरकार एवं उ0प्र0 सरकार द्वारा समय-समय पर निर्धारित मानदेय ही देय होगा। </p>
                <p>चयनित अभ्यर्थी द्वारा प्रस्तुत निर्धारित अर्हता सम्बन्धित शैक्षिक अभिलेख, अन्य प्रमाण पत्र एवं सूचनाएं जिनके आधार पर चयन समिति द्वारा उनका उक्त पद पर चयन किया गया है, के भविष्य में असत्य/फर्जी एवं कूटरचित पाये जाने अथवा जॉचोंपरान्त सक्षम प्राधिकारी द्वारा निरस्त कर दिये जाने अथवा चयनित अभ्यर्थी द्वारा पद के अनुरूप कार्य न करने की दशा में बिना किसी पूर्व सूचना/नोटिस के उनकी मानदेय आधारित सेवाएं समाप्त की जा सकती हैं। ऐसी स्थिति में अभ्यर्थी का कोई भी दावा मान्य नहीं होगा।</p>
                <p>चयनित अभ्यर्थी को विभाग द्वारा प्रशिक्षण हेतु उत्तर प्रदेश में संचालित प्रशिक्षण केन्द्रों पर प्रशिक्षण प्राप्त करने हेतु निर्धारित समयावधि हेतु भेजा जायेगा। अभ्यर्थी द्वारा उक्त प्रशिक्षण प्राप्त किया जाना आवश्यक होगा। </p>
                <p>अभ्यर्थी द्वारा योगदान के समय इस आशय का नोटरीयुक्त शपथ पत्र देना होगा, जिसमें घोषणा की जायेगी कि आंगनबाड़ी कार्यकत्री के पद पर चयन हेतु आवेदन के समय पोर्टल पर एवं भौतिक सत्यापन के दौरान प्रस्तुत किये गये समस्त अभिलेख/प्रपत्र एवं सूचनाएं सत्य हैं। कोई भी तथ्य छिपाया नहीं गया है। भविष्य में यदि कोई अभिलेख/प्रपत्र/ सूचना असत्य/फर्जी/कूटरचित पायी जाती है, तो नियुक्ति निरस्त कर दी जाये।</p>
            </div>
            <div class="signature">
                <b>जिला कार्यक्रम अधिकारी</b><br>
                <b>जनपद- <?php echo strtoupper(getdistNamehindi($_SESSION['distid'])); ?></b>
            </div>
            <br><br>
            <div>
                <p>&nbsp;पृष्ठांकन संख्या- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/बा0वि0परि0/आ0बा0स्था0/2026-27 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; दिनांक- <?php echo $letterdate; ?> </P>
                <br><p>प्रतिलिपि- निम्नलिखित को सूचनार्थ एवं आवश्यक कार्यवाही हेतु प्रेषित।</p>
            </div>
            <div class="pd">
                <div class="point">1. निदेशक, बाल विकास सेवा एवं पुष्टाहार उ0प्र0 लखनऊ।</div>
                <div class="point">2. जिलाधिकारी <?php echo strtoupper(getdistNamehindi($_SESSION['distid'])); ?></div>
                <div class="point">3. मुख्य विकास अधिकारी <?php echo strtoupper(getdistNamehindi($_SESSION['distid'])); ?></div>
                <div class="point">4. बाल विकास परियोजना अधिकारी  <?php echo strtoupper(getBlockName($data['project_id'])); ?></div>
                <div class="point">5. सुश्री/श्रीमती  <?php echo $data['name_hi']; ?> <?php if($data['marital_status'] == 1){ echo "पत्नी ". strtoupper($data['hname']); }else{ echo "पुत्री ". strtoupper($data['fname']); } ?> निवासी <?php  echo strtoupper($data['gram_panchayat_name']); ?>  को अनुपालनार्थ।</div>
                <div class="point">6. कार्यालय प्रति।</div>
            </div>

            <div class="last"><b>जिला कार्यक्रम अधिकारी</b><br><b>जनपद- <?php echo strtoupper(getdistNamehindi($_SESSION['distid'])); ?></b></div>
        </div>
    </div>
</body>
</html>
