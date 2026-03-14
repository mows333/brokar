<?php
/**
 * Events Archive — /programma/
 *
 * @package Brokar
 */

get_header();

// Aktive Kategorie-Filter
$active_cat = isset( $_GET['categorie'] ) ? sanitize_text_field( wp_unslash( $_GET['categorie'] ) ) : '';
?>

<!-- Page Hero -->
<div class="page-hero page-hero--events">
	<div class="page-hero__overlay"></div>
	<div class="container page-hero__content">
		<span class="hero__eyebrow" data-animate="fade-up"><?php esc_html_e( 'Brokar Cultureel Huis', 'brokar' ); ?></span>
		<h1 class="page-hero__title" data-animate="fade-up" data-delay="80">
			<?php esc_html_e( 'Programma', 'brokar' ); ?>
		</h1>
		<p class="page-hero__sub" data-animate="fade-up" data-delay="150">
			<?php esc_html_e( 'Exposities, concerten, workshops en lezingen — het volledige aanbod van Brokar.', 'brokar' ); ?>
		</p>
	</div>
</div>

<!-- Filter Bar -->
<div class="events-filter" data-animate="fade-up">
	<div class="container">
		<div class="events-filter__inner">
			<div class="events-filter__cats">
				<a href="<?php echo esc_url( get_post_type_archive_link( 'brokar_event' ) ); ?>"
				   class="filter-btn <?php echo empty( $active_cat ) ? 'is-active' : ''; ?>">
					<?php esc_html_e( 'Alles', 'brokar' ); ?>
				</a>
				<?php
				$cats = get_terms( [ 'taxonomy' => 'event_category', 'hide_empty' => true ] );
				if ( ! is_wp_error( $cats ) ) :
					foreach ( $cats as $cat ) :
						$cat_url = add_query_arg( 'categorie', $cat->slug, get_post_type_archive_link( 'brokar_event' ) );
					?>
					<a href="<?php echo esc_url( $cat_url ); ?>"
					   class="filter-btn <?php echo ( $active_cat === $cat->slug ) ? 'is-active' : ''; ?>">
						<?php echo esc_html( $cat->name ); ?>
					</a>
					<?php
					endforeach;
				endif;
				?>
			</div>
			<div class="events-filter__search">
				<form method="get" action="<?php echo esc_url( get_post_type_archive_link( 'brokar_event' ) ); ?>" role="search">
					<input type="search" name="s"
						placeholder="<?php esc_attr_e( 'Evenement zoeken…', 'brokar' ); ?>"
						value="<?php echo esc_attr( get_search_query() ); ?>"
						class="events-filter__input">
					<button type="submit" class="events-filter__submit" aria-label="<?php esc_attr_e( 'Zoeken', 'brokar' ); ?>">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
					</button>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- Events Grid -->
<section class="events-archive section" data-bg="dark">
	<div class="container">
		<?php
		// Query met categorie-filter
		$paged = get_query_var( 'paged', 1 );
		$args  = [
			'post_type'      => 'brokar_event',
			'posts_per_page' => 12,
			'paged'          => $paged,
			'meta_key'       => '_event_date',
			'orderby'        => 'meta_value',
			'order'          => 'ASC',
		];

		if ( $active_cat ) {
			$args['tax_query'] = [ [
				'taxonomy' => 'event_category',
				'field'    => 'slug',
				'terms'    => $active_cat,
			] ];
		}

		$events_query = new WP_Query( $args );
		?>

		<?php if ( $events_query->have_posts() ) : ?>

		<div class="events-grid">
			<?php
			$i = 0;
			while ( $events_query->have_posts() ) :
				$events_query->the_post();
				$event_id  = get_the_ID();
				$date      = get_post_meta( $event_id, '_event_date', true );
				$date_end  = get_post_meta( $event_id, '_event_date_end', true );
				$time      = get_post_meta( $event_id, '_event_time', true );
				$time_end  = get_post_meta( $event_id, '_event_time_end', true );
				$venue     = get_post_meta( $event_id, '_event_venue', true );
				$status    = get_post_meta( $event_id, '_event_status', true );
				$price     = get_post_meta( $event_id, '_event_price', true );
				$tickets   = get_post_meta( $event_id, '_event_tickets_url', true );
				$featured  = get_post_meta( $event_id, '_event_featured', true );
				$status_cfg = brokar_event_status_config( $status );

				// Datum aufschlüsseln
				$date_obj   = $date ? new DateTime( $date ) : null;
				$day        = $date_obj ? $date_obj->format( 'd' ) : '';
				$month      = $date_obj ? date_i18n( 'M', $date_obj->getTimestamp() ) : '';

				// Kategorien
				$event_cats = get_the_terms( $event_id, 'event_category' );
				$cat_name   = ( ! is_wp_error( $event_cats ) && $event_cats ) ? $event_cats[0]->name : '';
			?>
			<article class="event-card <?php echo $featured ? 'event-card--featured' : ''; ?>"
			         data-animate="fade-up" data-delay="<?php echo esc_attr( ( $i % 3 ) * 100 ); ?>">

				<?php if ( has_post_thumbnail() ) : ?>
				<a href="<?php the_permalink(); ?>" class="event-card__thumb-link" tabindex="-1" aria-hidden="true">
					<figure class="event-card__thumb">
						<?php the_post_thumbnail( 'brokar-card', [ 'class' => 'event-card__img', 'alt' => '' ] ); ?>
						<div class="event-card__thumb-overlay"></div>
					</figure>
				</a>
				<?php endif; ?>

				<div class="event-card__body">
					<div class="event-card__top">
						<?php if ( $cat_name ) : ?>
						<span class="event-tag"><?php echo esc_html( $cat_name ); ?></span>
						<?php endif; ?>
						<?php if ( $status_cfg['label'] ) : ?>
						<span class="event-status event-status--<?php echo esc_attr( $status_cfg['cls'] ); ?>">
							<?php echo esc_html( $status_cfg['label'] ); ?>
						</span>
						<?php endif; ?>
					</div>

					<div class="event-card__date-block">
						<?php if ( $day ) : ?>
						<div class="event-card__date">
							<span class="event-card__day"><?php echo esc_html( $day ); ?></span>
							<span class="event-card__month"><?php echo esc_html( $month ); ?></span>
						</div>
						<?php endif; ?>
						<div class="event-card__info">
							<h2 class="event-card__title">
								<a href="<?php the_permalink(); ?>" class="event-card__title-link">
									<?php the_title(); ?>
								</a>
							</h2>
							<div class="event-card__meta">
								<?php if ( $time ) : ?>
								<span class="event-card__meta-item">
									<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
									<?php echo esc_html( $time ); if ( $time_end ) echo ' – ' . esc_html( $time_end ); ?>
								</span>
								<?php endif; ?>
								<?php if ( $venue ) : ?>
								<span class="event-card__meta-item">
									<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
									<?php echo esc_html( $venue ); ?>
								</span>
								<?php endif; ?>
								<?php if ( $price ) : ?>
								<span class="event-card__meta-item">
									<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
									<?php echo esc_html( $price ); ?>
								</span>
								<?php endif; ?>
							</div>
						</div>
					</div>

					<?php if ( get_the_excerpt() ) : ?>
					<p class="event-card__excerpt"><?php the_excerpt(); ?></p>
					<?php endif; ?>

					<div class="event-card__actions">
						<a href="<?php the_permalink(); ?>" class="btn btn--outline btn--sm">
							<?php esc_html_e( 'Meer info', 'brokar' ); ?>
						</a>
						<?php if ( $tickets && $status !== 'soldout' ) : ?>
						<a href="<?php echo esc_url( $tickets ); ?>" class="btn btn--gold btn--sm" target="_blank" rel="noopener">
							<?php
							echo esc_html( $status === 'required'
								? __( 'Inschrijven', 'brokar' )
								: __( 'Tickets', 'brokar' ) );
							?>
						</a>
						<?php endif; ?>
					</div>
				</div>
			</article>
			<?php
				$i++;
			endwhile;
			wp_reset_postdata();
			?>
		</div>

		<?php
		// Pagination
		$big = 999999;
		$pages = paginate_links( [
			'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
			'format'    => '?paged=%#%',
			'current'   => max( 1, $paged ),
			'total'     => $events_query->max_num_pages,
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
				<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
			</div>
			<h2><?php esc_html_e( 'Geen evenementen gevonden', 'brokar' ); ?></h2>
			<p><?php esc_html_e( 'Er zijn momenteel geen evenementen gepland in deze categorie. Kom later terug!', 'brokar' ); ?></p>
			<a href="<?php echo esc_url( get_post_type_archive_link( 'brokar_event' ) ); ?>" class="btn btn--gold">
				<?php esc_html_e( 'Alle evenementen', 'brokar' ); ?>
			</a>
		</div>
		<?php endif; ?>
	</div>
</section>

<?php get_footer(); ?>
