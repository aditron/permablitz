<?php

/**
    MODIFY THE ADMIN
*/

function wps_translation_mangler($translation, $text, $domain) {
    global $post;
    if (isset($post->post_type) && $post->post_type == 'newsletter') {
        $translations = get_translations_for_domain( $domain);
        if ( $text == 'Published on: <b>%1$s</b>') {
            return $translations->translate( 'Sent On: <b>%1$s</b>' );
        }
        if ( $text == 'Publish <b>immediately</b>') {
            return $translations->translate( 'Send <b>immediately</b>: <b>%1$s</b>' );
        }
        if ( $text == 'Publish' ) {
          return 'Send';
      }
  }
  return $translation;
}
add_filter('gettext', 'wps_translation_mangler', 10, 4);

function hide_publish_button_editor() {
global $post;
// print_g($post);
if ( (isset($post->post_type) && $post->post_type == 'newsletter')  && $post->post_status == 'publish') {
    ?>
    <style>
        a.edit-timestamp,
        .misc-pub-post-status,
        .misc-pub-visibility,
        .misc-pub-revisions,
        #revisionsdiv,
        #publishing-action { display: none; }
    </style>
    <?php
}
}
add_action( 'admin_head', 'hide_publish_button_editor' );


add_filter( 'manage_newsletter_posts_columns', 'set_custom_edit_newsletter_columns' );

function set_custom_edit_newsletter_columns( $columns ) {

    $columns['sendtype'] = __( 'Send Type', 'my-text-domain' );
    return $columns;
}

add_action( 'manage_newsletter_posts_custom_column', 'my_manage_newsletter_columns', 10, 2 );

function my_manage_newsletter_columns( $column, $post_id ) {
    global $post;

    switch( $column ) {

        /* If displaying the 'duration' column. */
        case 'sendtype' :

            echo get_field( 'send_type', $post_id );
        
            break;
    }
}

add_filter('manage_posts_columns', 'sendnews_column');
function sendnews_column($columns) {
  $new = array();
  foreach($columns as $key => $title) {
    if ($key=='date') // Put the Thumbnail column before the Author column
      $new['sendtype'] = 'Thumbnail';
    $new[$key] = $title;
  }
  return $new;
}

add_filter( 'post_date_column_time' , 'my_post_date_column_time' , 10 , 2 );

function my_post_date_column_time( $h_time, $post ) {
    $h_time = str_replace('Published', 'Sent', $h_time);
    return $h_time;
}



/**
    EMAIL HANDLING
*/

    function newsletter_send_newsletters_out($post_id) {

        $post_type = get_post_type($post_id);
        if ( "newsletter" != $post_type ) return;

        // AUTO BLITZ NOTIFICATION HANDLING
        $acf_blitz_id = 'field_58eeb29fb2018';

        if (isset($_POST['acf'][$acf_blitz_id])) {

            $acf_preview_text = 'field_58eeb29fb2425';
            $acf_send_type = 'field_58eeb29fb261d';
            $acf_recipient_list = 'field_58eeb29fb2bf9';
            $acf_recipient_each = 'field_58eeb2a079634';

            $fields = $_POST['acf'];

            $blitz_id = $fields[$acf_blitz_id];

            $send_type = $fields[$acf_send_type];

            $blitz_title = get_the_title( $blitz_id );
            $blitz_title = str_replace('&#8211;', '-', $blitz_title);

            //$terms = get_the_terms( $post->ID, 'newsletter_category' ); // needed??

            $preview_text = replacePwithBR( styleForEDM( cleanMarkupForEDM( wpautop( $fields[$acf_preview_text] ) ) ) ); // preview text

            $subject = 'Just announced: ' . $blitz_title ;

            $msg =  prepare_autoBlitz_notification( $blitz_id, $send_type, $preview_text );

            newsletter_send($post_id, $send_type, $msg, $subject, $acf_recipient_list, $acf_recipient_each);

        }

        // GUILD DESIGN REQUESTS HANDLING
        $acf_subject_id = 'field_58eefdb0b07ba';

        if (isset($_POST['acf'][$acf_subject_id])) {

            $acf_send_type = 'field_58eefdb0b14fb';
            $acf_recipient_list = 'field_58eefdb0b18db';
            $acf_recipient_each = 'field_58eefdb18586a';
            $acf_intro_text = 'field_58eefdb0b0b5f';
            $acf_hero_image = 'field_58eefe37394a8';

            $fields = $_POST['acf'];

            $subject = cleanMarkupForEDM( $fields[$acf_subject_id] );

            //$terms = get_the_terms( $post->ID, 'newsletter_category' ); // needed??

            $preview_text = replacePwithBR( styleForEDM( cleanMarkupForEDM( wpautop( $fields[$acf_intro_text] ) ) ) ); // preview text

            $msg =  prepare_guild_notification( $post_id, $preview_text, $fields[$acf_hero_image] );

            $send_type = $fields[$acf_send_type];

            newsletter_send($post_id, $send_type, $msg, $subject, $acf_recipient_list, $acf_recipient_each);

        }

        // BLITZ HOST INFO handling

        $acf_host_subject_id = 'field_5906da0aa6af3';

        if (isset($_POST['acf'][$acf_host_subject_id])) {

            // $acf_send_type = 'field_58eefdb0b14fb'; // totally redundant here
            $acf_recipient_list = 'field_5906d9a73c699';
            $acf_recipient_each = 'field_5906d9a7ac894';
            $acf_intro_text = 'field_5906db46b4f9d';
            $acf_preview_text = 'field_5906d9a73c0db';
            $acf_send_type = 'field_5906dd4de5bed';
            $acf_blitz_id = 'field_5906d9a73bd1e';

            $fields = $_POST['acf'];

            $subject = cleanMarkupForEDM( $fields[$acf_host_subject_id] );
            $blitz_id = $fields[$acf_blitz_id];
            $send_type = $fields[$acf_send_type]; 

            $preview_text = $fields[$acf_preview_text]; // preview text
            $intro_text = replacePwithBR( styleForEDM( cleanMarkupForEDM( wpautop( $fields[$acf_preview_text] ) ) ) );

            $msg =  prepare_hostBlitzInfo_notification( $blitz_id, $send_type, $preview_text, $intro_text );
            newsletter_send($blitz_id, $send_type, $msg, $subject, $acf_recipient_list, $acf_recipient_each);

        }



    }
    add_action('save_post', 'newsletter_send_newsletters_out', 10,3);

    function newsletter_send($post_id, $send_type='Test email', $msg, $subject, $acf_recipient_list=null, $acf_recipient_each=null) {

        $headers = "From: Permablitz Melbourne <permablitz@gmail.com>\r\n";
        $headers.= "Reply-To: Permablitz Melbourne <permablitz@gmail.com>\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $subject = stripslashes( str_replace('&#8217;', "'" , $subject) );

        switch ($send_type) {

            default:
            case 'Test email':
            $recipients = $_POST['acf'][$acf_recipient_list];
            $users = array();
            foreach ($recipients as $rec) {
                $to = $rec[$acf_recipient_each];
                $users[] = $to;
                $sent = wp_mail($to, $subject, $msg, $headers);
                newsletter_store_response( $post_id, $sent, implode(",", $users) );
            }
            break;

            case 'Send to Biz':
            $to = 'team@lists.permablitz.net';
            $sent = wp_mail($to, $subject, $msg, $headers); 
            newsletter_store_response( $post_id, $sent, 'The Biz' );
            break;

            case 'Send to AutoBlitz list':

            $to = 'autoblitz@lists.permablitz.net';
            $sent = wp_mail($to, $subject, $msg, $headers);
            $to = 'permablitz@gmail.com';
            wp_mail($to, $subject, $msg, $headers);
            newsletter_store_response( $post_id, $sent, 'The AutoBlitz List' );

            break;

            case 'Send to the Guild':
              $to = 'melb_designers@lists.permablitz.net';
              $sent = wp_mail($to, $subject, $msg, $headers);
                newsletter_store_response( $post_id, $sent, 'The Guild List' );
              $to = 'permablitz@gmail.com';
              wp_mail($to, $subject, $msg, $headers);
            break;
        }

    }

    function newsletter_store_response($post_id, $sent, $recipients) {

        $time = ' on ' . the_time('M d, Y @ h:ia');
        $was_sent = $sent ? ' was sent successfully ' : ' failed ';
        $status = "Newsletter send to " . $recipients . $was_sent . $time;
        update_post_meta( $post_id, 'newsletter_status', $status );

    }

    


function prepare_autoBlitz_notification( $blitz_id, $send_type, $preview_text=null ) {

        $blitz_image = wp_get_attachment_image_src( get_post_thumbnail_id( $blitz_id), 'email-hero' );

        $blitz_img = $blitz_image[0];
        $blitz_url = get_permalink( $blitz_id );

        $blitz_blurb = cleanMarkupForEDM( get_field( 'blurb_for_email', $blitz_id ) );

        $blitz_title = cleanMarkupForEDM( get_the_title( $blitz_id ) );
        $blitz_title = str_replace('&#8211;', '-', $blitz_title);

        $promo = otherEventNotifications($blitz_id, $args=array('limit' => 4, 'category' => 58), true, 'Other Upcoming Events'  );

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

        return $msg;
    }

function prepare_guild_notification($post_id, $intro_text, $guild_img_id) {

  $blitz_title = cleanMarkupForEDM( get_the_title( $post_id ) );

  $blitz_image = wp_get_attachment_image_src( $guild_img_id , 'email-hero' );
  $blitz_img = $blitz_image[0];
  $blitz_url = get_permalink( $post_id );
  $blitz_blurb = cleanMarkupForEDM( $intro_text );

  $promo = otherDesignsNeeded(1);

  $msg = file_get_contents( get_stylesheet_directory_uri() . '/email/guild_notification.html' );
  $msg = str_replace( '{{BLITZ_PAGE_TITLE}}', $blitz_title, $msg );
  $msg = str_replace( '{{BLITZ_TITLE}}', pbz_edm_show_title($blitz_title), $msg );
  $msg = str_replace( '{{BLITZ_IMG}}', $blitz_img, $msg );
  $msg = str_replace( '{{BLITZ_BLURB}}', pbz_edm_blurbarea($blitz_blurb), $msg );
  $msg = str_replace( '{{BLITZ_URL}}', $blitz_url, $msg );
  $msg = str_replace( '{{OTHER_EVENTS}}', $promo, $msg );
  $msg = str_replace( '{{SUPER_SCRIPT}}', '', $msg );

  return $msg;

}

function prepare_hostBlitzInfo_notification( $blitz_id, $send_type, $preview_text=null, $intro_text=null ) {
    
    $blitz_image = wp_get_attachment_image_src( get_post_thumbnail_id( $blitz_id ), 'email-hero' );

    $blitz_img = $blitz_image[0];
    $blitz_url = get_permalink( $blitz_id );

    $blitz_blurb = cleanMarkupForEDM( $intro_text );

    $blitz_title = cleanMarkupForEDM( get_the_title( $blitz_id ) );
    $blitz_title = str_replace('&#8211;', '-', $blitz_title);

    $promo = otherEventNotifications($blitz_id, $args=array('limit' => 4, 'category' => 58), true, 'Other Upcoming Events'  );

    $msg = file_get_contents( get_stylesheet_directory_uri() . '/email/blitz_notification.html' );
    $msg = str_replace( '{{BLITZ_PAGE_TITLE}}', $blitz_title, $msg );
    $msg = str_replace( '{{BLITZ_TITLE}}', '', $msg );
    $msg = str_replace( '{{BLITZ_IMG}}', $blitz_img, $msg );
    $msg = str_replace( '{{BLITZ_BLURB}}', pbz_edm_blurbarea($blitz_blurb), $msg );
    $msg = str_replace( '{{BLITZ_URL}}', $blitz_url, $msg );
    $msg = str_replace( '{{OTHER_EVENTS}}', $promo, $msg );
    $msg = str_replace( '{{GET_BLITZING}}', '', $msg);
    $msg = str_replace( '{{SUPER_SCRIPT}}', $preview_text, $msg);

    return $msg;
}