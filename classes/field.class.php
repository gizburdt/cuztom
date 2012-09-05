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
			
			// Text
			case 'text' :
				if( $field['repeatable'] && is_array( $value ) )
				{					
					foreach( $value as $item )
					{
						echo '<li class="cuztom_field"><div class="handle_repeatable"></div><input type="text" name="cuztom[' . $field_id_name . '][]" id="' . $field_id_name . '" value="' . ( ! empty( $item ) ? $item : $field['default_value'] ) . '" />' . ( count( $value ) > 1 ? '<div class="remove_repeatable"></div>' : '' ) . '</li>';
					}
				}
				else
				{
					echo ( $field['repeatable'] ? '<li class="cuztom_field"><div class="handle_repeatable"></div>' : '' ) . '<input type="text" name="cuztom[' . $field_id_name . ']' . ( $field['repeatable'] ? '[]' : '' ) . '" id="' . $field_id_name . '" value="' . ( ! empty( $value ) ? $value : $field['default_value'] ) . '" />' . ( $field['repeatable'] ? '</li>' : '' );
				}
			break;
			
			// Textarea
			case 'textarea' :
				if( $field['repeatable'] && is_array( $value ) )
				{
					foreach( $value as $item )
					{
						echo '<li class="cuztom_field"><div class="handle_repeatable"></div><textarea name="cuztom[' . $field_id_name . '][]" id="' . $field_id_name . '">' . ( ! empty( $item ) ? $item : $field['default_value'] ) . '</textarea>' . ( count( $value ) > 1 ? '<div class="remove_repeatable"></div>' : '' ) . '</li>';
					}
				}
				else
				{
					echo ( $field['repeatable'] ? '<li class="cuztom_field"><div class="handle_repeatable"></div>' : '' ) . '<textarea name="cuztom[' . $field_id_name . ']' . ( $field['repeatable'] ? '[]' : '' ) . '" id="' . $field_id_name . '">' . ( ! empty( $value ) ? $value : $field['default_value'] ) . '</textarea>' . ( $field['repeatable'] ? '</li>' : '' );
				}
			break;
			
			// Checkbox
			case 'checkbox' :
				echo '<input type="checkbox" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '" ' . ( ! empty( $value ) ? checked( $value, 'on', false ) : checked( $field['default_value'], 'on', false ) ) . ' />';
			break;
			
			// Radio
			case 'radio' :
				echo '<input type="radio" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '" ' . ( ! empty( $value ) ? checked( $value, 'on', false ) : checked( $field['default_value'], 'on', false ) ) . ' />';
			break;
			
			// Yes - No
			case 'yesno' :
				echo '<div class="cuztom_checked_wrap cuztom_padding_wrap">';
					echo '<input type="radio" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '_yes" value="yes" ' . ( ! empty( $value ) ? checked( $value, 'yes', false ) : checked( $field['default_value'], 'yes', false ) ) . ' /> ';
					echo '<label for="' . $field_id_name . '_yes">' . __( 'Yes', CUZTOM_TEXTDOMAIN ) . '</label>';
					echo '<br />';
					echo '<input type="radio" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '_no" value="no" ' . ( ! empty( $value ) ? checked( $value, 'no', false ) : checked( $field['default_value'], 'no', false ) ) . ' /> ';
					echo '<label for="' . $field_id_name . '_no">' . __( 'No', CUZTOM_TEXTDOMAIN ) . '</label>';
				echo '</div>';
			break;
			
			// Select
			case 'select' :
				if( $field['repeatable'] && is_array( $value ) )
				{
					foreach( $value as $item )
					{
						echo '<li class="cuztom_field"><div class="handle_repeatable"></div><select name="cuztom[' . $field_id_name . '][]" id="' . $field_id_name . '">';
							if( is_array( $field['options'] ) )
							{
								foreach( $field['options'] as $slug => $name )
								{
									echo '<option value="' . Cuztom::uglify( $slug ) . '" ' . ( ! empty( $item ) ? selected( Cuztom::uglify( $slug ), $item, false ) : selected( $field['default_value'], Cuztom::uglify( $slug ), false ) ) . '>' . Cuztom::beautify( $name ) . '</option>';
								}
							}
						echo '</select>' . ( count( $value ) > 1 ? '<div class="remove_repeatable"></div>' : '' ) . '</li>';
					}
				}
				else
				{
					echo ( $field['repeatable'] ? '<li class="cuztom_field"><div class="handle_repeatable"></div>' : '' ) . '<select name="cuztom[' . $field_id_name . ']' . ( $field['repeatable'] ? '[]' : '' ) . '" id="' . $field_id_name . '">';
						if( is_array( $field['options'] ) )
						{
							foreach( $field['options'] as $slug => $name )
							{
								echo '<option value="' . Cuztom::uglify( $slug ) . '" ' . ( ! empty( $value ) ? selected( Cuztom::uglify( $slug ), $value, false ) : selected( $field['default_value'], Cuztom::uglify( $slug ), false ) ) . '>' . Cuztom::beautify( $name ) . '</option>';
							}
						}
					echo '</select>' . ( $field['repeatable'] ? '</li>' : '' );
				}
			break;
			
			// Checkboxes
			case 'checkboxes' :		
				echo '<div class="cuztom_checked_wrap cuztom_padding_wrap">';
					if( is_array( $field['options'] ) )
					{
						foreach( $field['options'] as $slug => $name )
						{							
							echo '<input type="checkbox" name="cuztom[' . $field_id_name . '][]" id="' . $field_id_name . '_' . Cuztom::uglify( $slug ) . '" value="' . Cuztom::uglify( $slug ) . '" ' . ( ! empty( $value ) ? ( in_array( Cuztom::uglify( $slug ), ( is_array( maybe_unserialize( $value ) ) ? maybe_unserialize( $value ) : array() ) ) ? 'checked="checked"' : '' ) : ( is_array( $field['default_value'] ) && in_array( $slug, $field['default_value'] ) ) ? 'checked="checked"' : checked( $field['default_value'], Cuztom::uglify( $slug ), false ) ) . ' /> ';								
							echo '<label for="' . $field_id_name . '_' . Cuztom::uglify( $slug ) . '">' . Cuztom::beautify( $name ) . '</label>';
							echo '<br />';
						}
					}
				echo '</div>';
			break;
			
			// Radios
			case 'radios' :
				echo '<div class="cuztom_checked_wrap cuztom_padding_wrap">';
					if( is_array( $field['options'] ) )
					{
						foreach( $field['options'] as $slug => $name )
						{
							echo '<input type="radio" name="cuztom[' . $field_id_name . '][]" id="' . $field_id_name . '_' . Cuztom::uglify( $slug ) . '" value="' . Cuztom::uglify( $slug ) . '" ' . ( ! empty( $value ) ? ( in_array( Cuztom::uglify( $slug ), ( is_array( maybe_unserialize( $value ) ) ? maybe_unserialize( $value ) : array() ) ) ? 'checked="checked"' : '' ) : checked( $field['default_value'], Cuztom::uglify( $slug ), false ) ) . ' /> ';
							echo '<label for="' . $field_id_name . '_' . Cuztom::uglify( $slug ) . '">' . Cuztom::beautify( $name ) . '</label>';
							echo '<br />';
						}
					}
				echo '</div>';
			break;
			
			// WYSIWYG
			case 'wysiwyg' :
				wp_editor( ( ! empty( $value ) ? $value : $field['default_value'] ), $field_id_name, array_merge( 
					
					// Default
					array(
						'textarea_name' => 'cuztom[' . $field_id_name . ']',
						'media_buttons' => false
					),
					
					// Given
					isset( $field['options'] ) ? $field['options'] : array()
				
				) );
			break;
			
			// Image
			case 'image' :
				$image = '';
				
				if( ! empty( $value ) )
				{
					$image = '<img src="' . $value . '" />';
				}
			
				echo '<div class="cuztom_button_wrap">';
					echo '<input type="hidden" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '" class="cuztom_hidden" value="' . ( ! empty( $value ) ? $value : '' ) . '"  />';
					echo '<input id="upload_image_button" type="button" class="button cuztom_button cuztom_upload" value="' . __( 'Select image', CUZTOM_TEXTDOMAIN ) . '" class="cuztom_upload" />';
					echo ( ! empty( $value ) ? '<a href="#" class="cuztom_remove_image">' . __( 'Remove current image', CUZTOM_TEXTDOMAIN ) . '</a>' : '' );
				echo '</div>';
				echo '<span class="cuztom_preview">' . $image . '</span>';
			break;
			
			// Datepicker
			case 'date' :
				echo '<input type="text" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '" class="cuztom_datepicker datepicker" value="' . ( ! empty( $value ) ? $value : $field['default_value'] ) . '" />';
			break;
			
			// Colorpicker
			case 'color' :
				echo '<input type="text" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '" class="cuztom_colorpicker colorpicker" value="' . ( ! empty( $value ) ? $value : $field['default_value'] ) . '" />';
			break;
			
			// Post select
			case 'post_select' :
				$options = array_merge(
					
					// Default
					array(
						'post_type'		=> 'post',
					),
					
					// Given
					isset( $field['options'] ) ? $field['options'] : array()
				
				);
				
				$post_type = $options['post_type'];
				$posts = get_posts( $options );
				
				if( $field['repeatable'] && is_array( $value ) )
				{
					foreach( $value as $item )
					{
						echo '<li class="cuztom_field"><div class="handle_repeatable"></div><select name="cuztom[' . $field_id_name . '][]" id="' . $field_id_name . '">';
							if( is_array( $posts ) )
							{
								foreach( $posts as $post )
								{
									echo '<option value="' . $post->ID . '" ' . ( ! empty( $item ) ? selected( $post->ID, $item, false ) : selected( $field['default_value'], $post->ID, false ) ) . '>' . $post->post_title . '</option>';
								}
							}
						echo '</select>' . ( count( $value ) > 1 ? '<div class="remove_repeatable"></div>' : '' ) . '</li>';;
					}
				}
				else
				{
					echo ( $field['repeatable'] ? '<li class="cuztom_field"><div class="handle_repeatable"></div>' : '' ) . '<select name="cuztom[' . $field_id_name . ']' . ( $field['repeatable'] ? '[]' : '' ) . '" id="' . $field_id_name . '">';
						if( is_array( $posts ) )
						{
							foreach( $posts as $post )
							{
								echo '<option value="' . $post->ID . '" ' . ( ! empty( $value ) ? selected( $post->ID, $value, false ) : selected( $field['default_value'], $post->ID, false ) ) . '>' . $post->post_title . '</option>';
							}
						}
					echo '</select>' . ( $field['repeatable'] ? '</li>' : '' );
				}
			break;
			
			// Post checkboxes
			case 'post_checkboxes' :
				$options = array_merge(
					
					// Default
					array(
						'post_type'		=> 'post',
					),
					
					// Given
					isset( $field['options'] ) ? $field['options'] : array()
				
				);
				
				$post_type = $options['post_type'];
				$posts = get_posts( array( 'post_type' => $post_type ) );
				
				echo '<div class="cuztom_post_wrap cuztom_checked_wrap cuztom_padding_wrap">';
					if( is_array( $posts ) )
					{
						foreach( $posts as $post )
						{
							echo '<input type="checkbox" name="cuztom[' . $field_id_name . '][]" id="' . $field_id_name . '_' . Cuztom::uglify( $post->post_title ) . '" value="' . $post->ID . '" ' . ( ! empty( $value ) ? ( in_array( $post->ID, ( is_array( maybe_unserialize( $value ) ) ? maybe_unserialize( $value ) : array() ) ) ? 'checked="checked"' : '' ) : ( is_array( $field['default_value'] ) && in_array( $post->ID, $field['default_value'] ) ) ? 'checked="checked"' : checked( $field['default_value'], $post->ID, false ) ) . ' /> ';
							echo '<label for="' . $field_id_name . '_' . Cuztom::uglify( $post->post_title ) . '">' . $post->post_title . '</label>';
							echo '<br />';
						}
					}
				echo '</div>';
			break;
			
			// Term select
			case 'term_select' :
				$options = array_merge(
					
					// Default
					array(
						'taxonomy'		=> 'category',
					),
					
					// Given
					isset( $field['options'] ) ? $field['options'] : array()
					
				);
				
				$options['echo'] = 0;
				$options['name'] = $field_id_name;
				
				if( $field['repeatable'] && is_array( $value ) )
				{
					foreach( $value as $item )
					{
						$args['selected'] = ( ! empty( $item ) ? $item : $field['default_value'] );
						$args['name'] = 'cuztom[' . $field_id_name . '][]';
						
						echo '<li class="cuztom_field"><div class="handle_repeatable"></div>' . wp_dropdown_categories( $options ) . ( count( $value ) > 1 ? '<div class="remove_repeatable"></div>' : '' ) . '</li>';
					}
				}
				else
				{
					$args['selected'] = ( ! empty( $value ) ? $value : $field['default_value'] );
					$args['name'] = 'cuztom[' . $field_id_name . ']' . ( $field['repeatable'] ? '[]' : '' );
					
					echo ( $field['repeatable'] ? '<li class="cuztom_field"><div class="handle_repeatable"></div>' : '' ) . wp_dropdown_categories( $options ) . ( $field['repeatable'] ? '</li>' : '' );
				}
			break;
			
			// Term checkboxes
			case 'term_checkboxes' :
				$options = array_merge(
					
					// Default
					array(
						'taxonomy'		=> 'category',
					),
					
					// Given
					isset( $field['options'] ) ? $field['options'] : array()
					
				);
				
				$terms = get_terms( $options['taxonomy'], array( 'hide_empty' => false ) );
				
				echo '<div class="cuztom_taxonomy_wrap cuztom_checked_wrap cuztom_padding_wrap">';
					if( is_array( $terms ) )
					{
						foreach( $terms as $term )
						{
							echo '<input type="checkbox" name="cuztom[' . $field_id_name . '][]" id="' . $field_id_name . '_' . Cuztom::uglify( $term->name ) . '" value="' . $term->term_id . '" ' . ( ! empty( $value ) ? ( in_array( $term->term_id, ( is_array( maybe_unserialize( $value ) ) ? maybe_unserialize( $value ) : array() ) ) ? 'checked="checked"' : '' ) : ( is_array( $field['default_value'] ) && in_array( $term->term_id, $field['default_value'] ) ) ? 'checked="checked"' : checked( $field['default_value'], $term->term_id, false ) ) . ' /> ';
							echo '<label for="' . $field_id_name . '_' . Cuztom::uglify( $term->name ) . '">' . $term->name . '</label>';
							echo '<br />';
						}
					}
				echo '</div>';
			break;

			// Hidden field
			case 'hidden':
				echo '<input type="hidden" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '" value="' . $field['default_value'] . '" />';
			break;
			
			// The input type can't be found
			default :
				_e( 'Unknown input type', CUZTOM_TEXTDOMAIN );
			break;
			
		endswitch;
	}
	
	
	/**
	 * Checks if the field is hidden for the custom fields box
	 *
	 * @param array $field
	 * @return string
	 *
	 * @author Gijs Jorissen
	 * @since 0.9
	 *
	 */
	static function _is_hidden( $field )
	{
		return isset( $field['hide'] ) ? $field['hide'] : false;
	}
	
	
	/**
	 * Checks if the field supports repeatable functionality
	 *
	 * @param $field or $field_type
	 * @return boolean
	 *
	 * @author Gijs Jorissen
	 * @since 1.0
	 *
	 */
	static function _supports_repeatable( $field )
	{
		$field_type = is_array( $field ) ? $field['type'] : $field;
		$supports = apply_filters( 'supports_repeatable', array( 'text', 'textarea', 'select', 'post_select', 'term_select' ) );
		
		return in_array( $field_type, $supports );
	}
	
	
	/**
	 * Builds an array of a field with all the arguments needed
	 *
	 * @param array $field
	 * @return array
	 *
	 * @author Gijs Jorissen
	 * @since 0.9
	 *
	 */
	static function _build_array( $field )
	{
		$field = array_merge(
		
			// Default
			array(
				'name'          => '',
	            'label'         => '',
	            'description'   => '',
	            'type'          => 'text',
				'hide'			=> true,
				'default_value'	=> '',
				'options'		=> array(),
				'repeatable'	=> false,
				'show_column'	=> false
			),
			
			// Given
			$field
		
		);
		
		return $field;
	}
	
	
	/**
	 * Builds an string used as field id and name
	 *
	 * @param array $field
	 * @return string
	 *
	 * @author Gijs Jorissen
	 * @since 0.9
	 *
	 */
	static function _build_id_name( $field, $box_title )
	{
		return ( self::_is_hidden( $field ) ? '_' : '' ) . Cuztom::uglify( $box_title ) . "_" . Cuztom::uglify( $field['name'] );
	}
}

?>