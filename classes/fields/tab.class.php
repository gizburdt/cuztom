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
			echo '<table border="0" cellading="0" cellspacing="0" class="cuztom_table cuztom_helper_table">';
				foreach( $fields as $field_id_name => $field )
				{
					$value = $context == 'user' ? get_user_meta( $post->ID, $field_id_name, true ) : get_post_meta( $post->ID, $field_id_name, true );
					
					if( ! $field instanceof Cuztom_Field_Hidden )
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
									echo sprintf( '+ %s', __( 'Add', CUZTOM_TEXTDOMAIN ) );
									echo '</a>';
									echo '<ul class="cuztom_repeatable_wrap">';
								}
							
								echo $field->output( $value );
								
								if( $field->repeatable && $field->_supports_repeatable() )
								{
									echo '</ul></div>';
								}
								
							echo '</td>';
						echo '</tr>';
					}
					else
					{
						echo $field->output( $value );
					}
				}
			echo '</table>';
		echo '</div>';
	}
}