<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 include 'master.php';
 ob_start();
 
 if(!checkLogin()){
   header('Location: login.php');

 }

 
 if(isset($_POST['uploadOrder'])){
    $otp = rand(1000,9999);
    $_SESSION['otp-login']=$otp; 
    header('Location: admin-otp.php');
    
 }

if(isset($_POST['saveuploadOrder'])){
    $date=date("Y-m-d H:i:s");
    $dir='../uploadOrder/';
    if (!file_exists ($dir)){
        mkdir('../uploadOrder/'.$dir,0777,true);  
    }
   
    $fileName = basename($_FILES["pdffile"]["name"]); 
    $randName = 'ordercopy'.time();
    $fileType = pathinfo($fileName,PATHINFO_EXTENSION);
    $targetFilePath = $dir.$randName .'.'.$fileType;
  
    //allow certain file formats
    $allowTypes = array('pdf','PDF');
    if(in_array($fileType, $allowTypes)){
        //upload file to server
        if(move_uploaded_file($_FILES["pdffile"]["tmp_name"], $targetFilePath) ){
        // $statusMsg = "The file ".$fileName. " has been uploaded.";

        $sqldata = "SELECT * FROM `vacancy_order` WHERE `dist_id` = '" . $_SESSION['distid'] . "'";
        $resu = execute_query($sqldata);
        $data = mysqli_num_rows($resu);
        if($data > 0){
            $_SESSION['error']="Vacancy already uploaded";
            header('Location: uploadvacancy.php');
        }
        else{
            $sql="INSERT INTO `vacancy_order`(`dist_id`,`pdf_name`,`last_date`,`uploaded_date`,`cutoff_date`) VALUES ('".$_SESSION['distid']."','".$targetFilePath."','".$_POST['last_date']."','".date('Y-m-d')."','".$_POST['cutoff_date']."')";
            
            // echo $sql;
             $stmt = $conn -> query($sql);
        }

           
            $msg="PDF Uploaded Successfully";
            $_SESSION['success-1']=$msg;
            $_SESSION['photoupdatedid']=mysqli_insert_id($conn);
            header('Location: uploadvacancy.php');
        }else{
            $statusMsg = "Sorry, there was an error uploading your file.";
            echo $statusMsg;
            die;
        }
    }else{
        $statusMsg = 'Sorry, Please upload PDF file';
        $_SESSION['error']=$statusMsg;
        echo  $statusMsg; 

    }
}

if (isset($_POST['extenddate'])) {
    $sql = "SELECT * FROM vacancy_order WHERE dist_id='" . $_SESSION['distid'] . "'";
    $resu = execute_query($sql);
    $row = mysqli_fetch_assoc($resu);
  //  $row1 = ($row['vacancy_extend_status'] == 0);
    $ldate = $row['last_date'];
    $days = $_POST['days'];
    echo $days;
    
    if($days > 10){
        //echo"test";
        $_SESSION['max-days']="Max 10 days";
      //  die;
        header('Location: extend_application_date.php');
        exit;
        die;
    }

 
    if($row['extend_day'] !=null){
        $_SESSION['onetime']="Max 10 days";
        header('Location: extend_application_date.php');
        exit;
        die;
    }
    $edate = date('Y-m-d', strtotime($ldate . ' + ' . $days . ' days'));
// ///////////////////////////////////////////////////////////////////////
$dir='../uploadOrder/';
    if (!file_exists ($dir)){
        mkdir('../uploadOrder/'.$dir,0777,true);  
    }
   
    $fileName = basename($_FILES["extend_order_pdf"]["name"]); 
    $randName = 'ordercopy'.time();
    $fileType = pathinfo($fileName,PATHINFO_EXTENSION);
    $targetFilePath = $dir.$randName .'.'.$fileType;
  
    //allow certain file formats
    $allowTypes = array('pdf','PDF');
    if(in_array($fileType, $allowTypes)){
        //upload file to server
        if(move_uploaded_file($_FILES["extend_order_pdf"]["tmp_name"], $targetFilePath) ){
        // Update the vacancy_order table with the new extended date
        $sql_update = "UPDATE vacancy_order SET extend_day='" . $_POST['days'] . "', last_date='" . $edate . "' ,extend_order_pdf = '$targetFilePath' WHERE dist_id='" . $_SESSION['distid'] . "'";
        execute_query($sql_update);

        $_SESSION['success'] = "Vacancy date extended successfully";
        header('Location: extend_application_date.php');
        }
        else{
            $_SESSION['extendpdf']="extend_application_date";
        }
    }
}


if(isset($_POST['save_subCategory'])){
  
    if(isset($_POST['handicap'])){
        $h=1;
    }else{
        $h=0;
    }
    if(isset($_POST['ff'])){
        $ff=1;
    }else{
        $ff=0;
    }

    if($_POST['editid']!=""){
        $sql="UPDATE setting set sub_category_hadnicap='".$h."', sub_category_ff='".$ff."' where id='".$_POST['editid']."'";
       // echo $sql; die;
        $res=execute_query($sql);
        $_SESSION['success-update']="success";
        header('Location: sub_category_setting.php');
    }
    else{
        $sql="INSERT INTO `setting`(`district_id`, `sub_category_hadnicap`, `sub_category_ff`) VALUES ('".$_SESSION['distid']."','".$h."','".$ff."')";
      
        $res=execute_query($sql);
        header('Location: sub_category_setting.php');
    }
   
    if($res){
        $msg="Setting Done";
        $_SESSION['success']=$msg;
       
        header('Location: sub_category_setting.php');
    }
    else{

    }

}

if(isset($_POST['verifyotp_brodsheet'])){
    if($_SESSION['otp'] == $_POST['otp']){
        $sql="UPDATE vacancy_order set vacancy_open_status=1 where dist_id='".$_SESSION['distid']."'";
        $res=execute_query($sql);
        $_SESSION['success']="Broadsheet Opened";
        unset($_SESSION['otp']);
        header('Location: broadsheet-dist.php');
        
    }
    else{
        $_SESSION['error']="Something is wrong";
        header('Location: broadsheet-dist.php');
    }
}

?>