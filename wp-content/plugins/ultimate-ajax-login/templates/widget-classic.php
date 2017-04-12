<?php
/*
 * Name: Classic Form Template
 * Description: Displays an AJAX-based classic form template
 * Type: Login
 * 
 * Instructions for modifying this template
 * 
 * DO NOT MODIFY THE ABOVE HEADERS, OR IT WILL STOP WORKING
 * Create a folder inside your active theme directory named ultimate_ajax_login and paste this inside it
 * 
 * 
 * Feel free to move things around as you wish, but keep the IDs and names for the fields as they are
 */

/* 
 * Copyright (C) 2014 Samer Bechara <sam@thoughtengineer.com>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

// Create new template object
$ual = new UAL_Template();

?>

<!-- Forms Dialog Div Wrapper - Used with Block UI-->
<div id="ual_div_<?php $ual->form_id(); ?>" title="<?php echo get_option('ual_login_button_text'); ?>">

    <div class="ual_text_above"><?php echo get_option('ual_text_above_form'); ?></div>
<!-- Login Form -->
<form id='ual_form_<?php $ual->form_id(); ?>' class='ual_form' method='post'>
    <div class='ual_form_item'>
	<label for='ual_username_<?php $ual->form_id(); ?>'><?php echo _e('Username'); ?></label>
	<input type="text" id='ual_username_<?php $ual->form_id(); ?>' name='ual_username' class='ual_field ual_username'/>
    </div>
    <div class='ual_form_item'>
	<label for='ual_password_<?php $ual->form_id(); ?>'><?php echo _e('Password'); ?></label>
	<input type='password' id='ual_password_<?php $ual->form_id(); ?>' name='ual_password' class='ual_field ual_password'/>
    </div>
    <div class='ual_form_item'>
	<input type='checkbox' id='ual_remember_me_<?php $ual->form_id(); ?>' name='ual_remember_me' checked='checked' />
	<label for='ual_remember_me_<?php $ual->form_id(); ?>'><?php echo _e('Remember me'); ?></label>	
    </div>
    <div class='ual_item ual_error error' id='ual_error_<?php $ual->form_id(); ?>'></div>
    <div class='ual_item'>
	<input type='submit' value='<?php echo get_option('ual_login_button_text'); ?>' class='ual_field ual_button'/>
    </div>
    <input type="hidden" name='form_id' value="<?php $ual->form_id(); ?>" />
</form> <!-- End of Login Form -->



<!-- Forgot Password Form -->

<form id="ual_forgot_form_<?php echo $ual->form_id();?>" method="POST" style="display:none">
    
    <label for='ual_fg_username_<?php $ual->form_id(); ?>'><?php _e('Enter your email address or username');?></label>        
   
    <input type='text' name='user_login' id='ual_fg_username_<?php $ual->form_id(); ?>' value='' />
    <?php do_action('lostpassword_form'); ?>
    
    <div class='ual_item ual_error error' id='ual_forgot_error_<?php $ual->form_id(); ?>'></div>
    <input type="hidden" name='form_id' value="<?php $ual->form_id(); ?>" />
    <input type="submit" value="<?php _e("Get New Password"); ?>" />
    <a href="#" class='ual_forgot_form_cancel'><?php _e("Cancel"); ?></a>    
</form>
           
</div> <!-- End of Ultimate Ajax Login Div -->