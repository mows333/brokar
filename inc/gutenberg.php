<?php
/**
 * Gutenberg / Block Editor Support
 *
 * @package Brokar
 */

defined( 'ABSPATH' ) || exit;

// Register block patterns category
function brokar_register_block_pattern_categories(): void {
	register_block_pattern_category( 'brokar', [
		'label' => __( 'Brokar', 'brokar' ),
	] );
}
add_action( 'init', 'brokar_register_block_pattern_categories' );

// Register block patterns
function brokar_register_block_patterns(): void {
	$patterns_dir = BROKAR_DIR . '/patterns/';
	if ( ! is_dir( $patterns_dir ) ) {
		return;
	}
	$files = glob( $patterns_dir . '*.php' );
	foreach ( (array) $files as $file ) {
		require_once $file;
	}
}
add_action( 'init', 'brokar_register_block_patterns' );

// Custom block styles
function brokar_register_block_styles(): void {
	// Button styles
	register_block_style( 'core/button', [
		'name'  => 'brokar-outline',
		'label' => __( 'Gold Outline', 'brokar' ),
	] );
	register_block_style( 'core/button', [
		'name'  => 'brokar-ghost',
		'label' => __( 'Ghost', 'brokar' ),
	] );

	// Image styles
	register_block_style( 'core/image', [
		'name'  => 'brokar-frame',
		'label' => __( 'Gold Frame', 'brokar' ),
	] );

	// Group styles
	register_block_style( 'core/group', [
		'name'  => 'brokar-section',
		'label' => __( 'Section Dark', 'brokar' ),
	] );
	register_block_style( 'core/group', [
		'name'  => 'brokar-section-light',
		'label' => __( 'Section Light', 'brokar' ),
	] );

	// Separator
	register_block_style( 'core/separator', [
		'name'  => 'brokar-ornament',
		'label' => __( 'Gold Ornament', 'brokar' ),
	] );

	// Quote
	register_block_style( 'core/quote', [
		'name'  => 'brokar-pullquote',
		'label' => __( 'Gold Pull Quote', 'brokar' ),
	] );
}
add_action( 'init', 'brokar_register_block_styles' );

// theme.json support
add_theme_support( 'wp-block-styles' );
add_theme_support( 'appearance-tools' );
