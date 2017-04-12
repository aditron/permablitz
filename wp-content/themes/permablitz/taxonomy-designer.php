<?php get_header(); 

 $term = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );

 ?>

<section class="content designer">

<div class="page-title pad group">

		<h1><i class="fa fa-user"></i><?php _e('Designer:','hueman'); ?> <span><?php echo $term->name; ?></span></h1>
	</div>
	<div class="pad group">		
		
		<?php if ((category_description() != '') && !is_paged()) : ?>
			<div class="notebox">
				<?php echo category_description(); ?>
			</div>
		<?php endif; ?>

		<?php

			$heading = get_field('heading', 'designer_' . $term->term_id);

			if ( $heading && !is_paged() )  {

				$img = get_field('image', 'designer_' . $term->term_id);

				$content_type = get_field('content_type', 'designer_' . $term->term_id);
				if ($content_type == 'General Blurb') {
					$output = get_field('blurb', 'designer_' . $term->term_id);
				} else {
					$questions = get_field('questions', 'designer_' . $term->term_id);
					$output = null;
					foreach ($questions as $q) {
						$output .= '<h3>' . $q['question'] . '</h3>';
						$output .= '<div class="response">' . $q['answer'] . '</div>';

					}
				}

				$blitz_list_heading = get_field('blitz_list_heading', 'designer_'. $term->term_id);
				 
		?>
		<div class="post_thumbnail">
		<?php echo wp_get_attachment_image( $img, 'thumb-large' ); ?>
		</div>
		<h2><?php echo $heading; ?></h2>
		<div class="notebox">
		<?php echo $output; ?>
		</div>
		<h2><?php echo $blitz_list_heading; ?></h3>
		<?php } ?>
		
		<?php if ( have_posts() ) : ?>
		
			<?php if ( ot_get_option('blog-standard') == 'on' ): ?>
				<?php while ( have_posts() ): the_post(); ?>
					<?php get_template_part('content-standard'); ?>
				<?php endwhile; ?>
			<?php else: ?>
			<div class="post-list group">
				<?php $i = 1; echo '<div class="post-row">'; while ( have_posts() ): the_post(); ?>
					<?php get_template_part('content'); ?>
				<?php if($i % 2 == 0) { echo '</div><div class="post-row">'; } $i++; endwhile; echo '</div>'; ?>
			</div><!--/.post-list-->
			<?php endif; ?>
		
			<?php get_template_part('inc/pagination'); ?>
			
		<?php endif; ?>
		
	</div><!--/.pad-->
	
</section><!--/.content-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>