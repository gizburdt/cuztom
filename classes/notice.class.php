<?php

if( ! defined( 'ABSPATH' ) ) exit;

/**
 * Cuztom notice class, to easily handle admin notices
 *
 * @author  Gijs Jorissen
 * @since  	2.3
 */
class Cuztom_Notice
{
	var $notice;
	var $type;

	/**
	 * Constructor
	 * 
	 * @param  	string 	$notice 
	 * @param 	string 	$type
	 *
	 * @author  Gijs Jorissen
	 * @since   2.3
	 * 
	 */
	function __construct( $notice, $type = 'updated' )
	{
		$this->notice 	= $notice;
		$this->type 	= $type;

		add_action( 'admin_notices', array( &$this, 'add_admin_notice' ) );
	}

	/**
	 * Adds the admin notice
	 *
	 * @author 	Gijs Jorissen
	 * @since   2.3
	 * 
	 */
	function add_admin_notice()
	{
		echo '<div class="' . $this->type . '">';
			echo '<p>' . $this->notice . '</p>';
    	echo '</div>';
	}
}