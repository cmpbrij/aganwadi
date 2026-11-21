<?php
include 'master.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../vendor/autoload.php';

use Mpdf\Mpdf;

if (!isset($_GET['dir'])) {
    echo "Can't Access";
    exit;
}

$uid = $_GET['dir'];
$app=$_GET['appNo'];

// Determine directory URL based on user status

    $directoryUrl = 'http://34.118.8.62/worker/newuploads/' . $uid . '/';


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
    $htmlContent = ''; 
    $mpdf = new \Mpdf\Mpdf();
$htmlContent = '';

$pair = [];  // To store photo + signature pairs

foreach ($imageUrls as $image) {

    // Extract full URL
    $imageUrl = $directoryUrl . $image;

    // Check if starts with 'photo' or 'signature'
    if (preg_match('/^(photo|signature)(\d+)\.(jpg|jpeg|png)$/i', $image, $match)) {
        $type = $match[1];   // photo or signature
        $key  = $match[2];   // number after prefix

        // Store photo & signature for same key
        if (!isset($pair[$key])) {
            $pair[$key] = [];
        }
        $pair[$key][$type] = $imageUrl;

    } else {
        // Normal images (full page)
        $htmlContent .= '<div style="page-break-after: always; text-align: center;">';
        $htmlContent .= '<img src="' . $imageUrl . '" style="width: 99%; height: auto;">';
        $htmlContent .= '</div>';
    }
}

// Now print photo + signature pairs on SAME PAGE
foreach ($pair as $key => $files) {
    $htmlContent .= '<div style="text-align:center; margin-bottom:20px;">';

    if (isset($files['photo'])) {
        $htmlContent .= '<img src="' . $files['photo'] . '" style="width:40%; margin:10px;">';
    }

    if (isset($files['signature'])) {
        $htmlContent .= '<img src="' . $files['signature'] . '" style="width:40%; margin:10px;">';
    }

    $htmlContent .= '</div>';
    $htmlContent .= '<div style="page-break-after: always;"></div>';
}

$mpdf->WriteHTML($htmlContent);



    // Save the PDF to a file
    $pdfFilePath = 'DOC_'.$app.'.pdf';
    $mpdf->Output($pdfFilePath, \Mpdf\Output\Destination::DOWNLOAD);

    // Provide download link for the generated PDF
    // echo "PDF generated successfully: <a href='AllImages.pdf' target='_blank'>Download PDF</a>";
} catch (\Mpdf\MpdfException $e) {
    echo 'MPDF Error: ' . $e->getMessage();
} catch (Exception $e) {
    echo 'General Error: ' . $e->getMessage();
}
?>
