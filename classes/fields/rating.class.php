<?php

class Cuztom_Field_Rating extends Cuztom_Field
{

	function _output( $value )
	{
		extract($this->options);
		if(is_array($hints)){
			$hints = implode('", "', $hints);
		}else{
			$hints = '"bad", "poor", "regular", "good", "gorgeous"';
		}
		$output = '';
		$output .= '<div id="' . $this->id_name . '"></div>';
		$output .= '
			<script type="text/javascript">
				jQuery("#' . $this->id_name . '").raty({
					starHalf    : "'.get_template_directory_uri().'/library/cuztom/assets/images/raty/star-half.png",
					starOff     : "'.get_template_directory_uri().'/library/cuztom/assets/images/raty/star-off.png",
					starOn      : "'.get_template_directory_uri().'/library/cuztom/assets/images/raty/star-on.png",
					scoreName   : ' . $this->id_name . ',
					size        : 24,
					noRatedMsg  : "' . ( ! empty( $noRatedMsg ) ? $noRatedMsg : 'Not rated yet!' ) . '",
					number      : ' . ( ! empty( $number ) ? $number : 5 ) . ',
					numberMax   : ' . ( ! empty( $numberMax ) ? $numberMax : 20 ) . ',
					readOnly    : ' . ( ! empty( $readOnly ) ? $readOnly : 0 ) . ',
					half        : ' . ( ! empty( $half ) ? $half : 0 ) . ',
					halfShow    : ' . ( ! empty( $halfShow ) ? $halfShow : 1 ) . ',
					hints       : ["' . $hints . '"],
					score       : ' . ( ! empty( $value ) ? $value : 0 ) . '
				});
			</script>';
		
		return $output;
	}
}
