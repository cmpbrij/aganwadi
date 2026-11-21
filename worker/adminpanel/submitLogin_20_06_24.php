<?php
include('../config/db_config.php');
session_start();

    if(isset($_POST['login'])){
    // removes backslashes

        $uname = stripslashes($_REQUEST['uname']);
       // echo $uname;
     
        //escapes special characters in a string
        $uname = mysqli_real_escape_string($conn,$uname);
        $pass = stripslashes($_REQUEST['pass']);
        $pass = mysqli_real_escape_string($conn,$pass);
        $pass=md5($pass);

       // echo $pass;

        $sql = "SELECT * FROM `admin_users` WHERE `userid`='".$uname."' and `password`='".$pass."'";
      //  echo $sql; die;
        $stmt = $conn -> query($sql);
        $count=mysqli_num_rows($stmt); 
        //echo $count; die;
        if($count >=1){
            $row=mysqli_fetch_assoc($stmt);
            $role=$row['user_type'];
      //  print_r($role); die;

            $ip=get_client_ip();
            if($role =='DPO'){
                $_SESSION['role'] = 'DPO';
                $_SESSION['adminid'] =$row['userid'];
                $_SESSION['distid'] =$row['district_id'];
                $_SESSION['sid'] =$row['id'];
                // $_SESSION['log'] = rand(16);
                $_SESSION['success']='Login Successfully!';
                $sql="INSERT INTO `admin_login_details`(`user_id`, `distid`, `date`, `user_type`,`ip`) VALUES ('".$uname."','".$row['district_id']."','".date('Y-m-d')."','DPO','".$ip."')";
                execute_query($sql);

               // echo $sql; die;
                header('Location: dashboard.php');
                
            }
            else if($role='admin'){
                $_SESSION['role'] = 'admin';
                $_SESSION['uid'] =$row['userid'];

               // echo  $_SESSION['uid'] ; die;
                // $_SESSION['log'] = rand(16);
                //$_SESSION['success']='success';
                $sql="INSERT INTO `admin_login_details`(`user_id`, `distid`, `date`, `user_type`,`ip`) VALUES ('".$uname."','".$row['district_id']."','".date('Y-m-d')."','ADMIN','".$ip."')";
                execute_query($sql);
                //echo $sql; die;
                header('Location: admin_dashboard.php');
            }

            exit();
        }
        else{
            $_SESSION['warning']="Password is wrong";
          
        header('Location: login.php');
       // echo "Error Description: ", $conn -> error;
        }

    }
    if(isset($_POST['changePass'])){
        
        $sql = "SELECT password FROM admin_users WHERE userid='".$_SESSION['adminid']."'";
        $result = execute_query($sql);

        if (mysqli_num_rows($result) > 0) {
            $oldpass=md5($_POST['old_pass']);
            $newpass=md5($_POST['new_pass']);
            $row = $result->fetch_assoc();
            $stored_password = $row["password"];
            
            // Verify current password
            if ($stored_password==$oldpass) {
               
                $update_sql = "UPDATE admin_users SET password = '".$newpass."' WHERE userid='".$_SESSION['adminid']."'";
                
                if (execute_query($update_sql) === TRUE) {
                    $_SESSION['success']="Password updated successfully";
                   

                    header('Location: change_pass.php');
                } else {
                    $_SESSION['error_in_change']="Error in password change";
                   
                    header('Location: change_pass.php');
                    
                }
            } else {
                $_SESSION['warning']="Old password not matched";
               
                header('Location:change_pass.php');
            }
        } else {
            echo "User not found";
        }



    }

    if(isset($_POST['adminchangePass'])){
        
        $sql = "SELECT password FROM admin_users WHERE userid = '".$_SESSION['uid']."'";
        $result = execute_query($sql);

        if (mysqli_num_rows($result) > 0) {
            $oldpass=md5($_POST['old_pass']);
            $newpass=md5($_POST['new_pass']);
            $row = $result->fetch_assoc();
            $stored_password = $row["password"];
            
            // Verify current password
            if ($stored_password==$oldpass) {
               
                $update_sql = "UPDATE admin_users SET password = '$newpass' WHERE userid = '".$_SESSION['uid']."'";
                
                if (execute_query($update_sql) === TRUE) {
                    $_SESSION['success']="Password updated successfully";
                   

                    header('Location: admin_change_pass.php');
                } else {
                    $_SESSION['error_in_change']="Error in password change";
                   
                    header('Location: admin_change_pass.php');
                    
                }
            } else {
                $_SESSION['warning']="Old password not matched";
               
                header('Location:admin_change_pass.php');
            }
        } else {
            echo "User not found";
        }



    }

    function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
?>

