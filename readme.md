## Cuztom Helper

This class can be used to quickly register Custom Post Types, Taxonomies, Meta Boxes, Menu Pages and Sidebars within your Wordpress projects. Please comment, review, watch, fork and report bugs.

**Version:** 0.8.1  
**Requires:** 3.0+ 

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

##0.8.1
* Added: Meta box taxonomies. Taxonomies as checkboxes in Meta Boxes.
* Improvement: Before Cuztom_Field will check if $field['options'] is an array before it loops through it. 

###0.8
* Added: Function: You can now use functions to execute some commands ( e.g. register_cuztom_post_type('book') )
* Changed: The second parameter of add Cuztom_Meta_Box is now $post_type_name instead of $fields. $fields is now the third parameter

###0.7.4
* Fixed: Cuztom::pluralize doesn't attach an 's', when the string ends with an 's'