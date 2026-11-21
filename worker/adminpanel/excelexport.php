<?php
include 'master.php';
ob_start();
require_once('TCPDF-main/tcpdf.php');
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Use a prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT nad.userid,
                                    nad.gram_panchayat, nad.pre_name, nad.name_hi, nad.name_en, nad.rikt_aww_center, nad.date_of_birth,
                                    nad.fname, nad.mname, nad.hname, nad.mobile, nad.age_years, nad.age_months, nad.age_days, 
                                    pd.category as cast, pd.sub_category, pd.avedika_status, pd.bpl_card, 
                                    ad.i_present, ad.g_present, ad.pg_present, ad.merit, 
                                    d.application_no, d.aganwadi_center, pd.drl_no, pd.death_date, pd.death_person_name,
                                    pd.divangta_pramnpatr_kramank, pd.divangta_avedan_krmank, pd.f_senani_sambandh, pd.f_senani_prmanptr,
                                    pd.avedika_status, pd.vidhwa_certificateno, pd.nivas_prmaanpatr_no, pd.nivas_avedan_prmanpatr, 
                                    pd.nivas_upload, pd.jaant_prmaanpatr_no, pd.jaati_avedan_prmanpatr, pd.jaati_upload, 
                                    pd.aay_prmaanpatr_no, pd.aay_avedan_prmanpatr, pd.aay_upload, 
                                    ad.i_school, ad.i_board, ad.i_year, ad.i_maxmarks, ad.i_totalmarks, ad.i_present, ad.g_present, 
                                    ad.pg_present, pd.v_jarikrta_name, pd.v_uploaddata, ad.i_marksheetdoc, ad.i_otherdoc, 
                                    ad.g_totalmarks, ad.g_maxmarks, ad.g_present, ad.g_marksheetdoc, ad.g_otherdoc, 
                                    ad.pg_totalmarks, ad.pg_maxmarks, ad.pg_marksheetdoc, ad.pg_otherdoc, 
                                    d.niwash_v_status, d.id as did, d.remarks, d.selection_status, nv.awc_name, 
                                    nv.unique_code, nv.vacancy_available, nv.category, nv.ews, d.income_v_status
                             FROM decleration d
                             INNER JOIN new_application_details nad ON d.userid = nad.userid
                             INNER JOIN personal_details pd ON nad.userid = pd.userid
                             INNER JOIN academic_details ad ON ad.userid = pd.userid
                             LEFT JOIN new_vacancy nv ON nv.id = d.aganwadi_center
                             WHERE d.district_id = ?
                             ORDER BY nv.awc_name IS NULL ASC, 
                                      IF(nv.category = pd.category, 0, 1) ASC, 
                                      d.niwash_v_status DESC, 
                                      pd.bpl_card DESC, pd.avedika_status ASC, 
                                      ad.merit ASC, nad.year DESC, 
                                      nad.month DESC, nad.day DESC, pd.sub_category DESC");

    // Bind the district_id to the statement and execute it
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Clean the output buffer to prevent any additional output before headers
    ob_end_clean();

    // Excel header with UTF-8 BOM for proper rendering in Excel
    header("Content-type: application/vnd.ms-excel; charset=UTF-8");
    header("Content-Disposition: attachment; filename=User_Detail.xls");
    header("Pragma: no-cache");
    header("Expires: 0");




    // Adding a UTF-8 BOM for proper Excel rendering

    echo "\xEF\xBB\xBF";


    // Column headers
    $columnHeader = "Application No\tAganwadi Center\tApplicant Name\tFather Name\tMother Name\tHusband Name\tMobile No\tDOB\tAge\tCategory\tResidency Application No. & CertificateID & View\tCast Application No. & CertificateID & View\tIncome Application No. & CertificateID & View\tHandicapped Application No. & CertificateID\tWidow Details\tIntermediate\tGraduation\tPost Graduation\tCurrent Status\tBPL\tReserved & EWS Info\tMerit\n";

    // Output column headers
    echo $columnHeader;


    // Fetch the data and output each row
    $i = 1;
    while ($row = $result->fetch_assoc()) {
        $i++;
        $rowData = [
            $i,
            $row['application_no'],
            $row['aganwadi_center'],
            utf8_encode($row['name_hi']),
            $row['fname'],
            $row['mname'],
            $row['hname'],
            $row['mobile'],
            $row['date_of_birth'],
            "{$row['age_years']} Years, {$row['age_months']} Months, {$row['age_days']} Days",
            $row['cast'],
            "{$row['nivas_prmaanpatr_no']} / {$row['nivas_avedan_prmanpatr']} / {$row['nivas_upload']}",
            "{$row['jaant_prmaanpatr_no']} / {$row['jaati_avedan_prmanpatr']} / {$row['jaati_upload']}",
            "{$row['aay_prmaanpatr_no']} / {$row['aay_avedan_prmanpatr']} / {$row['aay_upload']}",
            $row['divangta_pramnpatr_kramank'],
            $row['vidhwa_certificateno'],
            "{$row['i_school']} / {$row['i_board']} / {$row['i_year']}",
            "{$row['g_totalmarks']} / {$row['g_maxmarks']}",
            "{$row['pg_totalmarks']} / {$row['pg_maxmarks']}",
            $row['i_present'],
            $row['bpl_card'],
            "{$row['category']} / {$row['ews']}",
            $row['merit']
        ];

        // Output row data
        echo implode("\t", $rowData) . "\n";
    }

    // Free the result and close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
