function faFallBack($) {
  var $check = $('.fa');
  if ($check.length) {
    if ( $check.css('fontFamily') !== 'FontAwesome' ) {
      // fon't awesome not loaded!
      // remove current css link
      $('#font-awesome-css').remove;
      // add the local version
      var local = '<link rel="stylesheet" type="text/css" href="' 
        + mdBoneVar.faURL + '" />';
      $('head').append( local );
    }
  }
};