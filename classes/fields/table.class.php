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
		cfg'.$this->id.' = {
			columns : '.json_encode($this->args['columns']).',
			functions : {
				create : function(values){

					if(typeof values === "undefined")var values = false;

					var table_id = "'.$this->id.'";
					var self = window["cfg"+table_id];

					var row_html = "<tr>";

					for (var i = 0; i < self.columns.length; i++) {
						row_html += "<td>" + buildTableInput(self.columns[i],values) + "</td>";
					};
					
					row_html += "<td><div class=\"remove_row button button-small\">-</div></td>";
					row_html += "</tr>";
					
					jQuery("#table_"+table_id+" tbody").append(row_html);
					
					jQuery("#table_'.$this->id.' input").on("keyup",cfg'.$this->id.'.functions.update_value);
					jQuery("#table_'.$this->id.' .remove_row").on("click",cfg'.$this->id.'.functions.remove_row);
					jQuery("#table_'.$this->id.' .datepicker").datepicker();
				},
				get_value : function(){
					var table_id = "'.$this->id.'";
					var self = window["cfg"+table_id];
					
					var value = [];

					jQuery("#table_"+table_id+" tbody tr").each(function(idx,item){
						var vals = {};
						for (var i = 0; i < self.columns.length; i++) {
							vals[cleanupName(self.columns[i].name)] = jQuery(item).find("."+cleanupName(self.columns[i].name)).val();
						};
						value.push(vals);
					});
					return value;
				},
				update_value : function(){

					var table_id = "'.$this->id.'";
					var self = window["cfg"+table_id];

					jQuery("#'.$this->pre_id . $this->id . $this->after_id.'").val(JSON.stringify(self.functions.get_value()));
				},
				init_table : function(){

					var table_id = "'.$this->id.'";
					var self = window["cfg"+table_id];

					var val = JSON.parse(jQuery("#'.$this->pre_id . $this->id . $this->after_id.'").val());

					if(val.length){
						for (var i = 0; i < val.length; i++) {

							self.functions.create(val[i]);
						};
					}

				},
				remove_row : function(){
					console.log(jQuery(this).parent().parent());
					jQuery(this).parent().parent().remove();
					cfg'.$this->id.'.functions.update_value();
				}
			}
		};

		buildTableInput = function(cfg,values){
			var text_value = "";
			if(values){
				if(typeof values[cleanupName(cfg.name)] !== "undefined"){
					text_value = values[cleanupName(cfg.name)];
				}
			}

			switch(cfg.type){
				case "text":
					return "<input type=\"text\" class=\""+cleanupName(cfg.name)+"\" value=\""+text_value+"\">";
					break;
				case "int":
					return "<input type=\"number\" class=\""+cleanupName(cfg.name)+"\" value=\""+text_value+"\">";
					break;
				case "datepicker":
					return "<input type=\"text\" class=\"datepicker "+cleanupName(cfg.name)+"\" value=\""+text_value+"\">";
					break;
			}
		}

		cleanupName = function(val){
			return val.replace(/[^a-z]/gi,"");
		}


		jQuery("#create_'.$this->id.'").click(cfg'.$this->id.'.functions.create);
		jQuery("#table_'.$this->id.' input").on("keyup",cfg'.$this->id.'.functions.update_value);
		
		cfg'.$this->id.'.functions.init_table();
		</script>
		';

		return $output;
	}

}
