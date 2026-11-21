<?php
  include 'master.php';
 
  
  if(!checkLogin()){
    header('Location: login.php');

  }
  if(isset($_SESSION['distid']) && isset($_GET['pid'])){
    $did=$_SESSION['distid'];
    $pid=$_GET['pid'];
  }
  else{
    echo'Somthing went wrong!';
  }
// Fetch data from the database
        $query = "SELECT 
            p.project_name, 
            g.gram_panchayat_name, 
            nv.awc_name, 
            nv.unique_code, 
            nv.category, 
            nv.ews
        FROM 
            new_vacancy nv
       LEFT JOIN 
            projects p ON nv.project_id = p.id AND p.district_id='".$did."'
       LEFT JOIN 
            gram_panchayat g ON g.id = nv.gram_panchayat_id

        WHERE 
            nv.vacancy_available != 'Yes' AND nv.district_id = '".$did."' AND nv.project_id='".$pid."'
            
        GROUP BY 
        nv.unique_code,p.project_name, g.gram_panchayat_name, nv.awc_name, nv.unique_code, nv.category, nv.ews;";
           // echo   $query; die; 

        $result = execute_query($query);

        // Set the headers to download the CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="projectVacancy.csv"');

        // Open output stream
        $output = fopen('php://output', 'w');

        // Write the column headers
        fputcsv($output, array('Project Name', 'Grampanchyat Name', 'AWC Center', 'Unique Code', 'Category', 'EWS'));

        // Write the rows fetched from the database
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $cat=getCategoryTexteng($row['category']);
                $ews=ewstext($row['ews']);
                $data = [
                    $row['project_name'],          // Project Name
                    $row['gram_panchayat_name'],   // Grampanchyat Name
                    $row['awc_name'],              // AWC Center
                    $row['unique_code'],           // Unique Code
                    $cat,              // Category
                    $ews                    // EWS
                ];
                fputcsv($output, $data);
            }
           
        }

        // Close output stream
        fclose($output);
        ob_flush();

?>
