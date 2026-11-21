<?php
header("Access-Control-Allow-Origin: *");
include('../config/db_config.php');
include('../config/settings.php');
if(!isset($_SESSION['adminid'])){
    echo"Can't view login again"; die;
}

// if (!checkLogin()) {
//     header('Location: login.php');
// }
// if (isset($_SESSION['uid'])) {
//     $sql = "SELECT * FROM users WHERE `id`='" . $_SESSION['uid'] . "'";
//     $res = $conn->query($sql);
//     $data1 = mysqli_fetch_assoc($res);
// }


topheader();

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
dd.`application_no` ='" . $_GET['appNo'] . "'";
//echo $query; die;
$res = $conn->query($query);
$data = mysqli_fetch_assoc($res);
//print_r($data); die;

// $sql = "SELECT * FROM `uploaded_documents` WHERE userid='" . $_SESSION['uid'] . "'";
// $row = execute_query($sql);
// $udata = mysqli_fetch_array($row);

$sig = preg_replace('/\.\.\//', '', $data['signature']);
$photo = preg_replace('/\.\.\//', '', $data['photo']);

//echo $photo; die;
?>
<!doctype html>
<!-- <html lang="{{str_replace('_', '-', app()->getLocale())}}"> -->
<html>
<title>Registration : Anganwadi Recruitment 2024</title>
<meta charset="utf-8">
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.css" integrity="sha512-0TsYUclL0x2HXTMBHTQyrsFGsELlmYZRsmq8OG1SkV6V2lRzsZoFEddMf1dsqySJIegvLmrowaeiA9HNop2dXA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/0.3.3/sweet-alert.min.css" integrity="sha512-gpqtQIgLIXYBimyliA0xmgme7m5coXHQhscvqhAZcOoPlKOmEzPg2BhYIYV/d39j7fEkXh42UeVt7g5PzUtfSg==" crossorigin="anonymous" referrerpolicy="no-referrer" /> -->
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

<script src="../public/js/html2pdf.bundle.min.js"></script>
<script src="../public/js/html2canvas.min.js"></script>
<script src="../public/js/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
   
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

    @media print{
   
    .header{ display:none;}
   
    #print{ margin-left:0px;}
}
</style>
<style>
    @media print {
        /* Ensure that borders and other styles are preserved */
        table, th, td {
            border: 1px solid black !important;
            border-collapse: collapse !important;
        }
        
        .card-body {
            padding: 10px !important;
        }
        
        /* Hide any elements that should not be printed */
        .no-print {
            display: none !important;
        }
    }
</style>


<body class="dashbg">

    <div class="card">
        <div class="card-body" id="print">
            <!-- <h2>Preview Form</h2> -->
            <div class="headingTopMain mt-3">
                <b>आंगनवाड़ी एप्लीकेशन फॉर्म - 2024</b><br>
                <!-- आंगनबाड़ी कार्यकत्रियों, मिनी आंगनबाड़ी कार्यकत्रियों. एवं सहायिकाओं की
                मानदेय पर संविदा आधारित नियुक्ति -->
                <br />
                बाल विकास परियोजना : <?php echo getProjectname($data['project']); ?>
            </div>
            <div class="headingTop">
                <div class="left"><b>पंजीकरण संख्या : <?php echo $_GET['appNo']; ?></b></div>
                <div class="right"><b>आवेदन तिथि : <?php echo date('d-m-Y',strtotime($data['filled_date'])); ?></b></div>
            </div>
            <?php
            // print_r($data);   
            // die;              
            ?>
            <table style="width: 100%" id="order-listing1">
                <thead>
                    <tr>
                        <!-- <td style="width: 5%"></td> -->
                        <td style="width: 30%" class="text-center"><b>पद का नाम</b></td>
                        <td style="width: 60%" class="padding-4">आंगनवाड़ी कार्यकत्री</td>
                        <td rowspan="6" style="width: fit-content !important">
                            <!-- <img src="http://34.116.192.0/uploads/553324/photo1712586920.jpg" style="width:180px;height: 140px;padding:2px; border: 2px solid #ccc;" /> -->
                             <?php
                           //  echo $data['isnew']; 
                              $directoryUrl = 'http://34.116.192.0';
                              if ($data['isnew']==1) {
                               
                                $directoryUrl = 'http://34.118.8.62';
                            }
                            $imagePath = $directoryUrl.'/'.$photo;
                          // echo $imagePath; die;
                            $imageData = base64_encode(file_get_contents($imagePath));
                            echo '<img src="data:image/jpeg;base64,' . $imageData . '" style="width:180px;height: 140px;padding:2px; border: 2px solid #ccc;" />';
                            ?>

                            <?php
                            $imagePath = $directoryUrl.'/'.$sig;
                            $imageData = base64_encode(file_get_contents($imagePath));
                            echo '<img src="data:image/jpeg;base64,' . $imageData . '" style="width:180px;height: 50px;padding:2px; border: 1px solid #ccc;" />';
                            ?>

                            <!-- <img src="http://34.116.192.0/<?php echo $sig; ?>" style="width:180px;height: 50px;padding:2px; border: 1px solid #ccc;"> -->
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
                        <td class="padding-4"> <?php echo getawwCenter($data['aganwadi_center']); ?></td>
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
                        <td class="padding-4"><?php echo getPrename($data['pre_name']); ?> <?php echo $data['name_hi']; ?>(<?php echo $data['name_en']; ?>)</td>
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
                    <td colspan="2" ><?php echo $data['date_of_birth']; ?></td>
                    </tr>
                    <tr>
                        <!-- <td style="width: 5%">16</td> -->
                        <td colspan="1" class="text-center"><b>आधार नंबर:</b> </td>
                        <td colspan="2"> <?php echo $data1['aadhar_no']; ?></td>
                    </tr>
                    <tr>
                        
                        <td  class="text-center" colspan="3" style="font-weight: 700 !important"> आवेदिका की आयु</td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div style="display: flex; justify-content: space-around">
                                <div>वर्ष: <?php echo $data['year'];  ?> </div>
                                <div>माह: <?php echo $data['month'];  ?> </div>
                                <div>दिन: <?php echo $data['day'];  ?></div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                       
                        <td colspan="3" class="text-center" style="font-weight: 700 !important">शैक्षणिक योग्यता का विवरण</td>
                    </tr>
                    <tr>
                        <table style="width: 100%; border: none !important">
                            <thead style="font-weight: 700 !important">
                                <tr>
                                    <td class="text-center">क्र. स.</td>
                                    <td class="text-center">कक्षा</td>
                                    <td class="text-center" style="width: 25%">विद्यालय का नाम</td>
                                    <td class="text-center">बोर्ड का नाम</td>
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
                                    <td class="text-center"><?php echo $data['h_board']; ?></td>
                                    <td class="text-center"><?php echo $data['h_year']; ?></td>
                                    <td class="text-center"><?php echo $data['h_maxmarks']; ?></td>
                                    <td class="text-center"><?php echo $data['h_totalmarks']; ?></td>
                                    <td class="text-center"><?php echo $data['h_present']; ?></td>
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td class="text-center">इंटर</td>
                                    <td class="text-center" style="width: 25%"><?php echo $data['i_school']; ?></td>
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
                                    <td  class="text-center" style="width: 25%"><?php echo $data['pg_school']; ?></td>
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
            <p style="color:red;line-height:30px;"> मैं घोषणा करती हूँ कि मैने उक्त पद से सम्मान्धित प्रकाशित विज्ञप्ति को ध्यानपूर्वक पढ़ा है चयन से सम्बन्धित सभी शर्ते मुझे मान्य हैं। आवेदन-पत्र में अंकित सभी सूचना व आवेदन-पत्र के साथ सभी विवरण सत्य एवं सही है। भविष्य में यदि कोई तथ्य फर्जी/ असत्य पाये जाते हैं या छिपाया गया पाया जाता है, तो आवेदिका का अभ्यर्थन/निपुक्ति निरस्त कर समुचित वैधानिक कार्यवाही की जाएगी।</p>
             </div>
            <div class="col-12 text-center no-print">
                    <!-- <a><button class="btn btn-primary" id="btnprint" type="button">Download PDF</button></a> -->
                    <a><button class="btn btn-success" id="printButton" type="button">&nbsp;&nbsp;&nbsp;&nbsp;Print&nbsp;&nbsp;&nbsp;&nbsp;</button></a>
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
    document.getElementById("printButton").addEventListener("click", function () {
        window.print();
    });
</script>
<script>
    document.getElementById('btnprint').addEventListener('click', () => {
    const { jsPDF } = window.jspdf;

    // Options for html2canvas
    const options = {
        scale: 2, // Increase scale for better quality
        scrollY: -window.scrollY, // Consider window scroll position
        windowWidth: document.getElementById('print').scrollWidth, // Full width of content
        windowHeight: document.getElementById('print').scrollHeight, // Full height of content
    };

    // Convert HTML to canvas
    html2canvas(document.getElementById('print'), options).then(canvas => {
        const imgData = canvas.toDataURL('image/png');
        const pdf = new jsPDF('p', 'mm', 'a4'); // Use A4 size

        // Define margins
        const margin = 10; // 10 mm margin
        const imgWidth = 210 - 2 * margin; // A4 width in mm minus margins
        const pageHeight = 297; // A4 height in mm
        const imgHeight = (canvas.height * imgWidth) / canvas.width;
        let heightLeft = imgHeight;

        let position = margin;

        // Add image to PDF with margins
        pdf.addImage(imgData, 'PNG', margin, position, imgWidth, imgHeight);
        heightLeft -= (pageHeight - 2 * margin);

        // Loop over the rest of the pages
        while (heightLeft >= 0) {
            position = heightLeft - imgHeight + margin;
            pdf.addPage();
            pdf.addImage(imgData, 'PNG', margin, position, imgWidth, imgHeight);
            heightLeft -= (pageHeight - 2 * margin);
        }

        // Save the PDF
        pdf.save('Application Form.pdf');
    });
});

</script>
    </div>
    </div>
    
</body>

</html>