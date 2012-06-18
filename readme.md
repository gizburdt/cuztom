## Cuztom Helper

This class can be used to quickly register Custom Post Types, Taxonomies, Meta Boxes, Menu Pages and Sidebars within your Wordpress projects.

**Version:** 0.6  
**Requires:** 3.0+ 

## Basic usage

Include the main file.
	
	include( 'cuztom_helper/cuztom_helper.php' );
   
### Custom Post Types
	
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
	
## Advanced usage
See the <a href="https://github.com/Gizburdt/Wordpress-Cuztom-Helper/wiki">wiki</a> for the full and advanced guides.
	
## Todo
Full roadmap can be found <a href="https://github.com/Gizburdt/Wordpress-Cuztom-Helper/wiki/Roadmap">here</a>.

* Widgets
* Theme Options
* More input types like slider and gallery for Meta Boxes.
* Better documentation / Wiki

## Changelog
You can see the full changelog <a href="https://github.com/Gizburdt/Wordpress-Cuztom-Helper/wiki/Changelog">here</a>.

### 0.7
* Added: Meta box tabs. See the Wiki for usage
* Improvements: Just some minor improvements

### 0.6
* Improvement: Each class has its own file, so the readability is improved
* Improvement: Textdomain added to all translations, the textdomain can be set by a define
* Fixed: Some fatal PHP errors from 0.5 (sorry about that)

### 0.5
* Added: It is now possible to easily register sidebars with Cuztom