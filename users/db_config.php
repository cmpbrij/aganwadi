<?php
	$servername = 'localhost';
	$username = 'pgeuser';
	$password = 'nkpkak00';
	$db = 'aaganwadi_db_new'; 
	$conn = mysqli_connect($servername,$username,$password,$db) ;
	if (!$conn){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}  
	

	function execute_query($query){
		global $conn;
		$result = mysqli_query($conn, $query);
		return $result;
	}
	
	
?>