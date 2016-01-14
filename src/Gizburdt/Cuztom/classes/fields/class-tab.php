<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Tab extends Cuztom_Field
{
	/**
	 * Title
	 */
	var $title;

	/**
	 * Fields
	 */
	var $fields = array();

	/**
	 * Tab constructor
	 *
	 * @author 	Gijs Jorissen
	 * @since   3.0
	 *
	 */
	function __construct( $args )
	{
		parent::__construct( $args );

		if( ! $this->id ) {
			$this->id = Cuztom::uglify( $this->title );
		}
	}

	/**
	 * Outputs a tab
	 *
	 * @author 	Gijs Jorissen
	 * @since 	3.0
	 *
	 */
	function output( $args = array() )
	{
		$fields 	= $this->fields;
		$object_id 	= $this->object;

		// Show header
		if( $args['type'] == 'accordion' ) echo '<h3>' . $this->title . '</h3>';

		echo '<div id="' . $this->id . '">';

			if( $fields instanceof Cuztom_Bundle )
			{
				$fields->output( $field->value );
			}
			else
			{
				echo '<table border="0" cellading="0" cellspacing="0" class="from-table cuztom-table">';
					foreach( $fields as $id => $field )
					{
						if( ! $field instanceof Cuztom_Field_Hidden )
						{
							echo '<tr class="cuztom-tr">';
								echo '<th class="cuztom-th">';
									echo '<label for="' . $id . '" class="cuztom-label">' . $field->label . '</label>';
									echo $field->required ? ' <span class="cuztom-required">*</span>' : '';
									echo '<div class="cuztom-field-description">' . $field->description . '</div>';
								echo '</th>';
								echo '<td class="cuztom-td">';

									if( $field->repeatable && $field->_supports_repeatable )
									{
										echo '<a class="button-secondary cuztom-button js-cztm-add-sortable" href="#">' . sprintf( '+ %s', __( 'Add', 'cuztom' ) ) . '</a>';
										echo '<ul class="js-cztm-sortable cuztom-sortable cuztom_repeatable_wrap">';
											echo $field->output( $field->value );
										echo '</ul>';
									}
									else
									{
										echo $field->output( $field->value );
									}

								echo '</td>';
							echo '</tr>';

							$divider = true;
						}
						else
						{
							echo $field->output( $field->value );
						}
					}
				echo '</table>';
			}
		echo '</div>';
	}

	/**
	 * Save meta
	 *
	 * @param  	int 		$object_id
	 * @param  	string 		$value
	 *
	 * @author 	Gijs Jorissen
	 * @since  	3.0
	 *
	 */
	function save( $object, $values )
	{
		foreach( $this->fields as $id => $field )
		{
			// Get value from values
			$value = @$values[$id];

			// Save
			$field->save( $object, $value );
		}
	}

	/**
	 * Builds a tab
	 *
	 * @param 	array 	$data
	 * @param 	array 	$value
	 *
	 * @author 	Gijs Jorissen
	 * @since 	3.0
	 *
	 */
	function build( $data, $value )
	{
		foreach( $data as $type => $field ) {
			if( is_string( $type ) && $type == 'bundle' ) {
				// $tab->fields = $this->build( $fields );
			} else {
				$args = array_merge( $field, array( 'meta_type' => $this->meta_type, 'object' => $this->object, 'value'	=> @$value[$field['id']][0] ) );
				$field = Cuztom_Field::create( $args );

				$this->fields[$field->id] = $field;
			}
		}
	}
}