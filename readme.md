## Cuztom Helper

This class can be used to quickly register Custom Post Types, Taxonomies, Meta Boxes, Menu Pages and Sidebars within your Wordpress projects. Please comment, review, watch, fork and report bugs.

**Version:** 0.7.4  
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

###0.7.4
* Fixed: Cuztom::pluralize doesn't attach an 's', when the string ends with an 's'

###0.7.3
* Improvement: Some styling improvements
* Added: Radio now outputs one radio button, and radios outputs multiple radio button. Just like it does with checkboxes.

### 0.7.2
* Improvement: The image meta field now uses the Wordpress Media popup selector instead of the standard browser selector. So now al the uploaded media can be found in the Media library.
* Fixed: Issue #7: Before the meta boxes are being saved, Cuztom will check if $_POST['cuztom'] is set.
* Fixed: Issue #8: Cuztom will check if the meta is an array before it checks if the value is in the array (thanks to iamfriendly)
* Fixed: Issue #9: Preview image is now set to max-width: 100%