## Cuztom Helper

This class can be used to quickly register Custom Post Types, Taxonomies, Meta Boxes and Menu Pages within your Wordpress projects.

**Version:** 0.4  
**Requires:** 3.0+  
**Tested up to:** 3.3  

## Basic usage

Include the class.
	
	include( 'cuztom_helper.php' );
   
Register the Post Type.
	
	$book = new Custom_Post_Type( 'Book' );
	
### Add Custom Taxonomies
	
To add Custom Taxonomies, simply call this method.

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
* Widgets
* Theme Options
* More input types like slider and gallery for Meta Boxes.
* Better documentation / Wiki

## Changelog

### 0.4
* Added: Cuztom_Menu_Page class to easily register menu pages and submenus
* Added: Cuztom_Submenu_Page class to easily register submenus

### 0.3.3
* Added: CUZTOM_ to the defined jQuery UI style constant
* Added: Cuztom_Field class based on Cuztom_Meta_Box::output_field for future use

### 0.3.2
* Fixed: Issue #6: Date value will be loaded

### 0.3.1
* Fixed: Issue #2: It is possible to pass options to the WYSIWYG editor type. They will be merged with the defaults
* Fixed: Issue #4: jQuery UI style can be defined in functions.php before including Cuztom
* Fixed: Issue #5: Cuztom Helper Table is now full width of the meta box

### 0.3
* Added: Datepicker input type
* Added: Cuztom::register_styles, Cuztom::enqueue_styles, Cuztom::register_scripts, Cuztom::enqueue_scripts
* Added: Cuztom stylesheet
* Added: Cuztom javascripts

### 0.2.2
* Cuztom::uglify now converts all strange characters to underscores

### 0.2.1
* WYSIWYG editor is now enabled
* Todo: Cuztom::uglify needs to convert all strange characters to underscores

### 0.2
* Seperated classes for Post Type, Taxonomy and Meta Box
* Support for PHP versions below 5.3
* Multiple field types added: [ text, textarea, checkbox, yes/no, select, checkboxes, radio, image ]
* Todo: Cuztom::uglify needs to convert all strang characters to underscores
* Todo: WYSIWYG is still a normal textarea, but needs to be converted to a WYSIWYG editor

### 0.1
* First release, based on my tutorial on wp.tutsplus.com