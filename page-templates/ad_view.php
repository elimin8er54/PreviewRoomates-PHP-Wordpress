<?php
/*
Template Name: View Ad
*/
?>
<?php get_header();
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
	roommate_ad_id =:roommate_ad_id
	
	LIMIT 1;");
	

	$stmt->execute(
	['roommate_ad_id' => $_GET['ad_id']]); 
	$data = $stmt->fetchAll();
	
	
	$ad_isset = false;
	foreach ($data as $row) {
		$ad_isset = true;

			
		if(isset($_SESSION['roommate_user_id'])) {
			$roommate_user_email=$row['roommate_user_email']; 
		
		} else {
			$roommate_user_email="Log in to Send Email"; 
			
		}
		
		if($row['roommate_ad_showphone']==1) {
			$roommate_ad_phone=format_phone($row['roommate_ad_phone']); 
		} else {
			$roommate_ad_phone = "Ad has phone hidden";
		}
		
				
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
		$roommate_user_gender=$row['roommate_user_gender']; 
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
		$roommate_user_name=$row['roommate_user_name'];
		
		
		if(!empty($row['roommate_user_profilepic'])) {
			$roommate_user_profilepic = THEME_DIR."/assets/front/img/profiles/".$row['roommate_user_profilepic'];
		} else if($row['roommate_user_profilepic']== "M") {
			$roommate_user_profilepic =  THEME_DIR."/assets/front/img/img_avatar.png";
		} else if($row['roommate_user_profilepic']== "F") {
			$roommate_user_profilepic =  THEME_DIR."/assets/front/img/img_avatar2.png";
		}else if($row['roommate_user_profilepic']== "O") {
			$roommate_user_profilepic =  THEME_DIR."/assets/front/img/img_avatar3.jpg";
		} else {
			$roommate_user_profilepic =  THEME_DIR."/assets/front/img/img_avatar3.jpg";
		}
		
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
	
	
	
	if($ad_isset) {
		?>
		<link rel="stylesheet" type="text/css" href="<?php echo THEME_DIR ."/assets/front/css/adcss.css?version=1" ?>">

		
		<section class="content">

	<?php hu_get_template_part('parts/page-title'); ?>

	<div class="pad group">

		<div class="block_content">
		<section id="main-slider-section" class="main-slider-section mb-30 clearfix">

		<?php
		$star = get_savestatus($pdo,array($roommate_ad_id));
		if (in_array($roommate_ad_id, $star)) {
				$roommate_adpref_issaved= "fas";
			} else {
				$roommate_adpref_issaved = "far";
			}
		?>
		<a class="save_roommate" data-value="<?php echo $roommate_ad_id;?>" style = "float:left;padding:20px;color:white;" href="#">
			<i class="<?php echo $roommate_adpref_issaved; ?> fa-star">
			</i><span> Save</span>
			</a>
		
            <div style = " border-radius: 25px;" class="main-slider owl-carousel owl-theme owl-loaded owl-drag">
                
                <!-- /.item -->
                
                <!-- /.item -->
                
                <!-- /.item -->
            <div class="owl-stage-outer"><div class="owl-stage" style="">
			<div class="owl-item cloned" style="width: 397px;">
			<div class="owl-nav disabled">
	
			</div>
			</div>
	
			
			
			
			<div class="item">
                    <div  class="row">
						<div style = "float:left;width:30%;margin-top:3px;" class="item-child-left left-align">
						<img id = "profile-pic-ad" src = "<?php echo 	$roommate_user_profilepic; ?>" >
						</div>
                        <div  class="col l6 m6">
                            <div class="item-child-left left-align">
							<div style = "background-color:red">
                                <h2 style = "color:white" class="hi">hello</h2>
                                <p style = "color:white" class="name">My name is  </p>
								</div>
								<p class = "name"><?php echo show_lastname($roommate_user_name,$roommate_ad_showlastname); ?> </p>
								<div style = "background-color:red">
                                <small style = "color:white" class="position mb-30">&amp; <?php echo $roommate_ad_title; ?></small>
								</div>

                               <!-- <a href="http://www.webstrot.com/html/myporto/light_version/index.html#!" class="custom-btn waves-effect waves-light">
                                    <i class="fa fa-picture-o" aria-hidden="true"></i> view protfolio
                                </a>-->
                            </div>
                            <!-- /.item-child-left -->
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
		<div data-scroll="1" class="aboutme-section sec-p100-bg-bs mb-30 clearfix" id="about">
		<?php
				echo get_datestatus($roommate_ad_createdate);
				?>
            <div class="Section-title">
                <h2 style = "">
					<i class="fa fa-user-o" aria-hidden="true"></i>
					about me
				</h2>
			
                <span>about me</span>
                <p>
                   <?php
				   echo $roommate_ad_description;
				   ?>
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
									  <span class="service-info"><?php echo $roommate_user_email; ?></span>
                                    <span class="service-name">EMail Advertiser</span>
                                    <a href="#" class="more "onclick = "emailer(<?php echo $roommate_ad_userid; ?>,1);"><i class=" fa fa-plus" aria-hidden="true"></i></a>
                                </li>
                                
                                <li class="applications">
                                    <i class="fa fa-mobile" aria-hidden="true"></i>
									  <span class="service-info"><?php echo $roommate_ad_phone; ?></span>
                                    <span class="service-name">Call Advertiser</span>
                                    <!--<a href="#" class="more"><i class="fa fa-plus" aria-hidden="true"></i></a>-->
                                </li>
                            </ul>
                            <!-- /.service-list -->
                        </div>
                        <!-- /.personal-details-left -->
                    </div>
                    <!-- colm6 -->

                    <div class="col l6 m12 s12" >
                        <div class="personal-details-right">
                            <h2 class="title">personal details</h2>
                            <table class = "detail-table">
                                <tbody>
                                    <tr>
                                        <td class="td-w25">Name</td>
                                        <td class="td-w10">:</td>
                                        <td class="td-w65"><?php echo show_lastname($roommate_user_name,$roommate_ad_showlastname); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="td-w25">Age</td>
                                        <td class="td-w10">:</td>
                                        <td class="td-w65"><?php echo $roommate_ad_age; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="td-w25">Smoker?</td>
                                        <td class="td-w10">:</td>
                                        <td class="td-w65"><?php echo translate_smoking($roommate_ad_issmoker); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="td-w25">Pets?</td>
                                        <td class="td-w10">:</td>
                                        <td class="td-w65"><?php echo translate_pets($roommate_ad_haspets); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="td-w25">Occupation</td>
                                        <td class="td-w10">:</td>
                                        <td class="td-w65"><?php echo translate_occupation($roommate_ad_occupation); ?></td>
                                    </tr>
									<tr>
                                        <td class="td-w25">Interests</td>
                                        <td class="td-w10">:</td>
                                        <td class="td-w65"><?php  
										foreach ($roommate_interest_content as $interests) {
											echo $interests . "</br>";
										}
										?>
										
										</td>
                                    </tr>
									<tr>
                                        <td class="td-w25">Gender</td>
                                        <td class="td-w10">:</td>
                                        <td class="td-w65"><?php echo translate_gender($roommate_user_gender); ?></td>
                                    </tr>
									<tr>
                                        <td class="td-w25">Looking in</td>
                                        <td class="td-w10">:</td>
                                        <td class="td-w65"><?php  
										foreach ($roommate_citypref_city as $cities) {
											echo $cities . "</br>";
										}
										?></td>
                                    </tr>
									<tr>
                                        <td class="td-w25">Availability</td>
                                        <td class="td-w10">:</td>
                                        <td class="td-w65"><?php echo date("M-d-Y",strtotime($roommate_ad_moveinavailability)); ?></td>
                                    </tr>
									

                                </tbody>
                            </table>
                        </div>
                        <!-- /.personal-details-right -->
                    </div>
					<div class="col l6 m12 s12">
                        <div class="personal-details-right">
                            <h2 class="title">personal preferences</h2>
                            <table class = "detail-table">
                                <tbody>
                                    <tr>
                                        <td class="td-w25">Smokers OK?</td>
                                        <td class="td-w10">:</td>
                                        <td class="td-w65"><?php echo translate_smokingpref($roommate_ad_smokerok); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="td-w25">Pets OK?</td>
                                        <td class="td-w10">:</td>
                                        <td class="td-w65"><?php echo translate_petspref($roommate_ad_petsok); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="td-w25">Occupation?</td>
                                        <td class="td-w10">:</td>
                                        <td class="td-w65"><?php echo translate_occupationpref($roommate_ad_occupationpref); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="td-w25">Min Age?</td>
                                        <td class="td-w10">:</td>
                                        <td class="td-w65"><?php echo $roommate_ad_minagepref; ?></td>
                                    </tr>
                                    <tr>
                                        <td class="td-w25">Max Age?</td>
                                        <td class="td-w10">:</td>
                                        <td class="td-w65"><?php echo $roommate_ad_maxagepref; ?></td>
                                    </tr>
									<tr>
                                        <td class="td-w25">Amenities</td>
                                        <td class="td-w10">:</td>
                                        <td class="td-w65"><?php  
										foreach ($roommate_amenity_content as $amenity) {
											echo translate_amenities($amenity) . "</br>";
										}
										?></td>
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
                <div class="success-child-left">
                    <i class="fa fa-picture-o" aria-hidden="true"></i>
                    <p>
                        Send me a message if you want to chat
                    </p>
                </div>
                <!-- /.success-child-left -->
                <div class="success-child-right">
                    <a href="#" onclick = "emailer(1);" class="hire-me waves-effect">
                        <i class="fa fa-envelope-o " aria-hidden="true"></i> contact agent
                    </a>
                </div>
                <!-- /.success-child-right -->
            </div>
            <!-- /.success -->
			
        </div>


	</div><!--/.pad-->

</section><!--/.content-->
<div id = "main-popup">
			
</div>
		<?php
		
		
	} else {
		echo ("This ad does not exist.");
		die();
	}
	?>
<?php get_sidebar(); ?>

<?php get_footer(); ?>