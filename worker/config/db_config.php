<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$tz = 'Asia/Kolkata';   
date_default_timezone_set($tz);

	$servername = '34.118.116.211';
	$username = 'icdsdbuser01';
	$password = 'VJHj(6FN|xy\M=:}';
	$db = 'worker_newdb_2026'; 
	$conn = mysqli_connect($servername,$username,$password,$db) ;
	if (!$conn){
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}  
	

	// $servername = '34.118.116.211';
	// $username = 'pgeuser';
	// $password = 'Nkpkak@10';
	// $db1 = 'aaganwadi_db2'; 
	// $conn1 = mysqli_connect($servername,$username,$password,$db1) ;
	// if (!$conn1){
	// 	echo "Failed to connect to MySQL: " . mysqli_connect_error();
	// } 
	

	function execute_query($query){
		global $conn;
		$result = mysqli_query($conn, $query);
		return $result;
	}
	


	// cors_and_security_headers.php
	
	// Handle preflight requests
	// if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	// 	header("Access-Control-Allow-Origin: https://upanganwadibharti.in/");
	// 	header("Access-Control-Allow-Methods: GET, POST");
	// 	header("Access-Control-Allow-Headers: Content-Type, Authorization");
	// 	header("Access-Control-Max-Age: 900");
	// 	header("Access-Control-Allow-Credentials: true");
	// 	exit(0);
	// }
	
	// CORS headers for all other requests
	// header("Access-Control-Allow-Origin: https://upanganwadibharti.in/");
	// header("Access-Control-Allow-Methods: GET, POST");
	// header("Access-Control-Allow-Headers: Content-Type, Authorization");
	// header("Access-Control-Allow-Credentials: true");
	
	// Security headers

	// header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://apis.google.com; style-src 'self' 'unsafe-inline' http://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data:; object-src 'none'; frame-ancestors 'none'; base-uri 'self';");
	// header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' https://apis.google.com https://cdnjs.cloudflare.com https://www.gstatic.com; script-src-elem 'self' 'unsafe-inline' https://apis.google.com https://cdnjs.cloudflare.com https://www.gstatic.com; style-src 'self' 'unsafe-inline' http://fonts.googleapis.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data:; object-src 'none'; frame-ancestors 'none'; base-uri 'self';");

	// PHP file that sends the CSP header
//	header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://apis.google.com https://cdnjs.cloudflare.com https://www.gstatic.com; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://www.gstatic.com; font-src 'self' https://fonts.gstatic.com; img-src 'self' data:; object-src 'none'; frame-ancestors 'none'; base-uri 'self';");

	// header("Strict-Transport-Security: max-age=31536000; includeSubDomains; preload");
	// header("X-Content-Type-Options: nosniff");
	// header("Permissions-Policy: geolocation=(), microphone=(), camera=()");
	// header('Content-Type: text/html; charset=utf-8');
	?>
	