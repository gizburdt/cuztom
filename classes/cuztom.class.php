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
		add_action( 'admin_init', array( $this, 'register_styles' ) );
		add_action( 'admin_print_styles', array( $this, 'enqueue_styles' ) );
		
		add_action( 'admin_init', array( $this, 'register_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		
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
				wp_register_style( 'cuztom_jquery_ui_css', 
					$this->url . '/assets/css/jquery_ui.css', 
					false, 
					CUZTOM_VERSION, 
					'screen'
				);
			}
			else
			{
				wp_register_style( 'cuztom_jquery_ui_css', 
					'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/' . CUZTOM_JQUERY_UI_STYLE . '/jquery-ui.css', 
					false, 
					CUZTOM_VERSION, 
					'screen'
				);
			}
		}
		
		wp_register_style( 'cuztom_colorpicker_css', 
			$this->url . '/assets/css/colorpicker.css', 
			false, 
			CUZTOM_VERSION, 
			'screen'
		);
		
		wp_register_style( 'cuztom_css', 
			$this->url . '/assets/css/style.css', 
			array( 'thickbox' ), 
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
		wp_enqueue_style( 'cuztom_jquery_ui_css' );
		wp_enqueue_style( 'cuztom_colorpicker_css' );
		wp_enqueue_style( 'cuztom_css' );
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
		wp_register_script( 'cuztom_colorpicker_js', 
			$this->url . '/assets/js/jquery.colorpicker.js',
			array( 'jquery' ), 
			CUZTOM_VERSION, 
			true 
		);
		
		wp_register_script( 'cuztom_js', 
			$this->url . '/assets/js/functions.js',
			array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'jquery-ui-tabs', 'jquery-ui-accordion', 'cuztom_colorpicker_js', 'jquery-ui-sortable', 'thickbox' ), 
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
		wp_enqueue_script( 'cuztom_colorpicker_js' );
		wp_enqueue_script( 'cuztom_js' );
		
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
		wp_localize_script( 'cuztom_js', 'Cuztom', array(
			'home_url'			=> get_home_url(),
			'ajax_url'			=> admin_url( 'admin-ajax.php' ),
			'date_format'		=> get_option( 'date_format' ),
			'remove_image'		=> __( 'Remove current image', CUZTOM_TEXTDOMAIN ),
			'remove_file'		=> __( 'Remove current file', CUZTOM_TEXTDOMAIN )
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


	function _is_wp_callback( $callback )
	{
		return ( ! is_array( $callback ) ) || ( is_array( $callback ) && ( ( isset( $callback[1] ) && ! is_array( $callback[1] ) && method_exists( $callback[0], $callback[1] ) ) || ( isset( $callback[0] ) && ! is_array( $callback[0] ) && class_exists( $callback[0] ) ) ) );
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