<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Bundle
{
	var $id;
	var $meta_type;
	var $type 					= 'bundle';
	var $fields 				= array();
	
	var $object 				= null;
	var $value 					= null;

	var $args 					= true;
	var $underscore 			= true;
	var $limit 					= null;

	/**
	 * Construct for bundle
	 *
	 * @param   int  		$id
	 * @param 	array 		$args
	 *
	 * @author  Gijs Jorissen
	 * @since 	2.8.4
	 * 
	 */
	function __construct( $args )
	{
		// Bundle args
		$this->underscore		= isset( $args['underscore'] ) 		? 	$args['underscore'] 	: $this->underscore;
		$this->limit			= isset( $args['limit'] ) 			? 	$args['limit'] 			: $this->limit;

		// Localize bundle
		add_action( 'admin_enqueue_scripts', array( &$this, 'localize' ) );
	}

	function output_row( $value )
	{
		echo '<tr class="cuztom-tr">';
			echo '<td class="cuztom-td js-cuztom-field-selector" id="' . $this->id . '" colspan="2">';
				$this->output( $value );
			echo '</td>';
		echo '</tr>';
	}

	/**
	 * Outputs a bundle
	 * 
	 * @param  	object 			$object
	 *
	 * @author  Gijs Jorissen
	 * @since   1.6.5
	 *
	 */
	function output( $object, $args = array() )
	{
		$object_id = $this->object;

		echo '<div class="cuztom-bundles cuztom-bundles-' . $this->id . '">';
			echo '<a class="button-secondary cuztom-button js-cuztom-add-sortable js-cuztom-add-bundle cuztom-add-sortable" href="#">';
				echo sprintf( '+ %s', __( 'Add', 'cuztom' ) );
			echo '</a>';

			echo '<ul class="js-cuztom-sortable cuztom-sortable" data-cuztom-sortable-type="bundle">';

				if( ! empty( $this->value ) && isset( $this->value[0] ) )
				{
					$i = 0;
					foreach( $this->value as $bundle )
					{
						echo '<li class="cuztom-sortable-item js-cuztom-sortable-item cuztom-bundle cuztom-bundle-' . $this->id . '-' . $i . '">';
							echo '<div class="cuztom-handle-sortable js-cuztom-handle-sortable"><a href="#"></a></div>';
							echo '<fieldset class="cuztom-fieldset">';
								echo '<table border="0" cellading="0" cellspacing="0" class="form-table cuztom-table">';
									
									foreach( $this->fields as $id => $field )
									{
										$field->pre 		= '[' . $this->id . '][' . $i . ']';
										$field->after_id 	= '_' . $i;
										$value 				= isset( $this->value[$i][$id] ) ? $this->value[$i][$id] : '';
										
										if( ! $field instanceof Cuztom_Field_Hidden )
										{
											echo '<tr>';
												echo '<th class="cuztom-th">';
													echo '<label for="' . $id . $field->after_id . '" class="cuztom-label">' . $field->label . '</label>';
													echo '<div class="cuztom-field-description">' . $field->description . '</div>';
												echo '</th>';
												echo '<td class="cuztom-td">';

													if( $field->_supports_bundle )
														echo $field->output( $field->value, $object );
													else
														echo '<em>' . __( 'This input type doesn\'t support the bundle functionality (yet).', 'cuztom' ) . '</em>';

												echo '</td>';
											echo '</tr>';
										}
										else
										{
											echo $field->output( $field->value, $object );
										}
									}

								echo '</table>';
							echo '</fieldset>';
							echo count( $this->value ) > 1 ? '<div class="cuztom-remove-sortable js-cuztom-remove-sortable"><a href="#"></a></div>' : '';
						echo '</li>';
						
						$i++;
					}
					
				}
				elseif( ! empty( $this->default_value ) )
				{
					$i = 0;
					foreach( $this->default_value as $default )
					{
						echo '<li class="cuztom-sortable-item js-cuztom-sortable-item cuztom-bundle">';
							echo '<div class="cuztom-handle-sortable cuztom-handle-bundle js-cuztom-handle-sortable"><a href="#"></a></div>';
							echo '<fieldset class="cuztom-fieldset">';
							echo '<table border="0" cellading="0" cellspacing="0" class="form-table cuztom-table">';
								
								$fields = $this->fields;
								$y 		= 0;
								
								foreach( $fields as $id => $field )
								{
									$field->pre 			= '[' . $this->id . '][' . $i . ']';
									$field->after_id 		= '_' . $i;
									$field->default_value 	= $this->default_value[$i][$y];
									$value 					= '';

									if( ! $field instanceof Cuztom_Field_Hidden )
									{
										echo '<tr>';
											echo '<th class="cuztom-th">';
												echo '<label for="' . $id . $field->after_id . '" class="cuztom-label">' . $field->label . '</label>';
												echo '<div class="cuztom-description">' . $field->description . '</div>';
											echo '</th>';
											echo '<td class="cuztom-td">';

												if( $field->_supports_bundle )
													echo $field->output( $field->value, $object );
												else
													echo '<em>' . __( 'This input type doesn\'t support the bundle functionality (yet).', 'cuztom' ) . '</em>';

											echo '</td>';
										echo '</tr>';
									}
									else
									{
										echo $field->output( $field->value, $object );
									}

									$y++;
								}

							echo '</table>';
							echo '</fieldset>';
						echo '</li>';

						$i++;
					}
				}
				else
				{
					echo '<li class="cuztom-sortable-item js-cuztom-sortable-item cuztom-bundle">';
						echo '<div class="cuztom-handle-sortable cuztom-handle-bundle js-cuztom-handle-sortable"><a href="#"></a></div>';
						echo '<fieldset class="cuztom-fieldset">';
						echo '<table border="0" cellading="0" cellspacing="0" class="form-table cuztom-table">';
							
							$fields = $this->fields;
							
							foreach( $fields as $id => $field )
							{
								$field->pre 		= '[' . $this->id . '][0]';
								$field->after_id	= '_0';
								$value 				= '';

								if( ! $field instanceof Cuztom_Field_Hidden )
								{
									echo '<tr>';
										echo '<th class="cuztom-th">';
											echo '<label for="' . $id . $field->after_id . '" class="cuztom-label">' . $field->label . '</label>';
											echo '<div class="cuztom-description">' . $field->description . '</div>';
										echo '</th>';
										echo '<td class="cuztom-td">';

											if( $field->_supports_bundle )
												echo $field->output( $field->value, $object );
											else
												echo '<em>' . __( 'This input type doesn\'t support the bundle functionality (yet).', 'cuztom' ) . '</em>';

										echo '</td>';
									echo '</tr>';
								}
								else
								{
									echo $field->output( $field->value, $object );
								}
							}

						echo '</table>';
						echo '</fieldset>';
					echo '</li>';
				}
			echo '</ul>';

			echo '<a class="button-secondary cuztom-button js-cuztom-add-sortable js-cuztom-add-bundle cuztom-add-sortable" href="#">';
				echo sprintf( '+ %s', __( 'Add', 'cuztom' ) );
			echo '</a>';
		echo '</div>';
	}

	/**
	 * Save bundle meta
	 * 
	 * @param  	int 			$post_id
	 * @param  	string 			$value
	 *
	 * @author 	Gijs Jorissen
	 * @since 	1.6.2
	 * 
	 */
	function save( $object, $values )
	{
		$values 	= array_values( $values );

		foreach( $values as $row => $fields ) 
		{
			foreach( $fields as $id => $value )
				$values[$row][$id] = $this->fields[$id]->save_value( $value );
		}

		switch( $this->meta_type ) :
			case 'user' :
				delete_user_meta( $object_id, $this->id );		
				update_user_meta( $object_id, $this->id, $values );
			break;
			default :
				delete_post_meta( $object_id, $this->id );
				update_post_meta( $object_id, $this->id, $values );
			break;
		endswitch;

		// TODO: Term meta
	}

	function localize()
	{
		wp_localize_script( 'cuztom', 'Cuztom_' . $this->id, (array) $this );
	}
}