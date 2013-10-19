<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Accordion extends Cuztom_Tabs
{
	function output( $object )
	{
		$tabs 	= $this->tabs;

		echo '<div class="js-cuztom-accordion">';
			foreach( $tabs as $title => $tab )
			{
				$tab->output( $object, 'accordion' );
			}
		echo '</div>';
	}
}