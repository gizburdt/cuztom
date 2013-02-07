<?php

/**
 * General class with main methods and helper methods
 *
 * @author 	Gijs Jorissen
 * @since 	0.2
 *
 */
class Cuztom
{
	var $url = array();
	
	/**
	 * Wordpress reserved terms
	 * @var array
	 */
	static $_reserved = array( 'attachment', 'attachment_id', 'author', 'author_name', 'calendar', 'cat', 'category','category__and', 'category__in', 'category__not_in', 
		'category_name', 'comments_per_page', 'comments_popup', 'cpage', 'day', 'debug', 'error', 'exact', 'feed', 'hour', 'link_category', 
		'm', 'minute', 'monthnum', 'more', 'name', 'nav_menu', 'nopaging', 'offset', 'order', 'orderby', 'p', 'page', 'page_id', 'paged', 'pagename', 'pb', 
		'perm', 'post', 'post__in', 'post__not_in', 'post_format', 'post_mime_type', 'post_status', 'post_tag', 'post_type', 
		'posts', 'posts_per_archive_page', 'posts_per_page', 'preview', 'robots', 's', 'search', 'second', 'sentence', 'showposts', 
		'static', 'subpost', 'subpost_id', 'tag', 'tag__and', 'tag__in','tag__not_in', 'tag_id', 'tag_slug__and', 'tag_slug__in', 'taxonomy', 
		'tb', 'term', 'type', 'w', 'withcomments', 'withoutcomments', 'year' );

	/**
	 * Contructs the Cuztom class
	 * Adds actions
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.3
	 *
	 */
	function __construct()
	{
		// Add actions
		add_action( 'admin_init', array( &$this, 'register_styles' ) );
		add_action( 'admin_print_styles', array( &$this, 'enqueue_styles' ) );
		
		add_action( 'admin_init', array( &$this, 'register_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
		
		// Ajax
		add_action( 'wp_ajax_cuztom_field_ajax_save', array( 'Cuztom_Field', 'ajax_save' ) );
		add_action( 'wp_ajax_nopriv_cuztom_field_ajax_save', array( 'Cuztom_Field', 'ajax_save' ) );

		// Determine the full path to the this folder
		$this->_determine_cuztom_url( dirname( __FILE__ ) );
	}
	
	/**
	 * Registers styles
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.3
	 *
	 */
	function register_styles()
	{		
		if( CUZTOM_JQUERY_UI_STYLE != 'none' )
		{
			if( CUZTOM_JQUERY_UI_STYLE == 'cuztom' )
			{
				wp_register_style( 'cuztom-jquery-ui', 
					$this->url . '/assets/css/cuztom_jquery_ui.css', 
					false, 
					CUZTOM_VERSION, 
					'screen'
				);
			}
			else
			{
				wp_register_style( 'cuztom-jquery-ui', 
					'http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/' . CUZTOM_JQUERY_UI_STYLE . '/jquery-ui.css', 
					false, 
					CUZTOM_VERSION, 
					'screen'
				);
			}
		}
		
		wp_register_style( 'cuztom-colorpicker', 
			$this->url . '/assets/css/colorpicker.css', 
			false, 
			CUZTOM_VERSION, 
			'screen'
		);
		
		wp_register_style( 'cuztom', 
			$this->url . '/assets/css/style.css', 
			false, 
			CUZTOM_VERSION, 
			'screen'
		);
	}
	
	/**
	 * Enqueues styles
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.3
	 *
	 */
	function enqueue_styles()
	{
		if( ! function_exists( 'wp_enqueue_media' ) ) wp_enqueue_style( 'thickbox' );

		wp_enqueue_style( 'cuztom-jquery-ui' );
		wp_enqueue_style( 'cuztom-colorpicker' );
		wp_enqueue_style( 'cuztom' );
	}
	
	/**
	 * Registers scripts
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.3
	 *
	 */
	function register_scripts()
	{
		wp_register_script( 'jquery-colorpicker', 
			$this->url . '/assets/js/jquery.colorpicker.js',
			array( 'jquery' ), 
			CUZTOM_VERSION, 
			true 
		);

		wp_register_script( 'jquery-timepicker', 
			$this->url . '/assets/js/jquery.timepicker.js',
			array( 'jquery' ), 
			CUZTOM_VERSION, 
			true 
		);
		
		wp_register_script( 'cuztom', 
			$this->url . '/assets/js/functions.js',
			array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'jquery-ui-tabs', 'jquery-ui-accordion', 'jquery-colorpicker', 'jquery-timepicker', 'jquery-ui-sortable' ), 
			CUZTOM_VERSION, 
			true 
		);
	}
	
	/**
	 * Enqueues scripts
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.3
	 *
	 */
	function enqueue_scripts()
	{
		if( function_exists( 'wp_enqueue_media' ) )
		{
			wp_enqueue_media();
		}
		else
		{
			wp_enqueue_script( 'thickbox' );
			wp_enqueue_script( 'media-upload' );
		}

		wp_enqueue_script( 'cuztom' );
		
		self::localize_scripts();
	}
	
	/**
	 * Localizes scripts
	 * 
	 * @author 	Gijs Jorissen
	 * @since 	1.1.1
	 *
	 */
	function localize_scripts()
	{
		wp_localize_script( 'cuztom', 'Cuztom', array(
			'home_url'			=> get_home_url(),
			'ajax_url'			=> admin_url( 'admin-ajax.php' ),
			'date_format'		=> get_option( 'date_format' ),
			'wp_version'		=> get_bloginfo( 'version' ),
			'remove_image'		=> __( 'Remove current image', 'cuztom' ),
			'remove_file'		=> __( 'Remove current file', 'cuztom' )
		) );
	}
	
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
	 * Uglifies a string. Remove underscores and lower strings
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
		$last = $string[strlen( $string ) - 1];
		
		if( $last != 's' )
		{
			if( $last == 'y' )
			{
				$cut = substr( $string, 0, -1 );
				//convert y to ies
				$string = $cut . 'ies';
			}
			else
			{
				// just attach a s
				$string = $string . 's';
			}
		}
		
		return apply_filters( 'cuztom_pluralize', $string );
	}

	/**
	 * Checks if the callback is a Wordpress callback
	 * So, if the class, method and/or function exists. If so, call it.
	 * If it doesn't use the data array.
	 * 
	 * @param	string|array   	$callback
	 * @return 	boolean
	 *
	 * @author  Gijs Jorissen
	 * @since 	1.5
	 * 
	 */
	function is_wp_callback( $callback )
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
	    
	    return new WP_Error( 'reserved_term_used', __( "Use of a reserved term", 'cuztom' ) );
	}
	
	/**
	 * Recursive method to determine the path to the Cuztom folder
	 *
	 * @param 	string 			$path
	 * @return 	string
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.4.1
	 *
	 */
	function _determine_cuztom_url( $path = __FILE__ )
	{
		if( defined( 'CUZTOM_URL' ) && CUZTOM_URL != '' )
		{
			$this->url = CUZTOM_URL;
		}
		else
		{
			$path = dirname( $path );
			$path = str_replace( '\\', '/', $path );
			$explode_path = explode( '/', $path );
			
			$current_dir = $explode_path[count( $explode_path ) - 1];
			array_push( $this->url, $current_dir );
			
			if( $current_dir == 'wp-content' )
			{
				// Build new paths
				$path = '';
				$directories = array_reverse( $this->url );
				
				foreach( $directories as $dir )
				{
					$path = $path . '/' . $dir;
				}

				$this->url = $path;
			}
			else
			{
				return $this->_determine_cuztom_url( $path );
			}
		}
	}
}