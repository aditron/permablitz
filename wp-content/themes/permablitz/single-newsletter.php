<?php

	global $post;

	$blitz_id = get_field( 'blitz_to_promote', $post->ID );

	echo prepare_autoBlitz_notification( $blitz_id );