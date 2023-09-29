<?php
$post_classes = array(
	'postSingle',
	'postSingle--headerTop',
	'hentry',
);
if (!isset($article_schema_type)) {
	$article_schema_type = '';
}
if (!isset($article_body_schema)) {
	$article_body_schema = '';
}
$format = md_bone_get_post_format();
get_header(); ?>

<?php if (have_posts()) : the_post(); ?>
<main class="layoutBody<?php if (!has_post_thumbnail()) echo ' noThumb'; ?>">
	<div class="container">
		<div class="layoutContent clearfix">

			<div class="layoutContent-main<?php echo esc_attr($main_classes); ?>">				
				<article itemscope itemtype="<?php echo esc_attr($article_schema_type); ?>" <?php md_bone_post_class($post_classes); ?>>

					<?php md_bone_single_header(); ?>

					<?php
					if ($format == '') {
						md_bone_featured_img('full');
					} else {
						md_bone_post_format('full');
					} ?>
					
					<?php if ($post->post_content !== '') { ?>

						<div itemprop="<?php echo esc_attr($article_body_schema); ?>" class="postContent bodyCopy entry-content">
							<?php the_content(); ?>
						</div>

						<?php md_bone_post_pagination(); ?>

						<?php md_bone_review_score(); ?>

					<?php } ?>

					<?php md_bone_single_footer(); ?>

					<?php if(is_active_sidebar('adsidebar-3')) { ?>
						<div class="adSidebar adSidebar--3">
						<?php dynamic_sidebar('adsidebar-3'); ?>
						</div>
					<?php } ?>
					
					<?php if (md_bone_get_option('authorbox-switch', '1')) get_template_part('templates/author-box'); ?>

				</article>

				<?php if (md_bone_get_option('postnav-switch', '1')) get_template_part('templates/post-navigation'); ?>
								
				<?php if (md_bone_get_option('related-post-switch', '1')) get_template_part('templates/related-posts'); ?>

				<?php
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
				?>

			</div><!-- end layoutContent-main -->
			
			<aside id="mdSidebar" class="layoutContent-sidebar sidebar<?php echo esc_attr($sidebar_classes); ?>">
				<?php get_sidebar(); ?>
			</aside>

		</div><!-- end layoutContent -->
	</div><!-- end container -->

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