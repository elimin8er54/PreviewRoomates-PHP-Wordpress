<?php
if($_POST['ajax_call'] == 1) {
	session_start();

	require_once('../functions/database_connect.php');

	
	if(empty($_POST['user_email'])){
		echo json_encode("Please enter a username");
		die();
	}
	if(empty($_POST['user_password'])){
		echo json_encode("Please enter a password");
		die();
	}
	
	$stmt = $pdo->prepare("SELECT 
	roommate_user_id,
	roommate_user_name
	FROM roommate_users
	WHERE 
	roommate_user_email =:roommate_user_email AND
	roommate_user_password =:roommate_user_password");
	
	
	$stmt->execute(['roommate_user_email' => $_POST['user_email'], 'roommate_user_password' => md5($_POST['user_password'])]); 
	$data = $stmt->fetchAll();
	
	
	$user_exists = false;
	foreach ($data as $row) {
		$user_exists = true;
		$roommate_user_id = $row["roommate_user_id"];
		$roommate_user_name = $row["roommate_user_name"];
	}
	
	if($user_exists) {
		$_SESSION['roommate_user_id'] = $roommate_user_id;
		$_SESSION['roommate_user_name'] = $roommate_user_name;
		$result['isCorrect'] = true;
		echo json_encode($result);
		
	} else {
		echo json_encode("Your Email or Password is incorrect.");
		die();
	}
	
}
?>