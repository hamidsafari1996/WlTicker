<?php
function wlticker_shortcode_html($atts){
	$shortcode_id = $atts['id'];
	$base_meta = unserialize(get_post_meta($shortcode_id,'wlticker_base_meta',true));
	$controls_meta = unserialize(get_post_meta($shortcode_id,'wlticker_controls_meta',true));
	$colors_meta = unserialize(get_post_meta($shortcode_id,'wlticker_colors_meta',true));
	if(isset($shortcode_id) && get_post($shortcode_id) != null){
	if($base_meta){
?>
	<div class="container-wlticker-shortcode" style="background:<?php echo esc_attr($colors_meta['bg_color']); ?>;border-radius:<?php echo esc_attr($controls_meta['border_radius']); ?>px">
		<div class="entry-wlticker-shortcode" id="wlticker-shortcode-<?php echo esc_attr($shortcode_id); ?>">
			<div class="innerWrap">
			<?php foreach($base_meta as $object){ ?>
				<div class="list" style="border:<?php echo esc_attr($controls_meta['border_width']).'px'; echo ' '.esc_attr($controls_meta['border_style']); echo ' '.esc_attr($colors_meta['border_color']); ?>"><a href="<?php echo esc_url($object[2]); ?>" target="<?php echo esc_attr($object[3]); ?>" style="color:<?php echo esc_attr($colors_meta['content_color']); ?>">
				<?php
					echo ($controls_meta['display_title'] == 'on' )? '<label style="color:'.esc_attr($colors_meta['title_color']).'">'.esc_html($object[0]).': </label>' : '';
					echo esc_html($object[1]);
				?></a></div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php
	}
	if(isset($controls_meta['text_summury'])){
		$text_summury = '"white-space":"nowrap",';
		$text_summury .= '"overflow":"hidden",';
		$text_summury .= '"text-overflow":"ellipsis",';
		$text_summury .= '"display":"block"';
	}
echo '
<script>
jQuery(function($) {
	$("#wlticker-shortcode-'.esc_attr($shortcode_id).'").easyTicker({
		direction: "'.esc_attr($controls_meta['dir']).'",
		easing: "'.esc_attr($controls_meta['effect']).'",
		speed: "'.esc_attr($controls_meta['speed']).'",
		interval: '.esc_attr($controls_meta['duration'])*1000 .',
		height: "auto",
		visible: '.esc_attr($controls_meta['visible']).',
		mousePause: '.esc_attr($controls_meta['pause']).',
	});
	$("#wlticker-shortcode-'.esc_attr($shortcode_id).' .list a").css({'.$text_summury.'})
});
</script>
';
}else{
	_e('Shortcode Not Found!','wlticker');
}
}

function wlticker_widget_html($instance){
	$widget_id = $instance['post_id'];
	$base_meta = unserialize(get_post_meta($widget_id,'wlticker_base_meta',true));
	$controls_meta = unserialize(get_post_meta($widget_id,'wlticker_controls_meta',true));
	$colors_meta = unserialize(get_post_meta($widget_id,'wlticker_colors_meta',true));
	if(isset($widget_id) && get_post($widget_id) != null){
	if($base_meta){
?>
	<div class="container-wlticker-shortcode" style="background:<?php echo esc_attr($colors_meta['bg_color']); ?>;border-radius:<?php echo esc_attr($controls_meta['border_radius']); ?>px">
		<div class="entry-wlticker-shortcode" id="wlticker-widget-<?php echo esc_attr($widget_id); ?>">
			<div class="innerWrap">
			<?php foreach($base_meta as $object){ ?>
				<div class="list" style="border:<?php echo esc_attr($controls_meta['border_width']).'px'; echo ' '.esc_attr($controls_meta['border_style']); echo ' '.esc_attr($colors_meta['border_color']); ?>"><a href="<?php echo esc_url($object[2]); ?>" target="<?php echo esc_attr($object[3]); ?>" style="color:<?php echo esc_attr($colors_meta['content_color']); ?>">
				<?php
					echo ($controls_meta['display_title'] == 'on' )? '<label style="color:'.esc_attr($colors_meta['title_color']).'">'.esc_html($object[0]).': </label>' : '';
					echo esc_html($object[1]);
				?></a></div>
				<?php } ?>
			</div>
		</div>
	</div>
<?php
	}
	if(isset($controls_meta['text_summury'])){
		$text_summury = '"white-space":"nowrap",';
		$text_summury .= '"overflow":"hidden",';
		$text_summury .= '"text-overflow":"ellipsis",';
		$text_summury .= '"display":"block"';
	}
echo '
<script>
jQuery(function($) {
	$("#wlticker-widget-'.esc_attr($widget_id).'").easyTicker({
		direction: "'.esc_attr($controls_meta['dir']).'",
		easing: "'.esc_attr($controls_meta['effect']).'",
		speed: "'.esc_attr($controls_meta['speed']).'",
		interval: '.esc_attr($controls_meta['duration'])*1000 .',
		height: "auto",
		visible: '.esc_attr($controls_meta['visible']).',
		mousePause: '.esc_attr($controls_meta['pause']).',
	});
	$("#wlticker-widget-'.esc_attr($widget_id).' .list a").css({'.$text_summury.'})
});
</script>
';
}else{
	_e('Shortcode Not Found!','wlticker');
}
}
?>