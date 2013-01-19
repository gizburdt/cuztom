<?php

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

		$this->id 			= Cuztom::uglify( $this->title );
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
	function callback( $post, $data = array() )
	{
		// Nonce field for validation
		wp_nonce_field( plugin_basename( dirname( __FILE__ ) ), 'cuztom_nonce' );

		// Get all inputs from $data
		$data 		= $this->data;
		$context	= $this->_get_meta_type();
		
		if( ! empty( $data ) )
		{
			// Hidden field, so cuztom is always set
			echo '<input type="hidden" name="cuztom[__activate]" />';
			echo '<div class="cuztom">';

				if( ! empty( $this->description ) ) echo '<p class="cuztom_box_description">' . $this->description . '</p>';
			
				if( ( $data instanceof Cuztom_Tabs ) || ( $data instanceof Cuztom_Accordion ) || ( $data instanceof Cuztom_Bundle ) )
				{
					$data->output( $post, $context );
				}
				else
				{					
					echo '<table border="0" cellading="0" cellspacing="0" class="form-table cuztom_table cuztom_helper_table">';

						/* Loop through $data */
						foreach( $data as $id_name => $field )
						{
							$meta = $this->_get_meta_type() == 'user' ? get_user_meta( $post->ID, $id_name, true ) : get_post_meta( $post->ID, $id_name, true );

							if( ! $field instanceof Cuztom_Field_Hidden )
							{
								echo '<tr>';
									echo '<th class="cuztom_th th">';
										echo '<label for="' . $id_name . '" class="cuztom_label">' . $field->label . '</label>';
										echo '<div class="cuztom_description description">' . $field->description . '</div>';
									echo '</th>';
									echo '<td class="cuztom_td td">';

										if( $field->repeatable && $field->_supports_repeatable() )
										{
											echo '<div class="cuztom_padding_wrap">';
											echo '<a class="button-secondary cuztom_add cuztom_add_field cuztom_button" href="#">';
											echo sprintf( '+ %s', __( 'Add', 'cuztom' ) );
											echo '</a>';
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
	 * Check what kind of meta we're dealing with
	 * 
	 * @return  string
	 *
	 * @author 	Gijs Jorissen
	 * @since 	1.5
	 * 
	 */
	function _get_meta_type()
	{
		return get_class( $this ) == 'Cuztom_User_Meta' ? 'user' : 'post';
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
	function _build( $data )
	{
		$array = array();
		
		if( is_array( $data ) && ! empty( $data ) )
		{
			if( self::_is_tabs( $data ) || self::_is_accordion( $data ) )
			{
				$tabs = self::_is_tabs( $data ) ? new Cuztom_Tabs() : new Cuztom_Accordion();
				$tabs->id = $this->id;

				foreach( $data[1] as $title => $fields )
				{			
					$tab = new Cuztom_Tab();
					$tab->id = Cuztom::uglify( $title );
					$tab->title = Cuztom::beautify( $title );

					foreach( $fields as $field )
					{
						$class = 'Cuztom_Field_' . str_replace( ' ', '_', ucwords( str_replace( '_', ' ', $field['type'] ) ) );
						if( class_exists( $class ) )
						{
							$field = new $class( $field, $this->id );

							$this->fields[$field->id_name] = $field;
							$tab->fields[$field->id_name] = $field;
						}
					}

					$tabs->tabs[$title] = $tab;
				}

				$this->data = $tabs;
			}
			elseif( self::_is_bundle( $data ) )
			{
				$bundle = new Cuztom_Bundle();
				$bundle->id = $this->id;

				foreach( $data[1] as $field )
				{
					$class = 'Cuztom_Field_' . str_replace( ' ', '_', ucwords( str_replace( '_', ' ', $field['type'] ) ) );
					if( class_exists( $class ) )
					{
						$field = new $class( $field, $this->id );
						$field->repeatable = false;

						$this->fields[$field->id_name] = $field;
						$bundle->fields[$field->id_name] = $field;
					}
				}

				$this->data = $bundle;
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

				$this->data = $array;
			}
		}
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
	static function _is_tabs( $data )
	{
		return ( ! is_array( $data[0] ) ) && ( $data[0] == 'tabs' );
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
	static function _is_accordion( $data )
	{
		return ( ! is_array( $data[0] ) ) && ( $data[0] == 'accordion' );
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
	static function _is_bundle( $data )
	{
		return ( ! is_array( $data[0] ) ) && ( $data[0] == 'bundle' );
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
	static function _edit_form_tag()
	{
		echo ' enctype="multipart/form-data"';
	}
}