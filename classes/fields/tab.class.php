<?php

class Cuztom_Tab
{
	var $id;
	var $title;
	var $fields = array();

	function output( $post, $context, $type )
	{
		$fields = $this->fields;
				
		// Show header
		if( $type == 'accordion' ) echo '<h3>' . $this->title . '</h3>';
		
		echo '<div id="' . $this->id . '">';
			echo '<table border="0" cellading="0" cellspacing="0" class="from-table cuztom-table">';
				foreach( $fields as $field_id_name => $field )
				{
					$value = $context == 'user' ? get_user_meta( $post->ID, $field_id_name, true ) : get_post_meta( $post->ID, $field_id_name, true );
					
					if( ! $field instanceof Cuztom_Field_Hidden )
					{
						echo '<tr>';
							echo '<th class="cuztom-th">';
								echo '<label for="' . $field_id_name . '" class="cuztom-label">' . $field->label . '</label>';
								echo '<div class="cuztom-description">' . $field->description . '</div>';
							echo '</th>';
							echo '<td class="cuztom-td">';
							
								if( $field->repeatable && $field->_supports_repeatable() )
								{
									echo '<div class="cuztom-padding-wrap">';
									echo '<a class="button-secondary cuztom-button js-cuztom-add-field js-cuztom-add-sortable" href="#">';
										echo sprintf( '+ %s', __( 'Add', 'cuztom' ) );
									echo '</a>';
									echo '<ul class="js-cuztom-sortable cuztom-sortable">';
								}
							
								echo $field->output( $value, $post );
								
								if( $field->repeatable && $field->_supports_repeatable() )
								{
									echo '</ul></div>';
								}
								
							echo '</td>';
						echo '</tr>';
					}
					else
					{
						echo $field->output( $value, $post );
					}
				}
			echo '</table>';
		echo '</div>';
	}
}