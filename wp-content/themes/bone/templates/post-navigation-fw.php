<?php
	$prev_post = get_previous_post();
	if (!empty( $prev_post )) {
		$prev_post_url = get_permalink( $prev_post->ID );
		$prev_post_title = get_the_title( $prev_post->ID );
	}

	$next_post = get_next_post();
	if (!empty( $next_post )) {
		$next_post_url = get_permalink( $next_post->ID );
		$next_post_title = get_the_title( $next_post->ID );
	}
?>
<div class="postNavigation postNavigation--fw u-fullwidth">
	<div class="container">
		<div class="flexbox">
			<div class="flexbox-item">
				<?php if (!empty( $prev_post )) : ?>
				<div class="postNavigation-prev clearfix">
					<?php if ( has_post_thumbnail($prev_post->ID) ) { ?>
					<div class="postNavigation-thumb">
						<?php echo get_the_post_thumbnail( $prev_post->ID, 'md_bone_xs' ); ?>
					</div>
					<?php } ?>
					<span class="metaFont"><?php esc_html_e('Previous article', 'bone'); ?></span>
					<span class="postTitle"><?php echo esc_html($prev_post_title); ?></span>
					<a href="<?php echo esc_url($prev_post_url); ?>" class="u-stretched"></a>
				</div>
				<?php endif; ?>
			</div>
			
			<div class="flexbox-item">
				<?php if (!empty( $next_post )) : ?>
				<div class="postNavigation-next clearfix">
					<?php if ( has_post_thumbnail($next_post->ID) ) { ?>
					<div class="postNavigation-thumb">
						<?php echo get_the_post_thumbnail( $next_post->ID, 'md_bone_xs' ); ?>
					</div>
					<?php } ?>
					<span class="metaFont"><?php esc_html_e('Next article', 'bone'); ?></span>
					<span class="postTitle"><?php echo esc_html($next_post_title); ?></span>
					<a href="<?php echo esc_url($next_post_url); ?>" class="u-stretched"></a>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>