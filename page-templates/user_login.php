<?php
/*
Template Name: Login User
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
      <h2 class="register_intro">Login</h2>
  
      <div class="form_row form_row_email">
        <div class="form_label">Email</div>
        <div class="form_inputs">
          <span class="form_input form_text">
            <input type="email" name="user_email" size="30" maxlength="254" value="" id="user_email" autocomplete="email" required="">
          </span>
        </div>
      </div>
      <div class="form_row form_row_password">
        <div class="form_label">Password</div>
        <div class="form_inputs">
          <span class="form_input form_text">
            <input type="password" name="user_password" size="16" id="user_password" value="" required="">
          </span>
        </div>
      </div>
	  <!--<div class="form_row form_row_password">
        <div class="form_label"></div>
        <div class="form_inputs">
          <span class="form_input form_text">
            <a href="Forgot-Password" >Forgot Password</a>
          </span>
        </div>
      </div>-->
    </fieldset>

    <div class="form_row form_row_buttons">
      <div class="form_label"></div>
      <div class="form_inputs">
        <div class="form_input form_button">
          <button class="register-button button" id="registerbutton" type="button" name="submit">Login</button>
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
		login_user($("#user_email").val(),$("#user_password").val());
	});
});

function login_user(email,password){
		

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
				 console.log(request.responseText);
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
