<?php get_header(); ?>

<section class="content">
	
	<?php get_template_part('inc/page-title'); ?>

	<?php
		if (is_user_logged_in() ) {
		global $current_user;
		$current_user = wp_get_current_user();
		$designers_guide_tags = get_the_author_meta( 'designers_guide', $current_user->ID );
		$facilitators_guide_tags = get_the_author_meta( 'facilitators_guide', $current_user->ID );
		if (!$designers_guide_tags || !$facilitators_guide_tags) {
	?>
	<div class="pad group ">
	<div class="bz_feat">
		<?php if (!$designers_guide_tags) { ?>
		<p>Make sure you've read the <a href="https://www.dropbox.com/s/ws18zet84awvpd9/PermablitzDesignersGuide.pdf?dl=0" target="blank">Designers' Guide</a>! You can <a href="/designer-profile/">check this off</a> once you've read it - and you won't have to see this message again!</p>
		<?php } ?>

		<?php if (!$facilitators_guide_tags) { ?>
		<p>Make sure you've read the <a href="https://www.dropbox.com/s/3c5ei8hlm3kergy/FacilitatorsGuide.pdf?dl=0" target="blank">Facilitators' Guide</a>!  You can <a href="/designer-profile/">check this off</a> once you've read it - and you won't have to see this message again!</p>
		<?php } ?>
		<p><a href="/designer-profile/">Update your details</a> | <a href="/designers-page-application/">Get your own Blitz Archive happening!</a></p>
	</div>
	</div>
	<?php } } ?>
	
	<div class="pad group">
		
		<?php while ( have_posts() ): the_post(); ?>
			<article <?php post_class(); ?>>	
				<div class="post-inner group">
					
					<h1 class="post-title"><?php the_title(); ?></h1>
					<p class="post-byline">Date of request: <?php the_time(get_option('date_format')); ?></p>
					
					<?php if( get_post_format() ) { get_template_part('inc/post-formats'); } ?>
					
					<div class="clear"></div>
					
					<div class="entry <?php if ( ot_get_option('sharrre') != 'off' ) { echo 'share'; }; ?>">	
						<div class="entry-inner">
							<?php the_content(); ?>
							<?php if (!is_user_logged_in() ) { 
									echo guild_member_login_text();

									if ( ! dynamic_sidebar( 'sidebar-login' ) ) :
										dynamic_sidebar( 'sidebar-login' );
									endif;
								?>
							<a href="<?php echo wp_lostpassword_url(); ?>" title="Lost Password">Lost Password</a>
							<?php } ?>
							<?php wp_link_pages(array('before'=>'<div class="post-pages">'.__('Pages:','hueman'),'after'=>'</div>')); ?>
						</div>
						<?php // if ( ot_get_option('sharrre') != 'off' ) { get_template_part('inc/sharrre'); } ?>
						<div class="clear"></div>				
					</div><!--/.entry-->
					
				</div><!--/.post-inner-->	
			</article><!--/.post-->				
		<?php endwhile; ?>
		
		<div class="clear"></div>
		
		<?php the_tags('<p class="post-tags"><span>'.__('Tags:','hueman').'</span> ','','</p>'); ?>
		
		<?php if ( ( ot_get_option( 'author-bio' ) != 'off' ) && get_the_author_meta( 'description' ) ): ?>
			<div class="author-bio">
				<div class="bio-avatar"><?php echo get_avatar(get_the_author_meta('user_email'),'128'); ?></div>
				<p class="bio-name"><?php the_author_meta('display_name'); ?></p>
				<p class="bio-desc"><?php the_author_meta('description'); ?></p>
				<div class="clear"></div>
			</div>
		<?php endif; ?>
		
		<?php if ( ot_get_option( 'post-nav' ) == 'content') { get_template_part('inc/post-nav'); } ?>
		
		<?php if ( ot_get_option( 'related-posts' ) != '1' ) { get_template_part('inc/related-posts'); } ?>
		
		<?php comments_template('/comments.php',true); ?>
		
	</div><!--/.pad-->
	
</section><!--/.content-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>
