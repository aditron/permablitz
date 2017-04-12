<?php 
/**
 * Template Name: Hosts Management
 *
 * Allow hosts to manage their blitzes
 *
 */
$form_id = 0;
if(isset($wp_query->query_vars['host_key'])) {
  $vol_key = urldecode($wp_query->query_vars['host_key']);
  $form_id = get_id_from_key_frm($vol_key, 'form');
  global $wpdb;
		$querystr = "SELECT post_id
			FROM $wpdb->postmeta
			WHERE
				(meta_key = 'frm_form_id' AND meta_value = '". $form_id ."')
		";
		$view_id = $wpdb->get_var($wpdb->prepare($querystr));
 
  // check to see if user has already dropped out
} 
if (!$form_id) {
	wp_redirect( home_url() );
}
get_header(); 
?>

<section class="content form-hosts-update">
	
	<?php get_template_part('inc/page-title') . $vol_key; ?>
	
	<div class="pad group">
		
		<?php while ( have_posts() ): the_post(); ?>
		
			<article <?php post_class('group'); ?>>
				
				<?php // get_template_part('inc/page-image'); ?>
				
				<div class="entry themeform">
					<?php the_content(); ?>
					<?php echo do_shortcode('[display-frm-data id="'.$view_id.'" filter="1" drafts="0" order="DESC"]'); ?>
<?php if (!is_user_logged_in() ) { 
							echo "<p><a href='".wp_login_url( get_permalink() )."'>Click here</a> to login.</p>";
								} ?>
					<div class="clear"></div>
				</div><!--/.entry-->
				
			</article>
			
			<?php if ( ot_get_option('page-comments') == 'on' ) { comments_template('/comments.php',true); } ?>
			
		<?php endwhile; ?>
		
	</div><!--/.pad-->
	
</section><!--/.content-->

<?php get_sidebar(); ?>

<?php get_footer(); ?>