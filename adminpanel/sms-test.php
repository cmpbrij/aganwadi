<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
            include('../config/sms-config.php');

            $otp = rand(1000,9999);
           $s= sendresetOTP($otp,'9838668867');
           print_r($s);
?>