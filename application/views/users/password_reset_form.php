<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<p><?php $this->gen_lib->display_messages(); ?></p>
<?php echo form_open("users/passwordReset",array("autocomplete"=>"off")) ?>
<input type="hidden" value="<?php echo $id ?>" name="id" />
<label for="pass-input">New Password</label>
<!-- Try to turn autosave off on password-hash -->
<input type="password" id="pass-input" name="password_hash" />
<label for="pass-vinput">Confirm Password</label>
<input type="password" id="pass-vinput" name="vpassword" />
<br>
<button class="btn btn-success" type="submit">Submit</button>
<?php echo form_close(); ?>
