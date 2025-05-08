<?php
require_once 'dbConfig.php';
require_once 'models.php';

if (isset($_POST['insertNewUserBtn'])) {
	$username = trim($_POST['username']);
	$first_name = trim($_POST['first_name']);
	$last_name = trim($_POST['last_name']);
	$password = trim($_POST['password']);

	if (!empty($username) && !empty($first_name) && !empty($last_name) && !empty($password)) {

		$insertQuery = insertNewUser($pdo, $username, $first_name, $last_name, password_hash($password, PASSWORD_DEFAULT));
		$_SESSION['message'] = $insertQuery['message'];

		if ($insertQuery['status'] == '200') {
			$_SESSION['message'] = $insertQuery['message'];
			$_SESSION['status'] = $insertQuery['status'];
			header("Location: ../login.php");
		} else {
			$_SESSION['message'] = $insertQuery['message'];
			$_SESSION['status'] = $insertQuery['status'];
			header("Location: ../register.php");
		}

	} else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
		header("Location: ../register.php");
	}
}

if (isset($_POST['action']) && $_POST['action'] === 'submitReview') {
	$email = trim($_POST['email']);
	$gender = trim($_POST['gender']);
	$game = trim($_POST['game']);
	$user_review = trim($_POST['user_review']);
	$rating = trim($_POST['rating']);

	if (!empty($email) && !empty($gender) && !empty($game) && !empty($user_review) && !empty($rating)) {
			$data = [
					'email' => $email,
					'gender' => $gender,
					'game' => $game,
					'user_review' => $user_review,
					'rating' => $rating
			];

			$result = insertReview($data, $pdo);

			if ($result) {
					echo json_encode(['status' => 'success', 'message' => 'Review added successfully!']);
			} else {
					echo json_encode(['status' => 'error', 'message' => 'Error adding review!']);
			}
	} else {
			echo json_encode(['status' => 'error', 'message' => 'All fields are required!']);
	}
	exit();
}

if (isset($_POST['action']) && $_POST['action'] === 'delete') {
	$reviewId = $_POST['review_id'];
	$username = $_SESSION['username'];

	if (!$username) {
		echo 'error';
		exit;
	}
	$result = deleteReview($reviewId, $username, $pdo);
	echo $result ? 'success' : 'error';
	exit;
}

if (isset($_POST['action']) && $_POST['action'] === 'update') {
	$data = [
		'id' => $_POST['id'],
		'email' => trim($_POST['email']),
		'gender' => trim($_POST['gender']),
		'game' => trim($_POST['game']),
		'user_review' => trim($_POST['user_review']),
		'rating' => trim($_POST['rating'])
	];

	$userId = $_SESSION['username'];

	if ($userId && !empty($data['id'])) {
		$result = updateReview($data, $userId, $pdo);
		echo $result ? 'success' : 'error';
	} else {
		echo 'error';
	}
	exit;
}


if (isset($_POST['loginUserBtn'])) {
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	if (!empty($username) && !empty($password)) {

		$loginQuery = checkIfUserExists($pdo, $username);
		$userIDFromDB = $loginQuery['userInfoArray']['user_id'];
		$usernameFromDB = $loginQuery['userInfoArray']['username'];
		$passwordFromDB = $loginQuery['userInfoArray']['password'];

		if (password_verify($password, $passwordFromDB)) {
			$_SESSION['user_id'] = $userIDFromDB;
			$_SESSION['username'] = $usernameFromDB;
			header("Location: ../index.php");
		}

		else {
			$_SESSION['message'] = "Username/password invalid";
			$_SESSION['status'] = "400";
			header("Location: ../login.php");
		}
	}

	else {
		$_SESSION['message'] = "Please make sure there are no empty input fields";
		$_SESSION['status'] = '400';
		header("Location: ../register.php");
	}

}

if (isset($_POST['logoutUserBtn'])) {
	unset($_SESSION['user_id']);
	unset($_SESSION['username']);
	header("Location: ../login.php");
	exit();
}
?>