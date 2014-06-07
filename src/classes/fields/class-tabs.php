<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Tabs extends Cuztom_Field
{
	var $tabs = array();

	function __construct( $args )
	{
		$this->id = $args['id'];
	}

	function output_row( $value = null )
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

	function build( $data, $value )
	{
		foreach( $data as $title => $field ) {
			$args	= array_merge( array( 'title' => $title, 'meta_type' => $this->meta_type, 'object' => $this->object ) );
			$tab 	= new Cuztom_Tab( $args );
			$tab->build( $field['fields'], $value );

			$this->tabs[$title] = $tab;
		}
	}
}