<?php
/**
 * Blog Archive Template (Static front page → Posts page)
 *
 * @package Brokar
 */

get_header();
?>

<!-- Page Hero -->
<div class="page-hero page-hero--blog">
	<div class="page-hero__overlay"></div>
	<div class="container page-hero__content">
		<span class="hero__eyebrow" data-animate="fade-up"><?php esc_html_e( 'Brokar Cultureel Huis', 'brokar' ); ?></span>
		<h1 class="page-hero__title" data-animate="fade-up" data-delay="80">
			<?php esc_html_e( 'Nieuws & Verhalen', 'brokar' ); ?>
		</h1>
		<p class="page-hero__sub" data-animate="fade-up" data-delay="150">
			<?php esc_html_e( 'Verslagen, achtergronden en verhalen uit het hart van Brokar.', 'brokar' ); ?>
		</p>
	</div>
</div>

<!-- Blog Filter Bar -->
<div class="blog-filter" data-animate="fade-up">
	<div class="container">
		<div class="blog-filter__inner">
			<?php
			$active_cat_blog = get_query_var( 'cat' );
			$blog_cats = get_categories( [ 'hide_empty' => true ] );
			?>
			<a href="<?php echo esc_url( get_permalink( get_option( 'page_for_posts' ) ) ); ?>"
			   class="filter-btn <?php echo empty( $active_cat_blog ) ? 'is-active' : ''; ?>">
				<?php esc_html_e( 'Alles', 'brokar' ); ?>
			</a>
			<?php foreach ( $blog_cats as $bcat ) : ?>
			<a href="<?php echo esc_url( get_category_link( $bcat->term_id ) ); ?>"
			   class="filter-btn <?php echo ( (int) $active_cat_blog === $bcat->term_id ) ? 'is-active' : ''; ?>">
				<?php echo esc_html( $bcat->name ); ?>
			</a>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<!-- Blog Grid -->
<section class="blog-archive section" data-bg="dark">
	<div class="container">
		<?php if ( have_posts() ) : ?>

		<div class="blog-grid blog-grid--3">
			<?php
			$idx = 0;
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content/card', null, [
					'animate_delay' => ( $idx % 3 ) * 100,
					'featured'      => ( $idx === 0 ),
				] );
				$idx++;
			endwhile;
			?>
		</div>

		<?php
		// Pagination
		$big   = 999999;
		$pages = paginate_links( [
			'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format'    => '?paged=%#%',
			'current'   => max( 1, get_query_var( 'paged' ) ),
			'total'     => $GLOBALS['wp_query']->max_num_pages,
			'prev_text' => '&larr;',
			'next_text' => '&rarr;',
			'type'      => 'array',
		] );
		if ( $pages ) :
		?>
		<nav class="pagination" aria-label="<?php esc_attr_e( 'Paginering', 'brokar' ); ?>">
			<ul class="pagination__list">
				<?php foreach ( $pages as $page ) echo '<li class="pagination__item">' . $page . '</li>'; ?>
			</ul>
		</nav>
		<?php endif; ?>

		<?php else : ?>
		<div class="no-results">
			<div class="no-results__icon">
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
			</div>
			<h2><?php esc_html_e( 'Geen berichten gevonden', 'brokar' ); ?></h2>
			<p><?php esc_html_e( 'Er zijn momenteel geen berichten gepubliceerd. Kom later terug!', 'brokar' ); ?></p>
		</div>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>
