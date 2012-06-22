## Cuztom Helper

This class can be used to quickly register Custom Post Types, Taxonomies, Meta Boxes, Menu Pages and Sidebars within your Wordpress projects. Please comment, review, watch, fork and report bugs.

**Version:** 0.7.1  
**Requires:** 3.0+ 

## Basic usage

Include the main file.
	
	include( 'cuztom_helper/cuztom_helper.php' );
   
### Add Custom Post Types
	
	$book = new Cuztom_Post_Type( 'Book' );
	
### Add Custom Taxonomies
	
To add Custom Taxonomies to the newly created Post Type, simply call this method.

	$book->add_taxonomy( 'Author' );
			
You can also call this as a seperate class like this. The second parameter is the Post Type name.

	$taxonomy = new Cuztom_Taxonomy( 'Author', 'book' ) )

### Add Meta Boxes
	
Add Meta Boxes.

	$book->add_meta_box( 
		'Book Info', 
		array(
			array(
				'name' 			=> 'author',
				'label' 		=> 'Author',
				'description'	=> 'Just a little description',
				'type'			=> 'text'
			)
		)
	);
	
Meta Boxes can be added with their own class too. The second parameter is the Post Type name.

	$box = new Cuztom_Meta_Box(  
		'Book Info', 
		'book',
		array(
			'name' 			=> 'author',
			'label' 		=> 'Author',
			'description'	=> 'Just a little description',
			'type'			=> 'text'
		)
	)
	
### Add Sidebars

To register a sidebar, just call this.

	$sidebar = new Cuztom_Sidebar( 
		'Sidebar',
		'sidebar' ,
		'Just a little description',
	);

### Add Menu Page

Add a menu page.

	$menu_page = new Cuztom_Menu_Page(
		'Page Title', 
		'Menu Title', 
		'read', 
		'menu_page_slug', 
		'callback_function'
	);
	
### Add Submenu Page

To add a submenu page to the newly added page, call this.

	$menu_page->add_submenu_page(
		'Sub Page Title',
		'Sub Menu Title',
		'read', 
		'submenu_page_slug', 
		'sub_callback_function'
	);

To add a submenu page to another page.

	$submenu_page = new Cuztom_Submenu_Page(
		'parent_slug',
		'Sub Page Title',
		'Sub Menu Title',
		'read', 
		'submenu_page_slug', 
		'sub_callback_function'
	);
	
## Advanced usage
See the <a href="https://github.com/Gizburdt/Wordpress-Cuztom-Helper/wiki">wiki</a> for the full and advanced guides.
	
## Todo
Full roadmap can be found <a href="https://github.com/Gizburdt/Wordpress-Cuztom-Helper/wiki/Roadmap">here</a>.

* Better documentation / Wiki
* More input types like slider and gallery for Meta Boxes.
* Widgets
* Theme Options

## Changelog
You can see the full changelog <a href="https://github.com/Gizburdt/Wordpress-Cuztom-Helper/wiki/Changelog">here</a>.

### 0.7.1
* Added: Meta Box accordion. See the <a href="https://github.com/Gizburdt/Wordpress-Cuztom-Helper/wiki">wiki</a> for usage
* Added: Cuztom now has its own style for jQuery UI. It can be overwritten by defining another style.

### 0.7
* Added: Meta Box tabs. See the <<a href="https://github.com/Gizburdt/Wordpress-Cuztom-Helper/wiki">wiki</a> for usage
* Improvements: Just some minor improvements

### 0.6
* Improvement: Each class has its own file, so the readability is improved
* Improvement: Textdomain added to all translations, the textdomain can be set by a define
* Fixed: Some fatal PHP errors from 0.5 (sorry about that)