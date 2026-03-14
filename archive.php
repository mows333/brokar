<?php
/**
 * Archive Template
 *
 * @package Brokar
 */

get_header();
?>

<div class="archive-hero">
	<div class="container">
		<div class="archive-hero__content" data-animate="fade-up">
			<?php
			if ( is_category() ) {
				echo '<span class="section-label">' . esc_html__( 'Categorie', 'brokar' ) . '</span>';
				single_cat_title( '<h1 class="archive-hero__title">', '</h1>' );
				if ( category_description() ) {
					echo '<div class="archive-hero__desc">' . wp_kses_post( category_description() ) . '</div>';
				}
			} elseif ( is_tag() ) {
				echo '<span class="section-label">' . esc_html__( 'Tag', 'brokar' ) . '</span>';
				single_tag_title( '<h1 class="archive-hero__title">#', '</h1>' );
			} elseif ( is_author() ) {
				echo '<span class="section-label">' . esc_html__( 'Auteur', 'brokar' ) . '</span>';
				echo '<h1 class="archive-hero__title">' . esc_html( get_the_author() ) . '</h1>';
			} elseif ( is_date() ) {
				echo '<span class="section-label">' . esc_html__( 'Archief', 'brokar' ) . '</span>';
				echo '<h1 class="archive-hero__title">' . esc_html( get_the_date( 'F Y' ) ) . '</h1>';
			} else {
				echo '<h1 class="archive-hero__title">' . esc_html__( 'Nieuws & Blog', 'brokar' ) . '</h1>';
			}
			?>
		</div>
	</div>
</div>

<section class="blog-archive section" data-bg="light">
	<div class="container">
		<?php if ( have_posts() ) : ?>

		<div class="blog-grid blog-grid--masonry">
			<?php
			$i = 0;
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content/card', null, [
					'animate_delay' => $i * 80,
					'featured'      => ( $i === 0 ),
				] );
				$i++;
			endwhile;
			?>
		</div>

		<?php brokar_pagination(); ?>

		<?php else : ?>
		<div class="no-results">
			<div class="no-results__icon">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
			</div>
			<h2><?php esc_html_e( 'Geen berichten gevonden', 'brokar' ); ?></h2>
			<p><?php esc_html_e( 'Probeer een andere categorie of gebruik de zoekfunctie.', 'brokar' ); ?></p>
			<?php get_search_form(); ?>
		</div>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>
