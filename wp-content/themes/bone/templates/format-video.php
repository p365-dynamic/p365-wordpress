<?php
	if ( !isset($size) ) {
		$size = 'md_bone_lg';
	}
     	
	$video_url = md_bone_get_metabox( 'format_video_url' );
	$embed = wp_oembed_get( $video_url, array( 'width' => 820 ) );

	if ($embed == '') {
		md_bone_featured_img( $size );
		return;
	}
?>
<div class="postFormatMedia postFormatMedia--video">
	<div class="responsiveEmbedVideo">
		<?php echo wp_oembed_get( $video_url, array( 'width' => 820 ) ); ?>
	</div>
</div>