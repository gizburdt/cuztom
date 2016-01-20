<?php

namespace Gizburdt\Cuztom;

use Gizburdt\Cuztom\Support\Ajax;

if (! defined('ABSPATH')) {
    exit;
}

class Cuztom
{
    private static $version;
    private static $url;
    private static $dir;
    private static $instance;
    private static $ajax;

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
     * Public function to set the instance
     *
     * @return object
     * @since  2.3
     */
    public static function run()
    {
        if (! isset(self::$instance)) {
            self::$instance = new Cuztom;
            self::$instance->setup();
            self::$instance->includes();
            self::$instance->execute();
            self::$instance->add_hooks();
        }

        return self::$instance;
    }

    /**
     * Setup all the constants
     *
     * @since 2.3
     */
    private function setup()
    {
        self::$version  = '3.0';
        self::$dir      = dirname(__FILE__);
        self::$url      = $this->get_cuztom_url(__FILE__);
    }

    /**
     * Include the necessary files
     *
     * @since 2.3
     */
    private function includes()
    {
        // Support
        require_once(self::$dir . '/Support/Guard.php');
        require_once(self::$dir . '/Support/Notice.php');
        require_once(self::$dir . '/Support/Ajax.php');

        // Entity
        require_once(self::$dir . '/Entities/Entity.php');
        require_once(self::$dir . '/Entities/PostType.php');
        require_once(self::$dir . '/Entities/Taxonomy.php');
        require_once(self::$dir . '/Entities/Sidebar.php');
        require_once(self::$dir . '/Entities/helpers.php');

        // Meta
        require_once(self::$dir . '/Meta/Meta.php');
        require_once(self::$dir . '/Meta/Box.php');
        require_once(self::$dir . '/Meta/User.php');
        require_once(self::$dir . '/Meta/Term.php');

        // Fields
        require_once(self::$dir . '/Fields/Field.php');
        require_once(self::$dir . '/Fields/Bundle.php');
        require_once(self::$dir . '/Fields/Tabs.php');
        require_once(self::$dir . '/Fields/Accordion.php');
        require_once(self::$dir . '/Fields/Tab.php');
        require_once(self::$dir . '/Fields/Text.php');
        require_once(self::$dir . '/Fields/Textarea.php');
        require_once(self::$dir . '/Fields/Checkbox.php');
        require_once(self::$dir . '/Fields/YesNo.php');
        require_once(self::$dir . '/Fields/Select.php');
        require_once(self::$dir . '/Fields/MultiSelect.php');
        require_once(self::$dir . '/Fields/Checkboxes.php');
        require_once(self::$dir . '/Fields/Radios.php');
        require_once(self::$dir . '/Fields/Wysiwyg.php');
        require_once(self::$dir . '/Fields/Image.php');
        require_once(self::$dir . '/Fields/File.php');
        require_once(self::$dir . '/Fields/DateTime.php');
        require_once(self::$dir . '/Fields/Date.php');
        require_once(self::$dir . '/Fields/Time.php');
        require_once(self::$dir . '/Fields/Color.php');
        require_once(self::$dir . '/Fields/PostSelect.php');
        require_once(self::$dir . '/Fields/PostCheckboxes.php');
        require_once(self::$dir . '/Fields/TermSelect.php');
        require_once(self::$dir . '/Fields/TermCheckboxes.php');
        require_once(self::$dir . '/Fields/Hidden.php');
    }

    /**
     * Sets globals
     *
     * @since 3.0
     */
    private function execute()
    {
        // Globals
        global $cuztom, $current_screen;

        // Cuztom
        $cuztom          = new \stdClass;
        $cuztom->version = self::$version;
        $cuztom->data    = array();

        // Setup ajax
        self::$ajax = new Ajax;
    }

    /**
     * Add hooks
     *
     * @since 2.3
     */
    private function add_hooks()
    {
        // Assets
        add_action('admin_init', array( &$this, 'register_styles' ));
        add_action('admin_print_styles', array( &$this, 'enqueue_styles' ));

        add_action('admin_init', array( &$this, 'register_scripts' ));
        add_action('admin_enqueue_scripts', array( &$this, 'enqueue_scripts' ));

        // Add AJAX hooks
        self::$ajax->add_hooks();
    }

    /**
     * Registers styles
     *
     * @since 0.3
     */
    public function register_styles()
    {
        wp_register_style('cuztom-jquery-ui', '//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/base/jquery-ui.css', false, self::$version, 'screen');
        wp_register_style('cuztom', self::$url . '/Assets/dist/css/cuztom.min.css', false, self::$version, 'screen');
    }

    /**
     * Enqueues styles
     *
     * @since 0.3
     */
    public function enqueue_styles()
    {
        wp_enqueue_style('wp-color-picker');
        wp_enqueue_style('cuztom-jquery-ui');
        wp_enqueue_style('cuztom');
    }

    /**
     * Registers scripts
     *
     * @since 0.3
     */
    public function register_scripts()
    {
        wp_register_script('cuztom', self::$url . '/Assets/dist/js/cuztom.min.js', array(
            'jquery',
            'jquery-ui-core',
            'jquery-ui-datepicker',
            'jquery-ui-tabs',
            'jquery-ui-accordion',
            'jquery-ui-sortable',
            'jquery-ui-slider',
            'wp-color-picker'
        ), self::$version, true);
    }

    /**
     * Enqueues scripts
     *
     * @since 0.3
     */
    public function enqueue_scripts()
    {
        wp_enqueue_media();
        wp_enqueue_script('cuztom');

        self::localize_scripts();
    }

    /**
     * Localizes scripts
     *
     * @since 1.1.1
     */
    public function localize_scripts()
    {
        wp_localize_script('cuztom', 'Cuztom', array(
            'wp_version'        => get_bloginfo('version'),
            'home_url'          => get_home_url(),
            'ajax_url'          => admin_url('admin-ajax.php'),
            'date_format'       => get_option('date_format'),
            'translations'      => array()
        ));
    }

    /**
     * Recursive method to determine the path to the Cuztom folder
     *
     * @param  string $path
     * @param  array  $url
     * @return string
     * @since  0.4.1
     */
    public function get_cuztom_url($path = __FILE__, $url = array())
    {
        // Retun URL if defined
        if (defined('CUZTOM_URL')) {
            return CUZTOM_URL . 'src/Gizburdt/Cuztom/';
        }

        // Base vars
        $path    = dirname($path);
        $path    = str_replace('\\', '/', $path);
        $expath  = explode('/', $path);
        $current = $expath[count($expath) - 1];

        // Push to path array
        array_push($url, $current);

        // Check for current
        if (preg_match('/content/', $current)) {
            $path = '';
            $directories = array_reverse($url);

            foreach ($directories as $dir) {
                if (! preg_match('/content/', $dir)) {
                    $path = $path . '/' . $dir;
                }
            }

            return apply_filters('cuztom_url', WP_CONTENT_URL . $path);
        } else {
            return $this->get_cuztom_url($path, $url);
        }
    }

    /**
     * Beautifies a string. Capitalize words and remove underscores
     *
     * @param  string $string
     * @return string
     * @since  0.1
     */
    public static function beautify($string)
    {
        return apply_filters('cuztom_beautify', ucwords(str_replace('_', ' ', $string)));
    }

    /**
     * Uglifies a string. Remove strange characters and lower strings
     *
     * @param  string $string
     * @return string
     * @since  0.1
     */
    public static function uglify($string)
    {
        return apply_filters('cuztom_uglify', str_replace('-', '_', sanitize_title($string)));
    }

    /**
     * Makes a word plural
     *
     * @param  string $string
     * @return string
     * @since  0.1
     */
    public static function pluralize($string)
    {
        $specials = apply_filters('cuztom_plural', array(
            array('/(quiz)$/i',               "$1zes"  ),
            array('/^(ox)$/i',                "$1en"   ),
            array('/([m|l])ouse$/i',          "$1ice"  ),
            array('/(matr|vert|ind)ix|ex$/i', "$1ices" ),
            array('/(x|ch|ss|sh)$/i',         "$1es"   ),
            array('/([^aeiouy]|qu)y$/i',      "$1ies"  ),
            array('/([^aeiouy]|qu)ies$/i',    "$1y"    ),
            array('/(hive)$/i',               "$1s"    ),
            array('/(?:([^f])fe|([lr])f)$/i', "$1$2ves"),
            array('/sis$/i',                  "ses"    ),
            array('/([ti])um$/i',             "$1a"    ),
            array('/(buffal|tomat)o$/i',      "$1oes"  ),
            array('/(bu)s$/i',                "$1ses"  ),
            array('/(alias|status)$/i',       "$1es"   ),
            array('/(octop|vir)us$/i',        "$1i"    ),
            array('/(ax|test)is$/i',          "$1es"   ),
            array('/s$/i',                    "s"      ),
            array('/$/',                      "s"      )
        ));

        $irregular = apply_filters('cuztom_irregular', array(
            array('move',   'moves'   ),
            array('sex',    'sexes'   ),
            array('child',  'children'),
            array('man',    'men'     ),
            array('person', 'people'  )
        ));

        $uncountable = apply_filters('cuztom_uncountable', array(
            'sheep',
            'fish',
            'series',
            'species',
            'money',
            'rice',
            'information',
            'equipment'
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
     * Check if variable is empty
     *
     * @param  string|array $input
     * @param  boolean      $result
     * @return boolean
     * @since  3.0
     */
    public static function is_empty($input, $result = true)
    {
        if (is_array($input) && count($input)) {
            foreach ($input as $value) {
                $result = $result && self::is_empty($value);
            }
        } else {
            $result = empty($input);
        }

        return $result;
    }

    /**
     * Check if the term is reserved by Wordpress
     *
     * @param  string  $term
     * @return boolean
     * @since  1.6
     */
    public static function is_reserved_term($term)
    {
        if (! in_array($term, apply_filters('cuztom_reserved_terms', self::$reserved))) {
            return false;
        }

        return new WP_Error('cuztom_reserved_term_used', __('Use of a reserved term.', 'cuztom'));
    }
}

Cuztom::run();
