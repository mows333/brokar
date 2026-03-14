<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Naar inhoud', 'brokar' ); ?></a>

<!-- ═══════════════════════════════════════════════════════════
     SITE HEADER
     ═══════════════════════════════════════════════════════════ -->
<header class="site-header" id="site-header" role="banner">
	<div class="site-header__inner container">

		<!-- Logo -->
		<div class="site-header__brand">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-header__logo-text" rel="home">
					<span class="site-header__logo-brokar">Brokar</span>
					<span class="site-header__logo-sub"><?php esc_html_e( 'Cultureel Huis', 'brokar' ); ?></span>
				</a>
			<?php endif; ?>
		</div>

		<!-- Primary Navigation -->
		<nav class="site-nav" id="site-nav" aria-label="<?php esc_attr_e( 'Primaire navigatie', 'brokar' ); ?>">
			<?php
			wp_nav_menu( [
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'site-nav__list',
				'fallback_cb'    => 'brokar_fallback_menu',
				'walker'         => new Brokar_Nav_Walker(),
				'depth'          => 3,
			] );
			?>
		</nav>

		<!-- Header Actions: Lang + CTA + Hamburger -->
		<div class="site-header__actions">
			<?php brokar_language_switcher(); ?>

			<a href="<?php echo esc_url( home_url( '/programma' ) ); ?>" class="btn btn--gold btn--sm site-header__cta">
				<?php esc_html_e( 'Programma', 'brokar' ); ?>
			</a>

			<button
				class="hamburger"
				id="hamburger"
				aria-controls="site-nav"
				aria-expanded="false"
				aria-label="<?php esc_attr_e( 'Menu openen', 'brokar' ); ?>"
			>
				<span class="hamburger__bar"></span>
				<span class="hamburger__bar"></span>
				<span class="hamburger__bar"></span>
			</button>
		</div>

	</div><!-- .site-header__inner -->

	<!-- Progress bar -->
	<div class="reading-progress" id="reading-progress" aria-hidden="true"></div>
</header>

<!-- Mobile overlay nav -->
<div class="mobile-nav-overlay" id="mobile-nav-overlay" aria-hidden="true">
	<nav class="mobile-nav" aria-label="<?php esc_attr_e( 'Mobiel menu', 'brokar' ); ?>">
		<?php
		wp_nav_menu( [
			'theme_location' => 'primary',
			'container'      => false,
			'menu_class'     => 'mobile-nav__list',
			'fallback_cb'    => false,
			'depth'          => 2,
		] );
		?>
		<div class="mobile-nav__lang">
			<?php brokar_language_switcher(); ?>
		</div>
		<div class="mobile-nav__contact">
			<p><?php echo esc_html( brokar_get_option( 'address', 'Nationalestraat 28, 2000 Antwerpen' ) ); ?></p>
			<a href="tel:<?php echo esc_attr( brokar_get_option( 'phone', '+3230000000' ) ); ?>">
				<?php echo esc_html( brokar_get_option( 'phone', '+32 (0)3 000 00 00' ) ); ?>
			</a>
		</div>
	</nav>
</div>

<div id="main" class="site-main">
<?php
function brokar_fallback_menu(): void {
	echo '<ul class="site-nav__list">';
	wp_list_pages( [ 'title_li' => '', 'echo' => 1 ] );
	echo '</ul>';
}
