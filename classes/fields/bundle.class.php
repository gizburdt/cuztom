<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Bundle
{
	var $id;
	var $meta_type;
	
	var $fields 				= array();
	var $default_value 			= '';

	/**
	 * Construct for bundle
	 *
	 * @param   int  		$id
	 * @param 	array 		$data
	 *
	 * @author  Gijs Jorissen
	 * @since 	2.8.4
	 * 
	 */
	function __construct( $id, $data )
	{
		// Bundle data
		$this->default_value	= isset( $data['default_value'] ) 	? 	$data['default_value'] 			: $this->default_value;
		
		// Bundle id
		$this->id  				= isset( $id )						?	$this->build_id( $id )			: $this->id;
	}

	/**
	 * Outputs a bundle
	 * 
	 * @param  	object 			$post
	 * @param   string 			$meta_type
	 *
	 * @author  Gijs Jorissen
	 * @since   1.6.5
	 *
	 */
	function output( $post )
	{
		echo '<div class="padding-wrap">';
			echo '<a class="button-secondary cuztom-button js-cuztom-add-sortable js-cuztom-add-bundle cuztom-add-sortable" href="#">';
				echo sprintf( '+ %s', __( 'Add', 'cuztom' ) );
			echo '</a>';

			echo '<ul class="js-cuztom-sortable cuztom-sortable js-cuztom-bundle" data-cuztom-sortable-type="bundle">';
				
				$meta = $this->meta_type == 'user' ? get_user_meta( $post->ID, $this->id, true ) : get_post_meta( $post->ID, $this->id, true );

				if( ! empty( $meta ) && isset( $meta[0] ) )
				{
					$i = 0;
					foreach( $meta as $bundle )
					{
						echo '<li class="cuztom-sortable-item js-cuztom-sortable-item">';
							echo '<div class="cuztom-handle-sortable js-cuztom-handle-sortable"></div>';
							echo '<fieldset>';
							echo '<table border="0" cellading="0" cellspacing="0" class="form-table cuztom-table">';
								
								foreach( $this->fields as $id => $field )
								{
									$field->pre 		= '[' . $this->id . '][' . $i . ']';
									$field->after_id 	= '_' . $i;
									$value 				= isset( $meta[$i][$id] ) ? $meta[$i][$id] : '';
									
									if( ! $field instanceof Cuztom_Field_Hidden )
									{
										echo '<tr>';
											echo '<th class="cuztom-th">';
												echo '<label for="' . $id . $field->after_id . '" class="cuztom-label">' . $field->label . '</label>';
												echo '<div class="cuztom-description">' . $field->description . '</div>';
											echo '</th>';
											echo '<td class="cuztom-td">';

												if( $field->_supports_bundle ) {
													if( $field->repeatable && $field->_supports_repeatable )
													{
														echo '<a class="button-secondary cuztom-button js-cuztom-add-field js-cuztom-add-sortable" href="#">';
															echo sprintf( '+ %s', __( 'Add', 'cuztom' ) );
														echo '</a>';
														echo '<ul class="js-cuztom-sortable cuztom-sortable cuztom_repeatable_wrap">';
															echo $field->output( $value, $post );
														echo '</ul>';
													}
													else
													{
														echo $field->output( $value, $post );
													}
												}
												else
													echo '<em>' . __( 'This input type doesn\'t support the bundle functionality (yet).', 'cuztom' ) . '</em>';

											echo '</td>';
										echo '</tr>';
									}
									else
									{
										echo $field->output( $value, $post );
									}
								}

							echo '</table>';
							echo '</fieldset>';
							echo count( $meta ) > 1 ? '<div class="cuztom-remove-sortable js-cuztom-remove-sortable"></div>' : '';
						echo '</li>';
						
						$i++;
					}
					
				}
				elseif( ! empty( $this->default_value ) )
				{
					$i = 0;

					foreach( $this->default_value as $default )
					{
						echo '<li class="cuztom-sortable-item js-cuztom-sortable-item">';
							echo '<div class="cuztom-handle-sortable cuztom-handle-bundle js-cuztom-handle-sortable"></div>';
							echo '<fieldset>';
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

												if( $field->_supports_bundle ) {
													if( $field->repeatable && $field->_supports_repeatable )
													{
														echo '<a class="button-secondary cuztom-button js-cuztom-add-field js-cuztom-add-sortable" href="#">';
															echo sprintf( '+ %s', __( 'Add', 'cuztom' ) );
														echo '</a>';
														echo '<ul class="js-cuztom-sortable cuztom-sortable cuztom_repeatable_wrap">';
															echo $field->output( $value, $post );
														echo '</ul>';
													}
													else
													{
														echo $field->output( $value, $post );
													}
												}
												else
													echo '<em>' . __( 'This input type doesn\'t support the bundle functionality (yet).', 'cuztom' ) . '</em>';

											echo '</td>';
										echo '</tr>';
									}
									else
									{
										echo $field->output( $value, $post );
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
					echo '<li class="cuztom-sortable-item js-cuztom-sortable-item">';
						echo '<div class="cuztom-handle-sortable cuztom-handle-bundle js-cuztom-handle-sortable"></div>';
						echo '<fieldset>';
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

											if( $field->_supports_bundle ) {
												if( $field->repeatable && $field->_supports_repeatable )
												{
													echo '<a class="button-secondary cuztom-button js-cuztom-add-field js-cuztom-add-sortable" href="#">';
														echo sprintf( '+ %s', __( 'Add', 'cuztom' ) );
													echo '</a>';
													echo '<ul class="js-cuztom-sortable cuztom-sortable cuztom_repeatable_wrap">';
														echo $field->output( $value, $post );
													echo '</ul>';
												}
												else
												{
													echo $field->output( $value, $post );
												}
											}
											else
												echo '<em>' . __( 'This input type doesn\'t support the bundle functionality (yet).', 'cuztom' ) . '</em>';

										echo '</td>';
									echo '</tr>';
								}
								else
								{
									echo $field->output( $value, $post );
								}
							}

						echo '</table>';
						echo '</fieldset>';
					echo '</li>';
				}
			echo '</ul>';
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
	function save( $object_id, $values )
	{
		$values = apply_filters( "cuztom_" . $this->meta_type . "_meta_save_bundle_$this->id", 	$values, $this, $object_id );	
		$values = apply_filters( 'cuztom_' . $this->meta_type . '_meta_save_bundle', 			$values, $this, $object_id );
		$values = array_values( $values );

		foreach( $values as $row_id => $row ) 
		{
			foreach( $row as $id => $value )
				$values[$row_id][$id] = $this->fields[$id]->save_value($value);
		}

		if( $this->meta_type == 'user' )
		{
			delete_user_meta( $object_id, $this->id );		
			update_user_meta( $object_id, $this->id, $values );
		}
		else
		{
			delete_post_meta( $object_id, $this->id );
			update_post_meta( $object_id, $this->id, $values );
		}
	}

	/**
	 * Build the id for the bundle
	 *
	 * @return  string
	 *
	 * @author 	Gijs Jorissen
	 * @since 	2.7
	 * 
	 */
	function build_id( $id )
	{
		if( strpos( $id, '_', 0 ) !== 0 )
			$id = '_' . $id;

		return $id;
	}
}
