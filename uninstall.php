<?php
if(!defined('WP_UNINSTALL_PLUGIN')){
	exit();
}

delete_option('widget_wlticker_widget');

global $wpdb;

$wpdb->query(
	$wpdb->prepare(
		"
		DELETE FROM $wpdb->postmeta
		WHERE meta_key = %s
		OR meta_key = %s
		OR meta_key = %s
		",
		'wlticker_base_meta',
		'wlticker_controls_meta',
		'wlticker_colors_meta'
	)
);

$wpdb->query(
	$wpdb->prepare(
		"
		DELETE FROM $wpdb->posts
		WHERE post_type = %s
		",
		'wlticker'
	)
);
?>