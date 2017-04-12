<?php

require_once('../../../wp-load.php');

$fb = do_shortcode('[facebook_posts footer="true" edm="true"]');

$permablitz_news = do_shortcode('[permablitz_news edm="true" post_id='.$newsletter_id.']');
$permablitz_news = str_replace('<p>', '', $permablitz_news);
$permablitz_news = str_replace('</p>', '<br /><br />', $permablitz_news);

$msg = file_get_contents('email.html');

$msg = str_replace( '{{OTHER_EVENTS}}', otherEventNotifications($newsletter_id, array('limit'=>-1, 'category'=>57, 'scope' => '2016-02-01,2016-03-01')), $msg );
$msg = str_replace( '{{FACEBOOK_POSTS}}', $fb, $msg );
$msg = str_replace( '{{PERMABLITZ_NEWS}}', $permablitz_news, $msg);
          

echo $msg;

?>