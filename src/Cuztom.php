<?php

namespace Gizburdt\Cuztom;

use Illuminate\Support\Str;

Guard::blockDirectAccess();

class Cuztom
{
    /**
     * Version.
     */
    const VERSION = '4.0.0';

    /**
     * Url.
     *
     * @var string
     */
    private static $url;

    /**
     * Dir.
     *
     * @var string
     */
    private static $dir;

    /**
     * Src.
     *
     * @var string
     */
    private static $src;

    /**
     * Instance.
     *
     * @var object
     */
    private static $instance;

    /**
     * Data.
     *
     * @var object
     */
    public static $data = [];

    /**
     * Fields.
     *
     * @var array
     */
    public static $fields = [];

    /**
     * Reserved terms.
     *
     * @var array
     */
    public static $reserved = [
        'attachment', 'attachment_id', 'author', 'author_name',
        'calendar', 'cat', 'category', 'category__and',
        'category__in', 'category__not_in', 'category_name', 'comments_per_page',
        'comments_popup', 'customize_messenger_channel', 'customized', 'cpage',
        'day', 'debug', 'error', 'exact',
        'feed', 'hour', 'link_category', 'm',
        'minute', 'monthnum', 'more', 'name',
        'nav_menu', 'nonce', 'nopaging', 'offset',
        'order', 'orderby', 'p', 'page',
        'page_id', 'paged', 'pagename', 'pb',
        'perm', 'post', 'post__in', 'post__not_in',
        'post_format', 'post_mime_type', 'post_status', 'post_tag',
        'post_type', 'posts', 'posts_per_archive_page', 'posts_per_page',
        'preview', 'robots', 's', 'search',
        'second', 'sentence', 'showposts', 'static',
        'subpost', 'subpost_id', 'tag', 'tag__and',
        'tag__in', 'tag__not_in', 'tag_id', 'tag_slug__and',
        'tag_slug__in', 'taxonomy', 'tb', 'term',
        'theme', 'type', 'w', 'withcomments',
        'withoutcomments', 'year',
    ];

    /**
     * Get a box from data.
     *
     * @param string $box
     *
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
     * @param string $field
     *
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
     * @param string $string
     *
     * @return string
     */
    public static function beautify($string)
    {
        return apply_filters('cuztom_beautify', ucwords(str_replace('_', ' ', $string)));
    }

    /**
     * Uglifies a string. Remove strange characters and lower strings.
     *
     * @param string $string
     *
     * @return string
     */
    public static function uglify($string)
    {
        return apply_filters('cuztom_uglify', str_replace('-', '_', sanitize_title($string)));
    }

    /**
     * Makes a word plural.
     *
     * @param string $string
     *
     * @return string
     */
    public static function pluralize($string)
    {
        return apply_filters('cuztom_pluralize', Str::plural($string));
    }

    /**
     * Include view file.
     *
     * @param string $view
     * @param array  $variables
     */
    public static function view($view, $variables = [])
    {
        extract($variables);

        ob_start();

        include self::$dir.'/resources/views/'.$view.'.php';

        return ob_get_clean();
    }

    /**
     * Check if the term is reserved by Wordpress.
     *
     * @param string $term
     *
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
