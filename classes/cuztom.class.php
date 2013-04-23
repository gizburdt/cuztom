<?php

if( ! defined( 'ABSPATH' ) ) exit;

/**
 * General class with main methods and helper methods
 *
 * @author 	Gijs Jorissen
 * @since 	0.2
 *
 */
class Cuztom
{
	static $_reserved = array( 'attachment', 'attachment_id', 'author', 'author_name', 'calendar', 'cat', 'category','category__and', 'category__in', 'category__not_in', 
		'category_name', 'comments_per_page', 'comments_popup', 'cpage', 'day', 'debug', 'error', 'exact', 'feed', 'hour', 'link_category', 
		'm', 'minute', 'monthnum', 'more', 'name', 'nav_menu', 'nopaging', 'offset', 'order', 'orderby', 'p', 'page', 'page_id', 'paged', 'pagename', 'pb', 
		'perm', 'post', 'post__in', 'post__not_in', 'post_format', 'post_mime_type', 'post_status', 'post_tag', 'post_type', 
		'posts', 'posts_per_archive_page', 'posts_per_page', 'preview', 'robots', 's', 'search', 'second', 'sentence', 'showposts', 
		'static', 'subpost', 'subpost_id', 'tag', 'tag__and', 'tag__in','tag__not_in', 'tag_id', 'tag_slug__and', 'tag_slug__in', 'taxonomy', 
		'tb', 'term', 'type', 'w', 'withcomments', 'withoutcomments', 'year' );
	
	/**
	 * Beautifies a string. Capitalize words and remove underscores
	 *
	 * @param 	string 			$string
	 * @return 	string
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.1
	 *
	 */
	static function beautify( $string )
	{
		return apply_filters( 'cuztom_beautify', ucwords( str_replace( '_', ' ', $string ) ) );
	}
	
	/**
	 * Uglifies a string. Remove strange characters and lower strings
	 *
	 * @param 	string 			$string
	 * @return 	string
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.1
	 *
	 */
	static function uglify( $string )
	{
		return apply_filters( 'cuztom_uglify', str_replace( '-', '_', sanitize_title( $string ) ) );
	}
	
	/**
	 * Makes a word plural
	 *
	 * @param 	string 			$string
	 * @return 	string
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.1
	 *
	 */
	static function pluralize( $string )
	{
		$plural = array(
            array( '/(quiz)$/i',               "$1zes"   ),
        	array( '/^(ox)$/i',                "$1en"    ),
        	array( '/([m|l])ouse$/i',          "$1ice"   ),
        	array( '/(matr|vert|ind)ix|ex$/i', "$1ices"  ),
        	array( '/(x|ch|ss|sh)$/i',         "$1es"    ),
        	array( '/([^aeiouy]|qu)y$/i',      "$1ies"   ),
        	array( '/([^aeiouy]|qu)ies$/i',    "$1y"     ),
            array( '/(hive)$/i',               "$1s"     ),
            array( '/(?:([^f])fe|([lr])f)$/i', "$1$2ves" ),
            array( '/sis$/i',                  "ses"     ),
            array( '/([ti])um$/i',             "$1a"     ),
            array( '/(buffal|tomat)o$/i',      "$1oes"   ),
            array( '/(bu)s$/i',                "$1ses"   ),
            array( '/(alias|status)$/i',       "$1es"    ),
            array( '/(octop|vir)us$/i',        "$1i"     ),
            array( '/(ax|test)is$/i',          "$1es"    ),
            array( '/s$/i',                    "s"       ),
            array( '/$/',                      "s"       )
        );

        $irregular = array(
	        array( 'move',   'moves'    ),
	        array( 'sex',    'sexes'    ),
	        array( 'child',  'children' ),
	        array( 'man',    'men'      ),
	        array( 'person', 'people'   )
        );

        $uncountable = array( 
	        'sheep', 
	        'fish',
	        'series',
	        'species',
	        'money',
	        'rice',
	        'information',
	        'equipment'
        );

        // Save time if string in uncountable
        if ( in_array( strtolower( $string ), $uncountable ) )
        	return apply_filters( 'cuztom_pluralize', $string );

        // Check for irregular words
        foreach ( $irregular as $noun )
        {
        	if ( strtolower( $string ) == $noun[0] )
            	return apply_filters( 'cuztom_pluralize', $noun[1] );
        }

        // Check for plural forms
        foreach ( $plural as $pattern )
        {
        	if ( preg_match( $pattern[0], $string ) )
        		return apply_filters( 'cuztom_pluralize', preg_replace( $pattern[0], $pattern[1], $string ) );
        }
		
		// Return if noting found
		return apply_filters( 'cuztom_pluralize', $string );
	}

	/**
	 * Checks if the callback is a Wordpress callback
	 * So, if the class, method and/or function exists. If so, call it.
	 * If it doesn't use the data array (cuztom).
	 * 
	 * @param	string|array   	$callback
	 * @return 	boolean
	 *
	 * @author  Gijs Jorissen
	 * @since 	1.5
	 * 
	 */
	static function is_wp_callback( $callback )
	{
		return ( ! is_array( $callback ) ) || ( is_array( $callback ) && ( ( isset( $callback[1] ) && ! is_array( $callback[1] ) && method_exists( $callback[0], $callback[1] ) ) || ( isset( $callback[0] ) && ! is_array( $callback[0] ) && class_exists( $callback[0] ) ) ) );
	}

	/**
	 * Check if the term is reserved by Wordpress
	 * 
	 * @param  	string  		$term
	 * @return 	boolean
	 *
	 * @author  Gijs Jorissen
	 * @since  	1.6
	 * 
	 */
	static function is_reserved_term( $term )
	{
	    if( ! in_array( $term, self::$_reserved ) ) return false;
	    
	    return new WP_Error( 'reserved_term_used', __( 'Use of a reserved term.', 'cuztom' ) );
	}
}