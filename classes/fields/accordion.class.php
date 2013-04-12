<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Accordion
{
	var $id;
	var $tabs = array();

	/**
	 * Outputs an accordion
	 * 
	 * @param  	object 			$post
	 * @param   string 			$meta_type
	 *
	 * @author  Gijs Jorissen
	 * @since   1.6.5
	 *
	 */
	function output( $post, $meta_type )
	{
		$tabs 	= $this->tabs;
				
		// If it's about tabs or accordion
		echo '<div class="js-cuztom-accordion">';
			
			/* Loop through $data, tabs in this case */
			foreach( $tabs as $title => $tab )
			{
				$tab->output( $post, $meta_type, 'accordion' );
			}
		
		echo '</div>';
	}
}