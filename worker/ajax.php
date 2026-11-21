<?php
require_once("config/db_config.php");
if (isset($_POST['distid'])) {
    $sql = "SELECT * FROM projects where district_id=" . $_POST['distid'];
    //echo $sql;
    $result = $conn->query($sql);
    $html='<option value="">कृप्या विक्लप चुने</option>';
    while ($row = $result->fetch_assoc()) {
        $html.='<option value="' . $row['id'] . '">' .strtoupper($row['project_name']). '</option>';
    }
   // echo $html;
}

// if (isset($_POST['mob'])) {
//     $mob=$_POST['mob'];
//     echo $mob;
//     //return $otp;
// }

// query start for tehseels 
if (isset($_POST['district_id'])) {
    $district_name = $_POST["district_id"];
    $sql = "SELECT * FROM tehseels where district_id ='" . $district_name . "'";
    $result = mysqli_query($conn, $sql);
    $html='<option value="">कृप्या विक्लप चुने</option>';
    while ($row = mysqli_fetch_array($result)) {
        $html.= ' <option value="' . $row["id"] . '">' .$row["tehseel_name"] . '</option>';
    }
    echo $html;
}
// query start for projects 
if (isset($_POST['project_name'])) {
    $project_name = $_POST["project_name"];
    $sql = "SELECT project_name,id FROM projects
     WHERE  district_id = '" . $project_name . "'";
    // echo $sql;
    $result = mysqli_query($conn, $sql);
    $html='<option value="">कृप्या विक्लप चुने</option>';
    while ($row = mysqli_fetch_array($result)) {
        $html.=' <option value="' . $row["id"] . '">' .strtoupper($row["project_name"]). '</option>';
    }
    echo $html;
}


if (isset($_POST['project_id'])) {
    $project_id = $_POST["project_id"];
    $sql = "SELECT DISTINCT awc_urban_rural,id,project_id FROM new_vacancy WHERE project_id = $project_id";
    // echo $sql;
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($result);
    echo ' <option value="' . $row["project_id"] . '">' . strtoupper($row["awc_urban_rural"]) . '</option>';
      
   
}


if (isset($_POST['adminprojeectID'])) {
    $project_id = $_POST["adminprojeectID"];
    $sql = "SELECT DISTINCT gram_panchayat_name,id FROM gram_panchayat WHERE project_id = $project_id";
    // echo $sql;
    $result = mysqli_query($conn, $sql);
   if(mysqli_num_rows($result)){
    $html='<option value="">Please Select</option>';
    while( $row = mysqli_fetch_array($result)){
        $html.='<option value="'.$row["id"].'">'.strtoupper($row["gram_panchayat_name"]).'</option>';
    }
    echo $html;
   }
   else{
    echo'<option value="">No data found</option>';
   }
   
   
      
   
}


if (isset($_POST['gramp']) && isset($_POST['projectID'])) {
    $gramp = $_POST["gramp"];
    $project=$_POST['projectID'];
    $dist=$_POST['distID'];
    if($gramp== '1'){
        $g="awc_urban_rural = 'Urban'";
    }
    else if($gramp== '2'){
        $g="awc_urban_rural = 'Rural'";
    }
    else{
        $g="1=1";
    }
    $project = $_POST["projectID"];
    $sql = "SELECT DISTINCT 
       COALESCE(NULLIF(gp_name, ''), ward_name) AS gp_or_ward_name FROM new_vacancy
    WHERE `district_id`='".$dist."' AND project_id ='".$project."' and  vacancy_available='Yes' AND ".$g;
   // echo $sql;
 
    $html='<option value="">कृप्या विक्लप चुने</option>';
    $result = execute_query($sql);

    while ($row = mysqli_fetch_array($result)) {
        $html.=' <option value="' . $row["gp_or_ward_name"] . '">' .strtoupper($row["gp_or_ward_name"]). '</option>';
    }
    echo $html;

}

if(isset($_POST['grampanchayatID']) && isset($_POST['UR'])){
    $gpid=$_POST['grampanchayatID'];
    $project_id=$_POST['pid'];
    $dist=$_POST['distID'];
    $gramp=$_POST['UR'];


    if($gramp== '1'){
        $g="awc_urban_rural = 'Urban'";
    }
    else if($gramp== '2'){
        $g="awc_urban_rural = 'Rural'";
    }
    else{
        $g="1=1";
    }
   
    $sql = "SELECT awc_name,id,unique_code,category FROM new_vacancy WHERE 
    district_id='".$dist."' AND project_id='".$project_id."'  AND (gp_name LIKE '".$gpid."' OR ward_name LIKE '".$gpid."') AND  vacancy_available='Yes' AND ".$g;
    //echo $sql;
    $result =execute_query($sql);
   
    $html='<option value="">कृप्या विक्लप चुने</option>';
    if(mysqli_num_rows($result) > 0){
        while($row = mysqli_fetch_array($result)){
            $html.=' <option value="' . $row["id"] . '">' .strtoupper($row["awc_name"]). '('.$row['unique_code'].')-'.getCategoryText($row['category']).'</option>';
        }
    }
    else{
        $html='<option value="">No data found</option>';
    }
   
    echo $html;

}

if(isset($_POST['mobileVal'])){
    $sql="select mobile from users where mobile='".$_POST['mobileVal']."'";
    //echo $sql;
    $res=execute_query($sql);
    if(mysqli_num_rows($res) > 0){
       echo'1';
    }
    else{
      echo '0';
    }
}


function getCategoryText($selectedValue){
	if ($selectedValue == '1') {
		return 'सामान्य (अनारक्षित)';
	} elseif ($selectedValue == '2') {
		return 'अन्य पिछड़ा वर्ग';
	} elseif ($selectedValue == "3") {
		return 'अनुसूचित जाति';
	} elseif ($selectedValue == "4") {
		return 'अनुसूचित जनजाति';
	} elseif ($selectedValue == "5") {
		return 'EWS';
	}
  else{
    return 'सामान्य (अनारक्षित)';
  }

}
