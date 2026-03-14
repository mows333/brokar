<?php
/**
 * Menu helpers
 *
 * @package Brokar
 */

defined( 'ABSPATH' ) || exit;

// Widget areas
function brokar_widgets_init() {
	$defaults = [
		'before_widget' => '<div id="%1$s" class="widget %2$s">',
		'after_widget'  => '</div>',
		'before_title'  => '<h3 class="widget__title">',
		'after_title'   => '</h3>',
	];

	register_sidebar( array_merge( $defaults, [
		'name' => __( 'Blog Sidebar', 'brokar' ),
		'id'   => 'sidebar-blog',
	] ) );

	register_sidebar( array_merge( $defaults, [
		'name' => __( 'Voettekst Kolom 1', 'brokar' ),
		'id'   => 'footer-1',
	] ) );

	register_sidebar( array_merge( $defaults, [
		'name' => __( 'Voettekst Kolom 2', 'brokar' ),
		'id'   => 'footer-2',
	] ) );

	register_sidebar( array_merge( $defaults, [
		'name' => __( 'Voettekst Kolom 3', 'brokar' ),
		'id'   => 'footer-3',
	] ) );
}
add_action( 'widgets_init', 'brokar_widgets_init' );
