<?php
if($_POST['ajax_call'] == 1) {
	session_start();
	$params = json_decode($_POST['sendFormData'],true);
	require_once('../functions/database_connect.php');
	foreach($params as $name) {
		$_POST[$name['name']] = $name['value'];
	}
	$stmt = $pdo->prepare("SELECT 
	roommate_ad_id
	FROM roommate_ads
	INNER JOIN roommate_users ON roommate_user_id = roommate_ad_userid
	
	WHERE 
	roommate_user_id =:roommate_user_id
	
	LIMIT 1;");
	
	
	$stmt->execute(
	['roommate_user_id' => $_SESSION['roommate_user_id']]); 
	$data = $stmt->fetchAll();
	
	$hasAd = false;
	foreach ($data as $row) {
		$hasAd = true;
		$id2 = $row['roommate_ad_id'];
	}

	
	
	if(!isset($_SESSION['roommate_user_id'])) {
		$result['name'] = 'roommate_user_id';
	
	}
	if(!isset($_POST['ad_title'])) {
		$result['name'] = 'ad_title';
	
	} else if(strlen($_POST['ad_title']) >35){
		$result['name'] = 'ad_title';
	} 
	if(empty($_POST['combined_budget'])) {
	$result['name'] = 'combined_budget';
		
	}
	if(empty($_POST['min_age'])) {
		$result['name'] = 'min_age';
		
	}
	
	
	if($_POST['NumberOfMales'] == 0 &&$_POST['NumberOfFemales'] == 0 &&$_POST['NumberOfOthers'] == 0 ) {
		$result['name'] = 'NumberOfMales';
	
	}
	if(isset($result['name'])) {
		echo json_encode($result);
		die();
	}
	$pdo->beginTransaction();
    try
    {

	$data = [
    'roommate_ad_userid' => $_SESSION['roommate_user_id'],
    'roommate_ad_title' => $_POST['ad_title'],
    'roommate_ad_budget' => $_POST['combined_budget'],
	'roommate_ad_age' => $_POST['min_age'],
	'roommate_ad_occupation' => $_POST['share_type'],
	'roommate_ad_issmoker' =>$_POST['smoking_current'] == 'Y' ? 1 : 0,
	'roommate_ad_haspets' => $_POST['pets'] == 'Y' ? 1 : 0,
	
	'roommate_ad_phone' => $_POST['tel'],
	'roommate_ad_showphone' => isset($_POST['display_tel']) ? 1 : 0,
	'roommate_ad_description' => $_POST['ad_text'],
	'roommate_ad_showlastname' => isset($_POST['display_last_name']) ? 1 : 0,
	
	'roommate_ad_smokerok' => $_POST['smoking'] == 'Y' ? 1 : 0,
	'roommate_ad_petsok' =>  $_POST['pets_req'] == 'Y' ? 1 : 0,

	'roommate_ad_minagepref' => $_POST['min_age_req'],
	'roommate_ad_maxagepref' => $_POST['max_age_req'],
	'roommate_ad_occupationpref' => $_POST['share_type_req'],
	'roommate_ad_moveinavailability' => date($_POST['year_avail']."-".$_POST['mon_avail']."-".$_POST['day_avail']),
	'roommate_ad_mintermpref' => $_POST['min_term'],
	'roommate_ad_maxtermpref' => $_POST['max_term'],
	'roommate_ad_roomsizepref' => $_POST['RoomReq'],
	'roommate_ad_createdate' =>  date('Y-m-d H:i:s'),
	'roommate_ad_isdeleted' => 0,
	
	'roommate_ad_isbuddyup' =>isset($_POST['interested_meeting_other_seekers']) ? 1 : 0
	];
	
		if($hasAd) {
			$data['roommate_ad_id'] = $id2;
			
			$sql = "UPDATE 
					roommate_ads
					SET 
		
					roommate_ad_userid = :roommate_ad_userid, 
					roommate_ad_title = :roommate_ad_title, 
					roommate_ad_budget = :roommate_ad_budget, 
					roommate_ad_age = :roommate_ad_age, 
					roommate_ad_occupation = :roommate_ad_occupation, 
					roommate_ad_issmoker = :roommate_ad_issmoker, 
					roommate_ad_haspets = :roommate_ad_haspets, 

					roommate_ad_phone = :roommate_ad_phone, 
					roommate_ad_showphone = :roommate_ad_showphone, 
					roommate_ad_description = :roommate_ad_description, 
					roommate_ad_showlastname = :roommate_ad_showlastname,

					roommate_ad_smokerok = :roommate_ad_smokerok, 
					roommate_ad_petsok = :roommate_ad_petsok, 

					roommate_ad_minagepref = :roommate_ad_minagepref, 
					roommate_ad_maxagepref = :roommate_ad_maxagepref,
					roommate_ad_occupationpref = :roommate_ad_occupationpref,
					roommate_ad_moveinavailability = :roommate_ad_moveinavailability,
					roommate_ad_mintermpref = :roommate_ad_mintermpref,
					roommate_ad_maxtermpref = :roommate_ad_maxtermpref, 
					roommate_ad_roomsizepref = :roommate_ad_roomsizepref, 
					roommate_ad_createdate = :roommate_ad_createdate, 
					roommate_ad_isdeleted = :roommate_ad_isdeleted, 

					roommate_ad_isbuddyup = :roommate_ad_isbuddyup
					WHERE roommate_ad_id = :roommate_ad_id
					";
					$stmt= $pdo->prepare($sql);
					if($stmt->execute ($data)) {

					}
	
	
	
	
	
	  
	 $data = [
		'roommate_ads_roommate_adid' => $id2
	];
	 
	 $sql = "DELETE FROM roommate_amenities WHERE roommate_ads_roommate_adid=:roommate_ads_roommate_adid";
	 
	 $stmt= $pdo->prepare($sql);
			if($stmt->execute ($data)) {

			}
	 
	foreach($params as $name) {
		
	if($name['name'] == "amenities[]") {
	
	$data = [
		'roommate_ads_roommate_adid' => $id2,
		'roommate_amenity_content' => $name['value']
	];
	
	$sql = "INSERT INTO 
		roommate_amenities
		(
		roommate_ads_roommate_adid, 
		roommate_amenity_content)
		VALUES 
		(
		:roommate_ads_roommate_adid, 
		:roommate_amenity_content
		)";
	$stmt= $pdo->prepare($sql);
	if($stmt->execute ($data)) {
		
	}
	}
	}
	
	 $data = [
		'roommate_ads_roommate_adid' => $id2
	];
	 $sql = "DELETE FROM roommate_adpeople WHERE roommate_adpeople_adid=:roommate_adpeople_adid";
	 $stmt= $pdo->prepare($sql);
			if($stmt->execute ($data)) {

			}
	
	$data = [
		'roommate_adpeople_adid' => $id2,
		'roommate_adpeople_amount' => $_POST['NumberOfMales'],
		'roommate_adpeople_gender' => "male"
	];
	$data2 = [
		'roommate_adpeople_adid' => $id2,
		'roommate_adpeople_amount' => $_POST['NumberOfFemales'],
		'roommate_adpeople_gender' => "female"
	];
	$data3 = [
		'roommate_adpeople_adid' => $id2,
		'roommate_adpeople_amount' => $_POST['NumberOfOthers'],
		'roommate_adpeople_gender' => "other"
	];
	
	$sql = "INSERT INTO 
		roommate_adpeople
		(
		roommate_adpeople_adid,
		roommate_adpeople_amount, 
		roommate_adpeople_gender)
		VALUES 
		(
		:roommate_adpeople_adid,
		:roommate_adpeople_amount, 
		:roommate_adpeople_gender
		)";
	$stmt= $pdo->prepare($sql);
	if($stmt->execute ($data)) {}
	if($stmt->execute ($data2)) {}
	if($stmt->execute ($data3)) {}
			
	 $data = [
		'roommate_interest_adid' => $id2
	];
	 $sql = "DELETE FROM roommate_interests WHERE roommate_interest_adid=:roommate_interest_adid";
	 $stmt= $pdo->prepare($sql);
	if($stmt->execute ($data)) {

	}
	
	$interests = explode("\n", str_replace("\r", "", $_POST['interests']));
	
	foreach($interests as $value){
		if(!empty($value)) {
			$data = [
				'roommate_interest_adid' => $id2,
				'roommate_interest_content' => $value
			];
			
			
			$sql = "INSERT INTO 
				roommate_interests
				(
				roommate_interest_adid,
				roommate_interest_content)
				VALUES 
				(
				:roommate_interest_adid,
				:roommate_interest_content
				)";
			$stmt= $pdo->prepare($sql);
			if($stmt->execute ($data)) {}

		}
	}
			
	$data = [
		'roommate_citypref_adid' => $id2
	];
	 $sql = "DELETE FROM roommate_citypref WHERE roommate_citypref_adid=:roommate_citypref_adid";
	 $stmt= $pdo->prepare($sql);
	if($stmt->execute ($data)) {

	}
	
	if(isset( $_POST['cityboxa']) ||isset( $_POST['cityboxa']) ) {
	
	$data = [
			'roommate_citypref_adid' => $id2,
			'roommate_citypref_city' => $_POST['cityboxa']
		];
	$data2 = [
			'roommate_citypref_adid' => $id2,
			'roommate_citypref_city' => $_POST['cityboxb']
		];
		
		$sql = "INSERT INTO 
			roommate_cityprefs
			(
			roommate_citypref_adid,
			roommate_citypref_city)
			VALUES 
			(
			:roommate_citypref_adid,
			:roommate_citypref_city
			)";
		$stmt= $pdo->prepare($sql);
		if($stmt->execute ($data)) {}
		if($stmt->execute ($data2)) {}
	}
	
	 $pdo->commit();
	 $result['isCreated'] = true;
	 $result['aid'] = $id2;
		echo json_encode($result);
		} else {
			
		
		$sql = "INSERT INTO 
		roommate_ads
		(
	roommate_ad_userid, 
	roommate_ad_title, 
	roommate_ad_budget, 
	roommate_ad_age, 
	roommate_ad_occupation, 
	roommate_ad_issmoker, 
	roommate_ad_haspets, 
	
	roommate_ad_phone, 
	roommate_ad_showphone, 
	roommate_ad_description, 
	roommate_ad_showlastname,
	
	roommate_ad_smokerok, 
	roommate_ad_petsok, 
	
	roommate_ad_minagepref, 
	roommate_ad_maxagepref,
	roommate_ad_occupationpref,
	roommate_ad_moveinavailability,
	roommate_ad_mintermpref,
	roommate_ad_maxtermpref, 
	roommate_ad_roomsizepref, 
	roommate_ad_createdate, 
	roommate_ad_isdeleted, 

	roommate_ad_isbuddyup)
		VALUES 
		(
	:roommate_ad_userid, 
	:roommate_ad_title, 
	:roommate_ad_budget, 
	:roommate_ad_age, 
	:roommate_ad_occupation, 
	:roommate_ad_issmoker, 
	:roommate_ad_haspets, 

	:roommate_ad_phone, 
	:roommate_ad_showphone, 
	:roommate_ad_description, 
	:roommate_ad_showlastname,

	:roommate_ad_smokerok, 
	:roommate_ad_petsok, 

	:roommate_ad_minagepref, 
	:roommate_ad_maxagepref,
	:roommate_ad_occupationpref,
	:roommate_ad_moveinavailability,
	:roommate_ad_mintermpref,
	:roommate_ad_maxtermpref, 
	:roommate_ad_roomsizepref, 
	:roommate_ad_createdate, 
	:roommate_ad_isdeleted, 

	:roommate_ad_isbuddyup)";
	$stmt= $pdo->prepare($sql);
	if($stmt->execute ($data)) {
		
	}
	
	$id = $pdo->lastInsertId();
	
	
	
	foreach($params as $name) {
		
	if($name['name'] == "amenities[]") {
	
	$data = [
		'roommate_ads_roommate_adid' => $id,
		'roommate_amenity_content' => $name['value']
	];
	
	$sql = "INSERT INTO 
		roommate_amenities
		(
		roommate_ads_roommate_adid, 
		roommate_amenity_content)
		VALUES 
		(
		:roommate_ads_roommate_adid, 
		:roommate_amenity_content
		)";
	$stmt= $pdo->prepare($sql);
	if($stmt->execute ($data)) {
		
	}
	}
	}
	
	
		
	
	
	$data = [
		'roommate_adpeople_adid' => $id,
		'roommate_adpeople_amount' => $_POST['NumberOfMales'],
		'roommate_adpeople_gender' => "male"
	];
	$data2 = [
		'roommate_adpeople_adid' => $id,
		'roommate_adpeople_amount' => $_POST['NumberOfFemales'],
		'roommate_adpeople_gender' => "female"
	];
	$data3 = [
		'roommate_adpeople_adid' => $id,
		'roommate_adpeople_amount' => $_POST['NumberOfOthers'],
		'roommate_adpeople_gender' => "other"
	];
	
	$sql = "INSERT INTO 
		roommate_adpeople
		(
		roommate_adpeople_adid,
		roommate_adpeople_amount, 
		roommate_adpeople_gender)
		VALUES 
		(
		:roommate_adpeople_adid,
		:roommate_adpeople_amount, 
		:roommate_adpeople_gender
		)";
	$stmt= $pdo->prepare($sql);
	if($stmt->execute ($data)) {}
	if($stmt->execute ($data2)) {}
	if($stmt->execute ($data3)) {}
	
	$interests = explode("\n", str_replace("\r", "", $_POST['interests']));
	
	foreach($interests as $value){
		if(!empty($value)) {
			$data = [
				'roommate_interest_adid' => $id,
				'roommate_interest_content' => $value,
			];
			
			
			$sql = "INSERT INTO 
				roommate_interests
				(
				roommate_interest_adid,
				roommate_interest_content)
				VALUES 
				(
				:roommate_interest_adid,
				:roommate_interest_content
				)";
			$stmt= $pdo->prepare($sql);
			if($stmt->execute ($data)) {}

		}
	}
	
	if(isset( $_POST['cityboxa']) ||isset( $_POST['cityboxa']) ) {
	
	$data = [
			'roommate_citypref_adid' => $id,
			'roommate_citypref_city' => $_POST['cityboxa']
		];
	$data2 = [
			'roommate_citypref_adid' => $id,
			'roommate_citypref_city' => $_POST['cityboxb']
		];
		
		$sql = "INSERT INTO 
			roommate_cityprefs
			(
			roommate_citypref_adid,
			roommate_citypref_city)
			VALUES 
			(
			:roommate_citypref_adid,
			:roommate_citypref_city
			)";
		$stmt= $pdo->prepare($sql);
		if($stmt->execute ($data)) {}
		if($stmt->execute ($data2)) {}
	}
	
	 $pdo->commit();
	 $result['isCreated'] = true;
	 $result['aid'] = $id;
		echo json_encode($result);
		}
	} catch(Exception $e){
		  $pdo->rollBack();
	
	}
	
}
else if($_POST['ajax_call'] == 2) {
	session_start();
	
	

	
	require_once('../functions/database_connect.php');
		/* Getting file name */
	
		$path = $_FILES['file']['name'];
$ext = pathinfo($path, PATHINFO_EXTENSION);
$filename =  rand(1, 300)."_".time().".".$ext;

/* Location */
$location = "../assets/front/img/profiles/".$filename;
$uploadOk = 1;
$imageFileType = pathinfo($location,PATHINFO_EXTENSION);

/* Valid Extensions */
$valid_extensions = array("png","jpg","jpeg");
/* Check file extension */
if( !in_array(strtolower($imageFileType),$valid_extensions) ) {
   $uploadOk = 0;
}

if($uploadOk == 0){
   echo 0;
}else{
   /* Upload file */
   if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
	   
	   $stmt = $pdo->prepare("SELECT 
		roommate_user_profilepic
		FROM roommate_users
		WHERE 
		roommate_user_id =:roommate_user_id");
		
		
		$stmt->execute(['roommate_user_id' => $_SESSION['roommate_user_id']]); 
		$data = $stmt->fetchAll();
		
		foreach ($data as $row) {
			if(empty($row["roommate_user_profilepic"])){
				$roommate_user_profilepic = "";
			} else {
				$roommate_user_profilepic = $row["roommate_user_profilepic"];
			}
			
		}
   
	  $data = [
		'roommate_user_profilepic' => $filename,
		'roommate_user_id' => $_POST['user_ID']
	];
	  $sql = "UPDATE roommate_users 
	SET
	
	roommate_user_profilepic=:roommate_user_profilepic
	WHERE
	roommate_user_id = :roommate_user_id;";
	$stmt= $pdo->prepare($sql);
	if($stmt->execute ($data)) {
		
		
		if(!empty(	$roommate_user_profilepic)) {
			unlink('../assets/front/img/profiles/'.$roommate_user_profilepic);
		}
		
		echo $filename;
	}
	

   }else{
      echo 0;
   }
}
	
	
}

else if($_POST['ajax_call'] == 3) {
	session_start();
	
	

	
	require_once('../functions/database_connect.php');
$stmt = $pdo->prepare("SELECT 
	roommate_user_profilepic,
	roommate_user_gender
	FROM roommate_users
	WHERE 
	roommate_user_id =:roommate_user_id");
	
	
	$stmt->execute(['roommate_user_id' => $_SESSION['roommate_user_id']]); 
	$data = $stmt->fetchAll();
	
	foreach ($data as $row) {
		if(empty($row["roommate_user_profilepic"])){
			$result['roommate_user_profilepic'] = "";
		} else {
			$result['roommate_user_profilepic'] = $row["roommate_user_profilepic"];
		}
		$result['roommate_user_gender'] = $row["roommate_user_gender"];
	}
	
	echo json_encode($result);
}
?>