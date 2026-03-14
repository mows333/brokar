<?php
/**
 * Template Tag Helpers
 *
 * @package Brokar
 */

defined( 'ABSPATH' ) || exit;

/**
 * Resolve a page URL by slug.
 * Uses get_page_by_path() — so it works with any WordPress page.
 * Falls back gracefully to home_url( '/slug/' ) if the page doesn't exist yet.
 */
function brokar_url( string $slug ): string {
	$page = get_page_by_path( $slug );
	if ( $page ) {
		return (string) get_permalink( $page->ID );
	}
	// Fallback: just append slug to home URL
	return trailingslashit( home_url( '/' . ltrim( $slug, '/' ) ) );
}

/**
 * Render post meta (date, author, category)
 */
function brokar_post_meta( bool $show_cat = true ): void {
	$date = sprintf(
		'<time class="post-meta__date" datetime="%1$s">%2$s</time>',
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date( get_option( 'date_format' ) ) )
	);

	$author = sprintf(
		'<span class="post-meta__author">%s</span>',
		esc_html( get_the_author() )
	);

	echo '<div class="post-meta">' . $date . $author;

	if ( $show_cat ) {
		$cats = get_the_category();
		if ( $cats ) {
			$cat = array_shift( $cats );
			printf(
				'<a class="post-meta__cat" href="%s">%s</a>',
				esc_url( get_category_link( $cat->term_id ) ),
				esc_html( $cat->name )
			);
		}
	}

	echo '</div>';
}

/**
 * Render post thumbnail with link wrapper
 */
function brokar_post_thumbnail( string $size = 'brokar-card' ): void {
	if ( ! has_post_thumbnail() ) {
		return;
	}
	echo '<figure class="post-thumbnail">';
	if ( is_singular() ) {
		the_post_thumbnail( $size, [ 'class' => 'post-thumbnail__img' ] );
	} else {
		printf(
			'<a href="%s" class="post-thumbnail__link" tabindex="-1" aria-hidden="true">%s</a>',
			esc_url( get_permalink() ),
			get_the_post_thumbnail( null, $size, [ 'class' => 'post-thumbnail__img' ] )
		);
	}
	echo '</figure>';
}

/**
 * Social share links
 */
function brokar_social_share(): void {
	$url   = urlencode( get_permalink() );
	$title = urlencode( get_the_title() );
	?>
	<div class="social-share">
		<span class="social-share__label"><?php esc_html_e( 'Delen', 'brokar' ); ?></span>
		<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>" target="_blank" rel="noopener" class="social-share__link social-share__link--fb" aria-label="Facebook">
			<svg viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
		</a>
		<a href="https://twitter.com/intent/tweet?url=<?php echo $url; ?>&text=<?php echo $title; ?>" target="_blank" rel="noopener" class="social-share__link social-share__link--tw" aria-label="Twitter">
			<svg viewBox="0 0 24 24" fill="currentColor"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"/></svg>
		</a>
		<a href="mailto:?subject=<?php echo $title; ?>&body=<?php echo $url; ?>" class="social-share__link social-share__link--mail" aria-label="E-mail">
			<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
		</a>
	</div>
	<?php
}

/**
 * Pagination
 */
function brokar_pagination(): void {
	$links = paginate_links( [
		'prev_text' => '&larr;',
		'next_text' => '&rarr;',
		'type'      => 'array',
	] );

	if ( ! $links ) {
		return;
	}

	echo '<nav class="pagination" aria-label="' . esc_attr__( 'Paginering', 'brokar' ) . '">';
	echo '<ul class="pagination__list">';
	foreach ( $links as $link ) {
		echo '<li class="pagination__item">' . $link . '</li>';
	}
	echo '</ul></nav>';
}

/**
 * Reading time estimate
 */
function brokar_reading_time(): void {
	$content = get_the_content();
	$words   = str_word_count( strip_tags( $content ) );
	$minutes = (int) ceil( $words / 200 );
	printf(
		'<span class="reading-time">%d %s</span>',
		$minutes,
		esc_html( _n( 'min. lezen', 'min. lezen', $minutes, 'brokar' ) )
	);
}
