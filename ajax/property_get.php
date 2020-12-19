<?php
if($_POST['ajax_call'] == 1) {
	session_start();
	
	if(isset($_SESSION['search_p_timer'])) {
		if( time() < $_SESSION['search_p_timer'] + 3) {
		
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
	
	 if(!empty($_POST['budget-min']) && !empty($_POST['budget-max'])) {
		$budget_query = " AND (

		CAST( IF(property_RoomForRent='1',property_LeasePrice,property_LeasePrice/property_Bedrooms) AS  UNSIGNED)
			BETWEEN :budget_min AND :budget_max ) ";
		$data_array['budget_min']= $_POST['budget-min'];
		$data_array['budget_max']= $_POST['budget-max'];
	}else {
		$budget_query = "";
	
	}
	
	if(isset($_POST['search_ad_favorite'])){
		$favorite_query = " 
		INNER JOIN roommate_propprefs ON 
		roommate_proppref_propertyid = property_ID";
		$favorite_query_where = " AND roommate_proppref_userid = ".$_SESSION['roommate_user_id'] . " ";
	} else {
		$favorite_query = "";
		$favorite_query_where = "";
	}
	
	if(isset($_POST['is-custom-move'])) {
		$available_query = "";
	}
	else
	if(!empty($_POST['move-in-month']) && !empty($_POST['move-in-year'])) {
		$available_query = " AND  (MONTH(FROM_UNIXTIME(property_AvailableTS)) = :move_in_month AND
		YEAR(FROM_UNIXTIME(property_AvailableTS)) = :move_in_year) ";
		$data_array['move_in_month']= $_POST['move-in-month'];
		$data_array['move_in_year']= $_POST['move-in-year'];
	
	}else if(!empty($_POST['move-in-month'])) {
		$available_query = " AND  MONTH(FROM_UNIXTIME(property_AvailableTS)) = :move_in_month ";
		$data_array['move_in_month']= $_POST['move-in-month'];
	} else {
		$available_query = "";
	
	}
	
	if($_POST['pref-pet'] == "any") {
		$pet_query = "";

	}
	else if($_POST['pref-pet'] == "Pets") {
		$pet_query = " AND (
		property_Pets  LIKE '%Cats%' OR
		property_Pets  LIKE '%Dogs%' OR
		property_Pets  LIKE '%Small Pets%' OR
		property_Pets  LIKE '%Negotiable%'
		)";

	}else {
		
		$pet_query = " AND (
		property_Pets  LIKE '%No Pets%' OR
		property_Pets  LIKE '%Unsure - Check With Landlord%' OR
		property_Pets = ''
		)";
		
	}


		
		$stmt=$pdo->prepare (
		"SELECT 
		property_ID,
		property_City,
		property_LeasePrice,
		property_LPayingFee,
		property_Bedrooms,
		property_Zip,
		property_AvailableTS,
		photo_Thumb,
		property_RoomForRent
		FROM ap_property
		LEFT JOIN ap_photo ON photo_PropertyID = property_ID
		".$favorite_query."
		WHERE (property_Bedrooms > 1 OR
		property_RoomForRent = 1) AND 
		photo_RankOrder = 0 AND 
		property_StatusID = 1 
		".$budget_query."
		".$available_query."
		".$pet_query."
		".$favorite_query_where."
		ORDER BY property_NumPhotos DESC 
		;");
	

		$stmt->execute(
		$data_array
		); 
		$data = $stmt->fetchAll();
		$ad_exists = false;
		$ad_count =0;
		foreach ($data as $row){
		$ad_exists = true;
		
			

			$result['property_ID'][] = $row['property_ID'];	
			$result['property_City'][] = $row['property_City'];	

			$result['property_LeasePrice'][] = '$' . number_format(translate_roomforrentprice( $row['property_LeasePrice'],$row['property_Bedrooms'],$row['property_RoomForRent']), 2);
			$result['property_LPayingFee'][] = translate_landlordfee($row['property_LPayingFee']);	
			$result['property_Bedrooms'][] = $row['property_Bedrooms'];	
			$result['property_Zip'][] = $row['property_Zip'];	
			$result['property_AvailableTS'][] = date('Y-m-d', $row['property_AvailableTS']);
			$result['property_RoomForRent'][] = $row['property_RoomForRent'];
			if(!empty($row['photo_Thumb'])) {
				$result['photo_Thumb'][] = "http://previewbostonrealty.com/".$row['photo_Thumb'];
			} else {
				$result['photo_Thumb'][] = "/assets/front/img/thumb-small.png";
			}
			
	
			$ad_count++;
		}
		
		$result['adExists'] = $ad_exists;
		$result['ad_count'] = $ad_count;
	
	echo json_encode($result);
	
}
?>