<?php
/*
 * Default Events List Template
 * This page displays a list of events, called during the em_content() if this is an events list page.
 * You can override the default display settings pages by copying this file to yourthemefolder/plugins/events-manager/templates/ and modifying it however you need.
 * You can display events however you wish, there are a few variables made available to you:
 * 
 * $args - the args passed onto EM_Events::output()
 * 
 */
$current_url = get_permalink();

$events_count = EM_Events::count( apply_filters('em_content_events_args', $args) ); //Get events first, so we know how many there are in advance
$args = apply_filters('em_content_events_args', $args);
$args['[pagination'] = 0;

echo '<div class="post-list group event-list">';

echo EM_Events::output( $args );

echo "</div>";


?>
<script>
jQuery( document ).ready(function($) {
	$(".post-list article:even").each(function(index) {
		$(this).next().andSelf().wrapAll("<div class='post-row' />")
	});
});
</script>

<?php
		if( !empty($args['limit']) && $events_count > $args['limit'] ){

			echo '<nav class="pagination group"><div class="wp-pagenavi">';

				$page_total = ceil($events_count / $args['limit']);

			//Show the pagination links (unless there's less than $limit events)
			$search_args = EM_Events::get_post_search() + array('page'=>'%PAGE%','_wpnonce'=>$_REQUEST['_wpnonce']);
			$page_link_template = preg_replace('/(&|\?)page=\d+/i','',$_SERVER['REQUEST_URI']);
				$page_link_template = em_add_get_params($page_link_template, $search_args);
				$page_num = isset($_GET['pno']) ? $_GET['pno'] : 1;


				echo '<span class="pages">Page '.$page_num	.' of '.$page_total.'</span>';

				if ($page_num > 1) {
						echo '<a class="previouspostslink" href="'.$current_url.'?pno='. intval($page_num-1) .'" rel="prev">«</a>';
				}
				for ($i=1; $i<=$page_total; $i++) {

						if ($page_num == $i) {
								echo '<span class="current">'.$i.'</span>';
						} else if ($page_num < $i) {
							echo '<a class="page smaller" href="'.$current_url.'?pno='.$i.'">'.$i.'</a>';
						} else {
							echo '<a class="page larger" href="'.$current_url.'?pno='.$i.'">'.$i.'</a>';
						}

				}

				if ($page_num < $page_total) {
						echo '<a class="nextpostslink" href="'.$current_url.'?pno='. intval($page_num+1) .'" rel="next">»</a>';
				}
					

			echo '</div> </nav>';
		}
?>