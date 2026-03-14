<?php
/**
 * Comments Template
 *
 * @package Brokar
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<?php
			$count = get_comments_number();
			printf(
				/* translators: %d: comment count */
				esc_html( _n( '%d reactie', '%d reacties', $count, 'brokar' ) ),
				$count
			);
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments( [
				'style'       => 'ol',
				'short_ping'  => true,
				'avatar_size' => 48,
			] );
			?>
		</ol>

		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<nav class="comment-navigation">
			<div class="nav-previous"><?php previous_comments_link( __( '← Oudere reacties', 'brokar' ) ); ?></div>
			<div class="nav-next"><?php next_comments_link( __( 'Nieuwere reacties →', 'brokar' ) ); ?></div>
		</nav>
		<?php endif; ?>

	<?php endif; ?>

	<?php if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Reacties zijn gesloten.', 'brokar' ); ?></p>
	<?php endif; ?>

	<?php
	comment_form( [
		'title_reply'          => __( 'Laat een reactie achter', 'brokar' ),
		'title_reply_to'       => __( 'Reageer op %s', 'brokar' ),
		'cancel_reply_link'    => __( 'Annuleren', 'brokar' ),
		'label_submit'         => __( 'Reactie plaatsen', 'brokar' ),
		'submit_button'        => '<button name="%1$s" type="submit" id="%2$s" class="btn btn--gold %3$s">%4$s</button>',
		'submit_field'         => '<div class="form-submit">%1$s %2$s</div>',
		'comment_notes_before' => '',
	] );
	?>

</div><!-- #comments -->
