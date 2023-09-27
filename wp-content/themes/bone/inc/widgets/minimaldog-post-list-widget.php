<?php
/*
 * Display the Posts List
 */
class md_posts_list_widget extends WP_Widget {

	public function __construct()
	{
		$theme_name = wp_get_theme()->name;
		parent::__construct( 'md_posts_list_widget', $theme_name.' - '.esc_html__('Post List Widget', 'bone'), array('description' => esc_html__('Display the posts list in your sidebar or footer', 'bone'), 'classname' => 'mdPostsListWidget') );
	}

	function widget($args, $instance) {
		extract( $args );

		$title 		= apply_filters('widget_title', $instance['title']);
		$cats_id 	= $instance['cats_id'];
		$orderby 	= $instance['orderby'];
		$style 		= $instance['style'];
		$number 	= $instance['number'];


		// The Query
		$args = array(
			'posts_per_page' 	=> $number,
			'cat' 		 	=> $cats_id,
			'orderby'		 	=> $orderby,
			'status' 		 	=> 'publish',
			'ignore_sticky_posts'=> true
		);

		$classes = '';
		$classes .= $style.'Style';
		if (($style == 'list') || ($style == 'list--thumb') || ($style == 'card-w-list')) {
			$classes .= ' list--micro--withSeparator';
		}
		
		$query_posts = new WP_Query( $args );

		echo $before_widget;

		if ($title) echo $before_title . $title . $after_title;

		if ($query_posts->have_posts()): ?>
			<ul class="list--micro <?php echo esc_attr($classes); ?>">
				<?php
				switch ($style) {
					case 'card':
						while ($query_posts->have_posts()): $query_posts->the_post(); 
						?>
						<li>
							<?php get_template_part( 'templates/post-card-paper-micro' ); ?>
						</li>
						<?php
						endwhile;
						break;
					
					case 'tile':
						while ($query_posts->have_posts()): $query_posts->the_post(); 
						?>
						<li>
							<?php get_template_part( 'templates/post-tile-micro' ); ?>
						</li>
						<?php
						endwhile;
						break;

					case 'list--thumb':
						while ($query_posts->have_posts()): $query_posts->the_post(); 
						?>
						<li>
							<?php get_template_part( 'templates/post-list-paper-micro' ); ?>
						</li>
						<?php
						endwhile;
						break;

					case 'card-w-list':
						while ($query_posts->have_posts()): $query_posts->the_post(); 
						?>
						<li>
							<?php if ($query_posts->current_post == 0) {
								get_template_part( 'templates/post-card' );
								} else {
								get_template_part( 'templates/post-micro-simple' );
								}	?>
						</li>
						<?php
						endwhile;
						break;

					default:
						while ($query_posts->have_posts()): $query_posts->the_post(); 
						?>
						<li>
							<?php get_template_part( 'templates/post-micro-simple' ); ?>
						</li>
						<?php
						endwhile;
						break;
				}?>
				
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
		$instance['style'] = strip_tags($new_instance['style']);
		$instance['number'] = ($new_instance['number']);
		return $instance;
	}

	function form($instance) {
		$defaults = array( 'title' => esc_html__('Recent Posts' , 'bone') , 'cats_id' => '0' , 'orderby' => 'date', 'style' => 'list--thumb', 'number' => 4 );
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
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id( 'style' )); ?>"><?php esc_html_e('List style: ', 'bone'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id( 'style' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'style' )); ?>" >
				<option value="card" <?php if( $instance['style'] == 'card' ) echo "selected=\"selected\""; ?>><?php esc_html_e('Card', 'bone'); ?></option>
				<option value="card-w-list" <?php if( $instance['style'] == 'card-w-list' ) echo "selected=\"selected\""; ?>><?php esc_html_e('Card with list', 'bone'); ?></option>
				<option value="tile" <?php if( $instance['style'] == 'tile' ) echo "selected=\"selected\""; ?>><?php esc_html_e('Tile', 'bone'); ?></option>
				<option value="list--thumb" <?php if( $instance['style'] == 'list--thumb' ) echo "selected=\"selected\""; ?>><?php esc_html_e('List with thumb', 'bone'); ?></option>
				<option value="list" <?php if( $instance['style'] == 'list' ) echo "selected=\"selected\""; ?>><?php esc_html_e('List', 'bone'); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo esc_attr($this->get_field_id('number')); ?>"><?php esc_html_e('Number of posts:', 'bone'); ?></label>
			<input id="<?php echo esc_attr($this->get_field_id('number')); ?>" type="number" name="<?php echo esc_attr($this->get_field_name('number')); ?>" value="<?php echo esc_attr($instance['number']); ?>" />
		</p>
	<?php
	}
}

add_action('widgets_init', create_function('', 'return register_widget("md_posts_list_widget");'));