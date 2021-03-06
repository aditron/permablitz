<?php 
/**
 * Template Name: Volunteer dropouts
 *
 * Allow  to notify hosts that they can't attend.
 *
 */

if(isset($wp_query->query_vars['vol_key'])) {
  $vol_key = urldecode($wp_query->query_vars['vol_key']);
  // check to see if user has already dropped out
} else {
	wp_redirect( home_url() );
}
get_header(); 
?>

<section class="content">
	
	<?php get_template_part('parts/page-title'); ?>
	
	<div class="pad group">
		
		<?php while ( have_posts() ): the_post(); ?>
		
			<article <?php post_class('group'); ?>>
				
				<?php // get_template_part('parts/page-image'); ?>
				
				<div class="entry themeform">
					<?php the_content(); ?>
					<div class="clear"></div>
				</div><!--/.entry-->
				
			</article>
			
			<?php if ( hu_is_checked('page-comments') == 'on' ) { comments_template('/comments.php',true); } ?>
			
		<?php endwhile; ?>
		
	</div><!--/.pad-->
	
</section><!--/.content-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>