<?php

/**
 * Registers the meta boxes
 *
 * @author Gijs Jorissen
 * @since 0.2
 *
 */
class Cuztom_Meta_Box
{
	var $box_id;
	var $box_title;
	var $box_context;
	var $box_priority;
	var $post_type_name;
	var $meta_data;
	
	
	/**
	 * Constructs the meta box
	 *
	 * @param string $title
	 * @param array $fields
	 * @param string $post_type_name
	 * @param string $context
	 * @param string $priority
	 *
	 * @author Gijs Jorissen
	 * @since 0.2
	 *
	 */
	function __construct( $title, $post_type_name, $data = array(), $context = 'normal', $priority = 'default' )
	{
		if( ! empty( $title ) )
		{
			$this->post_type_name 	= $post_type_name;
			
			// Meta variables	
			$this->box_id 			= Cuztom::uglify( $title );
			$this->box_title 		= Cuztom::beautify( $title );
			$this->box_context		= $context;
			$this->box_priority		= $priority;

			$this->meta_data 		= $data;

			add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		}
		
		// Add multipart for files
		add_action( 'post_edit_form_tag', array( $this, 'post_edit_form_tag' ) );
		
		// Listen for the save post hook
		add_action( 'save_post', array( $this, 'save_post' ) );	
	}
	
	
	/**
	 * Method that calls the add_meta_box function
	 *
	 * @author Gijs Jorissen
	 * @since 0.2
	 *
	 */
	function add_meta_box()
	{			
		add_meta_box(
			$this->box_id,
			$this->box_title,
			array( $this, 'callback' ),
			$this->post_type_name,
			$this->box_context,
			$this->box_priority
		);
	}
	
	
	/**
	 * Main callback function of add_meta_box
	 *
	 * @param object $post
	 * @param object $data
	 * @return mixed
	 *
	 * @author Gijs Jorissen
	 * @since 0.2
	 *
	 */
	function callback( $post, $data )
	{
		// Nonce field for validation
		wp_nonce_field( plugin_basename( __FILE__ ), 'cuztom_nonce' );

		// Get all inputs from $data
		$meta_data = $this->meta_data;

		// Check the array and loop through it
		if( ! empty( $meta_data ) )
		{
			// Hidden field, so cuztom is always set
			echo '<input type="hidden" name="cuztom[__activate]" />';
			
			if( ! is_array( $meta_data[0] ) && ( $meta_data[0] == 'tabs' || $meta_data[0] == 'accordion' ) )
			{
				// If it's about tabs or accordion
				echo '<div class="cuztom_helper">';	
					echo '<div class="' . ( $meta_data[0] == 'tabs' ? 'cuztom_tabs' : 'cuztom_accordion' ) . '">';
						
						// Show tabs
						if( $meta_data[0] == 'tabs' )
						{
							echo '<ul>';
								foreach( $meta_data[1] as $tab )
								{
									$tab_id = Cuztom::uglify( $tab[0] );

									echo '<li><a href="#' . $tab_id . '">' . Cuztom::beautify( $tab[0] ) . '</a></li>';
								}
							echo '</ul>';
						}
					
						/* Loop through $meta_data, tabs in this case */
						foreach( $meta_data[1] as $tab )
						{
							$tab_id = Cuztom::uglify( $tab[0] );
							
							// Show header if accordion
							if( $meta_data[0] == 'accordion' )
							{
								echo '<h3>' . Cuztom::beautify( $tab[0] ) . '</h3>';
							}
							
							echo '<div id="' . $tab_id . '">';
								echo '<table border="0" cellading="0" cellspacing="0" class="cuztom_table cuztom_helper_table">';
									foreach( $tab[1] as $field )
									{
										$field = Cuztom_Field::_build_array( $field );
										$field_id_name = Cuztom_Field::_build_id_name( $field, $this->box_title );
										$meta = get_post_meta( $post->ID, $field_id_name, true );
										
										if( $field['type'] != 'hidden' )
										{
											echo '<tr>';
												echo '<th class="cuztom_th th">';
													echo '<label for="' . $field_id_name . '" class="cuztom_label">' . $field['label'] . '</label>';
													echo '<div class="cuztom_description description">' . $field['description'] . '</div>';
												echo '</th>';
												echo '<td class="cuztom_td td">';
												
													cuztom_field( $field_id_name, $field, $meta );
													
												echo '</td>';
											echo '</tr>';
										}
										else
										{
											cuztom_field( $field_id_name, $field, $meta );
										}
									}
								echo '</table>';
							echo '</div>';
						}
					
					echo '</div>';
				echo '</div>';
			}
			else
			{
				echo '<div class="cuztom_helper">';
					echo '<table border="0" cellading="0" cellspacing="0" class="cuztom_table cuztom_helper_table">';

						/* Loop through $meta_data */
						foreach( $meta_data as $field )
						{
							$field = Cuztom_Field::_build_array( $field );
							$field_id_name = Cuztom_Field::_build_id_name( $field, $this->box_title );
							$meta = get_post_meta( $post->ID, $field_id_name, true ) ? get_post_meta( $post->ID, $field_id_name, true ) : false;
							
							if( $field['type'] != 'hidden' )
							{
								echo '<tr>';
									echo '<th class="cuztom_th th">';
										echo '<label for="' . $field_id_name . '" class="cuztom_label">' . $field['label'] . '</label>';
										echo '<div class="cuztom_description description">' . $field['description'] . '</div>';
									echo '</th>';
									echo '<td class="cuztom_td td">';
									
										if( $field['repeatable'] && Cuztom_Field::_supports_repeatable( $field ) )
										{
											echo '<a class="button-secondary cuztom_add" href="#">++</a>';
											echo '<ul class="cuztom_repeatable_wrap"><li class="cuztom_field">';
										}

										cuztom_field( $field_id_name, $field, $meta );
										
										if( $field['repeatable'] && Cuztom_Field::_supports_repeatable( $field ) )
										{
											echo '</li></ul>';
										}

									echo '</td>';
								echo '</tr>';
							}
							else
							{
								cuztom_field( $field_id_name, $field, $meta );
							}
						}

					echo '</table>';
				echo '</div>';
			}
		}
	}
	
	
	/**
	 * Hooks into the save hook for the newly registered Post Type
	 *
	 * @author Gijs Jorissen
	 * @since 0.1
	 *
	 */
	function save_post( $post_id )
	{			
		// Deny the wordpress autosave function
		if( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) return;
		
		// Verify nonce
		if( ! isset( $_POST['cuztom_nonce'] ) || ! wp_verify_nonce( $_POST['cuztom_nonce'], plugin_basename( __FILE__ ) ) ) return;
		
		// Is the post from the given post type?
		if( get_post_type( $post_id ) != $this->post_type_name ) return;
		
		// Is the current user capable to edit this post
		if( ! current_user_can( get_post_type_object( $this->post_type_name )->cap->edit_post, $post_id ) ) return;
		
		// Loop through each meta box
		if( ! empty( $this->meta_data ) && isset( $_POST['cuztom'] ) )
		{			
			if( ! is_array( $this->meta_data[0] ) && ( $this->meta_data[0] == 'tabs' || $this->meta_data[0] == 'accordion' ) )
			{
				foreach( $this->meta_data[1] as $tab )
				{								
					foreach( $tab[1] as $field )
					{									
						$field = Cuztom_Field::_build_array( $field );
						$field_id_name = Cuztom_Field::_build_id_name( $field, $this->box_title );
						$this->_save_meta( $post_id, $field, $field_id_name );
					}
				}
			}
			else
			{
				foreach( $this->meta_data as $field )
				{
					$field = Cuztom_Field::_build_array( $field );
					$field_id_name = Cuztom_Field::_build_id_name( $field, $this->box_title );	
					$this->_save_meta( $post_id, $field, $field_id_name );
				}
			}		
		}		
	}
	
	
	/**
	 * Actual method that saves the post meta
	 *
	 * @param integer $post_id
	 * @param string $field  
	 * @param string $field_id_name
	 *
	 * @author Gijs Jorissen
	 * @since 0.7
	 *
	 */
	function _save_meta( $post_id, $field, $field_id_name )
	{						
		$value = isset( $_POST['cuztom'][$field_id_name] ) ? $_POST['cuztom'][$field_id_name] : '';
		
		if( $field['type'] == 'wysiwyg' ) $value = wpautop( $value );
		
		update_post_meta( $post_id, $field_id_name, $value );
	}
	
	
	/**
	 * Adds multipart support to the post form
	 *
	 * @return mixed
	 *
	 * @author Gijs Jorissen
	 * @since 0.2
	 *
	 */
	function post_edit_form_tag()
	{
		echo ' enctype="multipart/form-data"';
	}
}

?>