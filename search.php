<?php
/**
 * Search Results Template
 *
 * @package Brokar
 */

get_header();
?>

<section class="search-results-section section" data-bg="light">
	<div class="container">
		<header class="archive-hero" style="padding-bottom:2rem;">
			<span class="section-label"><?php esc_html_e( 'Zoekresultaten', 'brokar' ); ?></span>
			<h1 class="archive-hero__title">
				<?php
				printf(
					/* translators: %s: search query */
					esc_html__( 'Resultaten voor: "%s"', 'brokar' ),
					'<em>' . esc_html( get_search_query() ) . '</em>'
				);
				?>
			</h1>
		</header>

		<?php get_search_form(); ?>

		<?php if ( have_posts() ) : ?>
			<div class="blog-grid blog-grid--3" style="margin-top:3rem;">
				<?php while ( have_posts() ) : the_post(); ?>
					<?php get_template_part( 'template-parts/content/card' ); ?>
				<?php endwhile; ?>
			</div>
			<?php brokar_pagination(); ?>
		<?php else : ?>
			<div class="no-results" style="padding-top:3rem;">
				<p><?php esc_html_e( 'Geen resultaten gevonden. Probeer een andere zoekterm.', 'brokar' ); ?></p>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>
