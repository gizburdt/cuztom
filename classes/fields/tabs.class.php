<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Tabs
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
		$tabs = $this->tabs;
				
		echo '<div class="js-cuztom-tabs cuztom-tabs">';
			echo '<ul>';
				foreach( $tabs as $title => $tab )
				{
					echo '<li><a href="#' . $tab->id . '">' . $tab->title . '</a></li>';
				}
			echo '</ul>';
	
			foreach( $tabs as $title => $tab )
			{
				$tab->output( $post, 'tabs' );
			}
		echo '</div>';
	}
}