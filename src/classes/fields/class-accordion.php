<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Accordion extends Cuztom_Tabs
{
	function output( $args = array() )
	{
		$tabs 			= $this->tabs;
		$args['type'] 	= 'accordion';

		echo '<div class="js-cuztom-accordion cuztom-accordion cuztom-bundles-' . $this->id . '">';
			foreach( $tabs as $title => $tab )
			{
				$tab->output( $args );
			}
		echo '</div>';
	}
}