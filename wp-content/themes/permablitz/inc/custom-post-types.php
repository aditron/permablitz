<?php
/**

  DESIGNERS taxonomy

*/

function blitz_designers_post_type() {

$labels = array(
    'name'              => _x( 'Designers', 'taxonomy general name' ),
    'singular_name'     => _x( 'Designer', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Designers' ),
    'all_items'         => __( 'All Designers' ),
    'edit_item'         => __( 'Edit Designer' ),
    'update_item'       => __( 'Update Designer' ),
    'add_new_item'      => __( 'Add New Designer' ),
    'new_item_name'     => __( 'New Designer Name' ),
    'menu_name'         => __( 'Designers' ),
  );

  $args = array(
    'hierarchical'      => false,
    'labels'            => $labels,
    'show_ui'           => true,
    'show_admin_column' => true,
    'query_var'         => true,
    'rewrite'           => array( 'slug' => 'designer' )
  );

  register_taxonomy( 'designer', array( 'post' ), $args );

}
add_action( 'init', 'blitz_designers_post_type', 0 );

/**

  DESIGNERS taxonomy

*/

function newsletter_post_type() {

$labels = array(
    'name'              => _x( 'Newsletters', 'taxonomy general name' ),
    'singular_name'     => _x( 'Newsletter', 'taxonomy singular name' ),
    'search_items'      => __( 'Search Newsletters' ),
    'all_items'         => __( 'All Newsletters' ),
    'edit_item'         => __( 'Edit Newsletter' ),
    'update_item'       => __( 'Update Newsletter' ),
    'add_new_item'      => __( 'Add New Newsletter' ),
    'new_item_name'     => __( 'New Newsletter Name' ),
    'menu_name'         => __( 'Newsletters' ),
  );

  $args = array(
    'labels'        => $labels,
    'description'   => 'Manages newsletters',
    'public'        => true,
    'menu_position' => 45,
    'menu_icon'     => 'dashicons-media-text',
    'show_in_nav_menus' => true,
    'show_in_admin_bar' => true,
    'supports' => array( 'title', 'revisions' ),
    'has_archive'   => false,
    'rewrite'           => array( 'slug' => 'newsletter-preview' )
  );


  register_post_type( 'newsletter', $args );
}
add_action( 'init', 'newsletter_post_type' );

function newsletter_custom_taxonomies() {
    $labels = array(
  'name' => _x('Newsletter Categories', 'taxonomy general name'),
  'singular_name' => _x('Newsletter Category', 'taxonomy singular name'),
  'search_items' => __('Search Newsletter Categories'),
  'all_items' => __('All Newsletter Categories'),
  'parent_item' => __('Parent Newsletter Category'),
  'parent_item_colon' => __('Parent Newsletter Category:'),
  'edit_item' => __('Edit Newsletter Category'),
  'update_item' => __('Update Newsletter Category'),
  'add_new_item' => __('Add New Newsletter Category'),
  'new_item_name' => __('New Newsletter Category'),
  'menu_name' => __('Newsletter Categories'),
    );
    
    register_taxonomy(
      'newsletter_category', 
      'newsletter', 
      array(
      'labels' => $labels,
      'hierarchical' => true,
      'query_var' => true,
      'show_admin_column' => true
      )
    );
}
add_action( 'init', 'newsletter_custom_taxonomies', 0 );
?>