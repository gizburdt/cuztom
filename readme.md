## Cuztom

This helper can be used to quickly register Custom Post Types, Taxonomies, Meta Boxes, Menu Pages and Sidebars within your Wordpress projects. Please comment, review, watch, fork and report bugs.

**Version:** 2.9.18 <br/>
**Supports:** 3.5 - 4.3

## Basic usage

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

## Documentation
See the [documentation](https://cuztom.readme.io/) for advanced guides.
