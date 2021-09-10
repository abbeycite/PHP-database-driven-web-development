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
	<title> Picture </title>
	<link rel = "stylesheet" type = "text/css" href = "site.css">
</head>
<body>
<div class= "header">
    <img src="logo.jpg" alt="company logo">
    <h1>Picture</h1>
	<h2>Users Can Search member from his/her birthdate Here</h2>
</div>
<p class='clearall'>
	<a href = "index.html"> Home Page </a> <br>
</p>
<div id="items" class='clearall'>

<?php
		$month = filter_input(INPUT_GET, 'month');
		if ($month === false){
			unset($month);
		} 
		$day = filter_input(INPUT_GET, 'day');
		if ($day === false){
			unset($day);
		} 
		$year = filter_input(INPUT_GET, 'year');
		if ($year === false){
			unset($year);
		} 		
		
		
		if(isset($month) && isset($day) && isset($year)){
		$sql = "SELECT * from members
			WHERE MONTH(date_of_birth) = :month and DAY(date_of_birth) = :day and YEAR(date_of_birth) = :year";
			
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':month', $month, PDO::PARAM_INT);
		$stmt->bindValue(':day', $day, PDO::PARAM_INT);
		$stmt->bindValue(':year', $year, PDO::PARAM_INT);
		
		$stmt->execute();
		
		
		if ($stmt-> rowCount() > 0){
			$results = $stmt->fetchAll();
		?>
			
		<h3>Member list with birthdate:<?php echo $month.'/'.$day.'/'.$year;?></h3>
		<table>
			<tr>
				<th>Picture</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Date of Birth</th>
				<th>Year</th>
				<th>Heights</th>
				<th>Weights</th>
				<th>Language</th>
				<th>Nationality</th>
				<th>Occupation</th>
			</tr>
			
	<?php   foreach($results as  $row){
				echo "<tr>";
				echo "<td><a target='_blank' href='pics/",htmlspecialchars($row['member_id']),".jpg'><img src='pics/",htmlspecialchars($row['member_id']),".jpg' class='picture'/></a>", "</td>\n";
				echo "<td>", htmlspecialchars($row['firstname']), "</td>\n";
				echo "<td>", htmlspecialchars($row['lastname']), "</td>\n";
				echo "<td>", $month.'/'.$day.'/'.$year, "</td>\n";
				echo "<td>", htmlspecialchars($row['year']), "</td>\n";
				echo "<td>", htmlspecialchars($row['heights']), "</td>\n";
				echo "<td>", htmlspecialchars($row['weights']), "</td>\n";
				echo "<td>", htmlspecialchars($row['language']), "</td>\n";
				echo "<td>", htmlspecialchars($row['nationality']), "</td>\n";
				echo "<td>", htmlspecialchars($row['occupation']), "</td>\n";
				
				echo"</tr>";
			}
		}
		else{
			echo "No Results For your search, please try again.";
		}		
			
			$stmt->closeCursor();
	}	
	?>
			</table>
</div>	
	<div id="formArea">
		<h3>	
		Search Member Here		
		</h3>
		
		<form method="GET" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			
			<label>Month:</label>
			<input type="number" min="1" max="12" id="month" name="month" required="required">
			<br>
			<label>Day:</label>
			<input type="number" min="1" max="31" id="day" name="day" required="required">
			<br>
			<label>Year:</label>
			<input type="number" min="1920" max="2100" id="year" name="year" required="required">
			<br>
			
			<br>
			<input type="submit" value = "Search">
		    <input type="reset" value = "Reset">
			<br>
        </form>
	</div>
</body>
</html>
