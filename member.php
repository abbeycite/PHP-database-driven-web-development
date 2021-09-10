<!DOCTYPE html>
<!---
  Abiodun Abidemi
  CSCI 5060
  Project
  --->
  
<?php
	require('database.php');
?>  
<html>
<head>
    <meta charset = "utf-8">
	<title> Member Form </title>
	<link rel = "stylesheet" type = "text/css" href = "site.css">
</head>
<body>
<div class= "header">
    <img src="logo.jpg" alt="company logo">
    <h1>Member Form</h1>
	<h2>You can Insert, delete, and update member data</h2>
	
</div>
<p class='clearall'>
	<a href = "index.html"> Home Page </a> <br>
</p>
<?php

	$operation = filter_input(INPUT_POST, 'operation');
	
	if ($operation == 'insert') {
		$firstname = filter_input(INPUT_POST, 'firstname');
		$lastname = filter_input(INPUT_POST, 'lastname');
		$date_of_birth = filter_input(INPUT_POST, 'date_of_birth');
		//$year = filter_input(INPUT_POST, 'year',FILTER_VALIDATE_INT);
		$heights = filter_input(INPUT_POST, 'heights',FILTER_VALIDATE_FLOAT);		
		$weights = filter_input(INPUT_POST, 'weights',FILTER_VALIDATE_FLOAT);
		$language = filter_input(INPUT_POST, 'language');
		$nationality = filter_input(INPUT_POST, 'nationality');
		$occupation = filter_input(INPUT_POST, 'occupation');
		
		
		$sql = "INSERT INTO members
			    (firstname, lastname, date_of_birth, year, heights, weights, language, nationality, occupation) VALUES 
				(:firstname, :lastname, :date_of_birth, YEAR(:date_of_birth),:heights, :weights, :language, :nationality, :occupation)";
		$stmt = $db->prepare($sql);
		
		$stmt->bindValue(':firstname', $firstname, PDO::PARAM_STR);
		$stmt->bindValue(':lastname', $lastname, PDO::PARAM_STR);
		$stmt->bindValue(':date_of_birth', $date_of_birth, PDO::PARAM_STR);
		//$stmt->bindValue(':year', $year, PDO::PARAM_STR);
		$stmt->bindValue(':heights', (string)$heights, PDO::PARAM_STR);
		$stmt->bindValue(':weights', (string)$weights, PDO::PARAM_STR);
		$stmt->bindValue(':language', $language, PDO::PARAM_STR);
		$stmt->bindValue(':nationality', $nationality, PDO::PARAM_STR);
		$stmt->bindValue(':occupation', $occupation, PDO::PARAM_STR);
		
		$imgname = $_FILES['file']['name'];
		$imgs = $_FILES['file']['size'];
		$imgtname = $_FILES['file']['tmp_name'];
		
		if(empty($imgname)){
		   $err = "Please Select Image File.";
		   echo "<script>alert('".$err."');</script>";
		}
		else if($imgs > 2000000 || pathinfo($imgname,PATHINFO_EXTENSION) <> 'jpg'){
		   //echo pathinfo($imgname,PATHINFO_EXTENSION);exit;
		   $err = "Please Select File less than 2 mb of JPG file only";
		   echo "<script>alert('".$err."');</script>";
		   
		}
		else
		{
			if ($stmt->execute() == false) {
				echo "WARNING: error inserting new item<br>";
			}
			$last_id = $db->lastInsertId();
			move_uploaded_file($imgtname,"pics/".$last_id.".jpg");
		}
		
		
	} else if ($operation == "delete") {
		$member_id = filter_input(INPUT_POST, 'member_id', FILTER_VALIDATE_INT);
		
		$sql = "delete from members where member_id = :member_id";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
		
		if ($stmt->execute() == false) {
			echo "WARNING: error deleting item<br>";
		}
		
	} else if ($operation == "update_form") {
		$member_id = filter_input(INPUT_POST, 'member_id', FILTER_VALIDATE_INT);		
	
		$sql = "select * 
		        from members 
				where member_id = :member_id";
		$stmt = $db->prepare($sql);
		$stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
		
		if ($stmt->execute() == false) {
			echo "WARNING: error deleting item<br>";
		} else {
			
			if ($stmt->rowCount() === 1) {
				$record = $stmt->fetch();
				
				$member_id = $record['member_id'];
				$firstname = $record['firstname'];
				$lastname = $record['lastname'];
				$date_of_birth = $record['date_of_birth'];
				//$year = $record['year'];
				$heights = $record['heights'];		
				$weights = $record['weights'];
				$language = $record['language'];
				$nationality = $record['nationality'];
				$occupation = $record['occupation'];
			} else {
				# cancels the update
				$operation = "";
			}
			
			$stmt->closeCursor();
		}
		
	} else if ($operation == "update_database") {
		
		$member_id = filter_input(INPUT_POST, 'member_id', FILTER_VALIDATE_INT);		
		$firstname = filter_input(INPUT_POST, 'firstname');
		$lastname = filter_input(INPUT_POST, 'lastname');
		$date_of_birth = filter_input(INPUT_POST, 'date_of_birth');
		//$year = filter_input(INPUT_POST, 'year',FILTER_VALIDATE_INT);
		$heights = filter_input(INPUT_POST, 'heights',FILTER_VALIDATE_FLOAT);		
		$weights = filter_input(INPUT_POST, 'weights',FILTER_VALIDATE_FLOAT);
		$language = filter_input(INPUT_POST, 'language');
		$nationality = filter_input(INPUT_POST, 'nationality');
		$occupation = filter_input(INPUT_POST, 'occupation');
		
		$sql = "update members 
		        set firstname = :firstname,
				    lastname = :lastname,
					date_of_birth = :date_of_birth,
					year = YEAR(:date_of_birth),
					heights = :heights,					
					weights = :weights,
                    language = :language,
					nationality = :nationality,
					occupation = :occupation
					
				where member_id = :member_id";
		
		$stmt = $db->prepare($sql);
		
		$stmt->bindValue(':member_id', $member_id, PDO::PARAM_INT);
		$stmt->bindValue(':firstname', $firstname, PDO::PARAM_STR);
		$stmt->bindValue(':lastname', $lastname, PDO::PARAM_STR);
		$stmt->bindValue(':date_of_birth', $date_of_birth, PDO::PARAM_STR);
		//$stmt->bindValue(':year', $year, PDO::PARAM_STR);
		$stmt->bindValue(':heights', (string)$heights, PDO::PARAM_STR);
		$stmt->bindValue(':weights', (string)$weights, PDO::PARAM_STR);
		$stmt->bindValue(':language', $language, PDO::PARAM_STR);
		$stmt->bindValue(':nationality', $nationality, PDO::PARAM_STR);
		$stmt->bindValue(':occupation', $occupation, PDO::PARAM_STR);
		
		
		
		//-------
		$imgname = $_FILES['file']['name'];
		$imgs = $_FILES['file']['size'];
		$imgtname = $_FILES['file']['tmp_name'];
		
		if(empty($imgname)){
		   //$err = "Please Select Image File.";
		   //echo "<script>alert('".$err."');</alert></script>";
		}
		else if($imgs > 2000000 || pathinfo($imgname,PATHINFO_EXTENSION) <> 'jpg'){
		   //echo pathinfo($imgname,PATHINFO_EXTENSION);exit;
		   $err = "Please Select File less than 2 mb of JPG file only";
		   echo "<script>alert('".$err."');</script>";
		   
		}
		else
		{
			
			
			move_uploaded_file($imgtname,"pics/".$member_id.".jpg");
		}
		if ($stmt->execute() == false) {
			echo "WARNING: error updating item<br>";
		}
		//--------
		
		
	}

	# Data for the TABLE that showing all the Books
	$sortOrder = filter_input(INPUT_GET, 'sort_order');
	if (empty($sortOrder)) {
		$sortOrder = filter_input(INPUT_POST, 'sort_order');
	}
	
	$sql = "select * from members ";
	
	if ($sortOrder === 'firstname') {
		$sql .= "order by firstname";
	} else if ($sortOrder === 'lastname') {
		$sql .= "order by lastname";
	} else if ($sortOrder === 'date_of_birth') {
		$sql .= "order by date_of_birth";
	} else if ($sortOrder === 'year') {
		$sql .= "order by year";
	} else if ($sortOrder === 'weights') {
		$sql .= "order by weights";
	} else if ($sortOrder === 'heights') {
		$sql .= "order by heights";
	} else if ($sortOrder === 'language') {
		$sql .= "order by language";
	} else if ($sortOrder === 'nationality') {
		$sql .= "order by nationality";
	} else if ($sortOrder === 'occupation') {
		$sql .= "order by occupation";
	} else {
		$sql .= "order by member_id";
	}
	
	$stmt = $db->prepare($sql);
	$stmt->execute();
	
	$results = $stmt->fetchAll();
	$stmt->closeCursor();
	
	?>
	<div id="items" class='clearall'>
		<h3>Member List</h3>
		<table>
			<tr>
				<th><a href="?sort_order=firstname">First Name</a></th>
				<th><a href="?sort_order=lastname">Last Name</a></th>
				<th><a href="?sort_order=date_of_birth">Date of Birth</a></th>
				<th><a href="?sort_order=year">Year</a></th>
				<th><a href="?sort_order=heights">Heights</a></th>
				<th><a href="?sort_order=weights">Weights</a></th>
				<th><a href="?sort_order=language">Language</a></th>
				<th><a href="?sort_order=nationality">Nationality</a></th>
				<th><a href="?sort_order=occupation">Occupation</a></th>
				
			</tr>
			<?php
				foreach ($results as $row) {
					echo "<tr>";
					echo "<td>", htmlspecialchars($row['firstname']), "</td>\n";
					echo "<td>", htmlspecialchars($row['lastname']), "</td>\n";
					echo "<td>", htmlspecialchars($row['date_of_birth']), "</td>\n";
					echo "<td>", htmlspecialchars($row['year']), "</td>\n";
					echo "<td>", htmlspecialchars($row['heights']), "</td>\n";
					echo "<td>", htmlspecialchars($row['weights']), "</td>\n";
					echo "<td>", htmlspecialchars($row['language']), "</td>\n";
					echo "<td>", htmlspecialchars($row['nationality']), "</td>\n";
					echo "<td>", htmlspecialchars($row['occupation']), "</td>\n";
					
					?>
					<td>
						<form method="post" 
							  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" 
						      class="tableForm">
							<input type="hidden" name="sort_order" 
								   value="<?php echo htmlspecialchars($sortOrder); ?>" >
							<input type="hidden" name="operation" 
								   value="delete" >
							<input type="hidden" name="member_id" 
								   value="<?php echo $row['member_id']; ?>" >
							<input type="submit" 
								   value="Delete">
						</form>
					</td>
					<td>
						<form method="post"
							  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" 
						      class="tableForm">
							<input type="hidden" name="sort_order" 
								   value="<?php echo htmlspecialchars($sortOrder); ?>" >
							<input type="hidden" name="operation" 
								   value="update_form" >
							<input type="hidden" name="member_id" 
								   value="<?php echo $row['member_id']; ?>" >
							<input type="submit" 
								   value="Update">
						</form>
					</td>
					<?php
					echo "</tr>";
				}
			?>
		</table>
		
	</div>
	
	
	<div id="formArea">
		<h3>
			<?php if ($operation == "update_form") { ?>
				Update
			<?php } else { ?>
				Add
			<?php } ?>
			Member
		</h3>
		
		<form method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<?php if ($operation == "update_form") { ?>
				<input type="hidden" name="operation" value="update_database">
			<?php } else { ?>
				<input type="hidden" name="operation" value="insert">
			<?php } ?>
			
			<input type="hidden" name="sort_order" 
			       value="<?php echo htmlspecialchars($sortOrder); ?>">
			
			<?php if ($operation == "update_form") : ?>
				<input type="hidden" name="member_id" 
				       value="<?php echo $member_id; ?>">
			<?php endif ?>
			<label>First Name:</label>
			<input type="text" id="firstname" name="firstname" 
					<?php if ($operation == "update_form") : ?>
						value="<?php echo htmlspecialchars($firstname); ?>" 
					<?php endif ?>
					required="required">
			<br>
			<label>Last Name:</label>
			<input type="text" id="lastname" name="lastname" 
					<?php if ($operation == "update_form") : ?>
						value="<?php echo htmlspecialchars($lastname); ?>" 
					<?php endif ?>
					required="required">
			<br>
			<label>Date of Birth:</label>
			<input type="date" id="date_of_birth" name="date_of_birth" 
					<?php if ($operation == "update_form") : ?>
						value="<?php echo htmlspecialchars($date_of_birth); ?>" 
					<?php endif ?>
					required="required">		
			<br>
			<label>Picture:</label>
			<?php if ($operation == "update_form") : ?>
						<img src="pics/<?php echo $member_id.'.jpg';?>" class='picture'/>
					<?php endif ?>	
			<input type="file" id="picture" name="file" accept="image/jpg">
					<?php /*if ($operation == "update_form") : ?>
						value="<?php echo htmlspecialchars($file); ?>" 
					<?php endif */?>
					 
									
			<br>
			<label>Heights (in ft):</label>
			<input type="number" id="heights" name="heights" step="0.01"
					<?php if ($operation == "update_form") : ?>
						value="<?php echo htmlspecialchars($heights); ?>" 
					<?php endif ?>
					required="required">
			<br>
			<label>Weights (in lbs): </label>
			<input type="number" id="weights" name="weights" step="0.01"
					<?php if ($operation == "update_form") : ?>
						value="<?php echo htmlspecialchars($weights); ?>" 
					<?php endif ?>
					required="required">
			<br>
			<label>Language:</label>
			<input type="text" id="language" name="language" 
					<?php if ($operation == "update_form") : ?>
						value="<?php echo htmlspecialchars($language); ?>" 
					<?php endif ?>
					required="required">
			<br>
			<label>Nationality:</label>
			<input type="text" id="nationality" name="nationality" 
					<?php if ($operation == "update_form") : ?>
						value="<?php echo htmlspecialchars($nationality); ?>" 
					<?php endif ?>
					required="required">
			<br>
			<label>Occupation:</label>
			<input type="text" id="occupation" name="occupation" 
					<?php if ($operation == "update_form") : ?>
						value="<?php echo htmlspecialchars($occupation); ?>" 
					<?php endif ?>
					required="required">
			<br>
			

			
			<?php if ($operation == "update_form") { ?>
				<input type="submit" value="Update item">
			<?php } else { ?>
				<input type="submit" value="Insert">
			<?php } ?>
			
			<input type="reset">
			
			<?php if ($operation == "update_form"): ?>
				<input type="button" value="Cancel update"
						onclick="location.href='?sort_order=<?php echo $sortOrder; ?>'">
			<?php endif ?>
			
		</form>
	</div>

</body>
</html>