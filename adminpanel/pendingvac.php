 <?php
  include 'admin_master.php';
  ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
        $i=1;
        $sql = "SELECT `id`, `district_name` FROM `districts`";
        
        $res=execute_query($sql);
        while ($data = mysqli_fetch_assoc($res)) {

            $q="select id,unique_code,awc_name,district_id,project_id,gram_panchayat_id from new_vacancy where district_id='".$data['id']."' AND vacancy_available = 'Yes'";
            
            $vres=execute_query($q);
            while($vdata=mysqli_fetch_assoc($vres)){
                  $q1="select id from decleration where district_id='".$data['id']."' AND final_selection='1' and aganwadi_center='".$vdata['id']."'";
                  $jres=execute_query($q1);
                 
                  if(mysqli_num_rows($jres) > 0){
                    
                  }
                  else{
                    $sql="INSERT INTO `old_vacancy`(`unique_code`, `awc_name`, `district_id`, `project_id`, `gp_id`, `new_vacancy_id`) VALUES ('".$vdata['unique_code']."','".$vdata['awc_name']."','".$vdata['district_id']."','".$vdata['project_id']."','".$vdata['gram_panchayat_id']."','".$vdata['id']."')";
                  }
            }

          
            
            
        }

?>