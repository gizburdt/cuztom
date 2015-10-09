<?php

if( ! defined( 'ABSPATH' ) ) exit;

/**
 * Menu page class used to create menu page
 *
 * @author 	Walker Franson
 * @since 	2.9.17
 *
 */
class Cuztom_Menu_Page extends Cuztom_Meta
{
	var $page_title;
	var $menu_title;
	var $capability;
	var $menu_slug;
	var $function;
	var $icon_url;
	var $position;
	var $data;
	var $save_fields;
	
	/**
	 * Construct a new Cuztom Menu Page
	 *
	 * @param 	string|array 	$menu_title
	 * @param 	array 			$args
	 * @param 	array 			$fields
	 *
	 * @author 	Walker Franson
	 * @since 	2.9.17
	 *
	 */
	function __construct( $menu_title, $args = array(), $fields = array() )
	{
		if( ! empty( $menu_title ) )
		{
			// If $menu_title is an array, the first element is the singular name, the second is the plural name
			
			$this->page_title = Cuztom::beautify( $menu_title );
			$this->menu_title = Cuztom::beautify( $menu_title );
			$this->capability = ( $args['capability'] ) ? $args['capability'] : 'read';
			$this->menu_slug = Cuztom::uglify( $menu_title );

			$this->function = $args['functions'];
			$this->data = $this->build( $fields );

			if ( !$args['functions'] ) {
				$this->function = function() use ( $fields )
									{
										global $current_user;
										
										echo "<h1>" . $this->page_title . "</h1>";

										if ( $fields ) {
											echo '<form method="post" action="options.php">';
											$this->callback();
											echo '</form>';

											$user_roles = $current_user->roles;
											$user_role = array_shift($user_roles);

											echo "<h2>" . __( 'Como utilizar os dados salvos', 'cuztom' ) . "</h2>";
											if ( $user_role == "administrator" ) {
												echo "<p>" . __( 'As informações estão armazenadas na tabela de opções do WordPress, podendo ser utilizadas da seguinte forma:' , 'cuztom' ) . "</p>";
																						
												echo "<p>";
													echo "<table>";
												foreach ( $this->data as $name_fields => $field ) {
														echo "<tr>";
															echo "<td>";
																echo "<strong>" . $field->label . "</strong>";
															echo "</td>";
															echo "<td>";
																echo "<code>";
																	echo "&lt;?php ";
																	echo "\$example_variable = get_option( '$name_fields' );";
																	echo " ?&gt;";
																echo "</code>";
															echo "</td>";
														echo "</tr>";
												}												
													echo "</table>";
												echo "</p>";
											} else {
												echo "<p>" . __( 'Consulte o administrador do site' , 'cuztom' ) . "</p>";
											}
										}
									};
			}
			
			$this->icon_url = ( $args['icon_url'] ) ? $args['icon_url'] : 'dashicons-admin-page';
			$this->position = $args['position'];

			// Add action to register the post type, if the post type doesnt exist
			if ( empty ( $GLOBALS['admin_page_hooks'][$this->page_title] ) )
			{
				$this->register_menu_page();
			}
		}
	}
	
	/**
	 * Register the Post Type
	 * 
	 * @author 	Walker Franson
	 * @since 	2.9.17
	 *
	 */
	function register_menu_page()
	{
		add_action( 'admin_menu', function(){
			add_menu_page( $this->page_title, $this->menu_title, $this->capability, $this->menu_slug, $this->function, $this->icon_url, $this->position );

			add_action( 'admin_init', function(){
				foreach ( $this->data as $name_fields => $field ) {
					register_setting( 'menu-page-settings', $name_fields );
				}				
			} );
		} );
	}

	function callback( $object = null, $data = array() )
	{
		// Get all inputs from $data
		$data 		= $this->data;
		$meta_type 	= $this->get_meta_type();

		if( ! empty( $data ) )
		{
			echo '<div class="cuztom" data-object-id="' . ( $meta_type == 'post' ? get_the_ID() : $object->ID ) . '" data-meta-type="' . $meta_type . '">';

				echo '<table border="0" cellading="0" cellspacing="0" class="form-table cuztom-table">';

				settings_fields( 'menu-page-settings' );
				do_settings_sections( 'menu-page-settings' );

				/* Loop through $data */
				foreach( $data as $id_name => $field )
				{
					$field->overwrite = $saved_fields[] = $id_name;
					$value = get_option( $id_name );

					if( ! $field instanceof Cuztom_Field_Hidden )
					{
						echo '<tr>';
							echo '<th class="cuztom-th">';
								echo '<label for="' . $id_name . '" class="cuztom_label">' . $field->label . '</label>';
								echo $field->required ? ' <span class="cuztom-required">*</span>' : '';
								echo '<div class="cuztom-description description">' . $field->description . '</div>';
							echo '</th>';
							echo '<td class="cuztom-td">';

								if( $field->repeatable && $field->_supports_repeatable )
								{
									echo '<a class="button-secondary cuztom-button js-cuztom-add-field js-cuztom-add-sortable" href="#">';
										echo sprintf( '+ %s', __( 'Add', 'cuztom' ) );
									echo '</a>';
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
					}
					else
					{
						echo $field->output( $value, $object );
					}
				}

				echo '</table>';
				
				$saved_fields = implode( ',', $saved_fields );
				// echo '<input type="hidden" name="page_options" value="' . $saved_fields . '" />';
				submit_button();

			echo '</div>';
		}
	}
}
