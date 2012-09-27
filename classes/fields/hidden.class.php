<?php

class Cuztom_Field_Hidden extends Cuztom_Field
{
	function __construct( $field, $meta_box )
	{
		parent::__construct( $field, $meta_box );
	}
	
	function generate_output()
	{
	}
	
	function generate_repeatable_output()
	{
	}	
}