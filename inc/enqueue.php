<?php
/**
 * Enqueue Scripts & Styles
 *
 * @package Brokar
 */

defined( 'ABSPATH' ) || exit;

function brokar_enqueue_assets() {
	$v = BROKAR_VERSION;

	// ── Fonts ────────────────────────────────────────────────────────────────
	wp_enqueue_style(
		'brokar-fonts',
		'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500&family=Inter:wght@300;400;500;600&display=swap',
		[],
		null
	);

	// ── Main stylesheet ───────────────────────────────────────────────────────
	wp_enqueue_style(
		'brokar-style',
		BROKAR_URI . '/assets/css/main.css',
		[ 'brokar-fonts' ],
		$v
	);

	// ── Animations ───────────────────────────────────────────────────────────
	wp_enqueue_style(
		'brokar-animations',
		BROKAR_URI . '/assets/css/animations.css',
		[ 'brokar-style' ],
		$v
	);

	// ── Comment reply ────────────────────────────────────────────────────────
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	// ── Main JS ──────────────────────────────────────────────────────────────
	wp_enqueue_script(
		'brokar-main',
		BROKAR_URI . '/assets/js/main.js',
		[],
		$v,
		true
	);

	// Pass data to JS
	wp_localize_script( 'brokar-main', 'BrokarData', [
		'ajaxUrl'  => admin_url( 'admin-ajax.php' ),
		'nonce'    => wp_create_nonce( 'brokar_nonce' ),
		'siteUrl'  => home_url(),
		'lang'     => get_locale(),
	] );
}
add_action( 'wp_enqueue_scripts', 'brokar_enqueue_assets' );

// Block editor assets
function brokar_editor_assets() {
	wp_enqueue_style(
		'brokar-editor-style',
		BROKAR_URI . '/assets/css/editor-style.css',
		[],
		BROKAR_VERSION
	);
}
add_action( 'enqueue_block_editor_assets', 'brokar_editor_assets' );

// Preconnect Google Fonts
function brokar_preconnect_fonts( $urls, $relation_type ) {
	if ( 'preconnect' === $relation_type ) {
		$urls[] = 'https://fonts.googleapis.com';
		$urls[] = 'https://fonts.gstatic.com';
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'brokar_preconnect_fonts', 10, 2 );
