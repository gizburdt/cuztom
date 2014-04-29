<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Tabs
{
	var $id;
	var $meta_type;
	var $tabs 				= array();
	
	var $object 			= null;
	var $value 				= null;

	var $args 				= true;
	var $underscore 		= true;
	var $limit 				= null;

	function __construct( $args )
	{
		$this->id = $args['id'];
	}

	function output_row( )
	{
		echo '<tr class="cuztom-tabs">';
			echo '<td class="cuztom-field" id="' . $this->id . '" colspan="2">';
				$this->output();
			echo '</td>';
		echo '</tr>';
	}
	
	function output( $args = array() )
	{
		$tabs 			= $this->tabs;
		$args['type'] 	= 'tabs';
				
		echo '<div class="js-cuztom-tabs">';
			echo '<ul>';
				foreach( $tabs as $title => $tab )
				{
					echo '<li><a href="#' . $tab->id . '">' . $tab->title . '</a></li>';
				}
			echo '</ul>';
	
			foreach( $tabs as $title => $tab )
			{
				$tab->output( $args );
			}
		echo '</div>';
	}

	function save( $object, $values )
	{
		foreach( $this->tabs as $tab )
		{
			$tab->save( $object, $values );
		}
	}
}