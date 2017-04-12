<?php $sidebar = alx_sidebar_secondary(); ?>

<?php
	if (get_post_type() == 'blitz-request') {
		$sidebar = 'sidebar-guild';
	}
?>

<div class="sidebar s2">
	
	<a class="sidebar-toggle" title="<?php _e('Expand Sidebar','hueman'); ?>"><i class="fa icon-sidebar-toggle"></i></a>
	
	<div class="sidebar-content">
		
		<?php if ( ot_get_option('sidebar-top') != 'off' ): ?>
		<div class="sidebar-top group">
			<p><?php _e('Get Involved:','hueman'); ?></p>
		</div>
		<?php endif; ?>
		
		<?php if ( ot_get_option( 'post-nav' ) == 's2') { get_template_part('inc/post-nav'); } ?>
		
		<?php dynamic_sidebar($sidebar); ?>
		
	</div><!--/.sidebar-content-->
	
</div><!--/.sidebar-->