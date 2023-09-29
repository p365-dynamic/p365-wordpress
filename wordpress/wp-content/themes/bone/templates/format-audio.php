<?php
	if ( !isset($thumb_size) ) {
		$thumb_size = 'md_bone_md';
	}

	$audio_url = esc_url(md_bone_get_metabox( 'format_audio_url' ));
	$embed = wp_oembed_get( $audio_url, array( 'width' => 820, 'height' => 200 ) );
	if ( $embed == '' ) {
		$audio_files = md_bone_get_metabox( 'format_audio_file', '', 'type=file_advanced' );
		if ( $audio_files != '' ) {
			$audio_file_url = '';
			foreach ( $audio_files as $audio_file ) {
				$audio_file_url = $audio_file['url'];
			}
			$audio_element = '<audio src="'.$audio_file_url.'" controls="controls">';
			$audio_title = md_bone_get_metabox( 'format_audio_title' );
			$audio_artist = md_bone_get_metabox( 'format_audio_artist' );
		}
	}
	
?>
<div class="postFormatMedia postFormatMedia--audio">
<?php if ( $embed != '' ) { ?>
		<div class="responsiveEmbed">
			<?php echo wp_oembed_get( $audio_url, array( 'width' => 820, 'height' => 200 ) ); ?>
		</div>
<?php } elseif ( $audio_files != '' ) {
			if ( has_post_thumbnail() ) {
				$thumb_id = get_post_thumbnail_id();
				$thumb_url_array = wp_get_attachment_image_src( $thumb_id, $thumb_size, true );
				$thumb_url = $thumb_url_array[0];
				$style = 'background-color: #fefefe;background-image: url('.esc_url($thumb_url).');background-position: 50% 50%;background-size: cover;background-repeat: no-repeat;';
			} else {
				$style = 'background-color: #333;';
			}
			?>
			<div class="mdAudioPlayer" style="<?php echo esc_attr($style); ?>">
			<?php
			if ( ($audio_title != '') || ($audio_artist != '') ) {
				echo '<div class="mdAudioPlayer-trackInfo">';
				echo '<div class="mdAudioPlayer-trackInfo-icon">';
				echo '<i class="fa fa-music"></i>';
				echo '</div>';
				echo '<div class="mdAudioPlayer-trackInfo-meta">';
				echo '<div class="mdAudioPlayer-trackInfo-meta-title titleFont">'.esc_html($audio_title).'</div>';
				echo '<div class="mdAudioPlayer-trackInfo-meta-artist metaFont">'.esc_html($audio_artist).'</div>';
				echo '</div>';
				echo '</div>';
			}
			echo wp_kses_post($audio_element);
			?>
			</div>
			<?php
		} ?>
</div>