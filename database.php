<!---
  Abiodun Abidemi
  PHP-Project
  --->
<?php
	$dbName   = "family";
	$username = "family";
	$password = "Surakat084";
	$host = "localhost";
	//$host = "localhost:7777";//
	
	$dsn = "mysql:host=$host;dbname=$dbName";
	
	try {
		$db = new PDO($dsn, $username, $password);
		$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	} catch (PDOException $e) {
		error_log("Database connection error: Reason: " . $e->getMessage(), 0);
		include('database_error.html');
		echo $e;
		exit();
	}
?>
