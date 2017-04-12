<?php

require_once(dirname(dirname(dirname(dirname(__DIR__)))) . '/wp-load.php');

if (is_user_logged_in() ) {

	global $wpdb;
	$preview_id = $_GET['id'];

  $current_user = wp_get_current_user();
  $blitz_id = get_the_author_meta( 'host_blitz', $current_user->ID);

  // $blitz_id = 6956;
	

	 // $subject_id = getFieldIDFromFormidableForm(59, 'Subject Line');
   $content_id = getFieldIDFromFormidableForm(59, 'Email Message');
    
    $my_entry = FrmEntry::getOne($preview_id, true);
    
    // $subject = $my_entry->metas[$subject];
    $blitz_blurb = nl2br( $my_entry->metas[$content_id] );

    $msg = compileEmailToVolunteer($blitz_id, $blitz_blurb);

    echo $msg;




} else {

	wp_redirect( get_bloginfo('url') );
	
}