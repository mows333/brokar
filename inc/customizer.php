<?php
/**
 * Theme Customizer
 *
 * @package Brokar
 */

defined( 'ABSPATH' ) || exit;

function brokar_customizer_register( WP_Customize_Manager $wp_customize ): void {

	// ── Contact Section ───────────────────────────────────────────────────────
	$wp_customize->add_section( 'brokar_contact', [
		'title'    => __( 'Contact & Locatie', 'brokar' ),
		'priority' => 130,
	] );

	$contact_fields = [
		'address'   => [ 'label' => __( 'Adres',         'brokar' ), 'default' => 'Nationalestraat 28, 2000 Antwerpen' ],
		'phone'     => [ 'label' => __( 'Telefoon',       'brokar' ), 'default' => '+32 (0)3 000 00 00' ],
		'email'     => [ 'label' => __( 'E-mail',          'brokar' ), 'default' => 'info@brokar.be' ],
		'hours'     => [ 'label' => __( 'Openingstijden', 'brokar' ), 'default' => 'Di–Zo: 10:00–18:00' ],
	];

	foreach ( $contact_fields as $key => $args ) {
		$wp_customize->add_setting( "brokar_{$key}", [
			'default'           => $args['default'],
			'sanitize_callback' => 'sanitize_text_field',
		] );
		$wp_customize->add_control( "brokar_{$key}", [
			'label'   => $args['label'],
			'section' => 'brokar_contact',
			'type'    => 'text',
		] );
	}

	// ── Social Media ──────────────────────────────────────────────────────────
	$wp_customize->add_section( 'brokar_social', [
		'title'    => __( 'Sociale Media', 'brokar' ),
		'priority' => 135,
	] );

	$social_fields = [
		'facebook'  => 'Facebook URL',
		'instagram' => 'Instagram URL',
		'youtube'   => 'YouTube URL',
		'twitter'   => 'X / Twitter URL',
	];

	foreach ( $social_fields as $key => $label ) {
		$wp_customize->add_setting( "brokar_social_{$key}", [
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		] );
		$wp_customize->add_control( "brokar_social_{$key}", [
			'label'   => $label,
			'section' => 'brokar_social',
			'type'    => 'url',
		] );
	}

	// ── Hero Section ──────────────────────────────────────────────────────────
	$wp_customize->add_section( 'brokar_hero', [
		'title'    => __( 'Hero Sectie', 'brokar' ),
		'priority' => 120,
	] );

	$wp_customize->add_setting( 'brokar_hero_tagline', [
		'default'           => __( 'Kunst. Cultuur. Gemeenschap.', 'brokar' ),
		'sanitize_callback' => 'sanitize_text_field',
	] );
	$wp_customize->add_control( 'brokar_hero_tagline', [
		'label'   => __( 'Hero Tagline', 'brokar' ),
		'section' => 'brokar_hero',
		'type'    => 'text',
	] );
}
add_action( 'customize_register', 'brokar_customizer_register' );

// Helper: get customizer value
function brokar_get_option( string $key, string $default = '' ): string {
	return get_theme_mod( "brokar_{$key}", $default );
}
