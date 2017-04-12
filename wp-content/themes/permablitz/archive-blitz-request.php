<?php get_header(); ?>

<section class="content">
	
	<div class="page-title pad group">
		<h1>
			<i class="fa fa-folder-open"></i>
			<?php _e('Category:','hueman'); ?> <span>Blitz Requests</span>
		</h1>
	</div>

	<?php if( !is_user_logged_in() ) {
		echo '<div class="pad group">';
		echo guild_member_login_text();
		echo '<div class="designer-login">';
		if (!is_user_logged_in() ) { ?>
			<a href="<?php echo wp_lostpassword_url(); ?>" title="Lost Password">Lost Password</a>
	<?php
		}

		echo '</div>';
		echo '</div>';
	} else { ?>			 

	<?php
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
	<?php } ?>

	<div class="pad group">
		
		<?php $map_required = get_field( 'do_you_want_to_add_map_locations' ,'option');
			if ( $map_required ) :
				global $add_map_scripts;
				$add_map_scripts = true;

				$args = array(
					'posts_per_page'   => -1,
					'post_type'        => 'blitz-request'
				);
				$myposts = get_posts( $args );
				$output = '';
				if (count($myposts)):
				$output .= '<div class="acf-map">';
foreach ( $myposts as $post ) : setup_postdata( $post ); 
$locs = get_field('map_location', $post->ID);
$output .= '<div class="marker" data-lat="' . $locs['lat'] . '" data-lng="' . $locs['lng'] . '">
							<h4><a href="'.get_permalink().'">'.get_the_title().'</a></h4>
							<p>' . get_the_excerpt() . '</p>
						</div>';
endforeach; 
$output .= '</div>';
endif;
wp_reset_postdata();

				// $output = '';
				// $map_locations = get_field( 'map_locations', 'option' );
				
				// if ( count($map_locations) >=1 && is_array($map_locations)) {

				// 	// $output .= '<div class="acf-map">';

				// 		foreach ($map_locations as $locations) {
				// 			$locs = $locations['location'];
				// 			$page = $locations['page_link'];
				// 			$page_link = get_the_permalink($page->ID);
				// 			//$thumb = wp_get_attachment_image_src( get_post_thumbnail_id($page->ID), 'thumbnail' );
							
				// 	}
				// 	// $output .= '</div>';
				// }
		?>
		<div>
			<?php echo $output; ?>
		</div>
		<?php endif; ?>

		
		<?php $desc = get_field( 'description', 'option' );
			if ((trim($desc) != '') && !is_paged()) : ?>
			<div class="notebox">
				<?php echo $desc; ?>
			</div>
		<?php endif; ?>

		<?php if ( have_posts() ) : ?>
		
			<?php if ( ot_get_option('blog-standard') == 'on' ): ?>
				<?php while ( have_posts() ): the_post(); ?>
					<?php get_template_part('content-standard'); ?>
				<?php endwhile; ?>
			<?php else: ?>
			<div class="post-list group">
				<?php $i = 1; echo '<div class="post-row">'; while ( have_posts() ): the_post(); ?>
					<?php get_template_part('content'); ?>
				<?php if($i % 2 == 0) { echo '</div><div class="post-row">'; } $i++; endwhile; 
					echo '</div>'; 
				?>
			</div><!--/.post-list-->
			<?php endif; ?>
		
			<?php get_template_part('inc/pagination'); ?>
			
		<?php endif; ?>
		
		</div>

		<?php } ?>
	
	
</section><!--/.content-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>