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

			$this->meta_data 		= Cuztom_Meta_Box::_build_arrays( $data );
			
			add_filter( 'manage_posts_columns', array( $this, 'add_column_head' ) );
			add_action( 'manage_posts_custom_column', array( $this, 'add_column_content' ), 10, 2 );
			
			add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		}
		
		// Add multipart for files
		add_action( 'post_edit_form_tag', array( $this, 'post_edit_form_tag' ) );
		
		// Listen for the save post hook
		add_action( 'save_post', array( $this, 'save_post' ) );	
	}
	
	
	/**
	 * Used to add a column head to the Post Type's List Table
	 *
	 * @param array $default
	 * @return array
	 *
	 * @author Gijs Jorissen
	 * @since 1.1
	 *
	 */
	function add_column_head( $default )
	{
		$data = $this->meta_data;
		
		if( isset( $this->meta_data[0] ) && ! is_array( $this->meta_data[0] ) && ( $this->meta_data[0] == 'tabs' || $this->meta_data[0] == 'accordion' ) )
		{
			$tabs = array_slice( $data, 1 );
			
			foreach( $tabs as $tab => $fields )
			{
				foreach( $fields as $field_id_name => $field )
				{
					if( $field['show_column'] ) $default[$field_id_name] = $field['label'];
				}
			}
		}
		else
		{
			foreach( $data as $field_id_name => $field )
			{	
				if( $field['show_column'] ) $default[$field_id_name] = $field['label'];
			}
		}

		return $default;
	}
	
	
	/**
	 * Used to add the column content to the column head
	 *
	 * @param string $column
	 * @param int $post_id
	 * @return mixed
	 *
	 * @author Gijs Jorissen
	 * @since 1.1
	 *
	 */
	function add_column_content( $column, $post_id )
	{
		$meta = get_post_meta( $post_id, $column, true );
		
		if( isset( $this->meta_data[0] ) && ! is_array( $this->meta_data[0] ) && ( $this->meta_data[0] == 'tabs' || $this->meta_data[0] == 'accordion' ) )
		{
			$tabs = array_slice( $this->meta_data, 1 );
			
			foreach( $tabs as $tab => $fields )
			{
				foreach( $fields as $field_id_name => $field )
				{
					if( $column == $field_id_name )
					{
						echo $field['repeatable'] && Cuztom_Field::_supports_repeatable( $field ) ? 
							implode( $meta, ', ' ) : get_post_meta( $post_id, $column, true );
						break;
					}
				}
			}
		}
		else
		{
			$field = $this->meta_data[$column];
			echo $field['repeatable'] && Cuztom_Field::_supports_repeatable( $field ) ? implode( $meta, ', ' ) : get_post_meta( $post_id, $column, true );
		}
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
			
			if( isset( $meta_data[0] ) && ! is_array( $meta_data[0] ) && ( $meta_data[0] == 'tabs' || $meta_data[0] == 'accordion' ) )
			{			
				$tabs = array_slice( $meta_data, 1 );
				
				// If it's about tabs or accordion
				echo '<div class="cuztom_helper">';	
					echo '<div class="' . ( $meta_data[0] == 'tabs' ? 'cuztom_tabs' : 'cuztom_accordion' ) . '">';
						
						// Show tabs
						if( $meta_data[0] == 'tabs' )
						{
							echo '<ul>';
								foreach( $tabs as $tab => $fields )
								{
									$tab_id = Cuztom::uglify( $tab );

									echo '<li><a href="#' . $tab_id . '">' . Cuztom::beautify( $tab ) . '</a></li>';
								}
							echo '</ul>';
						}
						
						/* Loop through $meta_data, tabs in this case */
						foreach( $tabs as $tab => $fields )
						{							
							$tab_id = Cuztom::uglify( $tab );
							
							// Show header if accordion
							if( $meta_data[0] == 'accordion' )
							{
								echo '<h3>' . Cuztom::beautify( $title ) . '</h3>';
							}
							
							echo '<div id="' . $tab_id . '">';
								echo '<table border="0" cellading="0" cellspacing="0" class="cuztom_table cuztom_helper_table">';
									foreach( $fields as $field_id_name => $field )
									{
										$meta = get_post_meta( $post->ID, $field_id_name, true );
										
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
														echo '<div class="cuztom_padding_wrap">';
														echo '<a class="button-secondary cuztom_add cuztom_button" href="#">';
														echo '+ ' . __( 'Add', CUZTOM_TEXTDOMAIN ) . '</a>';
														echo '<ul class="cuztom_repeatable_wrap">';
													}
												
													cuztom_field( $field_id_name, $field, $meta );
													
													if( $field['repeatable'] && Cuztom_Field::_supports_repeatable( $field ) )
													{
														echo '</ul></div>';
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
					
					echo '</div>';
				echo '</div>';
			}
			else
			{
				echo '<div class="cuztom_helper">';
					echo '<table border="0" cellading="0" cellspacing="0" class="cuztom_table cuztom_helper_table">';

						/* Loop through $meta_data */
						foreach( $meta_data as $field_id_name => $field )
						{
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
											echo '<div class="cuztom_padding_wrap">';
											echo '<a class="button-secondary cuztom_add cuztom_button" href="#">';
											echo '+ ' . __( 'Add', CUZTOM_TEXTDOMAIN ) . '</a>';
											echo '<ul class="cuztom_repeatable_wrap">';
										}

										cuztom_field( $field_id_name, $field, $meta );
										
										if( $field['repeatable'] && Cuztom_Field::_supports_repeatable( $field ) )
										{
											echo '</ul></div>';
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
			if( isset( $this->meta_data[0] ) && ! is_array( $this->meta_data[0] ) && ( $this->meta_data[0] == 'tabs' || $this->meta_data[0] == 'accordion' ) )
			{
				$tabs = array_slice( $this->meta_data, 1 );
				
				foreach( $tabs as $tab => $fields )
				{							
					foreach( $fields as $field_id_name => $field )
					{									
						$this->_save_meta( $post_id, $field, $field_id_name );
					}
				}
			}
			else
			{
				foreach( $this->meta_data as $field_id_name => $field )
				{
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
	
	
	/**
	 * This array builds the complete array with the right key => value pairs
	 *
	 * @param array $data
	 * @return array
	 *
	 * @author Gijs Jorissen
	 * @since 1.1
	 *
	 */
	function _build_arrays( $data )
	{
		$return = array();
		
		if( ! is_array( $data[0] ) && ( $data[0] == 'tabs' || $data[0] == 'accordion' ) )
		{
			$return[0] = $data[0];
			
			foreach( $data[1] as $tab )
			{
				$title = $tab[0];			
				$return[$title] = array();

				foreach( $tab[1] as $field )
				{					
					$field = Cuztom_Field::_build_array( $field );
					$field_id_name = Cuztom_Field::_build_id_name( $field, $this->box_title );
					
					$return[$title][$field_id_name] = $field;
				}
			}
		}
		else
		{
			if( is_array( $data ) )
			{
				foreach( $data as $field )
				{
					$field = Cuztom_Field::_build_array( $field );
					$field_id_name = Cuztom_Field::_build_id_name( $field, $this->box_title );

					$return[$field_id_name] = $field;
				}
			}
		}
		
		return $return;
	}
}

?>