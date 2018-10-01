<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Seymour
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function seymour_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'seymour_body_classes' );

//////////////////////////////////////////////////////////
// Eliminar información sobre la versión de WP de
// headers y feeds para mejorar la seguridad
//////////////////////////////////////////////////////////
function complete_version_removal() {
    return '';
}
add_filter('the_generator', 'complete_version_removal');
