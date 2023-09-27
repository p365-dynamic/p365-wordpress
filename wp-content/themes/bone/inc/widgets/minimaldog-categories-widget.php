<?php
/*
 * Display the Categories
 */
class md_categories_widget extends WP_Widget {

	public function __construct()
	{
		$theme_name = wp_get_theme()->name;
		parent::__construct( 'md_categories_widget', $theme_name.' - '.esc_html__('Categories Widget', 'bone'), array('description' => esc_html__('Display categories', 'bone'), 'classname' => 'mdCategoriesWidget') );
	}

	function widget($args, $instance) {
		extract( $args );

		$title 		= apply_filters('widget_title', $instance['title']);
		$cats_id 	= $instance['cats_id'];
		$orderby 	= $instance['orderby'];
		$order = ($orderby == 'count')? 'DESC': 'ASC';

		// The Query
		$args = array(
			'orderby'		 	=> $orderby,
			'order'		 		=> $order,
			'include'			=> $cats_id,
		);
		
		$categories = get_categories( $args );

		echo $before_widget;

		if ($title) echo $before_title . $title . $after_title;

		if ( $categories ) {
			?><ul><?php
			foreach ( $categories as $cat_id => $category ) {
				$category__post = get_posts( 'category='.$category->term_id.'&posts_per_page=1&orderby=post_date&post_status=publish&md_bone_duplicate_disable=1' );
				if ( has_post_thumbnail( $category__post[0]->ID ) ) {
					$thumb_id = get_post_thumbnail_id( $category__post[0]->ID );
					$thumb_url_array = wp_get_attachment_image_src( $thumb_id, 'md_bone_sm', true );
					$thumb_url = $thumb_url_array[0];
				} else {
					$thumb_url = '';
				}
			?>
			<li>
				<div class="categoryTile category-<?php echo esc_attr($category->slug); ?>">
					<a href="<?php echo esc_url(get_category_link( $category->term_id )); ?>" class="o-blockLink">
					<div class="o-backgroundImg o-backgroundImg--dimmed" style="background-image: url('<?php echo esc_url($thumb_url); ?>');"></div>
					<div class="categoryTile-info u-absCentered">
						<h4 class="categoryTile-info-name btn btn--pill btn--solid"><?php echo esc_html($category->name); ?></h4>
						<span class="categoryTile-info-count metaFont"><?php echo esc_html($category->count).'&nbsp;'.esc_html__('posts', 'bone'); ?></span>
					</div>					
					</a>
				</div>
			</li>
			<?php 	
			}
			?></ul><?php
		}

		echo $after_widget;

	}

	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['title'] = strip_tags($new_instance['title']);
		$instance['cats_id'] = implode(',' , $new_instance['cats_id']  );
		$instance['orderby'] = strip_tags($new_instance['orderby']);
		return $instance;
	}

	function form($instance) {
		$defaults = array( 'title' => esc_html__('Popular Categories' , 'bone') , 'cats_id' => '0' , 'orderby' => 'count' );
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
			<label for="<?php echo esc_attr($this->get_field_id( 'orderby' )); ?>"><?php esc_html_e('Categories order: ', 'bone'); ?></label>
			<select id="<?php echo esc_attr($this->get_field_id( 'orderby' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'orderby' )); ?>" >
				<option value="name" <?php if( $instance['orderby'] == 'name' ) echo "selected=\"selected\""; ?>><?php esc_html_e('Alphabet', 'bone'); ?></option>
				<option value="count" <?php if( $instance['orderby'] == 'count' ) echo "selected=\"selected\""; ?>><?php esc_html_e('Number of posts', 'bone'); ?></option>
			</select>
		</p>
	<?php
	}
}

add_action('widgets_init', create_function('', 'return register_widget("md_categories_widget");'));