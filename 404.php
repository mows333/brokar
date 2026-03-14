<?php
/**
 * 404 Template
 *
 * @package Brokar
 */

get_header();
?>

<section class="error-404 section" data-bg="dark">
	<div class="container">
		<div class="error-404__inner" data-animate="fade-up">
			<div class="error-404__motif" aria-hidden="true">
				<svg viewBox="0 0 200 200" style="width:200px;opacity:0.1;">
					<g stroke="#C9A84C" fill="none" stroke-width="1">
						<rect x="40" y="40" width="120" height="120" transform="rotate(45 100 100)"/>
						<rect x="55" y="55" width="90" height="90" transform="rotate(45 100 100)"/>
						<circle cx="100" cy="100" r="15"/>
						<line x1="100" y1="0"   x2="100" y2="200"/>
						<line x1="0"   y1="100" x2="200" y2="100"/>
					</g>
				</svg>
			</div>

			<span class="section-label"><?php esc_html_e( 'Fout', 'brokar' ); ?></span>
			<h1 class="error-404__code">404</h1>
			<h2 class="error-404__title"><?php esc_html_e( 'Deze pagina bestaat niet', 'brokar' ); ?></h2>
			<p class="error-404__desc">
				<?php esc_html_e( 'Het lijkt erop dat de draad die u zocht ergens is afgeknipt. Laat ons u helpen de weg terug te vinden.', 'brokar' ); ?>
			</p>

			<div class="error-404__actions">
				<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn--gold btn--lg">
					<?php esc_html_e( 'Terug naar home', 'brokar' ); ?>
				</a>
				<a href="<?php echo esc_url( home_url( '/programma' ) ); ?>" class="btn btn--outline">
					<?php esc_html_e( 'Bekijk programma', 'brokar' ); ?>
				</a>
			</div>

			<div class="error-404__search" style="margin-top:2.5rem;">
				<?php get_search_form(); ?>
			</div>
		</div>
	</div>
</section>

<style>
.error-404__inner { text-align: center; padding: 3rem 0; }
.error-404__motif { margin-bottom: 1rem; }
.error-404__code {
  font-family: var(--font-serif);
  font-size: clamp(6rem, 20vw, 12rem);
  font-weight: 300;
  color: var(--gold);
  line-height: 1;
  margin-bottom: 0;
  opacity: 0.4;
}
.error-404__title { margin-bottom: 1.25rem; }
.error-404__desc {
  font-size: 1.0625rem;
  color: rgba(245,240,232,0.65);
  max-width: 48ch;
  margin: 0 auto 2.5rem;
}
.error-404__actions {
  display: flex;
  justify-content: center;
  gap: 1rem;
  flex-wrap: wrap;
}
.error-404__search { display: flex; justify-content: center; }
</style>

<?php get_footer(); ?>
