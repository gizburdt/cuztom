<?php

/**
 * Cuztom Field Class
 *
 * @author Gijs Jorissen
 * @since 0.3.3
 *
 */
class Cuztom_Field
{
	
	/**
	 * Outputs a field based on its type
	 *
	 * @param string $field_id_name
	 * @param array $type
	 * @param array $meta
	 * @return mixed
	 *
	 * @author Gijs Jorissen
	 * @since 0.2
	 *
	 */
	static function output( $field_id_name, $field, $value = '' )
	{		
		switch( $field['type'] ) :
			
			case 'text' :
				echo '<input type="text" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '" value="' . $value . '" />';
			break;
			
			case 'textarea' :
				echo '<textarea name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '">' . $value . '</textarea>';
			break;
			
			case 'checkbox' :
				echo '<input type="checkbox" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '" ' . checked( $value, 'on', false ) . ' />';
			break;
			
			case 'radio' :
				echo '<input type="radio" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '" ' . checked( $value, 'on', false ) . ' />';
			break;
			
			case 'yesno' :
				echo '<div class="cuztom_checked_wrap">';
					echo '<input type="radio" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '_yes" value="yes" ' . checked( $value, 'yes', false ) . ' /> ';
					echo '<label for="' . $field_id_name . '_yes">' . __( 'Yes', CUZTOM_TEXTDOMAIN ) . '</label>';
					echo '<br />';
					echo '<input type="radio" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '_no" value="no" ' . checked( $value, 'no', false ) . ' /> ';
					echo '<label for="' . $field_id_name . '_no">' . __( 'No', CUZTOM_TEXTDOMAIN ) . '</label>';
				echo '</div>';
			break;
			
			case 'select' :
				echo '<select name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '">';
					foreach( $field['options'] as $slug => $name )
					{
						echo '<option value="' . Cuztom::uglify( $slug ) . '" ' . selected( Cuztom::uglify( $slug ), $value, false ) . '>' . Cuztom::beautify( $name ) . '</option>';
					}
				echo '</select>';
			break;
			
			case 'checkboxes' :
				echo '<div class="cuztom_checked_wrap">';
					foreach( $field['options'] as $slug => $name )
					{
						echo '<input type="checkbox" name="cuztom[' . $field_id_name . '][]" id="' . $field_id_name . '_' . Cuztom::uglify( $slug ) . '" value="' . Cuztom::uglify( $slug ) . '" ' . ( in_array( Cuztom::uglify( $slug ), ( is_array( maybe_unserialize( $value ) ) ? maybe_unserialize( $value ) : array() ) ) ? 'checked="checked"' : '' ) . ' /> ';
						echo '<label for="' . $field_id_name . '_' . Cuztom::uglify( $slug ) . '">' . Cuztom::beautify( $name ) . '</label>';
						echo '<br />';
					}
				echo '</div>';
			break;
			
			case 'radios' :
				echo '<div class="cuztom_checked_wrap">';
					foreach( $field['options'] as $slug => $name )
					{
						echo '<input type="radio" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '_' . Cuztom::uglify( $slug ) . '" value="' . Cuztom::uglify( $slug ) . '" ' . checked( Cuztom::uglify( $slug ), $value, false ) . ' /> ';
						echo '<label for="' . $field_id_name . '_' . Cuztom::uglify( $slug ) . '">' . Cuztom::beautify( $name ) . '</label>';
						echo '<br />';
					}
				echo '</div>';
			break;
			
			case 'wysiwyg' :
				wp_editor( $value, $field_id_name, array_merge( 
					
					// Default
					array(
						'textarea_name' => 'cuztom[' . $field_id_name . ']',
						'media_buttons' => false
					),
					
					// Given
					isset( $field['options'] ) ? $field['options'] : array()
				
				) );
			break;
			
			case 'image' :
				$image = '';
				
				if( ! empty( $value ) )
				{
					$image = '<img src="' . $value . '" />';
				}
			
				echo '<div class="cuztom_button_wrap">';
					echo '<input type="hidden" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '" class="cuztom_hidden" value="' . ( ! empty( $value ) ? $value : '' ) . '"  />';
					echo '<input id="upload_image_button" type="button" value="' . __( 'Select image', CUZTOM_TEXTDOMAIN ) . '" class="cuztom_upload" />';
				echo '</div>';
				echo '<span class="cuztom_preview">' . $image . '</span>';
			break;
			
			case 'date' :
				echo '<input type="text" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '" class="cuztom_datepicker datepicker" value="' . $value . '" />';
			break;
			
			default:
				echo __( 'Unknown input type', CUZTOM_TEXTDOMAIN );
			break;
			
		endswitch;
	}
}

?>