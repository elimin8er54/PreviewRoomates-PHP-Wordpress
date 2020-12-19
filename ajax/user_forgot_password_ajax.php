<?php
if($_POST['ajax_call'] == 1) {
	session_start();

	require_once('../functions/database_connect.php');

	
	if(empty($_POST['user_email'])){
		echo json_encode("Please enter a username");
		die();
	}

	
	$stmt = $pdo->prepare("SELECT 
	roommate_user_id,
	roommate_user_name,
	roommate_user_email
	FROM roommate_users
	WHERE 
	roommate_user_email =:roommate_user_email");
	
	
	$stmt->execute(['roommate_user_email' => $_POST['user_email']]); 
	$data = $stmt->fetchAll();
	
	
	$user_exists = false;
	foreach ($data as $row) {
		$user_exists = true;
		$roommate_user_id = $row["roommate_user_id"];
		$roommate_user_name = $row["roommate_user_name"];
		$roommate_user_email = $row["roommate_user_email"];
	}
	
	if($user_exists) {
		$the_hash = substr(md5(rand()), 0, 7);;
		$data = [
    'roommate_user_reset' => $the_hash;
	];
	
	$sql = "INSERT INTO 
	roommate_users
	(
	roommate_user_reset)
	VALUES 
	(
	:roommate_user_reset)";
	$stmt= $pdo->prepare($sql);
	if($stmt->execute ($data)) {
		$result['isSent'] = true;
		echo json_encode($result);
	}
		

		// use wordwrap() if lines are longer than 70 characters
		$msg = "Hello ".$roommate_user_name."<br><br>".
		"You have requested a password reset please click the link to reset.<br>
		http://previewroommate.com/reset?id=".$the_hash."<br>
		If you did not request a password reset you may ignore this message";

		// send email
		mail($roommate_user_email,"Password Reset Preview Roommates",$msg);
		$result['isCorrect'] = true;
		echo json_encode($result);
		
	
	
		
	} else {
		$result['isSent'] = false;
		echo json_encode("There is no account with this email");
		die();
	}
	
}
?>