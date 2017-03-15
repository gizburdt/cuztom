# Cuztom

Cuztom is a Wordpress library, which can be used to easily register Post Types, Taxonomies, Meta Boxes, Term Meta, User Meta. Please comment, review, watch, fork and report bugs. Requires Wordpress 4.4+. :)

## Basic usage

### Add Custom Post Types

    $book = register_cuztom_post_type('Book');

### Add Custom Taxonomies

To add Custom Taxonomies to the newly created Post Type, simply call this method.

    $book->addTaxonomy('Author');

You can also call this as a seperate function like this. The second parameter is the Post Type name.

    $taxonomy = register_cuztom_taxonomy('Author', 'book');

### Add Meta Boxes

Add Meta Boxes.

    register_cuztom_meta_box(
        'meta_box_id',
        'book',
        array(
            'title'     => 'Book Info',
            'fields'    => array(
                'id'           => '_author',
                'label'        => 'Author',
                'description'  => 'Just a little description',
                'type'         => 'text'
            )
        )
    );

## Documentation
See the [documentation](https://cuztom.readme.io/) for advanced guides, changelog.