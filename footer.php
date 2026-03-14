</div><!-- #main -->

<!-- ═══════════════════════════════════════════════════════════
     SITE FOOTER
     ═══════════════════════════════════════════════════════════ -->
<footer class="site-footer" role="contentinfo">

	<!-- Newsletter Banner -->
	<div class="footer-newsletter">
		<div class="container">
			<div class="footer-newsletter__inner">
				<div class="footer-newsletter__text">
					<h2 class="footer-newsletter__title"><?php esc_html_e( 'Blijf op de hoogte', 'brokar' ); ?></h2>
					<p class="footer-newsletter__sub"><?php esc_html_e( 'Ontvang als eerste het laatste nieuws over exposities, concerten en workshops.', 'brokar' ); ?></p>
				</div>
				<form class="footer-newsletter__form" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="post">
					<?php wp_nonce_field( 'brokar_newsletter', 'newsletter_nonce' ); ?>
					<div class="footer-newsletter__field">
						<input
							type="email"
							name="newsletter_email"
							placeholder="<?php esc_attr_e( 'Uw e-mailadres', 'brokar' ); ?>"
							required
							class="footer-newsletter__input"
						>
						<button type="submit" class="btn btn--gold footer-newsletter__btn">
							<?php esc_html_e( 'Inschrijven', 'brokar' ); ?>
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<!-- Main Footer Grid -->
	<div class="footer-main">
		<div class="container">
			<div class="footer-grid">

				<!-- Col 1: Brand -->
				<div class="footer-grid__col footer-grid__col--brand">
					<?php if ( has_custom_logo() ) : ?>
						<?php the_custom_logo(); ?>
					<?php else : ?>
						<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="footer-logo">
							<span class="footer-logo__brokar">Brokar</span>
							<span class="footer-logo__sub"><?php esc_html_e( 'Cultureel Huis', 'brokar' ); ?></span>
						</a>
					<?php endif; ?>

					<p class="footer-tagline">
						<?php esc_html_e( 'Een ontmoetingsplek voor kunst, cultuur en gemeenschap in het hart van Antwerpen.', 'brokar' ); ?>
					</p>

					<!-- Social Links -->
					<div class="footer-social">
						<?php
						$socials = [
							'facebook'  => [ 'icon' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>', 'label' => 'Facebook' ],
							'instagram' => [ 'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/></svg>', 'label' => 'Instagram' ],
							'youtube'   => [ 'icon' => '<svg viewBox="0 0 24 24" fill="currentColor"><path d="M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46A2.78 2.78 0 0 0 1.46 6.42 29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58 2.78 2.78 0 0 0 1.95 1.96C5.12 20 12 20 12 20s6.88 0 8.59-.46a2.78 2.78 0 0 0 1.96-1.96A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58z"/><polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" fill="#0A1628"/></svg>', 'label' => 'YouTube' ],
						];
						foreach ( $socials as $key => $social ) :
							$url = brokar_get_option( "social_{$key}", '' );
							if ( $url ) :
						?>
						<a href="<?php echo esc_url( $url ); ?>" class="footer-social__link" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $social['label'] ); ?>">
							<?php echo $social['icon']; ?>
						</a>
						<?php
							endif;
						endforeach;
						?>
					</div>
				</div>

				<!-- Col 2: Navigation -->
				<div class="footer-grid__col footer-grid__col--nav">
					<h3 class="footer-col__title"><?php esc_html_e( 'Navigatie', 'brokar' ); ?></h3>
					<?php
					wp_nav_menu( [
						'theme_location' => 'secondary',
						'container'      => false,
						'menu_class'     => 'footer-nav__list',
						'fallback_cb'    => false,
						'depth'          => 1,
					] );
					?>
				</div>

				<!-- Col 3: Programma -->
				<div class="footer-grid__col footer-grid__col--program">
					<h3 class="footer-col__title"><?php esc_html_e( 'Ons Aanbod', 'brokar' ); ?></h3>
					<ul class="footer-nav__list">
						<li><a href="<?php echo esc_url( brokar_url( 'exposities' ) ); ?>"><?php esc_html_e( 'Exposities', 'brokar' ); ?></a></li>
						<li><a href="<?php echo esc_url( brokar_url( 'concerten' ) ); ?>"><?php esc_html_e( 'Concerten', 'brokar' ); ?></a></li>
						<li><a href="<?php echo esc_url( brokar_url( 'workshops' ) ); ?>"><?php esc_html_e( 'Workshops', 'brokar' ); ?></a></li>
						<li><a href="<?php echo esc_url( brokar_url( 'lezingen' ) ); ?>"><?php esc_html_e( 'Lezingen', 'brokar' ); ?></a></li>
						<li><a href="<?php echo esc_url( brokar_url( 'ruimtes-huren' ) ); ?>"><?php esc_html_e( 'Ruimtes huren', 'brokar' ); ?></a></li>
					</ul>
				</div>

				<!-- Col 4: Contact -->
				<div class="footer-grid__col footer-grid__col--contact">
					<h3 class="footer-col__title"><?php esc_html_e( 'Contact', 'brokar' ); ?></h3>
					<address class="footer-address">
						<p><?php echo esc_html( brokar_get_option( 'address', 'Nationalestraat 28, 2000 Antwerpen' ) ); ?></p>
						<p>
							<a href="tel:<?php echo esc_attr( str_replace( ' ', '', brokar_get_option( 'phone', '+3230000000' ) ) ); ?>">
								<?php echo esc_html( brokar_get_option( 'phone', '+32 (0)3 000 00 00' ) ); ?>
							</a>
						</p>
						<p>
							<a href="mailto:<?php echo esc_attr( brokar_get_option( 'email', 'info@brokar.be' ) ); ?>">
								<?php echo esc_html( brokar_get_option( 'email', 'info@brokar.be' ) ); ?>
							</a>
						</p>
						<p class="footer-hours">
							<strong><?php esc_html_e( 'Open:', 'brokar' ); ?></strong>
							<?php echo esc_html( brokar_get_option( 'hours', 'Di–Zo: 10:00–18:00' ) ); ?>
						</p>
					</address>

					<a href="https://maps.google.com/?q=Nationalestraat+28+Antwerpen" target="_blank" rel="noopener" class="footer-map-link">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
						<?php esc_html_e( 'Bekijk op kaart', 'brokar' ); ?>
					</a>
				</div>

			</div><!-- .footer-grid -->
		</div><!-- .container -->
	</div><!-- .footer-main -->

	<!-- Footer Bottom Bar -->
	<div class="footer-bottom">
		<div class="container">
			<div class="footer-bottom__inner">
				<p class="footer-bottom__copy">
					&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?>
					<a href="<?php echo esc_url( home_url( '/' ) ); ?>">Brokar Cultureel Huis</a>.
					<?php esc_html_e( 'Alle rechten voorbehouden.', 'brokar' ); ?>
				</p>
				<div class="footer-bottom__links">
					<a href="<?php echo esc_url( brokar_url( 'privacybeleid' ) ); ?>"><?php esc_html_e( 'Privacybeleid', 'brokar' ); ?></a>
					<a href="<?php echo esc_url( brokar_url( 'algemene-voorwaarden' ) ); ?>"><?php esc_html_e( 'Algemene voorwaarden', 'brokar' ); ?></a>
					<a href="<?php echo esc_url( brokar_url( 'cookies' ) ); ?>"><?php esc_html_e( 'Cookiebeleid', 'brokar' ); ?></a>
				</div>
				<div class="footer-bottom__lang">
					<?php brokar_language_switcher(); ?>
				</div>
			</div>
		</div>
	</div>

</footer>

<!-- Decorative threads (brocade motif) -->
<div class="brokar-threads" aria-hidden="true">
	<svg class="brokar-threads__svg" viewBox="0 0 1440 200" preserveAspectRatio="none">
		<path d="M0,100 C240,160 480,40 720,100 C960,160 1200,40 1440,100" stroke="#C9A84C" stroke-width="1" fill="none" opacity="0.15"/>
		<path d="M0,120 C240,60 480,180 720,120 C960,60 1200,180 1440,120" stroke="#C9A84C" stroke-width="0.5" fill="none" opacity="0.1"/>
	</svg>
</div>

<?php wp_footer(); ?>
</body>
</html>
