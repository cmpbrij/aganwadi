<?php
include 'master.php';
ob_start();

if (!checkLogin()) {
    header('Location: login.php');
}
ob_end_clean();
// Start the CSV download
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="applications.csv"');

$output = fopen('php://output', 'w');
// Add header row to the CSV
$header = [
    'Grampanchyat',
    'Application No.',
    'AWW Center',
    'Center Code',
    'Applicant Name En',
    'Applicant Name Hi',
    'Father Name',
    'Mother Name',
    'Husband Name',
    'Mobile No.',
    'DOB',
    'Category',
];
// Check if subcategory is enabled and add it to the header
$catstatus = subcategoryEnable();
if ($catstatus == 1) {
    $header[] = 'Sub Category';
}
$header = array_merge($header, [
    'Handicapped Application No. & CertificateID',
    'F.F. Relation & Details',
    'Residency Application No. & CertificateID & View',
    'Cast Application No. & CertificateID & View',
    'Income Application No. & CertificateID & View',
    'Current Status',
    'Widow Details',
    'Intermediate',
    'Graduation',
    'Post Graduation',
    'Merit',
    'Reserved & EWS Info',
]);
// Write the header to the CSV
fputcsv($output, $header);
// Connect to the database
$districtId = $_SESSION['distid'];
$projectId = $_GET['project_id'];
// Query to get the Gram Panchayat names
$nq = "SELECT DISTINCT d.gram_panchyat_id, gram_panchayat_name
       FROM decleration d
       JOIN gram_panchayat gp ON d.gram_panchyat_id = gp.id
       WHERE d.district_id = ? AND d.project_id = ?
       ORDER BY gram_panchayat_name";
     //  echo $nq;
$stmt = $conn->prepare($nq);
$stmt->bind_param("ss", $districtId, $projectId);
$stmt->execute();
$nres = $stmt->get_result();
while ($ndata = $nres->fetch_assoc()) {
   
    $q = "SELECT
            d.application_no,
            d.aganwadi_center,
            nad.name_en,
            nad.name_hi AS applicant_name,
            nad.fname AS father_name,
            nad.mname AS mother_name,
            nad.hname AS husband_name,
            nad.mobile,
            nad.date_of_birth,
            pd.category as cat,
            pd.sub_category,
            pd.vidhwa_certificateno,
           
            d.remarks,
            d.selection_status,
            ad.merit,
            nv.ews,
            d.cast_v_status,
            pd.avedika_status,
            d.income_v_status,
            nv.awc_name,
            nv.unique_code,
            pd.divangta_avedan_krmank,
            nv.category,
            pd.drl_no, pd.death_date, pd.death_person_name,
            pd.divangta_pramnpatr_kramank, pd.divangta_avedan_krmank,
            pd.f_senani_sambandh, pd.f_senani_prmanptr,
            pd.avedika_status, pd.vidhwa_certificateno,
            pd.nivas_prmaanpatr_no, pd.nivas_avedan_prmanpatr,
            pd.nivas_upload, pd.jaant_prmaanpatr_no, pd.jaati_avedan_prmanpatr, pd.jaati_upload, pd.aay_prmaanpatr_no, pd.aay_avedan_prmanpatr, pd.aay_upload, 
            ad.i_school, ad.i_board, ad.i_year, ad.i_maxmarks, ad.i_totalmarks, ad.i_present, ad.g_present, ad.pg_present, 
            pd.v_jarikrta_name, pd.v_uploaddata, ad.i_marksheetdoc, ad.i_otherdoc, ad.g_totalmarks, ad.g_maxmarks, ad.g_present, ad.g_marksheetdoc, ad.g_otherdoc, 
            ad.pg_totalmarks, ad.pg_maxmarks, ad.pg_marksheetdoc, ad.pg_otherdoc, 
            d.niwash_v_status,nv.ews, d.income_v_status, d.cast_v_status
          FROM decleration d
          INNER JOIN new_application_details nad ON d.userid = nad.userid
          INNER JOIN personal_details pd ON nad.userid = pd.userid
          INNER JOIN academic_details ad ON ad.userid = pd.userid
          LEFT JOIN new_vacancy nv ON nv.id = d.aganwadi_center
          WHERE d.district_id = '".$districtId."' AND d.project_id = '".$projectId."' AND d.gram_panchyat_id = '".$ndata['gram_panchyat_id']."'
          ORDER BY
            nv.unique_code IS NULL ASC,
            nv.awc_name IS NULL ASC,
            d.niwash_v_status IS NULL ASC,
            CAST(ad.merit AS DECIMAL(5,3)) DESC,
            CAST(nad.age_years AS UNSIGNED) DESC,
            CAST(nad.age_months AS UNSIGNED) DESC,
            CAST(nad.age_days AS UNSIGNED) DESC";
            $r=execute_query($q);
          //  echo $q; die;
    // $stmtDetails = $conn->prepare($q);
    // $stmtDetails->bind_param("sss", $districtId, $projectId, $gramPanchyatId);
    // $stmtDetails->execute();
    // $r = $stmtDetails->get_result();
    // Fetch each row and write to CSV
    while ($row = mysqli_fetch_assoc($r)) {
        // Prepare the data for each row
        $data = [
           
            $ndata['gram_panchayat_name'],
            $row['application_no'],
            isset($row['awc_name']) ? $row['awc_name'] : '' ,
            isset($row['unique_code']) ? $row['unique_code'] : '',
            $row['name_en'],
            getPrename($row['pre_name']).' ' . $row['applicant_name'],
            $row['father_name'],
            $row['mother_name'],
            $row['husband_name'],
            $row['mobile'],
            $row['date_of_birth'],
            getCategoryTexteng($row['cat']),
        ];
        // Add sub-category if enabled
        if ($catstatus == 1) {
            $data[] = getSubcategoryText($row['sub_category']);
        }
        // Additional data processing
        $data[] = !empty($row['divangta_avedan_krmank']) ? $row['divangta_avedan_krmank'] : 'NA';
        $data[] = !empty($row['f_senani_sambandh']) ? $row['f_senani_sambandh'] : 'NA';
        // $data[] = !empty($row['vidhwa_certificateno']) ? $row['vidhwa_certificateno'] : 'NA';
      
        $data[] = ' (' . ($row['niwash_v_status'] == '1' ? 'Verified' : 'Not Verified') . ')'.$row['nivas_avedan_prmanpatr'].'&'.$row['nivas_prmaanpatr_no'];
        $data[] = ' (' . ($row['cast_v_status'] == '1' ? 'Verified' : 'Not Verified') . ')'.$row['jaati_avedan_prmanpatr'].'&'.$row['jaant_prmaanpatr_no'];
        $data[] = ' (' . ($row['income_v_status'] == '1' ? 'Verified' : 'Not Verified') . ')'.$row['aay_avedan_prmanpatr'].'&'.$row['aay_prmaanpatr_no'];
        $data[]= getCurrentsituation($row['avedika_status']);
       
        $data[]=$row['vidhwa_certificateno'] . '&Jarikrta Name-' . $row['v_jarikrta_name'];
       
     
        // $data[] = !empty($row['aay_avedan_prmanpatr']) ? $row['aay_avedan_prmanpatr'] . ' (' . ($row['income_v_status'] == '1' ? 'Verified' : 'Not Verified') . ')' : 'NA';
        // Intermediate Marks
        $data[] = $row['i_totalmarks'] . '/' . $row['i_maxmarks'] . '=' . $row['i_present'] .'%';
        // Graduation Marks
        $data[] =$row['g_totalmarks'] . '/' . $row['g_maxmarks'] . '=' . $row['g_present'] .'%';

        $data[] =$row['pg_totalmarks'] . '/' . $row['pg_maxmarks'] . '=' . $row['pg_present'] .'%';
        $data[]=$row['merit'];
        $data[]='Reserved For: </b>' . getCategoryText($row['category']) . '<b>EWS: </b>' .  getewsText($row['ews']) ;
        fputcsv($output, $data);
    }
}

?>