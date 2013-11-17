<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Tab
{
	var $id;
	var $title;
	var $meta_type;
	var $fields = array();

	function __construct( $title )
	{
		$this->id 		= Cuztom::uglify( $title );
		$this->title 	= Cuztom::beautify( $title );
	}

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
										echo '<a class="button-secondary cuztom-button js-cuztom-add-sortable" href="#">' . sprintf( '+ %s', __( 'Add', 'cuztom' ) ) . '</a>';
										echo '<ul class="js-cuztom-sortable cuztom-sortable cuztom_repeatable_wrap">';
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

	function save( $object, $values )
	{
		foreach( $this->fields as $id => $field )
		{
			// Get value from values (and apply filters)
			$value 	= isset( $values[$id] ) ? $values[$id] : '';

			// Save
			$field->save( $object, $value );
		}
	}
}