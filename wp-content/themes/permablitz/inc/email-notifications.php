<?php

/**
	EMAIL PARTS
*/

function pbz_edm_show_title($title, $cta=false) {
  if (!$cta) {
  $output = '<tr>
                  <td align="center" style="padding:5px 0px 20px 0px; font-size:16px; line-height:18px; font-style:italic;">'.$title.'</td>
                </tr>';
              } else {

              }
  return $output;
}

function pbz_edm_blurbarea($content) {
	
	$content = styleForEDM( cleanMarkupForEDM( $content ) );
    $content = str_replace('<p>', '', $content);
    $content = str_replace('</p>', '<br /><br />', $content );
    $content = str_replace('<br><br><br><br>', '', $content );
	$content = preg_replace("/<br\W*?\/>/", "", $content);
  	
  	return '<tr>
	          <td style="padding:20px 0px 20px 0px; font-size:16px; line-height:18px;">'.$content.'</td>
	        </tr>';
}

function getBlitzingCTA($blitz_url, $cta='Get Blitzing!', $position="outer") {

  if ($position == 'outer') {
    $padding = "0px 0px 30px 0px";
  }
  if ($position == 'inner') {
    $padding = "0px 0px 0px 0px";
  }

  return '<tr>
                  <td style="padding:'.$padding.';" align="center">
                                            <table width="220" cellspacing="0" cellpadding="0" border="0" style="color:#46629e; font-family:Arial, Helvetica, sans-serif; font-size:14px; line-height:8px;">
                                                <tr>
                                                    <td align="center" style="font-size:14px; line-height:16px; background-color:#45562f; color:#ffffff;">
                                                        <a style="display:block; width:220px; color:#ffffff; text-decoration:none; padding:8px 0;" href="'.$blitz_url.'">
                                                            '.$cta.'
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                    </td>
                </tr>';
}







function compileEmailToVolunteer($blitz_id, $blitz_blurb ) {

	$blitz_image = wp_get_attachment_image_src( get_post_thumbnail_id( $blitz_id, $args=array('limit' => 8)) , 'email-hero' );
	$blitz_img = $blitz_image[0];
	$blitz_url = get_permalink( $blitz_id );

	$blitz_title = get_the_title( $blitz_id );
	$blitz_title = str_replace('&#8211;', '-', $blitz_title);

	$promo = otherEventNotifications($guild_id, $args=array('limit' => 4, 'category' => 58), true, 'Other Upcoming Events'  );

	$msg = file_get_contents( get_stylesheet_directory_uri() . '/email/blitz_notification.html' );

	$msg = str_replace( '{{BLITZ_PAGE_TITLE}}', $blitz_title, $msg );
	$msg = str_replace( '{{BLITZ_TITLE}}', '', $msg );
	$msg = str_replace( '{{BLITZ_IMG}}', $blitz_img, $msg );
	$msg = str_replace( '{{BLITZ_BLURB}}', $blitz_blurb, $msg );
	$msg = str_replace( '{{BLITZ_URL}}', $blitz_url, $msg );
	$msg = str_replace( '{{OTHER_EVENTS}}', $promo, $msg );
	$msg = str_replace( '{{GET_BLITZING}}', '', $msg);
	$msg = str_replace( '{{SUPER_SCRIPT}}', '', $msg);

	return $msg;
}