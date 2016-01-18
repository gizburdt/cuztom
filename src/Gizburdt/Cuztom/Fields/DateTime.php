<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;

Guard::directAccess();

class DateTime extends Field
{
    /**
     * Feature support
     */
    public $_supports_ajax            = true;
    public $_supports_bundle        = true;

    /**
     * Attributes
     */
    public $css_classes            = array( 'js-cztm-datetimepicker', 'cuztom-datetimepicker', 'datetimepicker', 'cuztom-input' );
    public $data_attributes        = array( 'time-format' => null, 'date-format' => null );

    /**
     * Constructs Cuztom_Field_Datetime
     *
     * @author 	Gijs Jorissen
     * @since 	0.3.3
     *
     */
    public function __construct($field)
    {
        parent::__construct($field);

        $this->data_attributes['date-format'] = $this->parse_date_format(isset($this->args['date_format']) ? $this->args['date_format'] : 'm/d/Y');
        $this->data_attributes['time-format'] = $this->parse_date_format(isset($this->args['time_format']) ? $this->args['time_format'] : 'H:i');
    }

    /**
     * Output method
     *
     * @return  string
     *
     * @author 	Gijs Jorissen
     * @since 	2.4
     *
     */
    public function _output($value = null)
    {
        return '<input type="text" ' . $this->output_name() . ' ' . $this->output_id() . ' ' . $this->output_css_class() . ' value="' . (! empty($value) ? (isset($this->args['date_format']) && isset($this->args['time_format']) ? date($this->args['date_format'] . ' ' .  $this->args['time_format'], $value) : date('m/d/Y H:i', $value)) : $this->default_value) . '" ' . $this->output_data_attributes() . ' />' . $this->output_explanation();
    }

    /**
     * Parse value
     *
     * @param 	string 		$value
     *
     * @author  Gijs Jorissen
     * @since 	2.8
     *
     */
    public function parse_value($value)
    {
        return strtotime($value);
    }

    /**
     * Matches each symbol of PHP date format standard
     * with jQuery equivalent codeword
     *
     * @param 	string 			$php_format
     *
     * @author 	Tristan Jahier
     * @since 	2.9
     *
     */
    public function parse_date_format($php_format)
    {
        $matching = array(
            // Day
            'd' => 'dd',
            'D' => 'D',
            'j' => 'd',
            'l' => 'DD',
            'N' => '',
            'S' => '',
            'w' => '',
            'z' => 'o',
            // Week
            'W' => '',
            // Month
            'F' => 'MM',
            'm' => 'mm',
            'M' => 'M',
            'n' => 'm',
            't' => '',
            // Year
            'L' => '',
            'o' => '',
            'Y' => 'yy',
            'y' => 'y',
            // Time
            'a' => 'tt',
            'A' => 'TT',
            'B' => '',
            'g' => 'h',
            'G' => 'H',
            'h' => 'hh',
            'H' => 'HH',
            'i' => 'mm',
            's' => 'ss',
            'u' => 'c',
            // ISO 8601
            'c' => 'Z'
        );

        $jqueryui_format    = '';
        $escaping            = false;

        for ($i = 0; $i < strlen($php_format); $i++) {
            $char    = $php_format[$i];
            if ($char === '\\') {
                $i++;
                if ($escaping) {
                    $jqueryui_format    .= $php_format[$i];
                } else {
                    $jqueryui_format                .= '\'' . $php_format[$i];
                }

                $escaping = true;
            } else {
                if ($escaping) {
                    $jqueryui_format .= "'";
                    $escaping = false;
                }

                if (isset($matching[$char])) {
                    $jqueryui_format .= $matching[$char];
                } else {
                    $jqueryui_format .= $char;
                }
            }
        }

        return $jqueryui_format;
    }
}
