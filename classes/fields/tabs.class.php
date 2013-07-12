<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Tabs
{
	var $id;
	var $meta_type;
	var $tabs = array();

	/**
	 * Outputs tabs
	 * 
	 * @param  	object 			$post
	 *
	 * @author  Gijs Jorissen
	 * @since   1.6.5
	 *
	 */
	function output( $post )
	{
		$tabs = $this->tabs;
				
		// If it's about tabs or accordion
		echo '<div class="js-cuztom-tabs cuztom-tabs">';
			
			echo '<ul>';
				foreach( $tabs as $title => $tab )
				{
					echo '<li><a href="#' . $tab->id . '">' . $tab->title . '</a></li>';
				}
			echo '</ul>';
			
			/* Loop through $data, tabs in this case */
			foreach( $tabs as $title => $tab )
			{
				$tab->output( $post, 'tabs' );
			}
		
		echo '</div>';
	}
}