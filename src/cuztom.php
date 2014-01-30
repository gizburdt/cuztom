<?php

if( ! defined( 'ABSPATH' ) ) exit;

if( ! class_exists( 'Cuztom_Initializer' ) ) :

/**
 * Cuztom_Initializer handles init of Cuztom
 *
 * @author 	Gijs Jorissen
 * @since  	2.3
 * 
 */
class Cuztom_Initializer
{
	private static $instance;

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
			self::$instance = new Cuztom_Initializer;
			self::$instance->setup_constants();
			self::$instance->includes();
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
		include( CUZTOM_DIR . 'classes/class-cuztom.php' );
		include( CUZTOM_DIR . 'classes/class-notice.php' );
		include( CUZTOM_DIR . 'classes/class-post-type.php' );
		include( CUZTOM_DIR . 'classes/class-taxonomy.php' );
		include( CUZTOM_DIR . 'classes/class-sidebar.php' );

		// Meta
		include( CUZTOM_DIR . 'classes/class-meta.php' );
		include( CUZTOM_DIR . 'classes/meta/meta_box.class.php' );
		include( CUZTOM_DIR . 'classes/meta/user_meta.class.php' );
		include( CUZTOM_DIR . 'classes/meta/term_meta.class.php' );
		
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
		add_action( 'wp_ajax_cuztom_field_ajax_save', array( 'Cuztom_Field', 'ajax_save' ) );
		add_action( 'wp_ajax_nopriv_cuztom_field_ajax_save', array( 'Cuztom_Field', 'ajax_save' ) );
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
		wp_register_style( 'cuztom-jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/base/jquery-ui.css', false, CUZTOM_VERSION, 'screen' );
		wp_register_style( 'cuztom', CUZTOM_URL . '/assets/css/cuztom.css', false, CUZTOM_VERSION, 'screen' );
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
		wp_register_script( 'jquery-timepicker', 	CUZTOM_URL . '/assets/js/jquery.timepicker.min.js', array( 'jquery' ), CUZTOM_VERSION, true );
		wp_register_script( 'cuztom', 				CUZTOM_URL . '/assets/js/cuztom.min.js',			array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'jquery-ui-tabs', 'jquery-ui-accordion', 'jquery-ui-sortable', 'wp-color-picker', 'jquery-timepicker', 'jquery-ui-slider' ), CUZTOM_VERSION, true );
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
		if( function_exists( 'wp_enqueue_media' ) ) wp_enqueue_media();
		
		wp_enqueue_script( 'thickbox' );
		wp_enqueue_script( 'cuztom' );
		wp_enqueue_script( 'media-upload' );
		
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
}

endif; // End class_exists check

Cuztom_Initializer::run();