<!DOCTYPE html>
<html>
    <head>
        <title><?php echo $template['title']; ?></title>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/vendors/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/vendors/fontawesome/css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/default.css" />
        <script src="<?php echo base_url(); ?>public/vendors/jquery/jquery-1.8.2.min.js"></script>
        <script src="<?php echo base_url(); ?>public/vendors/bootstrap/js/bootstrap.min.js"></script>
        <?php echo $template['metadata']; ?>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>public/css/<?php echo $this->router->class;?>.css" />
        
    </head>
    <body>
        <div class="container">
            <div class="navbar navbar-inverse navbar-static-top">
                <div class="navbar-inner">
                    <ul class="nav">
                        <li class="active"><a href="<?php echo base_url(); ?>" tabindex="1" >Home</a></li>

                    </ul>
                    <!-- Dynamic Links -->
                
                <?php if (isset($current_user) AND $current_user->role->name == "admin"): ?>
                    <ul class="nav">
                        <li class="divider-vertical"><li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                Admin <b class='caret'></b>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if (can("read","users")): ?>
                                    <a href="<?php echo base_url("users"); ?>">Users</a>
                                <?php endif ?>
                                <!-- Add Admin Links Remember to use Can function!-->
                            </ul>
                        </li>
                    </ul>
                <?php endif; ?>
                    
                <?php if ($this->session->userdata('user_id')): ?>
                    <ul class="nav pull-right">
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <?php echo $current_user->first_name;?> <b class='caret'></b>
                            </a>
                            <ul class="dropdown-menu">
                                <?php if (can('read', 'Users')): ?>
                                    <a href="<?php echo base_url("users/{$current_user->id}") ?>">Profile</a>
                                <?php endif ?>
                                <a href="<?php echo base_url("sessions/logout")?>">Logout</a>
                            </ul>
                        </li>
                    </ul>
                <?php else: ?>
                    <ul class="nav pull-right">
                        <li class='pull-right'> <a href="<?php echo base_url("sessions/login"); ?>" title='Login'>Login</a></li>
                    </ul>
                <?php endif;?>
                </div>
              </div>
            <br>
            
            <div id="main">
                <?php
                echo $template['body'];
                ?>
            </div>
        </div>
        
    </body>
</html>