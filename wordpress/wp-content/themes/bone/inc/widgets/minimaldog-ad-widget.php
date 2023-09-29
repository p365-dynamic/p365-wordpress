<?php
/*
 * Display Ad banner
 */
class md_ad_widget extends WP_Widget {

	public function __construct()
	{
		$theme_name = wp_get_theme()->name;
		parent::__construct( 'md_ad_widget', $theme_name.' - '.esc_html__('Ad Widget', 'bone'), array('description' => esc_html__('Display Ad base on screen size', 'bone'), 'classname' => 'mdAdWidget') );
	}

	function widget($args, $instance) {
		extract( $args );

		$title 		= apply_filters('widget_title', $instance['title']);
		$ad_code_xs	= $instance['ad_code_xs'];
		$ad_code_sm	= $instance['ad_code_sm'];
		$ad_code_md	= $instance['ad_code_md'];
		$ad_code_lg	= $instance['ad_code_lg'];

		echo $before_widget;

		if ($title) echo $before_title . $title . $after_title;
		?>
		<div class="mdAdWidget-content">
			<div class="adCode--xs">
				<?php echo html_entity_decode($ad_code_xs); ?>
			</div>
			<div class="adCode--sm">
				<?php echo html_entity_decode($ad_code_sm); ?>
			</div>
			<div class="adCode--md">
				<?php echo html_entity_decode($ad_code_md); ?>
			</div>
			<div class="adCode--lg">
				<?php echo html_entity_decode($ad_code_lg); ?>
			</div>
		</div>
		<?php
		echo $after_widget;
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = sanitize_text_field($new_instance['title']);
		$instance['ad_code_xs'] = htmlentities($new_instance['ad_code_xs'] );
		$instance['ad_code_sm'] = htmlentities($new_instance['ad_code_sm'] );
		$instance['ad_code_md'] = htmlentities($new_instance['ad_code_md'] );
		$instance['ad_code_lg'] = htmlentities($new_instance['ad_code_lg'] );
		return $instance;
	}

	function form($instance) {
		$defaults = array( 'title' => '', 'ad_code_xs' => '' , 'ad_code_sm' => '', 'ad_code_md' => '', 'ad_code_lg' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults );
		?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title: ', 'bone'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id('title')); ?>" class="widefat" type="text" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('ad_code_xs')); ?>"><?php esc_html_e('Ad code for screen width less than 500px:', 'bone'); ?></label>
			<textarea class="widefat" rows="10" id="<?php echo esc_attr($this->get_field_id('ad_code_xs')); ?>" name="<?php echo esc_attr($this->get_field_name('ad_code_xs')); ?>"><?php echo esc_html($instance['ad_code_xs']); ?></textarea>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('ad_code_sm')); ?>"><?php esc_html_e('Ad code for screen width from 501px ~ 800px:', 'bone'); ?></label>
			<textarea class="widefat" rows="10" id="<?php echo esc_attr($this->get_field_id('ad_code_sm')); ?>" name="<?php echo esc_attr($this->get_field_name('ad_code_sm')); ?>"><?php echo esc_html($instance['ad_code_sm']); ?></textarea>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('ad_code_md')); ?>"><?php esc_html_e('Ad code for screen width from 801px ~ 980px:', 'bone'); ?></label>
			<textarea class="widefat" rows="10" id="<?php echo esc_attr($this->get_field_id('ad_code_md')); ?>" name="<?php echo esc_attr($this->get_field_name('ad_code_md')); ?>"><?php echo esc_html($instance['ad_code_md']); ?></textarea>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('ad_code_lg')); ?>"><?php esc_html_e('Ad code for screen width greater than 980px:', 'bone'); ?></label>
			<textarea class="widefat" rows="10" id="<?php echo esc_attr($this->get_field_id('ad_code_lg')); ?>" name="<?php echo esc_attr($this->get_field_name('ad_code_lg')); ?>"><?php echo esc_html($instance['ad_code_lg']); ?></textarea>
		</p>
	<?php
	}
}

add_action('widgets_init', create_function('', 'return register_widget("md_ad_widget");'));