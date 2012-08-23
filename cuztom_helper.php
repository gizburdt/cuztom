<?php

// Start
ob_start();

// Define
define( 'CUZTOM_VERSION', '0.9.5' );
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

include( 'functions/post_type.php' );
include( 'functions/taxonomy.php' );
include( 'functions/meta_box.php' );
include( 'functions/sidebar.php' );
include( 'functions/menu_page.php' );
include( 'functions/submenu_page.php' );
include( 'functions/field.php' );

// Init
$cuztom = new Cuztom();

?>