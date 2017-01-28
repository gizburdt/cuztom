<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class File extends Field
{
    /**
     * Base.
     * @var mixed
     */
    public $inputType = 'hidden';
    public $view      = 'file';

    /**
     * Fillables.
     * @var mixed
     */
    public $css_class      = 'cuztom-input--hidden';
    public $cell_css_class = 'cuztom-field--file';

    /**
     * Construct.
     *
     * @param array $args
     * @param array $values
     */
    public function __construct($args, $values = null)
    {
        parent::__construct($args, $values);

        $this->html_attributes = array(
            'v-model' => 'value'
        );
    }

    /**
     * Output input field.
     *
     * @param  string $value
     * @param  string $view
     * @return string
     */
    public function outputInput($value = null, $view = null)
    {
        $view       = $view ? $view : $this->getView();
        $attachment = wp_get_attachment_metadata($value);

        $attachment['url']   = wp_get_attachment_url($value);
        $attachment['mime']  = str_replace('/', '-', get_post_mime_type($value));
        $attachment['title'] = get_the_title($value);

        return Cuztom::view('fields/'.$view, array(
            'field'      => $this,
            'value'      => $value,
            'attachment' => $attachment
        ));
    }
}
