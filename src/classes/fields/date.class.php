<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Date extends Cuztom_Field
{
	var $_supports_ajax			= true;
	var $_supports_bundle		= true;

	var $css_classes			= array( 'js-cuztom-datepicker', 'cuztom-datepicker', 'datepicker', 'cuztom-input' );
	var $data_attributes 		= array( 'date-format' => null );

	function __construct( $field, $parent )
	{
		parent::__construct( $field, $parent );

		$this->data_attributes['date-format'] = $this->parse_date_format( isset( $this->args['date_format'] ) ? $this->args['date_format'] : 'm/d/Y' );
	}

	function _output( $value )
	{
		return '<input type="text" ' . $this->output_name() . ' ' . $this->output_id() . ' ' . $this->output_css_class() . ' value="' . ( ! empty( $value ) ? ( isset( $this->args['date_format'] ) ? date( $this->args['date_format'], $value ) : date( 'm/d/Y', $value ) ) : $this->default_value ) . '" ' . $this->output_data_attributes() . ' />' . $this->output_explanation();
	}

	function save_value( $value )
	{
		return strtotime( $value );
	}

	/**
	 * Matches each symbol of PHP date format standard
	 * with jQuery equivalent codeword
	 * 
	 * @param 	string 			$php_format
	 *
	 * @author 	Tristan Jahier
	 * @since 	2.9
	 * 
	 */
	function parse_date_format( $php_format ) 
	{
		$matching = array(
			// Day
			'd' => 'dd',
			'D' => 'D',
			'j' => 'd',
			'l' => 'DD',
			'N' => '',
			'S' => '',
			'w' => '',
			'z' => 'o',
			// Week
			'W' => '',
			// Month
			'F' => 'MM',
			'm' => 'mm',
			'M' => 'M',
			'n' => 'm',
			't' => '',
			// Year
			'L' => '',
			'o' => '',
			'Y' => 'yy',
			'y' => 'y',
			// Time
			'a' => 'tt',
			'A' => 'TT',
			'B' => '',
			'g' => 'h',
			'G' => 'H',
			'h' => 'hh',
			'H' => 'HH',
			'i' => 'mm',
			's' => 'ss',
			'u' => 'c',
			// ISO 8601
			'c' => 'Z'
		);

		$jqueryui_format 	= "";
		$escaping 			= false;
		
		for($i = 0; $i < strlen($php_format); $i++) 
		{
			$char	= $php_format[$i];
			if( $char === '\\' ) 
			{
				$i++;
				if( $escaping ) $jqueryui_format 	.= $php_format[$i];
				else $jqueryui_format 				.= '\'' . $php_format[$i];
				
				$escaping = true;
			}
			else 
			{
				if( $escaping ) 
				{ 
					$jqueryui_format .= "'"; 
					$escaping = false; 
				}

				if( isset( $matching[$char] ) )
					$jqueryui_format .= $matching[$char];
				else
					$jqueryui_format .= $char;
			}
		}
		
		return $jqueryui_format;
	}
}