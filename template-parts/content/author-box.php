<?php
/**
 * Author Box
 *
 * @package Brokar
 */

if ( ! is_single() ) {
	return;
}
?>

<div class="author-box container container--narrow">
	<div class="author-box__avatar">
		<?php echo get_avatar( get_the_author_meta( 'ID' ), 80, '', '', [ 'class' => 'author-box__img' ] ); ?>
	</div>
	<div class="author-box__info">
		<span class="author-box__label"><?php esc_html_e( 'Over de auteur', 'brokar' ); ?></span>
		<h3 class="author-box__name"><?php echo esc_html( get_the_author() ); ?></h3>
		<?php if ( get_the_author_meta( 'description' ) ) : ?>
		<p class="author-box__bio"><?php echo esc_html( get_the_author_meta( 'description' ) ); ?></p>
		<?php endif; ?>
		<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="author-box__link">
			<?php printf( esc_html__( 'Meer van %s', 'brokar' ), esc_html( get_the_author() ) ); ?>
		</a>
	</div>
</div>
