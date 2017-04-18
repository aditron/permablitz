<?php
/* ------------------------------------------------------------------------- *
 *  Custom functions
/* ------------------------------------------------------------------------- */
	
require_once( dirname( __FILE__ ) . '/inc/custom-post-types.php' );
require_once( dirname( __FILE__ ) . '/inc/acf.php' ) ;
require_once( dirname( __FILE__ ) . '/inc/blitz-requests.php' );
require_once( dirname( __FILE__ ) . '/inc/email-notifications.php' );
require_once( dirname( __FILE__ ) . '/inc/hosts-and-vols.php' );
require_once( dirname( __FILE__ ) . '/inc/newsletters.php' );
require_once( dirname( __FILE__ ) . '/inc/fb_posts.php' );
require_once( dirname( __FILE__ ) . '/inc/widgets.php' );
require_once( dirname( __FILE__ ) . '/inc/shortcodes.php' ) ;
// require_once( dirname( __FILE__ ) . '/functions/widgets/alx-posts.php' );
require_once( dirname( __FILE__ ) . '/functions/widgets/alx-tabs.php' );
require_once( dirname( __FILE__ ) . '/functions/widgets/em-widgets.php' );
require_once( dirname( __FILE__ ) . '/inc/guild_members.php' );
require_once( dirname( __FILE__ ) . '/inc/menu-cache.php' );
// require_once( dirname( __FILE__ ) . '/inc/widget-cache.php' );


add_image_size( 'logo-standard', 320, 320 );
add_image_size( 'email-thumb', 388, 288, 1 );
add_image_size( 'email-hero', 590, 280, 1);
add_image_size( 'fb-thumb', 240, 240, 1);


function mapDescription($atts) {

	global $wpdb;

	$a = shortcode_atts( array(
        'location' => null,
    ), $atts );

	$map_locations_records = $wpdb->get_row($wpdb->prepare("SELECT * FROM ".$wpdb->prefix."map_locations where location_id=%d",$a['location']));
    
	$unmess_info_message = unserialize(base64_decode($map_locations_records->location_messages));

	return wpautop( stripslashes($unmess_info_message['googlemap_infowindow_message_one']) );


}

add_shortcode( 'mapdescription', 'mapDescription' );

function wpb_add_google_fonts() {

wp_enqueue_style( 'wpb-google-fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,300italic,300,400italic,600&subset=latin,latin-ext', false ); 
}

// add_action( 'wp_enqueue_scripts', 'wpb_add_google_fonts' );

/*  Enqueue javascript
/* ------------------------------------ */	
if ( ! function_exists( 'pbz_scripts' ) ) {

	function pbz_scripts() {
		if ( is_singular() ) { wp_enqueue_script( 'cycle2', get_stylesheet_directory_uri() . '/js/jquery.cycle2.js', array( 'jquery' ),'', true ); }
  wp_enqueue_script( 'matchHeight', get_stylesheet_directory_uri() . '/js/jquery.matchHeight.js', array( 'jquery' ),'', false );
	 wp_enqueue_script( 'owl', get_stylesheet_directory_uri() . '/js/owl.carousel.min.js', array( 'jquery' ),'', false );
  wp_enqueue_style( 'owl-style', get_stylesheet_directory_uri().'/js/assets/owl.carousel.css' );
  wp_enqueue_script( 'pbz_js', get_stylesheet_directory_uri() . '/js/jquery.functions.js', array( 'jquery' ),'', false );
  
  }  
	
}
add_action( 'wp_enqueue_scripts', 'pbz_scripts' ); 

function pbz_columns($atts) {

	$a = shortcode_atts( array(
        'location' => null,
    ), $atts );

    global $post;

    $columns = get_field('columns', get_the_ID() );

    $output = '';

    foreach($columns as $column) {

    	if ($column['image_position'] == 'Left') {
    		$col_1 = '';
    		if ($column['website'] != '') {
	    		$col_1 = '<a href="' . $column['website'] . '" target="_blank">';
	    	}
    		$col_1 .= wp_get_attachment_image( $column['image'], 'logo-standard', false, array( 'class' => 'attachment-logo-standard aligncenter' ) ); 
    		if ($column['website'] != '') {
	    		$col_1 .= '</a>';
	    	}
    	} else {
    		$col_1 = $column['content'];
    	}
    	$output .= do_shortcode('[column size="one-half"]'.$col_1.'[/column]');
    	if ($column['image_position'] == 'Right') {
    		$col_2 = '';
    		if ($column['website'] != '') {
	    		$col_2 = '<a href="' . $column['website'] . '" target="_blank">';
	    	}
    		$col_2 .= wp_get_attachment_image( $column['image'], 'logo-standard', false, array( 'class' => 'attachment-logo-standard aligncenter' ) );  
    		if ($column['website'] != '') {
	    		$col_2 .= '</a>';
	    	}
    	} else {
    		$col_2 = $column['content'];
    	}
    	$output .= do_shortcode('[column size="one-half" last="true"]'.$col_2.'[/column]');

    }

	return $output;
}

add_shortcode( 'pbz_columns', 'pbz_columns');



add_filter('frmpro_fields_replace_shortcodes', 'frm_make_shortcode', 10, 4);

function frm_make_shortcode($replace_with, $tag, $atts, $field){
  if(isset($atts['link_full'])){
     $new_val = '';
     foreach((array)$replace_with as $v){
       if(is_numeric($v)){
         $full = wp_get_attachment_image_src($v, 'full');
         $thumb = wp_get_attachment_image_src($v);
         $new_val .= '<a href="'. $full[0] .'"><img src="'. $thumb[0] .'" /></a>';
       }
     }
     return $new_val;
  }
  return $replace_with;
}

  // custom admin login logo
function custom_login_logo() {
  echo '<style type="text/css">
  .login h1 a { background-image: url('.get_stylesheet_directory_uri().'/img/logo.png) !important; display:block; background-size:320px 90px; width:320px!important;height:90px!important }
  </style>';
}
add_action('login_head', 'custom_login_logo');

function updatedEvent_send_email( $post_id, $post ) {

  if ($post->post_type == 'event') {

    if (has_term('upcoming-blitzes','event-categories', $post_id)) {
      $post_title = get_the_title( $post_id );
      $post_url = get_permalink( $post_id );
      $subject = 'An event has been added - ' . $post_title;

      $message = "An event has been added to the Permablitz website:\n\n";
      $message .= $post_title . ": " . $post_url;

      // Send email to admin.
      wp_mail( 'melb_newblitzalert@lists.permablitz.net', $subject, $message );
       
    }
  }
 }
add_action( 'publish_post', 'updatedEvent_send_email', 10, 2 );


function list_designers() {
  global $post;

  $terms = get_the_terms( $post->ID, 'designer' );
            
if ( $terms && ! is_wp_error( $terms ) ) : 

  foreach ( $terms as $term ) {
    $output .= '<a href="'.get_term_link($term).'">' . $term->name . '</a>' . "\n";
  }

  if ($term->count > 1 ) {
    $designer = 'Designers';
  } else {
    $designer = 'Designer';
  }
            
?>
<p class="post-tags designer-tags">
  <span><?php echo $designer; ?>: </span> 
  <?php echo $output; ?>
</p>

<?php endif;

}


/**

  BLITZ NOTIFICATION EMAILS

*/

if( function_exists('acf_add_options_page') ) {
 
  $page = acf_add_options_page(array(
    'page_title'  => 'Send an Instant Blitz Notification',
    'menu_title'  => 'Blitz Notifications',
    'menu_slug'   => 'intant-blitz-notification',
    'capability'  => 'edit_posts',
    'icon_url'    => get_stylesheet_directory_uri() . '/img/permablitz_icon_16x16.png',
    'redirect'    => false
  ));
 
}


function sendRecord($subject, $sent, $who) {
  $success = $sent ? ' sent successfully ' : ' failed ';
  $report = $subject .' email to ' .$who . $success . 'at ' . current_time('Y/m/d h:ia') . '.' . "\n";
  return $report;
}



function otherEventNotifications($blitz_id=0, $args=array('limit' => 6, 'category' => 58), $grid=false, $title="This Month's Events" ) {

    $events = array();

    $i = 0;

    $limit = isset($args['limit']) ? $args['limit'] : null;
    if ($limit) {
    $args['limit'] = $limit+1;      
    }

    $EM_Events = EM_Events::get($args);
    foreach ( $EM_Events as $EM_Event ) {
     $event_id = $EM_Event->event_id;
     $post_id = $EM_Event->post_id;

        $date_and_time = $EM_Event->output('#_{l, jS M}, #_EVENTTIMES');

        if ($blitz_id != $post_id && $i<$limit) {
          if ($i == 0) {
                  $img = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id) , 'email-thumb' );
                }
                $i++;

                 $events[] = array(
                            'title' => get_the_title($post_id),
                            'id' => $post_id,
                            'url' => get_permalink($post_id),
                            'date' => $date_and_time
                            );
          }
    }
   if (count($events) >= 1) {
      return otherEventsTop($events, $img[0], 0, $grid, $title);
    } else {
      return false;
    }
    
}

function otherEventsTop($events, $img, $guild=0, $updated=false, $title="This Month's Events") {

    if ($guild) {
      //$bgcolor = '82b965';
      $bgcolor = 'ffffff';
      $color = 'e6f1e0';
      $border = 'ffffff';
      $link = 'blitz-request';
      $title = 'Other Blitz Requests';
      $extra = 'We\'ve made further changes to the way we handle blitz requests - hopefully this will be easier for people! Just follow the links above, and login when prompted. Don\'t have a password or don\'t know it? Just use the Lost Password link - easy!';
      $extra .= '<br/><br/>If you have any trouble, just send us an email at <a style="color: #000000; font-weight: bold;" href="mailto:permablitz@gmail.com">permablitz@gmail.com</a> with the subject line "Technology sucks" and a brief description of what went wrong.<br/><br/>';
    } else {
      $bgcolor = 'ffffff';
      $color = '626262';
      $border = '4d4032';
      $link = 'events';
      $extra = '';
    }
    
    if (!$updated) {
    $output = '<tr>
                  <td width="600" class="emailWidthAuto" bgcolor="#'.$bgcolor.'" style="background-color:#'.$bgcolor.';" valign="top">
                      <table width="600" class="emailWidthAuto" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#'.$bgcolor.'" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#' . $color . '; background-color:#'.$bgcolor.';">
                          <tr>
                              <td width="30">&nbsp;</td>
                              <td height="25">&nbsp;</td>
                              <td width="30">&nbsp;</td>
                            </tr>
                          <tr>
                              <td width="30">&nbsp;</td>
                              <td>
                                  <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#'.$bgcolor.'" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#' . $color . '; background-color:#'.$bgcolor.';">
                                      <tr>
                                          <td width="175" valign="top" class="emailFloatLeft">
                                              <table width="175" class="emailWidthAuto" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#'.$bgcolor.'" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#333333; background-color:#'.$bgcolor.';">
                                                  <tr>
                                                      <td width="169" class="emailWidthAuto" style="border:3px solid #'.$border.';"><a href="http://www.permablitz.net/'.$link.'/"><img src="'.$img.'" width="169" height="125" alt="" border="0" style="display:block;" class="emailWidthAuto"></a></td>
                                                    </tr>
                                                </table>
                                            </td>
                                          <td width="25" height="10" class="emailFloatLeft">&nbsp;</td>
                                          <td valign="top" class="emailFloatLeft">
                                              <table width="100%" align="center" cellpadding="0" cellspacing="0" border="0" bgcolor="#'.$bgcolor.'" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:16px; color:#' . $color . '; background-color:#'.$bgcolor.';">
                                                  <tr>
                                                      <td style="font-size:18px; line-height:18px; font-weight:bold;">'.$title.'</td>
                                                    </tr>
                                                  <tr>
                                                      <td style="font-size:10px; line-height:10px;">&nbsp;</td>
                                                    </tr>
                                                  <tr>
                                                      <td style="font-size:12px; line-height:16px;" class="emailFloatLeft">';
                                    foreach($events as $event) {
                                      $output .= '<a href="'.$event['url'].'" style="color: #000000; font-weight: bold;">'.$event['title'].'</a>
                                                        <br>
                                                        '.$event['date'].'
                                                        <br><br>
                                                        ';
                                      }
                                      $output .= $extra;
                                      $output .= '</td>
                                                    </tr>';

                                                    

                                      $output .= '</table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                              <td width="30">&nbsp;</td>
                            </tr>
                          <tr>
                              <td width="30">&nbsp;</td>
                              <td height="25">&nbsp;</td>
                              <td width="30">&nbsp;</td>
                            </tr>
                        </table>
                    </td>
                </tr>';  
              } else {
                  $output = '<tr>
                                    <td style="font-size:20px; line-height:22px; color:#3c3c3c; border-top:#a9a9a9 1px solid; padding-top:20px; font-weight:bold;">' . $title . '</td>
                                </tr>
				<tr>
                                    <td style="padding-top:20px;">
                                    	<table border="0" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:18px; color:#3c3c3c" width="100%">';
					  $i = 0;
                                      foreach($events as $event) {
				      	$i++;
					if ($i%2==1) {
						$output .= '<tr><td width="290" bgcolor="#ffffff" class="emailFloatLeft" valign="top">';
					}
                                        $hero = wp_get_attachment_image_src( get_post_thumbnail_id( $event['id']) , 'thumb-medium' );
                              $output .= '
                                              <table align="left" cellpadding="0" cellspacing="0" border="0" bgcolor="#'.$bgcolor.'" style="font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:17px; color:#' . $color . '; background-color:#'.$bgcolor.'; ">
                                                  <tr>
                                                      <td>
                                                          <a href="'.$event['url'].'"><img src="'.$hero[0].'" alt="" class="emailWidthAuto" width="290" /></a>
                                                      </td>
                                                  </tr>
                                                  <tr>
                                                      <td style="padding: 5px 15px 0 5px">';
                                                          
							  if (!$guild) {
                                                        $output .= '<a href="'.$event['url'].'" style="color: #000000; font-weight: bold; font-size:13px;text-decoration:none">'.$event['title'].'</a>
                                                          <br><em>'.$event['date'].'</em><br><br><br>';
                                                        }
                                                      $output .= '</td>';
                                                      if ($guild) {
                                                      $output .= '<tr>';
                                                      $output .= '<td style="padding:0px 20px 20px 20px;">
                                                                <table width="220" cellspacing="0" cellpadding="0" border="0" style="color:#46629e; font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:8px;">
                                                                    <tr>
                                                                        <td width="220" align="center" style="font-size:14px; line-height:16px; background-color:#45562f; color:#ffffff;"><a style="display:block; color:#ffffff; text-decoration:none; padding:8px 0;" href="'.$event['url'].'">Join Team '.ucwords($event['title']).'!</a></td>
                                                                    </tr>
                                                                </table>
                                                            </td>';
                                                      $output .= '</tr>';
                                                    }
                                                    $output .= '</tr>
                                              </table>
                                                        ';
							
					      if ($i%2==1) {
						$output .= '</td><td width="26" class="emailFloatLeft">&nbsp;</td><td width="290" bgcolor="#ffffff" class="emailFloatLeft" valign="top">';
					}
					if (count($events) == $i && $i%2==1) {
						$output .= '</td><td width="26" class="emailFloatLeft">&nbsp;</td><td width="290" bgcolor="#ffffff" class="emailFloatLeft" valign="top">';
					}
					if ($i%2==0) {
						$output .= '</td></tr>';
					}
	
                                      }
				      
                                      $output .= '                                            
                                    </table>
                        </td>';
			if ($extra) {
				      $output .= '<tr>
									<td style="padding:20px 0px 20px 0px; font-size:16px; line-height:18px;">'.$extra.'</td>
								</tr>';
								}
                    $output .= '</tr>';
              }

                return $output;
} 

/**

  ACF OPTIONS

**/

if( function_exists('acf_add_options_page') ) {

  acf_add_options_sub_page(array(
    'page_title'  => 'Map Setup',
    'menu_title'  => 'Map Settings',
    'parent_slug'   => 'edit.php?post_type=blitz-request'
  ));
  
}

/**
* Custom
* Make excerpt visible on protected posts
**/
function my_excerpt_protected( $excerpt ) {
if ( post_password_required() )
{
$post = get_post();
$excerpt=$post->post_excerpt;
}
return $excerpt;
}
add_filter( 'the_excerpt', 'my_excerpt_protected' );

function pbz_get_the_excerpt($post_id) {
  global $post;  
  $save_post = $post;
  $post = get_post($post_id);
  $output = get_the_excerpt();
  $post = $save_post;
  return $output;
}

/**

    DESIGNERS STUFF

*/

// show admin bar only for admins and editors
if (!current_user_can('edit_posts')) {
  add_filter('show_admin_bar', '__return_false');
}

function redirect_users_by_role() {
 
    $current_user   = wp_get_current_user();
    if ($current_user) {
      $role_name      = $current_user->roles[0];
      if ( 'designer' === $role_name ) {
          wp_redirect( 'http://www.permablitz.net/blitz-request/' );
      } 
    }
 
} // cm_redirect_users_by_role
add_action( 'admin_init', 'redirect_users_by_role' );

add_filter('frm_setup_new_fields_vars', 'populate_designer_details', 20, 2);
function populate_designer_details($values, $field){
if($field->id == 149){//name
      global $current_user;
      get_currentuserinfo();
   $values['value'] = trim($current_user->user_firstname);
}

if($field->id == 379){//name
      global $current_user;
      get_currentuserinfo();
   $values['value'] = trim($current_user->user_lastname);
}

if($field->id == 150){//email
      global $current_user;
      get_currentuserinfo();
   $values['value'] = $current_user->user_email;
}
return $values;
}


function yoasttobottom() {
  return 'low';
}

add_filter( 'wpseo_metabox_prio', 'yoasttobottom');

add_filter('frm_send_new_user_notification', 'frm_stop_user_notification', 10, 4);
 
function frm_stop_user_notification($send, $form, $entry_id, $entry){ return false; }

function _remove_script_version( $src ){
$parts = explode( '?ver', $src );
return $parts[0];
}
add_filter( 'script_loader_src', '_remove_script_version', 15, 1 );
add_filter( 'style_loader_src', '_remove_script_version', 15, 1 );

function cleanMarkupForEDM($content) {
  return stripslashes(htmlspecialchars_decode(htmlentities(replacePwithBR($content), ENT_NOQUOTES, 'UTF-8'), ENT_NOQUOTES));
}

function replacePwithBR($content) {
  $content = str_replace('<p>', '', $content);
  $content = str_replace('</p>', '<br /><br />', $content);
  return $content;
}

function styleForEDM($content, $color="#000000") {
  // $content = ($content);
  $doc = new DOMDocument();
  $doc->loadHTML($content, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
  $links = $doc->getElementsByTagName('a');
  foreach ($links as $item) {
      if (!$item->hasAttribute('style'))
          $item->setAttribute('style','color: '.$color.'; font-weight:bold');  
  }
  $content=$doc->saveHTML();
  $content = str_replace( array('<p>','</p>'),'', $content);
  return $content;
}

function wp_get_attachment( $attachment_id ) {

$attachment = get_post( $attachment_id );
  return array(
      'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
      'caption' => $attachment->post_excerpt,
      'description' => $attachment->post_content,
      'href' => get_permalink( $attachment->ID ),
      'src' => $attachment->guid,
      'title' => $attachment->post_title
  );
}

function optimize_jquery() {
  if (!is_admin()) {
    wp_deregister_script('jquery-migrate.min');
    wp_deregister_script('comment-reply.min');
    $protocol='http:';
    if( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') {
      $protocol='https:';
    }
  }
}
add_action('template_redirect', 'optimize_jquery');

function clear_transients( $post_id ) {
  delete_transient( 'tag_cloud' );
  delete_transient( 'latest_posts' );
  delete_post_meta( $post_id, 'post_content_php' );
  delete_post_meta( $post_id, 'post_content_featured_php' );
}
add_action( 'save_post', 'clear_transients' );
function post_update( $ID,$post) {
  clear_transients($ID);
}

add_action(  'publish_post',  'post_update', 10, 2 );

function check_scheduled_posts ($new_status, $old_status, $post) {

    if (($old_status == 'future') && ($new_status == 'publish')) {
           clear_transients($post->ID);
    }
}

// add_action ('transition_post_status', 'check_scheduled_posts');

/**

  ADD CUSTOM STYLES

*/

function wpb_mce_buttons_2($buttons) {
  array_unshift($buttons, 'styleselect');
  return $buttons;
}
add_filter('mce_buttons_2', 'wpb_mce_buttons_2');

/*
* Callback function to filter the MCE settings
*/

function my_mce_before_init_insert_formats( $init_array ) {  

// Define the style_formats array

  $style_formats = array(  
    // Each array child is a format with it's own settings
    array(  
      'title' => 'Grey block',  
      'block' => 'div',  
      'classes' => 'grey-block',
      'wrapper' => true,
    )
  );  
  // Insert the array, JSON ENCODED, into 'style_formats'
  $init_array['style_formats'] = json_encode( $style_formats );  
  
  return $init_array;  
  
} 
// Attach callback to 'tiny_mce_before_init' 
add_filter( 'tiny_mce_before_init', 'my_mce_before_init_insert_formats' ); 

function my_theme_add_editor_styles() {
    add_editor_style( 'custom-editor-style.css' );
}
add_action( 'init', 'my_theme_add_editor_styles' );

function pbz_widgets_init() {
  register_sidebar( array(
    'name'          => __( 'Login Widget Area', 'twentyfifteen' ),
    'id'            => 'sidebar-login',
    'description'   => __( 'Add widgets here to appear in your login area.', 'permablitz' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ) );
  register_sidebar( array(
    'name'          => __( 'Guild Area', 'twentyfifteen' ),
    'id'            => 'sidebar-guild',
    'description'   => __( 'Add widgets here to appear in the guild section.', 'permablitz' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ) );
  register_sidebar( array(
    'name'          => __( 'Single Column', 'twentyfifteen' ),
    'id'            => 'sidebar-single',
    'description'   => __( 'Add widgets here when using a 2column template.', 'permablitz' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ) );
  register_sidebar( array(
    'name'          => __( 'Host Sidebar', 'twentyfifteen' ),
    'id'            => 'host-sidebar',
    'description'   => __( 'Add widgets here for use with Host pages.', 'permablitz' ),
    'before_widget' => '<div id="%1$s" class="widget %2$s">',
    'after_widget'  => '</div>',
    'before_title'  => '<h2 class="widget-title">',
    'after_title'   => '</h2>',
  ) );
}
add_action( 'widgets_init', 'pbz_widgets_init' );

/**
 * Function to get ID of the Formidable form or field from form/field key
 * Source - https://formidablepro.com/help-desk/keys-vs-ids/ (note that there is a typo in the example code - last ")" was missed)
 *
 * @uses globals $frmdb, $wpdb
 * @param $form_or_field - string with two possible values: 'form' or 'field'
 * @param $key - string with key of the Formidable form or field
 * @return $id_from_key - numeric ID
 **/
function get_id_from_key_frm ( $key, $form_or_field='field' ) { 
 global $frmdb, $wpdb;
 // Getting form ID using form_key
 if ( $form_or_field == 'form' && $key != '' ) {
 $id_from_key = $wpdb->get_var($wpdb->prepare("SELECT id from $frmdb->forms WHERE form_key = %s", $key));
 // Getting field ID using field_key
 } elseif ( $form_or_field == 'field' && $key != '' ) {
 $id_from_key = $wpdb->get_var($wpdb->prepare("SELECT id from $frmdb->fields WHERE field_key=%s", $key));
 }
 if (is_numeric($id_from_key)){
 return $id_from_key;
 }
}

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// Disable W3TC footer comment for everyone but Admins (single site) / Super Admins (network mode)
if ( !current_user_can( 'unfiltered_html' ) ) {
    add_filter( 'w3tc_can_print_comment', '__return_false', 10, 1 );
}
