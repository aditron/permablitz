<?php
/*
 * RSS Page
 * This page handles the even RSS feed.
 * You can override this file by and copying it to yourthemefolder/plugins/events-manager/templates/ and modifying as necessary.
 * 
 */
header ( "Content-type: application/rss+xml; charset=UTF-8" );
$offset = isset($_GET['offset']) ? $_GET['offset'] : 0;
$ty = isset($_GET['ty']) ? $_GET['ty'] : 0;
$number = 2;
echo '<?xml version="1.0" encoding="UTF-8" ?>'."\n";
?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
	<channel>
		<title><?php echo esc_html(get_option ( 'dbem_rss_main_title' )); ?></title>
		<link><?php	echo EM_URI; ?></link>
		<description><?php echo esc_html(get_option('dbem_rss_main_description')); ?></description>
		<docs>http://blogs.law.harvard.edu/tech/rss</docs>
		<pubDate><?php echo date('D, d M Y H:i:s +0000', get_option('em_last_modified', current_time('timestamp',true))); ?></pubDate>
		<atom:link href="<?php echo esc_attr(EM_RSS_URI); ?>" rel="self" type="application/rss+xml" />
		<?php
		$description_format = str_replace ( ">", "&gt;", str_replace ( "<", "&lt;", get_option ( 'dbem_rss_description_format' ) ) );
        $rss_limit = get_option('dbem_rss_limit');
        $page_limit = $rss_limit > 50 || !$rss_limit ? 50 : $rss_limit; //set a limit of 50 to output at a time, unless overall limit is lower		
		$args = !empty($args) ? $args:array(); /* @var $args array */
		$args = array_merge(array('scope'=>get_option('dbem_rss_scope'), 'owner'=>false, 'limit'=>$page_limit, 'page'=>1, 'order'=>get_option('dbem_rss_order'), 'orderby'=>get_option('dbem_rss_orderby')), $args);
		$args = apply_filters('em_rss_template_args',$args);
		$EM_Events = EM_Events::get( $args );
		$count = 0;
		while( count($EM_Events) > 0 ){
			foreach ( $EM_Events as $EM_Event ) {
				/* @var $EM_Event EM_Event */
				//$description = $EM_Event->output( get_option ( 'dbem_rss_description_format' ), "rss");
				//$description = ent2ncr(convert_chars($description)); //Some RSS filtering
				$event_url = $EM_Event->output('#_EVENTURL');
				$post_id = $EM_Event->output('#_EVENTPOSTID');
				$description = $EM_Event->output('#_EVENTEXCERPT{15,...}');
                $date_and_time = $EM_Event->output('#_{l, jS M} at #_EVENTTIMES');


$event_title = $EM_Event->output( get_option('dbem_rss_title_format'), "rss" );

$post_thumbnail_id = get_post_thumbnail_id( $post_id );
					$img = wp_get_attachment_image_src($post_thumbnail_id, 'newsletter-thumb');
					if (!$img) {
						$img[0] = 'http://lorempixel.com/output/animals-q-c-900-514-6.jpg';
					}

if ($count % 2 == 0) {
$output .= '<tr>
            <td valign="top" align="center" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;background-color: #FFFFFF;border-top: 0;border-bottom: 0;" id="templateColumns">
                    <tbody><tr>
                        <td valign="top" align="center" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                            <table width="600" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="templateContainer">
                                <tbody><tr>
                                    <td width="50%" valign="top" align="left" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="columnsContainer">
                                        <table width="100%" cellspacing="0" cellpadding="0" border="0" align="left" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="templateColumn">
                                            <tbody><tr>
                                                <td valign="top" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="leftColumnContainer"><table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnCaptionBlock">
    <tbody class="mcnCaptionBlockOuter">
        <tr>
            <td valign="top" style="padding: 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnCaptionBlockInner">
                

<table width="false" cellspacing="0" cellpadding="0" border="0" align="left" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnCaptionBottomContent">
    <tbody><tr>
        <td valign="top" align="left" style="padding: 0 9px 9px 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnCaptionBottomImageContent">
        
            
            <a style="word-wrap: break-word;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" target="_blank" class="" title="" href="'. $event_url .'">
            

            <img width="264" class="mcnImage" style="max-width: 900px;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;vertical-align: bottom;" src="' . $img[0]. '" alt="">
            </a>
        
        </td>
    </tr>
    <tr>
        <td width="264" valign="top" style="padding: 0px 9px;font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;font-size: 11px;line-height: 150%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;text-align: left;" class="mcnTextContent">
            <a style="word-wrap: break-word;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #000000;font-weight: normal;text-decoration: underline;" target="_blank" href="'. $event_url.'"><strong>'. $event_title . '</strong></a><br>
            <strong><span style="color:#6DC6DD">'.$date_and_time.'</span></strong><br>
' . $description . '
        </td>
    </tr>
</tbody></table>
            </td>
        </tr>
    </tbody>
</table></td>
                                                                </tr>
                                                            </tbody></table>
                                                        </td>';
                                                         
              } else {

$output .= '<td width="50%" valign="top" align="left" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="columnsContainer">
                <table width="100%" cellspacing="0" cellpadding="0" border="0" align="right" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="templateColumn">
                    <tbody><tr>
                        <td valign="top" style="mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="rightColumnContainer"><table width="100%" cellspacing="0" cellpadding="0" border="0" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnCaptionBlock">
    <tbody class="mcnCaptionBlockOuter">
        <tr>
            <td valign="top" style="padding: 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnCaptionBlockInner">
                

<table width="false" cellspacing="0" cellpadding="0" border="0" align="left" style="border-collapse: collapse;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnCaptionBottomContent">
    <tbody><tr>
        <td valign="top" align="left" style="padding: 0 9px 9px 9px;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" class="mcnCaptionBottomImageContent">
        
            
            <a style="word-wrap: break-word;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;" target="_blank" class="" title="" href="'. $event_url .'">
            

            <img width="264" class="mcnImage" style="max-width: 900px;border: 0;outline: none;text-decoration: none;-ms-interpolation-mode: bicubic;vertical-align: bottom;" src="' . $img[0]. '" alt="">
            </a>
        
        </td>
    </tr>
    <tr>
        <td width="264" valign="top" style="padding: 0px 9px;font-family: Arial, \'Helvetica Neue\', Helvetica, sans-serif;font-size: 11px;line-height: 150%;mso-table-lspace: 0pt;mso-table-rspace: 0pt;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #606060;text-align: left;" class="mcnTextContent">
            <a style="word-wrap: break-word;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;color: #000000;font-weight: normal;text-decoration: underline;" href="'. $event_url.'"><strong>' . $event_title . '</strong></a><br>
<strong><span style="color:#6DC6DD">'.$date_and_time.'</span></strong><br>' . $description . '
        </td>
    </tr>
</tbody></table>
            </td>
        </tr>
    </tbody>
</table>
		</td>
                                                                </tr>
                                                            </tbody></table>
                                                        </td>
                                                    </tr>
                                                </tbody></table>
                                            </td>
                                        </tr>
                                    </tbody></table>
                                </td>
                            </tr>';
}


				// if ( ($count >= $offset) && ($count < ($number + $offset)) ) {
				$count++;	
			}
        	if( $rss_limit != 0 && $count >= $rss_limit ){ 
        	    //we've reached our limit, or showing one event only
        	    break;
        	}else{
        	    //get next page of results
        	    $args['page']++;
        		$EM_Events = EM_Events::get( $args );
        	}
		}
		?>

		<item>
					<title>Events</title>
					<link>http://ww.permaculturemelbourne.com.au</link>
					<guid>http://ww.permaculturemelbourne.com.au</guid>
					<pubDate><?php echo date('Y-m-d H:i:s', 'D, d M Y H:i:s +0000'); ?></pubDate>
					<description><![CDATA[<?php echo $output; ?>]]></description>
				</item>
		
	</channel>
</rss>


<?php
die();

?>