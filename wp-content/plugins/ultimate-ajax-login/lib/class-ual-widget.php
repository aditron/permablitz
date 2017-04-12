<?php

/*
 * Implements our User Posts Per Page widget
 * @author Samer Bechara <sam@thoughtengineer.com>
 */
class UAL_Widget extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {

	// Call parent constructior
	parent::__construct(
		'ual_widget', // Base ID
		__('Ultimate AJAX Login', 'ultimate-ajax-login'), // Name
		array( 'description' => __( 'Displays the Ultimate AJAX Login form' ), ) // Args
	);	
	
	// Include Ajax library on frontend, uncomment if not needed
	add_action( 'wp_head', array( $this, 'add_ajax_library' ) );
	
	// Enqueue Block UI jQuery plugin
	wp_enqueue_script( 'ual-blockui-js', UAL_URL.'inc/js/jquery.blockUI.js', array('jquery') );
	// Enqueue JS file
	wp_enqueue_script( 'ual-widget-js', UAL_URL.'inc/js/widget.js', array('jquery', 'jquery-ui-dialog') );
	// Enqueue Popmodal JS
	wp_enqueue_script('ual-popmodal-js', UAL_URL.'lib/jquery-popmodal/popModal.min.js', array('jquery'), false, true);
	
	// Enqueue CSS files
	wp_enqueue_style( 'ual-widget-css', UAL_URL.'inc/css/widget.css');
	wp_enqueue_style( 'ual-popmodal-css', UAL_URL.'lib/jquery-popmodal/popModal.min.css');
	
	// Add ajax actions on the frontend for non-logged in users
	add_action( 'wp_ajax_nopriv_ual_ajax_login', array($this,'login_user') );
	add_action( 'wp_ajax_nopriv_ual_ajax_forgot_pw', array($this,'forgot_password') );
	
    }
    
    /**
     * Adds the WordPress Ajax Library to the frontend.
     */
    public function add_ajax_library() {

	$html = '<script type="text/javascript">';
	    $html .= 'var ajaxurl = "' . admin_url( 'admin-ajax.php' ) . '"';
	$html .= '</script>';

	echo $html;

    }
    
    /*
     * Logs in the user to wordpress
     */
    public function login_user(){
	
	// Get AJAX-submitted form data
	$form_data = array();
	parse_str($_POST['data'], $form_data);
	
	// Should we remember the user data
	$remember = isset($form_data['ual_remember_me'])?true:false;
	
	// Extract user credentials
	$credentials = array('user_login' => $form_data['ual_username'],
				'user_password' => $form_data['ual_password'],
				'remember'	=> $remember    );
	
	// Signon user
	$user = wp_signon($credentials);
	
	// User not signed in properly
	if (is_wp_error($user)){
	    
	    // Check if the user has specified a custom error message, and return it
	    if(get_option('ual_login_error_msg') != ''){
		$response['error'] = get_option('ual_login_error_msg');
		
		// Specify that this is a custom error
		$response['custom_error'] = true;
	    }
	    
	    // No custom error message has been specified, use WordPress default
	    else {
		$response['error'] = $user->get_error_message();
		
		// This is not a custom error
		$response['custom_error'] = false;		
	    }
	    $response['logged_in'] = false;
	}
	
	// User successfully logged in
	else {
	    $response['logged_in'] = true;
	    
	    
	    // Get widget settings - popping because result is 2D array with one key as widget ID
	    $widget_settings = $this->get_settings();
	    $settings = array_pop($widget_settings);
	    
	    // Get login redirect option
	    $redirect_login = $settings['redirect_login'];
	    
	    // Check if the widget has a redirect URL of its own
	    if( ! empty ( $redirect_login ) ) {
		
		$redirect = $redirect_login;
	    
	    }
	    
	    // Specific widget option is not set, use site specific option
	    else {

		// Redirect user upon login
		$redirect = get_option('ual_redirect_login');
		
	    }

	    
	    // If redirect is not empty, set the redirect flag
	    if(!empty($redirect)){
		$response['redirect'] = $redirect;
	    }
	    
	}
	
	// Encode and send data
	echo json_encode($response);
	
	die(); // Required for all AJAX calls
    }
    
    /*
     * Reset password AJAX functionality
     */
    
    public function forgot_password(){	
	
	$result = $this->retrieve_password();
	
	// Password has been successfully sent
	if($result === true){
	    _e('Password has been successfully sent');
	}
	
	// Error occurred
	elseif(is_wp_error($result)){
	    echo $result->get_error_message();
	}
	
	// Should never happen, but just in case
	else{
	    _e('An unexpected error occured. Please try again later');
	}
	
	die();
    }
    
    /**
     * Handles sending password retrieval email to user. Copied from wp-login.php because including was throwing an error
     *
     * @uses $wpdb WordPress Database object
     *
     * @return bool|WP_Error True: when finish. WP_Error on error
     */
    function retrieve_password() {
	
	
	    // Parse post data
	    parse_str($_POST['data'], $form_data);
	    
	    global $wpdb, $wp_hasher;

	    $errors = new WP_Error();

	    if ( empty( $form_data['user_login'] ) ) {
		    $errors->add('empty_username', __('<strong>ERROR</strong>: Enter a username or e-mail address.'));
	    } else if ( strpos( $form_data['user_login'], '@' ) ) {
		    $user_data = get_user_by( 'email', trim( $form_data['user_login'] ) );
		    if ( empty( $user_data ) )
			    $errors->add('invalid_email', __('<strong>ERROR</strong>: There is no user registered with that email address.'));
	    } else {
		    $login = trim($form_data['user_login']);
		    $user_data = get_user_by('login', $login);
	    }

	    /**
	     * Fires before errors are returned from a password reset request.
	     *
	     * @since 2.1.0
	     */
	    do_action( 'lostpassword_post' );

	    if ( $errors->get_error_code() )
		    return $errors;

	    if ( !$user_data ) {
		    $errors->add('invalidcombo', __('<strong>ERROR</strong>: Invalid username or e-mail.'));
		    return $errors;
	    }

	    // Redefining user_login ensures we return the right case in the email.
	    $user_login = $user_data->user_login;
	    $user_email = $user_data->user_email;

	    /**
	     * Fires before a new password is retrieved.
	     *
	     * @since 1.5.0
	     * @deprecated 1.5.1 Misspelled. Use 'retrieve_password' hook instead.
	     *
	     * @param string $user_login The user login name.
	     */
	    do_action( 'retreive_password', $user_login );

	    /**
	     * Fires before a new password is retrieved.
	     *
	     * @since 1.5.1
	     *
	     * @param string $user_login The user login name.
	     */
	    do_action( 'retrieve_password', $user_login );

	    /**
	     * Filter whether to allow a password to be reset.
	     *
	     * @since 2.7.0
	     *
	     * @param bool true           Whether to allow the password to be reset. Default true.
	     * @param int  $user_data->ID The ID of the user attempting to reset a password.
	     */
	    $allow = apply_filters( 'allow_password_reset', true, $user_data->ID );

	    if ( ! $allow )
		    return new WP_Error('no_password_reset', __('Password reset is not allowed for this user'));
	    else if ( is_wp_error($allow) )
		    return $allow;

	    // Generate something random for a password reset key.
	    $key = wp_generate_password( 20, false );

	    /**
	     * Fires when a password reset key is generated.
	     *
	     * @since 2.5.0
	     *
	     * @param string $user_login The username for the user.
	     * @param string $key        The generated password reset key.
	     */
	    do_action( 'retrieve_password_key', $user_login, $key );

	    // Now insert the key, hashed, into the DB.
	    if ( empty( $wp_hasher ) ) {
		    require_once ABSPATH . WPINC . '/class-phpass.php';
		    $wp_hasher = new PasswordHash( 8, true );
	    }
	    $hashed = $wp_hasher->HashPassword( $key );
	    $wpdb->update( $wpdb->users, array( 'user_activation_key' => $hashed ), array( 'user_login' => $user_login ) );

	    $message = __('Someone requested that the password be reset for the following account:') . "\r\n\r\n";
	    $message .= network_home_url( '/' ) . "\r\n\r\n";
	    $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
	    $message .= __('If this was a mistake, just ignore this email and nothing will happen.') . "\r\n\r\n";
	    $message .= __('To reset your password, visit the following address:') . "\r\n\r\n";
	    $message .= '<' . network_site_url("wp-login.php?action=rp&key=$key&login=" . rawurlencode($user_login), 'login') . ">\r\n";

	    if ( is_multisite() )
		    $blogname = $GLOBALS['current_site']->site_name;
	    else
		    /*
		     * The blogname option is escaped with esc_html on the way into the database
		     * in sanitize_option we want to reverse this for the plain text arena of emails.
		     */
		    $blogname = wp_specialchars_decode(get_option('blogname'), ENT_QUOTES);

	    $title = sprintf( __('[%s] Password Reset'), $blogname );

	    /**
	     * Filter the subject of the password reset email.
	     *
	     * @since 2.8.0
	     *
	     * @param string $title Default email title.
	     */
	    $title = apply_filters( 'retrieve_password_title', $title );
	    /**
	     * Filter the message body of the password reset mail.
	     *
	     * @since 2.8.0
	     *
	     * @param string $message Default mail message.
	     * @param string $key     The activation key.
	     */
	    $message = apply_filters( 'retrieve_password_message', $message, $key );

	    if ( $message && !wp_mail( $user_email, wp_specialchars_decode( $title ), $message ) )
		    wp_die( __('The e-mail could not be sent.') . "<br />\n" . __('Possible reason: your host may have disabled the mail() function.') );

	    return true;
    }

    

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {	
	
	// Set jQuery UI theme if not set
	$theme = isset($instance['theme'])?$instance['theme']:'smoothness';
	
	// Set default template if not set
	$template = isset($instance['template'])?$instance['template']:'classic';
	
	// Enqueue the widget jQuery UI theme if it hasn't been already
	if ( ! wp_style_is( 'ual-jqueryui' ) ){
	    wp_enqueue_style( 'ual-jqueryui', UAL_URL.'lib/jqueryui/themes/'.$theme.'/jquery-ui.min.css');
	}
	
	
	// Show template based on user status
	if( ! is_user_logged_in() ){

	    $this->load_template('widget-'.$template.'.php');
	}
	
	
	else {

	    // Load template specified by user
	    $this->load_template('widget-logged-in.php');

	}

    }

    /**
     * Outputs the widget options fields under Appearance->Widgets
     *
     * @param array $instance The widget instance
     */
    public function form( $instance ) {

	// If template field is set, use it
	if ( isset( $instance[ 'template' ] ) ) {
	    $template = $instance[ 'template' ];
	}
	// Use classic template
	else {
	    $template = 'classic';
	}

	// If jquery theme is set, use it
	if ( isset( $instance[ 'theme' ] ) ) {
	    $theme = $instance[ 'theme' ];
	}
	// Use default jquery theme
	else {
	    $theme = 'smoothness';
	}
	
	
	// If redirect URL is set, display it
	if ( isset( $instance[ 'redirect_login' ] ) ) {
	    $redirect_url = $instance[ 'redirect_login' ];
	}
	// Use default height
	else {
	    $redirect_url = '';
	}	
   
	?>
	<p>
	    <!-- Widget Template Select Field -->
	    <label for="<?php echo $this->get_field_id( 'template' ); ?>"><?php _e( 'Form Template' ); ?></label> 
	    <select class="widefat" id="<?php echo $this->get_field_id( 'template' ); ?>" name="<?php echo $this->get_field_name( 'template' ); ?>">
		<option value="classic" <?php echo ($template === 'classic')?"selected='selected'":""; ?>>Classic</option>
		<option value="dialog" <?php echo ($template === 'dialog')?"selected='selected'":""; ?>>Dialog Box</option>
		<option value="popmodal" <?php echo ($template === 'popmodal')?"selected='selected'":""; ?>>Modal Form</option>		
	    </select>
	    <br/><br/>
	    <!-- Widget Theme Select Field -->
	    <label for="<?php echo $this->get_field_id( 'theme' ); ?>"><?php _e( 'Widget Theme - Only for Dialog Template' ); ?></label> 
	    <select class="widefat" id="<?php echo $this->get_field_id( 'theme' ); ?>" name="<?php echo $this->get_field_name( 'theme' ); ?>">
		
		<?php 	
		
			// Get themes path
			$themes_path = UAL_PATH.'/lib/jqueryui/themes/';
			
			// Get list of themes in our directory
			$themes = scandir($themes_path);
			
			// Add theme to select box
			foreach($themes as $key=> $dir){
			    
			    // List all directories that are different from current directory and parent directory
			    if(is_dir($themes_path.$dir) && $dir!='.' && $dir !='..'){
				echo "<option value='$dir'";
				echo ($theme === $dir)?"selected='selected'":"";
				echo ">$dir</option>";
			    }
			}
			
		?>
	    </select>
	    <br/><br/>
	    <!-- Redirect URL Field -->
	    <label for="<?php echo $this->get_field_id( 'redirect_login' ); ?>"><?php _e( 'Override Redirect URL in Settings Page' ); ?></label> 
	    <input class="widefat" id="<?php echo $this->get_field_id( 'redirect_login' ); ?>" name="<?php echo $this->get_field_name( 'redirect_login' ); ?>" type="text" value="<?php echo esc_attr( $redirect_url ); ?>"><br/><br/>
	</p>

	<?php 
	
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update( $new_instance, $old_instance ) {

	// Initialize instance
	$instance = array();
	
	// Save user template
	$instance['template'] = ( ! empty( $new_instance['template'] ) ) ? strip_tags( $new_instance['template'] ) : '';	
	
	// Save jQuery Theme
	$instance['theme'] = ( ! empty( $new_instance['theme'] ) ) ? strip_tags( $new_instance['theme'] ) : '';
	
	// Validate the URL
	$sanitized_location = wp_sanitize_redirect($new_instance['redirect_login'] );	
	$valid_location = wp_validate_redirect($sanitized_location, admin_url());
	
	// Assign new URL to instance
	$instance['redirect_login'] = $valid_location;
	
	// Return values to be saved
	return $instance;	    
    }
    
    /*
     * Loads template from the theme directory ultimate_ajax_login if it exists
     * Reverts to template folder in plugin if nothing found
     * @param string $name  The full template name, e.g. widget-classic.php
     */
    
    public function load_template($template_name){
	
	// Set template path to current theme folder
	$template_path = 'ultimate_ajax_login';
	
	// Set default path
	$default_path = UAL_PATH.'/templates/';
	
	// Find template in theme folder
	$template = locate_template(
		array(
			trailingslashit( $template_path ) . $template_name,
			$template_name
		)
	);
	
	// Template not found
	if (! $template ) {
	    $template = $default_path.$template_name;
	}
	
	// Require template parser
	require_once(UAL_PATH.'/lib/class-ual-template.php');
	
	
	// Get widget settings which will be used in all templates
	$widget_settings = $this->get_settings();
	$settings = array_pop($widget_settings);
	
	// Load template
	require_once($template);
    }
    
}