<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<div class="comments-title blockHeading blockHeading--grey">
			<span class="hidden-xs">
				<i class="fa fa-comments"></i><?php printf( _nx( 'There is 1 comment', 'There are %1$s comments', get_comments_number(), 'comments title', 'bone' ), number_format_i18n( get_comments_number() ) ); ?>
			</span>
			<span class="hidden-sm hidden-md hidden-lg">
				<i class="fa fa-comments"></i><?php printf( _nx( '1 comment', '%1$s comments', get_comments_number(), 'comments title', 'bone' ), number_format_i18n( get_comments_number() ) ); ?>
			</span>
		</div>

		<?php md_bone_comment_nav(); ?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'callback' => 'md_bone_comment',
					'max-depth' => 4,
				) );
			?>
		</ol><!-- .comment-list -->

		<?php md_bone_comment_nav(); ?>

	<?php else: ?>
		<div class="comments-title blockHeading blockHeading--grey titleFont">
			<span class="hidden-xs">
				<i class="fa fa-comments"></i><?php  esc_html_e( 'There are no comments yet', 'bone'); ?>
			</span>
			<span class="hidden-sm hidden-md hidden-lg">
				<i class="fa fa-comments"></i><?php  esc_html_e( 'No comments', 'bone'); ?>
			</span>
		</div>

	<?php endif; // have_comments() ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
		if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'bone' ); ?></p>

	<?php endif; ?>

	<?php comment_form(); ?>

</div><!-- .comments-area -->
