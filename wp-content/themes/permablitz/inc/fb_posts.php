<?php


// Register Custom Post Type
function fb_post_post_type() {

    $labels = array(
        'name'                => _x( 'Facebook Posts', 'Post Type General Name', 'text_domain' ),
        'singular_name'       => _x( 'Facebook Post', 'Post Type Singular Name', 'text_domain' ),
        'menu_name'           => __( 'Facebook Posts', 'text_domain' ),
        'name_admin_bar'      => __( 'Facebook Post', 'text_domain' ),
        'parent_item_colon'   => __( 'Parent Item:', 'text_domain' ),
        'all_items'           => __( 'All Items', 'text_domain' ),
        'add_new_item'        => __( 'Add New Item', 'text_domain' ),
        'add_new'             => __( 'Add New', 'text_domain' ),
        'new_item'            => __( 'New Item', 'text_domain' ),
        'edit_item'           => __( 'Edit Item', 'text_domain' ),
        'update_item'         => __( 'Update Item', 'text_domain' ),
        'view_item'           => __( 'View Item', 'text_domain' ),
        'search_items'        => __( 'Search Item', 'text_domain' ),
        'not_found'           => __( 'Not found', 'text_domain' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'text_domain' ),
    );
    $args = array(
        'label'               => __( 'fb_post', 'text_domain' ),
        'description'         => __( 'Facebook Post Description', 'text_domain' ),
        'labels'              => $labels,	
        'supports'            => array( 'title', 'thumbnail' ),
        'hierarchical'        => false,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'menu_position'       => 20,
        'show_in_admin_bar'   => true,
        'show_in_nav_menus'   => true,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => true,
        'publicly_queryable'  => true,
        'capability_type'     => 'page',
        'menu_icon'			=> get_stylesheet_directory_uri() . '/img/ic_fbk_16.png'
    );
    register_post_type( 'fb-post', $args );

}

// Hook into the 'init' action
add_action( 'init', 'fb_post_post_type', 0 );

function facebook_posts($atts) {

	extract( shortcode_atts( array(
			'footer'	=> false,
            'edm'       => false,
            'post_id'       => null
		), $atts) );

	if ($footer) {

		$args = array( 
			'post_type' => 'fb-post', 
			'posts_per_page' => 6 
			); 

	} else {


		$facebook_posts = get_field('facebook_posts', $post_id);

		$ps = array();
		foreach ($facebook_posts as $fb) {
			array_push($ps, $fb['post']);
		}

		$args = array( 
			'post_type' => 'fb-post', 
			'post__in' =>  $ps,
			'orderby' => 'post__in'
			); 

	}

	

	$query = new WP_Query( $args );

	if ($edm) {
		return facebook_posts_edm($query);
	} else {
		return facebook_posts_output($query, $footer);
	}

}

function facebook_posts_output($query, $footer=false, $title="Last month's Facebook picks", $edm=false) {

	$output = '';

	if($query->have_posts()) : 
		$i = 0;
		if ($edm) {
			// need tables
		} else {
		 $output .= '<div class="facebook_posts">';
		 	if (!$footer) {
		 		$output .= '<div class="fb_title">' . $title . '</div>';			
			}
		}
      while($query->have_posts()) : 
         $query->the_post();
     $i++;
     		$data = get_fields( get_the_ID() );
     		
     		$img = $data['hero_image'];
            if(!$img) {
                $img = get_post_thumbnail_id( get_the_ID() );
            }

     		$fb = '<a href="' . $data['permablitz_fb_url'] . '" target="_blank">';
     		$fb .= wp_get_attachment_image( $img, 'thumb-medium' );
     		if (!$footer) {
	     		$fb.= '<div>'.get_the_title().'</div>';
	     	} else {
                $fb_title = cleanMarkupForEDM( get_the_title() );
	     		$fb.= '<p>'.$fb_title.'</p>';
		}
     		$fb .= '</a>';

     		if ($i%3 == 0 || $i == $query->found_posts) {
	     		$output .= do_shortcode('[column size="one-third" last="true"]'.$fb.'[/column]');
	     	} else {
	     		$output .= do_shortcode('[column size="one-third"]'.$fb.'[/column]');
	     	}

     		// $output .= do_shortcode('[/column]');

      endwhile;
      	$output .= '</div>';
      endif;

	return $output;

}

add_shortcode( 'facebook_posts', 'facebook_posts');

function facebook_posts_edm($query){

if($query->have_posts()) : 

	$output = '<tr>
                <td bgcolor="#ffffff" style="padding:20px 50px 20px 50px;">
                    <table border="0" cellpadding="0" cellspacing="0" class="emailWidthAuto" style="font-family:Arial, Helvetica, sans-serif; font-size:16px; line-height:20px; font-weight:normal; color:#3c3c3c; background-color:#ffffff;" width="100%">                    
                        <tr>
                            <td style="font-size:16px; line-height:18px; color:#333333; font-weight:bold; padding-top:10px; border-top:1px solid #46629e; text-align:center">Last month\'s Facebook picks
                             </td>
                        </tr>
                        <tr>
                            <td style="font-size:16px; line-height:18px; color:#333333; font-weight:bold; padding: 20px 0px 10px 0px;">                                     
                                <table border="0" cellpadding="0" cellspacing="0" class="emailWidthAuto" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:14px; font-weight:normal; color:#3c3c3c; background-color:#ffffff;" width="100%">
                                    <tr>';
	$i = 0;
	while($query->have_posts()) : 
         $query->the_post();

     		$data = get_fields( get_the_ID() );
            $i++;
            $img = isset($data['hero_image']) ? $data['hero_image'] : get_post_thumbnail_id( get_the_ID() );
	
     	$img = wp_get_attachment_image_src( $img, 'thumb-medium' );
        if ($i<=3) {
            $fb_title = cleanMarkupForEDM( get_the_title() );
        $output .= '<td width="165" class="emailFloatLeft" align="center" valign="top"><a href="'.$data['permablitz_fb_url'].'"><img src="'.$img[0].'" width="165" style="display:block; border:none;" alt="" /></a><br />'.$fb_title.'</td>';
        if ($i<3) {
            $output .= '<td width="25" class="emailFloatLeft">&nbsp;</td>';
        }
    }

        if($i == 3) { $output .= '</tr><tr>'; $i = 0; }   
     
     endwhile;
     $output .= '</tr>
                                        </table>
                                     </td>
                                </tr>
                                
                                <tr>
                                    <td style="padding:20px; border-bottom:1px solid #46629e;" align="center">
                                        <table width="220" border="0" cellpadding="0" cellspacing="0" style="color:#46629e; font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:8px;">
                                            <tr>
                                                <td width="220" align="center" style="font-size:14px; line-height:16px; background-color:#46629e; color:#ffffff;"><a href="https://www.facebook.com/PermablitzMelbourne/" style="display:block; color:#ffffff; text-decoration:none; padding:8px 0;">Follow us on Facebook</a></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>';

   return $output;

endif;

}

// Facebook Posts Importer
// Creates entries in a custom post type for posts pulled from a Facebook feed

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
$post_id = 5759 ;
//acme_add_file_to_media_uploader($post_id, $img );


if ( ! wp_next_scheduled( 'facebook_posts_feed' ) ) {
  wp_schedule_event( time(), 'daily', 'facebook_posts_feed' );
}

add_action( 'facebook_posts_feed', 'import_facebook_posts' );

function import_facebook_posts() {
    populateFBposts();
  //wp_mail( 'adrian.ohagan@gmail.com', 'Facebook email sent', 'Automatic scheduled email from WordPress.');
}

?>
