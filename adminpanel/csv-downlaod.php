<?php
include 'master.php';
ob_start();

if (!checkLogin()) {
    header('Location: login.php');
}
ob_end_clean();

// Start the CSV download
header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="BroadsheetCSV.csv"');

// Add BOM to indicate UTF-8 encoding
echo "\xEF\xBB\xBF";

$output = fopen('php://output', 'w');

// Add header row to the CSV
$header = [
    'Grampanchyat/Ward',
    'Nyaypanchyat',
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

// Connect to the database and set character set to UTF-8
$conn->set_charset("utf8");

$districtId = $_SESSION['distid'];
$projectId = $_GET['project_id'];

// Query to get the Gram Panchayat names
$nq = "SELECT MIN(nv.gram_panchayat_id) AS gram_panchayat_id, gp.gram_panchayat_name
        FROM new_vacancy nv
        JOIN gram_panchayat gp ON nv.gram_panchayat_id = gp.id
        WHERE nv.district_id = ?
        AND nv.project_id = ?
        AND nv.vacancy_available = 'Yes'
        GROUP BY nv.gram_panchayat_id, gp.gram_panchayat_name
        ORDER BY gp.gram_panchayat_name";

$stmt = $conn->prepare($nq);
$stmt->bind_param("ss", $districtId, $projectId);
$stmt->execute();
$nres = $stmt->get_result();

while ($ndata = $nres->fetch_assoc()) {
    $q = "SELECT
            d.application_no,
            d.aganwadi_center,
            nad.name_en,
            nad.pre_name,
            nad.name_hi AS applicant_name,
            nad.fname AS father_name,
            nad.mname AS mother_name,
            nad.hname AS husband_name,
            nad.mobile,
            nad.date_of_birth,
            pd.category AS cat,
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
            nad.nay_panchayat,
            pd.drl_no, pd.death_date, pd.death_person_name,
            pd.divangta_pramnpatr_kramank, pd.divangta_avedan_krmank,
            pd.f_senani_sambandh, pd.f_senani_prmanptr,
            pd.avedika_status, pd.vidhwa_certificateno,
            pd.nivas_prmaanpatr_no, pd.nivas_avedan_prmanpatr,
            pd.nivas_upload, pd.jaant_prmaanpatr_no, pd.jaati_avedan_prmanpatr, pd.jaati_upload, pd.aay_prmaanpatr_no, pd.aay_avedan_prmanpatr, pd.aay_upload,
            ad.i_school, ad.i_board, ad.i_year, ad.i_maxmarks, ad.i_totalmarks, ad.i_present, ad.g_present, ad.pg_present,
            pd.v_jarikrta_name, pd.v_uploaddata, ad.i_marksheetdoc, ad.i_otherdoc, ad.g_totalmarks, ad.g_maxmarks, ad.g_present, ad.g_marksheetdoc, ad.g_otherdoc,
            ad.pg_totalmarks, ad.pg_maxmarks, ad.pg_marksheetdoc, ad.pg_otherdoc,
            d.niwash_v_status, nv.ews
          FROM decleration d
          INNER JOIN new_application_details nad ON d.userid = nad.userid
          INNER JOIN personal_details pd ON nad.userid = pd.userid
          INNER JOIN academic_details ad ON ad.userid = pd.userid
          LEFT JOIN new_vacancy nv ON nv.id = d.aganwadi_center
          WHERE d.district_id = ?
          AND d.project_id = ?
          AND d.gram_panchyat_id = ?
          AND d.aganwadi_center != ''
          AND nv.vacancy_available = 'Yes'
          ORDER BY d.aganwadi_center, CAST(ad.merit AS DECIMAL(5,3)) DESC";

    $stmt = $conn->prepare($q);
    $stmt->bind_param("sss", $districtId, $projectId, $ndata['gram_panchayat_id']);
    $stmt->execute();
    $r = $stmt->get_result();
    
    while ($row = $r->fetch_assoc()) {
        $reservation_applied = $row['category'];
        if ($reservation_applied == '2' || $reservation_applied == '3') {
            if ($row['cat'] != $reservation_applied) {
                continue;
            }
        } elseif ($reservation_applied == '4') {
            if ($row['cat'] != '3' && $row['cat'] != '4') {
                continue;
            }
        }

        $data = [
            $ndata['gram_panchayat_name'],
            $ndata['nay_panchayat'],
            $row['application_no'],
            isset($row['awc_name']) ? $row['awc_name'] : '',
            isset($row['unique_code']) ? $row['unique_code'] : '',
            $row['name_en'],
            getPrename($row['pre_name']) . ' ' . $row['applicant_name'],
            $row['father_name'],
            $row['mother_name'],
            $row['husband_name'],
            $row['mobile'],
            $row['date_of_birth'],
            getCategoryTexteng($row['cat']),
        ];

        if ($catstatus == 1) {
            $data[] = getSubcategoryText($row['sub_category']);
        }

        $data[] = !empty($row['divangta_avedan_krmank']) ? $row['divangta_avedan_krmank'] : 'NA';
        $data[] = !empty($row['f_senani_sambandh']) ? $row['f_senani_sambandh'] : 'NA';
        $data[] = $row['nivas_avedan_prmanpatr'] . '&' . $row['nivas_prmaanpatr_no'];
        $data[] = $row['jaati_avedan_prmanpatr'] . '&' . $row['jaant_prmaanpatr_no'];
        $data[] = $row['aay_avedan_prmanpatr'] . '&' . $row['aay_prmaanpatr_no'];
        $data[] = getCurrentsituation($row['avedika_status']);
        $data[] = $row['vidhwa_certificateno'] . '&Jarikrta Name-' . $row['v_jarikrta_name'];
        $data[] = $row['i_totalmarks'] . '/' . $row['i_maxmarks'] . '=' . $row['i_present'] . '%';
        $data[] = $row['g_totalmarks'] . '/' . $row['g_maxmarks'] . '=' . $row['g_present'] . '%';
        $data[] = $row['pg_totalmarks'] . '/' . $row['pg_maxmarks'] . '=' . $row['pg_present'] . '%';
        $data[] = $row['merit'];
        $data[] = 'Reserved For: ' . getCategoryText($row['category']) . ' & EWS: ' . getewsText($row['ews']);
        
        fputcsv($output, $data);
    }
}

fclose($output);
?>
