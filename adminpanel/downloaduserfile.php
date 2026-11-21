<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if 'file' parameter is set
if (isset($_GET['file'])) {
    $fileUrl = $_GET['file'];
    
    // Context options to disable SSL verification (only for testing)
    $contextOptions = array(
        "ssl" => array(
            "verify_peer" => false,
            "verify_peer_name" => false,
        ),
    );

    $context = stream_context_create($contextOptions);

    // Fetch the file content
    $fileContent = @file_get_contents($fileUrl, false, $context); // Suppress warnings

    if ($fileContent === FALSE) {
        die("Error: Unable to download the file.");
    }

    // Set headers for the download
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($fileUrl) . '"');
    header('Content-Length: ' . strlen($fileContent));

    // Output the file content
    echo $fileContent;
} else {
    echo "No file specified for download.";
}
?>
