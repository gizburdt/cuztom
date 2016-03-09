<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Cuztom;
use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Tab extends Field
{
    /**
     * Title.
     *
     * @var string
     */
    public $title;

    /**
     * Fields.
     *
     * @var array
     */
    public $fields = array();

    /**
     * Construct.
     *
     * @param array $args
     *
     * @since 3.0
     */
    public function __construct($args)
    {
        parent::__construct($args);

        if (!$this->id) {
            $this->id = Cuztom::uglify($this->title);
        }
    }

    /**
     * Output.
     *
     * @param array $args
     *
     * @return string
     *
     * @since  3.0
     */
    public function output($args = array())
    {
        $fields = $this->fields;

        ob_start();

        ?>

        <?php if ($args['type'] == 'accordion') : ?>
            <h3><?php echo $this->title;
        ?></h3>
        <?php endif;
        ?>

        <div id="<?php echo $this->get_id();
        ?>">
            <?php if ($fields instanceof Bundle) : ?>
                <?php echo $fields->output($field->value);
        ?>
            <?php else : ?>
                <table border="0" cellading="0" cellspacing="0" class="from-table cuztom-table">
                    <?php
                        foreach ($fields as $id => $field) :
                            if (!$field instanceof Hidden) :
                                echo $field->output_row($field->value); else :
                                echo $field->output($field->value);
        endif;
        endforeach;
        ?>
                </table>
            <?php endif;
        ?>
        </div>

        <?php $ob = ob_get_clean();

        return $ob;
    }

    /**
     * Save.
     *
     * @param int          $object
     * @param string|array $values
     *
     * @return string
     *
     * @since  3.0
     */
    public function save($object, $values)
    {
        foreach ($this->fields as $id => $field) {
            $field->save($object, $values);
        }
    }

    /**
     * Build.
     *
     * @param array        $data
     * @param string|array $value
     *
     * @return void
     *
     * @since  3.0
     */
    public function build($data, $value)
    {
        foreach ($data as $type => $field) {
            if (is_string($type) && $type == 'bundle') {
                // $tab->fields = $this->build( $fields );
            } else {
                $args  = array_merge($field, array('meta_type' => $this->meta_type, 'object' => $this->object, 'value'    => @$value[$field['id']][0]));
                $field = Field::create($args);

                $this->fields[$field->id] = $field;
            }
        }
    }
}
