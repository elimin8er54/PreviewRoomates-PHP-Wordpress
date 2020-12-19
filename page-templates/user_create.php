<?php
/*
Template Name: Create User
*/
?>
<?php get_header(); ?>

<section class="content">

	<?php hu_get_template_part('parts/page-title'); ?>

	<div class="pad group">

		<form id = "create_form" name="create_form">
		
		<div class="block_area register">
    <fieldset>
      <h2 class="register_intro">Register with your email</h2>
      
      <div class="form_row form_row_first_name">
        <div class="form_label">Name</div>
        <div class="form_inputs">
          <span class="form_input form_text">
            <input type="text" name="user_name" size="25" maxlength="50" value="" autocomplete="given-name" required="">
          </span>
        </div>
      </div>
      <div class="form_row form_row_email">
        <div class="form_label">Email address</div>
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
      <div class="form_row form_row_password_confirm">
        <div class="form_label">Confirm password</div>
        <div class="form_inputs">
          <span class="form_input form_text">
            <input type="password" name="user_password_again" size="16" value="" required="">
          </span>
        </div>
      </div>
    </fieldset>
    <fieldset class="form_row form_row_gender">
      <div class="form_label">Gender</div>
      <div class="form_inputs">
        <label class="form_input form_radio">
          <input checked type="radio" name="user_gender" value="F" required="">
          Female
        </label>
        <label class="form_input form_radio">
          <input type="radio" name="user_gender" value="M">
          Male
        </label>
		 <label class="form_input form_radio">
          <input type="radio" name="user_gender" value="O">
          Other
        </label>
      </div>
	  
    </fieldset>
	<fieldset style="display:none;" class="form_row form_row_genderother">
	<div class="form_label">Specify Gender (Optional)</div>
	  <div class="form_inputs">
		<input  type="text" name="user_genderother" id = "user_genderother">
	  </div>
	</fieldset>
    <div class="form_row form_row_buttons">
      <div class="form_label"></div>
      <div class="form_inputs">
        <div class="form_input form_button">
          <button class="register-button button" id="registerbutton" type="button" name="submit">Register</button>
        </div>
      </div>
    </div>
  </div>
		
		</form>

	</div><!--/.pad-->

</section><!--/.content-->

<script>

$('[name="user_gender"]').change(function() {
	if($(this).val() == "O") {
		$(".form_row_genderother").show();
	}else{
		$(".form_row_genderother").hide();
	}
});

$( "#registerbutton" ).click(function() {
		var formdata = $("#create_form").serializeArray();

$.ajax({
            type:   'POST',
            url:    '<?php echo THEME_DIR. "/ajax/user_create_ajax.php" ?>',
            data: { 
			'ajax_call' : '1',
			'sendFormData' : JSON.stringify(formdata)
		},
		 dataType: "json", 
            success: function(data) {
				if(data.isCreated) {
				
					  login_user($("#user_email").val(),$("#user_password").val());
				} else{
					name_input = data.name;
					gotoerror(name_input);
					alert(data.info);
				}
            },
		error: function (request, status, error) {
		  console.log(request.responseText);
		}
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
				
			}
        });
}
</script>

<?php get_sidebar(); ?>

<?php get_footer(); ?>