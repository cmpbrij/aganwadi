<?php
include 'master.php';
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

use Mpdf\Mpdf;

if (!isset($_GET['dir'])) {
    echo "Can't Access";
    exit;
}

$uid = $_GET['dir'];
$app=$_GET['appNo'];

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
    $htmlContent = ''; 
    foreach ($imageUrls as $image) {
        // Construct full URL for each image
        $imageUrl = $directoryUrl . $image;
        $htmlContent .= '<div style="page-break-after: always; text-align: center;">';
        $htmlContent .= '<img src="' . $imageUrl . '" style="width: 99%; height: auto;">';
        $htmlContent .= '</div>';
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
