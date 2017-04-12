<?php

/* 
 * Contains the options page for the plugin
 */

// Form has been submitted
if(!empty($_POST)){
    
    // Call static function to save site options
    UAL_Main::save_site_options();
}
?>

<div class="wrap">
<h2>Ultimate AJAX Login Settings</h2>

<form method="post" action="options-general.php?page=ultimate_ajax_login"> 

<?php 

// Generate WP-specific form fields such as nonce field
settings_fields( 'ual-site-options' ); // Must match name in register_site_options_function

// Define the option group here, required by WP
do_settings_sections( 'ual-site-options' );


?>
<table class="form-table">	
        <tr valign="top">
        <th scope="row">Login Button Text</th>
        <td><input type='text' name='ual_login_button_text' value='<?php echo get_option('ual_login_button_text')?>' />
	    <p class="description">
		By default, the text <em><strong>Login</strong></em> is displayed on all the login buttons. You can override it here, by changing it to something else, such as <em><strong>Click Here to Login</strong></em>, <em><strong>Login Now</strong></em>...
	    </p>	    	    
	</td>
        </tr>	

        <tr valign="top">
        <th scope="row">Text to show above form</th>
        <td><textarea name='ual_text_above_form' rows="5" cols="30"><?php echo get_option('ual_text_above_form')?></textarea>
	    <p class="description">
		If you need to display a message for the user above the form, here is where you do it. HTML is allowed
	    </p>	    	    
	</td>
        </tr>	
	
        <tr valign="top">
        <th scope="row">Custom Error Login Message</th>
        <td><textarea name='ual_login_error_msg' rows="5" cols="30"><?php echo get_option('ual_login_error_msg')?></textarea>
	    <p class="description">
		In case of an invalid login, you can show your own text. HTML is allowed, so you can link to custom recovery pages, support pages... Leave blank to use default WordPress messages.
	    </p>	    	    
	</td>
        </tr>		
	
        <tr valign="top">
        <th scope="row">Successful Login URL</th>
        <td><input type='text' name='ual_redirect_login' class='widefat' value='<?php echo get_option('ual_redirect_login')?>' />
	    <p class="description">
		URL to redirect user to after logging in. If left blank, user will stay on current page. If invalid or external URL is entered, it will redirect to dashboard.<br/>Acceptable Values
	    <ol>
		<li><em>/hello-world/</em> or any other relative URL</li>
		<li><em><?php echo site_url('/hello-world/')."</em> or any absolute URL belonging to site";?></li>
		<li>Any other value will redirect to dashboard</li>
	    </ol>
	    </p>	    	    
	</td>
        </tr>		
</table> 
    
<?php
// Submit button
submit_button(); 

?>
</form>
</div>
