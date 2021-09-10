<!DOCTYPE html>
<!---
  Abiodun Abidemi
  PHP-Project
  --->
  
<?php
	require('database.php');
?>  
<html lang = "en-US">
<head>
    <meta charset = "utf-8">
	<title> Author </title>
	<link rel = "stylesheet" type = "text/css" href = "site.css">
</head>
<body>
<div class= "header">
    <img src="logo.jpg" alt="company logo">
    <h1>Member's Weight Change</h1>
	<h2>Users Can Estimate Members' Weight Change Here</h2>
</div>
<p class='clearall'>
	<a href = "index.html"> Home Page </a> <br>
</p>
<div id="items" class='clearall'>

<?php
		$FirstName = filter_input(INPUT_POST, 'firstname');
		if ($FirstName === false){
			unset($FirstName);
		} 
		$LastName = filter_input(INPUT_POST, 'lastname');
		if ($LastName === false){
			unset($LastName);
		} 
		$Date = filter_input(INPUT_POST, 'date');
		if ($Date === false){
			unset($Date);
		}
       $weight = filter_input(INPUT_POST, 'weight');
		if ($weight === false){
			unset($weight);
		}  		
		
		
		if(isset($FirstName) && isset($LastName) && isset($Date)&& isset($weight)){

	    $x = 2.5;
		$weight = $_POST["weight"];
		$name = $_POST["firstname"];
		$future_weight = $weight + $x+$x+$x+$x;
		
		echo "If weights increases by 2.5lbs for every quarter", " then " .$name. "'s" ." future weight will be " . $future_weight ." after 1 year" ;
		}
	?>		
</div>	
	<div id="formArea">
		<h3>	
		Search Member Here		
		</h3>
		
		<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			
			<label>First Name:</label>
			<input type="text" id="firstname" name="firstname" required="required">
			<br>
			<label>Last Name:</label>
			<input type="text" id="lastname" name="lastname" required="required">
			<br>
		
		    <label> Date:</label>
		    <input type="date" name="date" id="date" required>
			<br>
			<label> Weight(in lbs):</label>
		    <input type="float" name="weight" id="weight" value="<?php echo htmlspecialchars($weight); ?>" required>
			
			<br>
			<input type="submit" value = "Search">
		    <input type="reset" value = "Reset">
			<br>
        </form>
	</div>
</body>
</html>
