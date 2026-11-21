<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

error_reporting(E_ALL);




  
if (isset($_GET['file'])) {
    // Handle form submission
    $selectedFiles = explode(",",$_GET['file']);
   
    $zip = new ZipArchive();
   
    $uid=explode("/",$selectedFiles[0]);
    if(isset($uid[4])){
        $file_names=$uid[4].".zip";
    }else{
        $file_names="doc.zip";
    }
  
    # create a temp file & open it
    $tmp_file = tempnam('.','');
    $zip->open($tmp_file, ZipArchive::CREATE);
  
    # loop through each file
    foreach($selectedFiles as $file){
  
        # download file
        $download_file = file_get_contents($file);
  
        #add it to the zip
        $zip->addFromString(basename($file),$download_file);
  
    }
  
    # close zip
    $zip->close();
  
    # send the file to the browser as a download
    header('Content-disposition: attachment; filename='.$file_names);
    header('Content-type: application/zip');
    readfile($tmp_file);;
}