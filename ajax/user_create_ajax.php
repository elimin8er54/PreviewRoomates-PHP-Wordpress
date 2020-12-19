<?php
if($_POST['ajax_call'] == 1) {
	session_start();
	$params = json_decode($_POST['sendFormData'],true);
	require_once('../functions/database_connect.php');
	$result['isCreated'] = false;
	foreach($params as $name) {
		$_POST[$name['name']] = $name['value'];
	}
	
	if(empty($_POST['user_name'])) {
	$result['name'] = 'user_name';
	$result['info'] = 'Please enter a username';	
	}
	else if(empty($_POST['user_email'])) {
		$result['name'] = 'user_email';
		$result['info'] = 'Please enter your email address';
	}
	
	else	if(empty($_POST['user_password'])) {
			$result['name'] = 'user_password';
			$result['info'] = 'Please enter a password';	
		}
	
	
	else if(empty($_POST['user_password_again'])) {
			$result['name'] = 'user_password_again';
			$result['info'] = 'Please retype your password';	
	}
	
	else if(empty($_POST['user_gender'])) {
		$result['name'] = 'user_gender';
		$result['info'] = 'Please select a gender';	
		
	}
	else if(!empty($_POST['user_password']) && !empty($_POST['user_password_again'])) {
		if($_POST['user_password'] != $_POST['user_password_again']) {
			$result['name'] = 'user_password';
			$result['info'] = 'Please make sure your passwords match';	
			
		}
	}
	else if(!empty($_POST['user_password'])) {
		if(strlen($_POST['user_password']) < 6) {
			$result['name'] = 'user_password';
			$result['info'] = 'Please make sure your password is at least 6 characters';	

		}
	}
	
	if(isset($result['name'])) {
		echo json_encode($result);
		die();
	}
	
	
	

	$stmt = $pdo->prepare (
	"SELECT 
	roommate_user_id
	FROM roommate_users
	WHERE roommate_user_email = :roommate_user_email;");
	
	$stmt->execute(['roommate_user_email' => $_POST['user_email']]); 
	$data = $stmt->fetchAll();
	$email_exists = false;
	foreach ($data as $row) {
			$email_exists = true;
	}
		
	
	if($email_exists) {
		$result['name'] = 'user_password';
		$result['info'] = 'There is already an account with this email';	
	}
	
	
	if(isset($result['name'])) {
		echo json_encode($result);
		die();
	}
	
	
	
	
	if($_POST['user_gender'] != "O") {
		$_POST['user_genderother']= "";
	}
	
	$data = [
    'roommate_user_name' => $_POST['user_name'],
    'roommate_user_email' => $_POST['user_email'],
    'roommate_user_password' => md5($_POST['user_password']),
	'roommate_user_gender' => $_POST['user_gender'],
	'roommate_user_genderother' => $_POST['user_genderother'],
	];
	
	$sql = "INSERT INTO 
	roommate_users
	(
	roommate_user_name, 
	roommate_user_email, 
	roommate_user_password, 
	roommate_user_gender, 
	roommate_user_genderother)
	VALUES 
	(
	:roommate_user_name,
	:roommate_user_email,
	:roommate_user_password,
	:roommate_user_gender,
	:roommate_user_genderother)";
	$stmt= $pdo->prepare($sql);
	if($stmt->execute ($data)) {
		$result['isCreated'] = true;
		echo json_encode($result);
	}
	
	
}

?>