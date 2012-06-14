<?php

ob_start();

// Define
define( 'CUZTOM_VERSION', '0.5' );
if( ! defined( 'CUZTOM_TEXTDOMAIN', 'cuztom' ) ) define( 'CUZTOM_TEXTDOMAIN', 'cuztom' );
if( ! defined( 'CUZTOM_JQUERY_UI_STYLE' ) ) define( 'CUZTOM_JQUERY_UI_STYLE', 'cupertino' );

// Init
$cuztom = new Cuztom();


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
	var $version = CUZTOM_VERSION;
	var $textdomain = CUZTOM_TEXTDOMAIN;
	var $jquery_ui_style = CUZTOM_JQUERY_UI_STYLE;
	
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
		$this->_determine_cuztom_dir();
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
			$this->dir . '/css/style.css', 
			false, 
			$this->version, 
			'screen'
		);
		
		wp_register_style( 'cuztom_jquery_ui_css', 
			'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/' . $this->jquery_ui_style . '/jquery-ui.css', 
			false, 
			$this->version, 
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
			$this->dir . '/js/functions.js',
			array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker' ), 
			$this->version, 
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
	 * Recursive method to determine the path to this folder
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
			return $this->_get_dir( $path );
		}
	}		
}


/**
 * Cuztom Field Class
 *
 * @author Gijs Jorissen
 * @since 0.3.3
 *
 */
class Cuztom_Field
{
	
	/**
	 * Outputs a field based on its type
	 *
	 * @param string $field_id_name
	 * @param array $type
	 * @param array $meta
	 * @return mixed
	 *
	 * @author Gijs Jorissen
	 * @since 0.2
	 *
	 */
	static function output( $field_id_name, $field, $value = '' )
	{		
		switch( $field['type'] ) :
			
			case 'text' :
				echo '<input type="text" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '" value="' . $value . '" />';
			break;
			
			case 'textarea' :
				echo '<textarea name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '">' . $value . '</textarea>';
			break;
			
			case 'checkbox' :
				echo '<input type="checkbox" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '" ' . checked( $value, 'on', false ) . ' />';
			break;
			
			case 'yesno' :
				echo '<input type="radio" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '_yes" value="yes" ' . checked( $value, 'yes', false ) . ' />';
				echo '<label for="' . $field_id_name . '_yes">' . __('Yes') . '</label>';
				
				echo '<input type="radio" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '_no" value="no" ' . checked( $value, 'no', false ) . ' />';
				echo '<label for="' . $field_id_name . '_no">' . __('No') . '</label>';
			break;
			
			case 'select' :
				echo '<select name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '">';
					foreach( $field['options'] as $slug => $name )
					{
						echo '<option value="' . Cuztom::uglify( $slug ) . '" ' . selected( Cuztom::uglify( $slug ), $value, false ) . '>' . Cuztom::beautify( $name ) . '</option>';
					}
				echo '</select>';
			break;
			
			case 'checkboxes' :
				foreach( $field['options'] as $slug => $name )
				{
					echo '<input type="checkbox" name="cuztom[' . $field_id_name . '][]" id="' . $field_id_name . '_' . Cuztom::uglify( $slug ) . '" value="' . Cuztom::uglify( $slug ) . '" ' . ( in_array( Cuztom::uglify( $slug ), maybe_unserialize( $value ) ) ? 'checked="checked"' : '' ) . ' /><label for="' . $field_id_name . '_' . Cuztom::uglify( $slug ) . '">' . Cuztom::beautify( $name ) . '</label>';
				}
			break;
			
			case 'radio' :
				foreach( $field['options'] as $slug => $name )
				{
					echo '<input type="radio" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '_' . Cuztom::uglify( $slug ) . '" value="' . Cuztom::uglify( $slug ) . '" ' . checked( Cuztom::uglify( $slug ), $value, false ) . ' /><label for="' . $field_id_name . '_' . Cuztom::uglify( $slug ) . '">' . Cuztom::beautify( $name ) . '</label>';
				}
			break;
			
			case 'wysiwyg' :
				wp_editor( $value, $field_id_name, array_merge( 
					
					// Default
					array(
						'textarea_name' => 'cuztom[' . $field_id_name . ']',
						'media_buttons' => false
					),
					
					// Given
					isset( $field['options'] ) ? $field['options'] : array()
				
				) );
			break;
			
			case 'image' :
				echo '<input type="file" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '"  />';
				
				if( ! empty( $value ) ) echo '<img src="' . $value . '" />';
			break;
			
			case 'date' :
				echo '<input type="text" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '" class="cuztom_datepicker datepicker" value="' . $value . '" />';
			break;
			
			default:
				echo __( 'Input type not available' );
			break;
			
		endswitch;
	}
}


/**
 * Post Type class used to register post types
 * Can call add_taxonomy and add_meta_box to call the associated classes
 * Method chaining is possible
 *
 * @author Gijs jorissen
 * @since 0.1
 *
 */
class Cuztom_Post_Type
{
	var $post_type_name;
	var $post_type_args;
	var $post_type_labels;
	
	
	/**
	 * Construct a new Custom Post Type
	 *
	 * @param string $name
	 * @param array $args
	 * @param array $labels
	 *
	 * @author Gijs Jorissen
	 * @since 0.1
	 *
	 */
	function __construct( $name, $args = array(), $labels = array() )
	{
		if( ! empty( $name ) )
		{
			// Set some important variables
			$this->post_type_name		= Cuztom::uglify( $name );
			$this->post_type_args 		= $args;
			$this->post_type_labels 	= $labels;

			// Add action to register the post type, if the post type doesnt exist
			if( ! post_type_exists( $this->post_type_name ) )
			{
				add_action( 'init', array( &$this, 'register_post_type' ) );
			}
		}
	}
	
	
	/**
	 * Register the Post Type
	 *
	 * @author Gijs Jorissen
	 * @since 0.1
	 *
	 */
	function register_post_type()
	{		
		// Capitilize the words and make it plural
		$name 		= Cuztom::beautify( $this->post_type_name );
		$plural 	= Cuztom::pluralize( $name );

		// We set the default labels based on the post type name and plural. 
		// We overwrite them with the given labels.
		$labels = array_merge(

			// Default
			array(
				'name' 					=> _x( $plural, 'post type general name' ),
				'singular_name' 		=> _x( $name, 'post type singular name' ),
				'add_new' 				=> _x( 'Add New', strtolower( $name ) ),
				'add_new_item' 			=> __( 'Add New ' . $name ),
				'edit_item' 			=> __( 'Edit ' . $name ),
				'new_item' 				=> __( 'New ' . $name ),
				'all_items' 			=> __( 'All ' . $plural ),
				'view_item' 			=> __( 'View ' . $name ),
				'search_items' 			=> __( 'Search ' . $plural ),
				'not_found' 			=> __( 'No ' . strtolower( $plural ) . ' found'),
				'not_found_in_trash' 	=> __( 'No ' . strtolower( $plural ) . ' found in Trash'), 
				'parent_item_colon' 	=> '',
				'menu_name' 			=> $plural
			),

			// Given labels
			$this->post_type_labels

		);

		// Same principle as the labels. We set some default and overwite them with the given arguments.
		$args = array_merge(

			// Default
			array(
				'label' 				=> $plural,
				'labels' 				=> $labels,
				'public' 				=> true,
				'show_ui' 				=> true,
				'supports' 				=> array( 'title', 'editor' ),
				'show_in_nav_menus' 	=> true,
				'_builtin' 				=> false,
			),

			// Given args
			$this->post_type_args

		);

		// Register the post type
		register_post_type( $this->post_type_name, $args );
	}
	
	
	/**
	 * Add a taxonomy to the Post Type
	 *
	 * @param string $name
	 * @param array $args
	 * @param array $labels
	 *
	 * @author Gijs Jorissen
	 * @since 0.1
	 *
	 */
	function add_taxonomy( $name, $args = array(), $labels = array() )
	{
		// Call Cuztom_Taxonomy with this post type name as second parameter
		$taxonomy = new Cuztom_Taxonomy( $name, $this->post_type_name, $args, $labels );
		
		// For method chaining
		return $this;
	}
	
	
	/**
	 * Add post meta box to the Post Type
	 *
	 * @param string $title
	 * @param array $fields
	 * @param string $context
	 * @param string $priority
	 *
	 * @author Gijs Jorissen
	 * @since 0.1
	 *
	 */
	function add_meta_box( $title, $fields = array(), $context = 'normal', $priority = 'default' )
	{
		$meta_box = new Cuztom_Meta_Box( $title, $fields, $this->post_type_name, $context, $priority );
		
		// For method chaining
		return $this;
	}	
}


/**
 * Creates custom taxonomies
 *
 *
 * @author Gijs Jorissen
 * @since 0.2
 *
 */
class Cuztom_Taxonomy
{
	var $taxonomy_name;
	var $taxonomy_labels;
	var $taxonomy_args;
	var $post_type_name;
	
	
	/**
	 * Constructs the class with important vars and method calls
	 * If the taxonomy exists, it will be attached to the post type
	 *
	 * @param string $name
	 * @param string $post_type_name
	 * @param array $args
	 * @param array $labels
	 *
	 * @author Gijs Jorissen
	 * @since 0.2
	 *
	 */
	function __construct( $name, $post_type_name = null, $args = array(), $labels = array() )
	{
		if( ! empty( $name ) )
		{
			$this->post_type_name = $post_type_name;
			
			// Taxonomy properties
			$this->taxonomy_name		= Cuztom::uglify( $name );
			$this->taxonomy_labels		= $labels;
			$this->taxonomy_args		= $args;

			if( ! taxonomy_exists( $this->taxonomy_name ) )
			{
				add_action( 'init', array( &$this, 'register_taxonomy' ) );
			}
			else
			{
				add_action( 'init', array( &$this, 'register_taxonomy_for_object_type' ) );
			}
		}
	}
	
	
	/**
	 * Registers the custom taxonomy with the given arguments
	 *
	 * @author Gijs Jorissen
	 * @since 0.2
	 *
	 */
	function register_taxonomy()
	{
		$name 		= Cuztom::beautify( $this->taxonomy_name );
		$plural 	= Cuztom::pluralize( $name );

		// Default labels, overwrite them with the given labels.
		$labels = array_merge(

			// Default
			array(
				'name' 					=> _x( $plural, 'taxonomy general name' ),
				'singular_name' 		=> _x( $name, 'taxonomy singular name' ),
			    'search_items' 			=> __( 'Search ' . $plural ),
			    'all_items' 			=> __( 'All ' . $plural ),
			    'parent_item' 			=> __( 'Parent ' . $name ),
			    'parent_item_colon' 	=> __( 'Parent ' . $name . ':' ),
			    'edit_item' 			=> __( 'Edit ' . $name ), 
			    'update_item' 			=> __( 'Update ' . $name ),
			    'add_new_item' 			=> __( 'Add New ' . $name ),
			    'new_item_name' 		=> __( 'New ' . $name . ' Name' ),
			    'menu_name' 			=> __( $name ),
			),

			// Given labels
			$this->taxonomy_labels

		);

		// Default arguments, overwitten with the given arguments
		$args = array_merge(

			// Default
			array(
				'label'					=> $plural,
				'labels'				=> $labels,
				"hierarchical" 			=> true,
				'public' 				=> true,
				'show_ui' 				=> true,
				'show_in_nav_menus' 	=> true,
				'_builtin' 				=> false,
			),

			// Given
			$this->taxonomy_args

		);
		
		register_taxonomy( $this->taxonomy_name, $this->post_type_name, $args );
	}
	
	
	/**
	 * Used to attach the existing taxonomy to the post type
	 *
	 * @author Gijs Jorissen
	 * @since 0.2
	 *
	 */
	function register_taxonomy_for_object_type()
	{
		register_taxonomy_for_object_type( $this->taxonomy_name, $this->post_type_name );
	}	
}


/**
 * Registers the meta boxes
 *
 * @author Gijs Jorissen
 * @since 0.2
 *
 */
class Cuztom_Meta_Box
{
	var $box_id;
	var $box_title;
	var $box_context;
	var $box_priority;
	var $post_type_name;
	var $meta_fields;
	
	
	/**
	 * Constructs the meta box
	 *
	 * @param string $title
	 * @param array $fields
	 * @param string $post_type_name
	 * @param string $context
	 * @param string $priority
	 *
	 * @author Gijs Jorissen
	 * @since 0.2
	 *
	 */
	function __construct( $title, $fields = array(), $post_type_name = null, $context = 'normal', $priority = 'default' )
	{
		if( ! empty( $title ) )
		{
			$this->post_type_name 	= $post_type_name;
			
			// Meta variables	
			$this->box_id 			= Cuztom::uglify( $title );
			$this->box_title 		= Cuztom::beautify( $title );
			$this->box_context		= $context;
			$this->box_priority		= $priority;

			$this->meta_fields 	= $fields;

			add_action( 'admin_init', array( $this, 'add_meta_box' ) );
		}
		
		// Add multipart for files
		add_action( 'post_edit_form_tag', array( $this, 'post_edit_form_tag' ) );
		
		// Listen for the save post hook
		add_action( 'save_post', array( $this, 'save_post' ) );		
	}
	
	
	/**
	 * Method that calls the add_meta_box function
	 *
	 * @author Gijs Jorissen
	 * @since 0.2
	 *
	 */
	function add_meta_box()
	{			
		add_meta_box(
			$this->box_id,
			$this->box_title,
			array( $this, 'callback' ),
			$this->post_type_name,
			$this->box_context,
			$this->box_priority
		);
	}
	
	
	/**
	 * Main callback function of add_meta_box
	 *
	 * @param object $post
	 * @param object $data
	 * @return mixed
	 *
	 * @author Gijs Jorissen
	 * @since 0.2
	 *
	 */
	function callback( $post, $data )
	{
		// Nonce field for validation
		wp_nonce_field( plugin_basename( __FILE__ ), 'cuztom_nonce' );

		// Get all inputs from $data
		$meta_fields = $this->meta_fields;
		
		// Check the array and loop through it
		if( ! empty( $meta_fields ) )
		{
			echo '<div class="cuztom_helper">';
				echo '<table border="0" cellading="0" cellspacing="0" class="cuztom_table cuztom_helper_table">';
						
					/* Loop through $meta_fields */
					foreach( $meta_fields as $field )
					{
						$field_id_name = '_' . Cuztom::uglify( $this->box_title ) . "_" . Cuztom::uglify( $field['name'] );
						$meta = get_post_meta( $post->ID, $field_id_name );
					
						echo '<tr>';
							echo '<th class="cuztom_th th">';
								echo '<label for="' . $field_id_name . '" class="cuztom_label">' . $field['label'] . '</label>';
								echo '<div class="cuztom_description description">' . $field['description'] . '</div>';
							echo '</th>';
							echo '<td class="cuztom_td td">';
						
								Cuztom_Field::output( $field_id_name, $field, $meta[0] );
							
							echo '</td>';
						echo '</tr>';
					}
				
				echo '</table>';
			echo '</div>';
		}
	}
	
	
	/**
	 * Hooks into the save hook for the newly registered Post Type
	 *
	 * @author Gijs Jorissen
	 * @since 0.1
	 *
	 */
	function save_post()
	{		
		// Deny the wordpress autosave function
		if( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) return;

		if( $_POST && ! wp_verify_nonce( $_POST['cuztom_nonce'], plugin_basename( __FILE__ ) ) ) return;
		if( ! isset( $_POST ) ) return;
		
		global $post;
		if( ! isset( $post->ID ) && get_post_type( $post->ID ) !== $this->post_type_name ) return;
		
		// Loop through each meta box
		if( ! empty( $this->meta_fields ) )
		{
			foreach( $this->meta_fields as $field )
			{
				$field_id_name = '_' . Cuztom::uglify( $this->box_title ) . "_" . Cuztom::uglify( $field['name'] );
							
				if( $field['type'] == 'image' )
				{					
					if( isset( $_FILES ) && ! empty( $_FILES['cuztom']['tmp_name'][$field_id_name] ) )
					{
						$upload = wp_upload_bits( 
							$_FILES['cuztom']['name'][$field_id_name], 
							null, 
							file_get_contents( $_FILES['cuztom']['tmp_name'][$field_id_name] ) 
						);
						
						if( isset( $upload['error'] ) && $upload['error'] != 0 ) 
						{  
			                wp_die('There was an error uploading your file: ' . $upload['error']);  
			            } else {  
			                update_post_meta( $post->ID, $field_id_name, $upload['url']);
			            }
					}
				}
				else
				{
					$field_id_name = '_' . Cuztom::uglify( $this->box_title ) . "_" . Cuztom::uglify( $field['name'] );				
					update_post_meta( $post->ID, $field_id_name, $_POST['cuztom'][$field_id_name] );
				}
			}			
		}		
	}
	
	
	/**
	 * Adds multipart support to the post form
	 *
	 * @return mixed
	 *
	 * @author Gijs Jorissen
	 * @since 0.2
	 *
	 */
	function post_edit_form_tag()
	{
		echo ' enctype="multipart/form-data"';
	}
}


/**
 * Class to register Menu Pages
 *
 * @author Gijs Jorissen
 * @since 0.4
 *
 */
class Cuztom_Menu_Page
{
	var $page_title;
	var $menu_title;
	var $capability;
	var $menu_slug;
	var $function;
	var $icon_url;
	var $position;
	
	
	/**
	 * Constructor
	 *
	 * @param string $page_title
	 * @param string $menu_title
	 * @param string $capability
	 * @param string $menu_slug
	 * @param string $function
	 * @param string $icon_url
	 * @param int $position
	 *
	 * @author Gijs Jorissen 
	 * @since 0.4
	 *
	 */
	function __construct( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url = '', $position = 100 )
	{
		$this->page_title = Cuztom::beautify( $page_title );
		$this->menu_title = Cuztom::beautify( $menu_title );
		$this->capability = $capability;
		$this->menu_slug = Cuztom::uglify( $menu_slug );
		$this->function = $function;
		$this->icon_url = $icon_url;
		$this->position = $position;
		
		add_action( 'admin_menu', array( $this, 'register_menu_page' ) );
	}
	
	
	/**
	 * Hooked function to regster the menu page
	 *
	 * @author Gijs Jorissen
	 * @since 0.4
	 *
	 */
	function register_menu_page()
	{
		add_menu_page( 
			$this->page_title, 
			$this->menu_title, 
			$this->capability, 
			$this->menu_slug, 
			$this->function, 
			$this->icon_url,
			$this->position
		);
	}
	
	
	/**
	 * Add submenu page to the current parent page
	 * Method chaining is possible
	 *
	 * @param string $page_title
	 * @param string $menu_title
	 * @param string $capability
	 * @param string $menu_slug
	 * @param string $functions
	 *
	 * @author Gijs Jorissen
	 * @since 0.4
	 *
	 */
	function add_submenu_page( $page_title, $menu_title, $capability, $menu_slug, $function )
	{
		$submenu = new Cuztom_Submenu_Page( $this->menu_slug, $page_title, $menu_title, $capability, $menu_slug, $function );
		
		// For method chaining
		return $this;
	}
}


/**
 * Cuztom class to create submenus
 *
 * @author Gijs Jorissen
 * @since 0.4
 *
 */
class Cuztom_Submenu_Page
{
	var $parent_slug;
	var $page_title;
	var $menu_title;
	var $capability;
	var $menu_slug;
	var $function;
	
	
	/**
	 * Constructor
	 *
	 * @param string $parent_slug
	 * @param string $page_title
	 * @param string $menu_title
	 * @param string $capability
	 * @param string $menu_slug
	 * @param string $function
	 *
	 * @author Gijs Jorissen
	 * @since 0.4
	 *
	 */
	function __construct( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function )
	{
		$this->parent_slug = $parent_slug;
		$this->page_title = Cuztom::beautify( $page_title );
		$this->menu_title = Cuztom::beautify( $menu_title );
		$this->capability = $capability;
		$this->menu_slug = Cuztom::uglify( $menu_slug );
		$this->function = $function;
		
		add_action( 'admin_menu', array( $this, 'register_submenu_page' ) );
	}
	
	
	/**
	 * Calls the add submenu page
	 *
	 * @author Gijs Jorissen
	 * @since 0.4
	 *
	 */
	function register_submenu_page()
	{
		add_submenu_page(
			$this->parent_slug,
			$this->page_title, 
			$this->menu_title, 
			$this->capability, 
			$this->menu_slug, 
			$this->function
		);
	}
}


/**
 * Registers sidebars
 *
 * @author Gijs Jorissen
 * @since 0.5
 *
 */
class Cuztom_Sidebar
{
	var $sidebar_name;
	var $sidebar_id;
	var $sidebar_description;
	var $before_widget;
	var $after_widget;
	var $before_title;
	var $after_title;
	
	
	/**
	 * Constructor
	 *
	 * @param string $name
	 * @param string $description
	 * @param string $before_widget
	 * @param string $after_widget
	 * @param string $before_title
	 * @param string $after_title
	 *
	 * @author Gijs Jorissen
	 * @since 0.5
	 *
	 */
	function __construct( $name, $id, $description = '', $before_widget = '', $after_widget = '', $before_title = '', $after_title = '' )
	{
		$this->sidebar_name = Cuztom::beautify( $name );
		$this->sidebar_id = Cuztom::uglify( $id );
		$this->sidebar_description = $description;
		$this->before_widget = $before_widget;
		$this->after_widget = $after_widget;
		$this->before_title = $before_title;
		$this->after_title = $after_title;
		
		add_action( 'init', array( $this, 'register_sidebar' ) );
	}
	
	
	/**
	 * Register the Sidebar
	 *
	 * @author Gijs Jorissen
	 * @since 0.1
	 *
	 */
	function register_sidebar()
	{
		register_sidebar( array(
			'name' => $this->sidebar_name,
			'id' => $this->sidebar_id,
			'description' => $this->sidebar_description,
			'before_widget' => $this->before_widget,
			'after_widget' => $this->after_widget,
			'before_title' => $this->before_title,
			'after_title' => $this->after_title,
		) );
	}
}

?>