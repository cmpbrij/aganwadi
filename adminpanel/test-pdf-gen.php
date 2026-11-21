<?php
include 'master.php';
//include('../config/settings.php');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


require_once __DIR__ . '/../vendor/autoload.php';

use Mpdf\Mpdf;

if (!isset($_GET['dir'])) {
    echo "Can't Access";
    exit;
}

$uid = $_GET['dir'];

$sql = "SELECT isnew FROM users WHERE id='" . $uid . "'";
$res = execute_query($sql);
$data = mysqli_fetch_assoc($res);

// Determine directory URL based on user status
$directoryUrl = 'http://34.116.192.0/uploads/' . $uid . '/';
if ($data['isnew'] == '1') {
    $directoryUrl = 'http://34.118.8.62/newuploads/' . $uid . '/';
}

// Disable SSL verification (for testing purposes)
$contextOptions = [
    "ssl" => [
        "verify_peer" => false,
        "verify_peer_name" => false,
    ],
];
$context = stream_context_create($contextOptions);

// Fetch the HTML content of the directory
$html = file_get_contents($directoryUrl, false, $context);

if ($html === false) {
    die("Failed to fetch the directory content.");
}

// Use regular expressions to extract image URLs
preg_match_all('/href="([^"]+\.(jpg|jpeg|png|gif))"/i', $html, $matches);
$imageUrls = $matches[1];

if (empty($imageUrls)) {
    die("No images found in the directory.");
}

try {
    $mpdf = new Mpdf();

    $htmlContent = ''; // Initialize HTML content for PDF

    //Form
   
    $appNo = isset($_GET['appNo']) ? $_GET['appNo'] : die('Application No missing');

// Fetch data from the database
$query = "SELECT  pd.`category`, pd.`sub_category`, pd.`divangta_avedan_krmank`, pd.`divangta_pramnpatr_kramank`,
pd.`percentage`, pd.`f_senani_sambandh`, pd.`f_senani_prmanptr`, pd.`avedika_status`, pd.`vidhwa_certificateno`, pd.`v_jarikrta_name`, pd.`v_uploaddata`,
pd.`nivas_prmaanpatr_no`, pd.`nivas_avedan_prmanpatr`, pd.`nivas_upload`, pd.`jaant_prmaanpatr_no`, pd.`jaati_avedan_prmanpatr`,
pd.`jaati_upload`, pd.`aay_prmaanpatr_no`, pd.`aay_avedan_prmanpatr`, pd.`aay_upload`, pd.`bpl_card`,
ad.`id` as academic_id, ad.`userid` as academic_userid, ad.`h_school`, ad.`i_school`, ad.`g_school`, ad.`h_board`, ad.`h_year`, ad.`h_maxmarks`,
ad.`h_totalmarks`, ad.`h_marksheetdoc`, ad.`h_otherdoc`, ad.`h_present`, ad.`i_board`, ad.`i_year`, ad.`i_maxmarks`,
ad.`i_totalmarks`, ad.`i_present`, ad.`g_board`, ad.`g_year`, ad.`g_maxmarks`, ad.`g_marksheetdoc`, ad.`g_otherdoc`, ad.`g_present`, ad.`g_totalmarks`,
nad.`id` as application_id, nad.`userid` as application_userid, nad.`district`, nad.`tehseel`, nad.`project`, nad.`grameen_sehri`,
nad.`gram_panchayat`, nad.`word_name`, nad.`nay_panchayat`, nad.`rikt_pd`, dd.`aganwadi_center`, nad.`name_hi`, nad.`pre_name`, nad.`year`, nad.`month`, nad.`day`,
nad.`name_en`, nad.`fname`, nad.`mname`, nad.`hname`, nad.`mobile`, ad.pg_board, ad.pg_school, ad.pg_year, ad.pg_maxmarks, ad.pg_totalmarks, ad.pg_present,
dd.filled_date, dd.aganwadi_center, ud.signature, ud.photo, nad.isnew
FROM `personal_details` pd
JOIN `academic_details` ad ON pd.`userid` = ad.`userid`
JOIN `new_application_details` nad ON pd.`userid` = nad.`userid`
JOIN `decleration` dd ON nad.`userid` = dd.`userid`
JOIN `uploaded_documents` ud ON ud.`userid` = dd.`userid`
WHERE dd.`application_no` = '$appNo'";

$res = $conn->query($query);
$data = mysqli_fetch_assoc($res);

// Handle images securely
$sig = preg_replace('/\.\.\//', '', $data['signature']);
$photo = preg_replace('/\.\.\//', '', $data['photo']);

$directoryUrl = 'http://34.116.192.0';
if ($data['isnew'] == 1) {
    $directoryUrl = 'http://34.118.8.62';
}

// Generate Base64 Image Data
$imagePath = $directoryUrl . '/' . $photo;
$imageData = base64_encode(file_get_contents($imagePath));

$sigPath = $directoryUrl . '/' . $sig;
$sigData = base64_encode(file_get_contents($sigPath));

// Generate HTML content
$htmlContent = '
<style>
    body { font-family: "Devanagari", sans-serif; }
    .card { padding: 20px; border: 1px solid #ccc; }
    .headingTop { display: flex; justify-content: space-between; font-size: 18px; font-weight: bold; }
    .text-center { text-align: center; }
    .padding-4 { padding: 4px; }
    table { width: 100%; border-collapse: collapse; }
    td { padding: 8px; border: 1px solid #ccc; }
</style>

<div class="card">
    <div class="headingTopMain">
        <b>आंगनवाड़ी एप्लीकेशन फॉर्म - 2024</b><br>
        बाल विकास परियोजना : ' . htmlspecialchars($data['project']) . '
    </div>

    <div class="headingTop">
        <div class="left">पंजीकरण संख्या : ' . $appNo . '</div>
        <div class="right">आवेदन तिथि : ' . date('d-m-Y', strtotime($data['filled_date'])) . '</div>
    </div>

    <table>
        <tr>
            <td class="text-center"><b>पद का नाम</b></td>
            <td class="padding-4">आंगनवाड़ी कार्यकत्री</td>
            <td rowspan="6">
                <img src="data:image/jpeg;base64,' . $imageData . '" style="width:180px;height:140px;padding:2px;border:2px solid #ccc;" />
                <br>
                <img src="data:image/jpeg;base64,' . $sigData . '" style="width:180px;height:50px;padding:2px;border:1px solid #ccc;" />
            </td>
        </tr>
        <tr>
            <td class="text-center"><b>रिक्त केंद्र का नाम</b></td>
            <td class="padding-4">' . htmlspecialchars($data['aganwadi_center']) . '</td>
        </tr>
        <tr>
            <td class="text-center"><b>ग्राम सभा/वार्ड का नाम</b></td>
            <td class="padding-4">' . htmlspecialchars($data['gram_panchayat']) . '</td>
        </tr>
        <tr>
            <td class="text-center"><b>आवेदिका का नाम</b></td>
            <td class="padding-4">' . htmlspecialchars($data['pre_name']) . ' ' . htmlspecialchars($data['name_hi']) . ' (' . htmlspecialchars($data['name_en']) . ')</td>
        </tr>
        <tr>
            <td class="text-center"><b>पति का नाम</b></td>
            <td class="padding-4">' . htmlspecialchars($data['hname']) . '</td>
        </tr>
        <tr>
            <td class="text-center"><b>पिता का नाम</b></td>
            <td class="padding-4">' . htmlspecialchars($data['fname']) . '</td>
        </tr>
    </table>
</div>';



    //end

    // Loop through each image and add it to the HTML content
    foreach ($imageUrls as $image) {
        // Construct full URL for each image
        $imageUrl = $directoryUrl . $image;

        // Debug: Print image URL to confirm it’s correct
      //  echo "Adding image: " . $imageUrl . "<br>"; // You can remove this after confirming the URLs are correct

        // Concatenate the image into the PDF content
        $htmlContent .= '<div style="page-break-after: always; text-align: center;">';
        $htmlContent .= '<img src="' . $imageUrl . '" style="width: 100%; height: auto;">';
        $htmlContent .= '</div>';
    }

    // Write HTML content to the PDF
    $mpdf->WriteHTML($htmlContent);

    // Save the PDF to a file
    $pdfFilePath = '/Allcandidate_'.$uid.'.pdf';
    $mpdf->Output($pdfFilePath, \Mpdf\Output\Destination::DOWNLOAD);

    // Provide download link for the generated PDF
    echo "PDF generated successfully: <a href='AllImages.pdf' target='_blank'>Download PDF</a>";
} catch (\Mpdf\MpdfException $e) {
    echo 'MPDF Error: ' . $e->getMessage();
} catch (Exception $e) {
    echo 'General Error: ' . $e->getMessage();
}
?>
