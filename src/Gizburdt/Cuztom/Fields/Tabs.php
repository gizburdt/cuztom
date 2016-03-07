<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;
use Gizburdt\Cuztom\Fields\Field;
use Gizburdt\Cuztom\Fields\Tab;

Guard::directAccess();

class Tabs extends Field
{
    /**
     * Tabs
     * @var array
     */
    public $tabs = array();

    /**
     * Output row
     *
     * @param  string|array $value
     * @return string
     * @since  3.0
     */
    public function output_row($value = null)
    {
        ob_start();

        ?>

        <tr class="cuztom-tabs">
            <td class="cuztom-field" id="<?php echo $this->get_id() ?>" colspan="2">
                <?php echo $this->output(); ?>
            </td>
        </tr>

        <?php $ob = ob_get_clean(); return $ob;
    }

    /**
     * Output
     *
     * @param  array  $args
     * @return string
     * @since  3.0
     */
    public function output($args = array())
    {
        $args['type'] = 'tabs';

        ob_start();

        ?>

        <div class="js-cuztom-tabs">
            <ul>
                <?php foreach ($this->tabs as $title => $tab) : ?>
                    <li><a href="#<?php echo $tab->get_id(); ?>"><?php echo $tab->title; ?></a></li>
                <?php endforeach; ?>
            </ul>

            <?php foreach ($this->tabs as $title => $tab) : ?>
                <?php echo $tab->output($args); ?>
            <?php endforeach; ?>
        </div>

        <?php $ob = ob_get_clean(); return $ob;
    }

    /**
     * Save
     *
     * @param  integer $object
     * @param  array $values
     * @return void
     * @since  3.0
     */
    public function save($object, $values)
    {
        foreach ($this->tabs as $tab) {
            $tab->save($object, $values);
        }
    }

    /**
     * Build
     *
     * @param  array $data
     * @param  string|array $value
     * @return void
     * @since  3.0
     */
    public function build($data, $value)
    {
        foreach ($data as $title => $field) {
            $args = array_merge(array( 'title' => $title, 'meta_type' => $this->meta_type, 'object' => $this->object ));
            $tab  = new Tab($args);

            $tab->build($field['fields'], $value);

            $this->tabs[$title] = $tab;
        }
    }
}
