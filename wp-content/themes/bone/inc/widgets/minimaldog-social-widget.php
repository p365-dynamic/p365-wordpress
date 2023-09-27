<?php
/*
 * Display Social icons
 */
class md_social_widget extends WP_Widget {

	public function __construct()
	{
		$theme_name = wp_get_theme()->name;
		parent::__construct( 'md_social_widget', $theme_name.' - '.esc_html__('Social Widget', 'bone'), array('description' => esc_html__('Display social icons', 'bone'), 'classname' => 'mdSocialWidget') );
	}

	function widget($args, $instance) {
		extract( $args );
		$title = apply_filters('widget_title', $instance['title']);
		echo $before_widget;
		if ($title) echo $before_title . $title . $after_title;
		get_template_part('templates/site-social-inline' );
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field($new_instance['title']);
		return $instance;
	}

	function form($instance) {
		$defaults = array( 'title' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title: ', 'bone'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id('title')); ?>" class="widefat" type="text" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<?php esc_html_e('Display social network icons (set up in Theme Options &rarr; Social)', 'bone'); ?>
		</p>
	<?php
	}
}

add_action('widgets_init', create_function('', 'return register_widget("md_social_widget");'));