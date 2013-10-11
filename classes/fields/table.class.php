<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Table extends Cuztom_Field
{


	function _output( $value )
	{
		

		$output = '</td></tr><tr><td colspan="2">';

		$output .= '<div id="create_'.$this->id.'" class="button button-small">+</div>';

		$output .= '<table id="table_'.$this->id.'">
		<thead><tr>';

		foreach($this->args['columns'] as $arg){
			$output .= '<td>'.$arg['name'].'</td>';			
		}

		$output .= '<td>&nbsp;</td></tr></thead>
		<tbody>';

		$output .= '
		</tbody>
		</table>';

		$output .= '
		<input type="hidden" ' . $this->output_name() . ' id="'.$this->pre_id . $this->id . $this->after_id.'" class="cuztom-input" value=\''.$value.'\'></input>
		<script>
		if(typeof cuztomTableCfg === \'undefined\')cuztomTableCfg = [];
		cuztomTableCfg.push({
			table_id		: "'.$this->id.'",
			columns			: '.json_encode($this->args['columns']).',
			inputTarget	: "'.$this->pre_id . $this->id . $this->after_id.'"
		});
		</script>';

		return $output;
	}

}
