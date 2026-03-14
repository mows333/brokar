<?php
/**
 * Single Post Template
 *
 * @package Brokar
 */

get_header();
?>

<?php while ( have_posts() ) : the_post(); ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class( 'single-post' ); ?>>

		<!-- Post Header -->
		<header class="single-post__header">
			<div class="container container--narrow">
				<div class="single-post__meta-top" data-animate="fade-up">
					<?php
					$cats = get_the_category();
					if ( $cats ) :
						$cat = array_shift( $cats );
					?>
					<a class="post-category-badge" href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>">
						<?php echo esc_html( $cat->name ); ?>
					</a>
					<?php endif; ?>
					<?php brokar_reading_time(); ?>
				</div>
				<h1 class="single-post__title" data-animate="fade-up" data-delay="80"><?php the_title(); ?></h1>
				<div class="single-post__byline" data-animate="fade-up" data-delay="120">
					<?php brokar_post_meta( false ); ?>
				</div>
			</div>

			<?php if ( has_post_thumbnail() ) : ?>
			<figure class="single-post__hero" data-animate="fade-up" data-delay="160">
				<div class="container">
					<?php the_post_thumbnail( 'brokar-wide', [ 'class' => 'single-post__hero-img', 'alt' => esc_attr( get_the_title() ) ] ); ?>
				</div>
				<?php if ( get_the_post_thumbnail_caption() ) : ?>
				<figcaption class="single-post__caption container">
					<?php echo esc_html( get_the_post_thumbnail_caption() ); ?>
				</figcaption>
				<?php endif; ?>
			</figure>
			<?php endif; ?>
		</header>

		<!-- Post Content -->
		<div class="single-post__body container container--narrow">
			<div class="entry-content">
				<?php the_content(); ?>
			</div>

			<?php
			wp_link_pages( [
				'before' => '<nav class="page-links"><span class="page-links__label">' . __( 'Pagina\'s:', 'brokar' ) . '</span>',
				'after'  => '</nav>',
			] );
			?>
		</div>

		<!-- Post Footer -->
		<footer class="single-post__footer container container--narrow">
			<?php
			$tags = get_the_tags();
			if ( $tags ) :
			?>
			<div class="post-tags">
				<?php foreach ( $tags as $tag ) : ?>
				<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="post-tag">
					#<?php echo esc_html( $tag->name ); ?>
				</a>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>

			<?php brokar_social_share(); ?>

			<?php edit_post_link( __( 'Bewerk bericht', 'brokar' ), '<span class="edit-link">', '</span>' ); ?>
		</footer>

	</article>

	<!-- Author Box -->
	<?php get_template_part( 'template-parts/content/author-box' ); ?>

	<!-- Post Navigation -->
	<nav class="post-nav container container--narrow" aria-label="<?php esc_attr_e( 'Vorig/volgend bericht', 'brokar' ); ?>">
		<div class="post-nav__inner">
			<?php
			$prev = get_previous_post();
			$next = get_next_post();
			if ( $prev ) :
			?>
			<a href="<?php echo esc_url( get_permalink( $prev ) ); ?>" class="post-nav__link post-nav__link--prev">
				<span class="post-nav__direction">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
					<?php esc_html_e( 'Vorig bericht', 'brokar' ); ?>
				</span>
				<span class="post-nav__title"><?php echo esc_html( get_the_title( $prev ) ); ?></span>
			</a>
			<?php endif; ?>

			<?php if ( $next ) : ?>
			<a href="<?php echo esc_url( get_permalink( $next ) ); ?>" class="post-nav__link post-nav__link--next">
				<span class="post-nav__direction">
					<?php esc_html_e( 'Volgend bericht', 'brokar' ); ?>
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
				</span>
				<span class="post-nav__title"><?php echo esc_html( get_the_title( $next ) ); ?></span>
			</a>
			<?php endif; ?>
		</div>
	</nav>

	<!-- Related Posts -->
	<?php
	$related = new WP_Query( [
		'posts_per_page'      => 3,
		'post__not_in'        => [ get_the_ID() ],
		'category__in'        => wp_get_post_categories( get_the_ID() ),
		'ignore_sticky_posts' => 1,
	] );
	if ( $related->have_posts() ) :
	?>
	<section class="related-posts section" data-bg="light">
		<div class="container">
			<h2 class="related-posts__title"><?php esc_html_e( 'Meer berichten', 'brokar' ); ?></h2>
			<div class="blog-grid blog-grid--3">
				<?php
				while ( $related->have_posts() ) :
					$related->the_post();
					get_template_part( 'template-parts/content/card' );
				endwhile;
				wp_reset_postdata();
				?>
			</div>
		</div>
	</section>
	<?php endif; ?>

	<!-- Comments -->
	<?php if ( comments_open() || get_comments_number() ) : ?>
	<div class="comments-section container container--narrow">
		<?php comments_template(); ?>
	</div>
	<?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>
