<?php
if($_POST['ajax_call'] == 1) {
	session_start();
	
	if(isset($_SESSION['search_star_timer'])) {
		if( time() < $_SESSION['search_star_timer'] + 3) {
		
			die();
		}
	}
	
	
	$_SESSION['search_star_timer'] = time();
	require_once('../functions/database_connect.php');
	
	
	$stmt = $pdo->prepare (
	"SELECT 
	roommate_adpref_issaved
	FROM roommate_adprefs
	WHERE roommate_adpref_userid = :roommate_adpref_userid AND
	roommate_adpref_adid = :roommate_adpref_adid;");
	
	$stmt->execute(
	['roommate_adpref_userid' => $_SESSION['roommate_user_id'],
	'roommate_adpref_adid' =>$_POST['ad_id']]
	); 
	$data = $stmt->fetchAll();
	$issaved = false;
	foreach ($data as $row) {
			$issaved = true;
	}
		
	
	if($issaved) {
		$stmt_del = $pdo->prepare ( "DELETE FROM roommate_adprefs WHERE
		roommate_adpref_userid = :roommate_adpref_userid AND
		roommate_adpref_adid = :roommate_adpref_adid");
		$stmt_del->execute(['roommate_adpref_userid' => $_SESSION['roommate_user_id'],
	'roommate_adpref_adid' =>$_POST['ad_id']]);
		$result['isSaved'] = false;
			echo json_encode($result);
	}else{
		
	
		$data = [
		'roommate_adpref_userid' =>  $_SESSION['roommate_user_id'],
		'roommate_adpref_adid' => $_POST['ad_id'],
		'roommate_adpref_issaved' => 1
		];
		
		$sql = "INSERT INTO 
		roommate_adprefs
		(
		roommate_adpref_userid, 
		roommate_adpref_adid, 
		roommate_adpref_issaved)
		VALUES 
		(
		:roommate_adpref_userid,
		:roommate_adpref_adid,
		:roommate_adpref_issaved)";
		$stmt= $pdo->prepare($sql);
		if($stmt->execute ($data)) {
			$result['isSaved'] = true;
			echo json_encode($result);
		}
		
	}
}
?>