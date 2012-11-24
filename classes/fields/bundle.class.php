<?php

class Cuztom_Bundle
{
	var $id;
	var $fields = array();

	/**
	 * Save bundle meta
	 * 
	 * @param  	int 			$post_id
	 * @param  	string 			$value
	 *
	 * @author 	Gijs Jorissen
	 * @since 	1.6.2
	 * 
	 */
	function save( $post_id, $value )
	{
		add_post_meta( $post_id, $this->id, $value );
	}
}