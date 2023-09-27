jQuery(document).ready(function() {
	jQuery('body').on('click','.js-mdPostLike',function(event){
		event.preventDefault();
		text = '<span class="hidden-xs">&nbsp;'+mdBoneVar.postLike.likeCountText+'</span>';
		heart = jQuery(this);
		post_id = heart.data("post_id");
		heart.html("<i class='fa fa-heart-o'></i><i class='fa fa-spin fa-circle-o-notch'></i>");
		jQuery.ajax({
			type: "post",
			url: mdBoneVar.ajaxloadpost.ajaxurl,
			data: "action=md-post-like&nonce="+mdBoneVar.postLike.nonce+"&minimaldog_post_like=&post_id="+post_id,
			success: function(count){
				if( count.indexOf( "already" ) !== -1 )
				{
					var lecount = count.replace("already","");
					if (lecount === "0")
					{
						lecount = '';
						text = '<span class="hidden-xs">&nbsp;'+mdBoneVar.postLike.likeText+'</span>';
					} else {
						lecount = '&nbsp;'+lecount;
					}
					heart.prop('title', mdBoneVar.postLike.likeText);
					heart.removeClass("liked");
					heart.html("<i class='fa fa-heart-o'></i>"+lecount+text);
				}
				else
				{
					heart.prop('title', mdBoneVar.postLike.unlikeText);
					heart.addClass("liked");
					heart.html("<i class='fa fa-heart'></i>&nbsp;"+count+text);
				}
			}
		});
	});
});
