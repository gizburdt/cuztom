## Cuztom Helper

This class can be used to quickly register Custom Post Types, Taxonomies, Meta Boxes, Menu Pages and Sidebars within your Wordpress projects. Please comment, review, watch, fork and report bugs.

**Version:** 0.9.5  
**Requires:** 3.0+  

### Contributors
* <a href="https://github.com/Gizburdt">Gijs Jorissen [Gizburdt]</a>
* <a href="https://github.com/Pushplaybang">Paul [Pushplaybang]</a>

## Basic usage

Include the main file.
	
	include( 'cuztom_helper/cuztom_helper.php' );
   
### Add Custom Post Types
	
	$book = register_cuztom_post_type( 'Book' );
	
### Add Custom Taxonomies
	
To add Custom Taxonomies to the newly created Post Type, simply call this method.

	$book->add_taxonomy( 'Author' );
			
You can also call this as a seperate class like this. The second parameter is the Post Type name.

	$taxonomy = register_cuztom_taxonomy( 'Author', 'book' ) )

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

	$box = add_cuztom_meta_box(  
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

	$sidebar = register_cuztom_sidebar( 
		'Sidebar',
		'sidebar' ,
		'Just a little description',
	);

### Add Menu Page

Add a menu page.

	$menu_page = add_cuztom_menu_page(
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

	$submenu_page = add_cuztom_submenu_page(
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

###0.9.5
* Fixed: Issue #20: Functions.js is preventing Media Uploader from inserting image

###0.9.4
* Fixed: Issue #16: Undefined index notice

###0.9.3
* Fixed and improved: After some mistakes I made, this is a stable release.

###0.9.2
* Fixed: Issue #10: Fields in tabs now work again (props DarbCal)

### 0.9.1
* Small improvements

###0.9
* Added: Default value for input fields
* Added: Cuztom now checks if the current user is capable to edit the post
* Improvement: Remove current image for image unput field
* Improvement: Some minor improvements