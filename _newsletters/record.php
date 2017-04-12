<?php

//ini_set('display_errors', 'On');
//error_reporting(E_ALL | E_STRICT);

include( dirname(dirname(__FILE__)) . '/wp-load.php');

if( !empty( $_GET['cmp'] ) ) {
	global $wpdb;
	$wpdb->insert( 
		'pbz_campaign_tracking', 
		array( 
			'campaign' => $_GET['cmp'], 
			'ip' => $_SERVER['REMOTE_ADDR'],
			'useragent' => $_SERVER['HTTP_USER_AGENT'],
			'referer' => isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : ''
		), 
		array( 
			'%s', 
			'%s', 
			'%s', 
			'%s' 
		) 
	);
	
	//Begin the header output
	header( 'Content-Type: image/gif' );

    	//Full URI to the image
	$graphic_http = 'http://permablitz.net/_newsletters/common/blank.gif';

	//Get the filesize of the image for headers
	$filesize = filesize( 'common/blank.gif' );

	//Now actually output the image requested (intentionally disregarding if the database was affected)
	header( 'Pragma: public' );
	header( 'Expires: 0' );
	header( 'Cache-Control: must-revalidate, post-check=0, pre-check=0' );
	header( 'Cache-Control: private',false );
	header( 'Content-Disposition: attachment; filename="blank.gif"' );
	header( 'Content-Transfer-Encoding: binary' );
	header( 'Content-Length: '.$filesize );
	readfile( $graphic_http );

	exit();

}

?>