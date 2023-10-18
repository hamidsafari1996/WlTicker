<?php
class WLTICKER{
	
	public function __construct(){
		add_action('plugins_loaded',array($this,'wl_load_textdomain'));
		add_action('admin_enqueue_scripts',array($this,'wl_admin_enqueue_scripts'));
		add_action('wp_enqueue_scripts',array($this,'wl_enqueue_scripts'));
	}
	
	public function wl_load_textdomain(){
		load_plugin_textdomain(wlticker_plugin_name,false,'wlticker/languages');
	}
	
	public function wl_admin_enqueue_scripts($hook){
		if($hook != 'post.php' && $hook != 'post-new.php') return;
		wp_enqueue_script('wlticker-repeatable-fields',$this->wl_plugins_url('assets/js/repeatable-fields.js'),array('jquery','jquery-ui-core'),'1.4.8',true);
		wp_enqueue_script('wlticker-wlticker-admin',$this->wl_plugins_url('assets/js/wlticker-admin.js'),array('jquery','wp-color-picker'),wlticker_version,true);
		
		
		wp_enqueue_style('wlticker-font-awesome',$this->wl_plugins_url('assets/css/font-awesome.min.css'),array(),'4.7.0');
		wp_enqueue_style('wlticker-wlticker-admin',$this->wl_plugins_url('assets/css/wlticker-admin.css'),array(),wlticker_version);
		
		wp_enqueue_style( 'wp-color-picker' );
		
	}
	
	public function wl_enqueue_scripts(){
		wp_enqueue_script('wlticker-jquery-easy-ticker',$this->wl_plugins_url('assets/js/jquery.easy-ticker.min.js'),array('jquery'),'2.0',false);
		wp_enqueue_script('wlticker-jquery-easing',$this->wl_plugins_url('assets/js/jquery.easing.min.js'),array('jquery'),'1.3',false);
		wp_enqueue_style('wlticker-wlticker',$this->wl_plugins_url('assets/css/wlticker.css'),array(),wlticker_version);
	}
	
	public function wl_plugins_url($url){
		return plugins_url('wlticker/'.$url);
	}
}