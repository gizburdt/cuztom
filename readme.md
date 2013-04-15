## Cuztom Helper

This helper can be used to quickly register Custom Post Types, Taxonomies, Meta Boxes, Menu Pages and Sidebars within your Wordpress projects. Please comment, review, watch, fork and report bugs.

**Version:** 2.3.1  
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

###2.3.1
* Fixed: Issue #136: Cuztom::uglify() is removed from select, radio, checkbox slug. So you can control the slug, like BottomLeft.

###2.3
* Enhancement: Cuztom pluralize can now handle more types of plural words
* Enhancement: Security improvements
* Enhancement: Cleaner code, better asset naming
* Added: Cuztom now uses a Singleton to handle the initialization
* Added: Cuztom_Notice to handle admin notices better

###2.2.1
* Fixed: Issue #130: Image select button loses ats value in bundle
* Added: Select in bundle

###2.2
* Fixed: Issue #126: Image field error when editor is not supported by post type
* Fixed: Issue #125: Conflict with names in repeatable fields
* Added: Image support in bundles

###2.1.3
* Fixed: Issue #118: Upload with small images

###2.1.2
* Fixed: Fixed a bug where only 5 posts were shown in Cuztom post fields
* Fixed: call_to_user_func error

###2.1.1
* Fixed: Issue #47: Wrong content in the wrong admin column

###2.1
* Added: New field: multi select
* Enhancement: Table and fields are now looking better when the metabox is in the sidebar
* Enhancement: The version check within the javascript wasn't working well
* Enhancement: HTML tags outside of the translated string
* Changed (NOTE): Meta boxes now have a $id and a $title. Id is the unique string, the title can be translated

###2.0.2
* Enhancement: new jQuery UI theme version
* Fixed: Issue #105: Strings inside meta are now translated after using it in logic

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
