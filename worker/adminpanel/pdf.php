<?php
include 'master.php';
ob_start();

if (!checkLogin()) {
    header('Location: login.php');
}
require_once('TCPDF-main/tcpdf.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $districtId = ''; // Set this variable accordingly
    $projectId = '';  // Set this variable accordingly
    $gramPanchyatId = '';  // Set this variable accordingly

    // Query
    $q = "SELECT nad.userid, nad.grameen_sehri,nad.pre_name,
                                                nad.gram_panchayat, nad.pre_name, nad.name_hi, nad.name_en, nad.rikt_aww_center, nad.date_of_birth,
                                                nad.fname, nad.mname, nad.hname, nad.mobile, nad.age_years, nad.age_months, nad.age_days,
                                                pd.category AS cast, pd.sub_category, pd.avedika_status, pd.bpl_card, 
                                                ad.i_present, ad.g_present, ad.pg_present, ad.merit,
                                                d.application_no, d.aganwadi_center, pd.drl_no, pd.death_date, pd.death_person_name,
                                                pd.divangta_pramnpatr_kramank, pd.divangta_avedan_krmank,
                                                pd.f_senani_sambandh, pd.f_senani_prmanptr,
                                                pd.avedika_status, pd.vidhwa_certificateno,
                                                pd.nivas_prmaanpatr_no, pd.nivas_avedan_prmanpatr,
                                                pd.nivas_upload, pd.jaant_prmaanpatr_no, pd.jaati_avedan_prmanpatr, pd.jaati_upload, pd.aay_prmaanpatr_no, pd.aay_avedan_prmanpatr, pd.aay_upload, 
                                                ad.i_school, ad.i_board, ad.i_year, ad.i_maxmarks, ad.i_totalmarks, ad.i_present, ad.g_present, ad.pg_present, 
                                                pd.v_jarikrta_name, pd.v_uploaddata, ad.i_marksheetdoc, ad.i_otherdoc, ad.g_totalmarks, ad.g_maxmarks, ad.g_present, ad.g_marksheetdoc, ad.g_otherdoc, 
                                                ad.pg_totalmarks, ad.pg_maxmarks, ad.pg_marksheetdoc, ad.pg_otherdoc, 
                                                d.niwash_v_status, d.id AS did, d.remarks, d.selection_status, nv.awc_name, nv.unique_code, nv.vacancy_available, nv.category, nv.ews, 
                                                d.income_v_status, d.cast_v_status
                                            FROM decleration d
                                            INNER JOIN new_application_details nad ON d.userid = nad.userid
                                            INNER JOIN personal_details pd ON nad.userid = pd.userid
                                            INNER JOIN academic_details ad ON ad.userid = pd.userid
                                            LEFT JOIN new_vacancy nv ON nv.id = d.aganwadi_center
                                            WHERE d.district_id = ? 
                                            AND d.project_id = ? 
                                            AND d.gram_panchyat_id = ?
                                            ORDER BY 
                                            CASE 
                                                WHEN CAST(nad.age_years AS UNSIGNED) >= 35 OR CAST(nad.age_years AS UNSIGNED) <= 18 THEN 1 
                                                ELSE 0 
                                            END ASC,
                                            nv.awc_name IS NULL ASC, 
                                            d.niwash_v_status IS NULL ASC,

                                             CASE
                                                WHEN nv.ews = 1 AND pd.category = 5 AND CAST(d.income_v_status AS UNSIGNED) < 800000 THEN 1
                                                ELSE 0
                                            END DESC,
                                            CASE 
                                            WHEN nv.category = pd.category   THEN 1  -- High priority when categories match
                                            ELSE 0  -- Low priority when they don't match
                                            END DESC,
                                            CASE 
                                                WHEN nv.category = pd.category THEN 
                                                    CASE 
                                                       WHEN nv.category = pd.category THEN 1
                                                       WHEN d.verify_bpl = 1 THEN 2
                                                       WHEN pd.avedika_status != '3' THEN 3
                                                        WHEN pd.sub_category != 0  THEN 4
                                                        ELSE 5
                                                    END 
                                                ELSE 
                                                    CASE 
                                                        WHEN d.verify_bpl = 1 THEN 1
                                                        WHEN pd.avedika_status != '3' THEN 2
                                                        WHEN pd.sub_category != 0  THEN 3
                                                        ELSE 4 
                                                 END 
                                            END,
                                            -- CASE   
                                            --      WHEN pd.avedika_status != '3' THEN 1
                                            --         ELSE 0
                                            -- END DESC,
                                        
                                            CAST(ad.merit AS DECIMAL(5,3)) DESC,
                                            CAST(nad.age_years AS UNSIGNED) DESC,
                                            CAST(nad.age_months AS UNSIGNED) DESC,
                                            CAST(nad.age_days AS UNSIGNED) DESC";

    $stmt = $conn->prepare($q);
    $stmt->bind_param("sss", $districtId, $projectId, $gramPanchyatId);
    $stmt->execute();
    $r = $stmt->get_result();


    // Create new PDF document
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Vedprakash');
    $pdf->SetTitle('Hindi and English Example');
    $pdf->SetSubject('Hindi-English Rendering');
    $pdf->SetKeywords('TCPDF, PDF, Hindi, English');

    // Set margins and page breaks
    $pdf->SetMargins(5, 5, 5);
    $pdf->SetAutoPageBreak(TRUE, 10);

    // Add a page
    $pdf->AddPage('L');

    // Enable font subsetting for UTF-8 support
    $pdf->setFontSubsetting(true);

    // Load Mangal font for Hindi text
    $mangal_font_path = 'Mangal.ttf'; // Ensure correct path to font file
    if (file_exists($mangal_font_path)) {
        $mangal_fontname = TCPDF_FONTS::addTTFfont($mangal_font_path, 'TrueTypeUnicode', '', 32);
    } else {
        $mangal_fontname = 'dejavusans'; // Fallback to DejaVu Sans if Mangal is not found
    }

    // Load DejaVuSans for English text
    $dejavu_fontname = 'dejavusans';

    // Add table headers
    $html = '<h1 align="center">Broadsheet AWW-2025</h1>';
    $html .=  '<table><thead><tr>
            <th>Application No.</th>
            <th>Aganwadi Center</th>
            <th>Applicant Name</th>
            <th>Father Name</th>
            <th>Husband Name</th>
            <th>Mobile No.</th>
            <th>DOB</th>
            <th>Category & Sub Category</th>
            <th>Residency</th>
            <th>Cast </th>
            <th>Income</th>
            <th>C. Status</th>
           
            <th>Reserved & EWS Info</th>
            <th>Merit</th>
            </tr></thead>';

    // Fetch the data and display dynamically
    $html .= '<tbody>';
    while ($adata = $r->fetch_assoc()) {
        $html .= '<tr>';
        $html .= '<td>' . $adata['application_no'] . '</td>';
        $html .= '<td>' . $adata['awc_name'] . '<br>'.$adata['unique_code'].'</td>';
        $html .= '<td>'.getPrename($adata['pre_name']).' '. $adata['name_en'] . '</td>';
        $html .= '<td>' .strtoupper($adata['fname']). '<br>'.strtoupper($adata['mname']).'</td>';
        $html .= '<td>' . $adata['hname'] . '</td>';
        $html .= '<td>' . $adata['mobile'] . '</td>';
        $html .= '<td>' . $adata['date_of_birth'] . '</td>';
        $html .= '<td>' . getCategoryText($adata['cast']) .'<br>'.getSubcategoryText($adata['sub_category']).'</td>';
        $html .= '<td>' . $adata['nivas_avedan_prmanpatr'] .'<br>'.$adata['nivas_prmaanpatr_no'].'</td>';
        $html .= '<td>' . $adata['jaati_avedan_prmanpatr'] .'<br>'.$adata['jaant_prmaanpatr_no'].'</td>';
        $html .= '<td>' . $adata['income_v_status'] . '</td>';
        $html .= '<td>' . $adata['avedika_status'] . '</td>';
        $html .= '<td><b>Reserved For: </b>' . getCategoryText($adata['category']) . '<br><b>EWS: </b>' .  getewsText($adata['ews']) . '</td>';
        $html .= '<td>' . $adata['merit'] . '</td>';
        // Add other columns similarly
        $html .= '</tr>';
    }
    $html .= '</tbody>';
    $html .= '</table>';

    // Set DejaVuSans font for English text
    $pdf->SetFont($dejavu_fontname, '', 10, '', true);

    // Write the HTML content with both fonts to PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Output PDF
    $pdf->Output('example_001.pdf', 'I');
}
