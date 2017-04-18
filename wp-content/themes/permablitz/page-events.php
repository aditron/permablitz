<?php /* Template Name: Events */
get_header(); ?>

<section class="content">
	
	<?php get_template_part('parts/page-title'); ?>
	
	<div class="pad group">
		
		<?php while ( have_posts() ): the_post(); ?>
		
			<article <?php post_class('group'); ?>>
				
				<div class="themeform">
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