<?php

/**
 * Registers the meta boxes
 *
 * @author Gijs Jorissen
 * @since 0.2
 *
 */
class Cuztom_Meta_Box
{
	var $id;
	var $title;
	var $context;
	var $priority;
	var $post_type_name;
	var $data;
	var $fields;
	
	
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
	function __construct( $title, $post_type_name, $data = array(), $context = 'normal', $priority = 'default' )
	{
		if( ! empty( $title ) )
		{
			$this->post_type_name 	= $post_type_name;
			
			// Meta variables	
			$this->id 			= Cuztom::uglify( $title );
			$this->title 		= Cuztom::beautify( $title );
			$this->context		= $context;
			$this->priority		= $priority;

			// Build the meta box and fields
			$this->_build( $data );
			
			// Actions and filters
			add_filter( 'manage_posts_columns', array( $this, 'add_column_head' ) );
			add_action( 'manage_posts_custom_column', array( $this, 'add_column_content' ), 10, 2 );
			
			// Add multipart for files/images
			add_action( 'post_edit_form_tag', array( $this, 'post_edit_form_tag' ) );

			// Listen for the save post hook
			add_action( 'save_post', array( $this, 'save_post' ) );
			
			// Add the meta box
			add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		}	
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
			$this->id,
			$this->title,
			array( $this, 'callback' ),
			$this->post_type_name,
			$this->context,
			$this->priority
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
		$data = $this->data;
		
		if( ! empty( $data ) )
		{
			// Hidden field, so cuztom is always set
			echo '<input type="hidden" name="cuztom[__activate]" />';
			echo '<div class="cuztom_helper">';
			
				if( ( $data instanceof Cuztom_Tabs ) || ( $data instanceof Cuztom_Accordion ) )
				{
					
				}
				elseif( $data instanceof Cuztom_Bundle )
				{
					
				}
				elseif( is_array( $data ) )
				{					
					echo '<table border="0" cellading="0" cellspacing="0" class="cuztom_table cuztom_helper_table">';

						/* Loop through $data */
						foreach( $data as $field_id_name => $field )
						{
							$meta = get_post_meta( $post->ID, $field_id_name, true ) ? get_post_meta( $post->ID, $field_id_name, true ) : false;

							if( $field->type != 'hidden' )
							{
								echo '<tr>';
									echo '<th class="cuztom_th th">';
										echo '<label for="' . $field_id_name . '" class="cuztom_label">' . $field->label . '</label>';
										echo '<div class="cuztom_description description">' . $field->description . '</div>';
									echo '</th>';
									echo '<td class="cuztom_td td">';

										if( $field->repeatable && $field->_supports_repeatable() )
										{
											echo '<div class="cuztom_padding_wrap">';
											echo '<a class="button-secondary cuztom_add cuztom_add_field cuztom_button" href="#">';
											echo '+ ' . __( 'Add', CUZTOM_TEXTDOMAIN ) . '</a>';
											echo '<ul class="cuztom_repeatable_wrap">';
										}
										
											echo $field->output( $meta );

										if( $field->repeatable && $field->_supports_repeatable() )
										{
											echo '</ul></div>';
										}

									echo '</td>';
								echo '</tr>';
							}
							else
							{
								echo $field->output( $meta );
							}
						}

					echo '</table>';
				}
			
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
	function save_post( $post_id )
	{			
		// Deny the wordpress autosave function
		if( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) return;
		
		// Verify nonce
		if( ! isset( $_POST['cuztom_nonce'] ) || ! wp_verify_nonce( $_POST['cuztom_nonce'], plugin_basename( __FILE__ ) ) ) return;
		
		// Is the post from the given post type?
		if( get_post_type( $post_id ) != $this->post_type_name ) return;
		
		// Is the current user capable to edit this post
		if( ! current_user_can( get_post_type_object( $this->post_type_name )->cap->edit_post, $post_id ) ) return;
		
		// Loop through each meta box
		if( ! empty( $this->data ) && isset( $_POST['cuztom'] ) )
		{			
			if( isset( $this->data[0] ) && ! is_array( $this->data[0] ) && ( $this->data[0] == 'tabs' || $this->data[0] == 'accordion' ) )
			{
				$tabs = array_slice( $this->data, 1 );
				
				foreach( $tabs as $tab => $fields )
				{							
					foreach( $fields as $field_id_name => $field )
					{									
						$this->_save_meta( $post_id, $field, $field_id_name );
					}
				}
			}
			elseif( isset( $this->data[0] ) && ! is_array( $this->data[0] ) && ( $this->data[0] == 'bundle' ) )
			{
				delete_post_meta( $post_id, $this->id );
				
				foreach( $_POST['cuztom'][$this->id] as $bundle_id => $bundle )
				{
					$this->_save_meta( $post_id, $this->id, $bundle_id );
				}
			}
			else
			{
				foreach( $this->data as $field_id_name => $field )
				{
					$this->_save_meta( $post_id, $field, $field_id_name );
				}
			}
		}		
	}
	
	
	/**
	 * Actual method that saves the post meta
	 *
	 * @param integer $post_id
	 * @param string $field  
	 * @param string $field_id_name
	 *
	 * @author Gijs Jorissen
	 * @since 0.7
	 *
	 */
	function _save_meta( $post_id, $field, $id_name )
	{
		if( isset( $this->data[0] ) && ! is_array( $this->data[0] ) && ( $this->data[0] == 'bundle' ) )
		{
			$value = isset( $_POST['cuztom'][$field][$id_name] ) ? $_POST['cuztom'][$field][$id_name] : '';
			add_post_meta( $post_id, $field, $value );
		}
		else
		{
			$value = isset( $_POST['cuztom'][$id_name] ) ? $_POST['cuztom'][$id_name] : '';

			if( $field['type'] == 'wysiwyg' ) $value = wpautop( $value );
			if( ( $field['type'] == 'checkbox' || $field['type'] == 'checkboxes' || $field['type'] == 'post_checkboxes' 
				|| $field['type'] == 'term_checkboxes' ) && empty( $value ) ) $value = '-1';

			update_post_meta( $post_id, $id_name, $value );
		}
	}
	
	
	/**
	 * Used to add a column head to the Post Type's List Table
	 *
	 * @param array $default
	 * @return array
	 *
	 * @author Gijs Jorissen
	 * @since 1.1
	 *
	 */
	function add_column_head( $default )
	{
		$data = $this->data;
		
		foreach( $this->fields as $field_id_name => $field )
		{
			if( $field->show_column ) $default[$field_id_name] = $field->label;
		}

		return $default;
	}
	
	
	/**
	 * Used to add the column content to the column head
	 *
	 * @param string $column
	 * @param int $post_id
	 * @return mixed
	 *
	 * @author Gijs Jorissen
	 * @since 1.1
	 *
	 */
	function add_column_content( $column, $post_id )
	{
		$meta = get_post_meta( $post_id, $column, true );
		
		foreach( $this->fields as $field_id_name => $field )
		{
			if( $column == $field_id_name )
			{
				echo $field->repeatable && $field->_supports_repeatable() ? implode( $meta, ', ' ) : $meta;
				break;
			}
		}
	}
	
	
	/**
	 * This array builds the complete array with the right key => value pairs
	 *
	 * @param array $data
	 * @return array
	 *
	 * @author Gijs Jorissen
	 * @since 1.1
	 *
	 */
	function _build( $data )
	{
		$array = array();
		
		if( is_array( $data ) )
		{
			if( self::_is_tabs( $data ) || self::_is_accordion( $data ) )
			{
				$array[0] = $data[0];

				foreach( $data[1] as $title => $fields )
				{			
					$array[$title] = array();

					foreach( $fields as $field )
					{
						$class = 'Cuztom_Field_' . str_replace( ' ', '_', ucwords( str_replace( '_', ' ', $field['type'] ) ) );
						if( class_exists( $class ) )
						{
							$field = new $class( $field, $this->id );

							$this->fields[$field->id_name] = $field;
							$array[$field->id_name] = $field;
						}
					}
				}
			}
			elseif( self::_is_bundle( $data ) )
			{
				$array[0] = $data[0];
				$array[$this->id] = array();

				foreach( $data[1] as $field )
				{
					$class = 'Cuztom_Field_' . str_replace( ' ', '_', ucwords( str_replace( '_', ' ', $field['type'] ) ) );
					if( class_exists( $class ) )
					{
						$field = new $class( $field, $this->id );
						$field->repeatable = false;

						$this->fields[$field->id_name] = $field;
						$array[$field->id_name] = $field;
					}
				}
			}
			else
			{
				foreach( $data as $field )
				{
					$class = 'Cuztom_Field_' . str_replace( ' ', '_', ucwords( str_replace( '_', ' ', $field['type'] ) ) );
					if( class_exists( $class ) )
					{
						$field = new $class( $field, $this->id );

						$this->fields[$field->id_name] = $field;
						$array[$field->id_name] = $field;
					}
				}
			}
		}
		
		$this->data = $array;
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
	static function post_edit_form_tag()
	{
		echo ' enctype="multipart/form-data"';
	}
	
	
	/**
	 * Checks if the given array are tabs
	 *
	 * @param array $data
	 * @return bool
	 *
	 * @author Gijs Jorissen
	 * @since 1.3
	 *
	 */
	static function _is_tabs( $data )
	{
		return ( ! is_array( $data[0] ) ) && ( $data[0] == 'tabs' );
	}
	
	
	/**
	 * Checks if the given array is an accordion
	 *
	 * @param array $data
	 * @return bool
	 *
	 * @author Gijs Jorissen
	 * @since 1.3
	 *
	 */
	static function _is_accordion( $data )
	{
		return ( ! is_array( $data[0] ) ) && ( $data[0] == 'accordion' );
	}
	
	
	/**
	 * Checks if the given array is a bundle
	 *
	 * @param array $data
	 * @return bool
	 *
	 * @author Gijs Jorissen
	 * @since 1.3
	 *
	 */
	static function _is_bundle( $data )
	{
		return ( ! is_array( $data[0] ) ) && ( $data[0] == 'bundle' );
	}
}