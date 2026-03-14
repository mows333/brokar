<?php
/**
 * Language Switcher
 * Works with Polylang & WPML. Falls back to custom cookie-based switcher.
 *
 * @package Brokar
 */

defined( 'ABSPATH' ) || exit;

/**
 * Supported languages config
 */
function brokar_get_languages(): array {
	return [
		'nl' => [ 'label' => 'NL', 'name' => 'Nederlands',  'flag' => '🇳🇱' ],
		'fr' => [ 'label' => 'FR', 'name' => 'Français',    'flag' => '🇫🇷' ],
		'de' => [ 'label' => 'DE', 'name' => 'Deutsch',     'flag' => '🇩🇪' ],
		'en' => [ 'label' => 'EN', 'name' => 'English',     'flag' => '🇬🇧' ],
	];
}

/**
 * Render language switcher HTML
 */
function brokar_language_switcher(): void {
	$languages = brokar_get_languages();

	// Polylang
	if ( function_exists( 'pll_the_languages' ) ) {
		echo '<nav class="lang-switcher" aria-label="' . esc_attr__( 'Taal kiezen', 'brokar' ) . '">';
		echo '<ul class="lang-switcher__list">';
		pll_the_languages( [
			'show_flags'    => 0,
			'show_names'    => 0,
			'display_names_as' => 'slug',
			'hide_current'  => 0,
			'echo'          => 1,
		] );
		echo '</ul></nav>';
		return;
	}

	// WPML
	if ( function_exists( 'icl_get_languages' ) ) {
		$icl_langs = icl_get_languages( 'skip_missing=0&orderby=code' );
		if ( ! empty( $icl_langs ) ) {
			echo '<nav class="lang-switcher" aria-label="' . esc_attr__( 'Taal kiezen', 'brokar' ) . '">';
			echo '<ul class="lang-switcher__list">';
			foreach ( $icl_langs as $lang ) {
				$active = $lang['active'] ? ' is-active' : '';
				printf(
					'<li class="lang-switcher__item%s"><a href="%s" class="lang-switcher__link" hreflang="%s">%s</a></li>',
					esc_attr( $active ),
					esc_url( $lang['url'] ),
					esc_attr( $lang['language_code'] ),
					esc_html( strtoupper( $lang['language_code'] ) )
				);
			}
			echo '</ul></nav>';
		}
		return;
	}

	// Fallback: JS-based switcher (visual only, works with Polylang/WPML URLs or page slugs)
	$current = brokar_get_current_lang();
	echo '<nav class="lang-switcher" aria-label="' . esc_attr__( 'Taal kiezen', 'brokar' ) . '">';
	echo '<ul class="lang-switcher__list">';
	foreach ( $languages as $code => $lang ) {
		$active = ( $code === $current ) ? ' is-active' : '';
		$url    = brokar_get_lang_url( $code );
		printf(
			'<li class="lang-switcher__item%s"><a href="%s" class="lang-switcher__link" hreflang="%s" data-lang="%s">%s</a></li>',
			esc_attr( $active ),
			esc_url( $url ),
			esc_attr( $code ),
			esc_attr( $code ),
			esc_html( $lang['label'] )
		);
	}
	echo '</ul></nav>';
}

/**
 * Detect current language
 */
function brokar_get_current_lang(): string {
	// Polylang
	if ( function_exists( 'pll_current_language' ) ) {
		return pll_current_language( 'slug' );
	}
	// WPML
	if ( defined( 'ICL_LANGUAGE_CODE' ) ) {
		return ICL_LANGUAGE_CODE;
	}
	// Cookie or default
	if ( isset( $_COOKIE['brokar_lang'] ) ) {
		$lang = sanitize_key( $_COOKIE['brokar_lang'] );
		if ( array_key_exists( $lang, brokar_get_languages() ) ) {
			return $lang;
		}
	}
	return 'nl';
}

/**
 * Get URL for a language (fallback: adds ?lang= param)
 */
function brokar_get_lang_url( string $code ): string {
	$current_url = ( is_ssl() ? 'https://' : 'http://' ) . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
	$url         = remove_query_arg( 'lang', $current_url );
	return add_query_arg( 'lang', $code, $url );
}

/**
 * Handle ?lang= cookie for fallback switcher
 */
function brokar_handle_lang_cookie(): void {
	if ( isset( $_GET['lang'] ) ) {
		$lang = sanitize_key( $_GET['lang'] );
		if ( array_key_exists( $lang, brokar_get_languages() ) ) {
			setcookie( 'brokar_lang', $lang, time() + YEAR_IN_SECONDS, '/' );
		}
	}
}
add_action( 'init', 'brokar_handle_lang_cookie' );
