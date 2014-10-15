## Cuztom

This helper can be used to quickly register Custom Post Types, Taxonomies, Meta Boxes, Menu Pages and Sidebars within your Wordpress projects. Please comment, review, watch, fork and report bugs.

**Version:** 2.9.13  
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

	$sidebar = new Cuztom_Sidebar( array(
		'name'				=> 'Sidebar Twee',
		'id'				=> 'sidebar_twee',
		'description'		=> 'Build with an array',
	) );
	
## Advanced usage
See the <a href="https://github.com/gizburdt/wp-cuztom/wiki">wiki</a> for the full and advanced guides.

## Changelog
You can see the full changelog <a href="https://github.com/gizburdt/wp-cuztom/wiki/Changelog">here</a>.

###2.9.13
* Fixed #305: Term meta location fix
* Fixed #307: Conflicting tab ID
* Fixed #308: Yes/No, checkbox, checkboxes styling fixes

###2.9.12
* Improvement: #303: Remove wpautop from Cuztom WYSIWYG Field

###2.9.11
* Fixed: #278: Select with stored value 0 was not selected
* Fixed: #280: Radio buttons and checkboxes value in repeatable/bundle items

###2.9.10
* Fixed: Rare bug when saving a concept post (non-object error showed)

###2.9.9
* Fixed: #283: Repeatable file upload. Props @anteprimorac

###2.9.8
* Fixed: #281: Repeatable bundle with WYSIWYG

###2.9.7
* Added: It is now possible to add repeatable fields to bundles. Props @anteprimorac

###2.9.6
* Fixed: #276: Adding a sidebar shows a blank white box

###2.9.5
* Fixed: Bug in tab class with repeatable fields
* Improvement: Added the possibilty to set css classes for field, when building 

###2.9.4
* Fixed: Fixes jquery-ui url to work with http and https. props @sebmaynard

###2.9.3
* Fixed: Fixes for (repeatable) image field

###2.9.2
* Added: Repeatable image field

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
