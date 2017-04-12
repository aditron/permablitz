<?php
/*$key = '6c44dedaacea60df3d3e8f4e26ccca9fv';

if (!empty($_GET['k']))
	$incoming_key = $_GET['k'];
if (empty($incoming_key) || $incoming_key != $key) {
	echo "Permission denied";
	throw new exception('Permission denied due to invalid or missing key');
	die();
}*/


	header('Content-type: application/xml');

$newslettertype = (isset($_GET['type']) ? strip_tags(addslashes($_GET['type'])) : 'coverstory' );
require_once('library.php');

$nzl_library_inst = new nzl_library();


function getIDsFromArray($array, $count=6) {

	$i = 0;

	$output = array();

	foreach ($array as $arr) {
		if ($i < $count ) {
			array_push($output, $arr['post_id']);
		}

		$i++;
	}

	return $output;

}

function output_rss_category($feedname, $feed_content) {

	$output = "<rss version='2.0'>" . "\n";
	$output .= '<channel>'  . "\n";
	$output .= '<title>Listener: ' . $feedname . '</title>' . "\n";
	$output .= '<link>http://listener.co.nz</link>' . "\n";
	$output .= '<description>' . $feedname . '</description>' . "\n";

	foreach ($feed_content as $feed) {

		$output .= '<item>'  . "\n";
		$output .= '<title><![CDATA[' . $feed['title'] . ']]></title>'  . "\n";
		$output .= '<link>' . $feed['link'] . '</link>'  . "\n";
		$output .= '<description><![CDATA[' . $feed['description'] . ']]></description>'  . "\n";
		$output .= '<enclosure url="' . $feed['enclosure'] . '" type="image/jpeg"></enclosure>'  . "\n";
		$output .= '<category><![CDATA[' . $feed['category'] . ']]></category>'  . "\n";
		$output .= '<comments>' . $feed['comments'] . '</comments>'  . "\n";
		$output .= '<author>' . $feed['author'] . '</author>'  . "\n";

		$output .= '</item>'  . "\n";
	}

	$output .= '</channel>'  . "\n";
	$output .= '</rss>'  . "\n";

	return $output;

}

function rss_category_data($newslettertype, $feedname, $count, $total_exclusions) {

	$category_info = get_category_by_slug($newslettertype);


	$args = array(
			'posts_per_page' 	=> $count,
			'category'			=> $category_info->term_id,
			'orderby'			=> 'post_date',
			'order'				=> 'DESC',
			'exclude'			=> $total_exclusions
		);

	$myposts = get_posts( $args );

	$feed_content = array();

	foreach ( $myposts as $post ) : setup_postdata( $post );

		$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );

		$categories = get_the_category( $post->ID );
		$category_list = '';

		foreach($categories as $category) {
			$category_list .= $category->cat_name . ', ';
		}

		if(get_post_meta( get_the_ID(), 'pay_flag', true) == 'true'){
				$source =  'http://www.listener.co.nz/wp-content/themes/nzl/images/locked_icon.png'; //lock icon url
			}else{
				$source = 'http://www.listener.co.nz/wp-content/themes/nzl/images/blank.png';
			}

			$terms = get_the_terms( $post->ID, 'contributor' );
			foreach ( $terms as $term ) {
				$author = $term->name;
			}

		
		$feed_content[] = array(
						'title' => get_the_title($post->ID),
						'link' => get_permalink($post->ID),
						'description' => get_the_excerpt($post->ID),
						'enclosure' => $image[0],
						'category' => rtrim( trim($category_list), ','),
						'comments' => $source,
						'author' => $author
						);
	endforeach; 

	wp_reset_postdata();

	echo output_rss_category($feedname, $feed_content);

	die();

}


$link_append = array('permalink', 'post_image');
$name_map = array('post_id' => 'post_id', 'excerpt' => 'excerpt', 'permalink' => 'link', 'title' => 'title', 'author' => 'author', 'category_name' => 'category',
	'post_image' => 'image', 'pay_flag' => 'pay_flag');
$content_count = 200;
$exclude_ids = array();

//Current Issue number
$current_issue = $nzl_library_inst->getCurrentIssue_object_updated();
$issue_number= $current_issue[0]->slug;

$issue = $nzl_library_inst->getCurrentIssueStories(100);
$commentary = array();
$books = array();
$lifestyle = array();
$entertainment = array();

foreach ($issue['stories'] as $i => $istory){
	$story_struc = array();
	foreach ($istory as $title => $value) {
		//$value = (in_array($title, $link_append) ? 'http://www.listener.co.nz' . $value : $value);
		if ($name_map[$title]) {
			$story_struc[$name_map[$title]] = $value;
		}
	}
	$author = $nzl_library_inst->get_post_tag(array('post_id' => $istory['post_id'], 'type' => 'contributor', 'return_id' => true, 'link' => 'split'));
		if (!empty($author['author_display_name']))
			$story_struc['author'] = array_pop($author['author_display_name']);
	
	$category = $nzl_library_inst->get_post_tag(array('post_id' => $istory['post_id'], 'type' => 'category', 'return_id' => true, 'link' => 'split'));
		if (!empty($category['author_display_name']))
			$story_struc['category'] = array_pop($category['author_display_name']);


	if(strpos($story_struc['link'], '/commentary/') !== false)
	{				
		array_push($commentary,$story_struc);
	}
	if(strpos($story_struc['link'], '/books/') !== false)
	{
		array_push($books,$story_struc);
	}
	if(strpos($story_struc['link'], '/lifestyle/') !== false)
	{
		array_push($lifestyle,$story_struc);
	}
	if(strpos($story_struc['link'], '/current-affairs/') !== false)
	{
		array_push($lifestyle,$story_struc);
	}
	if(strpos($story_struc['link'], '/entertainment/') !== false)
	{
		array_push($entertainment,$story_struc);
	}
}

/*************** CURRENT ISSUE FEED - START *************************/
if($newslettertype == 'issue'){
	$archivepost_ids = $nzl_library_inst->getPostIDsByTax(array('limit' => 1, 'tax_type' => 'category', 'exclude_ids' => $exclude_ids, 'term_slug_filter' => 'archive'));
	$archivefeed_story = $nzl_library_inst->getCategoryList(array('limit' => 1, 'pay_flag' => true, 'getcategory' => true,
				'get_date' => true, 'include_ids' => $archivepost_ids, 'imageType' => 'herald_feed', 'blurb' => true, 'blurbLength' => $content_count));
	$exclude_ids = $archivepost_ids;
	$archivefeed = array();

	$latest = showLatestIssue();
	
	foreach ($archivefeed_story as $aid => $astory) {
		$archivefeed_struc = array();
		foreach ($astory as $title => $value) {
			if ($name_map[$title]) {
				$archivefeed_struc[$name_map[$title]] = $value;
			}
		}
		$archivefeed[] = $archivefeed_struc;
	}



?>
<?php // <?xml version='1.0' encoding='UTF-8'?> 
<rss version='2.0'>  
<channel>
	<title>Listener: Current Issue feed</title>
	<link>http://listener.co.nz</link>
	<description>Current Issue feed</description>
	<?php
	foreach ($archivefeed as $af) {
		$title = $af['title'];
		$link = $af['link'] ."?ref=e"; 
		$excerpt = $af['excerpt'];
		$date = $af['post_id'];
		$image = $af['image'];
		$category = $af['category'];
		$author = $af['author'];
		if($af['pay_flag'] == 'true'){
			$source =  'http://www.listener.co.nz/wp-content/themes/nzl/images/locked_icon.png'; //lock icon url
		}else{
			$source = 'http://www.listener.co.nz/wp-content/themes/nzl/images/blank.png';
		}
	?>
		<item>
			<title><![CDATA[<?php echo $title ?>]]></title>
			<link><?php echo $link ?></link>
			<description><![CDATA[<?php echo $excerpt ?>]]></description>
			<enclosure url="<?php echo $latest['cover']; ?>" type="image/jpeg"></enclosure>
			<category><![CDATA[<?php echo $category ?>]]><![CDATA[<?php echo $source ?>]]></category>
			<comments><?php echo $source ?></comments>
			<author><?php echo $author ?></author>
		 </item>
	<?php
	}
	?>
</channel>
</rss>
<?php
}
/*************** CURRENT ISSUE FEED - END *************************/

/*************** COVER STORY FEED - START *************************/

	$archivepost_ids = $nzl_library_inst->getPostIDsByTax(array('limit' => 1, 'tax_type' => 'category', 'exclude_ids' => $exclude_ids, 'term_slug_filter' => 'archive'));
	$exclude_ids = $archivepost_ids;
	$coverstorypost_ids = $nzl_library_inst->getPostIDsByTax(array('limit' => 1, 'tax_type' => 'post_tag', 'exclude_ids' => $exclude_ids, 'term_slug_filter' => 'cover-story'));
	$coverstory_story = $nzl_library_inst->getCategoryList(array('limit' => 1, 'pay_flag' => true, 'getcategory' => true,
				'get_date' => true, 'include_ids' => $coverstorypost_ids, 'imageType' => 'thumb', 'blurb' => true, 'blurbLength' => $content_count));
	$exclude_ids = array_merge($exclude_ids,$coverstorypost_ids);
	$coverstoryfeed = array();
	foreach ($coverstory_story as $csid => $csstory) {
		$coverstoryfeed_struc = array();
		foreach ($csstory as $title => $value) {
			//$value = (in_array($title, $link_append) ? 'http://www.listener.co.nz' . $value : $value);
			if ($name_map[$title]) {
				$coverstoryfeed_struc[$name_map[$title]] = $value;
			}
		}
		$author = $nzl_library_inst->get_post_tag(array('post_id' => $csstory['post_id'], 'type' => 'contributor', 'return_id' => true, 'link' => 'split'));
		if (!empty($author['author_display_name']))
			$coverstoryfeed_struc['author'] = array_pop($author['author_display_name']);

		$coverstoryfeed[] = $coverstoryfeed_struc;
	}

	$exclude_cover_IDs = getIDsFromArray($coverstoryfeed, 1);

if($newslettertype == 'cover_story'){
?>
<?php // <?xml version='1.0' encoding='UTF-8'?>
<rss version='2.0'>
<channel>
	<title>Listener: Cover Story feed</title>
	<link>http://listener.co.nz</link>
	<description>Cover story feed</description>
	<?php
	foreach ($coverstoryfeed as $csf) {
		$title = $csf['title'];
		$link = $csf['link'] ."?ref=e";
		$excerpt = $csf['excerpt'];
		$date = strtotime($csf['post_id']);
		$image = $csf['image'];
		$category = $csf['category'];
		$author = $csf['author'];
		if($csf['pay_flag'] == 'true'){
			$source =  'http://www.listener.co.nz/wp-content/themes/nzl/images/locked_icon.png'; //lock icon url
		}else{
			$source = 'http://www.listener.co.nz/wp-content/themes/nzl/images/blank.png';
		}
	?>
		<item>
			<title><![CDATA[<?php echo $title ?>]]></title>
			<link><?php echo $link ?></link>
			<description><![CDATA[<?php echo $excerpt ?>]]></description>
			<enclosure url="http://www.listener.co.nz<?php echo $image ?>" type="image/jpeg"></enclosure>
			<category><![CDATA[<?php echo $category ?>]]></category>
			<comments><?php echo $source ?></comments>
			<author><?php echo $author ?></author>
		 </item>
	<?php
	}
	?>
</channel>
</rss>
<?php
}
/*************** COVER STORY FEED- END *************************/

/*************** MAG FEATURES FEED - START *************************/

	$archivepost_ids = $nzl_library_inst->getPostIDsByTax(array('limit' => 1, 'tax_type' => 'category', 'exclude_ids' => $exclude_ids, 'term_slug_filter' => 'archive'));
	$exclude_ids = $archivepost_ids;
	$coverstorypost_ids = $nzl_library_inst->getPostIDsByTax(array('limit' => 1, 'tax_type' => 'post_tag', 'exclude_ids' => $exclude_ids, 'term_slug_filter' => 'cover-story'));
	$exclude_ids = array_merge($exclude_ids,$coverstorypost_ids);
	$magftpost_ids = $nzl_library_inst->getPostIDsByTax(array('limit' => 10, 'tax_type' => 'post_tag', 'exclude_ids' => $exclude_ids, 'term_slug_filter' => 'mag-features'));
	$magft_story = $nzl_library_inst->getCategoryList(array('limit' => 10, 'pay_flag' => true, 'getcategory' => true,
				'get_date' => true, 'include_ids' => $magftpost_ids, 'imageType' => 'thumb', 'blurb' => true, 'blurbLength' => $content_count));
	$magftfeed = array();
		
	$magftfeed_struc = array();
	foreach ($magft_story as $mfid => $mfstory) {

		foreach ($mfstory as $title => $value) {
			if ($name_map[$title]) {
				$magftfeed_struc[$name_map[$title]] = $value;
			}
		}
		$author = $nzl_library_inst->get_post_tag(array('post_id' => $mfstory['post_id'], 'type' => 'contributor', 'return_id' => true, 'link' => 'split'));
		if (!empty($author['author_display_name']))
			$magftfeed_struc['author'] = array_pop($author['author_display_name']);


		$issue = strip_tags($nzl_library_inst->get_post_tag(array('post_id' => $magftfeed_struc['post_id'], 'type' => 'issue') ));
		 if($issue == $issue_number) {
			$magftfeed[] = $magftfeed_struc;
		}

		array_push($magftfeed, $magftfeed_struc);

	}

	$exclude_mag_feat_IDs = getIDsFromArray($magftfeed, 4);

	$total_exclusions = array_merge($exclude_mag_feat_IDs, $exclude_cover_IDs);


switch ($newslettertype) {
	case 'commentary':
		rss_category_data($newslettertype, 'Commentary feed', 6, $total_exclusions);
	break;
	case 'books':	
		rss_category_data($newslettertype, 'Book feed', 6, $total_exclusions);
	break;
	case 'life':	
		rss_category_data($newslettertype, 'Life feed', 10, $total_exclusions);
	break;
	case 'entertainment':
		rss_category_data($newslettertype, 'Entertainment feed', 6, $total_exclusions);
	break;
}


if($newslettertype == 'mag_features'){

?>
<?php // <?xml version='1.0' encoding='UTF-8'?>
<rss version='2.0'>
<channel>
	<title>Listener: Mag Features feed</title>
	<link>http://listener.co.nz</link>
	<description>Mag Features feed</description>
	<?php
	foreach ($magftfeed as $mff) {
		$title = $mff['title'];
		$link = $mff['link'] ."?ref=e";
		$excerpt = $mff['excerpt'];
		$date = strtotime($mff['post_id']);
		$image = $mff['image'];
		$category = $mff['category'];
		$author = $mff['author'];
		if($mff['pay_flag'] == 'true'){
			$source =  'http://www.listener.co.nz/wp-content/themes/nzl/images/locked_icon.png'; //lock icon url
		}else{
			$source = 'http://www.listener.co.nz/wp-content/themes/nzl/images/blank.png';
		}
	?>
		<item>
			<title><![CDATA[<?php echo $title ?>]]></title>
			<link><?php echo $link ?></link>
			<description><![CDATA[<?php echo $excerpt ?>]]></description>
			<enclosure url="http://www.listener.co.nz<?php echo $image ?>" type="image/jpeg"></enclosure>
			<category><![CDATA[<?php echo $category ?>]]></category>
			<comments><?php echo $source ?></comments>
			<author><?php echo $author ?></author>
		 </item>
	<?php
	}
	?>
</channel>
</rss>
<?php
}
/*************** MAG FEATURES - END *************************/

/*************** COMMENTARY FEED - START *************************/
/*
if($newslettertype == 'commentary'){

?>
<?php // <?xml version='1.0' encoding='UTF-8'?>
<rss version='2.0'>
<channel>
	<title>Listener: Commentary feed</title>
	<link>http://listener.co.nz</link>
	<description>Commentary feed</description>
	<?php
	foreach ($commentary as $cf) {
		$title = $cf['title'];
		$link = $cf['link'] ."?ref=e";
		$excerpt = $cf['excerpt'];
		$date = $cf['post_id'];
		$image = $cf['image'];
		$category = $cf['category'];
		$author = $cf['author'];
		if($cf['pay_flag'] == 'true'){
			$source =  'http://www.listener.co.nz/wp-content/themes/nzl/images/locked_icon.png'; //lock icon url
		}else{
			$source = 'http://www.listener.co.nz/wp-content/themes/nzl/images/blank.png';
		}
	?>
		<item>
			<title><![CDATA[<?php echo $title ?>]]></title>
			<link><?php echo $link ?></link>
			<description><![CDATA[<?php echo $excerpt ?>]]></description>
			<enclosure url="http://www.listener.co.nz<?php echo $image ?>" type="image/jpeg"></enclosure>
			<category><![CDATA[<?php echo $category ?>]]></category>
			<comments><?php echo $source ?></comments>
			<author><?php echo $author ?></author>
		 </item>
	<?php
	}
	?>
</channel>
</rss>
<?php
}
*/
/*************** COMMENTARY FEED - END *************************/

/*************** LIFESTYLE FEED - START *************************/
/*
if($newslettertype == 'life'){

	function date_compare($a, $b)
	{
	    $t1 = strtotime($a['post_date']);
	    $t2 = strtotime($b['post_date']);
	    if ($t1 == $t2) {
	        return 0;
	    }
	    return ($t1 > $t2) ? -1 : 1;
	}
	usort($lifestyle, 'date_compare');
	
?>
<?php // <?xml version='1.0' encoding='UTF-8'?>
<rss version='2.0'>
<channel>
	<title>Listener: Life feed</title>
	<link>http://listener.co.nz</link>
	<description>Life Current Affairs feed</description>
	<?php
	foreach ($lifestyle as $lf) {
		$title = $lf['title'];
		$link = $lf['link'] ."?ref=e";
		$excerpt = $lf['excerpt'];
		$date = $lf['post_id'];
		$image = $lf['image'];
		$category = $lf['category'];
		$author = $lf['author'];
		if($lf['pay_flag'] == 'true'){
			$source =  'http://www.listener.co.nz/wp-content/themes/nzl/images/locked_icon.png'; //lock icon url
		}else{
			$source = 'http://www.listener.co.nz/wp-content/themes/nzl/images/blank.png';
		}
	?>
		<item>
			<title><![CDATA[<?php echo $title ?>]]></title>
			<link><?php echo $link ?></link>
			<description><![CDATA[<?php echo $excerpt ?>]]></description>
			<enclosure url="http://www.listener.co.nz<?php echo $image ?>" type="image/jpeg"></enclosure>
			<category><![CDATA[<?php echo $category ?>]]></category>
			<comments><?php echo $source ?></comments>
			<author><?php echo $author ?></author>
		 </item>
	<?php
	}
	?>
</channel>
</rss>
<?php
}
*/
/*************** LIFE FEED - END *************************/

/*************** BOOKS & CULTURE FEED - START *************************/
/*
if($newslettertype == 'books'){
?>
<?php // <?xml version='1.0' encoding='UTF-8'?>
<rss version='2.0'>
<channel>
	<title>Listener: Book feed</title>
	<link>http://listener.co.nz</link>
	<description>Book feed</description>
	<?php
	foreach ($books as $bf) {
		$title = $bf['title'];
		$link = $bf['link'] ."?ref=e";
		$excerpt = $bf['excerpt'];
		$date = strtotime($bf['post_id']);
		$image = $bf['image'];
		$category = $bf['category'];
		$author = $bf['author'];
		if($bf['pay_flag'] == 'true'){
			$source =  'http://www.listener.co.nz/wp-content/themes/nzl/images/locked_icon.png'; //lock icon url
		}else{
			$source = 'http://www.listener.co.nz/wp-content/themes/nzl/images/blank.png';
		}
	?>
		<item>
			<title><![CDATA[<?php echo $title ?>]]></title>
			<link><?php echo $link ?></link>
			<description><![CDATA[<?php echo $excerpt ?>]]></description>
			<enclosure url="http://www.listener.co.nz<?php echo $image ?>" type="image/jpeg"></enclosure>
			<category><![CDATA[<?php echo $category ?>]]></category>
			<comments><?php echo $source ?></comments>
			<author><?php echo $author ?></author>
		 </item>
	<?php
	}
	?>
</channel>
</rss>
<?php
}
*/
/*************** BOOKS & CULTURE FEED - END *************************/

/*************** ENTERTAINMENT FEED - START *************************/
/*
if($newslettertype == 'entertainment'){
?>
<?php // <?xml version='1.0' encoding='UTF-8'?>
<rss version='2.0'>
<channel>
	<title>Listener: Entertainment feed</title>
	<link>http://listener.co.nz</link>
	<description>Entertainment feed</description>
	<?php
	foreach ($entertainment as $ef) {
		$title = $ef['title'];
		$link = $ef['link'] ."?ref=e";
		$excerpt = $ef['excerpt'];
		$date = $ef['post_id'];
		$image = $ef['image'];
		$category = $ef['category'];
		$author = $ef['author'];
		if($ef['pay_flag'] == 'true'){
			$source =  'http://www.listener.co.nz/wp-content/themes/nzl/images/locked_icon.png'; //lock icon url
		}else{
			$source = 'http://www.listener.co.nz/wp-content/themes/nzl/images/blank.png';
		}
	?>
		<item>
			<title><![CDATA[<?php echo $title ?>]]></title>
			<link><?php echo $link ?></link>
			<description><![CDATA[<?php echo $excerpt ?>]]></description>
			<enclosure url="http://www.listener.co.nz<?php echo $image ?>" type="image/jpeg"></enclosure>
			<category><![CDATA[<?php echo $category ?>]]></category>
			<comments><?php echo $source ?></comments>
			<author><?php echo $author ?></author>
		 </item>
	<?php
	}
	?>
</channel>
</rss>
<?php
}
*/
/*************** ENTERTAINMENT FEED - END *************************/

?>