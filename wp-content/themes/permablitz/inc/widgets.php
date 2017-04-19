<?php
/*
	PbPages Widget
	
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	
	Copyright: (c) 2013 Alexander "Alx" Agnarson - http://alxmedia.se
	
		@package PbPages
		@version 1.0
*/

class PbPages extends WP_Widget {

/*  Constructor
/* ------------------------------------ */
	function PbPages() {
		parent::__construct( false, 'Single Page preview', array('description' => 'Display specific page', 'classname' => 'widget_alx_posts') );;	
	}
	
/*  Widget
/* ------------------------------------ */
	public function widget($args, $instance) {
		extract( $args );
		$instance['title']?NULL:$instance['title']='';
		$title = apply_filters('widget_title',$instance['title']);
		$output = $before_widget."\n";
		ob_start();	

		$page_id = $instance['page_id'];
		$description = $instance['description'];

		if ( has_post_thumbnail($page_id) ):


			$heading = $title ? '<h3>'.$title.'</h3>' : '';
	?>
	<?php echo $heading; ?>
	<ul class="group thumbs-enabled">
		<li>
			
			<div class="post-item-thumbnail">
				<a href="<?php echo get_permalink($page_id); ?>" title="<?php echo get_the_title($page_id); ?>">
					<?php echo get_the_post_thumbnail( $page_id, 'medium' ); ?>
				</a>
			</div>
			
			<?php if (trim($description)!="") { ?>
			<div class="post-item-inner group">
				<p class="post-item-title"><?php echo $description; ?></a></p>
			</div>
			<?php } ?>
		</li>
	</ul><!--/.alx-posts-->
<?php
		endif;
		$output .= ob_get_clean();
		$output .= $after_widget."\n";
		echo $output;
	}
	
/*  Widget update
/* ------------------------------------ */
	public function update($new,$old) {
		$instance = $old;
		$instance['title'] = strip_tags($new['title']);
		$instance['description'] = strip_tags($new['description']);
	// Page
		$instance['page_id'] = strip_tags($new['page_id']);
		return $instance;
	}

/*  Widget form
/* ------------------------------------ */
	public function form($instance) {
		// Default widget settings
		$defaults = array(
			'title' 			=> '',
			'description' 			=> '',
			'page_id' 			=> 0
		);
		$instance = wp_parse_args( (array) $instance, $defaults );
?>

	<style>
	.widget .widget-inside .alx-options-posts .postform { width: 100%; }
	.widget .widget-inside .alx-options-posts p { margin: 3px 0; }
	.widget .widget-inside .alx-options-posts hr { margin: 20px 0 10px; }
	.widget .widget-inside .alx-options-posts h4 { margin-bottom: 10px; }
	</style>
	
	<div class="alx-options-posts">
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('title') ); ?>">Title:</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('title') ); ?>" name="<?php echo esc_attr( $this->get_field_name('title') ); ?>" type="text" value="<?php echo esc_attr( $instance["title"] ); ?>" />
		</p>
		<p>
			<label style="width: 100%; display: inline-block;" for="<?php echo esc_attr( $this->get_field_id("page_id") ); ?>">Page:</label>
			<?php wp_dropdown_pages( array( 'name' => $this->get_field_name("page_id"), 'selected' => $instance["page_id"] ) ); ?>		
		</p>
		<p>Make sure the selected page contains a Featured Image, or nothing will be shown.</p>

		<p>
			<label for="<?php echo esc_attr( $this->get_field_id('description') ); ?>">Description:</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id('description') ); ?>" name="<?php echo esc_attr( $this->get_field_name('description') ); ?>" type="text" value="<?php echo esc_attr( $instance["description"] ); ?>" />
		</p>

		<hr>

	</div>
<?php

}

}

/*  Register widget
/* ------------------------------------ */
if ( ! function_exists( 'aoh_register_widget_posts' ) ) {

	function aoh_register_widget_posts() { 
		register_widget( 'PbPages' );
	}
	
}
add_action( 'widgets_init', 'aoh_register_widget_posts' );
