<?php

if( ! defined( 'ABSPATH' ) ) exit;

/**
 * Cuztom Meta for handling meta data
 *
 * @author 	Gijs Jorissen
 * @since 	1.5
 *
 */
class Cuztom_Meta
{
	var $id;
	var $title;
	var $callback;
	var $data;
	var $fields;
	var $description;

	/**
	 * Construct for all meta types, creates title (and description)
	 * 
	 * @param 	string|array 	$title
	 *
	 * @author  Gijs Jorissen
	 * @since 	1.6.4
	 * 
	 */
	function __construct( $title )
	{
		if( is_array( $title ) )
		{
			$this->title 		= Cuztom::beautify( $title[0] );
			$this->description 	= $title[1];
		}
		else
		{
			$this->title 		= Cuztom::beautify( $title );
		}
	}

	/**
	 * Main callback for meta
	 *
	 * @param 	object 			$post
	 * @param 	object 			$data
	 * @return 	mixed
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.2
	 *
	 */	
	function callback( $object, $data = array() )
	{
		// Nonce field for validation
		wp_nonce_field( 'cuztom_meta', 'cuztom_nonce' );

		// Get all inputs from $data
		$data 		= $this->data;
		$meta_type 	= $this->get_meta_type();

		if( ! empty( $data ) )
		{
			echo '<input type="hidden" name="cuztom[__activate]" />';
			echo '<div class="cuztom" data-object-id="' . ( $meta_type == 'post' ? get_the_ID() : $object->ID ) . '" data-meta-type="' . $meta_type . '">';

				if( ! empty( $this->description ) ) echo '<p class="cuztom-box-description">' . $this->description . '</p>';
			
				if( ( $data instanceof Cuztom_Tabs ) || ( $data instanceof Cuztom_Accordion ) || ( $data instanceof Cuztom_Bundle ) )
				{
					$data->output( $object );
				}
				else
				{
					echo '<table border="0" cellading="0" cellspacing="0" class="form-table cuztom-table">';

						/* Loop through $data */
						foreach( $data as $id_name => $field )
						{
							$value = $this->is_meta_type( 'user' ) ? get_user_meta( $object->ID, $id_name, true ) : get_post_meta( $object->ID, $id_name, true );

							if( ! $field instanceof Cuztom_Field_Hidden )
							{
								echo '<tr>';
									echo '<th class="cuztom-th">';
										echo '<label for="' . $id_name . '" class="cuztom_label">' . $field->label . '</label>';
										echo $field->required ? ' <span class="cuztom-required">*</span>' : '';
										echo '<div class="cuztom-description description">' . $field->description . '</div>';
									echo '</th>';
									echo '<td class="cuztom-td">';

										if( $field->repeatable && $field->_supports_repeatable )
										{
											echo '<a class="button-secondary cuztom-button js-cuztom-add-field js-cuztom-add-sortable" href="#">';
												echo sprintf( '+ %s', __( 'Add', 'cuztom' ) );
											echo '</a>';
											echo '<ul class="js-cuztom-sortable cuztom-sortable cuztom_repeatable_wrap">';
												echo $field->output( $value, $object );
											echo '</ul>';
										}
										else
										{
											echo $field->output( $value, $object );
										}

									echo '</td>';
								echo '</tr>';
							}
							else
							{
								echo $field->output( $value, $object );
							}
						}

					echo '</table>';
				}
			
			echo '</div>';
		}
	}

	/**
	 * Normal save method to save all the fields in a metabox
	 * Metabox and User Meta rely on this method
	 *
	 * @author 	Gijs Jorissen
	 * @since 	2.6
	 */
	function save( $object_id, $values )
	{
		// Loop through each meta box
		if( ! empty( $this->data ) && isset( $_POST['cuztom'] ) )
		{
			if( $this->data instanceof Cuztom_Bundle && $bundle = $this->data )
			{
				if( isset( $values[$bundle->id] ) )
					$bundle->save( $object_id, $values[$bundle->id] );
			}
			elseif( $this->data instanceof Cuztom_Tabs || $this->data instanceof Cuztom_Accordion )
			{
				foreach( $this->data->tabs as $tab )
				{
					if( $tab->fields instanceof Cuztom_Bundle && $bundle = $tab->fields )
					{
						if( isset( $values[$bundle->id] ) )
							$bundle->save( $object_id, $values[$bundle->id] );
					}
					else
					{
						$this->save( $object_id, $values );
					}
				}
			}
			else
			{
				$this->save( $object_id, $values );
			}
		}
	}

	/**
	 * Check what kind of meta we're dealing with
	 * 
	 * @return  string
	 *
	 * @author 	Gijs Jorissen
	 * @since 	1.5
	 * 
	 */
	function get_meta_type()
	{
		switch( get_class( $this ) ) :
			case 'Cuztom_Meta_Box' : 
				return 'post'; 
				break;
			case 'Cuztom_User_Meta' : 
				return 'user'; 
				break;
			case 'Cuztom_Term_Meta' : 
				return 'term'; 
				break;
			default :
				return false; 
				break;
		endswitch;
	}

	/**
	 * Check what kind of meta we're dealing with
	 * 
	 * @return  string
	 *
	 * @author 	Gijs Jorissen
	 * @since 	2.3
	 * 
	 */
	function is_meta_type( $meta_type )
	{
		return $this->get_meta_type() == $meta_type;
	}
	
	/**
	 * Checks if the given array are tabs
	 *
	 * @param 	array 			$data
	 * @return 	boolean
	 *
	 * @author 	Gijs Jorissen
	 * @since 	1.3
	 *
	 */
	static function is_tabs( $data )
	{
		return isset( $data[0] ) && ( ! is_array( $data[0] ) ) && ( $data[0] == 'tabs' );
	}
	
	/**
	 * Checks if the given array is an accordion
	 *
	 * @param 	array 			$data
	 * @return 	bool
	 *
	 * @author 	Gijs Jorissen
	 * @since 	1.3
	 *
	 */
	static function is_accordion( $data )
	{
		return isset( $data[0] ) && ( ! is_array( $data[0] ) ) && ( $data[0] == 'accordion' );
	}
	
	/**
	 * Checks if the given array is a bundle
	 *
	 * @param 	array 			$data
	 * @return 	bool
	 *
	 * @author 	Gijs Jorissen
	 * @since 	1.3
	 *
	 */
	static function is_bundle( $data )
	{
		return isset( $data[0] ) && ( ! is_array( $data[0] ) ) && ( $data[0] == 'bundle' );
	}

	/**
	 * This array builds the complete array with the right key => value pairs
	 *
	 * @param 	array 			$data
	 * @return 	array
	 *
	 * @author 	Gijs Jorissen
	 * @since 	1.1
	 *
	 */
	function build( $data, $parent = null )
	{
		$return = array();

		if( is_array( $data ) && ! empty( $data ) )
		{
			if( self::is_tabs( $data ) || self::is_accordion( $data ) )
			{
				$tabs 				= self::is_tabs( $data ) ? new Cuztom_Tabs( $this->id ) : new Cuztom_Accordion( $this->id );
				$tabs->meta_type 	= $this->get_meta_type();

				foreach( $data[1] as $title => $fields )
				{
					$tab 			= new Cuztom_Tab( $title );
					$tab->meta_type = $this->get_meta_type();

					if( self::is_bundle( $fields[0] ) )
					{
						$tab->fields = $this->build( $fields[0] );
					}
					else
					{
						foreach( $fields as $field )
						{
							$class = 'Cuztom_Field_' . str_replace( ' ', '_', ucwords( str_replace( '_', ' ', $field['type'] ) ) );
							if( class_exists( $class ) )
							{
								$field = new $class( $field, $this->id );
								$field->meta_type 			= $this->get_meta_type();

								$this->fields[$field->id] 	= $field;
								$tab->fields[$field->id] 	= $field;
							}
						}
					}

					$tabs->tabs[$title] = $tab;
				}

				$return = $tabs;
			}
			elseif( self::is_bundle( $data ) )
			{
				$bundle 	= new Cuztom_Bundle( $this->id, $data );

				foreach( $data[1] as $field )
				{
					$class = 'Cuztom_Field_' . str_replace( ' ', '_', ucwords( str_replace( '_', ' ', $field['type'] ) ) );
					if( class_exists( $class ) )
					{
						$field = new $class( $field, '' );
						$field->repeatable 		= false;
						$field->ajax 			= false;
						$field->meta_type 		= $this->get_meta_type();
						$field->in_bundle 		= true;

						$this->fields[$field->id] 	= $field;
						$bundle->fields[$field->id] = $field;
						$bundle->meta_type 			= $this->get_meta_type();
					}
				}

				$return = $bundle;
			}
			else
			{
				foreach( $data as $field )
				{
					$class = 'Cuztom_Field_' . str_replace( ' ', '_', ucwords( str_replace( '_', ' ', $field['type'] ) ) );
					if( class_exists( $class ) )
					{
						$field = new $class( $field, $this->id );
						$field->meta_type 			= $this->get_meta_type();

						$this->fields[$field->id] 	= $field;
						$return[$field->id] 		= $field;
					}
				}
			}
		}

		return $return;
	}

	/**
	 * Adds multipart support to form
	 *
	 * @return 	mixed
	 *
	 * @author 	Gijs Jorissen
	 * @since 	0.2
	 *
	 */
	static function edit_form_tag()
	{
		echo ' enctype="multipart/form-data"';
	}
}