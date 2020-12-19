<?php
if($_POST['ajax_call'] == 1) {
	session_start();

	require_once('../functions/database_connect.php');
	$params = json_decode($_POST['sendFormData'],true);
	foreach($params as $name) {
		$_POST[$name['name']] = $name['value'];
	}
	
	if(!isset($_SESSION['roommate_user_id']) || empty($_SESSION['roommate_user_id'])){
		
		die();
	}

	
	$stmt = $pdo->prepare("SELECT 
	roommate_user_id,
	roommate_user_name,
	roommate_user_email
	FROM roommate_users
	WHERE 
	roommate_user_id =:roommate_user_id");
	
	
	$stmt->execute(['roommate_user_id' => $_SESSION['roommate_user_id']]); 
	$data = $stmt->fetchAll();
	
	
	$user_exists = false;
	foreach ($data as $row) {
		$user_exists = true;
		$roommate_user_id = $row["roommate_user_id"];
		$roommate_user_name = $row["roommate_user_name"];
		$roommate_user_email = $row["roommate_user_email"];
	}
	
	if($user_exists) {

		
		$msg = "From user " . $roommate_user_name . "\n";
		$msg .= "From EMail " . $roommate_user_email . "\n\n";
		
		$msg .= $_POST['email-msg']. "\n\n";
		
		$msg .= "View this ad here: " . "previewroommate.com/view-ad/?ad_id=".$_POST['rec_id'] . "\n\n";
		
		$subject = "Roommate " . $roommate_user_name . " has sent you a message";

		// send email
		mail($roommate_user_email,$subject,$msg);
		$result['isSent'] = true;
		echo json_encode($result);
		
	
	
		
	} else {
		$result['isSent'] = false;
		echo json_encode("There is no account with this email");
		die();
	}
	
} else if($_POST['ajax_call'] == 2) {
	session_start();

	require_once('../functions/database_connect.php');
	$params = json_decode($_POST['sendFormData'],true);
	foreach($params as $name) {
		$_POST[$name['name']] = $name['value'];
	}
	
	if(!isset($_SESSION['roommate_user_id']) || empty($_SESSION['roommate_user_id'])){
		
		die();
	}
	
	$stmt = $pdo->prepare("SELECT 
	roommate_user_id,
	roommate_user_name,
	roommate_user_email
	FROM roommate_users
	WHERE 
	roommate_user_id =:roommate_user_id");
	
	
	$stmt->execute(['roommate_user_id' => $_SESSION['roommate_user_id']]); 
	$data = $stmt->fetchAll();
	
	
	$user_exists = false;
	foreach ($data as $row) {
		$user_exists = true;
		$roommate_user_id = $row["roommate_user_id"];
		$roommate_user_name = $row["roommate_user_name"];
		$roommate_user_email = $row["roommate_user_email"];
	}

	
	$stmt = $pdo->prepare("SELECT 
	property_ID,
	property_StreetName,
	property_StreetNum,
	property_City,
	property_PhotosObtainedBy
	FROM ap_property
	WHERE property_ID = :property_ID");
	
	
	$stmt->execute(['property_ID' => $_POST['rec_id']]); 
	$data = $stmt->fetchAll();
	
	

	foreach ($data as $row) {
		$property_StreetName = $row["property_StreetName"];
		$property_StreetNum = $row["property_StreetNum"];
		$property_City = $row["property_City"];
		$property_ID = $row["property_ID"];
		$property_PhotosObtainedBy = $row["property_PhotosObtainedBy"];
	}
	
	 $property_address =  $property_StreetNum . " " .  $property_StreetName . " " .  $property_City;
	$user_Email = "";
	if(!empty($property_PhotosObtainedBy)) {
		$stmt = $pdo->prepare("SELECT 
		user_Email
		FROM ap_users
		WHERE
		user_Type = 0 AND user_Name != 'Fiona Russo' AND user_Name != 'Amber' AND user_Name=:user_Name");
		
		$stmt->execute(['user_Name' => $property_PhotosObtainedBy]); 
		$data = $stmt->fetchAll();

		foreach ($data as $row) {
			$user_Email = $row["user_Email"];
		}
	} else {
		$user_Email = "info-a@previewbostonrealty.com";
		
	}
	$user_Email .= ",info-a@previewbostonrealty.com,shaunt.keshishian@gmail.com";
	
	if($user_exists) {

	
		
		$msg = "From User: " . $roommate_user_name . "\n";
		$msg .= "From EMail: " . $roommate_user_email . "\n\n";
		
		$msg .= $_POST['email-msg']. "\n\n";
		
		$msg .= "Requested property here: " . "previewroommate.com/view-property/?property_id=".$property_ID . "\n\n";
		
		$subject = "Property: " . $property_address . " Request";

		// send email
		mail($user_Email,$subject,$msg);
		$result['isSent'] = true;
		
		echo json_encode($result);

	} else {
		$result['isSent'] = false;
		echo json_encode("There is no account with this email");
		die();
	}
}
?>