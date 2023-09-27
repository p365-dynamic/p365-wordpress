<?php
$layout_opt = md_bone_get_layout_opt();
$post_classes = array(
	'postSingle',
	'postSingle--standard',
	'postSingle--attachment',
);
if ($layout_opt['sidebar-position'] == 'none') {
	$post_classes[] = 'postSingle--fullwidth';
}

get_header(); ?>

<?php if (have_posts()): the_post(); ?>

<main class="layoutBody">
<?php if ( $layout_opt['sidebar-position'] == 'none' ) { ?>
	<div class="container">
		<div class="layoutContent<?php echo esc_attr($layout_opt['main-class']); ?> clearfix">
			<article <?php post_class($post_classes); ?>>

				<?php md_bone_post_format('md_bone_lg'); ?>
				
				<div class="bodyCopy">
					<header class="postSingle-header">
						<h1 itemprop="name" class="postTitle"><?php the_title(); ?></h1>
					</header>

					<div class="postSingle--attachment-content">
						<?php
						if ( wp_attachment_is_image() ) {
							echo wp_get_attachment_image( get_the_id(), 'md_bone_xl', false,  array( 'class' => 'wp-post-image' ) ); }
						else {
							echo '<a href="' . wp_get_attachment_url() . '">' . basename( get_attached_file( get_the_id() ) ) . '</a>'; }
						?>
					</div>

					<?php if ( wp_attachment_is_image() ) { ?>
					<p class='postSingle--attachment-resolutions'> Downloads: 
					<?php
						$images = array();
						$image_sizes = get_intermediate_image_sizes();
						array_push( $image_sizes, 'full' );
						foreach( $image_sizes as $image_size ) {
							$image = wp_get_attachment_image_src( get_the_ID(), $image_size );
							$name = '(' . $image[1] . 'x' . $image[2] . ')';
							$images[] = '<a href="' . $image[0] . '">' . $name . '</a>';
						}
						echo implode( ' | ', $images );
					?>
					</p>
					<?php } ?>
				</div>
				
			</article>
		</div>
	</div>
<?php } else { ?>
	<div class="container">
		<div class="layoutContent clearfix">
			<div class="layoutContent-main<?php echo esc_attr($layout_opt['main-class']); ?>">

				<article <?php post_class($post_classes); ?>>

					<?php md_bone_post_format('md_bone_lg'); ?>
					
					<div class="bodyCopy">
						<header class="postSingle-header">
							<h1 itemprop="name" class="postTitle"><?php the_title(); ?></h1>
						</header>

						<div class="postSingle--attachment-content">
							<?php
							if ( wp_attachment_is_image() ) {
								echo wp_get_attachment_image( get_the_id(), 'md_bone_lg', false,  array( 'class' => 'wp-post-image' ) ); }
							else {
								echo '<a href="' . wp_get_attachment_url() . '">' . basename( get_attached_file( get_the_id() ) ) . '</a>'; }
							?>
						</div>

						<?php if ( wp_attachment_is_image() ) { ?>
						<p class='postSingle--attachment-resolutions'> Downloads: 
						<?php
							$images = array();
							$image_sizes = get_intermediate_image_sizes();
							array_push( $image_sizes, 'full' );
							foreach( $image_sizes as $image_size ) {
								$image = wp_get_attachment_image_src( get_the_ID(), $image_size );
								$name = '(' . $image[1] . 'x' . $image[2] . ')';
								$images[] = '<a href="' . $image[0] . '">' . $name . '</a>';
							}
							echo implode( ' | ', $images );
						?>
						</p>
						<?php } ?>

					</div>
					
				</article>

			</div>						

			<aside class="layoutContent-sidebar sidebar<?php echo esc_attr($layout_opt['sidebar-class']); ?>">
				<?php get_sidebar(); ?>
			</aside>	
		</div>
	</div>
	
	<?php } ?>

</main>
<?php endif; ?>

<?php if (is_active_sidebar('adsidebar-2')) { ?>
	<div class="adSidebar adSidebar--2">
		<div class="container">
			<?php dynamic_sidebar('adsidebar-2'); ?>
		</div>
	</div>
<?php } ?>

<?php get_footer();