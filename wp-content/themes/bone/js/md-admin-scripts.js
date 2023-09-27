(function ($, root, undefined) {
	
	$(function () {
		
		'use strict';

        // Review total score update
        function updateTotalScore(){
            $('#md_bone_post_options #criteria_score').closest('.rwmb-group-wrapper').on('click mousedown keydown', function(){
                var totalScore = 0;
                var i = 0;
                var scores = [];
                var $mdReviewScores = $(this).find('[name^=md_bone_review_score][name*=criteria_score]');
                $mdReviewScores.each(function(){
                    scores.push($(this).val());
                    totalScore += parseInt($(this).val());
                    i++;
                });
                if (scores.length > 0) {
                    $('#md_bone_review_totalscore').val(Math.round((totalScore/scores.length)*10)/10);
                }
            });
        }

        // Metabox post format toggle
        function toggleMetabox(){
            var $formatMetaboxes = $('[id^=md_bone_format_][class*=postbox]');
            if ($formatMetaboxes.length == 0) {
                return;
            }
            var $formatRadios = $('#post-formats-select').find('input');
            displayMetaboxes(); // hide all format on initial

            // show only selected format (initial)
            function displayMetaboxes() {
                var selectedFormat = $('input[name="post_format"]:checked').attr('id');
                var metaboxID = '#md_bone_'+selectedFormat.replace('post-','').replace(/\-/g,'_');
                $formatMetaboxes.hide();
                $(metaboxID).show();
            }

            $formatRadios.on('change', function(){
                displayMetaboxes();
            });
        }

        $(document).ready(function() {
            updateTotalScore();
            toggleMetabox();
        });
		
	});
	
})(jQuery, this);
