<?php
/*
	AlxVideo Widget

	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html

	Copyright: (c) 2019(shaunt)

		@package AlxRoommates
		@version 1.0
*/


class AlxRoommates extends WP_Widget {
private $Dbobj; 

/*  Constructor
/* ------------------------------------ */
	function __construct() {
		$this->$Dbobj = new DbConnection();
		$this->$Dbobj->connect();
		parent::__construct(
      'alxroommates',
      __('Preview Roommates', 'hueman'),
      array(
        'description' => __('Display roommates.', 'hueman'),
        'classname' => 'widget_hu_roommates'
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

		if(isset($_SESSION['roommate_user_id'])) {
			$show_saved = "AND roommate_ad_userid = ".$_SESSION['roommate_user_id'];
		} else {
			$show_saved = "";
		}

		$preview_photos = "http://previewbostonrealty.com/";
		$property_stmt = 
		$this->$Dbobj->getdbconnect()->query (
		"SELECT 
		roommate_ad_budget,
		roommate_user_gender,
		roommate_ad_age,
		roommate_user_name,
		roommate_ad_roomsizepref,
		roommate_ad_title,
		roommate_ad_description,
		roommate_ad_occupation,
		roommate_ad_id,
		roommate_photo_thumb,
		roommate_user_profilepic,
		roommate_ad_createdate,
		roommate_user_id,
		roommate_ad_showlastname
		FROM roommate_ads
		JOIN roommate_users ON roommate_user_id = roommate_ad_userid
		LEFT JOIN roommate_photos on roommate_photo_adid = roommate_ad_id
		WHERE 1=1
		ORDER BY roommate_ad_createdate DESC
		;");
	$roommate_ad_id=[];
		foreach ($property_stmt as $row){
			if(!isset($roommate_ad_id[$row['roommate_ad_id']])) {
				$roommate_ad_showlastname[$row['roommate_ad_id']] = $row['roommate_ad_showlastname'];	
				
				$roommate_ad_createdate[$row['roommate_ad_id']] = $row['roommate_ad_createdate'];	
				$roommate_ad_id[$row['roommate_ad_id']] = $row['roommate_ad_id'];	
				$roommate_ad_budget[$row['roommate_ad_id']] = $row['roommate_ad_budget'];	
				$roommate_user_gender[$row['roommate_user_gender']] = $row['roommate_user_gender'];	
				$roommate_ad_age[$row['roommate_ad_id']] = $row['roommate_ad_age'];	
				$roommate_user_name[$row['roommate_ad_id']] = $row['roommate_user_name'];	
				$roommate_ad_roomsizepref[$row['roommate_ad_id']] = $row['roommate_ad_roomsizepref'];	
				$roommate_ad_title[$row['roommate_ad_id']] = $row['roommate_ad_title'];	
				$roommate_ad_description[$row['roommate_ad_id']] = $row['roommate_ad_description'];	
				$roommate_ad_occupation[$row['roommate_ad_id']] = $row['roommate_ad_occupation'];	
				if(isset($row['roommate_user_profilepic'])){
					$roommate_photo_thumb[$row['roommate_ad_id']] = THEME_DIR."/assets/front/img/profiles/".$row['roommate_user_profilepic'];	
				} else {
					$roommate_photo_thumb[$row['roommate_ad_id']] = THEME_DIR."/assets/front/img/thumb-small.png";	
				}
				
				
			}
			
		}
		$roommate_adpref_issaved=[];
		if(!empty($roommate_ad_id)) {
			$stars = get_savestatus($this->$Dbobj->getdbconnect(),$roommate_ad_id);
		}
		foreach($roommate_ad_id as $theaid) {
			
			if (in_array($theaid, $stars)) {
				$roommate_adpref_issaved[$theaid] = "fas";
			} else {
				$roommate_adpref_issaved[$theaid] = "far";
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
	
	margin-top:10px;
	
}
.room-mid-left{
	display: inline-block;
  
  width: 40%
}
.room-mid-right{
	text-overflow: ellipsis;
	 overflow:hidden;
	 font-size: 13px;
    font-size: 0.866rem;
    border-top: 1px solid;
    border-color: #5E5E5E;
	display: inline-block;
  float: right;
 height:120px;
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
	foreach($roommate_ad_id as $aid) {
		if($room_counter < $amount){
			?>
			
			<div class="room-container">
			<div class = "room-top">
			<div class = "room-top-left">
			<p>
			<?php echo $roommate_ad_title[$aid]; ?>
			</p>
			</div>
			<div class = "room-top-right">
			<p><?php echo "$".$roommate_ad_budget[$aid]; ?>/month</p>
			
			</div>
			<br style="clear:both;"/>
			<div class = "room-top-left-info">
			<p><?php echo show_lastname($roommate_user_name[$aid],$roommate_ad_showlastname[$aid]) . " " . 
			translate_occupation($roommate_ad_occupation[$aid]) ." ". 
			translate_gender($roommate_ad_gender[$aid]) ." ". 
			$roommate_ad_age[$aid]; ?></p>
			</div>
			<div class = "room-top-right-info">
			<p><?php echo $roommate_ad_roomsizepref[$aid]; ?></p>
			</div>
			
			</div>
			<br style="clear:both;"/>
			<div class = "room-mid">
			<a href = "<?php echo THEME_DIR?>/word/view-ad/?ad_id=<?php echo $aid; ?>">
			<div class = "room-mid-left">
			<img class = "thumb-image-roommates" width="100" height="100" src = "<?php echo $roommate_photo_thumb[$aid]; ?>">
			</div>
			</a>
			<div class = "room-mid-right">
			<?php echo $roommate_ad_description[$aid] ?>
			</div>
			</div>
			<div class = "room-bot">
			<div class = "room-bot-left">
			<?php echo get_datestatus($roommate_ad_createdate[$aid]);?>
			</div>
			<div class = "room-bot-right">
			<a class="save_roommate" data-value="<?php echo $aid;?>" style = "color:{$color} ;float:left;padding:20px;" href="#">
	<i class="<?php echo $roommate_adpref_issaved[$aid]; ?> fa-star">
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
if ( ! function_exists( 'hu_register_widget_roommates' ) ) {

	function hu_register_widget_roommates() {
		register_widget( 'AlxRoommates' );
	}

}
add_action( 'widgets_init', 'hu_register_widget_roommates' );
