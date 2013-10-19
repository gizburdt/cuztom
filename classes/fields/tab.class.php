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

	function output( $object, $type )
	{
		$fields = $this->fields;
				
		// Show header
		if( $type == 'accordion' ) echo '<h3>' . $this->title . '</h3>';
		
		echo '<div id="' . $this->id . '">';

			if( $fields instanceof Cuztom_Bundle )
			{
				$fields->output( $object );
			}
			else
			{
				echo '<table border="0" cellading="0" cellspacing="0" class="from-table cuztom-table">';
					foreach( $fields as $id => $field )
					{
						$value = $this->meta_type == 'user' ? get_user_meta( $object->ID, $id, true ) : get_post_meta( $object->ID, $id, true );

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
											echo $field->output( $value, $object );
										echo '</ul>';
									}
									else
									{
										echo $field->output( $value, $object );
									}

								echo '</td>';
							echo '</tr>';

							$divider = true;
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

	function save( $object_id, $values )
	{
		foreach( $this->fields as $id => $field )
		{
			// Get value from values (and apply filters)
			$value 	= isset( $values[$id] ) ? $values[$id] : '';

			// Save
			$field->save( $object_id, $value );
		}
	}
}