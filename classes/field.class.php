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
				echo '<input type="text" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '" value="' . ( ! empty( $value ) ? $value : $field['default_value'] ) . '" />';
			break;
			
			case 'textarea' :
				echo '<textarea name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '">' . ( ! empty( $value ) ? $value : $field['default_value'] ) . '</textarea>';
			break;
			
			case 'checkbox' :
				echo '<input type="checkbox" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '" ' . ( ! empty( $value ) ? checked( $value, 'on', false ) : checked( $field['default_value'], 'on', false ) ) . ' />';
			break;
			
			case 'radio' :
				echo '<input type="radio" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '" ' . ( ! empty( $value ) ? checked( $value, 'on', false ) : checked( $field['default_value'], 'on', false ) ) . ' />';
			break;
			
			case 'yesno' :
				echo '<div class="cuztom_checked_wrap">';
					echo '<input type="radio" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '_yes" value="yes" ' . ( ! empty( $value ) ? checked( $value, 'yes', false ) : checked( $field['default_value'], 'yes', false ) ) . ' /> ';
					echo '<label for="' . $field_id_name . '_yes">' . __( 'Yes', CUZTOM_TEXTDOMAIN ) . '</label>';
					echo '<br />';
					echo '<input type="radio" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '_no" value="no" ' . ( ! empty( $value ) ? checked( $value, 'no', false ) : checked( $field['default_value'], 'no', false ) ) . ' /> ';
					echo '<label for="' . $field_id_name . '_no">' . __( 'No', CUZTOM_TEXTDOMAIN ) . '</label>';
				echo '</div>';
			break;
			
			case 'select' :
				echo '<select name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '">';
					if( is_array( $field['options'] ) )
					{
						foreach( $field['options'] as $slug => $name )
						{
							echo '<option value="' . Cuztom::uglify( $slug ) . '" ' . ( ! empty( $value ) ? selected( Cuztom::uglify( $slug ), $value, false ) : selected( $field['default_value'], Cuztom::uglify( $slug ), false ) ) . '>' . Cuztom::beautify( $name ) . '</option>';
						}
					}
				echo '</select>';
			break;
			
			case 'checkboxes' :				
				echo '<div class="cuztom_checked_wrap">';
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
			
			case 'radios' :
				echo '<div class="cuztom_checked_wrap">';
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
			
			case 'date' :
				echo '<input type="text" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '" class="cuztom_datepicker datepicker" value="' . ( ! empty( $value ) ? $value : $field['default_value'] ) . '" />';
			break;
			
			case 'color' :
				echo '<input type="text" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '" class="cuztom_colorpicker colorpicker" value="' . ( ! empty( $value ) ? $value : $field['default_value'] ) . '" />';
			break;
			
			case 'posts' :
				$options = array_merge(
					
					// Default
					array(
						'post_type'		=> 'post',
						'type'			=> 'checkboxes'
					),
					
					// Given
					isset( $field['options'] ) ? $field['options'] : array()
				
				);
				
				$post_type = $options['post_type'];
				$posts = get_posts( array( 'post_type' => $post_type ) );
				
				switch( $options['type'] ) :
				
					case 'checkboxes' :
						echo '<div class="cuztom_posts_wrap cuztom_checked_wrap">';
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
					
					case 'select' :
						echo '<select name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '">';
							if( is_array( $posts ) )
							{
								foreach( $posts as $post )
								{
									echo '<option value="' . $post->ID . '" ' . ( ! empty( $value ) ? selected( $post->ID, $value, false ) : selected( $field['default_value'], $post->ID, false ) ) . '>' . $post->post_title . '</option>';
								}
							}
						echo '</select>';
					break;
					
					default :
						_e( 'Unknown input type', CUZTOM_TEXTDOMAIN );
					break;
				
				endswitch;
			break;
			
			case 'terms' :
				$options = array_merge(
					
					// Default
					array(
						'taxonomy'		=> 'category',
						'type'			=> 'checkboxes'
					),
					
					// Given
					isset( $field['options'] ) ? $field['options'] : array()
					
				);
				
				$taxonomy = $options['taxonomy'];
				$terms = get_terms( $taxonomy, array( 'hide_empty' => false ) );
				
				switch( $options['type'] ) :
				
					case 'checkboxes' :
						echo '<div class="cuztom_taxonomy_wrap cuztom_checked_wrap">';
							if( is_array( $terms ) )
							{
								foreach( $terms as $term )
								{
									echo '<input type="checkbox" name="cuztom[' . $field_id_name . '][]" id="' . $field_id_name . '_' . Cuztom::uglify( $taxonomy ) . '" value="' . $term->term_id . '" ' . ( ! empty( $value ) ? ( in_array( $term->term_id, ( is_array( maybe_unserialize( $value ) ) ? maybe_unserialize( $value ) : array() ) ) ? 'checked="checked"' : '' ) : ( is_array( $field['default_value'] ) && in_array( $term->term_id, $field['default_value'] ) ) ? 'checked="checked"' : checked( $field['default_value'], $term->term_id, false ) ) . ' /> ';
									echo '<label for="' . $field_id_name . '_' . Cuztom::uglify( $taxonomy ) . '">' . $term->name . '</label>';
									echo '<br />';
								}
							}
						echo '</div>';
					break;
					
					case 'select' :
						
						$args = array(
							'echo' 			=> 1,
							'selected'		=> ( ! empty( $value ) ? $value : $field['default_value'] ),
							'orderby'		=> 'name',
							'order'			=> 'ASC',
							'taxonomy'		=> $taxonomy,
							'name'			=> 'cuztom[' . $field_id_name . ']',
							'hide_empty'	=> 0,
							'hierarchical'	=> 1
						);
						
						wp_dropdown_categories( $args );
					break;
					
					default :
						_e( 'Unknown input type', CUZTOM_TEXTDOMAIN );
					break;
				
				endswitch;
			break;
			
			case 'hidden':
				echo '<input type="hidden" name="cuztom[' . $field_id_name . ']" id="' . $field_id_name . '" value="' . $field['default_value'] . '" />';
			break;
			
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
				'options'		=> array()
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