<?php  
require_once 'dbConfig.php';
require_once 'models.php';

if (isset($_POST['searchAUser'])) {
	$keyword = $_POST['keyword'];
	$searchAUser = searchAUser($pdo, $keyword);
	foreach ($searchAUser as $row) {
		echo "<div class='postContainer' 
				style='padding: 25px; 
					   margin-top: 25px; 
					   border:1px solid black;'>
				<h1>". $row['last_name'] . ", " . $row['first_name'] . "</h1>
				<h4>" . $row['gender'] . "</h4>
				<h3>" . $row['email'] . "</h3>
			  </div>";
	}
}

if (isset($_POST['insertNewUser'])) {
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];
	$gender = $_POST['gender'];
	insertAUser($pdo, $first_name, $last_name, $email, $gender);
}

?>