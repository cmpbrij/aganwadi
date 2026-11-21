<?php
include 'master.php';
ob_start();
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if (!checkLogin()) {
    header('Location: login.php');
}
ob_end_clean();
// Start the CSV download
header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="applications.csv"');

$output = fopen('php://output', 'w');
//fprintf($output, "\xEF\xBB\xBF");
//fprintf($output, chr(0xEF).chr(0xBB).chr(0xBF));
// Add header row to the CSV
$header = [
     'Application No.',
      'AWW Center',
      'Center Code',
    'Grampanchyat',
    'Applicant Name En',
    'Applicant Name Hi',
    'Father Name',
    'Mother Name',
    'Husband Name',
    'Mobile No.',
    'DOB',
    'Category',
];

$header = array_merge($header, [
    'Full Address',
    'Residency Application No. & CertificateID',
    'Cast Application No. & CertificateID',
    'Income Application No. & CertificateID',
    'API Data Residency details',
    'API Data Residency issue date',
    'API Data issue status',
    'API Data Income Details',
    'API Data Income Issue Date',
    'API Data Income Value',
    'API Data Income Status',
    'API Data Cast',
    'API Data Cast Issue Date',
    'API Data Cast Status',
    'User Input Income',
    'User Input Income Issue Date',
    'Current Status',
    'Widow Details',
    'Intermediate',
    'Graduation',
    'Post Graduation',
    'Merit',
    'Reserved For'
]);
// Write the header to the CSV
fputcsv($output, $header);
// Connect to the database
$districtId = $_SESSION['distid'];
$projectId = $_GET['project_id'];
// Query to get the Gram Panchayat names
$nq = "SELECT id,unique_code,COALESCE(NULLIF(TRIM(nv.gp_name), ''), nv.ward_name) AS gp_or_ward_name
        FROM new_vacancy nv
        WHERE nv.district_id = '".$_SESSION['distid']."'
        AND nv.project_id = '".$_GET['project_id']."'
        ORDER BY gp_name,ward_name";
      //echo $nq; die;
$stmt = execute_query($nq);

while ($ndata = mysqli_fetch_assoc($stmt)) {
   
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
            ad.pg_totalmarks, ad.pg_maxmarks, ad.pg_marksheetdoc, ad.pg_otherdoc, pd.aay_prmaanpatr_issue_date ,d.created,pd.varshik_aay,nad.permanent_full_address,pd.grampanchayatname,pd.jaati,d.niwash_details,d.niwash_issue_date,d.niwash_cert_ststus,d.income_details,d.income_cert_status,d.income_issue_date,d.income_value,d.cast_v_status,d.cast_issue_date,d.cast_cert_status,d.cast_v_status,d.cast_issue_date,d.cast_cert_status
            
          FROM decleration d
          INNER JOIN new_application_details nad ON d.userid = nad.userid
          INNER JOIN personal_details pd ON nad.userid = pd.userid
          INNER JOIN academic_details ad ON ad.userid = pd.userid
          LEFT JOIN new_vacancy nv ON nv.id = d.aganwadi_center
          WHERE d.district_id = '".$districtId."' AND d.project_id = '".$projectId."'
           AND d.aganwadi_center = '".$ndata['id']."'
        ORDER BY
        CASE 
                WHEN d.selection_status = 1 THEN 0
                WHEN d.selection_status = 2 THEN 1
                ELSE 2
            END,
                CASE
                WHEN nv.category = 1 THEN 0
                WHEN d.category = nv.category THEN 1
                ELSE 2
            END,
            CASE
                WHEN nv.awc_urban_rural = 'Rural'
                    AND pd.varshik_aay > 1000
                    AND pd.varshik_aay <= 46080 THEN 1

                WHEN nv.awc_urban_rural = 'Urban'
                    AND pd.varshik_aay > 1000
                    AND pd.varshik_aay <= 56460 THEN 1

                
                ELSE 2
            END,
                CASE
                WHEN pd.avedika_status = 1 THEN 0
                WHEN pd.avedika_status = 2 THEN 1
                ELSE 2
            END,

            CAST(ad.merit AS DECIMAL(5,3)) DESC
            ";
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
            $row['application_no'],
             isset($row['awc_name']) ? $row['awc_name'] : '' ,
            isset($row['unique_code']) ? $row['unique_code'] : '',
            $ndata['gp_or_ward_name'],
            $row['name_en'],
            $row['applicant_name'],
            $row['father_name'],
            $row['mother_name'],
            $row['husband_name'],
            $row['mobile'],
            $row['date_of_birth'],
            getCategoryTexteng($row['cat']),
        ];
         $data[] = $row['permanent_full_address'];
        $data[] = $row['nivas_avedan_prmanpatr'].'&'.$row['nivas_prmaanpatr_no'];
        $data[] = $row['jaati_avedan_prmanpatr'].'&'.$row['jaant_prmaanpatr_no'];
       
        $data[] = $row['aay_avedan_prmanpatr'].'&'.$row['aay_prmaanpatr_no'];

         $data[] = $row['niwash_details'];
          $data[] = $row['niwash_issue_date'];
          $data[] = $row['niwash_cert_ststus'];

           $data[] = $row['income_details'];
           $data[] = $row['income_issue_date'];
           $data[] = $row['income_value'];
            $data[] = $row['income_cert_status'];

            $data[] = $row['cast_v_status'];
            $data[] = $row['cast_issue_date'];
            $data[] = $row['cast_cert_status'];
        
        
         $data[] = $row['varshik_aay'];
          $data[] = $row['aay_prmaanpatr_issue_date'];
        $data[]= getCurrentsituationen($row['avedika_status']);
       
        $data[]=$row['vidhwa_certificateno'] . '&Jarikrta Name-' . $row['v_jarikrta_name'];
       
     
        // $data[] = !empty($row['aay_avedan_prmanpatr']) ? $row['aay_avedan_prmanpatr'] . ' (' . ($row['income_v_status'] == '1' ? 'Verified' : 'Not Verified') . ')' : 'NA';
        // Intermediate Marks
        $data[] = $row['i_totalmarks'] . '/' . $row['i_maxmarks'] . '=' . $row['i_present'] .'%';
        // Graduation Marks
        $data[] =$row['g_totalmarks'] . '/' . $row['g_maxmarks'] . '=' . $row['g_present'] .'%';

        $data[] =$row['pg_totalmarks'] . '/' . $row['pg_maxmarks'] . '=' . $row['pg_present'] .'%';
        $data[]=$row['merit'];
        $data[]= getCategoryTexteng($row['category']) ;
        fputcsv($output, $data);
    }
}

?>