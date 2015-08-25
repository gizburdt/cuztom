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
	var $dismissible;

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
	function __construct( $notice, $type = 'updated', $dismissible )
	{
		$this->notice 		= $notice;
		$this->type 		= $type;
		$this->dismissible	= $dismissible;

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
		echo '<div class="' . $this->get_css_class() . '">';
			echo '<p>' . $this->notice . '</p>';
    	echo '</div>';
	}

	/**
	 * Returns the complete css class for the notice
	 *
	 * @author 	Gijs Jorissen
	 * @since   2.3
	 *
	 */
	function get_css_class()
	{
		$class = $this->type;

		if($this->dismissible) {
			$class .= ' is-dismissible';
		}

		return $class;
	}
}