<?php

	global $post;


	$blitz_id = get_field( 'blitz_to_promote', $post->ID );

	$terms = get_the_terms( $post->ID, 'newsletter_category' );

	// echo $terms[0]->name;

	switch($terms[0]->name) {

		case 'Instant Blitz Notification':
			$send_type = get_field( 'send_type', $post->ID );
			$preview_text = get_field( 'preview_text', $post->ID );
			echo prepare_autoBlitz_notification( $blitz_id, $send_type, $preview_text );
		break;

		case 'Guild Design Requests':
			$send_type = get_field( 'send_type', $post->ID );
			$subject = get_field( 'subject', $post->ID );
			$preview_text = get_field( 'intro_text', $post->ID );
			$hero_image = get_field( 'hero_image', $post->ID );
			echo prepare_guild_notification( $post->ID, $preview_text, $hero_image );
		break;

		case 'Blitz Host Info':
			$send_type = get_field( 'send_type', $post->ID );
			$subject = get_field( 'subject', $post->ID );
			$preview_text = get_field( 'preview_text', $post->ID );
			$intro_text = get_field( 'intro_text', $post->ID );
			$blitz_id = get_field( 'blitz_to_reference', $post->ID );
			echo prepare_hostBlitzInfo_notification( $blitz_id, $send_type, $preview_text, $intro_text );
		break;

	}