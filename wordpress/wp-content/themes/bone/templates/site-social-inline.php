<?php
$fb = md_bone_get_option('facebook-url', '');
$tw = md_bone_get_option('twitter-url', '');
$gp = md_bone_get_option('google-url', '');
$in = md_bone_get_option('instagram-url', '');
$pi = md_bone_get_option('pinterest-url', '');
$tu = md_bone_get_option('tumblr-url', '');
$li = md_bone_get_option('linkedin-url', '');
$yt = md_bone_get_option('youtube-url', '');
$vk = md_bone_get_option('vk-url', '');
$default_order = array(
    'fb' => true,
    'tw' => true,
    'gp' => true,
    'in' => true,
    'pi' => true,
    'tu' => true,
    'li' => true,
    'yt' => true,
    'vk' => true,
);
$social_sortable = md_bone_get_option('social-sortable', $default_order);
if (($fb !== '') || ($tw !== '') || ($gp !== '') || ($in !== '') || ($pi !== '') || ($tu !== '') || ($li !== '') || ($yt !== '') || ($vk !== '')) {
?>
<ul class="socialList socialList--inline metaFont">
	<?php
	foreach ($social_sortable as $key => $value) {
		if ($value) {
			switch ($key) {
				default:
				case 'fb':
					if ($fb !== '') {
						echo '<li class="socialList-facebook"><a href="'.esc_url($fb).'"><i class="fa fa-facebook"></i></a></li>';
					}
					break;
				
				case 'tw':
					if ($tw !== '') {
						echo '<li class="socialList-twitter"><a href="'.esc_url($tw).'"><i class="fa fa-twitter"></i></a></li>';
					}
					break;
				
				case 'gp':
					if ($gp !== '') {
						echo '<li class="socialList-google"><a href="'.esc_url($gp).'"><i class="fa fa-google-plus"></i></a></li>';
					}
					break;
				
				case 'in':
					if ($in !== '') {
						echo '<li class="socialList-instagram"><a href="'.esc_url($in).'"><i class="fa fa-instagram"></i></a></li>';
					}
					break;
				
				case 'pi':
					if ($pi !== '') {
						echo '<li class="socialList-pinterest"><a href="'.esc_url($pi).'"><i class="fa fa-pinterest"></i></a></li>';
					}
					break;
				
				case 'tu':
					if ($tu !== '') {
						echo '<li class="socialList-tumblr"><a href="'.esc_url($tu).'"><i class="fa fa-tumblr"></i></a></li>';
					}
					break;
				
				case 'li':
					if ($li !== '') {
						echo '<li class="socialList-linkedin"><a href="'.esc_url($li).'"><i class="fa fa-linkedin"></i></a></li>';
					}
					break;
				
				case 'yt':
					if ($yt !== '') {
						echo '<li class="socialList-youtube"><a href="'.esc_url($yt).'"><i class="fa fa-youtube"></i></a></li>';
					}
					break;
				
				case 'vk':
					if ($vk !== '') {
						echo '<li class="socialList-vk"><a href="'.esc_url($vk).'"><i class="fa fa-vk"></i></a></li>';
					}
					break;
			}
		}
	}
	?>
</ul>
<?php }