<?php
/**
 * The template for displaying comments
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package Hongo
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) { exit; }

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */

	if ( post_password_required() ) {
		return;
	}

	$hongo_comment_title	= get_theme_mod( 'hongo_comment_title', esc_html__( 'Write a comment', 'hongo' ) );
	$no_padding_class		= is_page() ? ' no-padding-lr' : '';
?>
<?php if ( have_comments() ) : ?>
	<div id="comments" class="col-md-12 col-sm-12 col-xs-12 hongo-comment-box<?php echo esc_attr( $no_padding_class );?>">
		<div class="comment-title alt-font">
			<?php echo comments_number(); ?>
		</div>
		<?php the_comments_navigation(); ?>
		<ul class="blog-comment">
			<?php
				wp_list_comments( array(
					'style'			=> 'li',
					'short_ping'	=> true,
					'avatar_size'	=> 400,
					'callback'		=> 'hongo_comment_callback',
				) );
			?>
		</ul>
		<?php the_comments_navigation(); ?>
	</div>		
<?php endif; // Check for have_comments(). ?>
<div class="col-md-12 col-sm-12 col-xs-12 hongo-comment-form<?php echo esc_attr( $no_padding_class );?>">
	<?php
		$user			= wp_get_current_user();
		$user_identity	= $user->exists() ? $user->display_name : '';
		$args			= array();
		$args			= wp_parse_args( $args );
		if ( ! isset( $args['format'] ) ) {
			$args['format'] = current_theme_supports( 'html5', 'comment-form' ) ? 'html5' : 'xhtml';
		}
		$aria_req	= '';
		$html_req	= '';
		$html5		= 'html5' === $args['format'];
		$fields		= array(
			'author'=> '<div class="col-md-4 col-sm-12 col-xs-12"><input id="author" placeholder="'.esc_attr__( 'نام و نام خانوادگی*', 'hongo' ).'" class="input-field comment-fields" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" ' . $aria_req . $html_req . ' /></div>',
			'email'	=> '<div class="col-md-4 col-sm-12 col-xs-12"><input id="email" placeholder="'.esc_attr__( 'ایمیل*', 'hongo' ).'" class="input-field comment-fields" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '"' . $aria_req . $html_req  . ' /></div>',
			'url'	=> '<div class="col-md-4 col-sm-12 col-xs-12"><input id="url" placeholder="'.esc_attr__( 'وبسایت', 'hongo' ).'" class="input-field comment-fields" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" /></div>',
		);
		$fields 	= apply_filters( 'comment_form_default_fields', $fields );

		// To provide filter for change comment text
		$comment_placeholder_field	= apply_filters( 'comment_placeholder_field', __( 'پیام خود را در این قسمت وارد کنید...', 'hongo' ) );
		$cancel_reply_link			= apply_filters( 'cancel_reply_link', esc_html__( 'انصراف', 'hongo' ) );
		$label_submit 				= apply_filters( 'label_submit', esc_html__( 'ارسال دیدگاه', 'hongo' ) );
		
		comment_form( array(
			'fields'				=> $fields,
			'comment_field'			=> '<div class="col-md-12 col-sm-12 col-xs-12"><textarea id="comment" placeholder="' . esc_attr( $comment_placeholder_field ) . '" rows="6" class="input-field comment-fields" name="comment" required="required"></textarea></div>',
			'title_reply_before'	=> '<div class="reply-comment-title"><span class="comment-title alt-font">',
			'title_reply_after'		=> '</span></div>',
			'class_form'			=> 'comment-form blog-comment-form',
			'title_reply'			=> $hongo_comment_title,
			'title_reply_to'		=> $hongo_comment_title . esc_html__( ' to %s', 'hongo' ),
			'cancel_reply_link'		=> $cancel_reply_link,
			'label_submit'			=> $label_submit,
			'comment_notes_before'	=> '',
			'comment_notes_after'	=> '',
			'class_submit'			=> 'btn btn-dark-gray btn-small hongo-comment-button',
			'submit_button'			=> '<input name="%1$s" type="submit" id="%2$s" class="%3$s" value="%4$s" />',
			'submit_field'			=> '<div class="col-md-12 col-sm-12 col-xs-12 form-submit">%1$s %2$s</div>',
			'logged_in_as'			=> '<p class="logged-in-as col-md-12">' . sprintf( __( 'وارد شوید تحت عنوان <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">میخواهید خارج شوید؟</a>', 'hongo' ), esc_url( admin_url( 'profile.php' ) ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
		) );
	?>
</div>