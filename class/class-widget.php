<?php
class WltickerWidget extends WP_Widget {

	function __construct() {
		// Instantiate the parent object
		parent::__construct(
		'wlticker_widget',
		__('Ticker', 'wlticker'),
		array('description' => __('ticker', 'wlticker'))
		);
	}
	
	function widget( $args, $instance ) {
		$instance['title'] = ($instance['display_title'] == 'on') ? $instance['title'] : '';
		echo $args['before_widget'];
		echo $args['before_title'].$instance['title'].$args['after_title'];
		wlticker_widget_html($instance);
		echo $args['after_widget'];
	}

	function form( $instance ) {
		$objects = array(
			'title'         => (isset($instance['title']))? $instance['title']: '',
			'post_id'       => (isset($instance['post_id']))? $instance['post_id']: '',
			'display_title' => (isset($instance['display_title']))? $instance['display_title']: '',
		);
	?>
	<p>
	<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:','wlticker') ?></label>
	<input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($objects['title']); ?>">
	</p>
	
	<?php
		$query = new WP_Query(array('post_type' => 'wlticker'));
		if($query->have_posts()):
	?>
	<p>
	<label for="<?php echo esc_attr($this->get_field_id('post_id')); ?>"><?php esc_html_e('Select a Ticker:','wlticker') ?></label>
	<select name="<?php echo esc_attr($this->get_field_name('post_id')); ?>" id="<?php echo esc_attr($this->get_field_id('post_id')); ?>">
	<?php
		while($query->have_posts()):
		$query->the_post();
		global $post;
		?>
		<option value="<?php echo esc_attr($post->ID); ?>" <?php selected($post->ID,$objects['post_id']) ?> ><?php echo esc_html($post->post_title) ?></option>
		<?php endwhile; ?>
	</select>
	</p>
	
	<p>
	<input type="checkbox" class="widefat" id="<?php echo esc_attr($this->get_field_id('display_title')); ?>" name="<?php echo esc_attr($this->get_field_name('display_title')); ?>" <?php checked($objects['display_title'],'on') ?> >
	<label for="<?php echo esc_attr($this->get_field_id('display_title')); ?>"><?php esc_html_e('Display Widget Title','wlticker') ?></label>
	</p>
	
	
	<?php
		else:
		esc_html_e('There is not any Ticker to Select','wlticker');
		endif;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = array(
			'title' => (!empty($new_instance['title']))? sanitize_text_field($new_instance['title']) : '',
			'post_id' => (!empty($new_instance['post_id']))? sanitize_text_field($new_instance['post_id']) : '',
			'display_title' => (!empty($new_instance['display_title']))? sanitize_text_field($new_instance['display_title']) : '',
		);
		return $instance;
	}
}

function WlTicker_register_widget() {
	register_widget( 'WlTickerWidget' );
}

add_action( 'widgets_init', 'WlTicker_register_widget' );
?>