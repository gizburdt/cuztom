jQuery(function($) {

    var doc = $(document);

    // Ajax save
    doc.on( 'click', '.js-cztm-ajax-save', function(event) {
        var that            = $(this),
            fieldID         = that.data('button-for'),
            object          = that.data('object'),
            meta_type       = that.data('meta-type'),
            input           = $('.cuztom-input[id="' + fieldID + '"]'),
            value           = input.val(),
            data = {
                action:     'cuztom_save_field',
                cuztom: {
                    value:      value,
                    id:         fieldID,
                    meta_type:  meta_type,
                    object_id:  object,
                }
            };

        $.post(
            Cuztom.ajax_url,
            data,
            function(response) {
                var response        = $.parseJSON(response),
                    border_color    = input.css('border-color');

                if( response.status ) {
                    input.animate({ borderColor: '#60b334' }, 200, function(){ input.animate({ borderColor: border_color }); });
                }
            }
        );

        // Prevent click
        event.preventDefault();
    });

});