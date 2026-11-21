<?php

	include'../config/db_config.php';
    include'../config/sms-config.php';
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    session_start();
        // use PHPMailer\PHPMailer\PHPMailer;
        // use PHPMailer\PHPMailer\SMTP;
        // use PHPMailer\PHPMailer\Exception;

        // require '../PHPMailer/src/PHPMailer.php';
        // require '../PHPMailer/src/SMTP.php';
        // require '../PHPMailer/src/Exception.php';


     function generatePassword($length = 6) {
            $characters = '0123456789';
            $password = '';
        
            for ($i = 0; $i < $length; $i++) {
                $password .= $characters[rand(0, strlen($characters) - 1)];
            }
        
            return $password;
        }
        
        
    
    if(isset($_POST['registration_submit'])){
        $mobile = stripslashes($_POST['mobile_no']);
        $sql="select mobile from users where mobile='".$mobile."'";
       // echo $sql;  die;
        $res=execute_query($sql);
        if(mysqli_num_rows($res) > 0){
          $_SESSION['mobval']="Mobile";
          header('Location: registration.php');
          exit;
        }

        $captcha=$_POST['captcha'];
		$cstatus=json_decode(verifyCaptcha($captcha),true);
		//print_r($cstatus); die;
		if($cstatus['captcha_status'] ==407){
            //echo"test1"; die;
			$_SESSION['cerror']="Captcha Expired! Please refersh the page";
			 header('Location: registration.php');
			 exit;
		}
		else if($cstatus['captcha_status'] ==400){
           // echo"test2"; die;
			$_SESSION['cerror']="Captcha Verification Failed!";
			 header('Location: registration.php');
			 exit;
		}
       // echo"test"; die;
        $name = stripslashes($_POST['applicant_name']);
        $fname = stripslashes($_POST['father_name']);
        $district = stripslashes($_POST['district']);
       // $category = stripslashes($_POST['category']);
        // $mobile = stripslashes($_POST['mobile']);
        $aadhar = stripslashes($_POST['aadhar']);
	
        //$age = stripslashes($_POST['age']);
        $emailid= stripslashes($_POST['emailid']);

      //  $otp = rand(1000,9999);
       
        // $html="<img src='https://upanganwadibharti.in/images/login_logo.jpg' alt='Icds' width='250' height='150'>";
        // $html .= "<table>
        //         <div class='card ca' style='border:2px solid black;height:400px;width:100%;background-color:#d5eef2;border-radius:10px;'>
        //         <p style='padding:20px 0px 10px 15px;'>Hello  ".$name."</p>
        //         <p style='padding:5px 15px 0px 30px'>Thank you for registering at AWW Portal.</p>
        //         <p style='padding:5px 15px 0px 30px'>Your account credential is:</p>
        //         <div class='container cont-12'>
        //             <p style='padding:0px 0px 0px 30px'><b> Email Id : $emailid <b></p>
        //             <p style='padding:0px 0px 0px 30px'><b> OTP : $otp </b></p>
        //         </div>
        //         <p style='padding:5px 15px 0px 30px'>Please log in to your Dashboard to continue further.</p>
        //         <p style='padding:5px 15px 0px 30px'>Your assistance is our priority. You can reply to this mail to reach us.</p>
        //         <p style='padding:5px 15px 0px 30px'>Regards, ICDS</p>
                
        //         </div>
        //         </table>";
                // $mail = new PHPMailer(true);
                // try {
                //     $mail->isSMTP();
                //     $mail->Host = "smtp.gmail.com";
                //     $mail->Port = 587;
                //     $mail->SMTPSecure = "tls";
                //     $mail->SMTPAuth = true;
                //     $mail->Username = "upanganwadibharti@gmail.com";
                //     $mail->Password = "Abcd1234@";
                //     $mail->SetFrom("upanganwadibharti@gmail.com", $emailid);
                //     //EMAIL  VARIABLE ASSIGN
                //     $mail->addAddress("$emailid");
                //     $mail->IsHTML(true);
                //     $mail->Subject = "Anganwadi Recruitment 2024";
                //     $mail->Body = $html;
                //     $mail->SMTPOptions = array(
                //         'ssl' => array(
                //             'verify_peer' => false,
                //             'verify_peer_name' => false,
                //             'allow_self_signed' => false
                //         )
                //     );
                //     $mail->send();
                //     // echo 'Message has been sent';
                // } catch (Exception $e) {
                //     echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                // }
            $pass=md5($_POST['pass']);         
            $sql="INSERT INTO `users`(`name`, `father_name`, `district`,`aadhar_no`, `mobile`, `emailid`,`created`, `otp`,`status`,`password`) VALUES ('".$name."','".$fname."','".$district."','".$aadhar."','".$mobile."','".$emailid."','".date('Y-m-d H:i:s')."','','0','".$pass."')";
            $res=mysqli_query($conn,$sql);	
          //  echo $sql;	 die;
        
            if($res){
                // $_SESSION['otp']=$otp;
                // $_SESSION['mobile']=$mobile;
                $_SESSION['success']='otp-page';
                $_SESSION['msg']='आप के मोबइल नंबर पे ओटीपी सफलतापूर्वक भेज दिया गया है';
               
               // $smsres=sendregOTP($otp,$mobile,$pass);
                unset($_SESSION['countdown_time']);
                header('Location: login.php');
                exit();
            }
            else{
                echo"Error in registration Please try again!";
            }

        }
    
    

    function getIpAddr(){
        if (!empty($_SERVER['HTTP_CLIENT_IP'])){
        $ipAddr=$_SERVER['HTTP_CLIENT_IP'];
        }elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $ipAddr=$_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
        $ipAddr=$_SERVER['REMOTE_ADDR'];
        }
        return $ipAddr;
    }

    if(isset($_GET['mob'])){
        $otp = rand(1000,9999);
        sendOTP($otp,$_GET['mob']);
		$sql="UPDATE `users` SET `otp`='".$otp."' WHERE mobile='".$_GET['mob']."'";
        execute_query($sql);
		$_SESSION['otp']= $otp;
		unset($_SESSION['countdown_time']);
		$_SESSION['msg']='दुबारा आपके मोबइल नंबर पे ओटीपी सफलतापूर्वक भेज दिया गया है';
        header('Location: otp.php');
    }

    if(isset($_POST['otpVerify'])){
        $sql="select * from users where mobile='".$_SESSION['mobile']."'";
        $r=execute_query($sql);
        if(mysqli_num_rows($r) > 0){
            $olddata=mysqli_fetch_array($r);
        }
        else{
            echo "Some proble occure";
        }

        $captcha=$_POST['captcha'];
		$cstatus=json_decode(verifyCaptcha($captcha),true);
		//print_r($cstatus); die;
		if($cstatus['captcha_status'] ==407){
			$_SESSION['cerror']="Captcha Expired! Please refersh the page";
			 header('Location: otp.php');
			 exit;
		}
		else if($cstatus['captcha_status'] ==400){
			$_SESSION['cerror']="Captcha Verification Failed!";
			 header('Location: otp.php');
			 exit;
		}
       $otp=$_POST['otp'];
        if(isset($_SESSION['otp-login'])){
            if($otp == $_SESSION['otp-login']){
                $_SESSION['success']="Login successfully!";
                header('Location: application_details.php');
            }
            else{
                $_SESSION['nototp']='no';
                header('Location: otp.php');
                echo "OTP error";
            }
        }

        if(isset($_SESSION['otp-rev'])){
            if($_SESSION['otp-rev'] == $otp){
              
                $_SESSION['success']="Login successfully!";
                unset($_SESSION['otp-rev']);
                header('Location: login.php');
            }
            else{
                $_SESSION['nototp']='no';
                header('Location: otp.php');
                echo "OTP error";
            }
        }
       
        if(isset($_POST['otp'])){
        //echo $otp; die;
            if($_POST['otp'] == $_SESSION['otp']){
                $sql1="UPDATE users set status=1 where mobile='".$_SESSION['mobile']."'";
                execute_query($sql1);
                $_SESSION['success']="Registration successful, Please login here";
                unset($_SESSION['countdown_time']);
                header('Location: login.php');
            }
            else{
                echo "OTP error";
            }
        }

        
    }

	if(isset($_POST['login_submit'])){
       
		$time=time()-360;
       // echo $time;
        $ip_address=getIpAddr();
        // Getting total count of hits on the basis of IP
        $q="select count(*) as total_count from loginchecks where time > $time and ip='$ip_address'";
        $query=execute_query($q);
        $check_login_row=mysqli_fetch_assoc($query);
        $total_count=$check_login_row['total_count'];
        //echo "---".$total_count; 

        
        //Checking if the attempt 3, or youcan set the no of attempt her. For now we taking only 3 fail attempted
        if($total_count==3){
            header('Location: login.php');
            $msg="To many failed login attempts. Please login after 30 sec";
            $_SESSION['msg']=$msg;
        }
        else{
            $uname = stripslashes($_REQUEST['user_id']);
            //escapes special characters in a string
             $uname = mysqli_real_escape_string($conn,$uname);
            $sql="select * from users where mobile='".$uname."' and password='".md5($_POST['pass'])."'";
           //echo $sql; die;
            $re=execute_query($sql);
            if(mysqli_num_rows($re) == 1){
                $data=mysqli_fetch_assoc($re);
                //print_r($data);
               
                    // $otp = rand(1000,9999);
                    // sendOTP($otp,$_POST['user_id']);
                    // $sql="UPDATE `users` SET `otp`='".$otp."' WHERE mobile='".$_POST['user_id']."'";
                    //  execute_query($sql);
                     //echo $sql; die;
                    // $_SESSION['otp-rev']=$otp;
                    $_SESSION['msg']='yes';
                    $_SESSION['uid'] = $data['id'];
                    $_SESSION['mobile'] = $data['mobile'];
                    if($ddata['application_no']==null){
                        $_SESSION['success']="Login Successfuly!";
                        header('Location: application_details.php');
                        exit;
                    }
                    else{
                        $_SESSION['success']="Login Successfuly!";
                        header('Location: dashboard.php');
                        exit;
                    }
                
            }
           
            else{
                $_SESSION['errorlogin']='Mobile number is wrong';
                $total_count++;
                $rem_attm=3-$total_count;
                if($rem_attm==0){
                    $msg="To many failed login attempts. Please login after 60 Minuts";
                    $_SESSION['lmsg']=$msg;
                }else{
                $msg="Please enter valid login details.<br/>$rem_attm attempts remaining";
                $_SESSION['lmsg']=$msg;
                }
                $try_time=time();
                $res=execute_query("insert into loginchecks(ip,time) values('$ip_address','$try_time')");
                header('Location: login.php');
                exit();
                //echo $res; die;

                // echo "Something went wrong!<BR>";
                // echo "Error Description: ", $conn -> error;
            }
        }
		
	}

    if(isset($_POST['loginotpVerify'])){
        $sql="select * from users where mobile='".$_SESSION['mobile']."' and status=1";
       // echo $sql;
        $r=execute_query($sql);
        if(mysqli_num_rows($r) > 0){
            $olddata=mysqli_fetch_array($r);
        }
        else{
            echo "Some proble occure";
        }

        $captcha=$_POST['captcha'];
		$cstatus=json_decode(verifyCaptcha($captcha),true);
		//print_r($cstatus); die;
		if($cstatus['captcha_status'] ==407){
			$_SESSION['cerror']="Captcha Expired! Please refersh the page";
			 header('Location: otp.php');
			 exit;
		}
		else if($cstatus['captcha_status'] ==400){
			$_SESSION['cerror']="Captcha Verification Failed!";
			 header('Location: otp.php');
			 exit;
		}
        $otp=$_POST['otp'];
        if($_SESSION['otp-login']==$otp){
            unset($_SESSION['otp-login']);
            if($olddata['application_no']==null){
                $_SESSION['success']="Login Successfuly!";
                header('Location: application_details.php');
                exit;
            }
            else{
                $_SESSION['success']="Login Successfuly!";
                header('Location: dashboard.php');
                exit;
            }
        }
        else{
            $_SESSION['no_match']="OTP Wrong!";
            header('Location: otp.php');
        }
        

        
    }


if(isset($_POST['save_user'])){
				   // removes backslashes

		$captcha=$_POST['captcha'];
		$cstatus=json_decode(verifyCaptcha($captcha),true);
		//print_r($cstatus); die;
		if($cstatus['captcha_status'] ==407){
			$_SESSION['cerror']="Captcha Expired! Please refersh the page";
			 header('Location: registration.php');
			 exit;
		}
		else if($cstatus['captcha_status'] ==400){
			$_SESSION['cerror']="Captcha Verification Failed!";
			 header('Location: registration.php');
			 exit;
		}

        $mobile = stripslashes($_POST['mobile']);
        $sqli = mysqli_query($conn, "SELECT * FROM `users` WHERE `mobile` = '$mobile'");
        if (mysqli_num_rows($sqli) > 0) {
            $_SESSION['MobErr']='Mobile Number is already Exits';
            header('Location: registration.php');
            exit;
        } 

		$sql = "INSERT INTO `users`(`name`, `father_name`, `mobile`, `dob`, `category`, `password`, `created`, `updated`) VALUES ('".$_POST['name']."','".$_POST['father_name']."','".$_POST['mobile']."','".$_POST['dob']."','".$_POST['category']."','".md5($_POST['pass'])."','','')";
        $stmt = $conn -> query($sql);
        if($stmt){
            $_SESSION['log'] = $uname;
            $_SESSION['success']='success';
            header('Location: login.php');
            exit();
        }
        else{
            echo "Something went wrong!<BR>";
            echo "Error Description: ", $conn -> error;
      }
		
	}

    
	function verifyCaptcha($input) {
    /**
     verifyCaptcha : This function verifies the validity of Captcha Images
     
     @return : 407 (captcha expired), 200 (captcha verified), 400 (captcha unverified), 500 (Server Error)
     **/

 	 $date = time();
    if(isset($_SESSION['captcha_set']) &&
        isset($_SESSION['captcha_token']) &&
            isset($_SESSION['captcha_expire'])) {
                //assign values
                $captcha_expire = $_SESSION['captcha_expire'] ;
                $captcha_token = $_SESSION['captcha_token'];
                //check if captcha has expired
               if($date < $_SESSION['captcha_expire']){
                    if(md5($input.$captcha_expire) == $captcha_token){
                        unset( $_SESSION['captcha_expire'] );
                        unset( $_SESSION['captcha_token']);
                        unset($_SESSION['captcha_set']);
                        $return = array(
                            "captcha_status" => 200,
                            "captcha_message" => "Captcha Verified!",
                        );
                        return json_encode($return); 
                    } else {
                        $return = array(
                            "captcha_status" => 400,
                            "captcha_message" => "Captcha Verification Failed!",
                         );
                         return json_encode($return);
                    }

                }else{
                    $return = array(
                    "captcha_status" => 407,
                    "captcha_message" => "Captcha Expired!",
                    );
                    return json_encode($return);
               }
            }else{
                $return = array(
                "captcha_status" => 500,
                "captcha_message" => "Session Invalid!",
                 );
                return json_encode($return);
            }
}

if(isset($_POST['reset_pass'])){
   
    $captcha=$_POST['captcha'];
    $cstatus=json_decode(verifyCaptcha($captcha),true);
    //print_r($cstatus); die;
    if($cstatus['captcha_status'] ==407){
        //echo"test1"; die;
        $_SESSION['cerror']="Captcha Expired! Please refersh the page";
         header('Location: resetPass.php');
         exit;
    }
    else if($cstatus['captcha_status'] ==400){
       // echo"test2"; die;
        $_SESSION['cerror']="Captcha Verification Failed!";
         header('Location: resetPass.php');
         exit;
    }
    $sql="select mobile from users where mobile='".$_POST['user_id']."'";
    $res=execute_query($sql);
    if(mysqli_num_rows($res) ==1){
        $row=$data['mobile'];
        $otp = rand(1000,9999);
        $_SESSION['reset-otp']=$otp;
        $_SESSION['reset_mobile']=$_POST['user_id'];
        $_SESSION['resetmsg']="OTP send";
        $_SESSION['temp_pass']=$_POST['pass'];
        header('Location: resetotp.php');
        exit;
        
    }
    else{
        $_SESSION['r_wrong']="Mobile is wrong!";
        header('Location: resetPass.php');
        exit;
    }
   

   

}

if(isset($_POST['resetotpVerify'])){
    $captcha=$_POST['captcha'];
    $cstatus=json_decode(verifyCaptcha($captcha),true);
    //print_r($cstatus); die;
    if($cstatus['captcha_status'] ==407){
        //echo"test1"; die;
        $_SESSION['cerror']="Captcha Expired! Please refersh the page";
         header('Location: resetPass.php');
         exit;
    }
    else if($cstatus['captcha_status'] ==400){
       // echo"test2"; die;
        $_SESSION['cerror']="Captcha Verification Failed!";
         header('Location: resetPass.php');
         exit;
    }
    if($_POST['otp']==$_SESSION['reset-otp']){
    $pass=md5($_SESSION['temp_pass']);
    $sql="UPDATE users set password='".$pass."' WHERE mobile='".$_SESSION['reset_mobile']."'";
   // echo $sql; die;
    $res=execute_query($sql);
    if($res){
        unset($_SESSION['reset_mobile']);
        unset($_SESSION['reset-otp']);
        unset($_SESSION['temp_pass']);
        $_SESSION['resetsucc']="Reset Password";
        $smsres=sendOTP($otp,$mobile);
        header('Location: login.php');
        exit;
    }
    }
    else{
        $_SESSION['otp-w']="OTP Wrong!";
        header('Location: resetotp.php');
        exit;
    }
}


?>