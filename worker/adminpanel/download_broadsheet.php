<?php
require_once('vendor/autoload.php');

// Create new PDF document
$pdf = new TCPDF();

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Name');
$pdf->SetTitle('PDF Title');
$pdf->SetSubject('PDF Subject');
$pdf->SetKeywords('TCPDF, PDF, example');

// Add a page
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 10);

// Loop through the results and add data to the PDF
while ($ndata = $nres->fetch_assoc()) {
    $gramPanchyatId = $ndata['gram_panchyat_id'];

    $q = "SELECT nad.userid, nad.gram_panchayat, nad.pre_name, nad.name_hi, nad.name_en, nad.rikt_aww_center, nad.date_of_birth,
                nad.fname, nad.mname, nad.hname, nad.mobile, nad.age_years, nad.age_months, nad.age_days, 
                pd.category as cast, pd.sub_category, pd.avedika_status, pd.bpl_card, ad.i_present, ad.g_present, ad.pg_present, 
                ad.merit, d.application_no, d.aganwadi_center, pd.drl_no, pd.death_date, pd.death_person_name,
                pd.divangta_pramnpatr_kramank, pd.divangta_avedan_krmank, pd.f_senani_sambandh, pd.f_senani_prmanptr, pd.avedika_status, 
                pd.vidhwa_certificateno, pd.nivas_prmaanpatr_no, pd.nivas_avedan_prmanpatr, pd.nivas_upload, pd.jaant_prmaanpatr_no, 
                pd.jaati_avedan_prmanpatr, pd.jaati_upload, pd.aay_prmaanpatr_no, pd.aay_avedan_prmanpatr, pd.aay_upload, 
                ad.i_school, ad.i_board, ad.i_year, ad.i_maxmarks, ad.i_totalmarks, ad.i_present, ad.g_present, ad.pg_present,
                pd.v_jarikrta_name, pd.v_uploaddata, ad.i_marksheetdoc, ad.i_otherdoc, ad.g_totalmarks, ad.g_maxmarks, 
                ad.g_present, ad.g_marksheetdoc, ad.g_otherdoc, ad.pg_totalmarks, ad.pg_maxmarks, ad.pg_marksheetdoc, 
                ad.pg_otherdoc, d.niwash_v_status, d.id as did, d.remarks, d.selection_status, nv.awc_name, nv.unique_code, 
                nv.vacancy_available, nv.category, nv.ews, d.income_v_status
            FROM decleration d
            INNER JOIN new_application_details nad ON d.userid = nad.userid
            INNER JOIN personal_details pd ON nad.userid = pd.userid
            INNER JOIN academic_details ad ON ad.userid = pd.userid
            LEFT JOIN new_vacancy nv ON nv.id = d.aganwadi_center
            WHERE d.district_id = ? AND d.project_id = ? AND d.gram_panchyat_id = ?";

    $stmt = $conn->prepare($q);
    $stmt->bind_param("sss", $districtId, $projectId, $gramPanchyatId);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $pdf->MultiCell(0, 10, 'Name: ' . $row['name_en'], 0, 'L', 0, 1);
        $pdf->MultiCell(0, 10, 'Gram Panchayat: ' . $row['gram_panchayat'], 0, 'L', 0, 1);
        // Add more fields as needed
    }
}

// Output the PDF to browser (force download)
$pdf->Output('file.pdf', 'D');


?>