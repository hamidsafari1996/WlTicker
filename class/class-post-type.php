<?php
class WLPOSTTYPE{
	function __construct(){
		add_action('add_meta_boxes',array($this,'wl_ticker_add_meta_boxes'));
		add_action('save_post',array($this,'wl_ticker_save_postmeta'),10,2);
	}
	
	public function wl_ticker_add_meta_boxes(){
		add_meta_box('wl-ticker-shortcode-field',__('Shortcode','wlticker'),array($this,'generate_shortcode_html_metabox'),'wlticker','side','default');
		add_meta_box('wl-ticker-repeat-field',__('Tickers','wlticker'),array($this,'generate_repeat_html_metabox'),'wlticker','normal','default');
		add_meta_box('wl-ticker-controls-field',__('Controls','wlticker'),array($this,'generate_controls_html_metabox'),'wlticker','normal','default');
		add_meta_box('wl-ticker-colors-field',__('Colors','wlticker'),array($this,'generate_colors_html_metabox'),'wlticker','normal','default');
			
	}
	
	public function generate_shortcode_html_metabox(){
		global $post;
		echo "<input type='text' value='[wlticker id=\"$post->ID\"]' onclick='this.focus(); this.select()' readonly class='wlticker-shortcode-input'>";
	}
	
	public function generate_repeat_html_metabox(){
		global $post;
		echo "<input type='hidden' name='wlticker_metabox_noncename' value='".wp_create_nonce(plugin_basename(__FILE__))."'>";
	?>
	<div class="wlticker-repeat" id="wlticker-repeat">
				<table class="wrapper">
				<thead>
					<tr>
						<td><span class="add"><?php esc_html_e('Add', 'wlticker'); ?></span></td>
					</tr>
				</thead>
				<tbody class="container">
				<tr class="template row">
					<td width="10%"><span class="move"><i class="fa fa-arrows"></i></span></td>
					<td width="70%">
						<label for="wlticker-ticker-title"><?php esc_html_e('Title', 'wlticker'); ?></label>
						<input type="text" name="ticker_title[{{row-count-placeholder}}]" id="wlticker-ticker-title" class="wlticker-input">
						<label for="wlticker-ticker-text"><?php esc_html_e('Ticker Text', 'wlticker'); ?></label>
						<textarea name="ticker_text[{{row-count-placeholder}}]" class="wlticker-textarea" id="wlticker-ticker-text"></textarea>
						<label for="wlticker-ticker-url"><?php esc_html_e('URL', 'wlticker'); ?></label>
						<input type="url" name="ticker_url[{{row-count-placeholder}}]" id="wlticker-ticker-url" class="wlticker-input">
						<sub><?php esc_html_e('Example: http://wplizer.com', 'wlticker'); ?></sub>
						<label for="wlticker-ticker-target"><?php esc_html_e('Target', 'wlticker'); ?></label>
						<select name="ticker_target[{{row-count-placeholder}}]" id="wlticker-ticker-target" class="wlticker-select">
							<option value="_self"><?php esc_html_e('Self', 'wlticker'); ?></option>
							<option value="_blank"><?php esc_html_e('Blank', 'wlticker'); ?></option>
						</select>
					</td>

					<td width="10%"><span class="remove"><i class="fa fa-trash-o"></i></span></td>
				</tr>
				<?php
				$base_meta = unserialize(get_post_meta($post->ID,'wlticker_base_meta',true));
				if($base_meta){
					$i = 0;
					foreach($base_meta as $obj){
				?>
						<tr class="row">
							<td width="10%"><span class="move"><i class="fa fa-arrows"></i></span></td>
							<td width="70%">
								<label for="wlticker-ticker-title"><?php esc_html_e('Title', 'wlticker'); ?></label>
								<input type="text" name="ticker_title[<?php echo esc_attr($i); ?>]" id="wlticker-ticker-title" class="wlticker-input" value="<?php echo esc_attr($obj[0]); ?>">
								<label for="wlticker-ticker-text"><?php esc_html_e('Ticker Text', 'wlticker'); ?></label>
								<textarea name="ticker_text[<?php echo esc_attr($i); ?>]" class="wlticker-textarea" id="wlticker-ticker-text"><?php echo esc_html($obj[1]); ?></textarea>
								<label for="wlticker-ticker-url"><?php esc_html_e('URL', 'wlticker'); ?></label>
								<input type="url" name="ticker_url[<?php echo esc_attr($i); ?>]" id="wlticker-ticker-url" class="wlticker-input" value="<?php echo esc_attr($obj[2]); ?>">
								<sub><?php esc_html_e('Example: http://wplizer.com', 'wlticker'); ?></sub>
								<label for="wlticker-ticker-target"><?php esc_html_e('Target', 'wlticker'); ?></label>
								<select name="ticker_target[<?php echo esc_attr($i); ?>]" id="wlticker-ticker-target" class="wlticker-select">
									<option value="_self" <?php selected($obj[3],'_self'); ?> ><?php esc_html_e('Self', 'wlticker'); ?></option>
									<option value="_blank" <?php selected($obj[3],'_blank'); ?>><?php esc_html_e('Blank', 'wlticker'); ?></option>
								</select>
							</td>

							<td width="10%"><span class="remove"><i class="fa fa-trash-o"></i></span></td>
						</tr>
				<?php $i++; } } ?>
				</tbody>
				<tr>
					<td><span class="add add-btm"><?php esc_html_e('Add', 'wlticker'); ?></span></td>
				</tr>
			</table>
		</div>
	<?php
	}
	
	public function generate_controls_html_metabox(){
		global $post;
		$ticker_controls = unserialize(get_post_meta($post->ID,'wlticker_controls_meta',true));
	?>
	<div class="wlticker-controls-html-metabox">
			<p>
				<input type="checkbox" name="ticker_control[display_title]" id="wlticker-controls-display-title" <?php @checked($ticker_controls['display_title'],'on'); ?>>
				<label for="wlticker-controls-display-title"><?php esc_html_e('Display Tickers Title (If Checked, The Title Will be Prepended to The Description)', 'wlticker'); ?></label>
			</p>
			
			<p>
				<input type="checkbox" name="ticker_control[text_summury]" id="wlticker-controls-text-summury" <?php @checked($ticker_controls['text_summury'],'on'); ?>>
				<label for="wlticker-controls-text-summury"><?php esc_html_e('Show Excerpt (If Checked, The Excerpt of The Description we be Shown)', 'wlticker'); ?></label>
			</p>
			
			<p>
				<label class="row" for="wlticker-controls-direction"><?php esc_html_e('Direction', 'wlticker'); ?></label>
				<select name="ticker_control[dir]" id="wlticker-controls-direction">
					<option value="up" <?php selected($ticker_controls['dir'],'up'); ?>><?php esc_html_e('Up', 'wlticker'); ?></option>
					<option value="down" <?php selected($ticker_controls['dir'],'down'); ?>><?php esc_html_e('Down', 'wlticker'); ?></option>
				</select>
			</p>
			
			<p>
				<label class="row" for="wlticker-controls-speed"><?php esc_html_e('Movement Speed', 'wlticker'); ?></label>
				<select name="ticker_control[speed]" id="wlticker-controls-speed">
					<option value="slow" <?php selected($ticker_controls['speed'],'slow'); ?>><?php esc_html_e('Slow', 'wlticker'); ?></option>
					<option value="fast" <?php selected($ticker_controls['speed'],'fast'); ?>><?php esc_html_e('Fast', 'wlticker'); ?></option>
				</select>
			</p>
			
			<p>
				<label class="row" for="wlticker-controls-duration"><?php esc_html_e('Delay Between Tickers (seconds)', 'wlticker'); ?></label>
				<input type="number" name="ticker_control[duration]" id="wlticker-controls-duration" value="<?php echo ($ticker_controls['duration'] != '')? esc_attr($ticker_controls['duration']) : '2'; ?>">
			</p>
			
			<p>
				<label class="row" for="wlticker-controls-visible"><?php esc_html_e('Count (Number of Tickers to Show at The Same Time)', 'wlticker'); ?></label>
				<input type="number" name="ticker_control[visible]" id="wlticker-controls-visible" value="<?php echo ($ticker_controls['visible'] != '')? esc_attr($ticker_controls['visible']) : '1'; ?>">
			</p>
			
			<p>
				<label class="row" for="wlticker-controls-effect"><?php esc_html_e('Easing Effect', 'wlticker'); ?></label>
				<select name="ticker_control[effect]" id="wlticker-controls-effect">
					<option value="linear" <?php selected($ticker_controls['effect'],'linear'); ?>><?php esc_html_e('linear', 'wlticker'); ?></option>
					<option value="swing" <?php selected($ticker_controls['effect'],'swing'); ?>><?php esc_html_e('swing', 'wlticker'); ?></option>
					<option value="easeInQuad" <?php selected($ticker_controls['effect'],'easeInQuad'); ?>><?php esc_html_e('easeInQuad', 'wlticker'); ?></option>
					<option value="easeOutQuad" <?php selected($ticker_controls['effect'],'easeOutQuad'); ?>><?php esc_html_e('easeOutQuad', 'wlticker'); ?></option>
					<option value="easeInOutQuad" <?php selected($ticker_controls['effect'],'easeInOutQuad'); ?>><?php esc_html_e('easeInOutQuad', 'wlticker'); ?></option>
					<option value="easeInCubic" <?php selected($ticker_controls['effect'],'easeInCubic'); ?>><?php esc_html_e('easeInCubic', 'wlticker'); ?></option>
					<option value="easeOutCubic" <?php selected($ticker_controls['effect'],'easeOutCubic'); ?>><?php esc_html_e('easeOutCubic', 'wlticker'); ?></option>
					<option value="easeInOutCubic" <?php selected($ticker_controls['effect'],'easeInOutCubic'); ?>><?php esc_html_e('easeInOutCubic', 'wlticker'); ?></option>
					<option value="easeInQuart" <?php selected($ticker_controls['effect'],'easeInQuart'); ?>><?php esc_html_e('easeInQuart', 'wlticker'); ?></option>
					<option value="easeOutQuart" <?php selected($ticker_controls['effect'],'easeOutQuart'); ?>><?php esc_html_e('easeOutQuart', 'wlticker'); ?></option>
					<option value="easeInOutQuart" <?php selected($ticker_controls['effect'],'easeInOutQuart'); ?>><?php esc_html_e('easeInOutQuart', 'wlticker'); ?></option>
					<option value="easeInQuint" <?php selected($ticker_controls['effect'],'easeInQuint'); ?>><?php esc_html_e('easeInQuint', 'wlticker'); ?></option>
					<option value="easeOutQuint" <?php selected($ticker_controls['effect'],'easeOutQuint'); ?>><?php esc_html_e('easeOutQuint', 'wlticker'); ?></option>
					<option value="easeInOutQuint" <?php selected($ticker_controls['effect'],'easeInOutQuint'); ?>><?php esc_html_e('easeInOutQuint', 'wlticker'); ?></option>
					<option value="easeInExpo" <?php selected($ticker_controls['effect'],'easeInExpo'); ?>><?php esc_html_e('easeInExpo', 'wlticker'); ?></option>
					<option value="easeOutExpo" <?php selected($ticker_controls['effect'],'easeOutExpo'); ?>><?php esc_html_e('easeOutExpo', 'wlticker'); ?></option>
					<option value="easeInOutExpo" <?php selected($ticker_controls['effect'],'easeInOutExpo'); ?>><?php esc_html_e('easeInOutExpo', 'wlticker'); ?></option>
					<option value="easeInSine" <?php selected($ticker_controls['effect'],'easeInSine'); ?>><?php esc_html_e('easeInSine', 'wlticker'); ?></option>
					<option value="easeOutSine" <?php selected($ticker_controls['effect'],'easeOutSine'); ?>><?php esc_html_e('easeOutSine', 'wlticker'); ?></option>
					<option value="easeInOutSine" <?php selected($ticker_controls['effect'],'easeInOutSine'); ?>><?php esc_html_e('easeInOutSine', 'wlticker'); ?></option>
					<option value="easeInCirc" <?php selected($ticker_controls['effect'],'easeInCirc'); ?>><?php esc_html_e('easeInCirc', 'wlticker'); ?></option>
					<option value="easeOutCirc" <?php selected($ticker_controls['effect'],'easeOutCirc'); ?>><?php esc_html_e('easeOutCirc', 'wlticker'); ?></option>
					<option value="easeInOutCirc" <?php selected($ticker_controls['effect'],'easeInOutCirc'); ?>><?php esc_html_e('easeInOutCirc', 'wlticker'); ?></option>
					<option value="easeInElastic" <?php selected($ticker_controls['effect'],'easeInElastic'); ?>><?php esc_html_e('easeInElastic', 'wlticker'); ?></option>
					<option value="easeOutElastic" <?php selected($ticker_controls['effect'],'easeOutElastic'); ?>><?php esc_html_e('easeOutElastic', 'wlticker'); ?></option>
					<option value="easeInOutElastic" <?php selected($ticker_controls['effect'],'easeInOutElastic'); ?>><?php esc_html_e('easeInOutElastic', 'wlticker'); ?></option>
					<option value="easeInBack" <?php selected($ticker_controls['effect'],'easeInBack'); ?>><?php esc_html_e('easeInBack', 'wlticker'); ?></option>
					<option value="easeOutBack" <?php selected($ticker_controls['effect'],'easeOutBack'); ?>><?php esc_html_e('easeOutBack', 'wlticker'); ?></option>
					<option value="easeInOutBack" <?php selected($ticker_controls['effect'],'easeInOutBack'); ?>><?php esc_html_e('easeInOutBack', 'wlticker'); ?></option>
					<option value="easeInBounce" <?php selected($ticker_controls['effect'],'easeInBounce'); ?>><?php esc_html_e('easeInBounce', 'wlticker'); ?></option>
					<option value="easeInOutBounce" <?php selected($ticker_controls['effect'],'easeInOutBounce'); ?>><?php esc_html_e('easeInOutBounce', 'wlticker'); ?></option>
				</select>
			</p>
			
			<p>
				<label class="row" for="wlticker-controls-border-radius"><?php esc_html_e('Border Radius (px)', 'wlticker'); ?></label>
				<input type="number" name="ticker_control[border_radius]" id="wlticker-controls-border-radius" value="<?php echo ($ticker_controls['border_radius'] != '')? esc_attr($ticker_controls['border_radius']) : '2'; ?>">
			</p>
			
			<p>
				<label class="row" for="wlticker-controls-border-width"><?php esc_html_e('Border Width (px)', 'wlticker'); ?></label>
				<input type="number" name="ticker_control[border_width]" id="wlticker-controls-border-width" value="<?php echo ($ticker_controls['border_width'] != '')? esc_attr($ticker_controls['border_width']) : '1'; ?>">
			</p>
			
			<p>
				<label class="row" for="wlticker-controls-border-style"><?php esc_html_e('Border Style', 'wlticker'); ?></label>
				<select name="ticker_control[border_style]" id="wlticker-controls-border-style">
					<option value="solid" <?php selected($ticker_controls['border_style'],'solid'); ?>><?php esc_html_e('Solid', 'wlticker'); ?></option>
					<option value="dotted" <?php selected($ticker_controls['border_style'],'dotted'); ?>><?php esc_html_e('Dotted', 'wlticker'); ?></option>
					<option value="dashed" <?php selected($ticker_controls['border_style'],'dashed'); ?>><?php esc_html_e('Dashed', 'wlticker'); ?></option>
					<option value="double" <?php selected($ticker_controls['border_style'],'double'); ?>><?php esc_html_e('Double', 'wlticker'); ?></option>
				</select>
			</p>
			
			<p>
				<label class="row" for="wlticker-controls-pause"><?php esc_html_e('Pause on Mouse Over', 'wlticker'); ?></label>
				<select name="ticker_control[pause]" id="wlticker-controls-pause">
					<option value="1" <?php selected($ticker_controls['pause'],'1'); ?>><?php esc_html_e('Yes', 'wlticker'); ?></option>
					<option value="0" <?php selected($ticker_controls['pause'],'0'); ?>><?php esc_html_e('No', 'wlticker'); ?></option>
				</select>
			</p>
			
			
		</div>
	<?php
	}
	
	public function generate_colors_html_metabox(){
		
		global $post;
		$ticker_colors = unserialize(get_post_meta($post->ID,'wlticker_colors_meta',true));
	?>
	<div class="wlticker-colors-html-metabox">
		<p>
			<label class="row" for="wlticker-bgcolor"><?php esc_html_e('Background Color', 'wlticker'); ?></label>
			<input name="ticker_colors[bg_color]" type="text" value="<?php echo (@$ticker_colors['bg_color'])? esc_attr($ticker_colors['bg_color']) : '#fff' ; ?>" class="wlticker-colorpicker" data-default-color="#fff" id="wlticker-bgcolor">
		</p>
		<p>
			<label class="row" for="wlticker-title-color"><?php esc_html_e('Title Color', 'wlticker'); ?></label>
			<input name="ticker_colors[title_color]" type="text" value="<?php echo (@$ticker_colors['title_color'])? esc_attr($ticker_colors['title_color']) : '#111' ; ?>" class="wlticker-colorpicker" data-default-color="#111" id="wlticker-title-color">
		</p>
		<p>
			<label class="row" for="wlticker-content-color"><?php esc_html_e('Content Color', 'wlticker'); ?></label>
			<input name="ticker_colors[content_color]" type="text" value="<?php echo (@$ticker_colors['content_color'])? esc_attr($ticker_colors['content_color']) : '#333' ; ?>" class="wlticker-colorpicker" data-default-color="#333" id="wlticker-content-color">
		</p>
		<p>
			<label class="row" for="wlticker-border-color"><?php esc_html_e('Border Color', 'wlticker'); ?></label>
			<input name="ticker_colors[border_color]" type="text" value="<?php echo (@$ticker_colors['border_color'])? esc_attr($ticker_colors['border_color']) : '#f2f2f2' ; ?>" class="wlticker-colorpicker" data-default-color="#f2f2f2" id="wlticker-border-color">
		</p>
	</div>
	<?php
	}
	
	public function wl_ticker_save_postmeta($post_id,$post){
		if(!wp_verify_nonce($_POST['wlticker_metabox_noncename'],plugin_basename(__FILE__)))
			return $post->ID;
		
		if(!current_user_can('edit_post',$post->ID))
			return $post->ID;
		
		$i = 0;
		foreach($_POST['ticker_title'] as $val){
			$wlticker_save_meta[$i][] = sanitize_text_field($val);
			$i++;
		}
		
		$i = 0;
		foreach($_POST['ticker_text'] as $val){
			$wlticker_save_meta[$i][] = sanitize_text_field($val);
			$i++;
		}
		
		$i = 0;
		foreach($_POST['ticker_url'] as $val){
			$wlticker_save_meta[$i][] = sanitize_text_field($val);
			$i++;
		}
		
		$i = 0;
		foreach($_POST['ticker_target'] as $val){
			$wlticker_save_meta[$i][] = sanitize_text_field($val); 
			$i++;
		}
		
		if(get_post_meta($post->ID,'wlticker_base_meta',FALSE)){
			update_post_meta($post->ID,'wlticker_base_meta',serialize($wlticker_save_meta));
		}else{
			add_post_meta($post->ID,'wlticker_base_meta',serialize($wlticker_save_meta));
		}
		if(!$wlticker_save_meta) delete_post_meta($post->ID,'wlticker_base_meta');
		
		
		$wlticker_control_meta = sanitize_text_field(serialize($_POST['ticker_control']));
		if(get_post_meta($post->ID,'wlticker_controls_meta',FALSE)){
			update_post_meta($post->ID,'wlticker_controls_meta',$wlticker_control_meta);
		}else{
			add_post_meta($post->ID,'wlticker_controls_meta',$wlticker_control_meta);
		}
		if(!$wlticker_control_meta) delete_post_meta($post->ID,'wlticker_controls_meta');
		
		
		$wlticker_colors_meta = sanitize_text_field(serialize($_POST['ticker_colors']));
		if(get_post_meta($post->ID,'wlticker_colors_meta',FALSE)){
			update_post_meta($post->ID,'wlticker_colors_meta',$wlticker_colors_meta);
		}else{
			add_post_meta($post->ID,'wlticker_colors_meta',$wlticker_colors_meta);
		}
		if(!$wlticker_colors_meta) delete_post_meta($post->ID,'wlticker_colors_meta');
		
		
	}
}
$WLPOSTTYPE = new WLPOSTTYPE();