<?php
if($_POST['ajax_call'] == 1) {
	session_start();
		if(isset($_SESSION['search_a_timer'])) {
				if( time() < $_SESSION['search_a_timer'] + 3) {
				
					die();
				}
			}
			
	
	$_SESSION['search_p_timer'] = time();
	require_once('../functions/database_connect.php');
	require_once('../functions/ajax_translate.php');
		$params = json_decode($_POST['sendFormData'],true);
	foreach($params as $name) {
		$_POST[$name['name']] = $name['value'];
	}
	$data_array=[];
	
	if(isset($_POST['search_ad_favorite'])){
		$favorite_query = " 
		INNER JOIN roommate_adprefs ON 
		roommate_ad_id = roommate_adpref_adid";
		$favorite_query_where = " AND roommate_adpref_userid = ".$_SESSION['roommate_user_id'] . " ";
	} else {
		$favorite_query = "";
		$favorite_query_where = "";
	}
	
	if(!empty($_POST['budget-min']) && !empty($_POST['budget-max'])) {
		$budget_query = " AND (roommate_ad_budget BETWEEN :budget_min AND :budget_max)";
		$data_array['budget_min']= $_POST['budget-min'];
		$data_array['budget_max']= $_POST['budget-max'];
	}else {
		$budget_query = "";
	
	}
	
	if(isset($_POST['is-custom-move'])) {
		$date_query = "";
	} else {
		$date_query = " AND (DATE(roommate_ad_moveinavailability) = :move_in_date)";
		$data_array['move_in_date']= $_POST['move-in-year']."-".$_POST['move-in-month']."-".$_POST['move-in-day'];
	}
		
	if((isset($_POST['min-term']) && isset($_POST['max-term']))) {
		$term_query = " AND (roommate_ad_mintermpref >= :roommate_ad_mintermpref AND roommate_ad_maxtermpref <=:roommate_ad_maxtermpref)";
		$data_array['roommate_ad_mintermpref']= $_POST['min_term'];
		$data_array['roommate_ad_maxtermpref']= $_POST['max_term'];
	} else {$term_query = "";}	
		
	if($_POST['room-size'] == "any") {
		$size_query = "" ;
	}
	else if($_POST['room-size'] == "large") {
		$size_query = " AND (roommate_ad_roomsizepref=:roommate_ad_roomsizepref)";
		$data_array['roommate_ad_roomsizepref']= "a double room";
	}
	else if($_POST['room-size'] == "small") {
		$size_query = " AND (roommate_ad_roomsizepref=:roommate_ad_roomsizepref)";
		$data_array['roommate_ad_roomsizepref']= "a single or double room";
	}	
	
	
	if($_POST['pref-occupation'] == "A") {$occupation_query = ""; }	
	else if($_POST['pref-occupation'] == "P") {
	$occupation_query = " AND (roommate_ad_occupation=:roommate_ad_occupation)";
	$data_array['roommate_ad_occupation']= "P";
	}	
	else if($_POST['pref-occupation'] == "O") { 
	$occupation_query = " AND (roommate_ad_occupation=:roommate_ad_occupation)";
	$data_array['roommate_ad_occupation']= "S";
	}
	
	if(!empty($_POST['age-min']) && !empty($_POST['age-max'])) {
		$age_query = " AND roommate_ad_age BETWEEN :age_min AND :age_max";
		$data_array['age_min']= $_POST['age-min'];
		$data_array['age_max']= $_POST['age-max'];
	}else {
		$age_query = "";
	
	}
	
	if($_POST['pref-smoking'] == "any") {
		$smoke_query = "";
		
	}else if($_POST['pref-smoking'] == "smoking"){
		$smoke_query = " AND roommate_ad_issmoker = :roommate_ad_issmoker";
		$data_array['roommate_ad_issmoker']= 1;
	
	}else if($_POST['pref-smoking'] == "nosmoking"){
		$smoke_query = " AND roommate_ad_issmoker = :roommate_ad_issmoker";
		$data_array['roommate_ad_issmoker']= 0;
	
	}



	if($_POST['pref-pet'] == "Pets") {
		
	$pet_query = "";
	}else {
		
		$pet_query = " AND roommate_ad_haspets= :roommate_ad_haspets";
		$data_array['roommate_ad_haspets']= 0;
	}
	

	
	$preview_photos = "http://previewbostonrealty.com/";
		$property_stmt = 
		$stmt=$pdo->prepare (
		"SELECT 
		roommate_ad_budget,
		roommate_ad_age,
		roommate_user_name,
		roommate_ad_roomsizepref,
		roommate_ad_title,
		roommate_ad_description,
		roommate_ad_occupation,
		roommate_ad_id,
		
		roommate_ad_issmoker,
		roommate_ad_haspets,
		roommate_user_profilepic,
		roommate_user_gender
		FROM roommate_ads
		JOIN roommate_users ON roommate_user_id = roommate_ad_userid
		".$favorite_query."
		
		WHERE 1=1 
		".$budget_query."
		".$date_query."
		".$term_query."
		".$occupation_query."
		".$age_query."
		".$smoke_query."
		".$pet_query."
		".$size_query."
		".$favorite_query_where."
		ORDER BY roommate_ad_createdate DESC
		;");
	
		
		
		
	
		
		$stmt->execute(
		$data_array
		); 
		$data = $stmt->fetchAll();
		$ad_exists = false;
		$ad_count =0;
		foreach ($data as $row){
		$ad_exists = true;
		
			
			
			$result['roommate_ad_haspets'][] =  translate_pets($row['roommate_ad_haspets']);
			$result['roommate_ad_issmoker'][] = translate_smoking($row['roommate_ad_issmoker']);
			$result['roommate_ad_id'][] = $row['roommate_ad_id'];	
			$result['roommate_ad_budget'][] = '$' . number_format($row['roommate_ad_budget'], 2);	
			$result['roommate_user_gender'][] = translate_gender($row['roommate_user_gender']);	
			$result['roommate_ad_age'][] = $row['roommate_ad_age'];	
			$result['roommate_user_name'][] = $row['roommate_user_name'];	
			$result['roommate_ad_roomsizepref'][] = $row['roommate_ad_roomsizepref'];	
			$result['roommate_ad_title'][] = $row['roommate_ad_title'];	
			$result['roommate_ad_description'][] = $row['roommate_ad_description'];	
			$result['roommate_ad_occupation'][] = translate_occupation($row['roommate_ad_occupation']);	
			
			$result['profile'][$ad_count] = false;
			if(!empty($row['roommate_user_profilepic'])) {
				$result['profile'][$ad_count] = true;
				$result['roommate_user_profilepic'][] = $row['roommate_user_profilepic'];
			} else if($row['roommate_user_gender']== "M") {
				$result['roommate_user_profilepic'][] =  "img_avatar.png";
			} else if($row['roommate_user_gender']== "F") {
				$result['roommate_user_profilepic'][] =  "img_avatar2.png";
			}else if($row['roommate_user_gender']== "O") {
				$result['roommate_user_profilepic'][] =  "img_avatar3.jpg";
			} else {
				$result['roommate_user_profilepic'][] =  "img_avatar3.jpg";
			}
			/*if(isset($_SESSION['roommate_user_id']) && isset($row['roommate_adpref_issaved']) && $row['roommate_adpref_issaved'] == 1){
				$result['roommate_adpref_issaved'][] = "fas";
			} else {
				$result['roommate_adpref_issaved'][] = "far";
			}*/
			
	
			$ad_count++;
		}
		
		$result['adExists'] = $ad_exists;
		$result['ad_count'] = $ad_count;
	
	echo json_encode($result);
	
}
?>