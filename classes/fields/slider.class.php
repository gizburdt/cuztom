<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom_Field_Slider extends Cuztom_Field
{
	function _output( $value, $object )
	{
		if ($this->range && is_array($this->range)) {
			$range = 'data-range-from="' . $this->range[0] . '" data-range-to="' . $this->range[1] . '"';
		} else {
			$range = 'data-range-from="0" data-range-to="100"';
		}

		if ($this->step) {
			$step = 'data-step="' . $this->step . '"';
		} else {
			$step = 'data-step="5"';
		}

		$output  = '<div class="js-cuztom-slider">';
		$output .= '<input type="hidden" name="cuztom' . $this->pre . '[' . $this->id_name . ']' . $this->after . '" id="' . $this->id_name . '" value="' . ( ! empty( $value ) ? $value : 0 ) . '" class="cuztom-input" />' . ( ! $this->repeatable && $this->explanation ? '<em class="cuztom-explanation">' . $this->explanation . '</em>' : '' );
		$output .= '<div class="cuztom-slider-div noUiSlider" data-value="' . ( ! empty( $value ) ? $value : 0) . '" ' . $range . ' ' . $step .  '></div>';
		$output .= '<div class="cuztom-slider-value"><strong>' . ( ! empty( $value ) ? $value : 0 ) . '</strong>';
		$output .= ($this->unit) ? '<span class="unit">' . $this->unit . '</span>' : '';
		$output .= '</div></div>';

		return $output;
	}
}