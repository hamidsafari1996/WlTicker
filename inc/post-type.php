<?php
/**
 * Register a post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function wl_ticker_register_post_type() {
	global $WLTICKER;
	$labels = array(
		'name'               => __( 'Tickers', 'wlticker' ),
		'singular_name'      => __( 'Ticker', 'wlticker' ),
		'menu_name'          => __( 'Tickers', 'wlticker' ),
		'name_admin_bar'     => __( 'Ticker', 'wlticker' ),
		'add_new'            => __( 'Add New', 'wlticker' ),
		'add_new_item'       => __( 'Add New Ticker', 'wlticker' ),
		'new_item'           => __( 'New Ticker', 'wlticker' ),
		'edit_item'          => __( 'Edit Ticker', 'wlticker' ),
		'view_item'          => __( 'View Ticker', 'wlticker' ),
		'all_items'          => __( 'All Tickers', 'wlticker' ),
		'search_items'       => __( 'Search Tickers', 'wlticker' ),
		'parent_item_colon'  => __( 'Parent Tickers:', 'wlticker' ),
		'not_found'          => __( 'No Ticker found.', 'wlticker' ),
		'not_found_in_trash' => __( 'No Ticker found in Trash.', 'wlticker' )
	);

	$args = array(
		'labels'               => $labels,
		'description'          => __( 'Description.', 'wlticker' ),
		'public'               => true,
		'publicly_queryable'   => true,
		'show_ui'              => true,
		'show_in_menu'         => true,
		'query_var'            => true,
		'rewrite'              => array( 'slug' => 'wlticker' ),
		'capability_type'      => 'post',
		'has_archive'          => true,
		'hierarchical'         => false,
		'menu_position'        => null,
		'menu_icon'            => 'dashicons-tickets-alt',
		'supports'             => array( 'title' ),
	);

	register_post_type( 'wlticker', $args );
}
add_action( 'init', 'wl_ticker_register_post_type' );

?>