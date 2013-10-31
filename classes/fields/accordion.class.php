<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Accordion extends Cuztom_Tabs
{
	function output( $object )
	{
		$tabs 	= $this->tabs;

		echo '<div class="js-cuztom-accordion cuztom-accordion cuztom-bundles-' . $this->id . '">';
			foreach( $tabs as $title => $tab )
			{
				$tab->output( $object, 'accordion' );
			}
		echo '</div>';
	}
}