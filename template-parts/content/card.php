<?php
/**
 * Post Card Template Part
 *
 * @package Brokar
 * @var array $args
 */

$delay    = $args['animate_delay'] ?? 0;
$featured = $args['featured'] ?? false;
$classes  = [ 'post-card' ];
if ( $featured ) {
	$classes[] = 'post-card--featured';
}
?>

<article id="post-<?php the_ID(); ?>" <?php post_class( implode( ' ', $classes ) ); ?> data-animate="fade-up" data-delay="<?php echo esc_attr( $delay ); ?>">

	<?php if ( has_post_thumbnail() ) : ?>
	<a href="<?php the_permalink(); ?>" class="post-card__thumb-link" tabindex="-1" aria-hidden="true">
		<figure class="post-card__thumb">
			<?php the_post_thumbnail( $featured ? 'brokar-wide' : 'brokar-card', [ 'class' => 'post-card__img', 'alt' => '' ] ); ?>
			<div class="post-card__thumb-overlay"></div>
		</figure>
	</a>
	<?php endif; ?>

	<div class="post-card__body">
		<?php
		$cats = get_the_category();
		if ( $cats ) :
			$cat = array_shift( $cats );
		?>
		<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" class="post-card__cat">
			<?php echo esc_html( $cat->name ); ?>
		</a>
		<?php endif; ?>

		<h3 class="post-card__title">
			<a href="<?php the_permalink(); ?>" class="post-card__title-link">
				<?php the_title(); ?>
			</a>
		</h3>

		<div class="post-card__excerpt">
			<?php the_excerpt(); ?>
		</div>

		<footer class="post-card__footer">
			<div class="post-card__meta">
				<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" class="post-card__date">
					<?php echo esc_html( get_the_date( 'd M Y' ) ); ?>
				</time>
				<span class="post-card__author"><?php echo esc_html( get_the_author() ); ?></span>
			</div>
			<a href="<?php the_permalink(); ?>" class="post-card__read-more" aria-label="<?php echo esc_attr( sprintf( __( 'Lees meer over %s', 'brokar' ), get_the_title() ) ); ?>">
				<?php esc_html_e( 'Lees meer', 'brokar' ); ?>
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
			</a>
		</footer>
	</div>
</article>
