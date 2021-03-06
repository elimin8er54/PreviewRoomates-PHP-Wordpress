<?php
/*
Template Name: Forgot Password
*/
?>
<?php 
session_start();
if(isset($_SESSION['roommate_user_id'])) {
	header("Location: ".home_url());
}	

?>
<?php get_header(); ?>



<section class="content">

	<?php hu_get_template_part('parts/page-title'); ?>

	<div class="pad group">

		<form id="login_form" name="login_form">
		
		<div class="block_area register">
    <fieldset>
      <h2 class="register_intro">Password Reset</h2>
  
      <div class="form_row form_row_email">
        <div class="form_label">Email</div>
        <div class="form_inputs">
          <span class="form_input form_text">
            <input type="email" name="user_email" size="30" maxlength="254" value="" id="user_email" autocomplete="email" required="">
          </span>
        </div>
      </div>
    </fieldset>

    <div class="form_row form_row_buttons">
      <div class="form_label"></div>
      <div class="form_inputs">
        <div class="form_input form_button">
          <button class="register-button button" id="registerbutton" type="button" name="submit">Reset</button>
        </div>
      </div>
    </div>
  </div>
		
		</form>

	</div><!--/.pad-->

</section><!--/.content-->
<script>
$( document ).ready(function() {
	$( "#registerbutton" ).click(function() {
		login_user($("#user_email").val());
	});
});

function login_user(email){
		

$.ajax({
            type:   'POST',
            url:    '<?php echo THEME_DIR. "/ajax/user_forgot_password_ajax.php" ?>',
            data: { 
			'ajax_call' : '1',
			'user_email' : email
		},
		 dataType: "json", 
            success: function(data) {
				if(data.isCorrect) {
					
					
				} else {
					alert(data);
				}
            },
			error: function (request, status, error) {
				
			}
        });
}
/*function login_user(email,password){
		

$.ajax({
            type:   'POST',
            url:    '<?php echo THEME_DIR. "/ajax/user_login_ajax.php" ?>',
            data: { 
			'ajax_call' : '1',
			'user_email' : email,
			'user_password' : password
		},
		 dataType: "json", 
            success: function(data) {
				if(data.isCorrect) {
					window.location.replace("<?php echo home_url(); ?>");
					
				} else {
					alert(data);
				}
            },
			error: function (request, status, error) {
				
			}
        });
}
*/
</script>

<?php get_sidebar(); ?>

<?php get_footer(); ?>
