<?php
include('config/db_config.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
echo "Niwash API";

$url1 = "https://edistrict.up.gov.in/wsedistverifycertdept/service.asmx/RetCertDetails?applicationNo=221330020040953&CertificateID=023222017757&secKey=VsKQb24%23kic23N";

$sql = "SELECT userid,nivas_prmaanpatr_no, nivas_avedan_prmanpatr FROM personal_details LIMIT 1";
echo $sql;


$res=execute_query($sql);
while($row=mysqli_fetch_assoc($res)){

 $url = "https://edistrict.up.gov.in/wsedistverifycertdept/service.asmx/RetCertDetails?applicationNo=".$row['nivas_avedan_prmanpatr']."&CertificateID=".$row['nivas_prmaanpatr_no']."&secKey=VsKQb24%23kic23N";
 echo $url;

//  echo $row['nivas_avedan_prmanpatr'];
//  echo $row['nivas_prmaanpatr_no'];
// Initialize cURL
$ch = curl_init();

// Set the URL
curl_setopt($ch, CURLOPT_URL, $url1);

// Set the option to return the response as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

// Execute the cURL request
$response = curl_exec($ch);


// Check if any error occurred
if (curl_errno($ch)) {
    //echo 'Error:' . curl_error($ch);
    curl_close($ch);

    $sql="INSERT INTO `api_niwash_data`(`reg_id`,`applicationNo`,`CertificateID`,`remarks`,CertificateStatus) VALUES ('".$row['userid']."','".$row['nivas_avedan_prmanpatr']."','".$row['nivas_prmaanpatr_no']."','curl_error','0')";
    execute_query($sql);
    continue;

}

// Close cURL resource
curl_close($ch);

// Debug: Output the raw response
//echo "Raw response: " . htmlspecialchars($response) . "\n";

// Parse the XML response
$xml_response = simplexml_load_string($response);

// Check if the XML was parsed correctly
if ($xml_response === false) {
   // echo "Error occurred while parsing XML.\n";
    $sql="INSERT INTO `api_niwash_data`(`reg_id`,`applicationNo`,`CertificateID`,`remarks`,CertificateStatus) VALUES ('".$row['userid']."','".$row['nivas_avedan_prmanpatr']."','".$row['nivas_prmaanpatr_no']."','xml_response_error','0')";
    execute_query($sql);
    continue;
}

// Extract the actual XML content from the <string> node
$actual_xml_content = htmlspecialchars_decode($xml_response);

// Parse the extracted XML content
$actual_xml = simplexml_load_string($actual_xml_content);

// Check if the actual XML was parsed correctly
if ($actual_xml === false) {
   // echo "Error occurred while parsing XML.\n";
    $sql="INSERT INTO `api_niwash_data`(`reg_id`,`applicationNo`,`CertificateID`,`remarks`,CertificateStatus) VALUES ('".$row['userid']."','".$row['nivas_avedan_prmanpatr']."','".$row['nivas_prmaanpatr_no']."','parsing_error','0')";
    execute_query($sql);
    continue;
}

$data = [
    'CertificateStatus' => (string) $actual_xml->CertificateStatus,
    'applicationNo' => (string) $actual_xml->applicationNo,
    'CertificateID' => (string) $actual_xml->CertificateID,
    'IssueDate' => (string) $actual_xml->IssueDate,
    'ApplicantName' => (string) $actual_xml->ApplicantName,
    'ApplicantNameEng' => (string) $actual_xml->ApplicantNameEng,
    'Father_Husband_Name' => (string) $actual_xml->Father_Husband_Name,
    'Tehsil' => (string) $actual_xml->Tehsil,
    'District' => (string) $actual_xml->District
];

$sql="INSERT INTO `api_niwash_data`(`reg_id`, `CertificateStatus`, `applicationNo`, `CertificateID`, `IssueDate`, `ApplicantName`, `Father_Husband_Name`, `Tehsil`, `District`, `remarks`) VALUES ('".$row['userid']."','".$data['CertificateStatus']."','".$data['applicationNo']."','".$data['CertificateID']."','".$data['IssueDate']."','".$data['ApplicantName']."','".$data['Father_Husband_Name']."','".$data['Tehsil']."','".$data['District']."','success')";
echo $sql;
execute_query($sql);

// Output the array
//print_r($certificate_details);




}
echo"completed";

