<?php
$data = json_decode(file_get_contents('php://input'), true);
if (isset($data['ids']) && count($data['ids']) > 0) {

     $uid = $_SESSION['uid'];
    $date= date('Y-m-d H:i:s');
  

   
   
    console.log($data);
    $ids = $data['ids'];
    // Loop through each centerid to perform necessary operations
    foreach ($ids as $centerId) {
       
        // Query to get details from `new_vacancy`
        $sql1 = "SELECT vacancy_available, category, ews FROM new_vacancy WHERE id = " . intval($centerId);
        $re1 = execute_query($sql1);
        $row = mysqli_fetch_assoc($re1);

        // Query to get details from `vacancy_edit_details`
        $sql11 = "SELECT isvacancy, category, ews FROM vacancy_edit_details WHERE centerid = " . intval($centerId) . " AND status IS NULL";
        $re11 = execute_query($sql11);
        $vrow = mysqli_fetch_assoc($re11);

        // Update query for `vacancy_edit_details`
        $sql = "UPDATE vacancy_edit_details 
                SET pre_ews = '" . $row['ews'] . "', 
                    pre_vacancy = '" . $row['vacancy_available'] . "', 
                    pre_category = '" . $row['category'] . "', 
                    approved_by = '" . $uid . "', 
                    status = 'Approve', 
                    approved_timestamp = '" . $date . "' 
                WHERE centerid = " . intval($centerId);

        // Execute the update query
        execute_query($sql);

        if($vrow['ews']=='Yes'){
            $y1='1';
        }
        else{
            $y1='0';
        }
        $sql="UPDATE `new_vacancy` SET `vacancy_available`='".$vrow['isvacancy']."', `ews`='".$y1."', `category`='".$vrow['category']."',`updated_status`='1' WHERE id='".$centerId."'";
      
       
        $res=execute_query($sql);
    }
    if($res)
     echo json_encode(['message' => 'Selected rows updated successfully.']);
    } else {
        // If no IDs were provided
        echo json_encode(['message' => 'No valid IDs provided for update.']);
    }
}
?>