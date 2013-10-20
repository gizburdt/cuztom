## Cuztom Helper

This helper can be used to quickly register Custom Post Types, Taxonomies, Meta Boxes, Menu Pages and Sidebars within your Wordpress projects. Please comment, review, watch, fork and report bugs.

**Version:** 2.9.1  
**Requires:** 3.5 / 3.0+  

## Basic usage

Include the main file.
	
	include( 'cuztom/cuztom.php' );
   
### Add Custom Post Types
	
	$book = register_cuztom_post_type( 'Book' );

**Note:** If you're using Custom Post Types, don't forget to *[flush rewrite rules on activation](http://codex.wordpress.org/Function_Reference/register_post_type#Flushing_Rewrite_on_Activation "Flushing Rewrite Rules on Activation")*.

### Add Custom Taxonomies
	
To add Custom Taxonomies to the newly created Post Type, simply call this method.

	$book->add_taxonomy( 'Author' );
			
You can also call this as a seperate class like this. The second parameter is the Post Type name.

	$taxonomy = register_cuztom_taxonomy( 'Author', 'book' );

### Add Meta Boxes
	
Add Meta Boxes.

	$book->add_meta_box( 
		'meta_box_id',
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
		'meta_box_id',
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

	$sidebar = register_cuztom_sidebar( array(
		'name'				=> 'Sidebar Twee',
		'id'				=> 'sidebar_twee',
		'description'		=> 'Build with an array',
	) );

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

## Changelog
You can see the full changelog <a href="https://github.com/Gizburdt/Wordpress-Cuztom-Helper/wiki/Changelog">here</a>.

###2.9.1
* Fixed: Issue #235: Error fixed where the color slider didn't show up

###2.9
* Added: Term meta locations: You can now determine where term meta can be edited (add/edit form)
* Improvement: Term meta is now saved based on taxonomy name and term id
* Changed: Bundles can now only be handled with the arrow
* Changed: uztom now just uses the base jQuery UI theme
* Fixed: Strict standards
* Fixed: Date fields were sometimes displaying in a weird way
* Fixed: Many small fixes

###2.8.4
* Fixed: Fixed bug with bundle default value

###2.8.3
* Added: Default values for bundles, so you can preset some bundles

###2.8.2
* Improvement: Javasscript preview size set to medium (and some extra checks)

###2.8.1
* Fixed: Issue #221: Data attribute
* Changed: Default image preview size

###2.8
* Added: Image preview size for image field. props @anteprimorachr
* Added: Bundle support for all fields. props @anteprimorachr
* Fixed: Small fixes & improvements

###2.7
* Improvement: Tables now get a unique class
* Improvement: Bundles are now saved hidden, starting with _
* Improvement: Responsive WYSIWYG editor within cuztom
* Fixed: #205: Image upload for user/term meta