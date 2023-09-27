<?php
/*
 * Display the Popular posts list
 */
class md_popular_widget extends WP_Widget {

	public function __construct()
	{
		$theme_name = wp_get_theme()->name;
		parent::__construct( 'md_popular_widget', $theme_name.' - '.esc_html__('Popular Posts Widget', 'bone'), array('description' => esc_html__('Display the posts list in your sidebar or footer', 'bone'), 'classname' => 'mdPopularWidget') );
	}

	function widget($args, $instance) {
		extract( $args );

		$title 		= apply_filters('widget_title', $instance['title']);
		$cats_id 	= $instance['cats_id'];
		$orderby 	= $instance['orderby'];
		$time_range = $instance['time_range'];
		$number 	= $instance['number'];

		switch ($time_range) {
			case 'week':
				$date_query = array(
								array(
									'column' => 'post_date_gmt',
									'after' => '1 week ago',
								),
							);
				break;

			case 'month':
				$date_query = array(
								array(
									'column' => 'post_date_gmt',
									'after' => '1 month ago',
								),
							);
				break;

			case 'year':
				$date_query = array(
								array(
									'column' => 'post_date_gmt',
									'after' => '1 year ago',
								),
							);
				break;
			
			default:
				$date_query = '';
				break;
		}

		// Handle the configs
		if ($orderby == 'meta_value_num') {
			$meta_key = 'minimaldog_post_like_count';

			if ($date_query) {
				$args = array(
					'posts_per_page' 	=> $number,
					'cat' 		 		=> $cats_id,
					'date_query'		=> $date_query,
					'orderby'		 	=> $orderby,
					'meta_key'			=> $meta_key,
					'status' 		 	=> 'publish',
					'ignore_sticky_posts'=> true,
					'md_bone_duplicate_disable' => true,
				);
			} else {
				$args = array(
					'posts_per_page' 	=> $number,
					'cat' 		 		=> $cats_id,
					'orderby'		 	=> $orderby,
					'meta_key'			=> $meta_key,
					'status' 		 	=> 'publish',
					'ignore_sticky_posts'=> true,
					'md_bone_duplicate_disable' => true,
				);
			}
			
		} else {
			if ($date_query) {
				$args = array(
					'posts_per_page' 	=> $number,
					'cat' 		 		=> $cats_id,
					'date_query'		=> $date_query,
					'orderby'		 	=> $orderby,
					'status' 		 	=> 'publish',
					'ignore_sticky_posts'=> true,
					'md_bone_duplicate_disable' => true,
				);
			} else {
				$args = array(
					'posts_per_page' 	=> $number,
					'cat' 		 		=> $cats_id,
					'orderby'		 	=> $orderby,
					'status' 		 	=> 'publish',
					'ignore_sticky_posts'=> true,
					'md_bone_duplicate_disable' => true,
				);
			}
		}

		$query_posts = new WP_Query( $args );

		echo $before_widget;

		if ($title) echo $before_title . $title . $after_title;

		if ($query_posts->have_posts()): ?>
			<ul class="u-noStyleList">
				<?php
				$nth = 1;
				
				while ($query_posts->have_posts()): $query_posts->the_post(); 
				?>
				<li>
					<?php require( locate_template( 'templates/post-list-bg.php' ) ); ?>
				</li>
				<?php $nth++; ?>
				<?php
				endwhile;
				?>
				
			</ul>
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
		$instance['time_range'] = strip_tags($new_instance['time_range']);
		$instance['number'] = ($new_instance['number']);
		return $instance;
	}

	function form($instance) {
		$defaults = array( 'title' => esc_html__('Popular Posts' , 'bone') , 'cats_id' => '0' , 'orderby' => 'meta_value_num', 'time_range' => 'list--thumb', 'number' => 4 );
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
			<label for="<?php echo esc_attr($this->get_field_id( 'orderby' )); ?>"><?php esc_html_e('Order by: ', 'bone'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id( 'orderby' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'orderby' )); ?>" >
				<option value="comment_count" <?php if( $instance['orderby'] == 'comment_count' ) echo "selected=\"selected\""; ?>><?php esc_html_e('Comments', 'bone'); ?></option>
				<option value="meta_value_num" <?php if( $instance['orderby'] == 'meta_value_num' ) echo "selected=\"selected\""; ?>><?php esc_html_e('Likes', 'bone'); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'time_range' )); ?>"><?php esc_html_e('Time range: ', 'bone'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id( 'time_range' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'time_range' )); ?>" >
				<option value="all-time" <?php if( $instance['time_range'] == 'all-time' ) echo "selected=\"selected\""; ?>><?php esc_html_e('All time', 'bone'); ?></option>
				<option value="year" <?php if( $instance['time_range'] == 'year' ) echo "selected=\"selected\""; ?>><?php esc_html_e('Year', 'bone'); ?></option>
				<option value="month" <?php if( $instance['time_range'] == 'month' ) echo "selected=\"selected\""; ?>><?php esc_html_e('Month', 'bone'); ?></option>
				<option value="week" <?php if( $instance['time_range'] == 'week' ) echo "selected=\"selected\""; ?>><?php esc_html_e('Week', 'bone'); ?></option>
				
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number of posts:', 'bone'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id('number')); ?>" type="number" name="<?php echo esc_attr($this->get_field_name('number')); ?>" value="<?php echo esc_attr($instance['number']); ?>" />
		</p>
	<?php
	}
}

add_action('widgets_init', create_function('', 'return register_widget("md_popular_widget");'));