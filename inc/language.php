<?php
/**
 * Language Switcher & Locale Switching
 *
 * Priorität:
 *  1. Polylang  (Plugin aktiv)  → pll_the_languages()
 *  2. WPML      (Plugin aktiv)  → icl_get_languages()
 *  3. Eigene    (kein Plugin)   → ?lang= GET-Parameter + Cookie
 *     Der locale-Filter sorgt dafür, dass alle __()-Strings übersetzt werden.
 *
 * @package Brokar
 */

defined( 'ABSPATH' ) || exit;

// ─────────────────────────────────────────────────────────────
// Sprachkonfiguration
// ─────────────────────────────────────────────────────────────

/**
 * Unterstützte Sprachen: Sprachcode → WP-Locale
 */
function brokar_get_languages(): array {
	return [
		'nl' => [
			'label'  => 'NL',
			'name'   => 'Nederlands',
			'locale' => 'nl_NL',
			'hreflang' => 'nl',
		],
		'fr' => [
			'label'  => 'FR',
			'name'   => 'Français',
			'locale' => 'fr_FR',
			'hreflang' => 'fr',
		],
		'de' => [
			'label'  => 'DE',
			'name'   => 'Deutsch',
			'locale' => 'de_DE',
			'hreflang' => 'de',
		],
		'en' => [
			'label'  => 'EN',
			'name'   => 'English',
			'locale' => 'en_GB',
			'hreflang' => 'en',
		],
	];
}

// ─────────────────────────────────────────────────────────────
// Aktuelle Sprache ermitteln (ohne Plugin)
// ─────────────────────────────────────────────────────────────

function brokar_get_current_lang(): string {
	// Polylang
	if ( function_exists( 'pll_current_language' ) ) {
		return (string) pll_current_language( 'slug' );
	}
	// WPML
	if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
		return (string) ICL_LANGUAGE_CODE;
	}
	// GET-Parameter hat Priorität (direkte Auswahl)
	if ( isset( $_GET['lang'] ) ) {
		$lang = sanitize_key( wp_unslash( $_GET['lang'] ) );
		if ( array_key_exists( $lang, brokar_get_languages() ) ) {
			return $lang;
		}
	}
	// Cookie
	if ( isset( $_COOKIE['brokar_lang'] ) ) {
		$lang = sanitize_key( wp_unslash( $_COOKIE['brokar_lang'] ) );
		if ( array_key_exists( $lang, brokar_get_languages() ) ) {
			return $lang;
		}
	}
	// Fallback: Niederländisch
	return 'nl';
}

// ─────────────────────────────────────────────────────────────
// ?lang= → Cookie setzen (läuft sehr früh im init-Hook)
// ─────────────────────────────────────────────────────────────

function brokar_handle_lang_switch(): void {
	// Nur bei eigenem Fallback-Switcher nötig
	if ( function_exists( 'pll_current_language' ) || defined( 'ICL_LANGUAGE_CODE' ) ) {
		return;
	}

	if ( ! isset( $_GET['lang'] ) ) {
		return;
	}

	$lang = sanitize_key( wp_unslash( $_GET['lang'] ) );
	if ( ! array_key_exists( $lang, brokar_get_languages() ) ) {
		return;
	}

	// Cookie für ein Jahr setzen
	setcookie(
		'brokar_lang',
		$lang,
		[
			'expires'  => time() + YEAR_IN_SECONDS,
			'path'     => '/',
			'samesite' => 'Lax',
		]
	);
}
add_action( 'init', 'brokar_handle_lang_switch', 1 );

// ─────────────────────────────────────────────────────────────
// Locale-Filter: WP wirklich auf die gewählte Sprache umschalten
// ─────────────────────────────────────────────────────────────

function brokar_filter_locale( string $locale ): string {
	// Polylang / WPML übernehmen selbst die Locale → nichts tun
	if ( function_exists( 'pll_current_language' ) || defined( 'ICL_LANGUAGE_CODE' ) ) {
		return $locale;
	}

	$lang      = brokar_get_current_lang();
	$languages = brokar_get_languages();

	if ( isset( $languages[ $lang ] ) ) {
		return $languages[ $lang ]['locale'];
	}

	return $locale;
}
// Muss vor plugins_loaded laufen damit Textdomains richtig geladen werden
add_filter( 'locale', 'brokar_filter_locale' );

// ─────────────────────────────────────────────────────────────
// Textdomain neu laden wenn Locale sich ändert
// ─────────────────────────────────────────────────────────────

function brokar_reload_textdomain(): void {
	if ( function_exists( 'pll_current_language' ) || defined( 'ICL_LANGUAGE_CODE' ) ) {
		return;
	}
	// Theme-Textdomain mit richtiger Locale laden
	unload_textdomain( 'brokar' );
	load_theme_textdomain( 'brokar', BROKAR_DIR . '/languages' );
}
add_action( 'after_setup_theme', 'brokar_reload_textdomain', 20 );

// ─────────────────────────────────────────────────────────────
// hreflang-Tags im <head> ausgeben (SEO)
// ─────────────────────────────────────────────────────────────

function brokar_hreflang_tags(): void {
	$languages   = brokar_get_languages();
	$current_url = brokar_current_url_clean();

	foreach ( $languages as $code => $lang ) {
		$url = add_query_arg( 'lang', $code, $current_url );
		printf(
			'<link rel="alternate" hreflang="%s" href="%s">' . "\n",
			esc_attr( $lang['hreflang'] ),
			esc_url( $url )
		);
	}
	// x-default → Niederländisch
	$nl_url = add_query_arg( 'lang', 'nl', $current_url );
	printf( '<link rel="alternate" hreflang="x-default" href="%s">' . "\n", esc_url( $nl_url ) );
}
add_action( 'wp_head', 'brokar_hreflang_tags', 2 );

// ─────────────────────────────────────────────────────────────
// Switcher HTML rendern
// ─────────────────────────────────────────────────────────────

function brokar_language_switcher(): void {
	$languages = brokar_get_languages();

	// ── Polylang ─────────────────────────────────────────────
	if ( function_exists( 'pll_the_languages' ) ) {
		echo '<nav class="lang-switcher" aria-label="' . esc_attr__( 'Taal kiezen', 'brokar' ) . '">';
		echo '<ul class="lang-switcher__list">';
		pll_the_languages( [
			'show_flags'       => 0,
			'show_names'       => 0,
			'display_names_as' => 'slug',
			'hide_current'     => 0,
			'echo'             => 1,
		] );
		echo '</ul></nav>';
		return;
	}

	// ── WPML ─────────────────────────────────────────────────
	if ( function_exists( 'icl_get_languages' ) ) {
		$icl_langs = icl_get_languages( 'skip_missing=0&orderby=code' );
		if ( ! empty( $icl_langs ) ) {
			echo '<nav class="lang-switcher" aria-label="' . esc_attr__( 'Taal kiezen', 'brokar' ) . '">';
			echo '<ul class="lang-switcher__list">';
			foreach ( $icl_langs as $lang ) {
				$active_cls = $lang['active'] ? ' is-active' : '';
				printf(
					'<li class="lang-switcher__item%s"><a href="%s" class="lang-switcher__link" hreflang="%s">%s</a></li>',
					esc_attr( $active_cls ),
					esc_url( $lang['url'] ),
					esc_attr( $lang['language_code'] ),
					esc_html( strtoupper( $lang['language_code'] ) )
				);
			}
			echo '</ul></nav>';
		}
		return;
	}

	// ── Eigener Fallback-Switcher ─────────────────────────────
	$current     = brokar_get_current_lang();
	$current_url = brokar_current_url_clean();

	echo '<nav class="lang-switcher" aria-label="' . esc_attr__( 'Taal kiezen', 'brokar' ) . '">';
	echo '<ul class="lang-switcher__list">';
	foreach ( $languages as $code => $lang ) {
		$is_active  = ( $code === $current );
		$active_cls = $is_active ? ' is-active' : '';
		$url        = add_query_arg( 'lang', $code, $current_url );
		$aria       = $is_active ? ' aria-current="true"' : '';
		printf(
			'<li class="lang-switcher__item%s">'
			. '<a href="%s" class="lang-switcher__link" hreflang="%s" title="%s"%s>%s</a>'
			. '</li>',
			esc_attr( $active_cls ),
			esc_url( $url ),
			esc_attr( $lang['hreflang'] ),
			esc_attr( $lang['name'] ),
			$aria,
			esc_html( $lang['label'] )
		);
	}
	echo '</ul></nav>';
}

// ─────────────────────────────────────────────────────────────
// Hilfsfunktion: aktuelle URL ohne bestehenden ?lang=-Parameter
// ─────────────────────────────────────────────────────────────

function brokar_current_url_clean(): string {
	$scheme  = is_ssl() ? 'https' : 'http';
	$host    = isset( $_SERVER['HTTP_HOST'] ) ? wp_unslash( $_SERVER['HTTP_HOST'] ) : '';
	$request = isset( $_SERVER['REQUEST_URI'] ) ? wp_unslash( $_SERVER['REQUEST_URI'] ) : '/';
	$full    = $scheme . '://' . $host . $request;
	return remove_query_arg( 'lang', $full );
}
