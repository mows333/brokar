<?php
/**
 * Main template file – fallback
 *
 * @package Brokar
 */

get_header();
?>

<section class="archive-section">
	<div class="container">
		<header class="archive-header">
			<?php
			if ( is_home() && ! is_front_page() ) {
				echo '<h1 class="archive-header__title">' . esc_html__( 'Blog', 'brokar' ) . '</h1>';
			} elseif ( is_archive() ) {
				the_archive_title( '<h1 class="archive-header__title">', '</h1>' );
				the_archive_description( '<div class="archive-header__desc">', '</div>' );
			} elseif ( is_search() ) {
				printf(
					'<h1 class="archive-header__title">%s <em>"%s"</em></h1>',
					esc_html__( 'Zoekresultaten voor', 'brokar' ),
					esc_html( get_search_query() )
				);
			} else {
				echo '<h1 class="archive-header__title">' . esc_html__( 'Nieuws & Blog', 'brokar' ) . '</h1>';
			}
			?>
		</header>

		<?php if ( have_posts() ) : ?>
			<div class="post-grid">
				<?php
				while ( have_posts() ) :
					the_post();
					get_template_part( 'template-parts/content/card' );
				endwhile;
				?>
			</div>

			<?php brokar_pagination(); ?>

		<?php else : ?>
			<div class="no-results">
				<p><?php esc_html_e( 'Geen berichten gevonden.', 'brokar' ); ?></p>
				<?php get_search_form(); ?>
			</div>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>
