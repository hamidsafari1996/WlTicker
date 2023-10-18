<?php
/*
Plugin Name: WlTicker
Plugin URI: #
Description: A plugin for creating news ticker and shortcode usability. 
Version: 1.0
Author: Hamid Safari
Author URI: #
License: A "Slug" license name e.g. GPL2
*/

define('wlticker_version','1.0.0');
define('wlticker_plugin_name','wlticker');

require_once 'class/class-base.php';
global $WLTICKER;
$WLTICKER = new WLTICKER();

if(is_admin()){
	require_once 'inc/post-type.php';
	require_once 'class/class-post-type.php';
}

require_once 'class/class-shortcode.php';
require_once 'class/class-widget.php';
require_once 'inc/functions.php';

function wl_ticker_activation(){
	wl_ticker_register_post_type();
	
	flush_rewrite_rules();
}
register_activation_hook(__FILE__,'wl_ticker_activation');

function wl_ticker_deactivation(){
	flush_rewrite_rules();
}
register_deactivation_hook(__FILE__,'wl_ticker_deactivation');