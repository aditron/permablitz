<?php get_header(); ?>

<section class="content">

	<div class="page-title pad group">
		<h1>
			<i class="fa fa-facebook"></i>
			<?php _e('Category:','hueman'); ?> <span>Popular Facebook Posts</span>
		</h1>
	</div>
	
	<div class="pad group masonry-grid">		
		
		<?php if ((category_description() != '') && !is_paged()) : ?>
			<div class="notebox">
				<?php echo category_description(); ?>
			</div>
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>
		
		
				<?php while ( have_posts() ): the_post(); ?>

					<?php
						$data = get_fields( get_the_ID() );
     		
			     		$img = $data['hero_image'];
			            if(!$img) {
			                $img = get_post_thumbnail_id( get_the_ID() );
			            }
					?>
					
					<div class="msnry">
						<div>
							<a href="<?php echo $data['permablitz_fb_url']; ?>" target="_blank">
								<?php echo wp_get_attachment_image( $img, 'thumb-medium' ); ?>
								<p><?php the_title(); ?></p>
							</a>
						</div>
					</div>

				<?php endwhile; ?>
			
		<?php endif; ?>
		
		<?php //echo do_shortcode('[wmls name="facebook-posts" id="1"] '); ?>
		
	</div><!--/.pad-->
	
</section><!--/.content-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>