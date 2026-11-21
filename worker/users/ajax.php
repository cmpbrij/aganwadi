<?php
 include '../config/sms-config.php';
    include '../config/db_config.php';
if(isset($_POST['aganid'])){
    $sql1="SELECT id,awc_name,vacancy_available,ews as ewsid,category,
    CASE 
        WHEN ews = 1 THEN 'Yes'
        ELSE 'No'
    END AS ews_status
     FROM `new_vacancy` WHERE id='".$_POST['aganid']."'";
    
    $res=execute_query($sql1);
    $row = mysqli_fetch_array($res);  
    echo json_encode($row);  
    
}
if(isset($_POST['ag_center_id'])){
    $sql="UPDATE `new_vacancy` SET `updated_status`='R' WHERE id='".$_POST['ag_center_id']."'";
    $res=execute_query($sql);
    if($res){
        $dist= $_SESSION['distid'];
        $sid = $_SESSION['distid'];
        $date= date('Y-m-d');
        $sql="INSERT INTO `vacancy_edit_details`(`userid`, `districtid`, `isvacancy`, `category`, `ews`, `date`, `centerid` ) VALUES ('".$dist."','".$sid."','".$_POST['vacancy']."','".$_POST['category']."','".$_POST['ews']."','".$date."','".$_POST['ag_center_id']."')";
       execute_query($sql);
        $msg="Data Updated!";
    }
    else{
        $msg="Failed Data Updated!";
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
    $smsres=sendOTP($otp,$mob);
    echo $smsres;
    
}

if(isset($_POST['sendotpforbroadsheet'])){
    $_SESSION['otp']=rand('1000','9999');
    $q = "UPDATE `vacancy_order` SET `otp`='".$_SESSION['otp']."' where dist_id='".$_SESSION['distid']."'";
   // echo $q;
    $res=execute_query($q);
    $sql = "SELECT mobile FROM admin_users WHERE district_id = '" . $_SESSION['distid'] . "'";
    $r=execute_query($sql);
    if(mysqli_num_rows($r) > 0){
        $row=mysqli_fetch_assoc($r);
        $smsres=sendOTP($_SESSION['otp'],$row['mobile']);
    }
  
    $response = [];

    if ($res) {
        $response['status'] = 'Success';
    } else {
        $response['status'] = 'Failed';
    }

    // Return the response as JSON
    echo json_encode($response);
  

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


//check category

if (isset($_POST['action']) && $_POST['action'] == 'checkCategory') {

    header('Content-Type: application/json');

    $category  = trim($_POST['category']);      // Applicant Category
    $center_id = trim($_POST['center_id']);     // Vacancy ID

    $sql = "SELECT category
            FROM new_vacancy
            WHERE id='$center_id'
            LIMIT 1";

    $result = execute_query($sql);

    if (!$result || mysqli_num_rows($result) == 0) {
        echo json_encode([
            'status' => 0,
            'message' => 'रिक्ति उपलब्ध नहीं है।'
        ]);
        exit;
    }

    $row = mysqli_fetch_assoc($result);
    $vacancyCategory = $row['category'];

    // Category Names
    $categoryNames = [
        1 => 'सामान्य (अनारक्षित)',
        2 => 'अन्य पिछड़ा वर्ग (OBC)',
        3 => 'अनुसूचित जाति (SC)',
        4 => 'अनुसूचित जनजाति (ST)'
    ];

    // General (Unreserved) - Everyone can apply
    if ($vacancyCategory == 1) {
        echo json_encode([
            'status' => 1,
            'message' => 'आप इस आंगनवाड़ी केंद्र पर आवेदन कर सकते हैं।'
        ]);
        exit;
    }

    // Reserved Category - Category Match
    if ($vacancyCategory == $category) {

        echo json_encode([
            'status' => 1,
            'message' => 'आप इस आंगनवाड़ी केंद्र पर आवेदन कर सकते हैं।'
        ]);

    } else {

        $reservedCategory = isset($categoryNames[$vacancyCategory])
            ? $categoryNames[$vacancyCategory]
            : 'निर्धारित श्रेणी';

        echo json_encode([
            'status' => 0,
            'message' => 'यह आंगनवाड़ी केंद्र <strong>' . $reservedCategory . '</strong> श्रेणी के लिए आरक्षित है। केवल <strong>' . $reservedCategory . '</strong> श्रेणी के अभ्यर्थी ही इस केंद्र पर आवेदन कर सकते हैं।'
        ]);
    }

    exit;
}
?>
