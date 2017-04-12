<?php
require_once('wp-load.php');
// Facebook Posts Importer
// Creates entries in a custom post type for posts pulled from a Facebook feed

// $latest = get_option('fb_feed_latest');
error_reporting(E_ALL);
ini_set('display_errors', 1);


// get the feed
function getFeed($url) {
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

function populateFBposts() {
    // Who's feed are we pulling?
    $page_id = "PermablitzMelbourne";
    $access_token = "553638201486139|qXH7mnizMj3uh1h0IZo6UTnHBYw";

    $url = "https://graph.facebook.com/".$page_id."/posts?fields=shares,likes.limit(0).summary(true),comments.limit(0).summary(true),full_picture,name,created_time,type&access_token=".$access_token;
    
    $data = getFeed($url);

    if ($data) {
    // make the json result into something useful
    $decoded = json_decode($data);

    $post_list = array();

    // iterate through each feed item
    foreach ($decoded->data as $entry) {

        $id_element = explode("_", $entry->id);

        $facebook_id = $entry->id;

        $shares_count = isset($entry->shares->count) ? $entry->shares->count : 0;
        $comment_count = isset($entry->comment->summary->total_count) ? $entry->comment->summary->total_count : 0;

        $date = new DateTime($entry->created_time);
	$date->setTimeZone(new DateTimeZone('Australia/Melbourne'));
        $post_list[] = array(
                'id' => $facebook_id,
                'name' => $entry->name,
                'type' => $entry->type,
                'photo' => $entry->full_picture,
                'link_id' => 'https://www.facebook.com/'.$page_id.'/posts/' . $id_element[1],
                'created_time' => $date->format("Y-m-d H:i:s"),
                'likes' => $entry->likes->summary->total_count,
                'shares' => $shares_count,
                'comments' => $entry->comments->summary->total_count,
                'tracked_engagements' => (int) $entry->likes->summary->total_count + (int) $shares_count + (int) $comment_count
                );
    }
    
    foreach ($post_list as $post) {

        echo '<pre>';
        print_r($post);
        echo '</pre>';

        if ($post['tracked_engagements']>=30) {
	
        global $wpdb;

        $fb_id = $post['id'];
        $item_exists = $wpdb->get_results( "select * from $wpdb->postmeta where meta_key = 'facebook_id' AND meta_value = '$fb_id' " );

        if ($item_exists) {
                // post already exists in wordpress, skip it
            } else {
                $args = array(
                    'post_type' => 'fb-post',
                    'post_title' => $post['name'],
                    'post_date' => $post['created_time'],
                    'post_status' => 'publish'
                );

                $new_post_id = wp_insert_post($args);

                $link_field_key = 'field_56a88385327ea';
                $image_field_key = 'field_56a883a0327eb';

                // set the custom fields
                update_field($link_field_key, $post['link_id'], $new_post_id);
		add_post_meta($new_post_id, 'facebook_id', $fb_id);

                $temp_path = trailingslashit( ABSPATH )  . 'fb-files/' . sanitize_title($post['name']) . '.jpg';

                $saved_image = saveImage($post['photo'], $temp_path);

                echo 'new_post_id=' . $new_post_id;
                echo '<br>temp_path=' . $temp_path;
                echo '<br>filename =' . sanitize_title($post['name']);
		
                acme_add_file_to_media_uploader($new_post_id, sanitize_title($post['name']).'.jpg' );
            }

        }


    }

    }

}

function saveImage($url, $savePath) {

    $ch = curl_init($url);
    $fp = fopen($savePath, 'wb');

    curl_setopt($ch, CURLOPT_TIMEOUT, 20);
    curl_setopt($ch, CURLOPT_FAILONERROR, true);
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);

    $result = curl_exec($ch);

    fclose($fp);
    curl_close($ch);

    if ($result) {
        return $savePath;
    } else {
        return false;
    }
}

function acme_add_file_to_media_uploader( $post_id, $filename ) {

 require_once( trailingslashit( ABSPATH ) . 'wp-admin/includes/media.php'); 
 require_once( trailingslashit( ABSPATH ) . 'wp-admin/includes/file.php');
 require_once( trailingslashit( ABSPATH ) . 'wp-admin/includes/image.php');

   $image = 'http://www.permablitz.net/fb-files/' . $filename;
echo $image;

// magic sideload image returns an HTML image, not an ID
$media = media_sideload_image($image, $post_id);

// therefore we must find it so we can set it as featured ID
if(!empty($media) && !is_wp_error($media)){
    $args = array(
        'post_type' => 'attachment',
        'posts_per_page' => -1,
        'post_status' => 'any',
        'post_parent' => $post_id
    );

    // reference new image to set as featured
    $attachments = get_posts($args);
    
$thumbnail_id = $attachments[0]->ID;
	update_post_meta( $post_id, '_thumbnail_id', $thumbnail_id );
	

    //unset($file);

    }
    

}
$img = 'starting-an-organic-garden-sustainable-gardening-australia.jpg';
$post_id = 5759	;
//acme_add_file_to_media_uploader($post_id, $img );


if ( ! wp_next_scheduled( 'facebook_posts_feed' ) ) {
  wp_schedule_event( time(), 'daily', 'facebook_posts_feed' );
}

add_action( 'facebook_posts_feed', 'import_facebook_posts' );

function import_facebook_posts() {
    populateFBposts();
  wp_mail( 'adrian.ohagan@gmail.com', 'Facebook email sent', 'Automatic scheduled email from WordPress.');
}

?>