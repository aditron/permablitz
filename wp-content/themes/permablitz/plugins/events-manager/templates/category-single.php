<?php
/*
 * This page displays a single event, called during the em_content() if this is an event page.
 * You can override the default display settings pages by copying this file to yourthemefolder/plugins/events-manager/templates/ and modifying it however you need.
 * You can display events however you wish, there are a few variables made available to you:
 * 
 * $args - the args passed onto EM_Events::output() 
 */
global $EM_Category; 
/* @var $EM_Category EM_Category */

$current_url = get_permalink();

echo '<div class="post-list group event-list">';
echo $EM_Category->output_single();
echo '</div>';


?>
<script>
jQuery( document ).ready(function($) {
	$(".themeform article:even").each(function(index) {
		$(this).next().andSelf().wrapAll("<div class='post-row' />")
	});
});
</script>