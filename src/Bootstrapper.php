<?php

namespace Gizburdt\Cuztom;

Guard::blockDirectAccess();

class Bootstrapper
{
    /**
     * Public function to set the instance.
     *
     * @return object
     */
    public static function run()
    {
        global $cuztom;

        if (! isset(Cuztom::$instance)) {
            Cuztom::$instance = new Cuztom();

            Cuztom::$instance->setup();
            Cuztom::$instance->execute();
            Cuztom::$instance->hooks();
            Cuztom::$instance->api();
        }

        $cuztom = Cuztom::$instance;
    }

    /**
     * Setup all the constants.
     */
    private function setup()
    {
        self::$version = '3.1.7';
        self::$src = dirname(__FILE__);
        self::$dir = dirname(dirname(__FILE__));
        self::$url = $this->getCuztomUrl(self::$src);

        do_action('cuztom_setup');
    }

    /**
     * Add hooks.
     */
    private function hooks()
    {
        add_action('admin_init', [$this, 'registerStyles']);
        add_action('admin_print_styles', [$this, 'enqueueStyles']);

        add_action('admin_init', [$this, 'registerScripts']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueScripts']);

        do_action('cuztom_hooks');
    }

    /**
     * Init API.
     *
     * @return void
     */
    private function api()
    {
        (new Api())->init();

        do_action('cuztom_ajax');
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
            [
                'jquery',
                'jquery-ui-core',
                'jquery-ui-tabs',
                'jquery-ui-accordion',
                'jquery-ui-sortable',
                'jquery-ui-slider',
                'wp-color-picker',
            ],
            self::$version,
            true
        );

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

        do_action('cuztom_enqueue_scripts');
    }

    /**
     * Localizes scripts.
     */
    public function localizeScripts()
    {
        wp_localize_script('cuztom', 'Cuztom', [
            'wpVersion'  => get_bloginfo('version'),
            'wpNonce'    => wp_create_nonce('cuztom'),
            'homeUrl'    => get_home_url(),
            'ajaxUrl'    => admin_url('admin-ajax.php'),
            'dateFormat' => get_option('date_format'),
            'translate'  => [],
        ]);

        do_action('cuztom_localize_scripts');
    }

    /**
     * Recursive method to determine the path to the Cuztom folder.
     *
     * @param string $path
     * @param array  $url
     *
     * @return string
     */
    public function getCuztomUrl($path = __FILE__, $url = [])
    {
        // Retun URL if defined
        if (defined('CUZTOM_URL')) {
            return CUZTOM_URL;
        }

        // Base vars
        $path = dirname($path);
        $path = str_replace('\\', '/', $path);
        $expath = explode('/', $path);
        $current = $expath[count($expath) - 1];

        // Push to path array
        array_push($url, $current);

        // Check for current
        if (preg_match('/content|app/', $current)) {
            $path = '';
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
}

Bootstrapper::run();
