<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Tabs
{
	var $id;
	var $meta_type;
	var $type 				= 'bundle';
	var $tabs 				= array();
	
	var $object 			= null;
	var $value 				= null;

	var $args 				= true;
	var $underscore 		= true;
	var $limit 				= null;

	function __construct( $args )
	{
		// Tabs args
		$this->underscore		= isset( $args['underscore'] ) 		? 	$args['underscore'] 	: $this->underscore;

		// Localize tabs
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
	
	function output( $args = array() )
	{
		$tabs 			= $this->tabs;
		$args['type'] 	= 'tabs';
				
		echo '<div class="js-cuztom-tabs cuztom-tabs cuztom-bundles-' . $this->id . '">';
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
	
	function localize()
	{
		wp_localize_script( 'cuztom', 'Cuztom_' . $this->id, (array) $this );
	}

	/**
	 * Build the id for the tabs
	 *
	 * @return  string
	 *
	 * @author 	Gijs Jorissen
	 * @since 	3.0
	 * 
	 */
	function build_id( $id, $parent )
	{
		return ( $this->underscore ? '_' : '' ) . $parent . '_' . $id;
	}
}