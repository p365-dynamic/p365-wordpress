<?php
/*
 * Display the Posts Slider
 */
class md_posts_slider_widget extends WP_Widget {

	public function __construct()
	{
		$theme_name = wp_get_theme()->name;
		parent::__construct( 'md_posts_slider_widget', $theme_name.' - '.esc_html__('Post Slider Widget', 'bone'), array('description' => esc_html__('Display the posts slider in your sidebar or footer', 'bone'), 'classname' => 'mdSliderWidget') );
	}

	function widget($args, $instance) {
		extract( $args );

		$title 		= apply_filters('widget_title', $instance['title']);
		$cats_id 	= $instance['cats_id'];
		$orderby 	= $instance['orderby'];
		$number 	= $instance['number'];

		// Handle the configs
		if ($orderby == 'meta_value_num') {
			$meta_key = '_post_like_count';
			// The Query
			$args = array(
				'posts_per_page' 	=> $number,
				'cat' 		 	=> $cats_id,
				'orderby'		 	=> $orderby,
				'meta_key'			=> $meta_key,
				'status' 		 	=> 'publish',
				'ignore_sticky_posts'=> true
			);
		} else {
			// The Query
			$args = array(
				'posts_per_page' 	=> $number,
				'cat' 		 	=> $cats_id,
				'orderby'		 	=> $orderby,
				'status' 		 	=> 'publish',
				'ignore_sticky_posts'=> true
			);
		}
		
		$query_posts = new WP_Query( $args );

		echo $before_widget;

		if ($title) echo $before_title . $title . $after_title;

		if ($query_posts->have_posts()): ?>
			<div class="mdSlider<?php if ( $query_posts->post_count > 1 ) { echo ' owl-carousel js-slider-widget'; }?>">
			<?php 
				while ($query_posts->have_posts()): $query_posts->the_post(); 
					get_template_part( 'templates/post-tile-center' );
				endwhile; ?>
			</div>
		<?php endif;
		echo $after_widget;

		// Reset Post Data
		wp_reset_postdata();
	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['cats_id'] = implode(',' , $new_instance['cats_id']  );
		$instance['orderby'] = strip_tags($new_instance['orderby']);
		$instance['number'] = ($new_instance['number']);
		return $instance;
	}

	function form($instance) {
		$defaults = array( 'title' => esc_html__('Recent Posts' , 'bone') , 'cats_id' => '0' , 'orderby' => 'date', 'number' => 4 );
		$instance = wp_parse_args( (array) $instance, $defaults );
		$categories_obj = get_categories();
		$categories = array();

		foreach ($categories_obj as $pn_cat) {
			$categories[$pn_cat->cat_ID] = $pn_cat->cat_name;
		} ?>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title: ', 'bone'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id('title')); ?>" class="widefat" type="text" name="<?php echo esc_attr($this->get_field_name('title')); ?>" value="<?php echo esc_attr($instance['title']); ?>" />
		</p>
		<p>
			<?php $cats_id = explode ( ',' , $instance['cats_id'] ) ; ?>
			<label for="<?php echo esc_attr($this->get_field_id( 'cats_id' )); ?>"><?php esc_html_e('Category: ', 'bone'); ?></label>
			<select multiple="multiple" id="<?php echo esc_attr($this->get_field_id( 'cats_id' )); ?>[]" name="<?php echo esc_attr($this->get_field_name( 'cats_id' )); ?>[]">
				<?php foreach ($categories as $key => $option) { ?>
				<option value="<?php echo esc_attr($key); ?>" <?php if ( in_array( $key , $cats_id ) ) { echo ' selected="selected"' ; } ?>><?php echo esc_html($option); ?></option>
				<?php } ?>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'orderby' )); ?>"><?php esc_html_e('Posts order: ', 'bone'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id( 'orderby' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'orderby' )); ?>" >
				<option value="date" <?php if( $instance['orderby'] == 'date' ) echo "selected=\"selected\""; ?>><?php esc_html_e('Latest', 'bone'); ?></option>
				<option value="rand" <?php if( $instance['orderby'] == 'rand' ) echo "selected=\"selected\""; ?>><?php esc_html_e('Random', 'bone'); ?></option>
				<option value="comment_count" <?php if( $instance['orderby'] == 'comment_count' ) echo "selected=\"selected\""; ?>><?php esc_html_e('Comments', 'bone'); ?></option>
				<option value="meta_value_num" <?php if( $instance['orderby'] == 'meta_value_num' ) echo "selected=\"selected\""; ?>><?php esc_html_e('Likes', 'bone'); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number of posts:', 'bone'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id('number')); ?>" type="number" name="<?php echo esc_attr($this->get_field_name('number')); ?>" value="<?php echo esc_attr($instance['number']); ?>" />
		</p>
	<?php
	}
}

add_action('widgets_init', create_function('', 'return register_widget("md_posts_slider_widget");'));