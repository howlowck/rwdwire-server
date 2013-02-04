<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<p><?php $this->gen_lib->display_messages(); ?></p>
<h1>Reset Your Password</h1>
<p>To Reset your password, please input your email</p>
<?php echo form_open("users/passwordResetEmailForm"); ?>
<label for="input-email">Email</label>
<input id="input-email" type="email" name="email"/><br>
<button class="btn btn-success">Send Password Reset Email</button>
<?php echo form_close(); ?>