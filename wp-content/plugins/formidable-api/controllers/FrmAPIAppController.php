<?php
if(!defined('ABSPATH')) die('You are not allowed to call this page directly.');

class FrmAPIAppController {
    public static $timeout = 15;
	public static $v2_base = 'frm/v2';
    
    public static function load_hooks() {
		add_action( 'admin_init', 'FrmAPIAppController::include_updater' );
		register_activation_hook( self::folder_name() . '/formidable-api.php', 'FrmAPIAppController::install' );
		add_action( 'rest_api_init', 'FrmAPIAppController::create_initial_rest_routes', 0 );
		add_shortcode( 'frm-api', 'FrmAPIAppController::show_api_object' );

		if ( false !== strpos( $_SERVER['REQUEST_URI'], '/wp-json/frm/forms' ) || false !== strpos( $_SERVER['REQUEST_URI'], '/wp-json/frm/entries' ) ) {
			FrmAPIv1Controller::load_hooks();
		}
    }

    public static function path(){
        return dirname(dirname(__FILE__));
    }

    public static function folder_name(){
        return basename( self::path() );
    }

    public static function install() {
        $frmdb = new FrmAPIDb();
        $frmdb->upgrade();
    }

    public static function include_updater() {
		if ( class_exists( 'FrmAddon' ) ) {
			include(self::path() .'/models/FrmAPIUpdate.php');
			FrmAPIUpdate::load_hooks();
		}
    }

	public static function create_initial_rest_routes() {
		add_filter( 'determine_current_user', 'FrmAPIAppController::set_current_user', 40 );
		add_filter( 'rest_authentication_errors', 'FrmAPIAppController::check_authentication', 50 );
		self::force_reauthentication();

		if ( ! class_exists('WP_REST_Controller') ) {
			include_once( self::path() . '/controllers/FrmAPITempController.php' );
		}

		$controller = new FrmAPIFieldsController();
		$controller->register_routes();

		$controller = new FrmAPIFormsController();
		$controller->register_routes();

		$controller = new FrmAPIEntriesController();
		$controller->register_routes();

		if ( class_exists('WP_REST_Posts_Controller') ) {
			$controller = new FrmAPIViewsController( 'frm_display' );
			$controller->register_routes();
		}
	}
	
	/**
    * Force reauthentication after we've registered our handler
    */
    public static function force_reauthentication() {
        if ( is_user_logged_in() ) {
            // Another handler has already worked successfully, no need to reauthenticate.
            return;
        }

        // Force reauthentication
        if ( defined('REST_REQUEST') && REST_REQUEST ) {
            $user_id = apply_filters( 'determine_current_user', false );
        	if ( $user_id ) {
        		wp_set_current_user( $user_id );
        	}        	
        }
    }
	
	public static function set_current_user($user_id) {
	    if ( !empty( $user_id) ) {
	        return $user_id;
	    }
	    
	    global $frm_api_error;
	    
	    if ( !isset( $_SERVER['PHP_AUTH_USER'] ) ){
            /*
            * php-cgi under Apache does not pass HTTP Basic user/pass to PHP by default
            * For this workaround to work, add this line to your .htaccess file:
            * RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
            */

			if ( isset( $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ) && ! isset( $_SERVER['HTTP_AUTHORIZATION'] ) ) {
				$_SERVER['HTTP_AUTHORIZATION'] = $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
			}

            if ( isset($_SERVER['HTTP_AUTHORIZATION']) && strlen($_SERVER['HTTP_AUTHORIZATION']) > 0 ) {
                list($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']) = explode(':', base64_decode(substr($_SERVER['HTTP_AUTHORIZATION'], 6)));
                if ( strlen($_SERVER['PHP_AUTH_USER']) == 0 || strlen($_SERVER['PHP_AUTH_PW']) == 0 ) {
                    unset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
                }
            }
            
            if ( !isset( $_SERVER['PHP_AUTH_USER'] ) ) {
                //$frm_api_error = array( 'code' => 'frm_missing_api', 'message' => __('You are missing an API key', 'frmapi') );
                return $user_id;
            }
		}
		
		// check if using api key
		$api_key = get_site_option('frm_api_key');
        $check_key = $_SERVER['PHP_AUTH_USER'];
        
        if ( $api_key != $check_key ) {
            $frm_api_error = array( 'code' => 'frm_incorrect_api', 'message'  => __('Your API key is incorrect', 'frmapi') );
            return $user_id;
        }
		
		$admins = new WP_User_Query( array( 'role' => 'Administrator', 'number' => 1, 'fields' => 'ID' ) );
		if ( empty($admins) ) {
		    $frm_api_error = array( 'code' => 'frm_missing_admin', 'message' => __('You do not have an administrator on this site', 'frmapi') );
		    return $user_id;
		}
		
		$user_ids = $admins->results;
		$user_id = reset($user_ids);
		
		$frm_api_error = 'success';
		
        return $user_id;
	}
	
	public static function check_authentication($result) {
    	if ( ! empty( $result ) ) {
    		return $result;
    	}

        // only return error if this is an frm route
        if ( ! FrmAPIAppHelper::is_frm_route() ) {
            return $result;
        }

    	global $frm_api_error;
	    if ( $frm_api_error && is_array($frm_api_error) ) {
	        return new WP_Error( $frm_api_error['code'], $frm_api_error['message'], array( 'status' => 403 ));
	    }
        
        if ( 'success' == $frm_api_error || is_user_logged_in() ) {
		    return true;
		}
		
		return $result;
	}

	public static function show_api_object( $atts ) {
		if ( ! isset( $atts['id'] ) || ! isset( $atts['url'] ) ) {
			return __( 'Please include id=# and url="yoururl.com" in your shortcode', 'frmapi' );
		}
		$atts['id'] = sanitize_title( $atts['id'] );
		$atts['type'] = sanitize_title( isset( $atts['type'] ) ? $atts['type'] : 'form' ) . 's';

		$container_id = 'frmapi-' . $atts['id'] . rand( 1000, 9999 );
		$url = trailingslashit( $atts['url'] ) . 'wp-json/frm/v2/' . $atts['type'] . '/' . $atts['id'];

		$get_params = $atts;
		if ( isset( $get_params['get'] ) ) {
			$pass_params = explode( ',', $get_params['get'] );
			foreach ( $pass_params as $pass_param ) {
				if ( isset( $_GET[ $pass_param ] ) ) {
					$get_params[ $pass_param ] = sanitize_text_field( $_GET[ $pass_param ] );
				}
			}
			unset( $get_params['get'] );
		}
		unset( $get_params['id'], $get_params['type'], $get_params['url'] );

		if ( $atts['type'] == 'forms' ) {
			$get_params['return'] = 'html';
		} else {
			$pass_params = array( 'frm-page-'. $atts['id'], 'frmcal-month', 'frmcal-year' );
			foreach ( $pass_params as $pass_param ) {
				$url_value = filter_input( INPUT_GET, $pass_param );
				if ( ! empty( $url_value ) ) {
					$get_params[ $pass_param ] = sanitize_text_field( $url_value );
				}
			}
		}

		if ( ! empty( $get_params ) ) {
			$url .= '?' . http_build_query( $get_params );
		}

		$form = '<div id="' . esc_attr( $container_id ) . '" class="frmapi-form" data-url="' . esc_url( $url ) . '"></div>';
		add_action( 'wp_footer', 'FrmAPIAppController::load_form_scripts');

		return $form;
	}

	public static function load_form_scripts() {
		$script = "jQuery(document).ready(function($){
var frmapi=$('.frmapi-form');
if(frmapi.length){
	for(var frmi=0,frmlen=frmapi.length;frmi<frmlen;frmi++){
		frmapiGetData($(frmapi[frmi]));
	}
}
});
function frmapiGetData(frmcont){
	jQuery.ajax({
		dataType:'json',
		url:frmcont.data('url'),
		success:function(json){
			frmcont.html(json.renderedHtml);
		}
	});
}";
		$script = str_replace( array( "\r\n", "\r", "\n", "\t", '' ), '', $script );
		echo '<script type="text/javascript">' . $script .'</script>';
	}

    public static function send_webhooks( $entry, $hook, $type = 'live' ) {
        if ( ! is_object( $entry ) ) {
            $entry = FrmEntry::getOne( $entry );
        }
        
        add_filter('frm_use_wpautop', '__return_false');

		$body = trim( $hook->post_content['data_format'] );
		if ( empty( $body ) ) {
			$body = self::get_entries_array( array( $entry->id ) );
		} else {
			$body = FrmAppHelper::maybe_json_decode( $body );
		}
		$body = json_encode( $body );

		//TODO: trigger sanitize_url=1 on every shortcode
		$body = str_replace('[\/', '[/', $body); // allow end shortcodes to be processed
		$body = apply_filters( 'frm_content', $body, $entry->form_id, $entry );
		$body = str_replace('[/', '[\/', $body); // if the end shortcodes are still present, escape them

		$body = str_replace( ' & ', ' %26 ', $body ); // escape &

		$headers = array();
		if ( $type == 'test' ) {
			$headers['X-Hook-Test'] = 'true';
		}

		$url = apply_filters( 'frm_content', $hook->post_content['url'], $entry->form_id, $entry );
		$args = array(
			'url' => $url, 'headers' => $headers,
			'api_key' => $hook->post_content['api_key'],
			'body' => $body, 'method' => 'POST',
		);

		$resp = self::send_request( $args );

		do_action( 'frmapi_post_response', $resp, $entry, $hook );

        add_filter('frm_use_wpautop', '__return_true');
    }

	public static function send_request( $args ) {
		$headers = isset( $args['headers'] ) ? $args['headers'] : array();
		if ( isset( $args['api_key'] ) && ! empty( $args['api_key'] ) ) {
			$api_key = trim( $args['api_key'] );
			$headers['Authorization'] = 'Basic ' . base64_encode( $api_key .':x' );
		}
		if ( ! isset( $headers['Content-type'] ) ) {
			$headers['Content-type'] = 'application/json';
		}

		$arg_array = array(
			'body'      => $args['body'],
			'timeout'   => self::$timeout,
			'sslverify' => false,
			'headers'   => $headers,
			'method'    => $args['method'],
		);

		$url = esc_url_raw( trim( $args['url'] ) );
		$resp = wp_remote_post( $url, $arg_array );

		return $resp;
	}

    public static function get_entries_array($ids) {
	    global $wpdb;

	    $item_form_id = 0;
        $entry_array = array();

        // fetch 20 posts at a time rather than loading the entire table into memory
        while ( $next_set = array_splice( $ids, 0, 20 ) ) {
            $where = 'WHERE id IN (' . join( ',', $next_set ) . ')';
            $entries = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}frm_items $where" );
            unset($where);

            // Begin Loop
            foreach ( $entries as $entry ) {
                if($item_form_id != $entry->form_id){
					$fields = FrmField::get_all_for_form( $entry->form_id, '', 'include' );
                    $item_form_id = $entry->form_id;
                }
                
                $meta = FrmEntriesController::show_entry_shortcode(array(
                    'format' => 'array', 'include_blank' => true, 'id' => $entry->id,
                    'user_info' => false, //'entry' => $entry
                ));

                $entry_array[] = array_merge((array) $entry, $meta);
                
                unset($entry);
            }

            if ( isset($fields) ) {
                unset($fields);
            }
        }
        
        return $entry_array;
	}
    
}