<?php
/*
Template Name: View Property
*/
?>
<?php get_header();
	include(HU_BASE.'/functions/database_connect.php');
	$stmt = $pdo->prepare("SELECT
	ap_property.property_ID,
	ap_property.property_StreetNum,
	ap_property.property_StreetName, 
	ap_property.property_RoomForRent,
		ap_property.property_City,
		ap_property.property_State, 
		ap_property.property_CreatedDate, 
		ap_property.property_ListPrice, 
		ap_property.property_HideListPrice,
		ap_property.property_HideStreet,
		ap_property.property_VirtualTour, 
		ap_property.property_Title,
		ap_property.property_Details,
		ap_property.property_Bedrooms, 
		ap_property.property_Bathrooms,
		ap_property.property_LivingSize,
		ap_property.property_LotSize, 
		ap_property.property_Meter,
		ap_property_status.status_Title, 
		ap_property_type.type_Title, 
		ap_property.property_HotText,
		ap_property.property_LeasePrice,
		ap_property.property_PDF, 
		ap_property.property_MLS,
		ap_property.property_Zip, 
		ap_property.property_SoldPrice,
		ap_property.property_PhotosObtainedBy, 
		ap_property.property_OpenHouse,
		ap_property.property_MLS,
		ap_property.property_ExtFeats,
		ap_property.property_Floors,
		ap_property.property_FloorRestrict,
		ap_property.property_IntFeats,
		ap_property.property_Kitchen,
		ap_property.property_Laundry,
		ap_property.property_Parking,
		ap_property.property_Pets,
		ap_property.property_Transpo,
		ap_property.property_AptNum, 
		ap_property.property_College,
		ap_property.property_AvailableDay,
		ap_property.property_AvailableYear,
		ap_property.property_Available,
		ap_property.property_SubLoc,
		ap_property.property_ParkingRent, 
		property_LPayingFee, property_UseAdInfo,
	
		
		property_AdvertisingInfo,
		property_PhotoAge, 
		property_AvailableNow 
		FROM ap_property
	
		, ap_property_type, ap_property_status 
		
		WHERE property_ID = :property_ID 
		AND ap_property_status.status_ID = ap_property.property_StatusID 
		AND ap_property_type.type_ID = ap_property.property_TypeID 
		");
	
	
	$stmt->execute(
	['property_ID' => $_GET['property_id']]); 
	$data = $stmt->fetchAll();
	
	
	$property_isset = false;
	foreach ($data as $row) {
		$property_isset = true;
		$stmt = $pdo->prepare("SELECT a.photo_ID, a.photo_File as pf, a.photo_Thumb as pt, a.photo_Description, a.photo_RankOrder,
	b.photo_id AS editid, b.photo_edit_File as pef, b.photo_edit_Thumb as pet FROM ap_photo a
	LEFT JOIN ap_photo_edit b ON a.photo_id = b.photo_ID
	WHERE photo_PropertyID = :photo_PropertyID ORDER BY photo_RankOrder ");
	$stmt->execute(
	['photo_PropertyID' => $_GET['property_id']]); 
	$dataphoto = $stmt->fetchAll();
	$has_photo = false;
	foreach ($dataphoto as $prow) {
			$has_photo = true;
		if($prow['editid'] != null) {
		
		$photo_file[] = "http://previewbostonrealty.com/admin/test/".$prow['pef'];	
		$photo_thumb[] = "http://previewbostonrealty.com/admin/test/".$prow['pef'];	
		} else {
			$photo_file[] = "http://previewbostonrealty.com/".$prow['pf'];	
		$photo_thumb[] = "http://previewbostonrealty.com/".$prow['pt'];
			
		}
	} 

	if (!$has_photo) {
		$photo_file[] = "http://previewbostonrealty.com/images/house_sil_large.gif";
	}
	
	
	
	

	$pettext = "";

	if ((strpos($row['property_Pets'], "Dogs") !== false) && (strpos($row['property_Pets'], "Cats") !== false))  {
		$pettext = "Dog &amp; Cat Friendly";
	} else if (strpos($row['property_Pets'], "Dogs") !== false) {
		$pettext = "Dog Friendly";
	} else if (strpos($row['property_Pets'], "Cats") !== false)  {
		$pettext = "Cat Friendly";
	} else if (strpos($row['property_Pets'], "Small Pets") !== false)  {
		$pettext = "Small Pets Are Welcome";
	} else if (strpos($row['property_Pets'], "Pets Negotiable") !== false)  {
		$pettext = "Pets Are Negotiable";
	} else if (strpos($row['property_Pets'], "No Pets") !== false)  {
		$pettext = "No Pets, Please";
	} else {
		$pettext = "Ask for Details";
	}

	// Clean up the Parking output for it's own section - excessive but effective.	


	$row['property_Parking'] = str_replace("On Street-Permit Parking", "On Street (with Permit)", $row['property_Parking']);
	$row['property_Parking'] = str_replace("On Street-No Permit Required", "On Street (without Permit)", $row['property_Parking']);


	$row['property_Parking'] = str_replace("Off Street 1 Space For Rent", "1 Off Street Space For Rent", $row['property_Parking']);
	$row['property_Parking'] = str_replace("Off Street 2 Spaces For Rent", "2 Off Street Spaces For Rent", $row['property_Parking']);
	$row['property_Parking'] = str_replace("Off Street 3 Spaces For Rent", "3 Off Street Spaces For Rent", $row['property_Parking']);
	$row['property_Parking'] = str_replace("Off Street 4 Spaces For Rent", "4 Off Street Spaces For Rent", $row['property_Parking']);
	$row['property_Parking'] = str_replace("Off Street 5 Spaces For Rent", "5 Off Street Spaces For Rent", $row['property_Parking']);
	$row['property_Parking'] = str_replace("Off Street 6 Spaces For Rent", "6 Off Street Spaces For Rent", $row['property_Parking']);
	$row['property_Parking'] = str_replace("Off Street 7 Spaces For Rent", "7 Off Street Spaces For Rent", $row['property_Parking']);
	$row['property_Parking'] = str_replace("Off Street 8 Spaces For Rent", "8 Off Street Spaces For Rent", $row['property_Parking']);

	$row['property_Parking'] = str_replace("Off Street 1 Space", "1 Off Street Space Inc.", $row['property_Parking']);
	$row['property_Parking'] = str_replace("Off Street 2 Spaces", "2 Off Street Spaces Inc.", $row['property_Parking']);
	$row['property_Parking'] = str_replace("Off Street 3 Spaces", "3 Off Street Spaces Inc.", $row['property_Parking']);
	$row['property_Parking'] = str_replace("Off Street 4 Spaces", "4 Off Street Spaces Inc.", $row['property_Parking']);
	$row['property_Parking'] = str_replace("Off Street 5 Spaces", "5 Off Street Spaces Inc.", $row['property_Parking']);
	$row['property_Parking'] = str_replace("Off Street 6 Spaces", "6 Off Street Spaces Inc.", $row['property_Parking']);
	$row['property_Parking'] = str_replace("Off Street 7 Spaces", "7 Off Street Spaces Inc.", $row['property_Parking']);
	$row['property_Parking'] = str_replace("Off Street 8 Spaces", "8 Off Street Spaces Inc.", $row['property_Parking']);

	$row['property_Parking'] = str_replace("1 Garage Space Inc", "1 Garage Space Inc.", $row['property_Parking']);
	$row['property_Parking'] = str_replace("2 Garage Spaces Inc", "2 Garage Spaces Inc.", $row['property_Parking']);
	$row['property_Parking'] = str_replace("3 Garage Spaces Inc", "3 Garage Spaces Inc.", $row['property_Parking']);
	$row['property_Parking'] = str_replace("4 Garage Spaces Inc", "4 Garage Spaces Inc.", $row['property_Parking']);
	$row['property_Parking'] = str_replace("5 Garage Spaces Inc", "5 Garage Spaces Inc.", $row['property_Parking']);
	$row['property_Parking'] = str_replace("6 Garage Spaces Inc", "6 Garage Spaces Inc.", $row['property_Parking']);
	$row['property_Parking'] = str_replace("7 Garage Spaces Inc", "7 Garage Spaces Inc.", $row['property_Parking']);
	$row['property_Parking'] = str_replace("8 Garage Spaces Inc", "8 Garage Spaces Inc.", $row['property_Parking']);

//	$row['property_Parking'] = str_replace(",", "", $row['property_Parking']);	

	$park = explode(",", $row['property_Parking']);		
	sort($park);

	$park = array_filter($park, 'strlen' );

	$row['property_Parking'] = implode(",", $park);


	$row['property_Parking'] = str_replace(",", "<br>", $row['property_Parking']);	

	
	// Clean up the kitchen code

	$kitchen = explode(",", $row['property_Kitchen']);		
	sort($kitchen);
	$row['property_Kitchen'] = implode(",", $kitchen);
  	
	$row['property_Kitchen'] = str_replace(",,", ",", $row['property_Kitchen']);
	$row['property_Kitchen'] = str_replace(",,", ",", $row['property_Kitchen']);
	$row['property_Kitchen'] = str_replace(",,", ",", $row['property_Kitchen']);
	$row['property_Kitchen'] = str_replace(",,", ",", $row['property_Kitchen']);
	$row['property_Kitchen'] = str_replace(",,", ",", $row['property_Kitchen']);

	$row['property_Kitchen'] = str_replace(",", "<br>", $row['property_Kitchen']);	

	// clean up tranportation

	$row['property_Transpo'] = str_replace("\"T\",", "", $row['property_Transpo']);
	$row['property_Transpo'] = str_replace("\"T\"", "", $row['property_Transpo']);		
	$row['property_Transpo'] = str_replace(",,", ",", $row['property_Transpo']);
	$row['property_Transpo'] = str_replace(",,", ",", $row['property_Transpo']);
	$row['property_Transpo'] = str_replace(",,", ",", $row['property_Transpo']);
	$row['property_Transpo'] = str_replace(",,", ",", $row['property_Transpo']);
	$row['property_Transpo'] = str_replace(",,", ",", $row['property_Transpo']);
	$row['property_Transpo'] = str_replace(",,", ",", $row['property_Transpo']);
	$row['property_Transpo'] = str_replace(",,", ",", $row['property_Transpo']);
	$row['property_Transpo'] = str_replace(",,", ",", $row['property_Transpo']);	
	$row['property_Transpo'] = str_replace("\"T\"", "", $row['property_Transpo']);		
	$row['property_Transpo'] = str_replace(",,", ",", $row['property_Transpo']);
	$row['property_Transpo'] = str_replace(",,", ",", $row['property_Transpo']);
	$row['property_Transpo'] = str_replace(",,", ",", $row['property_Transpo']);
	$row['property_Transpo'] = str_replace(",,", ",", $row['property_Transpo']);
	$row['property_Transpo'] = str_replace(",,", ",", $row['property_Transpo']);
	$row['property_Transpo'] = str_replace(",,", ",", $row['property_Transpo']);
	$row['property_Transpo'] = str_replace(",,", ",", $row['property_Transpo']);
	$row['property_Transpo'] = str_replace(",,", ",", $row['property_Transpo']);	


	$row['property_Transpo'] = str_replace("Green B", "Green Line (B)", $row['property_Transpo']);	
	$row['property_Transpo'] = str_replace("Green C", "Green Line (C)", $row['property_Transpo']);	
	$row['property_Transpo'] = str_replace("Green D", "Green Line (D)", $row['property_Transpo']);	
	$row['property_Transpo'] = str_replace("Bus 57", "Bus (#57)", $row['property_Transpo']);	
	$row['property_Transpo'] = str_replace("Bus 64", "Bus (#64)", $row['property_Transpo']);	
	$row['property_Transpo'] = str_replace("Bus 65", "Bus (#65)", $row['property_Transpo']);	
	$row['property_Transpo'] = str_replace("Bus 66", "Bus (#66)", $row['property_Transpo']);	
	$row['property_Transpo'] = str_replace("Bus 86", "Bus (#86)", $row['property_Transpo']);	

	$transpo = explode(",", $row['property_Transpo']);		
	sort($transpo);

	$transpo = array_filter($transpo, 'strlen' );

	$row['property_Transpo'] = implode(",", $transpo);
	

	$row['property_Transpo'] = str_replace(",", "<br>", $row['property_Transpo']);


	// Clean up interior features
	$row['property_IntFeats'] = str_replace(",,", ",", $row['property_IntFeats']);
	$row['property_IntFeats'] = str_replace(",,", ",", $row['property_IntFeats']);
	$row['property_IntFeats'] = str_replace(",,", ",", $row['property_IntFeats']);
	$row['property_IntFeats'] = str_replace(",,", ",", $row['property_IntFeats']);	
	$row['property_IntFeats'] = str_replace(",,", ",", $row['property_IntFeats']);
	$row['property_IntFeats'] = str_replace(",,", ",", $row['property_IntFeats']);
	$row['property_IntFeats'] = str_replace(",,", ",", $row['property_IntFeats']);	


	$row['property_IntFeats'] = str_replace("Shows Well,", "", $row['property_IntFeats']);
	$row['property_IntFeats'] = str_replace("Shows Poorly,", "", $row['property_IntFeats']);
	$row['property_IntFeats'] = str_replace("Shows Messy,", "", $row['property_IntFeats']);
	$row['property_IntFeats'] = str_replace("Tenants Are Helpful,", "", $row['property_IntFeats']);
	$row['property_IntFeats'] = str_replace("Dont Ask Tenants Questions,", "", $row['property_IntFeats']);
	$row['property_IntFeats'] = str_replace("Wants Quiet People,", "", $row['property_IntFeats']);
	$row['property_IntFeats'] = str_replace("Located Above Bar,", "", $row['property_IntFeats']);
	$row['property_IntFeats'] = str_replace("Grad/Proffesionals Only,", "", $row['property_IntFeats']);
	$row['property_IntFeats'] = str_replace("Shows Well", "", $row['property_IntFeats']);
	$row['property_IntFeats'] = str_replace("Shows Poorly", "", $row['property_IntFeats']);
	$row['property_IntFeats'] = str_replace("Shows Messy", "", $row['property_IntFeats']);
	$row['property_IntFeats'] = str_replace("Tenants Are Helpful", "", $row['property_IntFeats']);
	$row['property_IntFeats'] = str_replace("Dont Ask Tenants Questions", "", $row['property_IntFeats']);
	$row['property_IntFeats'] = str_replace("Wants Quiet People", "", $row['property_IntFeats']);
	$row['property_IntFeats'] = str_replace("Located Above Bar", "", $row['property_IntFeats']);
	$row['property_IntFeats'] = str_replace("Grad/Proffesionals Only", "", $row['property_IntFeats']);

	// Special section to handle utilities - extract them from intfeats. be careful of 'heat' ----------------------------------------
	$utility = array();

	$pos = strpos($row['property_IntFeats'], "Heat and Hot Water");
	if ($pos !== false) {
		$utility[] = "Heat and Hot Water Included";
		$row['property_IntFeats'] = str_replace("Heat and Hot Water,", "", $row['property_IntFeats']);
		$row['property_IntFeats'] = str_replace("Heat and Hot Water", "", $row['property_IntFeats']);
	}

	$pos = strpos($row['property_IntFeats'], "Hot Water");
	if ($pos !== false) {
		$utility[] = "Hot Water Included";
		$row['property_IntFeats'] = str_replace("Hot Water,", "", $row['property_IntFeats']);
		$row['property_IntFeats'] = str_replace("Hot Water", "", $row['property_IntFeats']);		
	}	

	$pos = strpos($row['property_IntFeats'], "Oil Heat");
	if ($pos !== false) {
		$utility[] = "Oil Heat";
		$row['property_IntFeats'] = str_replace("Oil Heat,", "", $row['property_IntFeats']);
		$row['property_IntFeats'] = str_replace("Oil Heat", "", $row['property_IntFeats']);		
	}		

	$pos = strpos($row['property_IntFeats'], "Gas Heat");
	if ($pos !== false) {
		$utility[] = "Gas Heat";
		$row['property_IntFeats'] = str_replace("Gas Heat,", "", $row['property_IntFeats']);
		$row['property_IntFeats'] = str_replace("Gas Heat", "", $row['property_IntFeats']);		
	}		

	$pos = strpos($row['property_IntFeats'], "Gas Included");
	if ($pos !== false) {
		$utility[] = "Gas Included";
		$row['property_IntFeats'] = str_replace("Gas Included,", "", $row['property_IntFeats']);
		$row['property_IntFeats'] = str_replace("Gas Included", "", $row['property_IntFeats']);		
	}		

	$pos = strpos($row['property_IntFeats'], "Electricity Included");
	if ($pos !== false) {
		$utility[] = "Electricity Included";
		$row['property_IntFeats'] = str_replace("Electricity Included,", "", $row['property_IntFeats']);
		$row['property_IntFeats'] = str_replace("Electricity Included", "", $row['property_IntFeats']);		
	}			

	$pos = strpos($row['property_IntFeats'], "All Utilities Included");
	if ($pos !== false) {
		$utility[] = "All Utilities Included";
		$row['property_IntFeats'] = str_replace("All Utilities Included,", "", $row['property_IntFeats']);
		$row['property_IntFeats'] = str_replace("All Utilities Included", "", $row['property_IntFeats']);		
	}			

	$pos = strpos($row['property_IntFeats'], "Electric Heat");
	if ($pos !== false) {
		$utility[] = "Electric Heat";
		$row['property_IntFeats'] = str_replace("Electric Heat,", "", $row['property_IntFeats']);
		$row['property_IntFeats'] = str_replace("Electric Heat", "", $row['property_IntFeats']);		
	}		

	$pos = strpos($row['property_IntFeats'], "Heat");
	if ($pos !== false) {
		$utility[] = "Heat Included";
		$row['property_IntFeats'] = str_replace("Heat,", "", $row['property_IntFeats']);
		$row['property_IntFeats'] = str_replace("Heat", "", $row['property_IntFeats']);		
	}		

	sort($utility);
	$utility_text = implode("<br>", $utility);



	// end utilities section ----------------------------------------------------------------------------------------------------------


	$row['property_IntFeats'] = str_replace("Heat,", "Heat Inclued,", $row['property_IntFeats']);

	$row['property_IntFeats'] = str_replace("Fireplace - Decorative,", "Fireplace (Decorative),", $row['property_IntFeats']);

	$intfeat = explode(",", $row['property_IntFeats']);		
	sort($intfeat);
	$row['property_IntFeats'] = implode(",", $intfeat);

	$row['property_IntFeats'] = str_replace(",", "<br>", $row['property_IntFeats']);	

	// Clean up interior features
	$row['property_ExtFeats'] = str_replace(",,", ",", $row['property_ExtFeats']);
	$row['property_ExtFeats'] = str_replace(",,", ",", $row['property_ExtFeats']);
	$row['property_ExtFeats'] = str_replace(",,", ",", $row['property_ExtFeats']);
	$row['property_ExtFeats'] = str_replace(",,", ",", $row['property_ExtFeats']);
	$row['property_ExtFeats'] = str_replace(",,", ",", $row['property_ExtFeats']);
	$row['property_ExtFeats'] = str_replace(",,", ",", $row['property_ExtFeats']);

	$extfeat = explode(",", $row['property_ExtFeats']);		
	sort($extfeat);
	$row['property_ExtFeats'] = implode(",", $extfeat);


	$row['property_ExtFeats'] = str_replace(",", "<br>", $row['property_ExtFeats']);		

	if ($row['status_Title'] == "Active") {
		$status_display = "<span style=\"color: green;\">Active</span>";
	}

	if ($row['status_Title'] == "Rented") {
		$status_display = "<span style=\"color: red;\">Unavailable</span>";
	}

	if ($row['status_Title'] == "Pending") {
		$status_display = "<span style=\"color: red;\">Unavailable</span>";
	}

	$property_LPayingFee = $row['property_LPayingFee'];

	$property_LPayingFee = str_replace("None", "No", $property_LPayingFee);
	
	if ($property_LPayingFee) {
		if ($property_LPayingFee == 'No'){
			$fee = "Tenants pay full fee";
		}
		else{
		$fee = "landlord pays ".strtolower($property_LPayingFee)." fee";}
	} else {
		$fee = "N/A";
	}
		
		$property_ID=$row['property_ID'];
		$property_StreetNum=$row['property_StreetNum'];
		$property_StreetName=$row['property_StreetName']; 
		$property_City=$row['property_City'];
		$property_State=$row['property_State']; 
		$property_ListPrice=$row['property_ListPrice']; 
		$property_HideListPrice=$row['property_HideListPrice'];
		$property_HideStreet=$row['property_HideStreet'];
		$property_Title=$row['property_Title'];
		$property_Details=$row['property_Details'];
		$property_Bedrooms=$row['property_Bedrooms']; 
		$property_Bathrooms=$row['property_Bathrooms'];
		$property_LivingSize=$row['property_LivingSize'];
		$property_Meter=$row['property_Meter'];
		$status_Title=$row['status_Title']; 
		$type_Title=$row['type_Title']; 
		$property_LeasePrice=translate_roomforrentprice($row['property_LeasePrice'],$row['property_Bedrooms'],$row['property_RoomForRents']);
		$property_Zip=$row['property_Zip']; 
		$property_PhotosObtainedBy=$row['property_PhotosObtainedBy']; 
		$property_Floors=$row['property_Floors'];
		$property_FloorRestrict=$row['property_FloorRestrict'];
		$property_Laundry=$row['property_Laundry'];
		$property_AptNum=$row['property_AptNum']; 
		$property_College=$row['property_College'];
		$property_AvailableDay=$row['property_AvailableDay'];
		$property_AvailableYear=$row['property_AvailableYear'];
		$property_Available=$row['property_Available'];
		$property_SubLoc=$row['property_SubLoc'];
		$property_ParkingRent=$row['property_ParkingRent']; 
		$property_AvailableNow =$row['property_AvailableNow ']; 
		$property_CreatedDate = $row['property_CreatedDate'];	
		
	}
	
	$stmt_user = $pdo->prepare("
	SELECT user_Name,user_Email,user_Phone,user_ID
	FROM ap_users 
	WHERE user_Type = '0' AND
	user_Name != 'Fiona Russo' AND 
	user_Name != 'Amber' AND 
	user_Name = :user_Name
	");
	
	$stmt_user->execute(
	['user_Name' => $property_PhotosObtainedBy]); 
	$datauser = $stmt_user->fetchAll();
	
	
	
	$user_Name = "Preview Properties";
	$user_Phone = "(617) 787-0700 ";
	$user_Email = "info-a@previewbostonrealty.com";
	
	foreach ($datauser as $rowuser) {
		
		if(  preg_match( '/^\+\d(\d{3})(\d{3})(\d{4})$/', $rowuser['user_Phone'],  $matches ) )
		{
			$user_Phone = $matches[1] . '-' .$matches[2] . '-' . $matches[3];
			
		}
				
		$user_Name = $rowuser['user_Name'];
		$user_Email = $rowuser['user_Email'];
		$user_ID = $rowuser['user_ID'];
		
		
	}
	
	
	
	if($property_isset) {
		?>
		
	<link rel="stylesheet" type="text/css" href="<?php echo THEME_DIR ."/assets/front/css/propertycss.css?version=1" ?>">
		
		<section class="content">

	<?php hu_get_template_part('parts/page-title'); ?>

	<div class="pad group">

		<div class="block_content">
		<section id="main-slider-section" class="main-slider-section mb-30 clearfix">
		<?php
		$star = get_savestatusprop($pdo,array($property_ID));
		if (in_array($property_ID, $star)) {
				$roommate_proppref_issaved= "fas";
			} else {
				$roommate_proppref_issaved = "far";
			}
		?>
		<a class="save_room" data-value="<?php echo $property_ID;?>" style = "float:left;padding:20px;" href="#">
			<i class="<?php echo $roommate_proppref_issaved; ?> fa-star">
			</i><span> Save</span>
			</a>
          <div style = "float:right;"><?php echo get_datestatus($property_CreatedDate);?></div>

		  <div class="main-slider owl-carousel owl-theme owl-loaded owl-drag">
                
                <!-- /.item -->
                
                <!-- /.item -->
                
                <!-- /.item -->
            <div class="owl-stage-outer"><div class="owl-stage" style="">
			<div class="owl-item cloned" style="width: 397px;">
			<div class="owl-nav disabled">
	
			</div>
			</div>
	
			
			
			
			<div class="item">
                    <div class="row">
					 <div  class="col l6 m6">
                            <div class="item-child-left left-align first">
                                <h2 class="hi"><?php echo $property_City . ", MA - ".$property_SubLoc; ?></h2>
                                <p class="name"><?php echo "$" .$property_LeasePrice . "/month"; ?></p>
								<p class="name"><?php echo "Reference #: " .$property_ID; ?></p>
								<p class="name"><?php echo "Rental Status: ". $status_display; ?></p>
                            </div>
                            <!-- /.item-child-left -->
                        </div>
						<div class="item-child-left left-align second">
						<p><?php echo "Available: ".$property_Available; ?></p>
						<p><?php echo "Bedrooms: ".$property_Bedrooms; ?></p>
						<p><?php echo "Bathrooms: ".$property_Bathrooms; ?></p>
						<p><?php echo "Pets: ".$pettext; ?></p>
						<p><?php echo "Fee: ".$fee; ?></p>
						<p><?php echo "Laundry: ".$row['property_Laundry']; ?></p>
					
						</div>
                       
                        <!-- coll6 -->

                  

                    </div>
                    <!-- row -->
             
                        <!-- coll6 -->

            </div>
                    <!-- row -->
               
		
				
				</div>
		
				</div>
				</div>
	
            <!-- /.main-slider -->

        </section>
		<div data-scroll="1" class=" aboutme-section sec-p100-bg-bsp mb-30 clearfix" id="img-container">
		Drag to show more
		<div class="siema">
			<?php
			foreach($photo_file as $pfile){
				?>
			<div>
				<img src="<?php echo $pfile; ?>">
            </div>
			<?php
			}
			?>
			</div>
            <!-- /.success -->
        </div>
		
		<div data-scroll="1" class="aboutme-section sec-p100-bg-bs mb-30 clearfix" id="about">
            <div class="Section-title">
                <h2>
					<i class="fa fa-user-o" aria-hidden="true"></i>
					contact an agent
				</h2>
                <span>contact an agent</span>
                <p>
                   
                </p>
            </div>
            <!-- /.Section-title -->

            <div class="personal-details-area">
                <div class="row">
                    <div class="col l6 m12 s12">
                        <div class="personal-details-left">
                            <ul class="service-list ul-li">
                              
                                <li class="website">
                                    <i class="fa fa-globe" aria-hidden="true"></i>
									 <span class="service-info"><?php echo format_phone($user_Email); ?></span>
                                    <span style = "font-weight:bold" class="service-name">Email Agent</span>
                                    <a href="#" class="more"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                </li>
                               <!-- <li class="softwares">
                                    <i class="fa fa-desktop" aria-hidden="true"></i>
                                    <span class="service-name">Msg. Agent</span>
                                    <a href="#" class="more"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                </li>-->
                                <li class="applications">
                                    <i class="fa fa-mobile" aria-hidden="true"></i>
									 <span class="service-info"><?php echo format_phone($user_Phone); ?></span>
                                    <span style = "font-weight:bold" class="service-name">Call Agent</span>
                                    <a href="#" class="more"><i class="fa fa-plus" aria-hidden="true"></i></a>
                                </li>
                            </ul>
                            <!-- /.service-list -->
                        </div>
                        <!-- /.personal-details-left -->
                    </div>
                    <!-- colm6 -->

                   
					<div class="col l6 m12 s12">
                        <div class="personal-details-right" >
                            <h2 class="title">more information</h2>
                            <table class = "detail-table">
                                <tbody class = "table-info">
                                    <tr>
                                        <td class="td-w25">Parking</td>
                                       
                                        <td class="td-w65"><?php echo $row['property_Parking']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="td-w25">Utilities:</td>
                                    
                                        <td class="td-w65"><?php echo$utility_tex; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="td-w25">Kitchen</td>
                                      
                                        <td class="td-w65"><?php echo $row['property_Kitchen']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="td-w25">Mass Transit</td>
                                     
                                        <td class="td-w65"><?php echo $row['property_Transpo']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="td-w25">Interior Features</td>
                                       
                                        <td class="td-w65"><?php echo $row['property_IntFeats']; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="td-w25">Exterior Features</td>
                                       
                                        <td class="td-w65"><?php echo $row['property_ExtFeats']; ?></td>
                                    </tr>
                                   


                                </tbody>
                            </table>
                        </div>
                        <!-- /.personal-details-right -->
                    </div>
					 <div class="col l6 m12 s12" >
                        <div class="personal-details-right">
                            <h2 class="title">agent information</h2>
                            <table class = "detail-table">
                                <tbody class = "table-info">
                                    <tr>
                                        <td class="td-w25">Name:</td>
                                       
                                        <td class="td-w65"><?php echo $user_Name; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="td-w25">Phone:</td>
                                       
                                        <td class="td-w65"><?php echo $user_Phone; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="td-w25">Email:</td>
                                       
                                        <td class="td-w65"><?php echo $user_Email; ?></td>
                                    </tr>
                                 
                                    


                                </tbody>
                            </table>
                        </div>
                        <!-- /.personal-details-right -->
                    </div>
                    <!-- colm6 -->
                </div>
                <!-- row -->
            </div>
            <!-- /.personal-details-area -->

            <div class="success">
                <div class="success-child-right">
                    <a href="#" onclick = "emailer(2,<?php echo $property_ID; ?>);" class="hire-me waves-effect">
                        <i class="fa fa-envelope-o " aria-hidden="true"></i> contact agent
                    </a>
                </div>
                <!-- /.success-child-left -->
               
                <!-- /.success-child-right -->
            </div>
            <!-- /.success -->
        </div>
		
		<div data-scroll="2" class="my-skill-section sec-p100-bg-bs mb-30 clearfix" id="skill">
       

            <div class="professional-skills-area">
               
            <!-- /.professional-skills-area -->
<script type='text/javascript'>
var ws_address = "<?php echo $property_StreetName; ?> <?php echo $property_City;?>, MA, <?php echo $property_Zip;?>";


var ws_wsid = '679ae46401c4c350a9db3e4105356f50';

var ws_format = 'tall';
var ws_width = '600';
var ws_height = '700';
</script><style type='text/css'>#ws-walkscore-tile{position:relative;text-align:left}#ws-walkscore-tile *{float:none;}</style><div id='ws-walkscore-tile'></div><script type='text/javascript' src='http://www.walkscore.com/tile/show-walkscore-tile.php'></script>
        
            <!-- /.languages-skills -->

        </div>
		            </div>

	</div><!--/.pad-->

</section><!--/.content-->
		<?php
		
		
	} else {
		echo ("This ad does not exist.");
		die();
	}
	?>
	<script src="<?php echo THEME_DIR; ?>/assets/front/siema/siema.min.js"> </script>
	<script>
	new Siema({
  selector: '.siema',
  duration: 2000,
  easing: 'ease-out',
  perPage: 1,
  startIndex: 0,
  draggable: true,
  multipleDrag: true,
  threshold: 20,
  loop: true,
  rtl: false,
  onInit: () => {},
  onChange: () => {},
});
	</script>
	<div id = "main-popup">
			
</div>
<?php get_sidebar(); ?>

<?php get_footer(); ?>