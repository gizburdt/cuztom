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
	var $description;
	var $callback;
	var $data;
	var $fields;

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
		if( is_array( $title ) ) {
			$this->title 		= Cuztom::beautify( $title['title'] );
			$this->description 	= $title['description'];
		} else {
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
	function output( $object, $data = array(), $args = array() )
	{
		// Nonce field for validation
		wp_nonce_field( 'cuztom_meta', 'cuztom_nonce' );

		if( ! empty( $data ) )
		{
			echo '<input type="hidden" name="cuztom[__activate]" />';
			echo '<div class="cuztom data-object-id="' . $this->object . '" data-meta-type="' . $this->meta_type . '">';
				if( ! empty( $this->description ) )
					echo '<div class="cuztom-box-description">' . $this->description . '</div>';

				echo '<table class="form-table cuztom-table cuztom-main-table">';
					foreach( $this->data as $id => $field ) {
						$this->output_row( $field );
					}
				echo '</table>';
			echo '</div>';
		}
	}

	/**
	 * Outputs a row in a meta table
	 *
	 * @author 	Gijs Jorissen
	 * @since 	3.0
	 */
	function output_row( $field )
	{
		if( ( $field instanceof Cuztom_Tabs ) || ( $field instanceof Cuztom_Bundle ) )
		{
			$field->output_row();
		}
		else
		{
			if( ! $field instanceof Cuztom_Field_Hidden ) :
				echo '<tr class="cuztom-row cuztom-' . $field->type . '">';
					echo '<th>';
						echo '<label for="' . $field->id . '" class="cuztom-label">' . $field->label . '</label>';
						echo $field->required ? ' <span class="cuztom-required">*</span>' : '';
						echo '<div class="cuztom-field-description">' . $field->description . '</div>';
					echo '</th>';
					echo '<td class="cuztom-field" id="' . $field->id . '" data-id="' . $field->id . '">';
						if( $field->is_repeatable() ) :
							echo '<a class="button-secondary cuztom-button js-cuztom-add-sortable" href="#">' . sprintf( '+ %s', __( 'Add', 'cuztom' ) ) . '</a>';
							echo '<ul class="cuztom-sortable js-cuztom-sortable">';
								echo $field->output( $field->value );
							echo '</ul>';
						else :
							echo $field->output( $field->value );
						endif;
					echo '</td>';
				echo '</tr>';

				$divider = true;
			else :
				echo $field->output( $field->value );
			endif;
		}
	}

	/**
	 * Normal save method to save all the fields in a metabox
	 * Metabox and User Meta rely on this method
	 *
	 * @author 	Gijs Jorissen
	 * @since 	2.6
	 */
	function save( $object, $values )
	{
		// Loop through each meta box
		if( ! empty( $this->data ) && isset( $_POST['cuztom'] ) )
		{
			echo '<pre>';

			foreach( $this->data as $id => $field )
			{
				if( ( $field instanceof Cuztom_Tabs || $field instanceof Cuztom_Accordion ) && $tabs = $field ) :
					$tabs->save( $object, $values );
				elseif( $field instanceof Cuztom_Bundle && $bundle = $field ) :
					$value = isset( $values[$id] ) ? $values[$id] : '';
					$bundle->save( $object, $value );
				else :
					if( @$field->in_bundle ) 
						continue;

					$value = isset( $values[$id] ) ? $values[$id] : '';
					$field->save( $object, $value );
				endif;
			}
		}
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
		return $this->meta_type == $meta_type;
	}

	/**
	 * Get object ID
	 *
	 * @author 	Gijs Jorissen
	 * @since 	3.0
	 * 
	 */
	function get_object_id()
	{
		if( isset( $_GET['post'] ) ) :
			return $_GET['post'];
		elseif( isset( $_GET['user_id'] ) ) :
			return $_GET['user_id'];
		elseif( isset( $_GET['tag_ID'] ) ) :
			return $_GET['tag_ID'];
		else :
			return null;
		endif;

		// TODO: Use get_current_screen()
	}

	/**
	 * Get value bases on field id
	 * 
	 * @return  field
	 *
	 * @author 	Gijs Jorissen
	 * @since 	3.0
	 * 
	 */
	function get_meta_values( $field = null, $args = array( 'taxonomy' => '' ) )
	{
		switch( $this->meta_type ) :
			case 'post' :
				return get_post_meta( $this->object );
				break;
			case 'user' :
				return get_user_meta( $this->object );
				break;
			case 'term' :
				return get_cuztom_term_meta( $this->object, isset( $object->taxonomy ) ? $object->taxonomy : null );
				break;
			default :
				return false;
				break;
		endswitch;
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
		$object 		= $this->get_object_id();
		$this->object 	= $object;
		$return 		= array();
		$values			= $this->get_meta_values();

		if( is_array( $data ) && ! empty( $data ) )
		{
			foreach( $data as $type => $field )
			{
				// Tabs / accordion
				if( is_string( $type ) && ( $type == 'tabs' || $type == 'accordion' ) )
				{
					$tabs 				= $type == 'tabs' ? new Cuztom_Tabs( $field ) : new Cuztom_Accordion( $field );
					$tabs->meta_type 	= $this->meta_type;
					$tabs->object 		= $this->object;

					foreach( $field['fields'] as $title => $fields )
					{
						$tab 				= new Cuztom_Tab( $title );
						$tab->meta_type 	= $this->meta_type;
						$tab->object 		= $this->object;

						foreach( $fields as $type => $field )
						{
							if( is_string( $type ) && $type == 'bundle' )
							{
								$tab->fields 	= $this->build( $fields );
							}
							else
							{
								$args = array_merge(
									$field,
									array(
										'meta_type'		=> $this->meta_type,
										'object'		=> $this->object,
										'value'			=> @$values[$field['id']][0]
									)
								);

								$field = create_cuztom_field( $args );

								if( is_object( $field ) ) {
									$this->fields[$field->id] 	= $field;
									$tab->fields[$field->id] 	= $field;
								}
							}
						}

						$tabs->tabs[$title] = $tab;
					}

					$return[$tabs->id] = $tabs;
				}

				// Bundle
				elseif( is_string( $type ) && $type == 'bundle' )
				{
					$field 				= array_merge( array( 'id' => $field['id'] ), (array) $field );
					$bundle 			= new Cuztom_Bundle( $field );
					$bundle->meta_type 	= $this->meta_type;
					$bundle->object 	= $this->object;

					foreach( $field['fields'] as $type => $field )
					{
						if( is_string( $type ) && $type == 'tabs' )
						{
							$tab->fields 	= $this->build( $fields );
						}
						else
						{
							$args = array_merge(
								$field,
								array(
									'repeatable'	=> false,
									'ajax'			=> false,
									'in_bundle'		=> true,
									'meta_type'		=> $this->meta_type,
									'object'		=> $this->object,
									'value'			=> @$values[$field['id']][0]
								)
							);

							$field = create_cuztom_field( $args );

							if( is_object( $field ) ) {
								$this->fields[$field->id] 	= $field;
								$bundle->fields[$field->id] = $field;
							}
						}
					}

					$return[$bundle->id] = $bundle;
				}

				// Fields
				else
				{
					$args = array_merge(
						$field,
						array(
							'meta_type'		=> $this->meta_type,
							'object'		=> $this->object,
							'value'			=> @$values[$field['id']][0]
						)
					);

					$field = create_cuztom_field( $args );

					if( is_object( $field ) ) {
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