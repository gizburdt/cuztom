<?php

class Cuztom_Notice
{
	var $notice;
	var $type;

	function __construct( $notice, $type = 'updated' )
	{
		$this->notice 	= $notice;
		$this->type 	= $type;

		add_action( 'admin_notices', array( &$this, 'add_admin_notice' ) );
	}

	function add_admin_notice()
	{
		echo '<div class="' . $this->type . '">';
			echo '<p>' . $this->notice . '</p>';
    	echo '</div>';
	}
}