<?php
/**
 * Add image class in tinymce
 */
add_action('print_media_templates', 'md_bone_change_backbone_js_hook');
function md_bone_change_backbone_js_hook() {
    //change the backbone js template
    ?>
    <script type="text/javascript">

        (function (){

            var md_template_content = jQuery('#tmpl-image-details').text();

            var md_our_content = '' +
                '<div class="setting md-bone-modal">' +
                '<span>Modal image</span>' +
                '<div class="button-large button-group" >' +
                '<button class="button active md-bone-modal-image-off" value="left">Off</button>' +
                '<button class="button md-bone-modal-image-on" value="left">On</button>' +
                '</div>' +
                '</div><!-- /setting -->' +
                '<div class="setting md-bone-wide-img">' +
                '<span>Wide image</span>' +
                '<div class="button-large button-group" >' +
                '<button class="button active md-bone-wide-image-off" value="left">Off</button>' +
                '<button class="button md-bone-wide-image-wide" value="left">Wide</button>' +
                '<button class="button md-bone-wide-image-fw" value="left">Full width</button>' +
                '</div>' +
                '</div><!-- /setting -->';

            //inject our settings in the template - before <div class="setting align">
            md_template_content = md_template_content.replace('<div class="setting align">', md_our_content + '<div class="setting align">');

            //save the template
            jQuery('#tmpl-image-details').html(md_template_content);

            //modal off - click event
            jQuery(".md-bone-modal-image-on").live( "click", function() {
                if (jQuery(this).hasClass('active')) {
                    return;
                }
                md_change_link_to();
                md_add_image_css_class('js-imageZoom');

                jQuery(".md-bone-modal-image-off").removeClass('active');
                jQuery(".md-bone-modal-image-on").addClass('active');
            });

            //modal on - click event
            jQuery(".md-bone-modal-image-off").live( "click", function() {
                if (jQuery(this).hasClass('active')) {
                    return;
                }

                md_remove_image_css_class('js-imageZoom');

                jQuery(".md-bone-modal-image-off").addClass('active');
                jQuery(".md-bone-modal-image-on").removeClass('active');
            });

            //modal off - click event
            jQuery(".md-bone-wide-image-wide").live( "click", function() {
                if (jQuery(this).hasClass('active')) {
                    return;
                }
                md_change_link_to();
                md_add_image_css_class('is-wideImage');
                md_remove_image_css_class('is-fullwidthImage');

                jQuery(".md-bone-wide-image-off").removeClass('active');
                jQuery(".md-bone-wide-image-wide").addClass('active');
                jQuery(".md-bone-wide-image-fw").removeClass('active');
            });

            //modal off - click event
            jQuery(".md-bone-wide-image-fw").live( "click", function() {
                if (jQuery(this).hasClass('active')) {
                    return;
                }
                md_change_link_to();
                md_add_image_css_class('is-fullwidthImage');
                md_remove_image_css_class('is-wideImage');

                jQuery(".md-bone-wide-image-off").removeClass('active');
                jQuery(".md-bone-wide-image-wide").removeClass('active');
                jQuery(".md-bone-wide-image-fw").addClass('active');
            });

            //modal on - click event
            jQuery(".md-bone-wide-image-off").live( "click", function() {
                if (jQuery(this).hasClass('active')) {
                    return;
                }

                md_remove_image_css_class('is-fullwidthImage');
                md_remove_image_css_class('is-wideImage');

                jQuery(".md-bone-wide-image-off").addClass('active');
                jQuery(".md-bone-wide-image-wide").removeClass('active');
                jQuery(".md-bone-wide-image-fw").removeClass('active');
            });

            //util functions to edit the image details in wp-admin
            function md_change_link_to() {
                jQuery('*[data-setting="link"]').val('none');
                jQuery('*[data-setting="link"]').change();
            }
            function md_add_image_css_class(new_class) {
                var md_extra_classes_value = jQuery('*[data-setting="extraClasses"]').val();
                jQuery('*[data-setting="extraClasses"]').val(md_extra_classes_value + ' ' + new_class);
                jQuery('*[data-setting="extraClasses"]').change(); //trigger the change event for backbonejs
            }

            function md_remove_image_css_class(new_class) {
                var md_extra_classes_value = jQuery('*[data-setting="extraClasses"]').val();

                //try first with a space before the class
                var md_regex = new RegExp(" " + new_class,"g");
                md_extra_classes_value = md_extra_classes_value.replace(md_regex, '');

                var md_regex = new RegExp(new_class,"g");
                md_extra_classes_value = md_extra_classes_value.replace(md_regex, '');

                jQuery('*[data-setting="extraClasses"]').val(md_extra_classes_value);
                jQuery('*[data-setting="extraClasses"]').change(); //trigger the change event for backbonejs
            }

            //clears all classes except the modal image one
            function md_clear_all_classes() {
                var md_extra_classes_value = jQuery('*[data-setting="extraClasses"]').val();
                if (md_extra_classes_value.indexOf('js-imageZoom') > -1) {
                    //we have the modal image one - keep it, remove the others
                    jQuery('*[data-setting="extraClasses"]').val('js-imageZoom');
                } else {
                    jQuery('*[data-setting="extraClasses"]').val('');
                }
            }

            //monitor the backbone template for the current status of the picture
            setInterval(function(){
                var md_extra_classes_value = jQuery('*[data-setting="extraClasses"]').val();
                if (typeof md_extra_classes_value !== 'undefined' && md_extra_classes_value != '') {
                    // if we have modal on, switch the toggle
                    if (md_extra_classes_value.indexOf('js-imageZoom') > -1) {
                        jQuery(".md-bone-modal-image-off").removeClass('active');
                        jQuery(".md-bone-modal-image-on").addClass('active');
                    }

                    if (md_extra_classes_value.indexOf('is-wideImage') > -1) {
                        jQuery(".md-bone-wide-image-off").removeClass('active');
                        jQuery(".md-bone-wide-image-wide").addClass('active');
                        jQuery(".md-bone-wide-image-fw").removeClass('active');
                    }

                    if (md_extra_classes_value.indexOf('is-fullwidthImage') > -1) {
                        jQuery(".md-bone-wide-image-off").removeClass('active');
                        jQuery(".md-bone-wide-image-wide").removeClass('active');
                        jQuery(".md-bone-wide-image-fw").addClass('active');
                    }

                }
            }, 1000);
        })(); //end anon function
    </script>
<?php
}