<?php 
require_once 'dbConfig.php';

function getRecentUsers($pdo) {
	$sql = "SELECT 
				user_game_scores.*, 
				user_accounts.username AS created_by_username, 
				user_accounts.username AS updated_by_username
			FROM user_game_scores
			LEFT JOIN user_accounts ON user_game_scores.created_by = user_accounts.username
			LEFT JOIN user_accounts AS updater ON user_game_scores.updated_by = updater.username
			WHERE user_game_scores.deleted_at IS NULL
			ORDER BY user_game_scores.id DESC
			LIMIT 6";

	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}	

function getReviewsByUser($userId, $pdo) {
	$sql = "SELECT 
	            user_game_scores.*, 
	            user_accounts.username AS created_by_username,
	            updater_accounts.username AS updated_by_username
	        FROM user_game_scores
	        JOIN user_accounts ON user_game_scores.created_by = user_accounts.username
	        LEFT JOIN user_accounts AS updater_accounts ON user_game_scores.updated_by = updater_accounts.username
	        WHERE user_game_scores.created_by = :username
	          AND user_game_scores.deleted_at IS NULL
	        ORDER BY user_game_scores.created_at DESC";

	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':username', $userId, PDO::PARAM_STR);
	$stmt->execute();

	return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


//User Entity
function checkIfUserExists($pdo, $username) {
	$response = array();
	$sql = "SELECT * FROM user_accounts WHERE username = ?";
	$stmt = $pdo->prepare($sql);

	if ($stmt->execute([$username])) {

		$userInfoArray = $stmt->fetch();

		if ($stmt->rowCount() > 0) {
			$response = array(
				"result"=> true,
				"status" => "200",
				"userInfoArray" => $userInfoArray
			);
		}

		else {
			$response = array(
				"result"=> false,
				"status" => "400",
				"message"=> "User doesn't exist from the database"
			);
		}
	}

	return $response;
}

function insertNewUser($pdo, $username, $first_name, $last_name, $password) {
	$response = array();
	$checkIfUserExists = checkIfUserExists($pdo, $username); 

	if (!$checkIfUserExists['result']) {
		$sql = "INSERT INTO user_accounts (username, first_name, last_name, password) 
		VALUES (?,?,?,?)";

		$stmt = $pdo->prepare($sql);

		if ($stmt->execute([$username, $first_name, $last_name, $password])) {
			$response = array(
				"status" => "200",
				"message" => "User successfully inserted!"
			);
		}
		else {
			$response = array(
				"status" => "400",
				"message" => "An error occured with the query!"
			);
		}
	}
	else {
		$response = array(
			"status" => "400",
			"message" => "User already exists!"
		);
	}

	return $response;
}

//End of User Entity
function getAllUsers($pdo) {
	$sql = "SELECT * FROM user_accounts";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}
function getUserByID($pdo, $username) {
	$sql = "SELECT * FROM user_accounts WHERE username = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$username]);

	if ($executeQuery) {
		return $stmt->fetch();
	}
}

//CRUD
function insertReview($data, $pdo) {
	if (isset($_SESSION['username'])) {
			$username = $_SESSION['username'];
	} else {
			return false;
	}
	$sql = "INSERT INTO user_game_scores (username, email, gender, game, user_review, rating, created_by) 
					VALUES (?, ?, ?, ?, ?, ?, ?)";
	$stmt = $pdo->prepare($sql);
	$result = $stmt->execute([
			$username,
			$data['email'],
			$data['gender'],
			$data['game'],
			$data['user_review'],
			$data['rating'],
			$username
	]);
	return $result;
}

function updateReview($data, $userId, $pdo) {
	$sql = "UPDATE user_game_scores 
	        SET email = ?, gender = ?, game = ?, user_review = ?, rating = ?, updated_by = ?, updated_at = NOW()
	        WHERE id = ?";
	$stmt = $pdo->prepare($sql);
	return $stmt->execute([
		$data['email'],
		$data['gender'],
		$data['game'],
		$data['user_review'],
		$data['rating'],
		$userId,
		$data['id']
	]);
}

function deleteReview($id, $username, $pdo) {
  $sql = "DELETE FROM user_game_scores 
          WHERE id = ? AND created_by = ?";
  $stmt = $pdo->prepare($sql);
  $result = $stmt->execute([$id, $username]);

  return $result;
}
?>