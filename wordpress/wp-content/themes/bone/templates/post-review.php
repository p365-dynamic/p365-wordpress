<?php
    $post_id = get_the_id();
	$review_totalscore = md_bone_get_metabox( 'review_totalscore', '' );		
	$category_array = get_the_category();
	if ( $category_array ) {
		$category_id = $category_array[0]->term_id;
		$category_name = esc_attr( $category_array[0]->name );
		$category_link = esc_url( get_category_link( $category_id ) );
	}
	$article_link =  get_permalink();
	$max_score = 10;
?>
<div class="post--review clearfix">
	<h5 class="post--review-title postTitle"><a href="<?php echo esc_url($article_link); ?>" rel="bookmark"><?php the_title(); ?></a></h5>
	<div class="post--review-score metaFont"><?php echo esc_html($review_totalscore).'/'.esc_html($max_score); ?></div>
	<div class="post--review-meter">
		<div class="post--review-meter-bar" style="width:<?php echo esc_html($review_totalscore*100/$max_score); ?>%"></div>
	</div>
</div>