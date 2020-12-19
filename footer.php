        </div><!--/.main-inner-->
      </div><!--/.main-->
    </div><!--/.container-inner-->
  </div><!--/.container-->
  <?php do_action('__before_footer') ; ?>
  <footer id="footer">

    <?php if ( hu_is_checked('footer-ads') ) : ?>
      <?php
        ob_start();
        hu_print_widgets_in_location( 'footer-ads' );
        $full_width_widget_html = ob_get_contents();
      ?>
      <?php if ( ! empty($full_width_widget_html) ) : ob_end_clean(); ?>
        <section class="container" id="footer-full-width-widget">
          <div class="container-inner">
            <?php hu_print_widgets_in_location( 'footer-ads' ); ?>
          </div><!--/.container-inner-->
        </section><!--/.container-->
      <?php endif; ?>
    <?php endif; ?>

    <?php // footer widgets
    $_footer_columns = 0;
    if ( 0 != intval( hu_get_option( 'footer-widgets' ) ) ) {
        $_footer_columns = intval( hu_get_option( 'footer-widgets' ) );
        if( $_footer_columns == 1) $class = 'one-full';
        if( $_footer_columns == 2) $class = 'one-half';
        if( $_footer_columns == 3) $class = 'one-third';
        if( $_footer_columns == 4) $class = 'one-fourth';
    }


    //when do we display the widget wrapper on front end ?
    // - there's at least a column
    // - the widget zone(s) in the column(s) have at least one widget ( => is_active_sidebar() )

    //when do we display the widget wrapper when customizing ?
    //- there's at least one column

    $is_widget_wrapper_on = false;
    if ( hu_is_customizing() ) {
        $is_widget_wrapper_on = $_footer_columns > 0;
    } else {
        $is_widget_wrapper_on = $_footer_columns > 0;
        $_one_widget_zone_active = false;

        for ( $i = 1; $i <= $_footer_columns; $i++ ) {
          if ( $_one_widget_zone_active )
            continue;
          if ( apply_filters( 'hu_is_active_footer_widget_zone', is_active_sidebar( "footer-{$i}" ), $i, $_footer_columns ) )
            $_one_widget_zone_active = true;
        }//for

        $is_widget_wrapper_on = $is_widget_wrapper_on && $_one_widget_zone_active;
    }

    if ( $is_widget_wrapper_on ) : ?>

        <section class="container" id="footer-widgets">
          <div class="container-inner">

            <div class="pad group">

              <?php for ($i = 1; $i <= $_footer_columns ;$i++ ) : ?>
                  <div class="footer-widget-<?php echo $i; ?> grid <?php echo $class; ?> <?php if ( $i == $_footer_columns ) { echo 'last'; } ?>">
                    <?php hu_print_widgets_in_location( 'footer-' . $i ); ?>
                  </div>
              <?php endfor; ?>

            </div><!--/.pad-->

          </div><!--/.container-inner-->
        </section><!--/.container-->

    <?php endif; //$is_widget_wrapper_on ?>

    <?php if ( hu_has_nav_menu( 'footer' ) ): ?>
      <nav class="nav-container group" id="nav-footer" data-menu-id="<?php echo hu_get_menu_id( 'footer'); ?>" data-menu-scrollable="false">
        <?php hu_print_mobile_btn(); ?>
        <div class="nav-text"><?php apply_filters( 'hu_mobile_menu_text', '' );//put your mobile menu text here ?></div>
        <div class="nav-wrap">
          <?php
            wp_nav_menu(
                array(
                  'theme_location'=>'footer',
                  'menu_class'=>'nav container group',
                  'container'=>'',
                  'menu_id'=>'',
                  'fallback_cb'=> 'hu_page_menu'
              )
            );
          ?>
        </div>
      </nav><!--/#nav-footer-->
    <?php endif; ?>

    <section class="container" id="footer-bottom">
      <div class="container-inner">

        <a id="back-to-top" href="#"><i class="fas fa-angle-up"></i></a>

        <div class="pad group">

          <div class="grid one-half">
            <?php $_footer_logo_img_src = apply_filters( 'hu_footer_logo_src', hu_get_img_src_from_option('footer-logo') ); ?>
            <?php if ( false !== $_footer_logo_img_src && ! empty($_footer_logo_img_src) ) : ?>
              <img id="footer-logo" src="<?php echo $_footer_logo_img_src; ?>" alt="<?php get_bloginfo('name'); ?>">
            <?php endif; ?>

            <div id="copyright">
                <p><?php echo apply_filters('hu_parse_template_tags', wp_kses_post( hu_get_option( 'copyright' ) ) ); ?></p>
            </div><!--/#copyright-->

            <?php if ( hu_is_checked( 'credit' ) || hu_is_customizing() ) : ?>
              <?php
                $hu_theme = wp_get_theme();
              ?>
              <?php ob_start(); ?>
                  
              <?php
                $credits_html = ob_get_contents();
                if ($credits_html) ob_end_clean();
                echo apply_filters( 'hu_credits_html', $credits_html );
              ?>
            <?php endif; ?>

          </div>

          <div class="grid one-half last">
            <?php if ( hu_has_social_links() || hu_is_customizing() ) : ?>
              <?php hu_print_social_links(); ?>
            <?php else : //if not customizing, display an empty p for design purposes ?>
                <?php if ( hu_user_can_see_customize_notices_on_front() ) : ?>
                    <?php
                      printf( '<p style="text-transform:none;text-align: right;">%1$s. <br/><a style="color: white;text-decoration:underline;" href="%2$s" title="%3$s">%3$s &raquo;</a></p>',
                          __('You can set your social links here from the live customizer', 'hueman'),
                          admin_url( 'customize.php?autofocus[section]=social_links_sec' ),
                          __('Customize now', 'hueman')
                      );
                    ?>
                <?php endif; ?>
            <?php endif; ?>
          </div>

        </div><!--/.pad-->

      </div><!--/.container-inner-->
    </section><!--/.container-->

<script>
	$( ".save_roommate" ).click(function(e) {
		
		<?php if(!isset($_SESSION['roommate_user_id'])) { ?>
			alert("You must make an account to save ads.");
		<?php } ?>
		thiselement = $(this);
		 e.preventDefault();
		$.ajax({
            type:   'POST',
            url:    '<?php echo THEME_DIR. "/ajax/save_roommate.php" ?>',
            data: { 
			'ajax_call' : '1',
			'ad_id' : thiselement.data("value")
		},
		 dataType: "json", 
            success: function(data) {
				if(data.isSaved) {
					
					thiselement.children( "i" ).toggleClass('far fas');
					
				} else {
					thiselement.children( "i" ).toggleClass('fas far');
				}
            },
		error: function (request, status, error) {
		  console.log(request.responseText);
		}
		
        });
	});
	
	$( ".save_room" ).click(function(e) {
	
		<?php if(!isset($_SESSION['roommate_user_id'])) { ?>
			alert("You must make an account to save properties.");
		<?php } ?>
		thiselement = $(this);
			
		 e.preventDefault();
		$.ajax({
            type:   'POST',
            url:    '<?php echo THEME_DIR. "/ajax/save_room.php" ?>',
            data: { 
			'ajax_call' : '1',
			'property_id' : thiselement.data("value")
		},
		 dataType: "json", 
            success: function(data) {
				if(data.isSaved) {
					
					thiselement.children( "i" ).toggleClass('far fas');
					
				} else {
					thiselement.children( "i" ).toggleClass('fas far');
				}
            },
		error: function (request, status, error) {
		  
		}
		
        });
	});
	
	
		function emailer(send_email,pid){
			
		<?php if(isset($_SESSION['roommate_user_id'])) { ?>
		var x = document.getElementById("main-popup");
		
		temp_table = '<div class="form-popup" id="email-form">'+
					 ' <form  id = "email-form-main" class="form-container">'+
					   ' <h1>Send Message</h1>'+


					   ' <textarea rows="15" placeholder="Enter Message" name="email-msg" id = "email-msg"required> </textarea>'+
						
						'<button type="button" onclick="send_email('+send_email+');" class="btn send-email">Send Message</button>'+
						'<button type="submit" class="btn cancel" onclick="closeForm()">Close</button>'+
						
						'<input name = "rec_id" style="display:none;" value="'+pid+'">'+
					 ' </form>'+
					'</div>';
					
			x.innerHTML = temp_table;
		<?php } else { ?>
		alert("You need an account to message this ad.");
		
		<?php } ?>
			return false;
	}
	function closeForm() {
		document.getElementById("main-popup").innerHTML = "";
	}
	
	function send_email(email_type){
	$(".send-email").hide();
		var formdata = $("#email-form-main").serializeArray();
		$.ajax({
            type:   'POST',
            url:    '<?php echo THEME_DIR. "/ajax/emailer_ajax.php" ?>',
            data: { 
			'ajax_call' : email_type,
			'sendFormData' : JSON.stringify(formdata),
			
		},
		 dataType: "json", 
            success: function(data) {
				if(data.isSent) {
					document.getElementById("email-msg").innerHTML = "";
					closeForm();
					alert("Email has been sent to an agent. Thank you!");
				} else {
					alert("Sorry, something went wrong and your message was not sent.");
					$(".send-email").show();
				}
            },
		error: function (request, status, error) {
		
		 alert("Sorry, something went wrong and your message was not sent.");
		 $(".send-email").show();
		}
		
        });
	}
	function gotoerror(name_input){
							$([document.documentElement, document.body]).animate({
								scrollTop: $('[name="'+name_input+'"]').offset().top - 100
							}, 500);
						  $('[name="'+name_input+'"]').css("border","2px solid red");
						}
						  $( document ).ready(function() {
$( ".main_logout" ).click(function() {

$.ajax({
            type:   'POST',
            url:    '<?php echo THEME_DIR. "/ajax/user_logout_ajax.php" ?>',
            data: { 
			'ajax_call' : '1'
		},
		 dataType: "json", 
            success: function(data) {
			 window.location.replace("<?php echo home_url(); ?>");
            },
		error: function (request, status, error) {
		  window.location.replace("<?php echo home_url(); ?>");
		}
        });
});
});
	</script>

  </footer><!--/#footer-->

</div><!--/#wrapper-->

<?php wp_footer(); ?>
</body>
</html>