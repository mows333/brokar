<?php
/**
 * Single Event Template
 *
 * @package Brokar
 */

get_header();

while ( have_posts() ) :
	the_post();
	$event_id  = get_the_ID();
	$date      = get_post_meta( $event_id, '_event_date', true );
	$date_end  = get_post_meta( $event_id, '_event_date_end', true );
	$time      = get_post_meta( $event_id, '_event_time', true );
	$time_end  = get_post_meta( $event_id, '_event_time_end', true );
	$venue     = get_post_meta( $event_id, '_event_venue', true );
	$status    = get_post_meta( $event_id, '_event_status', true );
	$price     = get_post_meta( $event_id, '_event_price', true );
	$tickets   = get_post_meta( $event_id, '_event_tickets_url', true );
	$status_cfg = brokar_event_status_config( $status );
	$event_cats = get_the_terms( $event_id, 'event_category' );
	$cat_name   = ( ! is_wp_error( $event_cats ) && $event_cats ) ? $event_cats[0]->name : '';
?>

<!-- Event Hero -->
<div class="event-hero">
	<?php if ( has_post_thumbnail() ) : ?>
	<div class="event-hero__media">
		<?php the_post_thumbnail( 'brokar-hero', [ 'class' => 'event-hero__img', 'alt' => '' ] ); ?>
		<div class="event-hero__overlay"></div>
	</div>
	<?php else : ?>
	<div class="event-hero__media event-hero__media--gradient"></div>
	<?php endif; ?>

	<div class="container event-hero__content">
		<div data-animate="fade-up">
			<?php if ( $cat_name ) : ?>
			<span class="event-tag"><?php echo esc_html( $cat_name ); ?></span>
			<?php endif; ?>
			<h1 class="event-hero__title"><?php the_title(); ?></h1>
			<?php if ( $date ) : ?>
			<p class="event-hero__date"><?php echo esc_html( brokar_event_date_string( $event_id ) ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</div>

<!-- Event Content + Sidebar -->
<div class="event-layout section" data-bg="dark">
	<div class="container">
		<div class="event-layout__grid">

			<!-- Main Content -->
			<div class="event-layout__main" data-animate="fade-right">
				<div class="entry-content" style="color:rgba(245,240,232,0.85);">
					<?php the_content(); ?>
				</div>

				<?php brokar_social_share(); ?>

				<!-- Back link -->
				<a href="<?php echo esc_url( get_post_type_archive_link( 'brokar_event' ) ); ?>"
				   class="event-back-link">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
					<?php esc_html_e( 'Terug naar programma', 'brokar' ); ?>
				</a>
			</div>

			<!-- Sidebar: Details -->
			<aside class="event-layout__sidebar" data-animate="fade-left">
				<div class="event-detail-card">
					<h2 class="event-detail-card__title"><?php esc_html_e( 'Praktisch', 'brokar' ); ?></h2>

					<ul class="event-detail-list">
						<?php if ( $date ) : ?>
						<li class="event-detail-item">
							<div class="event-detail-item__icon">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
							</div>
							<div>
								<span class="event-detail-item__label"><?php esc_html_e( 'Datum', 'brokar' ); ?></span>
								<span class="event-detail-item__value"><?php echo esc_html( brokar_event_date_string( $event_id ) ); ?></span>
							</div>
						</li>
						<?php endif; ?>

						<?php if ( $time ) : ?>
						<li class="event-detail-item">
							<div class="event-detail-item__icon">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
							</div>
							<div>
								<span class="event-detail-item__label"><?php esc_html_e( 'Aanvang', 'brokar' ); ?></span>
								<span class="event-detail-item__value">
									<?php echo esc_html( $time );
									if ( $time_end ) echo ' – ' . esc_html( $time_end ); ?>
								</span>
							</div>
						</li>
						<?php endif; ?>

						<?php if ( $venue ) : ?>
						<li class="event-detail-item">
							<div class="event-detail-item__icon">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
							</div>
							<div>
								<span class="event-detail-item__label"><?php esc_html_e( 'Locatie', 'brokar' ); ?></span>
								<span class="event-detail-item__value"><?php echo esc_html( $venue ); ?></span>
							</div>
						</li>
						<?php endif; ?>

						<?php if ( $price ) : ?>
						<li class="event-detail-item">
							<div class="event-detail-item__icon">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
							</div>
							<div>
								<span class="event-detail-item__label"><?php esc_html_e( 'Toegang', 'brokar' ); ?></span>
								<span class="event-detail-item__value"><?php echo esc_html( $price ); ?></span>
							</div>
						</li>
						<?php endif; ?>

						<?php if ( $status_cfg['label'] ) : ?>
						<li class="event-detail-item">
							<div class="event-detail-item__icon">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
							</div>
							<div>
								<span class="event-detail-item__label"><?php esc_html_e( 'Beschikbaarheid', 'brokar' ); ?></span>
								<span class="event-status event-status--<?php echo esc_attr( $status_cfg['cls'] ); ?>">
									<?php echo esc_html( $status_cfg['label'] ); ?>
								</span>
							</div>
						</li>
						<?php endif; ?>
					</ul>

					<!-- CTA -->
					<div class="event-detail-card__cta">
						<?php if ( $tickets && $status !== 'soldout' ) : ?>
						<a href="<?php echo esc_url( $tickets ); ?>" class="btn btn--gold btn--lg" target="_blank" rel="noopener" style="width:100%;justify-content:center;">
							<?php
							echo esc_html( $status === 'required'
								? __( 'Inschrijven', 'brokar' )
								: ( $price === 'Gratis' || $status === 'free'
									? __( 'Gratis deelnemen', 'brokar' )
									: __( 'Tickets kopen', 'brokar' ) ) );
							?>
						</a>
						<?php elseif ( $status === 'soldout' ) : ?>
						<div class="event-soldout">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
							<?php esc_html_e( 'Dit evenement is uitverkocht', 'brokar' ); ?>
						</div>
						<?php endif; ?>
					</div>

					<!-- Contact info -->
					<div class="event-detail-card__contact">
						<p><?php esc_html_e( 'Vragen? Neem contact op:', 'brokar' ); ?></p>
						<a href="mailto:<?php echo esc_attr( brokar_get_option( 'email', 'info@brokar.be' ) ); ?>">
							<?php echo esc_html( brokar_get_option( 'email', 'info@brokar.be' ) ); ?>
						</a>
					</div>
				</div>
			</aside>

		</div>
	</div>
</div>

<!-- Related Events -->
<?php
$related = new WP_Query( [
	'post_type'      => 'brokar_event',
	'posts_per_page' => 3,
	'post__not_in'   => [ $event_id ],
	'meta_key'       => '_event_date',
	'orderby'        => 'meta_value',
	'order'          => 'ASC',
] );
if ( $related->have_posts() ) :
?>
<section class="section" data-bg="dark" style="padding-top:0;">
	<div class="container">
		<h2 class="section-title" style="margin-bottom:2rem;">
			<?php esc_html_e( 'Meer evenementen', 'brokar' ); ?>
		</h2>
		<div class="events-grid events-grid--3">
			<?php
			while ( $related->have_posts() ) :
				$related->the_post();
				$r_id    = get_the_ID();
				$r_date  = get_post_meta( $r_id, '_event_date', true );
				$r_time  = get_post_meta( $r_id, '_event_time', true );
				$r_venue = get_post_meta( $r_id, '_event_venue', true );
				$r_stat  = get_post_meta( $r_id, '_event_status', true );
				$r_scfg  = brokar_event_status_config( $r_stat );
				$r_cats  = get_the_terms( $r_id, 'event_category' );
				$r_cat   = ( ! is_wp_error( $r_cats ) && $r_cats ) ? $r_cats[0]->name : '';
				$r_dobj  = $r_date ? new DateTime( $r_date ) : null;
			?>
			<article class="event-card">
				<?php if ( has_post_thumbnail() ) : ?>
				<a href="<?php the_permalink(); ?>" class="event-card__thumb-link" tabindex="-1">
					<figure class="event-card__thumb">
						<?php the_post_thumbnail( 'brokar-card', [ 'class' => 'event-card__img', 'alt' => '' ] ); ?>
						<div class="event-card__thumb-overlay"></div>
					</figure>
				</a>
				<?php endif; ?>
				<div class="event-card__body">
					<div class="event-card__top">
						<?php if ( $r_cat ) echo '<span class="event-tag">' . esc_html( $r_cat ) . '</span>'; ?>
					</div>
					<div class="event-card__date-block">
						<?php if ( $r_dobj ) : ?>
						<div class="event-card__date">
							<span class="event-card__day"><?php echo esc_html( $r_dobj->format( 'd' ) ); ?></span>
							<span class="event-card__month"><?php echo esc_html( date_i18n( 'M', $r_dobj->getTimestamp() ) ); ?></span>
						</div>
						<?php endif; ?>
						<div class="event-card__info">
							<h3 class="event-card__title"><a href="<?php the_permalink(); ?>" class="event-card__title-link"><?php the_title(); ?></a></h3>
							<div class="event-card__meta">
								<?php if ( $r_time ) : ?><span class="event-card__meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg><?php echo esc_html( $r_time ); ?></span><?php endif; ?>
								<?php if ( $r_venue ) : ?><span class="event-card__meta-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg><?php echo esc_html( $r_venue ); ?></span><?php endif; ?>
							</div>
						</div>
					</div>
					<div class="event-card__actions">
						<a href="<?php the_permalink(); ?>" class="btn btn--outline btn--sm"><?php esc_html_e( 'Meer info', 'brokar' ); ?></a>
					</div>
				</div>
			</article>
			<?php
			endwhile;
			wp_reset_postdata();
			?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>
