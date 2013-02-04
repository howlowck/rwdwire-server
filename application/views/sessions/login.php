
<p><?php $this->gen_lib->display_messages(); ?></p>
<?php echo form_open('sessions/authenticate'); ?>

Email: <input type="text" name="email" value="<?php echo set_value('email'); ?>"/> <br/>
Password: <input type="password" name="password"/> <br/>
<input class ="btn"type="submit" name="submit" value="Login" />
<?php echo form_close(); ?> 
<a href="<?php echo base_url("users/passwordResetInit"); ?>">Forgot Your Password?</a><br>
<br>
<strong>OR</strong> <br> <br>
 <a class="btn btn-success" href="<?php echo base_url("users/new"); ?>">Register</a>