<?php
/*
Normally the js should be properly enqueued and the url
passed via wp_enqueue_script, but this is a proof of concept
more that real code
*/
function fa_fallback() {
  $cssurl = get_template_directory_uri() . '/css/';
}
add_action('wp_footer', function() {
  $cssurl = get_template_directory_uri() . '/css/';
  ?>
  <span id="facheck" data-cssuri="<?php echo esc_url($cssurl); ?>" class="fa" style="display:none">
  </span>
  <script>
  jQuery(document).ready(function($) {
    var $check = $('#facheck');
    if ( $check.css('fontFamily') !== 'FontAwesome' ) {
      // fon't awesome not loaded!
      // remove current css link
      $('#font-awesome-css').remove;
      // add the local version
      var local = '<link rel="stylesheet" type="text/css" href="' 
        + mdBoneVar.faURL + '" />';
      $('head').append( local );
    }
  });
  </script>
  <?php
});