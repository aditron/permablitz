<?php

// Register Custom Post Type
function blitz_request_post_type() {

    $labels = array(
        'name'                => _x( 'Blitz Requests', 'Post Type General Name', 'text_domain' ),
        'singular_name'       => _x( 'Blitz Request', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'           => __( 'Blitz Request', 'text_domain' ),
        'name_admin_bar'      => __( 'Blitz Request', 'text_domain' ),
        'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
        'all_items'           => __( 'All Items', 'text_domain' ),
        'add_new_item'        => __( 'Add New Item', 'text_domain' ),
        'add_new'             => __( 'Add New', 'text_domain' ),
        'new_item'            => __( 'New Item', 'text_domain' ),
        'edit_item'           => __( 'Edit Item', 'text_domain' ),
        'update_item'         => __( 'Update Item', 'text_domain' ),
        'view_item'           => __( 'View Item', 'text_domain' ),
        'search_items'        => __( 'Search Item', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );
    $args = array(
        'label'               => __( 'blitz_request', 'text_domain' ),
        'description'         => __( 'Blitz Request Description', 'text_domain' ),
        'labels'              => $labels,
        'supports'            => array( 'editor', 'thumbnail', 'title', 'excerpt' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 20,
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
    );
    register_post_type( 'blitz-request', $args );

}

// Hook into the 'init' action
add_action( 'init', 'blitz_request_post_type', 0 );

/**


*/

add_action('frm_after_create_entry', 'record_designer', 30, 2);
function record_designer( $entry_id, $form_id ) {
 if($form_id == 14){ 

  $row = array(
  'field_56b6da2cb1985' => get_current_user_ID()
);

  add_row('field_56b6da1ab1984', $row);  

 }
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

if( function_exists('acf_add_options_sub_page') ) {
  
  // add parent
  $parent = acf_add_options_sub_page(array(
    'page_title'  => 'Send an Instant Guild Notification',
    'menu_title'  => 'Guild Notifications',
    'parent_slug'    => 'intant-blitz-notification'
  ));
  
}

/**

  FORMIDABLE INTEGRATION INTO ACF

*/

/* helper function to get formidable forms to ACF: */
function get_formidable_forms(){
  ob_start();
  FrmFormsHelper::forms_dropdown( 'frm_add_form_id' );
  $forms = ob_get_contents();
  ob_end_clean();
  preg_match_all('/<option\svalue="([^"]*)" >([^>]*)<\/option>/', $forms, $matches);
  $result = array_combine($matches[1], $matches[2]);
  return $result;
}

/* auto populate acf field with form IDs */
function load_forms_function( $field ){
  $result = get_formidable_forms();
  if( is_array($result) ){
    $field['choices'] = array();
    foreach( $result as $key=>$match ){
      $field['choices'][ $key ] = $match;
    }
  }
    return $field;
}
add_filter('acf/load_field/name=which_group', 'load_forms_function');

function sendBlitzNotification($post_id) {

  // bail early if no ACF data
    if( empty($_POST['acf']) ) {
        return;   
    }

    if (isset($_POST['acf']['field_5650014070b17'])) {

      $fields = $_POST['acf'];
      
      $blitz_id = $fields['field_5650014070b17'];

      
      $blitz_image = wp_get_attachment_image_src( get_post_thumbnail_id( $blitz_id, $args=array('limit' => 8)) , 'email-hero' );
      $blitz_img = $blitz_image[0];
      $blitz_url = get_permalink( $blitz_id );
      
      $send_type = $_POST['acf']['field_5650017a70b18'];

      $preview_text = stripslashes($_POST['acf']['field_57c2aeeae8684']); // preview text

      if( $_POST['acf']['field_5706334758086'] == 1 ) { // custom_message
        $blitz_blurb = nl2br( $_POST['acf']['field_5706339c58087'] ); // message

        $subject = stripslashes($_POST['acf']['field_57064b3448086']); // custom subject line
        $blitz_title = $subject;
      } else {
        $blitz_blurb = get_field( 'blurb_for_email', $blitz_id );
	
	     $blitz_title = get_the_title( $blitz_id );
        $blitz_title = str_replace('&#8211;', '-', $blitz_title);
        $subject = 'Just announced: ' . $blitz_title ;
      }
      
      $promo = otherEventNotifications($guild_id, $args=array('limit' => 4, 'category' => 58), true, 'Other Upcoming Events'  );

      $msg = file_get_contents( get_stylesheet_directory_uri() . '/email/blitz_notification.html' );
      $msg = str_replace( '{{BLITZ_PAGE_TITLE}}', $blitz_title, $msg );
      $msg = str_replace( '{{BLITZ_TITLE}}', '', $msg );
      $msg = str_replace( '{{BLITZ_IMG}}', $blitz_img, $msg );
      $msg = str_replace( '{{BLITZ_BLURB}}', pbz_edm_blurbarea($blitz_blurb), $msg );
      $msg = str_replace( '{{BLITZ_URL}}', $blitz_url, $msg );
      $msg = str_replace( '{{OTHER_EVENTS}}', $promo, $msg );
      if ($send_type == 'Send to Signups') {
        $msg = str_replace( '{{GET_BLITZING}}', '', $msg);
      } else {
        $msg = str_replace( '{{GET_BLITZING}}', getBlitzingCTA($blitz_url), $msg);        
      }
      $msg = str_replace( '{{SUPER_SCRIPT}}', $preview_text, $msg);

      $send_notes = 'field_565589fee28d4';
  
      // $prev_sends = get_field($send_notes, 'option');
      $prev_sends = $_POST['acf']['field_565589fee28d4'];
        
      $headers = "From: Permablitz Melbourne <permablitz@gmail.com>\r\n";
      $headers.= "Reply-To: Permablitz Melbourne <permablitz@gmail.com>\r\n";
      $headers .= "MIME-Version: 1.0\r\n";
      $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

      $subject = stripslashes( str_replace('&#8217;', "'" , $subject) );

      switch ($send_type) {
        default:
        case 'Test email':
            $recipients = $_POST['acf']['field_565001f170b19'];
            foreach ($recipients as $rec) {
                $to = $rec['field_5650020270b1a'];
                $sent = wp_mail($to, $subject, $msg, $headers);
              $_POST['acf'][$send_notes] = sendRecord($subject, $sent, $to) . $prev_sends;  
            }
        break;
        case 'Send to Signups':
            $form_id = $_POST['acf']['field_570565f302e22'];
            $recipients = getEmailsFromFormidableForm($form_id);
            foreach ($recipients as $rec) {
                $to = $rec;
                $sent = wp_mail($to, $subject, $msg, $headers);
                $_POST['acf'][$send_notes] .= sendRecord($subject, $sent, $to) . $prev_sends;  
            }
        break;
        case 'Send to Biz':
            $to = 'team@lists.permablitz.net';
            $sent = wp_mail($to, $subject, $msg, $headers);
          $_POST['acf'][$send_notes] = sendRecord($subject, $sent, 'the Biz List ') . $prev_sends;  
        break;
        case 'Send to AutoBlitz list':
          if (!get_post_meta( $post_id, 'notification_sent' ) ) {
            $to = 'autoblitz@lists.permablitz.net';
            $sent = wp_mail($to, $subject, $msg, $headers);
            $_POST['acf'][$send_notes] = sendRecord($subject, $sent, 'the Autoblitz List ') . $prev_sends;  
            $to = 'permablitz@gmail.com';
            wp_mail($to, $subject, $msg, $headers);
            if ($sent) {
              add_post_meta($post_id, 'notification_sent', time() );
            }
          }
        break;
      }
  
    }

}
add_action('acf/save_post', 'sendBlitzNotification', 1);

add_action('save_post_blitz-request', 'defaultDesignerInfo');
function defaultDesignerInfo($post_id, $post, $update){
    if (get_post_type($post_id) == 'blitz-request') {
      $form_display_id = get_post_meta($post_id, 'frm_display_id', true);
      $form_id = get_post_meta($form_display_id, 'frm_form_id', true);
      if ($form_id) {
        update_post_meta( $post_id, 'frm_form_id', $form_id );
        delete_post_meta($post_id, 'frm_display_id');
      }
      $roles = get_post_meta($post_id, '_members_access_role');
      if (!in_array('administrator', $roles)) {
        add_post_meta($post_id, '_members_access_role', 'administrator');
      }
      if (!in_array('designer', $roles)) {
        add_post_meta($post_id, '_members_access_role', 'designer');
      }
      $current_error = get_post_meta($post_id, '_members_access_error', true); 
      if ( trim($current_error) == '' || $_POST['_members_access_error'] == '') {
        update_post_meta( $post_id, '_members_access_error', get_field('default_login_message', 'option') );
        
      }

    }
}

add_action('save_post', 'delete_view_field');

function delete_view_field($post_id){
  if(isset($_POST['frm_wp_post_custom']) && isset($_POST['frm_wp_post_custom']['=frm_display_id'])){
    unset($_POST['frm_wp_post_custom']['=frm_display_id']);
    update_post_meta( $post_id, '_members_access_error', get_field('default_login_message', 'option') );        
  }

  if (isset($_POST['post_type']) && $_POST['post_type'] == 'post'){
      if (in_category('Newsletters')) {
          if (trim($_POST['acf']['field_56ac664002803']) != "") {
            /*
              $newsletter_id = $post_id;

            $newsletter_title = cleanMarkupForEDM( get_the_title( $newsletter_id ) );
          $post_url = get_permalink( $newsletter_id );

          $permablitz_news = do_shortcode('[permablitz_news edm="true" post_id='.$newsletter_id.']');
          $permablitz_news = styleForEDM($permablitz_news);

          $fb = do_shortcode('[facebook_posts edm="true"]');

          $data = get_fields($newsletter_id);
          $date = $data['month'];
          $date_parts = explode('/', $date);
    
          $start_month = date('Y-m-01', mktime(0,0,0,$date_parts[1],1,$date_parts[2]) );
          $end_month = date('Y-m-t', mktime(0,0,0,$date_parts[1],1,$date_parts[2]) );

          $blitz_blurb = $data[ 'introduction' ];
          $blitz_blurb = replacePwithBR( styleForEDM( cleanMarkupForEDM( $blitz_blurb ) ) );

          $hero_of_the_month = heroAndHerb( $newsletter_id);
          
          $bits_and_pieces = do_shortcode('[bits_and_pieces edm="true" post_id='.$newsletter_id.']' );
          $bits_and_pieces = styleForEDM($bits_and_pieces);

          $in_the_garden = inTheGarden($data, $newsletter_id);

          $superscript = $data['super_script'];

          $signoff = $data['sign-off'];

          $msg = file_get_contents( get_stylesheet_directory_uri() . '/email/newsletter.html' );
          $msg = str_replace( '{{SUPER_SCRIPT}}', $superscript, $msg );
          $msg = str_replace( '{{NEWSLETTER_TITLE}}', $newsletter_title, $msg );
          $msg = str_replace( '{{UPCOMING_BLITZES}}', pbz_upcomingBlitzes(), $msg );
          $msg = str_replace( '{{NEWSLETTER_IMG}}', $hero_image[0], $msg );
          $msg = str_replace( '{{BLITZ_BLURB}}', $blitz_blurb, $msg );
          $msg = str_replace( '{{NEWSLETTER_URL}}', $post_url, $msg );
          $msg = str_replace( '{{PERMABLITZ_NEWS}}', $permablitz_news, $msg);
          $msg = str_replace( '{{FACEBOOK_POSTS}}', $fb, $msg);
          $msg = str_replace( '{{HERO_OF_THE_MONTH}}', $hero_of_the_month, $msg);
          $msg = str_replace( '{{BITS_AND_PIECES}}', $bits_and_pieces, $msg);
          $msg = str_replace( '{{BACK_IN_THE_GARDEN}}', $in_the_garden, $msg );
          // $msg = str_replace( '{{SIGNOFF}}', $signoff, $msg );
          
          $msg = str_replace( '{{OTHER_EVENTS}}', otherEventNotifications($newsletter_id, array('category'=>58, 'scope' => $start_month .','.$end_month), true ), $msg );

            update_post_meta($post_id, 'newsletter', $msg); 
            */
            delete_post_meta( $post_id, 'newsletter' );

        }
      }
  }
}

function sendGuildNotification($post_id) {

  // bail early if no ACF data
    if( empty($_POST['acf']) ) {
        return;   
    }

    if (isset($_POST['acf']['field_56b853338537d'])) {

      $fields = $_POST['acf'];
      
      if (!get_post_meta( $post_id, 'notification_sent' ) ) {          

          $guild_intro = nl2br( $_POST['acf']['field_56a0a6973c2e1'] ) . '<br><br>';

          $blitz_or_event = $fields['field_56b853338537d'];

          if ($blitz_or_event == 'Blitz') {
            $guild_id = $fields['field_56a0a25782dd0'];   
	    $promo = otherDesignsNeeded($guild_id);
          } else {
            $guild_id = $fields['field_56b853608537e'];
	    // $promo = otherEventNotifications($guild_id, $args=array('limit' => 8)  );
      $promo = otherEventNotifications($guild_id, $args=array('limit' => 6, 'category' => 58), true, 'Other Upcoming Events'  );
          }

          $blitz_title = get_the_title( $guild_id );
          $blitz_image = wp_get_attachment_image_src( get_post_thumbnail_id( $guild_id) , 'email-hero' );
          $blitz_img = $blitz_image[0];
          $blitz_url = get_permalink( $guild_id );
          $blitz_blurb = $guild_intro;

          $msg = file_get_contents( get_stylesheet_directory_uri() . '/email/guild_notification.html' );
          $msg = str_replace( '{{BLITZ_PAGE_TITLE}}', $blitz_title, $msg );
          $msg = str_replace( '{{BLITZ_TITLE}}', pbz_edm_show_title($blitz_title), $msg );
          $msg = str_replace( '{{BLITZ_IMG}}', $blitz_img, $msg );
          $msg = str_replace( '{{BLITZ_BLURB}}', pbz_edm_blurbarea($blitz_blurb), $msg );
          $msg = str_replace( '{{BLITZ_URL}}', $blitz_url, $msg );
          $msg = str_replace( '{{OTHER_EVENTS}}', $promo, $msg );
          $msg = str_replace( '{{SUPER_SCRIPT}}', '', $msg );
      
          $blitz_title = str_replace('&#8211;', '-', $blitz_title);
      
          $subject = stripslashes($_POST['acf']['field_56a0a6723c2e0']);

          $send_type = $_POST['acf']['field_56a0a257831bb'];

          $send_notes = 'field_56a0a2578398e';

        $prev_sends = $_POST['acf'][ $send_notes ];
        
          $headers = "From: Permablitz Melbourne <permablitz@gmail.com>\r\n";
          $headers.= "Reply-To: Permablitz Melbourne <permablitz@gmail.com>\r\n";
          $headers .= "MIME-Version: 1.0\r\n";
          $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

          switch ($send_type) {
            default:
            case 'Test email':
                $recipients = $_POST['acf']['field_56a0a257835a9'];
                foreach ($recipients as $rec) {
                    $to = $rec['field_56a0a257a8dc3'];
                    $sent = wp_mail($to, $subject, $msg, $headers);
                  $_POST['acf'][$send_notes] .= sendRecord($subject, $sent, $to) . $prev_sends;  
                }
            break;
            case 'Send to Signups':
                $form_id = $_POST['acf']['field_56d72a21cffe5'];
                $recipients = getEmailsFromFormidableForm($form_id);
                foreach ($recipients as $rec) {
                    $to = $rec;
                    $sent = wp_mail($to, $subject, $msg, $headers);
                    $_POST['acf'][$send_notes] .= sendRecord($subject, $sent, $to) . $prev_sends;  
                }
            break;
            case 'Send to Biz':
                $to = 'team@lists.permablitz.net';
                $sent = wp_mail($to, $subject, $msg, $headers);
              $_POST['acf'][$send_notes] = sendRecord($subject, $sent, 'the Biz List ') . $prev_sends;  
            break;
            case 'Send to the Guild':
              $to = 'melb_designers@lists.permablitz.net';
              $sent = wp_mail($to, $subject, $msg, $headers);
              $_POST['acf'][$send_notes] = sendRecord($subject, $sent, 'the Guild List ') . $prev_sends;  
              $to = 'permablitz@gmail.com';
              wp_mail($to, $subject, $msg, $headers);
            break;
          }

        }
    
    }

}
add_action('acf/save_post', 'sendGuildNotification', 1);


function otherDesignsNeeded($post_id) {
  $events = array();
  $img = array();

  $args = array(
        'post_type' => 'blitz-request',
        'post__not_in' => array($post_id),
        'posts_per_page' => -1
        );
  $posts_array = get_posts( $args );
  $myposts = get_posts( $args );
foreach ( $myposts as $post ) : setup_postdata( $post ); 

    $img[] = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID) , 'email-thumb' );

    $events[] = array(
                            'title' => get_the_title( $post->ID ),
                            'id' => $post->ID,
                            'url' => get_permalink($post->ID),
                            'date' => get_the_date('l, jS M', $post->ID )
                            );

 endforeach; 
wp_reset_postdata();
     if (count($events) >= 1) {
      return otherEventsTop($events, $img[1][0], true, true);
    } else {
      return false;
    }
}

/**

    DESIGNERS APPLIED ALREADY

**/

function designers_applied($target='web'){
    global $frmdb;
    $ids = $frmdb->get_col($frmdb->entries);
    $entries = count($ids);
    if ($target == 'web') {
      return $entries;
    } else {
      if ($entries <> 1) {
        return 'There are '. $entries . ' designers interested in this blitz.';
      } else {
        return 'There is 1 designer interested in this blitz';
      }
    }
}

function cleanLI(&$value, $key) {
  $value = str_replace("</li>", "", $value);  
}

function getEmailsFromFormidableForm($form_id, $type='Yes') {

  global $wpdb;
  $email_id = $wpdb->get_var( "SELECT id FROM pbz_frm_fields WHERE form_id = $form_id AND type='email' " );
  $attending_id = $wpdb->get_var( "SELECT id FROM pbz_frm_fields WHERE form_id = $form_id AND name='Attending' " );
// this gets you the list of IDs
$query = "

SELECT distinct(M2.meta_value)
FROM  `pbz_frm_items` as I
INNER JOIN `pbz_frm_item_metas` as M
ON M.item_id = I.id 
INNER JOIN `pbz_frm_item_metas` as M2
ON M2.item_id = I.id 
WHERE  I.form_id = $form_id
AND (M.field_id = $attending_id AND M.meta_value = '$type') 
AND M2.field_id = $email_id
";
$data = $wpdb->get_results( $query, ARRAY_A ); 
$people = array();
foreach ($data as $d) {
	array_push($people, $d['meta_value']);
}
  return $people;
}

