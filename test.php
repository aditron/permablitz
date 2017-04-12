<?php

require_once('wp-load.php');
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
function testNewsletterEmail($newsletter_id) {
        $newsletter_title = get_the_title( $newsletter_id );
          $hero_image = wp_get_attachment_image_src( get_post_thumbnail_id( $newsletter_id) , 'email-hero' );
          $post_url = get_permalink( $newsletter_id );

          $permablitz_news = do_shortcode('[permablitz_news edm="true" post_id='.$newsletter_id.']');
          $permablitz_news = styleForEDM($permablitz_news);

          $schedule = 	get_post_time( 'U', false, $newsletter_id);
          $start_month = date('Y-m-01', $schedule);
          $end_month = date('Y-m-t', $schedule);

          $fb = do_shortcode('[facebook_posts footer="true" edm="true"]');

          $data = get_fields($newsletter_id);

          if ($data['month']) {
               $date  = $data['month'];
               $date_parts = explode('/', $date);
               $start_month = $date_parts[2] . '-' . $date_parts[1] . '-' . $date_parts[0]; 
               $end_month = date( 'Y-m-t', mktime(0, 0, 0, $date_parts[1] , 1, $date_parts[2] ) );
          }

          $blitz_blurb = $data[ 'introduction' ];
          $blitz_blurb = pbz_edm_blurbarea( styleForEDM( cleanMarkupForEDM( $blitz_blurb ) ) );

          $hero_of_the_month = heroAndHerb( $newsletter_id);
          
          $bits_and_pieces = do_shortcode('[bits_and_pieces edm="true" post_id='.$newsletter_id.']' );
          $bits_and_pieces = styleForEDM($bits_and_pieces);

          $in_the_garden = inTheGarden($data, $newsletter_id);

          $superscript = $data['super_script'];

          $msg = file_get_contents( get_stylesheet_directory_uri() . '/email/newsletter.html' );
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
          $msg = str_replace( '{{SUPER_SCRIPT}}', $superscript, $msg );
          
          $msg = str_replace( '{{OTHER_EVENTS}}', otherEventNotifications($newsletter_id, array('category'=>58, 'scope' => $start_month .','.$end_month), true ), $msg );
 	update_post_meta($newsletter_id, 'newsletter', $msg);
        echo $msg;
	//echo otherEventNotifications($newsletter_id, array('category'=>58, 'scope' => $start_month .','.$end_month), true );     
}



function test_notify($fname='Adrian', $suburb='Forest Hill') {

$guild_id = 6832;

 $blitz_title = get_the_title( $guild_id );
          $blitz_image = wp_get_attachment_image_src( get_post_thumbnail_id( $guild_id) , 'email-hero' );
          $blitz_img = $blitz_image[0];
	  $blitz_img = 'http://www.permablitz.net/wp-content/uploads/2016/08/Banner-celebrating-10-years-of-backyard-blitzing.jpg';
          $blitz_url = get_the_permalink( $guild_id );
	  
	  $guild_intro = 'Hi '.$fname.',<br><br>';
	  $guild_intro .= 'It\'s been a while sine the ' . $suburb . ' Blitz at your place, and we hope the results of the day have had a good and lasting impact. We\'d love to know how the garden is coming along - let us know if you\'d be happy for us to come out and take a few photos of the place! It\'s always good for people to see a before and after photo, as well as to see what worked and what didn\'t.<br><br>';
	  $guild_intro .= 'Now that Permabitz has been eating the suburbs for ten years, we\'re having a party to celebrate - and as someone who has been an important part of our journey, we\'d love it if you could join us!<br><br>';
	  
	  $guild_intro2 = 'Join us for an afternoon in the sun as we thank the founders, the designers, other hosts like yourself, the Collective members from both then and now, those that inspired us - and of course the volunteers that make it all possible.<br><br>';
	  $guild_intro2 .= 'There\'ll be food (you like pizza right?), there\'ll be drinks, there\'ll be music (<a href="http://www.theorbweavers.com/">The Orbweavers</a> are going to be playing, but just in case - Hermann has maraccas!) and there\'ll even be incredibly fun games - including <a href="https://en.wiktionary.org/wiki/chicken_bingo">chicken bingo</a>!<br><br>';
	  $guild_intro2 .= 'And it wouldn\'t be a Permablitz event if we didn\'t have workshops, so you can bet we\'ll have those too.<br><br>';
	  $guild_intro2 .= 'It\'s all happening at Peppertree Place on Sunday October 23 from 11am. We really hope to see you there!<br><br><br>';
          $guild_intro2 .= 'All the beets,<br>';
	  $guild_intro2 .= 'The team @ Permabitz decentral';
	  
	  
       $blitz_blurb = styleForEDM( cleanMarkupForEDM( $guild_intro ) );
          $blitz_blurb = str_replace('<p>', '', $blitz_blurb);
          $blitz_blurb = str_replace('</p>', '<br /><br />', $blitz_blurb );

       $blitz_blurb2 = styleForEDM( cleanMarkupForEDM( $guild_intro2 ) );
          $blitz_blurb2 = str_replace('<p>', '', $blitz_blurb2);
          $blitz_blurb2 = str_replace('</p>', '<br /><br />', $blitz_blurb2 );

     $blurb = pbz_edm_blurbarea($blitz_blurb);
     $blurb .= getBlitzingCTA('https://www.facebook.com/events/297026847341721/', 'Join us at the party!', 'inner');
     $blurb .= pbz_edm_blurbarea($blitz_blurb2);
	  
	  $schedule = 	'2016-09-12';
          $start_month = '2016-09-17'; // date('Y-m-01', $schedule);
          $end_month = '2016-09-30'; //date('Y-m-t', $schedule);
	  $promo = otherEventNotifications($guild_id, $args=array('limit' => 6, 'category' => array(57,58), 'scope' => $start_month .','.$end_month), true, 'Other Events Coming Up' );
	  
	  $heroAndHerb = heroAndHerb($guild_id);
	  
	  $superscript = 'Hi '. $fname.', come and help us celebrate ten years of backyard blitzing!';


$msg = file_get_contents( get_stylesheet_directory_uri() . '/email/guild_notification.html' );
          $msg = str_replace( '{{BLITZ_PAGE_TITLE}}', $blitz_title, $msg );
          $msg = str_replace( '{{BLITZ_TITLE}}', pbz_edm_show_title($blitz_title), $msg );
          $msg = str_replace( '{{BLITZ_IMG}}', $blitz_img, $msg );
          $msg = str_replace( '{{BLITZ_BLURB}}', $blitz_blurb, $msg );
          $msg = str_replace( '{{BLITZ_URL}}', $blitz_url, $msg );
          $msg = str_replace( '{{OTHER_EVENTS}}', $promo, $msg );
          $msg = str_replace( '{{BITS_AND_PIECES}}', $bits_and_pieces, $msg);
	  $msg = str_replace( '{{HERO_OF_THE_MONTH}}', $heroAndHerb, $msg );
          $msg = str_replace( '{{SUPER_SCRIPT}}', $superscript, $msg );
      
          return $msg;
}
global $wpdb;
$results = $wpdb->get_results( 'SELECT * FROM pbz_prty_hosts WHERE sent=0 LIMIT 10', OBJECT );
//echo count($results);

$headers = "From: Permablitz Melbourne <permablitz@gmail.com>\r\n";
$headers.= "Reply-To: Permablitz Melbourne <permablitz@gmail.com>\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

$subject = 'Permablitz is turning ten and we want you to join us!';
      
foreach ($results as $result) {
	
	$msg = test_notify($result->fname, $result->suburb);
	echo $msg;
	die();
	$sent = wp_mail($result->email, $subject, $msg, $headers);
	
	$wpdb->update( 
	'pbz_prty_hosts', 
	array( 
		'sent' => $sent
	), 
	array( 'ID' => $result->id ), 
	array( 
		'%d'
	), 
	array( '%d' ) 
);
	
}
//echo test_notify();

die();
$post_id = isset($_GET['post_id']) ? $_GET['post_id'] : 3745;



// $msg = get_post_meta($post_id, 'newsletter', true);
// echo $msg;
// die();
$msg = testNewsletterEmail($post_id);
if (isset($msg)){

$hero_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id) , 'email-hero' );
$msg = str_replace( '{{NEWSLETTER_IMG}}', $hero_image[0], $msg );
echo $msg;
} 
if (empty($msg)) {
  echo '<p>To preview a newsletter, you need to enter test.php?post_id=1324 where 1324 is the post_id of the page you want to view</p>';

}
