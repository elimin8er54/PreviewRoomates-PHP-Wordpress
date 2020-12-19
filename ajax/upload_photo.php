<?php
if($_POST['ajax_call'] == 1) {
	session_start();
	if(isset($_SESSION['search_star_timer_room'])) {
		if( time() < $_SESSION['search_star_timer_room'] + 3) {
		
			die();
		}
	}
	
	
	$_SESSION['search_star_timer_room'] = time();
	require_once('../functions/database_connect.php');
	
	
	$stmt = $pdo->prepare (
	"SELECT 
	roommate_proppref_issaved
	FROM roommate_propprefs
	WHERE roommate_proppref_userid = :roommate_proppref_userid AND
	roommate_proppref_propertyid = :roommate_proppref_propertyid;");
	
	$stmt->execute(['roommate_proppref_userid' => $_SESSION['roommate_user_id'],
	'roommate_proppref_propertyid' =>$_POST['property_id']]
	); 
	$data = $stmt->fetchAll();
	$issaved = false;
	foreach ($data as $row) {
			$issaved = true;
	}
		
	
	if($issaved) {
		$stmt_del = $pdo->prepare ( "DELETE FROM roommate_propprefs WHERE
		roommate_proppref_userid = :roommate_proppref_userid AND
		roommate_proppref_propertyid = :roommate_proppref_propertyid");
		$stmt_del->execute(['roommate_proppref_userid' => $_SESSION['roommate_user_id'],
	'roommate_proppref_propertyid' =>$_POST['property_id']]);
		$result['isSaved'] = false;
			echo json_encode($result);
	}else{
		
	
		$data = [
		'roommate_proppref_userid' =>  $_SESSION['roommate_user_id'],
		'roommate_proppref_propertyid' => $_POST['property_id'],
		'roommate_proppref_issaved' => 1
		];
		
		$sql = "INSERT INTO 
		roommate_propprefs
		(
		roommate_proppref_userid, 
		roommate_proppref_propertyid, 
		roommate_proppref_issaved)
		VALUES 
		(
		:roommate_proppref_userid,
		:roommate_proppref_propertyid,
		:roommate_proppref_issaved)";
		$stmt= $pdo->prepare($sql);
		if($stmt->execute ($data)) {
			$result['isSaved'] = true;
			echo json_encode($result);
		}
		
	}
}
?>