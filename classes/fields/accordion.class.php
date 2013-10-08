<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Accordion
{
	var $id;
	var $meta_type;
	var $tabs = array();

	function __construct( $id )
	{
		$this->id 	= $id;
	}

	function output( $post )
	{
		$tabs 	= $this->tabs;

		echo '<div class="js-cuztom-accordion">';
			foreach( $tabs as $title => $tab )
			{
				$tab->output( $post, 'accordion' );
			}
		echo '</div>';
	}
}