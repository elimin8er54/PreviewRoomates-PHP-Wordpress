<?php
/*
Template Name: Create Ad
*/
?>
<?php
session_start();
if(!isset($_SESSION['roommate_user_id'])) {
	header("Location: ".home_url());
}


get_header(); 
include(HU_BASE.'/functions/database_connect.php');




$stmt = $pdo->prepare("SELECT 
	roommate_ad_id,
	roommate_ad_userid, 
	roommate_ad_title, 
	roommate_ad_budget, 
	roommate_ad_age,
	roommate_ad_occupation, 
	roommate_ad_issmoker,
	roommate_ad_haspets, 
	roommate_ad_language,
	roommate_ad_nationality,
	roommate_ad_phone,
	roommate_ad_showphone,
	roommate_ad_description,
	roommate_ad_showlastname,
	roommate_ad_orientation,
	roommate_user_gender, 
	roommate_ad_smokerok,
	roommate_ad_petsok, 
	roommate_ad_genderpref,
	roommate_ad_minagepref,
	roommate_ad_maxagepref,
	roommate_ad_occupationpref,
	roommate_ad_moveinavailability,
	roommate_ad_mintermpref, 
	roommate_ad_maxtermpref,
	roommate_ad_roomsizepref,
	roommate_ad_createdate, 
	roommate_ad_updatedate, 
	roommate_ad_isdeleted,
	roommate_ad_genderother,
	roommate_ad_orientationpref,
	roommate_ad_showorientation,
	roommate_ad_isbuddyup,
	roommate_user_name,
	roommate_user_profilepic,
	roommate_user_email
	FROM roommate_ads
	INNER JOIN roommate_users ON roommate_user_id = roommate_ad_userid
	
	WHERE 
	roommate_user_id =:roommate_user_id
	
	LIMIT 1;");
	

	$stmt->execute(
	['roommate_user_id' => $_SESSION['roommate_user_id']]); 
	$data = $stmt->fetchAll();
	
	foreach ($data as $row) {
		
		$roommate_ad_phone=$row['roommate_ad_phone']; 
		$roommate_ad_showphone=$row['roommate_ad_showphone']; 
		$roommate_ad_id=$row['roommate_ad_id']; 
		$roommate_ad_userid=$row['roommate_ad_userid']; 
		$roommate_ad_title=$row['roommate_ad_title']; 
		$roommate_ad_budget=$row['roommate_ad_budget']; 
		$roommate_ad_age=$row['roommate_ad_age']; 
		$roommate_ad_occupation=$row['roommate_ad_occupation']; 
		$roommate_ad_issmoker=$row['roommate_ad_issmoker']; 
		$roommate_ad_haspets=$row['roommate_ad_haspets']; 
		$roommate_ad_language=$row['roommate_ad_language']; 
		$roommate_ad_nationality=$row['roommate_ad_nationality']; 
		$roommate_ad_description=$row['roommate_ad_description']; 
		$roommate_ad_showlastname=$row['roommate_ad_showlastname']; 
		$roommate_ad_orientation=$row['roommate_ad_orientation']; 
		$roommate_ad_smokerok=$row['roommate_ad_smokerok']; 
		$roommate_ad_petsok=$row['roommate_ad_petsok']; 
		$roommate_ad_genderpref=$row['roommate_ad_genderpref']; 
		$roommate_ad_minagepref=$row['roommate_ad_minagepref']; 
		$roommate_ad_maxagepref=$row['roommate_ad_maxagepref']; 
		$roommate_ad_occupationpref=$row['roommate_ad_occupationpref']; 
		$roommate_ad_moveinavailability=$row['roommate_ad_moveinavailability'];
		$roommate_ad_mintermpref=$row['roommate_ad_mintermpref']; 
		$roommate_ad_maxtermpref=$row['roommate_ad_maxtermpref']; 
		$roommate_ad_roomsizepref=$row['roommate_ad_roomsizepref']; 
		$roommate_ad_createdate=$row['roommate_ad_createdate']; 
		$roommate_ad_updatedate=$row['roommate_ad_updatedate']; 
		$roommate_ad_isdeleted=$row['roommate_ad_isdeleted']; 
		$roommate_ad_genderother=$row['roommate_ad_genderother'];
		$roommate_ad_orientationpref=$row['roommate_ad_orientationpref'];
		$roommate_ad_showorientation=$row['roommate_ad_showorientation']; 
		$roommate_ad_isbuddyup=$row['roommate_ad_isbuddyup'];
		
		
	
		
	}

$stmt = $pdo->prepare (
	"SELECT 
	roommate_interest_content
	FROM roommate_interests
	WHERE roommate_interest_adid = :roommate_interest_adid;");
	
	$stmt->execute(['roommate_interest_adid' => $roommate_ad_id]
	); 
	$data = $stmt->fetchAll();
	$roommate_interest_content=[];
	foreach ($data as $row) {
			$roommate_interest_content[] = $row['roommate_interest_content'];
	}
	
	$stmt = $pdo->prepare (
	"SELECT 
	roommate_amenity_content
	FROM roommate_amenities
	WHERE roommate_ads_roommate_adid = :roommate_ads_roommate_adid;");
	
	$stmt->execute(['roommate_ads_roommate_adid' => $roommate_ad_id]
	); 
	$data = $stmt->fetchAll();
	$roommate_amenity_content=[];
	foreach ($data as $row) {
			$roommate_amenity_content[] = $row['roommate_amenity_content'];
	}
	
	$stmt = $pdo->prepare (
	"SELECT 
	roommate_citypref_city
	FROM roommate_cityprefs
	WHERE roommate_citypref_adid = :roommate_citypref_adid;");
	
	$stmt->execute(['roommate_citypref_adid' => $roommate_ad_id]
	); 
	$data = $stmt->fetchAll();
	$roommate_citypref_city=[];
	foreach ($data as $row) {
			$roommate_citypref_city[] = $row['roommate_citypref_city'];
	}
?>
<style>
.form_row {
     color: #34373C; 
     margin: 10px 0; 
     float: left; 
     clear: both; 
     width: 100%; 
     line-height: 1.8; 
     font-size: 12px; 
     font-size: 0.8rem; 
}
.pl_step2 .form_inputs {
    width: 60%;
    margin-left: 38%;
}
.form_inputs {
    width: 70%;
    margin-left: 28%;
}
.form_label {
    width: 25%;
    float: left;
    margin-left: 5px;
    font-weight: 500;
}
legend, caption {
    color: #FFF;
    background: #B2B2B2;
    text-shadow: 0 -1px -1px rgba(0,0,0,0.3);
    width: 96%;
    padding: 0.75% 2%;
    margin: 0 0 5px;
    font-family: 'Quicksand',sans-serif;
    font-size: 15px;
    font-weight: 500;
    -webkit-border-radius: 10px;
    -moz-border-radius: 10px;
    border-radius: 10px;
}
</style>
<section class="content">

	<?php hu_get_template_part('parts/page-title'); ?>

	<div class="pad group">

		<div class="block_content">
	
		<form id = "ad_form">
		<fieldset>
		
		
			<legend>
				Get started with your
				room
				wanted advert
			</legend>
		
		<div class="form_row form_row_seekers">
			<div class="form_label">I am / we are</div>
			<div class="form_inputs">
				<span class="form_input form_select">
					<select id="NumberOfMales" name="NumberOfMales">
						<option value="0">Select your amount...</option>
						<option value="1">1 male</option>
						<option value="2">2 males</option>
						<option value="3">3 males</option>
						<option value="4">4 males</option>
						<option value="5">5 males</option>
						<option value="6">6 males</option>	
					</select>
					<select id="NumberOfFemales" name="NumberOfFemales">
						<option value="0">Select your amount...</option>
						<option value="1">1 female</option>
						<option value="2">2 females</option>
						<option value="3">3 females</option>
						<option value="4">4 females</option>
						<option value="5">5 females</option>
						<option value="6">6 females</option>	
					</select>
					<select id="NumberOfOthers" name="NumberOfOthers">
						<option value="0">Select your amount...</option>
						<option value="1">1 other</option>
						<option value="2">2 others</option>
						<option value="3">3 others</option>
						<option value="4">4 others</option>
						<option value="5">5 others</option>
						<option value="6">6 others</option>	
					</select>
				</span>
			</div>
		</div>
		<div id="white-overlay" class="">
			<div class="form_row form_row_looking_for">
				<div class="form_label">Looking for</div>
				<div class="form_inputs">
					
						<span class="form_input form_select">
							<select id="RoomReq" name="RoomReq">
								<option value="nothing" ></option>
								<option <?php echo  ( $roommate_ad_roomsizepref=="a single or double room") ? " selected " : ""; ?> value="a single or double room">
									a small or large room (i.e. twin bed ok)
								</option>
								<option <?php echo  ( $roommate_ad_roomsizepref=="a double room") ? " selected " : ""; ?> value="a double room">
									a large room (full sized bed minimum)
								</option>
								
							</select>
							to rent in an apartment or house share
						</span>
					
					
				</div>
			</div>
				<div class="form_row form_row_buddyups">
					<div class="form_label">'Buddy ups'</div>
					<div class="form_inputs">
						<label class="form_input form_checkbox">
							<input <?php echo  ( $roommate_ad_isbuddyup==1) ? " checked " : ""; ?> type="checkbox" name="interested_meeting_other_seekers" value="Y">
							I/we are also interested in <em>Buddying up</em>
						</label>
						<div class="form_hint">
							
								Tick this if you might like to <em>Buddy Up</em> with other room seekers to find a whole apartment or house together and start a brand new roomshare.
							
							
						</div>
					</div>
				</div>
		</div>
		
	</fieldset>
			<fieldset>
					<legend>Your search</legend>
				<div class="form_row form_row_watchlist ">
						
							<div class="form_label">
								
								Where in Boston do you want to live?
								
							</div>
							<div class="form_inputs">
								<span class="form_input form_select">
								
									
										<input value="Allston" <?php echo (in_array("Allston",$roommate_citypref_city)) ? " checked " : ""; ?> type = "checkbox" name = "cityboxa" >Allston
										<input value="Brighton" <?php echo (in_array("Brighton",$roommate_citypref_city)) ? " checked " : ""; ?> type = "checkbox" name = "cityboxb" >Brighton
								
								</span>
								
							</div>
					
					
				</div>
				
				<div class="form_row form_row_budget  ">
					<div class="form_label">
						
						Your budget
						
						
						<div class="form_hint">
							
								
									(total rental amount you can afford)
								
							
							
						</div>
					</div>
					<div class="form_inputs">
						<span class="form_input form_text">
							$
							<input type="number" name="combined_budget" value="<?php echo $roommate_ad_budget ?>" step="any">
						</span>
						<span class="form_input form_select" style="margin-right: 0;">
							per month
						</span>
					</div>
				</div>
				<div class="form_row form_row_avail_from">
					<div class="form_label">
						I am
						
						available to move in from
					</div>
					<div class="form_inputs">
					<span class="form_input form_select">
							<select name="mon_avail">
								<?php for($i=1;$i<=12;$i++) { ?>
								<option <?php if($i==date("m")) { echo " selected ";} ?>  value="<?php echo $i; ?>"><?php  echo date("M");?></option>
								<?php } ?>
							</select>
						</span>
						<span class="form_input form_select">
							<select name="day_avail">
								
								<?php for($i=1;$i<=31;$i++) { ?>
								<option <?php if($i==date("d")) { echo " selected ";} ?> value="<?php echo $i; ?>"><?php echo $i?></option>
								<?php } ?>
							</select>
						</span>
						
						<span class="form_input form_select">
							<select name="year_avail">

                    <?php for($i=date("Y");$i<=date("Y")+2;$i++) { ?>
                    <option  value="<?php echo $i; ?>"><?php echo $i?></option>
                    <?php } ?></select>

						</span>
					</div>
				</div>
				<div class="form_row form_row_period ">
					<div class="form_label">
						
						Period accommodation needed for
						
					</div>
					<div class="form_inputs">
						<span class="form_input form_select">
							<select name="min_term">
							    <option <?php echo ($roommate_ad_mintermpref == "0") ? " selected " : ""; ?> value="0">No minimum</option>
							    <option <?php echo ($roommate_ad_mintermpref == "1") ? " selected " : ""; ?> value="1">1 Month</option>
							    <option <?php echo ($roommate_ad_mintermpref == "2") ? " selected " : ""; ?> value="2">2 Months</option>
							    <option <?php echo ($roommate_ad_mintermpref == "3") ? " selected " : ""; ?> value="3">3 Months</option>
							    <option <?php echo ($roommate_ad_mintermpref == "4") ? " selected " : ""; ?> value="4">4 Months</option>
							    <option <?php echo ($roommate_ad_mintermpref == "5") ? " selected " : ""; ?> value="5">5 Months</option>
							    <option <?php echo ($roommate_ad_mintermpref == "6") ? " selected " : ""; ?> value="6">6 Months</option>
							    <option <?php echo ($roommate_ad_mintermpref == "7") ? " selected " : ""; ?> value="7">7 Months</option>
							    <option <?php echo ($roommate_ad_mintermpref == "8") ? " selected " : ""; ?> value="8">8 Months</option>
							    <option <?php echo ($roommate_ad_mintermpref == "9") ? " selected " : ""; ?> value="9">9 Months</option>
							    <option <?php echo ($roommate_ad_mintermpref == "10") ? " selected " : ""; ?> value="10">10 Months</option>
							    <option <?php echo ($roommate_ad_mintermpref == "11") ? " selected " : ""; ?> value="11">11 Months</option>
							    <option <?php echo ($roommate_ad_mintermpref == "12") ? " selected " : ""; ?> value="12">1 Year</option>
							    <option <?php echo ($roommate_ad_mintermpref == "15") ? " selected " : ""; ?> value="15">1 Year 3 Months</option>
							    <option <?php echo ($roommate_ad_mintermpref == "18") ? " selected " : ""; ?> value="18">1 Year 6 Months</option>
							    <option <?php echo ($roommate_ad_mintermpref == "21") ? " selected " : ""; ?> value="21">1 Year 9 Months</option>
							    <option <?php echo ($roommate_ad_mintermpref == "24") ? " selected " : ""; ?> value="24">2 Years</option>
							</select>

						</span>
						<span class="form_text_separator">to</span>
						<span class="form_input form_select">

							<select name="max_term">
							    <option <?php echo ($roommate_ad_maxtermpref == "0") ? " selected " : ""; ?> value="0">No maximum</option>
							    <option <?php echo ($roommate_ad_maxtermpref == "1") ? " selected " : ""; ?> value="1">1 Month</option>
							    <option <?php echo ($roommate_ad_maxtermpref == "2") ? " selected " : ""; ?> value="2">2 Months</option>
							    <option <?php echo ($roommate_ad_maxtermpref == "3") ? " selected " : ""; ?> value="3">3 Months</option>
							    <option <?php echo ($roommate_ad_maxtermpref == "4") ? " selected " : ""; ?> value="4">4 Months</option>
							    <option <?php echo ($roommate_ad_maxtermpref == "5") ? " selected " : ""; ?> value="5">5 Months</option>
							    <option <?php echo ($roommate_ad_maxtermpref == "6") ? " selected " : ""; ?> value="6">6 Months</option>
							    <option <?php echo ($roommate_ad_maxtermpref == "7") ? " selected " : ""; ?> value="7">7 Months</option>
							    <option <?php echo ($roommate_ad_maxtermpref == "8") ? " selected " : ""; ?> value="8">8 Months</option>
							    <option <?php echo ($roommate_ad_maxtermpref == "9") ? " selected " : ""; ?> value="9">9 Months</option>
							    <option <?php echo ($roommate_ad_maxtermpref == "10") ? " selected " : ""; ?> value="10">10 Months</option>
							    <option <?php echo ($roommate_ad_maxtermpref == "11") ? " selected " : ""; ?> value="11">11 Months</option>
							    <option <?php echo ($roommate_ad_maxtermpref == "12") ? " selected " : ""; ?> value="12">1 Year</option>
							    <option <?php echo ($roommate_ad_maxtermpref == "15") ? " selected " : ""; ?> value="15">1 Year 3 Months</option>
							    <option <?php echo ($roommate_ad_maxtermpref == "18") ? " selected " : ""; ?> value="18">1 Year 6 Months</option>
							    <option <?php echo ($roommate_ad_maxtermpref == "21") ? " selected " : ""; ?> value="21">1 Year 9 Months</option>
							    <option <?php echo ($roommate_ad_maxtermpref == "24") ? " selected " : ""; ?> value="24">2 Years</option>
							    <option <?php echo ($roommate_ad_maxtermpref == "36") ? " selected " : ""; ?> value="36">3 Years</option>
							</select>


						</span>
					</div>
				</div>
				

				
				<div class="form_row form_row_amenities">
					<div class="form_label">
						I
						
						would prefer these amenities
					</div>
					<div class="form_inputs">
						<div class="cols cols2">
							<div class="col col_first">
								<label class="form_input form_checkbox">
									<input  <?php echo (in_array("furnished",$roommate_amenity_content)) ? " checked " : ""; ?>  type="checkbox" name="amenities[]" value="furnished"> Furnished
								</label>
							
								<label class="form_input form_checkbox">
									<input <?php echo (in_array("washing_machine",$roommate_amenity_content)) ? " checked " : ""; ?> type="checkbox" name="amenities[]" value="washing_machine"> Washing machine
								</label>
								<label class="form_input form_checkbox">
									<input <?php echo (in_array("garden",$roommate_amenity_content)) ? " checked " : ""; ?> type="checkbox" name="amenities[]" value="garden"> Yard/terrace
								</label>
								<label class="form_input form_checkbox">
									<input <?php echo (in_array("balcony",$roommate_amenity_content)) ? " checked " : ""; ?> type="checkbox" name="amenities[]" value="balcony"> Balcony/patio
								</label>

							</div>
							<div class="col col_last">
								<label class="form_input form_checkbox">
									<input <?php echo (in_array("off_street_parking",$roommate_amenity_content)) ? " checked " : ""; ?> type="checkbox" name="amenities[]" value="off_street_parking"> Parking
								</label>

								<label class="form_input form_checkbox">
									<input <?php echo (in_array("garage",$roommate_amenity_content)) ? " checked " : ""; ?> type="checkbox" name="amenities[]" value="garage"> Garage
								</label>
							
								
									<label class="form_input form_checkbox">
										<input <?php echo (in_array("cable and net ready",$roommate_amenity_content)) ? " checked " : ""; ?> type="checkbox" name="amenities[]" value="cable and net ready"> Cable and net ready
									</label>
									
								
							</div>
						</div>
					</div>
				</div>
			</fieldset>
			<fieldset>
	
				<legend>
					About you
				</legend>
				<div class="form_row form_row_age ">
					<div class="form_label">
						

						Age
						

						
					</div>
					<div class="form_inputs">
						<span class="form_input form_select">
							

<select name="min_age">
    <option value="" selected="">Select...</option>
   <?php for ($i = 18; $i <= 99;$i++) {
	?>
	<option <?php echo  ($i==$roommate_ad_age) ? " selected " : ""; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
	<?php
	}  
	?>
</select>
						</span>
						
						years old
					</div>
				</div>
				<div class="form_row form_row_occupation">
					<div class="form_label">
						Occupation
					</div>
					<div class="form_inputs">
						
							<span class="form_input form_select">
								<select name="share_type">
									<option <?php echo  ( $roommate_ad_occupation=="ND") ? " selected " : ""; ?> value="ND">Not disclosed</option>
									<option  <?php echo  ( $roommate_ad_occupation=="S") ? " selected " : ""; ?> value="S">Student</option>
									<option  <?php echo  ( $roommate_ad_occupation=="P") ? " selected " : ""; ?> value="P">Professional</option>
									<option  <?php echo  ( $roommate_ad_occupation=="O") ? " selected " : ""; ?> value="O">Other</option>
								</select>
							</span>
						
						
					</div>
				</div>
				
					
				
				<div class="form_row form_row_smoking">
					<div class="form_label">
						Do you smoke?
					</div>
					<div class="form_inputs">
						<span class="form_input form_select">
							<select name="smoking_current">
								<option  <?php echo  ( $roommate_ad_issmoker==0) ? " selected " : ""; ?> value="N" >No</option>
								<option  <?php echo  ( $roommate_ad_issmoker==1) ? " selected " : ""; ?> value="Y">Yes</option>
							</select>
						</span>
					</div>
				</div>
				<div class="form_row form_row_pets">
					<div class="form_label">
						Do you have any pets?
					</div>
					<div class="form_inputs">
						<span class="form_input form_select">
							<select name="pets">
								<option  <?php echo  ( $roommate_ad_haspets=="O") ? " selected " : ""; ?> value="N">No</option>
								<option  <?php echo  ( $roommate_ad_haspets=="1") ? " selected " : ""; ?> value="Y">Yes</option>
							</select>
						</span>
					</div>
				</div>
				
					<!--<div class="form_row form_row_orientation">
						<div class="form_label">
							Your sexual orientation
						</div>
						<div class="form_inputs">
							<span class="form_input form_select">
								<select name="gay_lesbian">
									<option value="ND" selected="">Undisclosed</option>
									<option value="S">Straight</option>
									
									<option value="G">Gay/Lesbian</option>
									<option value="B">Bi-sexual</option>
								</select>
							</span>
							<br>
							<label class="form_input form_checkbox">
								<input type="checkbox" name="gay_consent" value="Y">
								Yes, I would like to show my orientation to other users
							</label>
						</div>
					</div>-->
				
					
					<div class="form_row form_row_interests">
						<div class="form_label">
							Your interests (Use a new line for every interest)
						</div>
						<div class="form_inputs">
							<span class="form_input form_text">
								<textarea   rows="8" cols="30" type="text" name="interests">
								<?php 
								foreach($roommate_interest_content as $interests) {
									echo $interests."\n";
								}
								
								?></textarea>
							</span>
						</div>
					</div>
				
				<div class="form_row form_row_name  ">
					<div class="form_label">
						
						
						Your name
						
						
					</div>
					<div class="form_inputs">
						
						<br>
						<label class="form_input form_checkbox">
							<input <?php echo ($roommate_ad_showlastname == 0) ? "" : " checked "; ?> type="checkbox" name="display_last_name" checked="" value="Y">
							Display last name on advert?
						</label>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend>Your preferred roommate</legend>
				
				
					<div class="form_row form_row_age">
						<div class="form_label">
							Age range
						</div>
						<div class="form_inputs">
							<span class="form_input form_select">
								

<select name="min_age_req">
  
<?php for ($i = 18; $i <= 99;$i++) {
	?>
	<option <?php echo  ($i==$roommate_ad_minagepref) ? " selected " : ""; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
	<?php
	}  
	?>
</select>
							</span>
							<span class="form_text_separator">to</span>
							<span class="form_input form_select">
								

<select name="max_age_req">
 
  <?php for ($i = 18; $i <= 99;$i++) {
	?>
	<option <?php echo  ($i==$roommate_ad_maxagepref) ? " selected " : ""; ?> value="<?php echo $i; ?>"><?php echo $i; ?></option>
	<?php
	}  
	?>
</select>
							</span>
						</div>
					</div>
					<div class="form_row form_row_occupation">
						<div class="form_label">
							Occupation
						</div>
						<div class="form_inputs">
							<span class="form_input form_select">
								<select name="share_type_req">
									<option value="M">Don't mind</option>
									<option value="S">Students</option>
									<option value="P">Professionals</option>
								</select>
							</span>
						</div>
					</div>
					<div class="form_row form_row_smoking">
						<div class="form_label">
							Smoking OK?
						</div>
						<div class="form_inputs">
							<span class="form_input form_select">
								<select name="smoking">
									<option   <?php echo  ($roommate_ad_smokerok==1) ? " selected " : ""; ?> value="Y">Don't mind</option>
									<option   <?php echo  ($roommate_ad_smokerok==0) ? " selected " : ""; ?> value="N">No thanks</option>
								</select>
							</span>
						</div>
					</div>
					<div class="form_row form_row_pets">
						<div class="form_label">
							Pets OK?
						</div>
						<div class="form_inputs">
							<span class="form_input form_select">
								<select name="pets_req">
									<option  <?php echo  ($roommate_ad_petsok==1) ? " selected " : ""; ?> value="Y">Don't mind</option>
									<option  <?php echo  ($roommate_ad_petsok==0) ? " selected " : ""; ?> value="N">No thanks</option>
								</select>
							</span>
						</div>
					</div>
					<!--<div class="form_row form_row_orientation">
						<div class="form_label">
							Orientation
						</div>
						<div class="form_inputs">
							<span class="form_input form_select">
								<select name="gay_lesbian_req">
									<option value="ND" selected="">Not important</option>
									<option value="S">Straight</option>
									<option value="G">Gay/Lesbian</option>
									<option value="B">Bi-sexual</option>
									<option value="O">Other</option>
								</select>
							</span>
						</div>
					</div>-->
				
			</fieldset>
		
		
			<fieldset>
				<legend>
					Advert details (optional)
				</legend>
				<div class="form_row form_row_title ">
					<div class="form_label">
						
						Advert title
						
						<div class="form_hint">
							(Short description)
						</div>
					</div>
					<div class="form_inputs">
						<span class="form_input form_text">
							<input type="text" name="ad_title" value="<?php echo $roommate_ad_title; ?>" size="48" maxlength="35">
						</span>
					</div>
				</div>
				<div class="form_row form_row_description ">
					<div class="form_label">
						
						Description
						
						<div class="form_hint">
							(No contact details permitted within description)
						</div>
					</div>
					<div class="form_inputs">
						<span class="form_input form_text">
							<textarea name="ad_text" rows="10" cols="36" wrap="virtual"><?php echo $roommate_ad_description; ?></textarea>
						</span>
						<div class="form_hint">
							Include details about the accommodation you are looking for,
							who you'd like to live with and what a potential roommate
							should expect living with you.
						</div>
					</div>
				</div>
				
				
				<div class="form_row form_row_tel">
    <div class="form_label">
  
    </div>
  <div class="form_inputs">
	  <span class="form_input form_text"></span>
			
	<button onclick="upload_gif(<?php echo $_SESSION['roommate_user_id'];?>, this);"  type="button" class="btn-xs btn-warning">Upload Photo</button>
			
		  </div>
</div>		

				<div class="form_row form_row_tel">
    <div class="form_label">
  
    </div>
  <div class="form_inputs">
	  <span class="form_input form_text"> </span>
			
				
				 <img src="<?php echo $roommate_user_profilepic; ?>" id="img" width="100" height="100">
		  </div>
</div>	
<div class="form_row form_row_tel">
    <div class="form_label">
      Telephone
    </div>
  <div class="form_inputs">
    <span class="form_input form_text">
      <input type="tel" name="tel" value="<?php echo $roommate_ad_phone; ?>" autocomplete="tel" id="form_input--tel-n">
    </span>
      <label class="form_input form_checkbox">
        <input <?php echo ($roommate_ad_showphone == 1) ? " checked " : ""; ?> name="display_tel" value="Y" type="checkbox">
        Display with advert?
      </label>
  </div>
</div>

</fieldset>
		
		<div class="form_row form_row_buttons">
			<div class="form_label"></div>
			<div class="form_inputs">

				<div class="form_input form_button pl_save_bottom">
<button class="button" id="postWantedAd" type="button" name="submit"> Post ad
											</button>
					
				</div>
			</div>
		</div>
	</form>

              </div>
<div style = "display:none">
<input type="file" id="file" name="file" />
            <input type="button" class="button" value="Upload" id="but_upload">
</div>
	</div><!--/.pad-->

</section><!--/.content-->
<script>

	the_user = "";
	function upload_gif(user_id,the_element){
		$( "#file" ).trigger( "click" );
		the_user = user_id;
	}
$(document).ready(function(){
	
	document.getElementById("file").onchange = function() {
    document.getElementById("but_upload").click();
};

$.ajax({
            type:   'POST',
            url:    '<?php echo THEME_DIR. "/ajax/ad_create_ajax.php" ?>',
            data: { 
			'ajax_call' : '3'
		},
		 dataType: "json", 
            success: function(response) {
				
				if(response.roommate_user_profilepic != '' ) {
				plocation = '<?php echo THEME_DIR . "/assets/front/img/profiles/";?>';
				plocation +=response.roommate_user_profilepic;
				} else if(response.roommate_user_gender== "M") {
			plocation = '<?php echo THEME_DIR."/assets/front/img/img_avatar1.png"; ?>';
		} else if(response.roommate_user_gender== "F") {
			plocation =  '<?php echo THEME_DIR."/assets/front/img/img_avatar2.png"; ?>';
		}else if(response.roommate_user_gender== "O") {
			plocation = '<?php echo THEME_DIR."/assets/front/img/img_avatar3.jpg"; ?>';
		} else {
		plocation =  '<?php echo THEME_DIR."/assets/front/img/img_avatar3.jpg"; ?>';
		}
		
			
                $("#img").attr("src",plocation); 
            },
		error: function (request, status, error) {
			 console.log(request.responseText);
		}
        });

    $("#but_upload").click(function(){

        var fd = new FormData();
        var files = $('#file')[0].files[0];
        fd.append('file',files);
		fd.append('user_ID',the_user);
		fd.append('ajax_call',2);
        $.ajax({
            url: '<?php echo THEME_DIR. "/ajax/ad_create_ajax.php" ?>',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
				plocation = '<?php echo THEME_DIR . "/assets/front/img/profiles/";?>';
				plocation +=response;
			
                if(response != 0){
                    $("#img").attr("src",plocation); 
                    // Display image element
					
					
                }else{
                    alert('file not uploaded, something went wrong.');
                }
            },
        });
		 $("#file").val(''); 
    });
});
$( "#postWantedAd" ).click(function() {
		var formdata = $("#ad_form").serializeArray();

$.ajax({
            type:   'POST',
            url:    '<?php echo THEME_DIR. "/ajax/ad_create_ajax.php" ?>',
            data: { 
			'ajax_call' : '1',
			'sendFormData' : JSON.stringify(formdata)
		},
		 dataType: "json", 
            success: function(data) {
				if(data.isCreated) {
					window.location.replace("/view-ad/?ad_id="+data.aid);
					 
				} else{
				
						name_input = data.name;
						//var myAlert = new cAlert(data.message, "danger", "blocked", 2);
						//myAlert.alert();
						 gotoerror(name_input);
						
						
					
				}
            },
		error: function (request, status, error) {
			console.log(request.responseText);
		}
        });
});
</script>
<?php get_sidebar(); ?>

<?php get_footer(); ?>