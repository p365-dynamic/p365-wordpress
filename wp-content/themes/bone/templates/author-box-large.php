<?php
	global $wp_query;
	$curauth = $wp_query->get_queried_object();
	$author_id = $curauth->ID;
	$author_email = get_the_author_meta('email', $author_id);
    $author_name = get_the_author_meta('display_name', $author_id);
    $author_tw = get_the_author_meta('twitter', $author_id);
    $author_gp = get_the_author_meta('google', $author_id);
    $author_fb = get_the_author_meta('facebook', $author_id);
    $author_tb = get_the_author_meta('tumblr', $author_id);
    $author_in = get_the_author_meta('instagram', $author_id);
    $author_pt = get_the_author_meta('pinterest', $author_id);
    $author_www = get_the_author_meta('url', $author_id);
    $author_post_counts = count_user_posts( $author_id );
?>
<div itemscope itemtype="http://schema.org/Person" class="authorBox authorBox--large">
	<div class="authorBox-avatar"><?php echo get_avatar( $author_id, 120, '', esc_html__( 'avatar', 'bone' ), array('extra_attr' => 'itemprop="image"') ); ?></div>
	<div class="authorBox-text">

		<h4 itemprop="name" class="authorBox-name authorName"><?php echo esc_html($author_name); ?></h4>
		<p class="authorBox-bio"><?php the_author_meta( 'description' ); ?></p>

		<ul class="authorBox-socials list-inline">
			<?php if ($author_email) { ?>
			<li>
				<a href="mailto:<?php echo esc_attr($author_email); ?>" target="_blank" title="Email"><i class="fa fa-envelope"></i></a>
			</li>
			<?php } ?>

			<?php if ($author_www) { ?>
			<li>
				<a href="<?php echo esc_url($author_www); ?>" target="_blank" title="Website"><i class="fa fa-globe"></i></a>
			</li>
			<?php } ?>

			<?php if ($author_tw) { ?>
			<li>
				<a href="//twitter.com/<?php echo esc_attr($author_tw); ?>" target="_blank" title="Twitter"><i class="fa fa-twitter"></i></a>
			</li>
			<?php } ?>

			<?php if ($author_fb) { ?>
			<li>
				<a href="//facebook.com/<?php echo esc_attr($author_fb); ?>" target="_blank" title="Facebook"><i class="fa fa-facebook"></i></a>
			</li>
			<?php } ?>

			<?php if ($author_gp) { ?>
			<li>
				<a href="//plus.google.com/<?php echo esc_attr($author_gp); ?>" target="_blank" title="Google+"><i class="fa fa-google-plus"></i></a>
			</li>
			<?php } ?>

			<?php if ($author_tb) { ?>
			<li>
				<a href="//<?php echo esc_attr($author_tb); ?>.tumblr.com" target="_blank" title="Tumblr"><i class="fa fa-tumblr"></i></a>
			</li>
			<?php } ?>

			<?php if ($author_in) { ?>
			<li>
				<a href="//instagram.com/<?php echo esc_attr($author_in); ?>" target="_blank" title="Instagram"><i class="fa fa-instagram"></i></a>
			</li>
			<?php } ?>

			<?php if ($author_pt) { ?>
			<li>
				<a href="//pinterest.com/<?php echo esc_attr($author_pt); ?>" target="_blank" title="Pinterest"><i class="fa fa-pinterest"></i></a>
			</li>
			<?php } ?>			
		</ul>
		<div class="author-meta">
			<div class="author-meta__post-count">
				<h5 class="metaFont"><?php esc_html_e('Posts created', 'bone'); ?></h5>
				<span class="titleFont"><?php echo esc_html($author_post_counts); ?></span>
			</div><!--
			--><div class="author-meta__post-liked-count">
				<h5 class="metaFont"><?php esc_html_e('Posts liked', 'bone'); ?></h5>
				<span class="titleFont"><?php minimaldog_user_likes_count(); ?></span>
			</div>
		</div>
		
	</div>
	
</div>