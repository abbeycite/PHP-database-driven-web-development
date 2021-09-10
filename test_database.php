<!DOCTYPE html>
<!---
  Abiodun Abidemi
  CSCI 5060
  Project
  --->
<html>
<head>
	<meta charset="utf-8">
	<title>Test database connection</title>
</head>
<body>
	<h1>Test database connection</h1>
	<?php
		$dbName   = "family";
		$username = "family";
		$password = "Surakat084";
		$host = "localhost";
		//$host = "localhost:7777";//
		
		$dsn = "mysql:host=$host;dbname=$dbName";
		
		try {
			$db = new PDO($dsn, $username, $password);
			
			echo "SUCCESS!!!!!!!";
		} catch (PDOException $e) {
			echo "FAILURE. Reason: ", $e->getMessage();
		}
	?>
</body>
</html>