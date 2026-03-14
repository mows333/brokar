<?php
/**
 * Custom Nav Walker
 *
 * @package Brokar
 */

defined( 'ABSPATH' ) || exit;

class Brokar_Nav_Walker extends Walker_Nav_Menu {

	public function start_lvl( &$output, $depth = 0, $args = null ) {
		$indent  = str_repeat( "\t", $depth );
		$output .= "\n{$indent}<ul class=\"sub-menu sub-menu--depth-{$depth}\" role=\"menu\">\n";
	}

	public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
		$indent   = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		$classes  = empty( $item->classes ) ? [] : (array) $item->classes;
		$classes[] = 'menu-item--' . $item->ID;

		if ( $args->walker->has_children ) {
			$classes[] = 'has-children';
		}

		$class_names = implode( ' ', array_filter( array_map( 'sanitize_html_class', $classes ) ) );
		$output     .= $indent . '<li id="menu-item-' . $item->ID . '" class="' . esc_attr( $class_names ) . '" role="none">';

		$atts = [
			'title'  => ! empty( $item->attr_title ) ? $item->attr_title : '',
			'target' => ! empty( $item->target )     ? $item->target     : '',
			'rel'    => ! empty( $item->xfn )        ? $item->xfn        : '',
			'href'   => ! empty( $item->url )        ? $item->url        : '',
			'class'  => 'nav__link',
			'role'   => 'menuitem',
		];

		if ( in_array( 'current-menu-item', $classes, true ) ) {
			$atts['aria-current'] = 'page';
			$atts['class']       .= ' is-active';
		}

		if ( $args->walker->has_children ) {
			$atts['aria-haspopup'] = 'true';
			$atts['aria-expanded'] = 'false';
			$atts['class']        .= ' nav__link--parent';
		}

		$atts_str = '';
		foreach ( $atts as $attr => $value ) {
			if ( ! empty( $value ) ) {
				$atts_str .= ' ' . $attr . '="' . esc_attr( $value ) . '"';
			}
		}

		$title   = apply_filters( 'the_title', $item->title, $item->ID );
		$output .= '<a' . $atts_str . '>';
		$output .= '<span class="nav__link-text">' . esc_html( $title ) . '</span>';

		if ( $args->walker->has_children ) {
			$output .= '<svg class="nav__chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>';
		}

		$output .= '</a>';
	}

	public function end_el( &$output, $item, $depth = 0, $args = null ) {
		$output .= "</li>\n";
	}
}
