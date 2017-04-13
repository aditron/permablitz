<?php

/**
    MODIFY THE ADMIN
*/

function wps_translation_mangler($translation, $text, $domain) {
        global $post;
    if ($post->post_type == 'newsletter') {
        $translations = &get_translations_for_domain( $domain);
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
 if ($post->post_type == 'newsletter' && $post->post_status == 'publish') {
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

/**
    EMAIL HANDLING
*/

function newsletter_send_autoBlitz_notification($post_id) {

    $post_type = get_post_type($post_id);
    if ( "newsletter" != $post_type ) return;

    $acf_blitz_id = 'field_58eeb29fb2018';
    $acf_preview_text = 'field_58eeb29fb2425';
    $acf_send_type = 'field_58eeb29fb261d';
    $acf_recipient_list = 'field_58eeb29fb2bf9';
    $acf_recipient_each = 'field_58eeb2a079634';

    print_r($_POST); 

    if (isset($_POST['acf'][$acf_blitz_id])) {

      $fields = $_POST['acf'];
      
      $blitz_id = $fields[$acf_blitz_id];
      echo $blitz_id;
      die();

      $send_type = $fields[$acf_send_type];

      $preview_text = stripslashes($fields[$acf_preview_text]); // preview text

      $blitz_title = get_the_title( $blitz_id );
      $blitz_title = str_replace('&#8211;', '-', $blitz_title);

      $subject = 'Just announced: ' . $blitz_title ;

      $msg = prepare_autoBlitz_notification( $blitz_id, $preview_text );
  
      newsletter_send($send_type, $subject, $acf_recipient_list, $acf_recipient_each);
  
    }

}
add_action('save_post', 'newsletter_send_autoBlitz_notification', 10,3);

function prepare_autoBlitz_notification( $blitz_id, $preview_text=null ) {

    $blitz_image = wp_get_attachment_image_src( get_post_thumbnail_id( $blitz_id, 'email-hero' ) );
    $blitz_img = $blitz_image[0];
    $blitz_url = get_permalink( $blitz_id );

    $blitz_blurb = get_field( 'blurb_for_email', $blitz_id );

    $blitz_title = get_the_title( $blitz_id );
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

function newsletter_send($send_type='Test email', $subject, $acf_recipient_list=null, $acf_recipient_each=null) {

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
  }

}

function newsletter_store_response($post_id, $recipients, $sent) {

    $time = ' on ' . date('M d, Y @ h:ia');
    $was_sent = $sent ? ' was sent successfully ' : ' failed ';
    $status = "Newsletter send to " . $recipients . $was_sent . $time;
    update_post_meta( $post_id, 'newsletter_status', $status );

}