<?php
/**
 * Template Name: Over ons / About
 *
 * Pagina-sjabloon voor de "Over ons"-pagina van Brokar Cultureel Huis.
 * Inhoud is bewerkbaar via de WP-editor (klassiek) en via de
 * meta-boxen "Over ons — afbeeldingen" in de pagina-editor.
 *
 * Alle tekst wordt door het DeepL-systeem automatisch vertaald
 * op basis van de gekozen taal.
 *
 * @package Brokar
 */

get_header();

$pid    = get_the_ID();
$img1   = brokar_pb_get_img_url( $pid, 'about_img1', 'brokar-card' );
$img2   = brokar_pb_get_img_url( $pid, 'about_img2', 'brokar-wide' );
$img3   = brokar_pb_get_img_url( $pid, 'about_img3', 'brokar-card' );

// Hero-achtergrond: pagina-featured image of about_img1
$hero_bg = brokar_pb_get_img_url( $pid, 'page_hero_image', 'brokar-hero' )
	?: ( has_post_thumbnail( $pid ) ? get_the_post_thumbnail_url( $pid, 'brokar-hero' ) : $img1 );
?>

<!-- ═══════════════════════════════════════════════════════════
     PAGE HERO
     ═══════════════════════════════════════════════════════════ -->
<section class="page-hero page-hero--about" aria-label="<?php esc_attr_e( 'Over ons', 'brokar' ); ?>">
	<?php if ( $hero_bg ) : ?>
		<img src="<?php echo esc_url( $hero_bg ); ?>" class="page-hero__bg-img" alt="" loading="eager">
	<?php endif; ?>
	<div class="page-hero__overlay"></div>
	<div class="container page-hero__content" data-animate="fade-up">
		<span class="section-label"><?php esc_html_e( 'Wie wij zijn', 'brokar' ); ?></span>
		<h1 class="page-hero__title"><?php the_title(); ?></h1>
		<p class="page-hero__sub">
			<?php esc_html_e( 'Een ontmoetingsplek voor alle generaties, culturen en verhalen — geworteld in Antwerpen, verbonden met de wereld.', 'brokar' ); ?>
		</p>
	</div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     MISSIE & VERHAAL
     ═══════════════════════════════════════════════════════════ -->
<section class="about-mission section" data-bg="dark">
	<div class="container">
		<div class="about-mission__grid">
			<div class="about-mission__text" data-animate="fade-right">
				<span class="section-label"><?php esc_html_e( 'Ons Verhaal', 'brokar' ); ?></span>
				<h2 class="section-title">
					<?php esc_html_e( 'Brokar — de naam van een', 'brokar' ); ?>
					<em class="text-gold"><?php esc_html_e( 'geweven stof', 'brokar' ); ?></em>
				</h2>

				<?php if ( have_posts() ) : the_post(); ?>
					<?php if ( get_the_content() ) : ?>
						<div class="about-content wp-content">
							<?php the_content(); ?>
						</div>
					<?php else : ?>
						<div class="about-content">
							<p><?php esc_html_e( 'Net zoals brokaatweefsel zijde, goud en zilver vervlecht tot één prachtig geheel, brengt Brokar Cultureel Huis de diverse stemmen van Antwerpen samen. Elk mens is een draad; samen vormen we een rijke stof van verhalen, tradities en dromen.', 'brokar' ); ?></p>
							<p><?php esc_html_e( 'Gelegen in het hart van Antwerpen bieden wij een warme thuishaven voor iedereen: jong en oud, kunstenaar en bezoeker, local en vreemdeling. Brokar is een plek waar kunst, cultuur en gemeenschap samenkomen.', 'brokar' ); ?></p>
							<p><?php esc_html_e( 'Opgericht in 2019 is Brokar uitgegroeid tot een culturele ankerplaats in de Antwerpse binnenstad. Ons programma omvat meer dan 120 evenementen per jaar: concerten, lezingen, exposities, workshops en kinderateliers.', 'brokar' ); ?></p>
						</div>
					<?php endif; ?>
				<?php endif; ?>
			</div>

			<?php if ( $img1 ) : ?>
			<div class="about-mission__visual" data-animate="fade-left">
				<div class="about-img-wrap">
					<img src="<?php echo esc_url( $img1 ); ?>" alt="<?php esc_attr_e( 'Brokar — sfeerbeeld', 'brokar' ); ?>" loading="lazy">
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     STATS
     ═══════════════════════════════════════════════════════════ -->
<section class="about-stats section" data-bg="gold">
	<div class="container">
		<div class="about-stats__grid" data-animate="fade-up">
			<div class="about-stat">
				<strong class="about-stat__num">2019</strong>
				<span class="about-stat__label"><?php esc_html_e( 'Opgericht', 'brokar' ); ?></span>
			</div>
			<div class="about-stat">
				<strong class="about-stat__num">120<sup>+</sup></strong>
				<span class="about-stat__label"><?php esc_html_e( 'Evenementen per jaar', 'brokar' ); ?></span>
			</div>
			<div class="about-stat">
				<strong class="about-stat__num">8.000<sup>+</sup></strong>
				<span class="about-stat__label"><?php esc_html_e( 'Bezoekers per jaar', 'brokar' ); ?></span>
			</div>
			<div class="about-stat">
				<strong class="about-stat__num">4</strong>
				<span class="about-stat__label"><?php esc_html_e( 'Talen op de site', 'brokar' ); ?></span>
			</div>
		</div>
	</div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     MISSIE & WAARDEN
     ═══════════════════════════════════════════════════════════ -->
<section class="about-values section" data-bg="light">
	<div class="container">
		<div class="section-header text-center" data-animate="fade-up">
			<span class="section-label"><?php esc_html_e( 'Onze missie', 'brokar' ); ?></span>
			<h2 class="section-title"><?php esc_html_e( 'Waar wij voor staan', 'brokar' ); ?></h2>
		</div>

		<div class="about-values__grid">
			<?php
			$values = [
				[
					'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
					'title' => __( 'Gemeenschap', 'brokar' ),
					'desc'  => __( 'Wij geloven dat cultuur mensen verbindt. Brokar is een plek waar Antwerpenaren van alle achtergronden elkaar ontmoeten, inspireren en versterken.', 'brokar' ),
				],
				[
					'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>',
					'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>',
					'title' => __( 'Diversiteit', 'brokar' ),
					'desc'  => __( 'Onze programmering weerspiegelt de rijkdom van Antwerpen: meerdere talen, tradities en kunstvormen — samengeweven tot één levendig aanbod.', 'brokar' ),
				],
				[
					'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>',
					'title' => __( 'Kwaliteit', 'brokar' ),
					'desc'  => __( 'Van internationale kunstenaars tot lokaal talent — wij kiezen voor programma\'s die raken, verbazen en blijven hangen. Kwaliteit is onze norm.', 'brokar' ),
				],
				[
					'icon'  => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
					'title' => __( 'Toegankelijkheid', 'brokar' ),
					'desc'  => __( 'Cultuur is voor iedereen. Wij streven naar betaalbare toegang, inclusieve programma\'s en een ruimte waar elke bezoeker zich welkom voelt.', 'brokar' ),
				],
			];
			foreach ( $values as $i => $val ) :
			?>
			<div class="about-value-card" data-animate="fade-up" data-delay="<?php echo esc_attr( $i * 100 ); ?>">
				<div class="about-value-card__icon"><?php echo $val['icon']; // phpcs:ignore ?></div>
				<h3 class="about-value-card__title"><?php echo esc_html( $val['title'] ); ?></h3>
				<p class="about-value-card__desc"><?php echo esc_html( $val['desc'] ); ?></p>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<?php if ( $img2 || $img3 ) : ?>
<!-- ═══════════════════════════════════════════════════════════
     FOTOGALERIJ
     ═══════════════════════════════════════════════════════════ -->
<section class="about-gallery section" data-bg="dark">
	<div class="container">
		<div class="about-gallery__grid">
			<?php if ( $img2 ) : ?>
			<div class="about-gallery__item about-gallery__item--wide" data-animate="fade-up">
				<img src="<?php echo esc_url( $img2 ); ?>" alt="<?php esc_attr_e( 'Brokar — gebouw en evenementen', 'brokar' ); ?>" loading="lazy">
			</div>
			<?php endif; ?>
			<?php if ( $img3 ) : ?>
			<div class="about-gallery__item" data-animate="fade-up" data-delay="100">
				<img src="<?php echo esc_url( $img3 ); ?>" alt="<?php esc_attr_e( 'Brokar — publiek en activiteiten', 'brokar' ); ?>" loading="lazy">
			</div>
			<?php endif; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- ═══════════════════════════════════════════════════════════
     TEAM
     ═══════════════════════════════════════════════════════════ -->
<section class="about-team section" data-bg="dark">
	<div class="container">
		<div class="section-header text-center" data-animate="fade-up">
			<span class="section-label"><?php esc_html_e( 'De mensen achter Brokar', 'brokar' ); ?></span>
			<h2 class="section-title"><?php esc_html_e( 'Ons team', 'brokar' ); ?></h2>
		</div>

		<div class="about-team__grid">
			<?php
			$team = [
				[
					'name'  => 'Fatima El Moubaraki',
					'role'  => __( 'Artistiek Directeur', 'brokar' ),
					'bio'   => __( 'Fatima stuurt de artistieke visie van Brokar. Haar passie voor interculturele dialoog vormt de kern van ons programma.', 'brokar' ),
				],
				[
					'name'  => 'Thomas Vermeersch',
					'role'  => __( 'Zakelijk Directeur', 'brokar' ),
					'bio'   => __( 'Thomas beheert de dagelijkse werking en partnerships. Zijn netwerk maakt grootse projecten mogelijk.', 'brokar' ),
				],
				[
					'name'  => 'Laila Azzouzi',
					'role'  => __( 'Programmacoördinator', 'brokar' ),
					'bio'   => __( 'Laila stelt het jaarlijkse programma samen en begeleidt de kunstenaars van idee tot uitvoering.', 'brokar' ),
				],
				[
					'name'  => 'Koen De Backer',
					'role'  => __( 'Communicatieverantwoordelijke', 'brokar' ),
					'bio'   => __( 'Koen vertaalt de verhalen van Brokar naar het publiek via alle kanalen — online en offline.', 'brokar' ),
				],
			];
			foreach ( $team as $i => $member ) :
			?>
			<div class="team-card" data-animate="fade-up" data-delay="<?php echo esc_attr( $i * 80 ); ?>">
				<div class="team-card__avatar">
					<svg viewBox="0 0 80 80" fill="none" aria-hidden="true">
						<circle cx="40" cy="40" r="40" fill="rgba(201,168,76,0.1)"/>
						<circle cx="40" cy="30" r="14" stroke="#C9A84C" stroke-width="1.5"/>
						<path d="M10 72 Q40 52 70 72" stroke="#C9A84C" stroke-width="1.5" fill="none"/>
					</svg>
				</div>
				<h3 class="team-card__name"><?php echo esc_html( $member['name'] ); ?></h3>
				<span class="team-card__role"><?php echo esc_html( $member['role'] ); ?></span>
				<p class="team-card__bio"><?php echo esc_html( $member['bio'] ); ?></p>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>

<!-- ═══════════════════════════════════════════════════════════
     CTA
     ═══════════════════════════════════════════════════════════ -->
<section class="about-cta section" data-bg="gold">
	<div class="container text-center" data-animate="fade-up">
		<h2 class="section-title"><?php esc_html_e( 'Kom ons ontmoeten', 'brokar' ); ?></h2>
		<p style="max-width:55ch;margin-inline:auto;margin-bottom:2.5rem;font-size:1.125rem">
			<?php esc_html_e( 'Brokar staat open voor iedereen. Ontdek ons programma, schrijf in voor een workshop of bezoek gewoon onze tentoonstellingen.', 'brokar' ); ?>
		</p>
		<div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap">
			<a href="<?php echo esc_url( brokar_url( 'programma' ) ); ?>" class="btn btn--gold" style="background:var(--navy);border-color:var(--navy);color:var(--ivory)">
				<?php esc_html_e( 'Bekijk het programma', 'brokar' ); ?>
			</a>
			<a href="<?php echo esc_url( brokar_url( 'contact' ) ); ?>" class="btn btn--outline" style="border-color:var(--navy);color:var(--navy)">
				<?php esc_html_e( 'Neem contact op', 'brokar' ); ?>
			</a>
		</div>
	</div>
</section>

<?php get_footer(); ?>
