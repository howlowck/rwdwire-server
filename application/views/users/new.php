<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<p><?php $this->gen_lib->display_messages(); ?></p>
<div class="container">
	<legend> Register new User (if you are a NU student, you don't have to register) </legend>
	<?php echo form_open('users/create', array("class"=>"form")); ?>
		<label for="input-username">Username <span class="required" aria-label="required">*</span></label>
		<input type="text" id="input-username" name="username" value="<?php echo $this->gen_lib->getFormData("username"); ?>">
		<label for="input-email">Email <span class="required" aria-label="required">*</span></label>
		<input type="text" id="input-email" name="email" value="<?php echo $this->gen_lib->getFormData("email"); ?>">
		<label for="input-first">First Name <span class="required" aria-label="required">*</span></label>
		<input type="text" id="input-first" name="first_name" value="<?php echo $this->gen_lib->getFormData("first_name"); ?>">
		<label for="input-last">Last Name</label>
		<input type="text" id="input-last" name="last_name" value="<?php echo $this->gen_lib->getFormData("last_name");; ?>">
		<label for="input-pass">Password <span class="required" aria-label="required">*</span></label>
		<input type="password" id="input-pass" name="password_hash">
		<span  class="help-block">Have at least 6 character</span>
		<label for="input-vpass">Verify Password <span class="required" aria-label="required">*</span></label>
		<input type="password" id="input-vpass" name="vpassword">

		<!-- reCaptcha -->
		 <?php
          require_once(APPPATH.'libraries/recaptchalib.php');
          $publickey = $this->config->item('recaptcha_public'); // you got this from the signup page
          echo recaptcha_get_html($publickey);
        ?>
  		<!-- End of reCaptcha -->
		<br>
		<button type="submit" class="btn btn-success">Submit</button> 
	<?php echo form_close(); ?>
</div>
