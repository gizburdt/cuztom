<?php

if( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'Cuztom' ) ) :

/**
 * Cuztom handles init of Cuztom
 *
 * @author 	Gijs Jorissen
 * @since  	2.3
 * 
 */
class Cuztom
{
	private static $instance;
	private static $ajax;

	static $reserved = array( 'attachment', 'attachment_id', 'author', 'author_name', 
		'calendar', 'cat', 'category','category__and', 'category__in', 'category__not_in', 'category_name', 'comments_per_page', 'comments_popup', 'cpage', 
		'day', 'debug', 'error', 'exact', 'feed', 'hour', 'link_category', 'm', 'minute', 'monthnum', 'more', 
		'name', 'nav_menu', 'nopaging', 'offset', 'order', 'orderby', 'p', 'page', 'page_id', 'paged', 'pagename', 'pb', 
		'perm', 'post', 'post__in', 'post__not_in', 'post_format', 'post_mime_type', 'post_status', 'post_tag', 'post_type', 
		'posts', 'posts_per_archive_page', 'posts_per_page', 'preview', 'robots', 's', 'search', 'second', 'sentence', 'showposts', 
		'static', 'subpost', 'subpost_id', 'tag', 'tag__and', 'tag__in','tag__not_in', 'tag_id', 'tag_slug__and', 'tag_slug__in', 'taxonomy', 
		'tb', 'term', 'type', 'w', 'withcomments', 'withoutcomments', 'year' );

	/**
	 * Public function to set the instance
	 * 
	 * @author 	Gijs Jorissen
	 * @since  	2.3
	 * 
	 */
	public static function run()
	{
		if ( ! isset( self::$instance ) ) 
		{
			self::$instance = new Cuztom;
			self::$instance->setup_constants();
			self::$instance->includes();
			self::$instance->execute();
			self::$instance->add_hooks();
		}
		
		return self::$instance;
	}

	/**
	 * Setup all the constants
	 * 
	 * @author 	Gijs Jorissen
	 * @since   2.3
	 * 
	 */
	private function setup_constants()
	{
		if( ! defined( 'CUZTOM_VERSION' ) ) 
			define( 'CUZTOM_VERSION', '3.0' );

		if( ! defined( 'CUZTOM_DIR' ) ) 
			define( 'CUZTOM_DIR', plugin_dir_path( __FILE__ ) );

		if( ! defined( 'CUZTOM_URL' ) ) 
			define( 'CUZTOM_URL', $this->get_cuztom_url( __FILE__ ) );
	}

	/**
	 * Include the necessary files
	 * 
	 * @author 	Gijs Jorissen
	 * @since   2.3
	 * 
	 */
	private function includes()
	{
		// General
		include( CUZTOM_DIR . 'classes/class-notice.php' );
		include( CUZTOM_DIR . 'classes/class-ajax.php' );
		include( CUZTOM_DIR . 'classes/class-post-type.php' );
		include( CUZTOM_DIR . 'classes/class-taxonomy.php' );
		include( CUZTOM_DIR . 'classes/class-sidebar.php' );

		// Meta
		include( CUZTOM_DIR . 'classes/class-meta.php' );
		include( CUZTOM_DIR . 'classes/meta/class-meta-box.php' );
		include( CUZTOM_DIR . 'classes/meta/class-user-meta.php' );
		include( CUZTOM_DIR . 'classes/meta/class-term-meta.php' );
		
		// Fields
		include( CUZTOM_DIR . 'classes/class-field.php' );
		include( CUZTOM_DIR . 'classes/fields/class-bundle.php' );
		include( CUZTOM_DIR . 'classes/fields/class-tabs.php' );
		include( CUZTOM_DIR . 'classes/fields/class-accordion.php' );
		include( CUZTOM_DIR . 'classes/fields/class-tab.php' );
		include( CUZTOM_DIR . 'classes/fields/class-text.php' );
		include( CUZTOM_DIR . 'classes/fields/class-textarea.php' );
		include( CUZTOM_DIR . 'classes/fields/class-checkbox.php' );
		include( CUZTOM_DIR . 'classes/fields/class-yesno.php' );
		include( CUZTOM_DIR . 'classes/fields/class-select.php' );
		include( CUZTOM_DIR . 'classes/fields/class-multi-select.php' );
		include( CUZTOM_DIR . 'classes/fields/class-checkboxes.php' );
		include( CUZTOM_DIR . 'classes/fields/class-radios.php' );
		include( CUZTOM_DIR . 'classes/fields/class-wysiwyg.php' );
		include( CUZTOM_DIR . 'classes/fields/class-image.php' );
		include( CUZTOM_DIR . 'classes/fields/class-file.php' );
		include( CUZTOM_DIR . 'classes/fields/class-date.php' );
		include( CUZTOM_DIR . 'classes/fields/class-time.php' );
		include( CUZTOM_DIR . 'classes/fields/class-datetime.php' );
		include( CUZTOM_DIR . 'classes/fields/class-color.php' );
		include( CUZTOM_DIR . 'classes/fields/class-post-select.php' );
		include( CUZTOM_DIR . 'classes/fields/class-post-checkboxes.php' );
		include( CUZTOM_DIR . 'classes/fields/class-term-select.php' );
		include( CUZTOM_DIR . 'classes/fields/class-term-checkboxes.php' );
		include( CUZTOM_DIR . 'classes/fields/class-hidden.php' );

		// Functions
		include( CUZTOM_DIR . 'functions/post-type.php' );
		include( CUZTOM_DIR . 'functions/taxonomy.php' );
	}

	/**
	 * Sets globals
	 *
	 * @author 	Gijs Jorissen
	 * @since 	3.0
	 *
	 */
	private function execute()
	{
		global $cuztom;
		
		$cuztom = array(
			'version'	=> CUZTOM_VERSION,
			'fields' 	=> array(),
			'data'		=> array()		
		);

		// Setup ajax
		self::$ajax = new Cuztom_Ajax;
	}

	/**
	 * Add hooks
	 * 
	 * @author 	Gijs Jorissen
	 * @since   2.3
	 * 
	 */
	private function add_hooks()
	{
		// Assets
		add_action( 'admin_init', array( &$this, 'register_styles' ) );
		add_action( 'admin_print_styles', array( &$this, 'enqueue_styles' ) );
		
		add_action( 'admin_init', array( &$this, 'register_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );
		
		// Ajax
		self::$ajax->add_hooks();
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
		wp_register_style( 'cuztom-jquery-ui', CUZTOM_URL . 'assets/css/jquery-ui.css', false, CUZTOM_VERSION, 'screen' );
		wp_register_style( 'cuztom', CUZTOM_URL . 'assets/css/cuztom.css', false, CUZTOM_VERSION, 'screen' );
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
		wp_enqueue_style( 'thickbox' );
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'cuztom-jquery-ui' );
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
		wp_register_script( 'jquery-timepicker', CUZTOM_URL . 'assets/js/jquery.timepicker.min.js', array( 'jquery' ), CUZTOM_VERSION, true );
		wp_register_script( 'cuztom', CUZTOM_URL . 'assets/js/cuztom.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'jquery-ui-tabs', 'jquery-ui-accordion', 'jquery-ui-sortable', 'wp-color-picker', 'jquery-timepicker', 'jquery-ui-slider' ), CUZTOM_VERSION, true );
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
			wp_enqueue_media();
		
		wp_enqueue_script( 'thickbox' );
		wp_enqueue_script( 'media-upload' );
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
			'translations'		=> array(
				'limit_reached'		=> __( 'Limit reached!', 'cuztom' )
			)
		) );
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
	function get_cuztom_url( $path = __FILE__, $url = array() )
	{
		$path 		= dirname( $path );
		$path 		= str_replace( '\\', '/', $path );
		$expath 	= explode( '/', $path );
		$current 	= $expath[count( $expath ) - 1];

		array_push( $url, $current );
		
		if( preg_match( '/content/', $current ) )
		{
			// Build new paths
			$path = '';
			$directories = array_reverse( $url );
			
			foreach( $directories as $dir )
			{
				$path = $path . '/' . $dir;
			}

			return apply_filters( 'cuztom_url', $path );
		}
		else
		{
			return $this->get_cuztom_url( $path, $url );
		}
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
		$specials = apply_filters( 'cuztom_plural', array(
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
        ) );

        $irregular = apply_filters( 'cuztom_irregular', array(
	        array( 'move',   'moves'    ),
	        array( 'sex',    'sexes'    ),
	        array( 'child',  'children' ),
	        array( 'man',    'men'      ),
	        array( 'person', 'people'   )
        ) );

        $uncountable = apply_filters( 'cuztom_uncountable', array( 
	        'sheep', 
	        'fish',
	        'series',
	        'species',
	        'money',
	        'rice',
	        'information',
	        'equipment'
        ) );

        // Save time if string in uncountable
        if ( in_array( strtolower( $string ), $uncountable ) )
        	return apply_filters( 'cuztom_pluralize', $string, 'uncountable' );

        // Check for irregular words
        foreach ( $irregular as $noun )
        {
        	if ( strtolower( $string ) == $noun[0] )
            	return apply_filters( 'cuztom_pluralize', $noun[1], 'irregular' );
        }

        // Check for plural forms
        foreach ( $specials as $pattern )
        {
        	if ( preg_match( $pattern[0], $string ) )
        		return apply_filters( 'cuztom_pluralize', preg_replace( $pattern[0], $pattern[1], $string ), 'special' );
        }
		
		// Return if noting found
		return apply_filters( 'cuztom_pluralize', $string, null );
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
		if( ! in_array( $term, apply_filters( 'cuztom_reserved_terms', self::$reserved ) ) ) 
			return false;
	    
	    return new WP_Error( 'reserved_term_used', __( 'Use of a reserved term.', 'cuztom' ) );
	}
}

endif; // End class_exists check

Cuztom::run();