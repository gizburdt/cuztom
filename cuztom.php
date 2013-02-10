<?php

// Start
ob_start();

// Define
define( 'CUZTOM_VERSION', '2.1.1' );
if( ! defined( 'CUZTOM_URL' ) ) define( 'CUZTOM_URL', '' );
if( ! defined( 'CUZTOM_JQUERY_UI_STYLE' ) ) define( 'CUZTOM_JQUERY_UI_STYLE', 'cuztom' );

// Include
include( 'classes/cuztom.class.php' );

include( 'classes/field.class.php' );
include( 'classes/fields/bundle.class.php' );
include( 'classes/fields/tabs.class.php' );
include( 'classes/fields/accordion.class.php' );
include( 'classes/fields/tab.class.php' );
include( 'classes/fields/text.class.php' );
include( 'classes/fields/textarea.class.php' );
include( 'classes/fields/checkbox.class.php' );
include( 'classes/fields/yesno.class.php' );
include( 'classes/fields/select.class.php' );
include( 'classes/fields/multi_select.class.php' );
include( 'classes/fields/checkboxes.class.php' );
include( 'classes/fields/radios.class.php' );
include( 'classes/fields/wysiwyg.class.php' );
include( 'classes/fields/image.class.php' );
include( 'classes/fields/file.class.php' );
include( 'classes/fields/date.class.php' );
include( 'classes/fields/time.class.php' );
include( 'classes/fields/datetime.class.php' );
include( 'classes/fields/color.class.php' );
include( 'classes/fields/post_select.class.php' );
include( 'classes/fields/post_checkboxes.class.php' );
include( 'classes/fields/term_select.class.php' );
include( 'classes/fields/term_checkboxes.class.php' );
include( 'classes/fields/hidden.class.php' );

include( 'classes/meta.class.php' );
include( 'classes/meta_box.class.php' );
include( 'classes/user_meta.class.php' );

include( 'classes/post_type.class.php' );
include( 'classes/taxonomy.class.php' );

include( 'classes/sidebar.class.php' );
include( 'classes/page.class.php' );
include( 'classes/pages/menu_page.class.php' );
include( 'classes/pages/submenu_page.class.php' );

include( 'functions/post_type.php' );
include( 'functions/taxonomy.php' );
include( 'functions/meta_box.php' );
include( 'functions/sidebar.php' );
include( 'functions/menu_page.php' );
include( 'functions/submenu_page.php' );

// Init
$cuztom = new Cuztom();