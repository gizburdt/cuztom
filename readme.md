## Cuztom Helper

This helper can be used to quickly register Custom Post Types, Taxonomies, Meta Boxes, Menu Pages and Sidebars within your Wordpress projects. Please comment, review, watch, fork and report bugs.

**Version:** 2.6.6  
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

###2.6.6
* Fixed: Issue #185: Hidden fields now work just like normal text fields, but still hidden ofcourse ;)
* Fixed: Issue #186: Data is now saved when value is 0
* Fixed: Small fixes and improvements
* Added: License file

###2.6.4 / 2.6.5
* Fixed: Issue #175: Errors when saving meta

###2.6.3
* Improvement: Iris picker is now shown with the right CSS. probs @ikixxx
* Fixed: Issue #179: Meta data not being saved on pages. 

###2.6.2
* Fixed: Since 2.6.1 there were some bugs and errors, regarding the saving and displaying of meta data. They are all fixed now.
* Removed: The page classes are now removed, because they are not very helpful. They will be back when there is more logic for them to handle.

###2.6.1
* Fixed: Issue #175: PHP warnings and errors
* Improvement: Code cleanup of Cuztom_Field

### 2.6
* NOTE: If you would like to set the id, you need to set id, and not id_name anymore
* Improvement: Use better OOP for saving meta
* Added: It is now possible to add bundles within tabs

###2.5.3
* Improvement: Image select improvements
* Improvement: New colorpicker (Iris)
* Added: Term meta in Taxonomy List Table

###2.5.2
* Fixed: Issue #168: Repeatable field won't save

###2.5.1
* Fixed: Issue #167: Fields that require javascript now work in Term Meta
* Changed: Date and datetime are now being saved as unix time stamp

###2.5
* Added: Term meta!