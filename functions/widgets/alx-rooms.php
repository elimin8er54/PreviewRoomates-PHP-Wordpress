<?php
/*
	AlxVideo Widget

	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html

	Copyright: (c) 2019(shaunt)

		@package AlxRooms
		@version 1.0
*/


class AlxRooms extends WP_Widget {
private $Dbobj; 

/*  Constructor
/* ------------------------------------ */
	function __construct() {
		$this->$Dbobj = new DbConnection();
		$this->$Dbobj->connect();
		parent::__construct(
      'alxrooms',
      __('Preview Rooms', 'hueman'),
      array(
        'description' => __('Display preview properties room for rents.', 'hueman'),
        'classname' => 'widget_hu_rooms'
      )
    );
	
	}

  public function hu_get_defaults() {
	
    return array(
      'title'       => '',
    // Video
      'amount'     => '5',
    );
  }


/*  Widget
/* ------------------------------------ */
	public function widget($args, $instance) {

		$preview_photos = "http://previewbostonrealty.com/";
		$property_stmt = 
		$this->$Dbobj->getdbconnect()->query (
		"SELECT 
		property_ID,
		property_City,
		property_LeasePrice,
		property_LPayingFee,
		property_Bedrooms,
		property_Zip,
		property_AvailableTS,
		photo_Thumb,
		property_RoomForRent,
		property_CreatedDate,
		property_Kitchen,
		property_IntFeats,
		property_Parking,
		property_Pets,
		property_ExtFeats
		FROM ap_property
		LEFT JOIN ap_photo ON photo_PropertyID = property_ID
		WHERE (property_Bedrooms > 1 OR property_RoomForRent = 1) AND photo_RankOrder = 0 AND property_StatusID = 1 ORDER BY property_NumPhotos DESC   LIMIT ".$instance['amount'].";");
	
		foreach ($property_stmt as $row){
		if(!isset($property_ID[$row['property_ID']])) {
			
			$property_Kitchen[$row['property_ID']] = $row['property_Kitchen'];	
			$property_IntFeats[$row['property_ID']] = $row['property_IntFeats'];	
			$property_Parking[$row['property_ID']] = $row['property_Parking'];	
			$property_Pets[$row['property_ID']] = $row['property_Pets'];	
			$property_ExtFeats[$row['property_ID']] = $row['property_ExtFeats'];	
			
			$property_CreatedDate[$row['property_ID']] = $row['property_CreatedDate'];	
			$property_City[$row['property_ID']] = $row['property_City'];	
			$property_ID[$row['property_ID']] = $row['property_ID'];	
			$photo_Thumb[$row['property_ID']] = $row['photo_Thumb'];
			
				$property_LeasePrice[$row['property_ID']] = translate_roomforrentprice( $row['property_LeasePrice'],$row['property_Bedrooms'],$row['property_RoomForRent']);
			
			$property_Zip[$row['property_ID']] = $row['property_Zip'];
			$property_Bedrooms[$row['property_ID']] = $row['property_Bedrooms'];
			if(!empty($row['photo_Thumb'])) {
				$photo_Thumb[$row['property_ID']] = "http://previewbostonrealty.com/".$row['photo_Thumb'];
			} else {
				$photo_Thumb[$row['property_ID']] = HU_BASE."assets/front/img/thumb-small.png";
			}
			if($row['property_LPayingFee'] == "None") {
				$property_LPayingFee[$row['property_ID']] = "Full Fee";
			}else if($row['property_LPayingFee'] == "Full") {
				$property_LPayingFee[$row['property_ID']] = "No Fee";
			}else if($row['property_LPayingFee'] == "Half") {
				$property_LPayingFee[$row['property_ID']] = "Half Fee";
			} else {
				$property_LPayingFee[$row['property_ID']] = $row['property_LPayingFee'];
			}
			
			
		}
			
		}
		
		$stars = get_savestatusprop($this->$Dbobj->getdbconnect(),$property_ID);
		
		
		
		
	
		
		foreach($property_ID as $thepid) {
			
			if (in_array($thepid, $stars)) {
				$roommate_proppref_issaved[$thepid] = "fas";
			} else {
				$roommate_proppref_issaved[$thepid] = "far";
			}
		}
		
		extract( $args );
		$instance['title'] = isset( $instance['title'] ) ? $instance['title'] : '';
		$title = apply_filters('widget_title',$instance['title']);
		$output = $before_widget."\n";
		if($title)
			$output .= $before_title.$title.$after_title;
		ob_start();


		// The widget
		if ( !empty($instance['amount']) ) {
			$amount = $instance['amount'];
		}
		else {
			$amount = 5;
		}
		
		
		?>
		<style>
.room-container{
	
	    border: 1px solid #D5D5D5;
    margin-bottom: 24px;
    border-radius: 6px;
	    box-sizing: border-box;
    padding: 8px 16px;
    position: relative;
    max-width: 438px;
	    background: #F5F5F5;
display: inline-block;
	width:100%;
}
.room-top-left{
	display: inline-block;
  float: left;
  width: 50%
}
.room-top-right{
	display: inline-block;
  float: right;
  
}
.room-mid{
	text-overflow: ellipsis;
	margin-top:10px;
}
.room-mid-left{
	display: inline-block;
  
  width: 40%
}
.room-mid-right{
	
	 font-size: 13px;
    font-size: 0.866rem;
    border-top: 1px solid;
    border-color: #5E5E5E;
	display: inline-block;
  float: right;
 
  width: 58%
   
   
    
 
}

.room-top-left-info{
	display: inline-block;
  float:left;
  width: 50%
}
.room-top-right-info{
	display: inline-block;
  text-align:right;
  width: 50%
}
.room-bot-left{
	display: inline-block;
  float: left;
  width: 50%
}
.room-bot-right{
display: inline-block;
  float: right;
 
}
.thumb-image{
width:100%;
height:auto;
 
}
.new{
	font-size: 10px;
    font-size: 0.667rem;
    padding: 2px 4px;
    font-weight: 500;
    text-transform: uppercase;
    color: #FFF;
    display: inline-block;
    padding: 0 4px;
    line-height: 1.5;
    background: #FF9500 !important;
    border: 1px solid #FF9500;
    box-sizing: border-box;
    min-width: 70px;
    text-align: center;
	margin-top:10px;
}


</style>
		<div class="room-main-container">
		<?php
		
		$room_counter = 0;
	foreach($property_ID as $pid) {
		$room_description = "";
		$room_description .= $property_IntFeats[$pid] . "\n";
							$property_Parking[$pid] . "\n";
							$property_Pets[$pid] . "\n";
							$property_ExtFeats[$pid] . "\n";
							$property_Kitchen[$pid] . "\n";
			
		if($room_counter < $amount){
			?>
			
			<div class="room-container">
			<div class = "room-top">
			<div class = "room-top-left">
			<p>
			<?php echo $property_City[$pid] . " (".$property_Zip[$pid].")"; ?>
			</p>
			</div>
			<div class = "room-top-right">
			<p><?php echo "$".$property_LeasePrice[$pid]; ?>/month</p>
			
			</div>
			<div class = "room-top-left-info">
			<p><?php echo $property_Bedrooms[$pid] . " Bedroom Property"; ?></p>
			</div>
			<div class = "room-top-right-info">
			<p><?php echo $property_LPayingFee[$pid]; ?></p>
			</div>
			
			</div>
			
			<div class = "room-mid">
			<a href = "<?php echo THEME_DIR?>/word/view-property/?property_id=<?php echo $pid; ?>">
			<div class = "room-mid-left">
			<img class = "thumb-image" src = "<?php echo $photo_Thumb[$pid]; ?>">
			</div>
			</a>
			<div class = "room-mid-right">
			<?php echo $room_description; ?>
			</div>
			</div>
			<div class = "room-bot">
			<div class = "room-bot-left">
			<?php echo get_datestatus($property_CreatedDate[$pid]);?>
			</div>
			<div class = "room-bot-right">
			<a class="save_room" data-value="<?php echo $pid;?>" style = "float:left;padding:20px;" href="#">
			<i class="<?php echo $roommate_proppref_issaved[$pid]; ?> fa-star">
			</i><span> Save</span>
			</a>
			</div>
			</div>
			</div>
			
			<?php
			$room_counter++;
		}
			
			}
		?>
		</div>
<?php
		$output .= ob_get_clean();
		$output .= $after_widget."\n";
		echo $output;
	}

/*  Widget update
/* ------------------------------------ */
	public function update($new,$old) {
		$instance = $old;
		$instance['title'] = strip_tags($new['title']);
	// Video
		$instance['amount'] = strip_tags($new['amount']);
		return $instance;
	}

/*  Widget form
/* ------------------------------------ */
	public function form($instance) {
		// Default widget settings
		$defaults = $this -> hu_get_defaults();
		$instance = wp_parse_args( (array) $instance, $defaults );
?>

	<style>
	.widget .widget-inside .alx-options-rooms .postform { width: 100%; }
	.widget .widget-inside .alx-options-rooms p { margin: 3px 0; }
	.widget .widget-inside .alx-options-rooms hr { margin: 20px 0 10px; }
	.widget .widget-inside .alx-options-rooms h4 { margin-bottom: 10px; }
	</style>

	<div class="alx-options-rooms">
	
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>">Title:</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
		</p>

	<h4>Amount to Display</h4>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id("amount") ); ?>">Amount</label>
			<input style="width:100%;" id="<?php echo esc_attr( $this->get_field_id("amount") ); ?>" name="<?php echo esc_attr( $this->get_field_name("amount") ); ?>" type="text" value="<?php echo esc_attr( $instance["amount"] ); ?>" />
		</p>

	
	</div>
<?php

}

}

/*  Register widget
/* ------------------------------------ */
if ( ! function_exists( 'hu_register_widget_rooms' ) ) {

	function hu_register_widget_rooms() {
		register_widget( 'AlxRooms' );
	}

}
add_action( 'widgets_init', 'hu_register_widget_rooms' );
