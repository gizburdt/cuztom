<?php

namespace Gizburdt\Cuztom\Fields;

use Gizburdt\Cuztom\Support\Guard;

Guard::directAccess();

class Accordion extends Tabs
{
    /**
     * Ouput accordion row.
     *
     * @param mixed $value
     *
     * @since 3.0
     */
    public function output_row($value = null)
    {
        ob_start();

        ?>

        <tr class="cuztom-accordion">
            <td class="cuztom-field" colspan="2" id="<?php echo $this->get_id();
        ?>">
                <?php echo$this->output();
        ?>
            </td>
        </tr>

        <?php $ob = ob_get_clean();

        return $ob;
    }

    /**
     * Output accordion.
     *
     * @param array $args
     *
     * @since 3.0
     */
    public function output($args = array())
    {
        $args['type'] = 'accordion';

        ob_start();

        ?>

        <div class="js-cuztom-accordion">
            <?php foreach ($this->tabs as $title => $tab) : ?>
                <?php echo $tab->output($args);
        ?>
            <?php endforeach;
        ?>
        </div>

        <?php $ob = ob_get_clean();

        return $ob;
    }
}
