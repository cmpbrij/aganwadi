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
            bm.block_name, 
             COALESCE(NULLIF(TRIM(nv.gp_name), ''), nv.ward_name) AS gp_or_ward_name,
            nv.awc_name, 
            nv.unique_code, 
            nv.category,
            nv.gp_name
            
        FROM 
            new_vacancy nv
       LEFT JOIN 
            block_master bm ON nv.project_id = bm.id AND bm.district_id='".$did."'

        WHERE 
             nv.district_id = '".$did."' AND nv.project_id='".$pid."'";
           // echo   $query; die; 

        $result = execute_query($query);

        // Set the headers to download the CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="projectVacancy.csv"');

        // Open output stream
        $output = fopen('php://output', 'w');

        // Write the column headers
        fputcsv($output, array('Project Name', 'GP/Ward Name', 'AWC Center', 'Unique Code', 'Category'));

        // Write the rows fetched from the database
        if (mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                $cat=getCategoryTexteng($row['category']);
               
                $data = [
                    $row['block_name'],          // Project Name
                    $row['gp_or_ward_name'],   // Grampanchyat Name
                    $row['awc_name'],              // AWC Center
                    $row['unique_code'],           // Unique Code
                    $cat            // Category
                  
                ];
                fputcsv($output, $data);
            }
           
        }

        // Close output stream
        fclose($output);
        ob_flush();

?>
