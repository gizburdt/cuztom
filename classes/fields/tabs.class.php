<?php

class Cuztom_Tabs
{
	var $id;
	var $tabs = array();

	/**
	 * Outputs tabs
	 * 
	 * @param  	object 			$post
	 * @param   string 			$context
	 *
	 * @author  Gijs Jorissen
	 * @since   1.6.5
	 *
	 */
	function output( $post, $context )
	{
		$tabs = $this->tabs;
				
		// If it's about tabs or accordion
		echo '<div class="cuztom_tabs">';
			
			echo '<ul>';
				foreach( $tabs as $title => $tab )
				{
					$tab_id = Cuztom::uglify( $title );

					echo '<li><a href="#' . $tab_id . '">' . Cuztom::beautify( $title ) . '</a></li>';
				}
			echo '</ul>';
			
			/* Loop through $data, tabs in this case */
			foreach( $tabs as $title => $tab )
			{							
				$tab_id = Cuztom::uglify( $title );
				$fields = $tab->fields;
				
				echo '<div id="' . $tab_id . '">';
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
		
		echo '</div>';
	}
}