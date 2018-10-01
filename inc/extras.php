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

//////////////////////////////////////////////////////////
// Retrasar el envío de nuevas entradas al feed (15 min)
//////////////////////////////////////////////////////////
function publish_later_on_feed($where) {
    global $wpdb;

    if (is_feed()) {
        // timestamp in WP-format
        $now = gmdate('Y-m-d H:i:s');

        // value for wait; + device
        $wait = '15'; // integer

        // http://dev.mysql.com/doc/refman/5.0/en/date-and-time-functions.html#function_timestampdiff
        $device = 'MINUTE'; // MINUTE, HOUR, DAY, WEEK, MONTH, YEAR

        // add SQL-sytax to default $where
        $where .= " AND TIMESTAMPDIFF($device, $wpdb->posts.post_date_gmt, '$now') > $wait ";
    }
    return $where;
}
add_filter('posts_where', 'publish_later_on_feed');
