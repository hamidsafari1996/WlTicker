<?php
class WLTICKERSHORTCODE{
	public function __construct(){
		add_shortcode('wlticker',array($this,'wlticker_create_shortcode'));
	}
	
	public function wlticker_create_shortcode($atts){
		wlticker_shortcode_html($atts);
	}
}
$WLTICKERSHORTCODE = new WLTICKERSHORTCODE();
?>