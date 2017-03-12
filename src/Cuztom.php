<?php

namespace Gizburdt\Cuztom;

use Gizburdt\Cuztom\Support\Ajax;

if (! defined('ABSPATH')) {
    exit;
}

class Cuztom
{
    /**
     * Version.
     * @var string
     */
    private static $version;

    /**
     * Url.
     * @var string
     */
    private static $url;

    /**
     * Dir.
     * @var string
     */
    private static $dir;

    /**
     * Src.
     * @var string
     */
    private static $src;

    /**
     * Instance.
     * @var object
     */
    private static $instance;

    /**
     * Ajax.
     * @var object
     */
    private static $ajax;

    /**
     * Reserved terms.
     * @var array
     */
    public static $reserved = array(
        'attachment', 'attachment_id', 'author', 'author_name',
        'calendar', 'cat', 'category', 'category__and', 'category__in', 'category__not_in', 'category_name',
        'comments_per_page', 'comments_popup', 'customize_messenger_channel', 'customized', 'cpage',
        'day', 'debug', 'error', 'exact', 'feed', 'hour', 'link_category', 'm', 'minute', 'monthnum', 'more', 'name',
        'nav_menu', 'nonce', 'nopaging', 'offset', 'order', 'orderby', 'p', 'page', 'page_id', 'paged', 'pagename', 'pb', 'perm',
        'post', 'post__in', 'post__not_in', 'post_format', 'post_mime_type', 'post_status', 'post_tag', 'post_type', 'posts', 'posts_per_archive_page',
        'posts_per_page', 'preview', 'robots', 's', 'search', 'second', 'sentence', 'showposts', 'static', 'subpost', 'subpost_id',
        'tag', 'tag__and', 'tag__in', 'tag__not_in', 'tag_id', 'tag_slug__and', 'tag_slug__in', 'taxonomy', 'tb', 'term', 'theme', 'type',
        'w', 'withcomments', 'withoutcomments', 'year'
    );

    /**
     * Public function to set the instance.
     *
     * @return object
     */
    public static function run()
    {
        if (! isset(self::$instance)) {
            self::$instance = new self();

            self::$instance->setup();
            self::$instance->includes();
            self::$instance->execute();
            self::$instance->hooks();
        }

        return self::$instance;
    }

    /**
     * Setup all the constants.
     */
    private function setup()
    {
        self::$version = '3.0.2';
        self::$src     = dirname(__FILE__);
        self::$dir     = dirname(dirname(__FILE__));
        self::$url     = $this->getCuztomUrl(self::$src);
    }

    /**
     * Include the necessary files.
     */
    private function includes()
    {
        // Support
        require_once self::$src.'/Support/Guard.php';
        require_once self::$src.'/Support/Notice.php';
        require_once self::$src.'/Support/Ajax.php';
        require_once self::$src.'/Support/Request.php';
        require_once self::$src.'/Support/Response.php';

        // Entity
        require_once self::$src.'/Entities/Entity.php';
        require_once self::$src.'/Entities/PostType.php';
        require_once self::$src.'/Entities/Taxonomy.php';
        require_once self::$src.'/Entities/Sidebar.php';
        require_once self::$src.'/Entities/helpers.php';

        // Meta
        require_once self::$src.'/Meta/Meta.php';
        require_once self::$src.'/Meta/Box.php';
        require_once self::$src.'/Meta/User.php';
        require_once self::$src.'/Meta/Term.php';
        require_once self::$src.'/Meta/helpers.php';

        // Fields
        require_once self::$src.'/Fields/Traits/Checkable.php';
        require_once self::$src.'/Fields/Traits/Checkables.php';
        require_once self::$src.'/Fields/Traits/Selectable.php';
        require_once self::$src.'/Fields/Field.php';
        require_once self::$src.'/Fields/Bundle.php';
        require_once self::$src.'/Fields/Bundle/Item.php';
        require_once self::$src.'/Fields/Tabs.php';
        require_once self::$src.'/Fields/Accordion.php';
        require_once self::$src.'/Fields/Tab.php';
        require_once self::$src.'/Fields/Text.php';
        require_once self::$src.'/Fields/Textarea.php';
        require_once self::$src.'/Fields/Checkbox.php';
        require_once self::$src.'/Fields/YesNo.php';
        require_once self::$src.'/Fields/Select.php';
        require_once self::$src.'/Fields/MultiSelect.php';
        require_once self::$src.'/Fields/Checkboxes.php';
        require_once self::$src.'/Fields/Radios.php';
        require_once self::$src.'/Fields/Wysiwyg.php';
        require_once self::$src.'/Fields/Image.php';
        require_once self::$src.'/Fields/File.php';
        require_once self::$src.'/Fields/DateTime.php';
        require_once self::$src.'/Fields/Date.php';
        require_once self::$src.'/Fields/Time.php';
        require_once self::$src.'/Fields/Color.php';
        require_once self::$src.'/Fields/PostSelect.php';
        require_once self::$src.'/Fields/PostCheckboxes.php';
        require_once self::$src.'/Fields/TermSelect.php';
        require_once self::$src.'/Fields/TermCheckboxes.php';
        require_once self::$src.'/Fields/TaxonomySelect.php';
        require_once self::$src.'/Fields/TaxonomyCheckboxes.php';
        require_once self::$src.'/Fields/Hidden.php';
    }

    /**
     * Sets globals.
     */
    private function execute()
    {
        // Globals
        global $cuztom;

        // Cuztom
        $cuztom          = new \stdClass();
        $cuztom->version = self::$version;
        $cuztom->data    = array();
        $cuztom->ajax    = new Ajax();
    }

    /**
     * Add hooks.
     */
    private function hooks()
    {
        add_action('admin_init', array(&$this, 'registerStyles'));
        add_action('admin_print_styles', array(&$this, 'enqueueStyles'));

        add_action('admin_init', array(&$this, 'registerScripts'));
        add_action('admin_enqueue_scripts', array(&$this, 'enqueueScripts'));
    }

    /**
     * Registers styles.
     */
    public function registerStyles()
    {
        wp_register_style(
            'cuztom-jquery-ui',
            '//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/base/jquery-ui.css',
            false,
            self::$version,
            'screen'
        );

        wp_register_style(
            'cuztom',
            self::$url.'/assets/css/cuztom.min.css',
            false,
            self::$version,
            'screen'
        );
    }

    /**
     * Enqueues styles.
     */
    public function enqueueStyles()
    {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_style('cuztom-jquery-ui');
        wp_enqueue_style('cuztom');
    }

    /**
     * Registers scripts.
     */
    public function registerScripts()
    {
        // Cuztom
        wp_register_script(
            'cuztom',
            self::$url.'/assets/js/cuztom.min.js',
            array(
                'jquery',
                'jquery-ui-core',
                'jquery-ui-tabs',
                'jquery-ui-accordion',
                'jquery-ui-sortable',
                'jquery-ui-slider',
                'wp-color-picker'
            ),
            self::$version,
            true
        );
    }

    /**
     * Enqueues scripts.
     */
    public function enqueueScripts()
    {
        wp_enqueue_media();
        wp_enqueue_script('cuztom');

        self::localizeScripts();
    }

    /**
     * Localizes scripts.
     */
    public function localizeScripts()
    {
        wp_localize_script('cuztom', 'Cuztom', array(
            'wpVersion'  => get_bloginfo('version'),
            'wpNonce'    => wp_create_nonce('cuztom'),
            'homeUrl'    => get_home_url(),
            'ajaxUrl'    => admin_url('admin-ajax.php'),
            'dateFormat' => get_option('date_format'),
            'translate'  => array()
        ));
    }

    /**
     * Recursive method to determine the path to the Cuztom folder.
     *
     * @param  string $path
     * @param  array  $url
     * @return string
     */
    public function getCuztomUrl($path = __FILE__, $url = array())
    {
        // Retun URL if defined
        if (defined('CUZTOM_URL')) {
            return CUZTOM_URL;
        }

        // Base vars
        $path    = dirname($path);
        $path    = str_replace('\\', '/', $path);
        $expath  = explode('/', $path);
        $current = $expath[count($expath) - 1];

        // Push to path array
        array_push($url, $current);

        // Check for current
        if (preg_match('/content|app/', $current)) {
            $path        = '';
            $directories = array_reverse($url);

            foreach ($directories as $dir) {
                if (! preg_match('/content|app/', $dir)) {
                    $path = $path.'/'.$dir;
                }
            }

            return apply_filters('cuztom_url', WP_CONTENT_URL.$path);
        } else {
            return $this->getCuztomUrl($path, $url);
        }
    }

    /**
     * Get a box from data.
     *
     * @param  string $box
     * @return object
     */
    public static function getBox($box)
    {
        global $cuztom;

        return isset($cuztom->data[$box]) ? $cuztom->data[$box] : null;
    }

    /**
     * Beautifies a string. Capitalize words and remove underscores.
     *
     * @param  string $string
     * @return string
     */
    public static function beautify($string)
    {
        return apply_filters('cuztom_beautify', ucwords(str_replace('_', ' ', $string)));
    }

    /**
     * Uglifies a string. Remove strange characters and lower strings.
     *
     * @param  string $string
     * @return string
     */
    public static function uglify($string)
    {
        return apply_filters('cuztom_uglify', str_replace('-', '_', sanitize_title($string)));
    }

    /**
     * Makes a word plural.
     *
     * @param  string $string
     * @return string
     */
    public static function pluralize($string)
    {
        $specials = apply_filters('cuztom_plural', array(
            array('/(quiz)$/i',               '$1zes'),
            array('/^(ox)$/i',                '$1en'),
            array('/([m|l])ouse$/i',          '$1ice'),
            array('/(matr|vert|ind)ix|ex$/i', '$1ices'),
            array('/(x|ch|ss|sh)$/i',         '$1es'),
            array('/([^aeiouy]|qu)y$/i',      '$1ies'),
            array('/([^aeiouy]|qu)ies$/i',    '$1y'),
            array('/(hive)$/i',               '$1s'),
            array('/(?:([^f])fe|([lr])f)$/i', '$1$2ves'),
            array('/sis$/i',                  'ses'),
            array('/([ti])um$/i',             '$1a'),
            array('/(buffal|tomat)o$/i',      '$1oes'),
            array('/(bu)s$/i',                '$1ses'),
            array('/(alias|status)$/i',       '$1es'),
            array('/(octop|vir)us$/i',        '$1i'),
            array('/(ax|test)is$/i',          '$1es'),
            array('/s$/i',                    's'),
            array('/$/',                      's')
        ));

        $irregular = apply_filters('cuztom_irregular', array(
            array('move',   'moves'),
            array('sex',    'sexes'),
            array('child',  'children'),
            array('man',    'men'),
            array('person', 'people')
        ));

        $uncountable = apply_filters('cuztom_uncountable', array(
            'sheep',
            'fish',
            'series',
            'species',
            'money',
            'rice',
            'information',
            'equipment',
            'pokemon'
        ));

        // Save time if string in uncountable
        if (in_array(strtolower($string), $uncountable)) {
            return apply_filters('cuztom_pluralize', $string, 'uncountable');
        }

        // Check for irregular words
        foreach ($irregular as $noun) {
            if (strtolower($string) == $noun[0]) {
                return apply_filters('cuztom_pluralize', $noun[1], 'irregular');
            }
        }

        // Check for plural forms
        foreach ($specials as $pattern) {
            if (preg_match($pattern[0], $string)) {
                return apply_filters('cuztom_pluralize', preg_replace($pattern[0], $pattern[1], $string), 'special');
            }
        }

        // Return if noting found
        return apply_filters('cuztom_pluralize', $string, null);
    }

    /**
     * String to time.
     *
     * @param  string $string
     * @return string
     */
    public static function time($string)
    {
        return strtotime(str_replace('/', '-', $string));
    }

    /**
     * Include view file.
     *
     * @param string $view
     * @param array  $variables
     */
    public static function view($view, $variables = array())
    {
        extract($variables);

        ob_start();

        include self::$dir.'/resources/views/'.$view.'.php';

        return ob_get_clean();
    }

    /**
     * Check if isset and true.
     *
     * @param  string $input Mostly an array element
     * @return bool
     */
    public static function isTrue($input)
    {
        return isset($input) && $input == true;
    }

    /**
     * Check if variable is empty.
     *
     * @param  string|array $input
     * @param  bool         $result
     * @return bool
     */
    public static function isEmpty($input, $result = true)
    {
        if (is_array($input) && count($input)) {
            foreach ($input as $value) {
                $result = $result && self::isEmpty($value);
            }
        } else {
            $result = empty($input);
        }

        return $result;
    }

    /**
     * Check if array (and not empty).
     *
     * @param  mixed $input
     * @return bool
     */
    public static function isArray($input)
    {
        return ! self::isEmpty($input) && is_array($input);
    }

    /**
     * Check if string starts with.
     *
     * @param  string $string
     * @param  string $start
     * @return bool
     */
    public static function startsWith($string, $start)
    {
        return substr($string, 0, 1) == $start;
    }

    /**
     * htmlspecialchars && json_encode.
     *
     * @param  mixed  $input
     * @return string
     */
    public static function jsonEncode($input)
    {
        return ! self::isEmpty($input) ? htmlspecialchars(json_encode($input)) : 0;
    }

    /**
     * Merge.
     *
     * @param  array $base
     * @param  array $merge
     * @return array
     */
    public static function merge($base, $merge)
    {
        if (is_string($merge)) {
            $explode = explode('=>', $merge);

            $merge = array(
                trim($explode[0]) => trim($explode[1])
            );
        }

        return array_merge($base, $merge);
    }

    /**
     * Check if the term is reserved by Wordpress.
     *
     * @param  string $term
     * @return bool
     */
    public static function isReservedTerm($term)
    {
        if (! in_array($term, apply_filters('cuztom_reserved_terms', self::$reserved))) {
            return false;
        }

        return new \WP_Error('cuztom_reserved_term_used', __('Use of a reserved term.', 'cuztom'));
    }
}

Cuztom::run();
