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
	var $name 			= '';
    var $label 			= '';
    var $description 	= '';
	var $hide 			= true;
	var $default_value 	= '';
	var $options 		= array();
	var $repeatable 	= false;
	var $show_column 	= false;
	var $output 		= '';
	
	
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
	function output()
	{
		echo $output;
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
		return apply_filters( 'cuztom_is_hidden', $this->hide );
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
	function _supports_repeatable()
	{
		return in_array( $this->type, apply_filters( 'cuztom_supports_repeatable', array( 'text', 'textarea', 'select', 'post_select', 'term_select' ) ) );
	}
	
	
	/**
	 * Checks if the field supports bundle functionality
	 *
	 * @param $field or $field_type
	 * @return boolean
	 *
	 * @author Gijs Jorissen
	 * @since 1.2
	 *
	 */
	function _supports_bundle()
	{		
		return in_array( $field->type, apply_filters( 'cuztom_supports_bundle', array( 'text', 'textarea' ) ) );
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
	function _build_id_name( $field, $box_title )
	{
		return apply_filters( 'cuztom_buidl_id_name', ( self::_is_hidden() ? '_' : '' ) . Cuztom::uglify( $box_title ) . "_" . Cuztom::uglify( $field['name'] ) );
	}
}