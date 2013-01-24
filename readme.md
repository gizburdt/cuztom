## Cuztom Helper

This class can be used to quickly register Custom Post Types, Taxonomies, Meta Boxes, Menu Pages and Sidebars within your Wordpress projects. Please comment, review, watch, fork and report bugs.

**Version:** 2.0.1  
**Requires:** 3.0+  

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
	
Or with an array.

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

###2.0.1
* Fixed: Issue #100: Little bug with the WYSIWYG editor where data is not saved to the database

###2.0
* Added: Explanation. This is a second description shown below the field (not all fields are supported yet)
* Added: Possibility to add a 'None' option to Cuztom_Select and Cuztom_Post_Select
* Added: AJAX support for all fields (except radios and checkboxes)
* Added: New fields, datepicker and datetimepicker
* Enhancement: Better CSS and JS (selectors)
* Enhancement: Better field outputting
* Enhancement: Better handling of images and files
* Enhancement: Many minor enchancements
* Changed: show_column is renamed to show_admin_column, for Taxonomies and Fields
* Changed: $options is changed to $args (field options). Options is now used for select, radios and checkboxes
* Fixed: Many minor bugs
* Removed: Field functions (/functions/field.php)
* Removed: Cuztom_Field_Radio

###1.6.8
* Enhancement: We're now using 'cuztom' (as string) as textdomain instead of CUZTOM_TEXTDOMAIN
* Enhancement: No PHP variables in translation functions

###1.6.7
* Deprecated: Cuztom_Radio_Field is from now on deprecated, because it is not usable
* Enhancement: The reserved term notice in Cuztom_Taxonomy is better handled with admin_notices

###1.6.6
* Fixed: Issue #76: Adding existing taxonomies to post types resulted in reserved tag error

###1.6.5
* Enhancement: Better use of OOP, especially in the fields and tabs section.

###1.6.4
* Enhancement: Box description. If you want a descrption for a box, just pass an array to the $title parameter. The first element is the title, the second is the description.

###1.6.3
* Fixed: Bugs in javascript
* Enhancement: The checked check for checkboxes is improved

###1.6.2
* Enhancement: The savinf process is now better OOP based
* Enhancement: Better check for which checkboxes need to be checked
* Enhancement: Sprintf in Taxonomy labels
* Enhancement: Error message of reserved term usage only visible in Admin area

###1.6.1
* Enhancement: If a Cuztom Image Field is shown as a Post Table column, then the image is shown instead of the attachment_id

###1.6
* Added: Taxonomy as Post Table Column and as filter above the Post Table. Just set show_column = true in the Cuztom_Taxonomy args and it's all done. ( Issue #47 )
