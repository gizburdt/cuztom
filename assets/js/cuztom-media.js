
// Remove current attached media
doc.on('click', '.js-cuztom-remove-media', function(event) {
    var that  = $(this).hide(),
        field = that.closest('.js-cuztom-field');

    // Clear previews / data
    field.find('.cuztom-preview').html('');
    field.find('.cuztom-input-hidden').val('');

    // Prevent click
    event.preventDefault();
});

// Upload media
doc.on('click', '.js-cuztom-upload', function(event) {
    var that        = $(this),
        type        = that.attr('data-media-type') || 'image',
        field       = that.closest('.js-cuztom-field'),
        hidden      = field.find('.cuztom-input-hidden'),
        preview     = field.find('.cuztom-preview'),
        previewSize = 'medium',
        _cuztom_uploader;

    // Fire!
    if ( undefined !== _cuztom_uploader ) {
        _cuztom_uploader.open();
        return;
    }

    // Extend the wp.media object
    _cuztom_uploader = wp.media.frames.file_frame = wp.media({
        multiple: false,
        type:     type
    });

    // Send the data to the fields
    _cuztom_uploader.on('select', function() {
        attachment = _cuztom_uploader.state().get('selection').first().toJSON();

        // (Re)set the remove button
        field.find('.js-cuztom-remove-media').remove();

        // Send an id to the field and set the preview
        if( type == 'image' ) {
            var thumbnail = previewSize && !$.isArray(previewSize) && attachment.sizes[previewSize]
                ? attachment.sizes[previewSize]
                : (attachment.sizes.medium ? attachment.sizes.medium : attachment.sizes.full);

            if( $.isArray(previewSize)) {
                if( parseInt( previewSize[0] ) > 0 ) {
                    thumbnail.width = parseInt( previewSize[0] );
                }

                if( parseInt( previewSize[1] ) > 0 ) {
                    thumbnail.height = parseInt( previewSize[1] );
                }
            }

            that.after('<a href="#" class="button button-small cuztom-remove-media js-cuztom-remove-media" tabindex="-1" title="Remove current image">x</a>');
            preview.html('<img src="' + thumbnail.url + '" height="' + thumbnail.height + '" width="' + thumbnail.width + '" />')
        } else {
            that.after('<a href="#" class="button button-small cuztom-remove-media js-cuztom-remove-media" tabindex="-1" title="Remove current file">x</a>');
            preview.html('<span class="cuztom-mime mime-application-pdf"><a href="' + attachment.url + '">' + attachment.title + '</a></span>')
        }

        hidden.val( attachment.id );
    });

    _cuztom_uploader.open();

    // Prevent click
    event.preventDefault();
});
