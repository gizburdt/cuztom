## Cuztom Helper

This class can be used to quickly register Custom Post Types, Taxonomies, Meta Boxes and Menu Pages within your Wordpress projects.

**Version:** 0.4  
**Requires:** 3.0+ 

## Basic usage

Include the class.
	
	include( 'cuztom_helper/cuztom_helper.php' );
   
### Custom Post Types
	
	$book = new Custom_Post_Type( 'Book' );
	
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
	
## Todo
Full roadmap can be found <a href="https://github.com/Gizburdt/Wordpress-Cuztom-Helper/wiki/Roadmap">here</a>.

* Widgets
* Theme Options
* More input types like slider and gallery for Meta Boxes.
* Better documentation / Wiki

## Changelog
You can see the full changelog <a href="https://github.com/Gizburdt/Wordpress-Cuztom-Helper/wiki/Changelog">here</a>.

### 0.4
* Added: Cuztom_Menu_Page class to easily register menu pages and submenus
* Added: Cuztom_Submenu_Page class to easily register submenus

### 0.3.3
* Added: CUZTOM_ to the defined jQuery UI style constant
* Added: Cuztom_Field class based on Cuztom_Meta_Box::output_field for future use