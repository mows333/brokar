<?php
/**
 * Front Page Template
 *
 * @package Brokar
 */

get_header();
?>

<!-- ═══════════════════════════════════════════════════════════
     HERO SECTION
     ═══════════════════════════════════════════════════════════ -->
<section class="hero" id="hero" aria-label="<?php esc_attr_e( 'Hero sectie', 'brokar' ); ?>">
	<div class="hero__media">
		<?php if ( has_post_thumbnail() ) : ?>
			<?php the_post_thumbnail( 'brokar-hero', [ 'class' => 'hero__bg-img', 'alt' => '' ] ); ?>
		<?php else : ?>
			<div class="hero__bg-gradient"></div>
		<?php endif; ?>
		<div class="hero__overlay"></div>

		<!-- Brocade SVG motif -->
		<div class="hero__motif" aria-hidden="true">
			<svg viewBox="0 0 400 400" class="hero__motif-svg">
				<defs>
					<linearGradient id="goldGrad" x1="0%" y1="0%" x2="100%" y2="100%">
						<stop offset="0%" style="stop-color:#E8C96A;stop-opacity:1"/>
						<stop offset="100%" style="stop-color:#9B7A2E;stop-opacity:1"/>
					</linearGradient>
				</defs>
				<!-- Brocade diamond pattern -->
				<g stroke="url(#goldGrad)" fill="none" stroke-width="0.8" opacity="0.4">
					<rect x="100" y="100" width="200" height="200" transform="rotate(45 200 200)"/>
					<rect x="120" y="120" width="160" height="160" transform="rotate(45 200 200)"/>
					<rect x="150" y="150" width="100" height="100" transform="rotate(45 200 200)"/>
					<circle cx="200" cy="200" r="20"/>
					<circle cx="200" cy="200" r="8"/>
					<!-- Thread lines -->
					<line x1="200" y1="0"   x2="200" y2="400"/>
					<line x1="0"   y1="200" x2="400" y2="200"/>
					<line x1="0"   y1="0"   x2="400" y2="400" stroke-width="0.4"/>
					<line x1="400" y1="0"   x2="0"   y2="400" stroke-width="0.4"/>
				</g>
			</svg>
		</div>
	</div>

	<div class="hero__content container">
		<div class="hero__text" data-animate="fade-up">
			<span class="hero__eyebrow"><?php esc_html_e( 'Antwerpen', 'brokar' ); ?></span>
			<h1 class="hero__title">
				<span class="hero__title-line" data-split>
					<?php echo esc_html( get_bloginfo( 'name' ) ); ?>
				</span>
			</h1>
			<p class="hero__tagline">
				<?php echo esc_html( get_theme_mod( 'brokar_hero_tagline', __( 'Kunst. Cultuur. Gemeenschap.', 'brokar' ) ) ); ?>
			</p>
			<p class="hero__desc">
				<?php esc_html_e( 'Een ontmoetingsplek voor alle generaties, waar de draden van de gemeenschap worden samengeweven tot een kleurrijk tapijt van beleving.', 'brokar' ); ?>
			</p>
			<div class="hero__actions">
				<a href="<?php echo esc_url( home_url( '/programma' ) ); ?>" class="btn btn--gold btn--lg">
					<?php esc_html_e( 'Ontdek het programma', 'brokar' ); ?>
				</a>
				<a href="<?php echo esc_url( home_url( '/over-brokar' ) ); ?>" class="btn btn--outline btn--lg">
					<?php esc_html_e( 'Over Brokar', 'brokar' ); ?>
				</a>
			</div>
		</div>

		<div class="hero__scroll-indicator" aria-hidden="true">
			<div class="hero__scroll-line"></div>
			<span class="hero__scroll-text"><?php esc_html_e( 'Scroll', 'brokar' ); ?></span>
		</div>
	</div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     TICKER / UPCOMING EVENTS STRIP
     ═══════════════════════════════════════════════════════════ -->
<div class="event-ticker" aria-label="<?php esc_attr_e( 'Aankomende evenementen', 'brokar' ); ?>">
	<div class="event-ticker__label"><?php esc_html_e( 'Agenda', 'brokar' ); ?></div>
	<div class="event-ticker__track">
		<div class="event-ticker__inner" role="marquee" aria-live="off">
			<?php
			$ticker_events = [
				__( 'Expositie: Weven & Worden — 15 apr. t/m 15 jun.', 'brokar' ),
				__( 'Concert: Nacht van de Nacht — 28 apr. 20:00', 'brokar' ),
				__( 'Workshop: Islamitische Kalligrafie — 4 mei', 'brokar' ),
				__( 'Lezing: De Stad als Verhaal — 10 mei 19:30', 'brokar' ),
				__( 'Kinderatelier: Kleuren & Vormen — 18 mei', 'brokar' ),
				__( 'Expositie: Weven & Worden — 15 apr. t/m 15 jun.', 'brokar' ),
				__( 'Concert: Nacht van de Nacht — 28 apr. 20:00', 'brokar' ),
			];
			foreach ( $ticker_events as $event ) :
			?>
			<span class="event-ticker__item">
				<svg viewBox="0 0 8 8" aria-hidden="true"><circle cx="4" cy="4" r="3" fill="#C9A84C"/></svg>
				<?php echo esc_html( $event ); ?>
			</span>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<!-- ═══════════════════════════════════════════════════════════
     INTRO / ABOUT SECTION
     ═══════════════════════════════════════════════════════════ -->
<section class="intro-section section" data-bg="dark">
	<div class="container">
		<div class="intro-grid">
			<div class="intro-grid__text" data-animate="fade-right">
				<span class="section-label"><?php esc_html_e( 'Ons Verhaal', 'brokar' ); ?></span>
				<h2 class="section-title">
					<?php esc_html_e( 'Brokar — de naam van een', 'brokar' ); ?>
					<em class="text-gold"><?php esc_html_e( 'geweven stof', 'brokar' ); ?></em>
				</h2>
				<div class="intro-text">
					<p>
						<?php esc_html_e( 'Net zoals brokaatweefsel zijde, goud en zilver vervlecht tot één prachtig geheel, brengt Brokar Cultureel Huis de diverse stemmen van Antwerpen samen. Elk mens is een draad; samen vormen we een rijke stof van verhalen, tradities en dromen.', 'brokar' ); ?>
					</p>
					<p>
						<?php esc_html_e( 'Gelegen in het hart van Antwerpen bieden wij een warme thuishaven voor iedereen: jong en oud, kunstenaar en bezoeker, local en vreemdeling.', 'brokar' ); ?>
					</p>
				</div>
				<a href="<?php echo esc_url( home_url( '/over-brokar' ) ); ?>" class="btn btn--gold btn--outline">
					<?php esc_html_e( 'Meer over ons', 'brokar' ); ?>
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
				</a>
			</div>
			<div class="intro-grid__visual" data-animate="fade-left">
				<div class="intro-visual">
					<div class="intro-visual__img-wrap">
						<img src="<?php echo esc_url( BROKAR_URI . '/assets/images/intro-weaving.jpg' ); ?>" alt="<?php esc_attr_e( 'Brokaatweefsel detail', 'brokar' ); ?>" loading="lazy" class="intro-visual__img">
					</div>
					<div class="intro-visual__stat-card">
						<div class="stat-item">
							<strong class="stat-item__num" data-count="2019">2019</strong>
							<span class="stat-item__label"><?php esc_html_e( 'Opgericht', 'brokar' ); ?></span>
						</div>
						<div class="stat-divider"></div>
						<div class="stat-item">
							<strong class="stat-item__num" data-count="120">120<sup>+</sup></strong>
							<span class="stat-item__label"><?php esc_html_e( 'Evenementen / jaar', 'brokar' ); ?></span>
						</div>
						<div class="stat-divider"></div>
						<div class="stat-item">
							<strong class="stat-item__num" data-count="8000">8.000<sup>+</sup></strong>
							<span class="stat-item__label"><?php esc_html_e( 'Bezoekers / jaar', 'brokar' ); ?></span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     PILLARS / OFFER SECTION
     ═══════════════════════════════════════════════════════════ -->
<section class="pillars-section section" data-bg="light">
	<div class="container">
		<div class="section-header text-center" data-animate="fade-up">
			<span class="section-label"><?php esc_html_e( 'Wat wij bieden', 'brokar' ); ?></span>
			<h2 class="section-title"><?php esc_html_e( 'Vier draden, één weefsel', 'brokar' ); ?></h2>
		</div>

		<div class="pillars-grid">
			<?php
			$pillars = [
				[
					'icon'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>',
					'slug'    => 'exposities',
					'title'   => __( 'Exposities', 'brokar' ),
					'desc'    => __( 'Van hedendaagse beeldende kunst tot fotografie en installaties — onze galerij biedt een platform aan zowel gevestigde als opkomende kunstenaars uit Antwerpen en ver daarbuiten.', 'brokar' ),
					'cta'     => __( 'Bekijk exposities', 'brokar' ),
					'url'     => '/exposities',
					'num'     => '01',
				],
				[
					'icon'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/></svg>',
					'slug'    => 'concerten',
					'title'   => __( 'Concerten', 'brokar' ),
					'desc'    => __( 'Onze concertzaal verwelkomt jazz, wereldmuziek, klassiek en experimentele klanken. Muziek als universele taal die generaties en culturen verbindt.', 'brokar' ),
					'cta'     => __( 'Zie agenda', 'brokar' ),
					'url'     => '/concerten',
					'num'     => '02',
				],
				[
					'icon'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>',
					'slug'    => 'lezingen',
					'title'   => __( 'Lezingen', 'brokar' ),
					'desc'    => __( 'Auteurs, denkers en verhalenvertellers nemen u mee op reis door literatuur, geschiedenis en hedendaagse thema\'s. Elke lezing een uitnodiging tot dialoog.', 'brokar' ),
					'cta'     => __( 'Programma lezingen', 'brokar' ),
					'url'     => '/lezingen',
					'num'     => '03',
				],
				[
					'icon'    => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>',
					'slug'    => 'workshops',
					'title'   => __( 'Workshops', 'brokar' ),
					'desc'    => __( 'Doe-het-zelf met je handen: keramiek, textiel, kalligrafie, fotografie en nog veel meer. Workshops voor kinderen, tieners én volwassenen het hele jaar door.', 'brokar' ),
					'cta'     => __( 'Schrijf in', 'brokar' ),
					'url'     => '/workshops',
					'num'     => '04',
				],
			];

			foreach ( $pillars as $i => $pillar ) :
			?>
			<article class="pillar-card" data-animate="fade-up" data-delay="<?php echo $i * 100; ?>">
				<div class="pillar-card__num"><?php echo esc_html( $pillar['num'] ); ?></div>
				<div class="pillar-card__icon"><?php echo $pillar['icon']; ?></div>
				<h3 class="pillar-card__title"><?php echo esc_html( $pillar['title'] ); ?></h3>
				<p class="pillar-card__desc"><?php echo esc_html( $pillar['desc'] ); ?></p>
				<a href="<?php echo esc_url( home_url( $pillar['url'] ) ); ?>" class="pillar-card__link">
					<?php echo esc_html( $pillar['cta'] ); ?>
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
				</a>
			</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     FEATURED EVENTS
     ═══════════════════════════════════════════════════════════ -->
<section class="events-section section" data-bg="dark">
	<div class="container">
		<div class="section-header section-header--flex" data-animate="fade-up">
			<div>
				<span class="section-label"><?php esc_html_e( 'Agenda', 'brokar' ); ?></span>
				<h2 class="section-title"><?php esc_html_e( 'Aankomende evenementen', 'brokar' ); ?></h2>
			</div>
			<a href="<?php echo esc_url( home_url( '/programma' ) ); ?>" class="btn btn--gold btn--outline">
				<?php esc_html_e( 'Volledig programma', 'brokar' ); ?>
			</a>
		</div>

		<div class="events-list">
			<?php
			$events = [
				[
					'date_day'   => '28',
					'date_month' => __( 'APR', 'brokar' ),
					'time'       => '20:00',
					'cat'        => __( 'Concert', 'brokar' ),
					'title'      => __( 'Nacht van de Nacht', 'brokar' ),
					'desc'       => __( 'Een avond vol duisternis en licht, met live jazz en gesproken woord.', 'brokar' ),
					'venue'      => __( 'Concertzaal', 'brokar' ),
					'status'     => __( 'Beperkte plaatsen', 'brokar' ),
					'status_cls' => 'warning',
				],
				[
					'date_day'   => '04',
					'date_month' => __( 'MEI', 'brokar' ),
					'time'       => '14:00',
					'cat'        => __( 'Workshop', 'brokar' ),
					'title'      => __( 'Islamitische Kalligrafie', 'brokar' ),
					'desc'       => __( 'Ontdek de schoonheid van Arabische letters onder begeleiding van meester-kalligraaf Youssef El Idrissi.', 'brokar' ),
					'venue'      => __( 'Ateliersaal', 'brokar' ),
					'status'     => __( 'Vrije plaatsen', 'brokar' ),
					'status_cls' => 'available',
				],
				[
					'date_day'   => '10',
					'date_month' => __( 'MEI', 'brokar' ),
					'time'       => '19:30',
					'cat'        => __( 'Lezing', 'brokar' ),
					'title'      => __( 'De Stad als Verhaal', 'brokar' ),
					'desc'       => __( 'Schrijver en stedenbouwkundige Rachida Lamrabet over Antwerpen als palimpsest van identiteiten.', 'brokar' ),
					'venue'      => __( 'Grote Zaal', 'brokar' ),
					'status'     => __( 'Vrije plaatsen', 'brokar' ),
					'status_cls' => 'available',
				],
				[
					'date_day'   => '18',
					'date_month' => __( 'MEI', 'brokar' ),
					'time'       => '10:00',
					'cat'        => __( 'Kinderatelier', 'brokar' ),
					'title'      => __( 'Kleuren & Vormen', 'brokar' ),
					'desc'       => __( 'Een creatieve ochtend voor kinderen van 6 tot 12 jaar: schilderen, knippen en plakken.', 'brokar' ),
					'venue'      => __( 'Kinderruimte', 'brokar' ),
					'status'     => __( 'Inschrijven vereist', 'brokar' ),
					'status_cls' => 'required',
				],
			];
			foreach ( $events as $i => $evt ) :
			?>
			<div class="event-row" data-animate="fade-up" data-delay="<?php echo $i * 80; ?>">
				<div class="event-row__date">
					<span class="event-row__day"><?php echo esc_html( $evt['date_day'] ); ?></span>
					<span class="event-row__month"><?php echo esc_html( $evt['date_month'] ); ?></span>
				</div>
				<div class="event-row__body">
					<div class="event-row__meta">
						<span class="event-tag"><?php echo esc_html( $evt['cat'] ); ?></span>
						<span class="event-row__time">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
							<?php echo esc_html( $evt['time'] ); ?>
						</span>
						<span class="event-row__venue">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
							<?php echo esc_html( $evt['venue'] ); ?>
						</span>
					</div>
					<h3 class="event-row__title"><?php echo esc_html( $evt['title'] ); ?></h3>
					<p class="event-row__desc"><?php echo esc_html( $evt['desc'] ); ?></p>
				</div>
				<div class="event-row__action">
					<span class="event-status event-status--<?php echo esc_attr( $evt['status_cls'] ); ?>">
						<?php echo esc_html( $evt['status'] ); ?>
					</span>
					<a href="<?php echo esc_url( home_url( '/programma' ) ); ?>" class="btn btn--gold btn--sm">
						<?php esc_html_e( 'Meer info', 'brokar' ); ?>
					</a>
				</div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     FEATURED EXHIBITION (full-width)
     ═══════════════════════════════════════════════════════════ -->
<section class="feature-expo section" data-bg="dark" aria-label="<?php esc_attr_e( 'Uitgelichte expositie', 'brokar' ); ?>">
	<div class="feature-expo__media">
		<div class="feature-expo__img-placeholder"></div>
		<div class="feature-expo__overlay"></div>
	</div>
	<div class="container feature-expo__content">
		<div class="feature-expo__badge" data-animate="fade-up">
			<span><?php esc_html_e( 'Nu te zien', 'brokar' ); ?></span>
		</div>
		<h2 class="feature-expo__title" data-animate="fade-up" data-delay="100">
			<?php esc_html_e( 'Weven & Worden', 'brokar' ); ?>
		</h2>
		<p class="feature-expo__artist" data-animate="fade-up" data-delay="150">
			<?php esc_html_e( 'Leila Benali & Collective Draad', 'brokar' ); ?>
		</p>
		<p class="feature-expo__dates" data-animate="fade-up" data-delay="200">
			<?php esc_html_e( '15 april — 15 juni 2025', 'brokar' ); ?>
		</p>
		<p class="feature-expo__desc" data-animate="fade-up" data-delay="250">
			<?php esc_html_e( 'Een meeslepende installatie over migratie, identiteit en de kracht van gemeenschap, geweven uit duizenden verhalen van Antwerpenaren.', 'brokar' ); ?>
		</p>
		<a href="<?php echo esc_url( home_url( '/exposities/weven-en-worden' ) ); ?>" class="btn btn--gold btn--lg" data-animate="fade-up" data-delay="300">
			<?php esc_html_e( 'Ontdek de expositie', 'brokar' ); ?>
		</a>
	</div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     QUOTE SECTION
     ═══════════════════════════════════════════════════════════ -->
<section class="quote-section section" data-bg="gold">
	<div class="container">
		<blockquote class="hero-quote" data-animate="fade-up">
			<p class="hero-quote__text">
				<?php esc_html_e( '"Brokar is geen gebouw. Het is een weefgetouw waarop wij samen onze stad maken."', 'brokar' ); ?>
			</p>
			<footer class="hero-quote__footer">
				<cite><?php esc_html_e( '— Fatima El Moubaraki, Artistiek Directeur', 'brokar' ); ?></cite>
			</footer>
		</blockquote>
	</div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     LATEST BLOG POSTS
     ═══════════════════════════════════════════════════════════ -->
<section class="blog-section section" data-bg="light">
	<div class="container">
		<div class="section-header section-header--flex" data-animate="fade-up">
			<div>
				<span class="section-label"><?php esc_html_e( 'Nieuws & Verhalen', 'brokar' ); ?></span>
				<h2 class="section-title"><?php esc_html_e( 'Laatste berichten', 'brokar' ); ?></h2>
			</div>
			<a href="<?php echo esc_url( home_url( '/blog' ) ); ?>" class="btn btn--outline">
				<?php esc_html_e( 'Alle berichten', 'brokar' ); ?>
			</a>
		</div>

		<?php
		$blog_query = new WP_Query( [
			'posts_per_page' => 3,
			'post_status'    => 'publish',
			'orderby'        => 'date',
			'order'          => 'DESC',
		] );

		if ( $blog_query->have_posts() ) :
		?>
		<div class="blog-grid blog-grid--3">
			<?php
			$blog_index = 0;
			while ( $blog_query->have_posts() ) :
				$blog_query->the_post();
				get_template_part( 'template-parts/content/card', null, [ 'animate_delay' => $blog_index * 100 ] );
				$blog_index++;
			endwhile;
			wp_reset_postdata();
			?>
		</div>
		<?php endif; ?>
	</div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     CTA / VISIT US
     ═══════════════════════════════════════════════════════════ -->
<section class="visit-section section" data-bg="dark">
	<div class="container">
		<div class="visit-grid">
			<div class="visit-grid__info" data-animate="fade-right">
				<span class="section-label"><?php esc_html_e( 'Bezoek ons', 'brokar' ); ?></span>
				<h2 class="section-title"><?php esc_html_e( 'Vind ons in het hart van Antwerpen', 'brokar' ); ?></h2>
				<ul class="visit-details">
					<li class="visit-detail">
						<div class="visit-detail__icon">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
						</div>
						<div>
							<strong><?php esc_html_e( 'Adres', 'brokar' ); ?></strong>
							<span><?php echo esc_html( brokar_get_option( 'address', 'Nationalestraat 28, 2000 Antwerpen' ) ); ?></span>
						</div>
					</li>
					<li class="visit-detail">
						<div class="visit-detail__icon">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
						</div>
						<div>
							<strong><?php esc_html_e( 'Openingsuren', 'brokar' ); ?></strong>
							<span><?php echo esc_html( brokar_get_option( 'hours', 'Di–Zo: 10:00–18:00' ) ); ?></span>
						</div>
					</li>
					<li class="visit-detail">
						<div class="visit-detail__icon">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.61 3.41a2 2 0 0 1 1.95-2.18h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.96a16 16 0 0 0 6 6l.87-.87a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
						</div>
						<div>
							<strong><?php esc_html_e( 'Telefoon', 'brokar' ); ?></strong>
							<a href="tel:<?php echo esc_attr( str_replace( ' ', '', brokar_get_option( 'phone', '+3230000000' ) ) ); ?>">
								<?php echo esc_html( brokar_get_option( 'phone', '+32 (0)3 000 00 00' ) ); ?>
							</a>
						</div>
					</li>
					<li class="visit-detail">
						<div class="visit-detail__icon">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
						</div>
						<div>
							<strong><?php esc_html_e( 'E-mail', 'brokar' ); ?></strong>
							<a href="mailto:<?php echo esc_attr( brokar_get_option( 'email', 'info@brokar.be' ) ); ?>">
								<?php echo esc_html( brokar_get_option( 'email', 'info@brokar.be' ) ); ?>
							</a>
						</div>
					</li>
				</ul>
				<a href="<?php echo esc_url( home_url( '/contact' ) ); ?>" class="btn btn--gold">
					<?php esc_html_e( 'Stuur een bericht', 'brokar' ); ?>
				</a>
			</div>

			<div class="visit-grid__map" data-animate="fade-left">
				<div class="map-frame">
					<iframe
						src="https://www.openstreetmap.org/export/embed.html?bbox=4.39,51.21,4.42,51.22&layer=mapnik&marker=51.2155,4.4051"
						loading="lazy"
						title="<?php esc_attr_e( 'Kaart van Brokar Cultureel Huis', 'brokar' ); ?>"
						aria-label="<?php esc_attr_e( 'Kaart van Brokar Cultureel Huis', 'brokar' ); ?>"
					></iframe>
				</div>
			</div>
		</div>
	</div>
</section>

<?php get_footer(); ?>
