<?php

require_once('wp-load.php');

function testEmail($newsletter_id) {
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
          
          $blitz_blurb = $data[ 'introduction' ];
          $blitz_blurb = styleForEDM( cleanMarkupForEDM( $blitz_blurb ) );

          $hero_of_the_month = heroOfTheMonth( $data, $newsletter_id);
          
          $bits_and_pieces = do_shortcode('[bits_and_pieces edm="true" post_id='.$newsletter_id.']' );
          $bits_and_pieces = styleForEDM($bits_and_pieces);

          $in_the_garden = inTheGarden($data, $newsletter_id);

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
          
          $msg = str_replace( '{{OTHER_EVENTS}}', otherEventNotifications($newsletter_id, array('category'=>58, 'scope' => $start_month .','.$end_month) ), $msg );
 
        echo $msg;     
}


$post_id = isset($_GET['post_id']) ? $_GET['post_id'] : 1419;
    //testEmail(3143);
$msg = get_post_meta($post_id, 'newsletter', true);

if (isset($msg)){

$hero_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post_id) , 'email-hero' );
$msg = str_replace( '{{NEWSLETTER_IMG}}', $hero_image[0], $msg );
echo $msg;
} 
if (empty($msg)) {
  echo '<p>To preview a newsletter, you need to enter test.php?post_id=1324 where 1324 is the post_id of the page you want to view</p>';

}



// $planting_list = 'Beetroot,Broad Beans,Broccoli,Buckwheat,Cabbage,Caraway,Carrots,Cauliflower,Chervil,Chicory,Chinese Cabbage,Cress,Garlic clove,Kohlrabi,Leeks,Lettuce,Mizuna,Mustard Greens,Oats,Onions,Orach,Parsley,Parsnip,Potato tubers,Radish,Salad Burnett,Salsify,Shallot bulbs,Silverbeet,Spinach,Spring Onions,Strawberry runners,Swedes,Turnip';
// $plants_list=explode(",",$planting_list);

// print_r($list_one);
// print_r($list_two);

// // $test = otherEventNotifications($newsletter_id, array('category'=>58, 'scope' => '2016-02-01,2016-02-29')) ;
// // print_r($test);