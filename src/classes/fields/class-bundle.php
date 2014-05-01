<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Bundle extends Cuztom_Field
{
	var $type 		= 'bundle';
	var $fields 	= array();

	/**
	 * Construct for bundle
	 *
	 * @param   array  		$bundle
	 *
	 * @author  Gijs Jorissen
	 * @since 	2.8.4
	 * 
	 */
	function __construct( $bundle )
	{
		parent::__construct( $bundle );
	}

	/**
	 * Output a row
	 *
	 * @author  Gijs Jorissen
	 * @since 	3.0
	 * 
	 */
	function output_row()
	{
		echo $this->output_control();

		echo '<tr class="cuztom-bundle">';
			echo '<td class="cuztom-field" id="' . $this->id . '" colspan="2">';
				echo '<div class="cuztom-bundles cuztom-bundles-' . $this->id . '">';
					echo '<ul class="js-cuztom-sortable cuztom-sortable" data-cuztom-sortable-type="bundle">';
						$this->output();
					echo '</ul>';
				echo '</div>';
			echo '</td>';
		echo '</tr>';
		
		echo $this->output_control();
	}

	/**
	 * Outputs a bundle
	 * 
	 * @param  	object 			$object
	 *
	 * @author  Gijs Jorissen
	 * @since   1.6.5
	 *
	 */
	function output( $value = null )
	{
		$i = 0;

		if( ! empty( $this->value ) && isset( $this->value[0] ) ) :
			foreach( $this->value as $bundle ) {
				echo $this->output_item( $i );
				$i++;
			}
		elseif( ! empty( $this->default_value ) ) :
			foreach( $this->default_value as $default ) {
				echo $this->output_item( $i );
				$i++;
			}
		else :
			echo $this->output_item();
		endif;
	}

	/**
	 * Outputs bundle item
	 *
	 * @param   int  		$index
	 *
	 * @author  Gijs Jorissen
	 * @since 	2.8.4
	 * 
	 */
	function output_item( $index = 0 )
	{
		$output = '<li class="cuztom-sortable-item">';
			$output .= '<div class="cuztom-handle-sortable js-cuztom-handle-sortable"><a href="#"></a></div>';
			$output .= '<fieldset class="cuztom-fieldset">';
				$output .= '<table border="0" cellading="0" cellspacing="0" class="form-table cuztom-table">';
					foreach( $this->fields as $id => $field )
					{
						$field->before_name 	= '[' . $this->id . '][' . $index. ']';
						$field->after_id 		= '_' . $index;
						$field->default_value 	= isset( $this->default_value[$index][$id] ) ? $this->default_value[$index][$id] : $field->default_value;
						$value 					= isset( $this->value[$index][$id] ) ? $this->value[$index][$id] : '';
						
						if( ! $field instanceof Cuztom_Field_Hidden )
						{
							$output .= '<tr>';
								$output .= '<th class="cuztom-th">';
									$output .= '<label for="' . $id . $field->after_id . '" class="cuztom-label">' . $field->label . '</label>';
									$output .= '<div class="cuztom-field-description">' . $field->description . '</div>';
								$output .= '</th>';
								$output .= '<td class="cuztom-td">';

									if( $field->_supports_bundle )
										$output .= $field->output();
									else
										$output .= '<em>' . __( 'This input type doesn\'t support the bundle functionality (yet).', 'cuztom' ) . '</em>';

								$output .= '</td>';
							$output .= '</tr>';
						}
						else
						{
							$output .= $field->output();
						}
					}
				$output .= '</table>';
			$output .= '</fieldset>';
			$output .= count( $this->value ) > 1 ? '<div class="cuztom-remove-sortable js-cuztom-remove-sortable"><a href="#"></a></div>' : '';
		$output .= '</li>';

		return $output;
	}

	function output_control()
	{
		echo '<tr class="cuztom-control cuztom-control-top">';
			echo '<td colspan="2">';
				echo '<a class="button-secondary cuztom-button button button-small js-cuztom-add-sortable js-cuztom-add-bundle" data-sortable-type="bundle" data-field-id="' . $this->id . '" href="#">';
					echo sprintf( '+ %s', __( 'Add item', 'cuztom' ) );
				echo '</a>';

				if( $this->limit ) {
					echo '<div class="cuztom-counter">';
						echo '<span class="current">' . count( $this->value ) . '</span>';
						echo '<span class="divider"> / </span>';
						echo '<span class="max">' . $this->limit . '</span>';
					echo '</div>';
				}
			echo '</td>';
		echo '</tr>';
	}

	/**
	 * Save bundle meta
	 * 
	 * @param  	int 			$post_id
	 * @param  	string 			$value
	 *
	 * @author 	Gijs Jorissen
	 * @since 	1.6.2
	 * 
	 */
	function save( $object, $values )
	{
		$values 	= array_values( $values );

		foreach( $values as $row => $fields ) 
		{
			foreach( $fields as $id => $value )
				$values[$row][$id] = $this->fields[$id]->save_value( $value );
		}

		switch( $this->meta_type ) :
			case 'user' :
				delete_user_meta( $object, $this->id );		
				update_user_meta( $object, $this->id, $values );
			break;
			default :
				delete_post_meta( $object, $this->id );
				update_post_meta( $object, $this->id, $values );
			break;
		endswitch;

		// TODO: Term meta
	}

	function build( $data, $value )
	{
		foreach( $data as $type => $field )
		{
			if( is_string( $type ) && $type == 'tabs' )
			{
				$tab->fields = $this->build( $fields );
			}
			else
			{
				$args = array_merge( $field, array( 'meta_type' => $this->meta_type, 'object' => $this->object, 'value'	=> maybe_unserialize( @$value[$field['id']][0] ) ) );
				
				$field = Cuztom_Field::create( $args );
				$field->repeatable 	= false;
				$field->ajax 		= false;
				$field->in_bundle 	= true;

				$this->fields[$field->id] = $field;
			}
		}
	}
}