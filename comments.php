<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Flexible
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

<div id="comments" class="comments-area comments  nolist">

	<?php
	// You can start editing here -- including this comment!
	if ( have_comments() ) : ?>
		<h5 class="comments-title">
			<?php
				printf( // WPCS: XSS OK.
					esc_html( _nx( '1 COMMENT', '%1$s COMMENTS', get_comments_number(), 'comments title', 'flexible' ) ),
					number_format_i18n( get_comments_number() )
				);
			?>
		</h5>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-above" class="navigation comment-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'flexible' ); ?></h2>
			<div class="nav-links">

				<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'flexible' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'flexible' ) ); ?></div>

			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-above -->
		<?php endif; // Check for comment navigation. ?>
        
        <?php add_filter('comment_reply_link', 'flexible_reply_link_class'); ?>
		<ul class="comments-list">
			<?php
				wp_list_comments( array(                    
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size'=> 75,
					'callback'   => 'flexible_cb_comment'
				) );
			?>
		</ul><!-- .comment-list -->
        <?php remove_filter('comment_reply_link', 'flexible_reply_link_class'); ?>


		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // Are there comments to navigate through? ?>
		<nav id="comment-nav-below" class="navigation comment-navigation" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comment navigation', 'flexible' ); ?></h2>
			<div class="nav-links">

				<div class="nav-previous"><?php previous_comments_link( esc_html__( 'Older Comments', 'flexible' ) ); ?></div>
				<div class="nav-next"><?php next_comments_link( esc_html__( 'Newer Comments', 'flexible' ) ); ?></div>

			</div><!-- .nav-links -->
		</nav><!-- #comment-nav-below -->
		<?php
		endif; // Check for comment navigation.

	endif; // Check for have_comments().


	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>

		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'flexible' ); ?></p>
	<?php
	endif;
    
    /* comment form */
    $comments_args = ( function_exists( 'flexible_custom_comment_form' ) ) ? flexible_custom_comment_form() : '';
	comment_form($comments_args);
	?>

</div><!-- #comments -->
