<?php

namespace Gizburdt\Cuztom;

use Gizburdt\Cuztom\Support\Ajax;

if (! defined('ABSPATH')) {
    die();
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
     * Data.
     * @var object
     */
    public static $data = array();

    /**
     * Fields.
     * @var array
     */
    public static $fields = array();

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
            self::$instance->execute();
            self::$instance->hooks();
            self::$instance->ajax();
        }

        return self::$instance;
    }

    /**
     * Setup all the constants.
     */
    private function setup()
    {
        self::$version = '3.1.7';
        self::$src     = dirname(__FILE__);
        self::$dir     = dirname(dirname(__FILE__));
        self::$url     = $this->getCuztomUrl(self::$src);

        // Do
        do_action('cuztom_setup');
    }

    /**
     * Sets globals.
     */
    private function execute()
    {
        global $cuztom;

        $cuztom = new self();

        // Do
        do_action('cuztom_execute');
    }

    /**
     * Add hooks.
     */
    private function hooks()
    {
        add_action('admin_init', array($this, 'registerStyles'));
        add_action('admin_print_styles', array($this, 'enqueueStyles'));

        add_action('admin_init', array($this, 'registerScripts'));
        add_action('admin_enqueue_scripts', array($this, 'enqueueScripts'));

        // Do
        do_action('cuztom_hooks');
    }

    /**
     * Init Ajax.
     *
     * @return void
     */
    private function ajax()
    {
        (new Ajax())->init();
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

        // Do
        do_action('cuztom_register_styles');
    }

    /**
     * Enqueues styles.
     */
    public function enqueueStyles()
    {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_style('cuztom-jquery-ui');
        wp_enqueue_style('cuztom');

        // Do
        do_action('cuztom_enqueue_styles');
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

        // Do
        do_action('cuztom_regiter_scripts');
    }

    /**
     * Enqueues scripts.
     */
    public function enqueueScripts()
    {
        wp_enqueue_media();
        wp_enqueue_script('cuztom');

        self::localizeScripts();

        // Do
        do_action('cuztom_enqueue_scripts');
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

        // Do
        do_action('cuztom_localize_scripts');
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
        return isset(self::$data[$box]) ? self::$data[$box] : null;
    }

    /**
     * Add box to global.
     *
     * @param object $box
     */
    public static function addBox($box)
    {
        self::$data[$box->id] = $box;
    }

    /**
     * Get field.
     *
     * @param  string $field
     * @return object
     */
    public static function getField($field)
    {
        return isset(self::$fields[$field]) ? self::$fields[$field] : null;
    }

    /**
     * Add field to global.
     *
     * @param object $field
     */
    public static function addField($field)
    {
        self::$fields[$field->id] = $field;
    }

    /**
     * Get all fields.
     *
     * @return array
     */
    public static function getFields()
    {
        return self::$fields;
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
                return apply_filters('cuztom_pluralize', ucwords($noun[1]), 'irregular');
            }
        }

        // Check for plural forms
        foreach ($specials as $pattern) {
            if (preg_match($pattern[0], $string)) {
                return apply_filters(
                    'cuztom_pluralize',
                    ucwords(preg_replace($pattern[0], $pattern[1], $string)),
                    'special'
                );
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
        return apply_filters('cuztom_time', strtotime(str_replace('/', '-', $string)));
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

        include dirname(dirname(__FILE__)).'/resources/views/'.$view.'.php';

        return ob_get_clean();
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

            return $result;
        }

        return empty($input);
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
