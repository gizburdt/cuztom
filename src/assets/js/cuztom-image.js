/*!
 * Cuztom
 * Images
 * Made by Gizburdt
 */

jQuery(function($) {

    var doc = $(document);

    // Remove current attached image
    doc.on( 'click', '.js-cztm-remove-media', function() {
        var that        = $(this),
            parent      = that.closest('.cuztom-field');

        parent.find( '.cuztom-preview').html('');
        parent.find( '.cuztom-hidden').val('');

        that.hide();

        return false;
    });

    // Upload image
    doc.on( 'click', '.js-cztm-upload', function() {
        var that        = $(this),
            type        = that.data('media-type'),
            fieldID     = that.data('id'),
            parent      = that.parent(),
            hidden      = $( '.cuztom-hidden', parent ),
            preview     = $( '.cuztom-preview', parent ),
            _cuztom_uploader;

        // Set preview size
        previewSize         = 'medium';

        // Fire!
        if( _cuztom_uploader ) {
            _cuztom_uploader.open();
            return;
        }

        // Extend the wp.media object
        _cuztom_uploader = wp.media.frames.file_frame = wp.media({
            multiple:   false,
            type:       type
        });

        // Send the data to the fields
        _cuztom_uploader.on('select', function() {
            attachment = _cuztom_uploader.state().get('selection').first().toJSON();

            // (Re)set the remove button
            parent.find('.js-cztm-remove-media').remove();
            that.after('<a href="#" class="js-cztm-remove-media cuztom-remove-media"></a>');

            // Send an id or url to the field and set the preview
            if( type == 'image' )
            {
                var thumbnail = previewSize && !$.isArray(previewSize) && attachment.sizes[previewSize] ? attachment.sizes[previewSize] : ( attachment.sizes.medium ? attachment.sizes.medium : attachment.sizes.full );
                if( $.isArray( previewSize ) ) {
                    if( parseInt( previewSize[0] ) > 0 )
                        thumbnail.width = parseInt( previewSize[0] );
                    if( parseInt( previewSize[1] ) > 0 )
                        thumbnail.height = parseInt( previewSize[1] );
                }

                preview.html('<img src="' + thumbnail.url + '" height="' + thumbnail.height + '" width="' + thumbnail.width + '" />')
                hidden.val( attachment.id );
            }
            else
            {
                preview.html('<span class="cuztom-mime"><a href="' + attachment.url + '" target="_blank">' + attachment.name + '</a></span>' );
                hidden.val( attachment.url );
            }
        });

        _cuztom_uploader.open();
        return false;
    });

});