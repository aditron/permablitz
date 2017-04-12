<?php

function permablitz_gallery($atts) {

	$a = shortcode_atts( array(
        'album' => null,
        'userid' => '113886493944065832069',
        'more' => 0
    ), $atts );

    $album_num = 'album_' . $a['album'];

    $output = get_transient( $album_num );

    if ($a['more'] == 1) {
    	delete_transient( $album_num );
    } 

    if ( $output === false ) {
    
	    if ($a['album']) {
			$feedURL = 'http://picasaweb.google.com/data/feed/api/user/' . $a['userid']. '/albumid/' . $a['album'];
			
			$sxml = simplexml_load_file($feedURL);
			$photos = array();
			foreach ($sxml->entry as $entry) {

				$source = $entry->content['src'];
			  	$src_parts = explode('/',$source);

			  $temp['lrg'] = 'http://' . $src_parts[2] . '/' . $src_parts[3] . '/' . $src_parts[4] . '/' . $src_parts[5]
			    . '/'. $src_parts[6] . '/s1024/' . $src_parts[7];
			  $temp['thumb'] = 'http://' . $src_parts[2] . '/' . $src_parts[3] . '/' . $src_parts[4] . '/' . $src_parts[5]
			    . '/'. $src_parts[6] . '/s300/' . $src_parts[7];
			  
			  $temp['title'] = $entry->title;

			  $photos[] = $temp;
			}

			if (count($photos)) {

				$output .= '<div id="pictures" class="owl-carousel">';

				foreach ($photos as $pic) {
					// $size= getimagesize($pic['thumb']);
					$output .= '<a class="item" style="height:225px" href="' . $pic['lrg'] . '" rel="lightbox" title="' . $pic['title'] . '">
			    <img src="' . $pic['thumb'] . '" alt="' . $pic['title'] . '" /></a>';
			    // $output .= '<a class="item" href="' . $pic['lrg'] . '" rel="lightbox" title="' . $pic['title'] . '">
			    // <img data-src="' . $pic['thumb'] . '" data-src-retina="' . $pic['thumb'] . '" height="300" alt="' . $pic['title'] . '" /></a>';
				}
				$output .='</div>';
				$output .= '<div class="pic-num"></div>';

				set_transient( $album_num, $output, 0 );

			}
		}

	}
	return $output;
}

add_shortcode( 'permablitz_gallery', 'permablitz_gallery');

add_action('init', 'register_map_scripts');
add_action('wp_footer', 'print_map_scripts');

function register_map_scripts() {
	wp_register_script('google-maps', '//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false');
	wp_register_script('acf-maps', get_stylesheet_directory_uri() . '/js/jquery.acf.maps.js', array('jquery'), '1.0', true);
}

function print_map_scripts() {
	global $add_map_scripts;

	if ( ! $add_map_scripts )
		return;

	wp_print_scripts('google-maps');
	wp_print_scripts('acf-maps');
}

function permablitz_gmaps($atts) {

	global $add_map_scripts;

	$add_map_scripts = true;

	$maps_req = get_field( 'do_you_want_to_add_map_locations', get_the_ID() ); 

	$output = '';

	if ($maps_req) {
		$map_locations = get_field( 'map_locations', get_the_ID() );
		
		if ( count($map_locations) >=1 && is_array($map_locations)) {

			$output .= '<div class="acf-map">';

				foreach ($map_locations as $locations) {
					$locs = $locations['location'];
					$page = $locations['page_link'];
					$page_link = get_the_permalink($page->ID);
					$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($page->ID), 'thumbnail' );
					$output .= '<div class="marker" data-lat="' . $locs['lat'] . '" data-lng="' . $locs['lng'] . '">
					<h4><a href="'.$page_link.'">'.$page->post_title.'</a></h4>
					<a href="'.$page_link.'"><img src="'. $thumb[0] .'" width="160" alt="" /></a>
				</div>';
			}
			$output .= '</div>';
		}

		
	}

	return $output;

}

add_shortcode( 'permablitz_gmaps', 'permablitz_gmaps');

function prev_blitzes_map($atts) {

	global $add_map_scripts;

	$add_map_scripts = true;

	$maps_req = get_field( 'show_prev_blitz_map', get_the_ID() ); 

	$output = '';

	if ($maps_req) {
		$map_locations = get_field( 'map_locations', get_the_ID() );
		
		if ( count($map_locations) >=1 && is_array($map_locations)) {

			$output .= '<div class="acf-map">';

				foreach ($map_locations as $locations) {
					$locs = $locations['location'];
					$page = $locations['post_to_link_to'];
					$page_link = get_the_permalink($page->ID);
					$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($page->ID), 'thumbnail' );
					$output .= '<div class="marker" data-lat="' . $locs['lat'] . '" data-lng="' . $locs['lng'] . '">
					<h4><a href="'.$page_link.'">'.$page->post_title.'</a></h4>
					<a href="'.$page_link.'"><img src="'. $thumb[0] .'" width="160" alt="" /></a>
				</div>';
			}
			$output .= '</div>';
		}

		
	}

	return $output;

}

add_shortcode( 'prev_blitzes_map', 'prev_blitzes_map');


function pbz_blitzpoint( $atts ){

  $col_1 = '<div style="background: #abc959; width: 80%; margin: 0px auto; height:100%; text-align: center; font-family: Georgia; font-weight: bold; color: #fff; font-size: 24px; line-height: 2em; ">+1</div>';
  $col_2 = "<strong>Want to have your own Blitz?</strong><br/> This event counts as one \"Blitz point\". If you've been to a PermaBlitz (or a Permabee) and attend this event you'll be eligible for your own PermaBlitz!";

  $output = null;
  $output .= '<table class="bz_points"><tr><td class="points">+1</td>';
  $output .= '<td class="bz_desc">' . $col_2 . '</td></tr></table>';
  return $output;
}
add_shortcode( 'blitzpoint', 'pbz_blitzpoint' );

function pbz_communitypoint( $atts ){

  $col_2 = "<strong>Want to have your own Blitz?</strong><br/>This event counts as \"Community involvement\". If you've been to a PermaBlitz (or a Permabee) and attend this event you'll be eligible for your own PermaBlitz!";

  $output = null;
  $output .= '<table class="bz_points"><tr><td class="points">+C</td>';
  $output .= '<td class="bz_desc">' . $col_2 . '</td></tr></table>';
  return $output;
}
add_shortcode( 'communitypoint', 'pbz_communitypoint' );

function pbz_groups() {

	global $add_map_scripts;

	$add_map_scripts = true;

    $output = '';
    $maps = get_field('area');

    $output .= '<div class="acf-map">';

			foreach ($maps as $map) { 
				foreach ($map['groups'] as $locations) {
					$locs = $locations['map_location'];
					$output .= '<div class="marker" data-lat="' . $locs['lat'] . '" data-lng="' . $locs['lng'] . '">
					<h4>'.$locations['group_name'].'</h4>
				</div>';
			}
		}
			$output .= '</div>';


    foreach ($maps as $map) {

    	$output .= '<h2 class="group-heading">'.$map['area_name'].'</h2>' . "\n";
    	$i=0;
    	$count = count($map['groups']);
    	// $output .= $count;
    	foreach ($map['groups'] as $group) {
    		$close = false;
    		if (!$i || $i%3 == 0) {
    			$output .= '<div class="row">' ."\n";
    		}
    		if ($i+1 == $count || $i%3 == 2) {
    			$close = true;
    		}
    		// $output .= ($i+1) . ' - ';
    		$output .= '<div class="grid pbz-groups one-third';
    		$output .= ($close==true) ? ' last' : '';
    		$output .= '">';
    		$output .= '<h3>' . $group['group_name'] . '</h3>';
    		if ($group['website'] || $group['facebook_page']) {
	    			$output .= '<p>';
	    		if ($group['website']) {
	    			$output .= '<a href="'.$group['website'].'" target="_blank">Website</a> ';
	    		}
	    		if ($group['website'] && $group['facebook_page']) {
	    			$output .= ' / ';
	    		}
	    		if ($group['facebook_page']) {
	    			$output .= '<a href="'.$group['facebook_page'].'" target="_blank">Facebook</a> ';
	    		}
	    		$output .= '</p>';
	    	}
	    	$output .= $group['extra_info'];	
    		$output .= '</div>'."\n";
    		if ($close) {
    			$output .= '</div>' ."\n";
    			$output .= '<div class="clear"></div>' ."\n";
    		}
    		$i++;

    	}
    }

    return $output;


}
add_shortcode( 'pbz_groups', 'pbz_groups' );

function pbz_plantingGuide( $atts ) {

	$a = shortcode_atts( array(
        'target' => 'screen',
        'post_id' => null
    ), $atts );

    global $post;

    if ($a['target'] == 'email') {
    	$planting_list = get_field( 'planting_list', $a['post_id'] ); 
    	$top[0] = '<td width="50%" class="emailFloatContentLeft" valign="top">
                                                        <ul>';
    	$top[1] = '<td width="50%" class="emailFloatContentLeft" valign="top">
                                                        <ul>';
        $btm = '</ul></td>';
    } else {
    	$top[0] = '<div class="grid one-half"><ul>';
    	$top[1] = '<div class="grid one-half last"><ul>';
    	$btm = '</ul></div>';
    	$post_id = isset($a['post_id']) ? $a['post_id'] : $post->ID; 
    	$planting_list = get_field( 'planting_list', $post_id ); 
    }
    $plants_list=explode(",",$planting_list);
	$list_one = array();
	$list_two = array();
	$total = count($plants_list);
	foreach ($plants_list as $k => $v) {
	    if ($k < ceil($total/2)) {
	        $list_one[] = $v;
	    }
	    else {
	        $list_two[] = $v;
	    }
	}

	if ($a['target'] == 'email') {

		$new_list = array();
		for ($i = 0; $i<count($list_one); $i++) {
			array_push($new_list, $list_one[$i]);
			if (isset($list_two[$i])) {
			array_push($new_list, $list_two[$i]);		
			}
		}

		$output = '<tr>
									<td style="padding:0px 0px 20px 0px; font-size:12px; line-height:14px; color:#404040;" align="center">
                                    <table border="0" cellpadding="0" cellspacing="0" class="emailWidthAuto" style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:14px; font-weight:normal; color:#ffffff; background-color:#3b8dbd;" width="60%">';
                                    	
                                    
		$i = 0;
		foreach ($new_list as $t) {
			$i++;
			if ($i%2==1) {
				$output .= '<tr>';
			}
			$output .= '<td>&#9679;</td><td>'  .$t . '</td>';
			if ($i%2==1) {
				$output .= '<td width="25">&nbsp;</td>';
			}
			if (count($new_list) == $i && $i%2==1) {
				$output .= '<td>&nbsp;</td><td>&nbsp;</td>';
			}
			if ($i%2==0) {
				$output .= '</tr>';
			}
	}
		$output .= '</table>
                                     
            </td>
		</tr>';

	} else {

		$output = $top[0];
		foreach ($list_one as $plant) {
			$output .= '<li>' . $plant . '</li>';
		}
		$output .= $btm;
		$output .= $top[1];
		foreach ($list_two as $plant) {
			$output .= '<li>' . $plant . '</li>';
		}
		$output .= $btm;
		$output .= '<div style="clear:both"></div>';

	}

	return $output;

}
add_shortcode( 'plantingguide', 'pbz_plantingGuide' );

function newsletter_signoff() {
	global $post;
	$sign_off = get_field( 'sign-off', $post->ID );
	$output = '<p style="text-align: center;">
			<em>
			<strong>'.$sign_off.'</strong>
			</em>
			</p>';
		return $output;
}
add_shortcode( 'signoff', 'newsletter_signoff' );
?>
