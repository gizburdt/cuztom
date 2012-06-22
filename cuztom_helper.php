<?php

// Errors
//error_reporting( E_ALL );
//ini_set( 'display_errors', 1 );

// Start
ob_start();

// Define
define( 'CUZTOM_VERSION', '0.7.1' );
if( ! defined( 'CUZTOM_TEXTDOMAIN' ) ) define( 'CUZTOM_TEXTDOMAIN', 'cuztom' );
if( ! defined( 'CUZTOM_JQUERY_UI_STYLE' ) ) define( 'CUZTOM_JQUERY_UI_STYLE', 'cuztom' );

// Include
include( 'classes/cuztom.class.php' );
include( 'classes/field.class.php' );
include( 'classes/post_type.class.php' );
include( 'classes/meta_box.class.php' );
include( 'classes/taxonomy.class.php' );
include( 'classes/menu_page.class.php' );
include( 'classes/submenu_page.class.php' );
include( 'classes/sidebar.class.php' );

// Init
$cuztom = new Cuztom();

?>