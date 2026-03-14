<?php
/**
 * Theme Setup
 *
 * @package Brokar
 */

defined( 'ABSPATH' ) || exit;

function brokar_setup() {
	// Translations
	load_theme_textdomain( 'brokar', BROKAR_DIR . '/languages' );

	// Title tag
	add_theme_support( 'title-tag' );

	// Post thumbnails
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'brokar-hero',    1920, 1080, true );
	add_image_size( 'brokar-card',    800,  600,  true );
	add_image_size( 'brokar-square',  600,  600,  true );
	add_image_size( 'brokar-wide',    1200, 675,  true );

	// HTML5
	add_theme_support( 'html5', [
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
		'style',
		'script',
	] );

	// Custom logo
	add_theme_support( 'custom-logo', [
		'height'      => 80,
		'width'       => 200,
		'flex-height' => true,
		'flex-width'  => true,
	] );

	// Feed links
	add_theme_support( 'automatic-feed-links' );

	// Selective refresh for widgets
	add_theme_support( 'customize-selective-refresh-widgets' );

	// Block editor styles
	add_theme_support( 'editor-styles' );
	add_editor_style( 'assets/css/editor-style.css' );

	// Gutenberg wide & full alignment
	add_theme_support( 'align-wide' );

	// Gutenberg color palette
	add_theme_support( 'editor-color-palette', [
		[
			'name'  => __( 'Navy', 'brokar' ),
			'slug'  => 'brokar-navy',
			'color' => '#0A1628',
		],
		[
			'name'  => __( 'Gold', 'brokar' ),
			'slug'  => 'brokar-gold',
			'color' => '#C9A84C',
		],
		[
			'name'  => __( 'Gold Light', 'brokar' ),
			'slug'  => 'brokar-gold-light',
			'color' => '#E8C96A',
		],
		[
			'name'  => __( 'Ivory', 'brokar' ),
			'slug'  => 'brokar-white',
			'color' => '#F5F0E8',
		],
		[
			'name'  => __( 'Gray', 'brokar' ),
			'slug'  => 'brokar-gray',
			'color' => '#8A8A8A',
		],
	] );

	// Gutenberg font sizes
	add_theme_support( 'editor-font-sizes', [
		[ 'name' => __( 'Small',       'brokar' ), 'slug' => 'small',       'size' => 14 ],
		[ 'name' => __( 'Normal',      'brokar' ), 'slug' => 'normal',      'size' => 18 ],
		[ 'name' => __( 'Medium',      'brokar' ), 'slug' => 'medium',      'size' => 24 ],
		[ 'name' => __( 'Large',       'brokar' ), 'slug' => 'large',       'size' => 36 ],
		[ 'name' => __( 'Extra Large', 'brokar' ), 'slug' => 'extra-large', 'size' => 54 ],
		[ 'name' => __( 'Huge',        'brokar' ), 'slug' => 'huge',        'size' => 72 ],
	] );

	// Disable custom colors to enforce palette
	// add_theme_support( 'disable-custom-colors' );

	// Post formats
	add_theme_support( 'post-formats', [
		'aside',
		'gallery',
		'quote',
		'video',
		'audio',
		'image',
	] );

	// Responsive embeds
	add_theme_support( 'responsive-embeds' );

	// Block patterns
	add_theme_support( 'core-block-patterns' );

	// WP nav menus
	register_nav_menus( [
		'primary'   => __( 'Primair Menu', 'brokar' ),
		'secondary' => __( 'Voettekst Menu', 'brokar' ),
		'social'    => __( 'Sociale Media', 'brokar' ),
	] );
}
add_action( 'after_setup_theme', 'brokar_setup' );

// Content width
function brokar_content_width() {
	$GLOBALS['content_width'] = 1200;
}
add_action( 'after_setup_theme', 'brokar_content_width', 0 );

// Excerpt length
add_filter( 'excerpt_length', fn() => 30 );
add_filter( 'excerpt_more',   fn() => '&hellip;' );
