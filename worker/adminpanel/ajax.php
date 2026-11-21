<?php
  include 'master.php';
  include '../config/sms-config.php';

if(isset($_POST['aganid'])){
    $sql1="SELECT id,awc_name,vacancy_available,ews as ewsid,category,
    CASE 
        WHEN ews = 1 THEN 'Yes'
        ELSE 'No'
    END AS ews_status
     FROM `new_vacancy` WHERE id='".$_POST['aganid']."'";
   //echo $sql1;
    $res=execute_query($sql1);
    $row = mysqli_fetch_array($res);  
    echo json_encode($row);  
    
}
if(isset($_POST['ag_center_id'])){
    $ews= isset($_POST['ews']) ? $_POST['ews'] : '';
    $sql="UPDATE `new_vacancy` SET `updated_status`='1', vacancy_available='".$_POST['vacancy']."', category='".$_POST['category']."', ews='".$ews."'  WHERE id='".$_POST['ag_center_id']."'";

    
    $res=execute_query($sql);
    if($res){
        $dist= $_SESSION['distid'];
        $sid = $_SESSION['distid'];
        $date= date('Y-m-d');
        $sql="INSERT INTO `vacancy_edit_details`(`userid`, `districtid`, `isvacancy`, `category`, `ews`, `date`, `centerid` ) VALUES ('".$dist."','".$sid."','".$_POST['vacancy']."','".$_POST['category']."','".$_POST['ews']."','".$date."','".$_POST['ag_center_id']."')";
       execute_query($sql);
        $msg="success";
    }
    else{
        $msg="error";
    }
    echo $msg;
}

if(isset($_POST['uploadOTP'])){
    $otp = rand(1000,9999);
    $_SESSION['uotp']=$otp; 
    $sql="SELECT * FROM admin_users where id='".$_SESSION['sid']."'";
    $res=execute_query($sql);
    $row=mysqli_fetch_array($res);
    $mob=$row['mobile'];
    $smsres=sendroutedSms($otp,$mob);
    echo $smsres;
    
}

if(isset($_POST['sendotpforbroadsheet'])){
    ob_clean();
    header('Content-Type: application/json');

    $_SESSION['otp'] = rand(1000,9999);

    $q = "UPDATE vacancy_order SET otp='".$_SESSION['otp']."' WHERE dist_id='".$_SESSION['distid']."'";
    $res = execute_query($q);

    $smsres = false;
    $sql = "SELECT mobile FROM admin_users WHERE district_id='".$_SESSION['distid']."'";
    $r = execute_query($sql);

    if($r && mysqli_num_rows($r) > 0){
        $row = mysqli_fetch_assoc($r);
        $smsres = sendroutedSms($_SESSION['otp'], $row['mobile']);
       
    }

    if($res && $smsres){
        echo json_encode([
            'status' => 'Success',
            'message' => 'OTP sent successfully'
        ]);
    } else {
        echo json_encode([
            'status' => 'Failed',
            'message' => 'OTP could not be sent'
        ]);
    }
    exit;
}

if(isset($_POST['selectedreason'])){
    $sql="UPDATE decleration set remarks='".$_POST['selectedreason']."',selection_status='".$_POST['selectval']."' where id='".$_POST['did']."'";
    // echo $sql;
    $res=execute_query($sql);

    $sql1="INSERT INTO `selectionaudit`(`userid`, `districtid`, `centername`, `remark`, `selected`, `datetime`) VALUES ('".$_SESSION['sid']."','".$_SESSION['distid']."','".$_POST['did']."','".$_POST['selectedreason']."','".$_POST['selectval']."','".date('Y-m-d H:i:s')."')";
    execute_query($sql1);
    $response = [];

    if ($res) {
        $response['status'] = 'Success';
    } else {
        $response['status'] = 'Failed';
    }

    // Return the response as JSON
    echo json_encode($response);

}

if(isset($_POST['selectedreasonfinal'])){
    $sql="UPDATE decleration set final_remarks='".$_POST['selectedreasonfinal']."',final_selection='".$_POST['selectval']."' where id='".$_POST['finalMarkid']."'";
    // echo $sql;
    $res=execute_query($sql);

    $sql1="INSERT INTO `selectionaudit`(`userid`, `districtid`, `centername`, `remark`, `selected`, `datetime`) VALUES ('".$_SESSION['sid']."','".$_SESSION['distid']."','".$_POST['finalMarkid']."','".$_POST['selectedreasonfinal']."','".$_POST['selectval']."','".date('Y-m-d H:i:s')."')";
    execute_query($sql1);
    $response = [];

    if ($res) {
        $response['status'] = 'Success';
    } else {
        $response['status'] = 'Failed';
    }

    // Return the response as JSON
    echo json_encode($response);

}

if(isset($_POST['Adminaganid'])){
    $sql1="SELECT id,centerid,isvacancy,category as cid,
    CASE 
     WHEN ews = '1' THEN 'Yes'
     ELSE 'No'
     END AS ews,
    CASE 
        WHEN category = 1 THEN 'General(GEN)'
        WHEN category = 2 THEN 'Other Backward Caste(OBC)'
         WHEN category = 3 THEN 'Scheduled Caste(SC)'
          WHEN category = 4 THEN 'Scheduled Tribes(ST)'
           WHEN category = 5 THEN 'Economically Weaker Section(EWS)'
        ELSE 'UR'
    END AS category
    FROM `vacancy_edit_details` WHERE centerid='".$_POST['Adminaganid']."' AND approved_by IS NULL or approved_by=''";
   // echo $sql1;
    $res=execute_query($sql1);
    $row = mysqli_fetch_array($res);  
    echo json_encode($row);  
    
}
/*Inserting admin accept and reject*/
if(isset($_POST['AdminAganwadi1'])){
    $uid = $_SESSION['uid'];
    $date= date('Y-m-d H:i:s');
    $sql1="select vacancy_available,category,ews from new_vacancy where id='".$_POST['aww_center1']."'";
   // echo $sql1; 
    $re1=execute_query($sql1);
    $row=mysqli_fetch_assoc($re1);

    $sql11="select isvacancy,category,ews from vacancy_edit_details where id='".$_POST['AdminAganwadi1']."'";
     // echo $sql1; 
      $re11=execute_query($sql11);
      $vrow=mysqli_fetch_assoc($re11);
    
    $sqlq="UPDATE `vacancy_edit_details` SET pre_ews='".$row['ews']."', pre_vacancy='".$row['vacancy_available']."', `pre_category`='".$row['category']."', approved_by='".$uid."' ,`status`='Approve', approved_timestamp='".$date."' WHERE id='".$_POST['AdminAganwadi1']."'";
   //echo $sqlq;
    execute_query($sqlq);

    $y=trim($vrow['isvacancy']);
    
    $sql2="UPDATE `new_vacancy` SET `vacancy_available`='".$y."', `ews`='".$vrow['ews']."', `category`='".$vrow['category']."',`updated_status`='1' WHERE id='".$_POST['aww_center1']."'";
   // echo $sql2; 
   
    $res=execute_query($sql2);
    if($res){
        $msg="Data Updated!";
    }
    else{
        $msg="Failed Data Updated!";
    }
    echo $msg;
}

if(isset($_POST['aww_center'])){
    
    $uid = $_SESSION['uid'];
    $date= date('Y-m-d H:i:s');
    $sql1="select vacancy_available,category,ews from new_vacancy where id='".$_POST['aww_center']."'";
    $re1=execute_query($sql1);
    $row=mysqli_fetch_assoc($re1);

    // $sql11="select isvacancy,category,ews from vacancy_edit_details where centerid='".$_POST['aww_center1']."' AND status is NULL";
    // //  echo $sql1; die;
    //   $re11=execute_query($sql11);
    //   $vrow=mysqli_fetch_assoc($re11);

    
    
      $sql="UPDATE `vacancy_edit_details` SET pre_ews='".$row['ews']."', pre_vacancy='".$row['vacancy_available']."', `pre_category`='".$row['category']."', approved_by='".$uid."' ,`status`='Reject', approved_timestamp='".$date."' WHERE centerid='".$_POST['aww_center']."'";
      echo $sql;
   
      execute_query($sql);
  
    $sql="UPDATE `new_vacancy` SET `updated_status`='Reject' WHERE id='".$_POST['aww_center']."'";
   // echo $sql;
    $res=execute_query($sql);
    if($res){
        $msg="Data Updated!";
    }
    else{
        $msg="Failed Data Updated!";
    }
    echo $msg;
}


 
if(isset($_POST['action']) && $_POST['action'] == 'fetchGramPanchayat') {
     $project_id = !empty($_POST['project_id']) ? $_POST['project_id'] : '';
     $district_id = isset($_SESSION['distid']) ? $_SESSION['distid'] : 0;
     $gram_panchayat_id = !empty($_POST['gram_panchayat_id']) ? $_POST['gram_panchayat_id'] : '';

        $sql = "SELECT id, gram_panchayat_name FROM gram_panchayat WHERE project_id = ? and district_id = ? ORDER BY gram_panchayat_name ASC";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $project_id , $district_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        $returnHtml = '<option value="">Select Gram Panchayat</option>';
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $selected = $row['id'] == $gram_panchayat_id ? 'selected' : '';
                $returnHtml .= '<option value="' . $row['id'] . '" ' . $selected . '>' . $row['gram_panchayat_name'] . '</option>';
            }
        } 

        echo $returnHtml;

}

if(isset($_POST['action']) && $_POST['action'] == 'addvacancy') {
     $sql = "UPDATE new_vacancy SET vacancy_available = '".$_POST['status']."' WHERE id = '".$_POST['row_id']."'";
    $res=execute_query($sql);
     if ($res) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }
    exit;
}

 
?>
