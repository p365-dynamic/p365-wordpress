<?php
	$author_id = get_the_author_meta( 'ID' );
	$author_email = get_the_author_meta('email', $author_id);
    $author_name = get_the_author_meta('display_name', $author_id);
    $author_tw = get_the_author_meta('twitter', $author_id);
    $author_gp = get_the_author_meta('google', $author_id);
    $author_fb = get_the_author_meta('facebook', $author_id);
    $author_tb = get_the_author_meta('tumblr', $author_id);
    $author_in = get_the_author_meta('instagram', $author_id);
    $author_pt = get_the_author_meta('pinterest', $author_id);
    $author_www = get_the_author_meta('url', $author_id);
?>
<div itemprop="author" itemscope itemtype="http://schema.org/Person" class="authorBox">
	<div class="authorBox-avatar"><?php echo get_avatar( $author_id, 100, '', esc_html__( 'avatar', 'bone' ), array('extra_attr' => 'itemprop="image"') ); ?></div>
	<div class="authorBox-text">
		<div class="authorBox-name authorName">
			<h4 itemprop="name" ><?php the_author_posts_link(); ?></h4>
		</div>
		<p class="authorBox-bio metaFont"><?php the_author_meta( 'description' ); ?></p>

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
	</div>
</div>