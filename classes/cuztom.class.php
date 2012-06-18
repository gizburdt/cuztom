<?php

/**
 * General class with main methods and helper methods
 *
 * @author Gijs Jorissen
 * @since 0.2
 *
 */
class Cuztom
{
	var $dir = array();
	
	/**
	 * Contructs the Cuztom class
	 * Adds actions
	 *
	 * @author Gijs Jorissen
	 * @since 0.3
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
		$this->_determine_cuztom_dir( dirname( __FILE__ ) );
	}
	
	
	/**
	 * Registers styles
	 *
	 * @author Gijs Jorissen
	 * @since 0.3
	 *
	 */
	function register_styles()
	{
		wp_register_style( 'cuztom_css', 
			$this->dir . '/assets/css/style.css', 
			false, 
			CUZTOM_VERSION, 
			'screen'
		);
		
		wp_register_style( 'cuztom_jquery_ui_css', 
			'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/' . CUZTOM_JQUERY_UI_STYLE . '/jquery-ui.css', 
			false, 
			CUZTOM_VERSION, 
			'screen'
		);
	}
	
	
	/**
	 * Enqueues styles
	 *
	 * @author Gijs Jorissen
	 * @since 0.3
	 *
	 */
	function enqueue_styles()
	{
		wp_enqueue_style( 'cuztom_css' );
		wp_enqueue_style( 'cuztom_jquery_ui_css' );
	}
	
	
	/**
	 * Registers scripts
	 *
	 * @author Gijs Jorissen
	 * @since 0.3
	 *
	 */
	function register_scripts()
	{
		wp_register_script( 'cuztom_js', 
			$this->dir . '/assets/js/functions.js',
			array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker', 'jquery-ui-tabs' ), 
			CUZTOM_VERSION, 
			true 
		);
	}
	
	
	/**
	 * Enqueues scripts
	 *
	 * @author Gijs Jorissen
	 * @since 0.3
	 *
	 */
	function enqueue_scripts()
	{
		wp_enqueue_script( 'cuztom_js' );
	}
	
	
	/**
	 * Beautifies a string. Capitalize words and remove underscores
	 *
	 * @param string $string
	 * @return string
	 *
	 * @author Gijs Jorissen
	 * @since 0.1
	 *
	 */
	static function beautify( $string )
	{
		return ucwords( str_replace( '_', ' ', $string ) );
	}
	
	
	/**
	 * Uglifies a string. Remove underscores and lower strings
	 *
	 * @param string $string
	 * @return string
	 *
	 * @author Gijs Jorissen
	 * @since 0.1
	 *
	 */
	static function uglify( $string )
	{
		return strtolower( preg_replace( '/[^A-z0-9]/', '_', $string ) );
	}
	
	
	/**
	 * Makes a word plural
	 *
	 * @param string $string
	 * @return string
	 *
	 * @author Gijs Jorissen
	 * @since 0.1
	 *
	 */
	static function pluralize( $string )
	{
		$last = $string[strlen( $string ) - 1];
		
		if( $last == 'y' )
		{
			$cut = substr( $string, 0, -1 );
			//convert y to ies
			$plural = $cut . 'ies';
		}
		else
		{
			// just attach a s
			$plural = $string . 's';
		}
		
		return $plural;
	}
	
	
	/**
	 * Recursive method to determine the path to the Cuztom folder
	 *
	 * @param string $path
	 * @return string
	 *
	 * @author Gijs Jorissen
	 * @since 0.4.1
	 *
	 */
	function _determine_cuztom_dir( $path = __FILE__ )
	{
		$path = dirname( $path );
		$explode_path = explode( '/', $path );
		
		$current_dir = $explode_path[count( $explode_path ) - 1];
		array_push( $this->dir, $current_dir );
		
		if( $current_dir == 'wp-content' )
		{
			// Build new paths
			$path = '';
			$directories = array_reverse( $this->dir );
			
			foreach( $directories as $dir )
			{
				$path = $path . '/' . $dir;
			}

			$this->dir = $path;
		}
		else
		{
			return $this->_determine_cuztom_dir( $path );
		}
	}		
}

?>