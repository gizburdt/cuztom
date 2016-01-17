<?php

if( ! defined( 'ABSPATH' ) ) exit;

class Cuztom
{
    private static $version;
    private static $url;
    private static $dir;
    private static $instance;
    private static $ajax;

    static $reserved = array(
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
        if( ! isset( self::$instance ) ) {
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
        self::$dir      = dirname( __FILE__ );
        self::$url      = $this->get_cuztom_url( __FILE__ );
    }

    /**
     * Include the necessary files
     *
     * @since 2.3
     */
    private function includes()
    {
        // General
        include( self::$dir . '/classes/class-entity.php' );
        include( self::$dir . '/classes/class-notice.php' );
        include( self::$dir . '/classes/class-ajax.php' );
        include( self::$dir . '/classes/class-post-type.php' );
        include( self::$dir . '/classes/class-taxonomy.php' );
        include( self::$dir . '/classes/class-sidebar.php' );

        // Meta
        include( self::$dir . '/classes/class-meta.php' );
        include( self::$dir . '/classes/meta/class-meta-box.php' );
        include( self::$dir . '/classes/meta/class-user-meta.php' );
        include( self::$dir . '/classes/meta/class-term-meta.php' );

        // Fields
        include( self::$dir . '/classes/class-field.php' );
        include( self::$dir . '/classes/fields/class-bundle.php' );
        include( self::$dir . '/classes/fields/class-tabs.php' );
        include( self::$dir . '/classes/fields/class-accordion.php' );
        include( self::$dir . '/classes/fields/class-tab.php' );
        include( self::$dir . '/classes/fields/class-text.php' );
        include( self::$dir . '/classes/fields/class-textarea.php' );
        include( self::$dir . '/classes/fields/class-checkbox.php' );
        include( self::$dir . '/classes/fields/class-yesno.php' );
        include( self::$dir . '/classes/fields/class-select.php' );
        include( self::$dir . '/classes/fields/class-multi-select.php' );
        include( self::$dir . '/classes/fields/class-checkboxes.php' );
        include( self::$dir . '/classes/fields/class-radios.php' );
        include( self::$dir . '/classes/fields/class-wysiwyg.php' );
        include( self::$dir . '/classes/fields/class-image.php' );
        include( self::$dir . '/classes/fields/class-file.php' );
        include( self::$dir . '/classes/fields/class-datetime.php' );
        include( self::$dir . '/classes/fields/class-date.php' );
        include( self::$dir . '/classes/fields/class-time.php' );
        include( self::$dir . '/classes/fields/class-color.php' );
        include( self::$dir . '/classes/fields/class-post-select.php' );
        include( self::$dir . '/classes/fields/class-post-checkboxes.php' );
        include( self::$dir . '/classes/fields/class-term-select.php' );
        include( self::$dir . '/classes/fields/class-term-checkboxes.php' );
        include( self::$dir . '/classes/fields/class-hidden.php' );

        // Functions
        include( self::$dir . '/functions/post-type.php' );
        include( self::$dir . '/functions/taxonomy.php' );
        include( self::$dir . '/functions/user.php' );
        include( self::$dir . '/functions/sidebar.php' );
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
        $cuztom          = new stdClass;
        $cuztom->version = self::$version;
        $cuztom->data    = array();

        // Setup ajax
        self::$ajax = new Cuztom_Ajax;
    }

    /**
     * Add hooks
     *
     * @since 2.3
     */
    private function add_hooks()
    {
        // Assets
        add_action( 'admin_init', array( &$this, 'register_styles' ) );
        add_action( 'admin_print_styles', array( &$this, 'enqueue_styles' ) );

        add_action( 'admin_init', array( &$this, 'register_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( &$this, 'enqueue_scripts' ) );

        // Ajax
        self::$ajax->add_hooks();
    }

    /**
     * Registers styles
     *
     * @since 0.3
     */
    function register_styles()
    {
        wp_register_style( 'cztm-jquery-ui', '//ajax.googleapis.com/ajax/libs/jqueryui/1.9.2/themes/base/jquery-ui.css', false, self::$version, 'screen' );
        wp_register_style( 'cztm', self::$url . '/assets/dist/css/cuztom.min.css', false, self::$version, 'screen' );
    }

    /**
     * Enqueues styles
     *
     * @since 0.3
     */
    function enqueue_styles()
    {
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_style( 'cztm-jquery-ui' );
        wp_enqueue_style( 'cztm' );
    }

    /**
     * Registers scripts
     *
     * @since 0.3
     */
    function register_scripts()
    {
        wp_register_script( 'cztm', self::$url . '/assets/dist/js/cuztom.min.js', array(
            'jquery',
            'jquery-ui-core',
            'jquery-ui-datepicker',
            'jquery-ui-tabs',
            'jquery-ui-accordion',
            'jquery-ui-sortable',
            'jquery-ui-slider',
            'wp-color-picker'
        ), self::$version, true );
    }

    /**
     * Enqueues scripts
     *
     * @since 0.3
     */
    function enqueue_scripts()
    {
        wp_enqueue_media();
        wp_enqueue_script( 'media-upload' );
        wp_enqueue_script( 'cztm' );

        self::localize_scripts();
    }

    /**
     * Localizes scripts
     *
     * @since 1.1.1
     */
    function localize_scripts()
    {
        wp_localize_script( 'cztm', 'Cztm', array(
            'wp_version'        => get_bloginfo( 'version' ),
            'home_url'          => get_home_url(),
            'ajax_url'          => admin_url( 'admin-ajax.php' ),
            'date_format'       => get_option( 'date_format' ),
            'translations'      => array()
        ) );
    }

    /**
     * Recursive method to determine the path to the Cuztom folder
     *
     * @param  string $path
     * @param  array  $url
     * @return string
     * @since  0.4.1
     */
    function get_cuztom_url( $path = __FILE__, $url = array() )
    {
        // Retun URL if defined
        if( defined('CUZTOM_URL') ) {
            return CUZTOM_URL;
        }

        // Base vars
        $path    = dirname( $path );
        $path    = str_replace( '\\', '/', $path );
        $expath  = explode( '/', $path );
        $current = $expath[count( $expath ) - 1];

        // Push to path array
        array_push( $url, $current );

        // Check for current
        if( preg_match( '/content/', $current ) ) {
            $path = '';
            $directories = array_reverse( $url );

            foreach( $directories as $dir ) {
                if( ! preg_match( '/content/', $dir ) ) {
                    $path = $path . '/' . $dir;
                }
            }

            return apply_filters( 'cuztom_url', WP_CONTENT_URL . $path );
        } else {
            return $this->get_cuztom_url( $path, $url );
        }
    }

    /**
     * Beautifies a string. Capitalize words and remove underscores
     *
     * @param  string $string
     * @return string
     * @since  0.1
     */
    static function beautify( $string )
    {
        return apply_filters( 'cuztom_beautify', ucwords( str_replace( '_', ' ', $string ) ) );
    }

    /**
     * Uglifies a string. Remove strange characters and lower strings
     *
     * @param  string $string
     * @return string
     * @since  0.1
     */
    static function uglify( $string )
    {
        return apply_filters( 'cuztom_uglify', str_replace( '-', '_', sanitize_title( $string ) ) );
    }

    /**
     * Makes a word plural
     *
     * @param  string $string
     * @return string
     * @since  0.1
     */
    static function pluralize( $string )
    {
        $specials = apply_filters( 'cuztom_plural', array(
            array( '/(quiz)$/i',               "$1zes"   ),
            array( '/^(ox)$/i',                "$1en"    ),
            array( '/([m|l])ouse$/i',          "$1ice"   ),
            array( '/(matr|vert|ind)ix|ex$/i', "$1ices"  ),
            array( '/(x|ch|ss|sh)$/i',         "$1es"    ),
            array( '/([^aeiouy]|qu)y$/i',      "$1ies"   ),
            array( '/([^aeiouy]|qu)ies$/i',    "$1y"     ),
            array( '/(hive)$/i',               "$1s"     ),
            array( '/(?:([^f])fe|([lr])f)$/i', "$1$2ves" ),
            array( '/sis$/i',                  "ses"     ),
            array( '/([ti])um$/i',             "$1a"     ),
            array( '/(buffal|tomat)o$/i',      "$1oes"   ),
            array( '/(bu)s$/i',                "$1ses"   ),
            array( '/(alias|status)$/i',       "$1es"    ),
            array( '/(octop|vir)us$/i',        "$1i"     ),
            array( '/(ax|test)is$/i',          "$1es"    ),
            array( '/s$/i',                    "s"       ),
            array( '/$/',                      "s"       )
        ) );

        $irregular = apply_filters( 'cuztom_irregular', array(
            array( 'move',   'moves'    ),
            array( 'sex',    'sexes'    ),
            array( 'child',  'children' ),
            array( 'man',    'men'      ),
            array( 'person', 'people'   )
        ) );

        $uncountable = apply_filters( 'cuztom_uncountable', array(
            'sheep',
            'fish',
            'series',
            'species',
            'money',
            'rice',
            'information',
            'equipment'
        ) );

        // Save time if string in uncountable
        if( in_array( strtolower( $string ), $uncountable ) ) {
            return apply_filters( 'cuztom_pluralize', $string, 'uncountable' );
        }

        // Check for irregular words
        foreach ( $irregular as $noun ) {
            if( strtolower( $string ) == $noun[0] ) {
                return apply_filters( 'cuztom_pluralize', $noun[1], 'irregular' );
            }
        }

        // Check for plural forms
        foreach ( $specials as $pattern ) {
            if( preg_match( $pattern[0], $string ) ) {
                return apply_filters( 'cuztom_pluralize', preg_replace( $pattern[0], $pattern[1], $string ), 'special' );
            }
        }

        // Return if noting found
        return apply_filters( 'cuztom_pluralize', $string, null );
    }

    /**
     * Check if variable is empty
     *
     * @param  string|array $input
     * @param  boolean      $result
     * @return boolean
     * @since  3.0
     */
    static function is_empty($input, $result = true)
    {
        if(is_array($input) && count($input)) {
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
    static function is_reserved_term( $term )
    {
        if( ! in_array( $term, apply_filters( 'cuztom_reserved_terms', self::$reserved ) ) ) {
            return false;
        }

        return new WP_Error( 'cuztom_reserved_term_used', __( 'Use of a reserved term.', 'cuztom' ) );
    }
}

Cuztom::run();