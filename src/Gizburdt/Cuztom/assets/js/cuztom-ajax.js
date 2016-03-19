
// Ajax save
doc.on( 'click', '.js-cztm-ajax-save', function(event) {
    var that            = $(this),
        cuztom          = that.closest('.js-cztm'),
        field           = that.closest('.js-cztm-field'),
        field_id        = field.attr('data-id'),
        box_id          = cuztom.attr('data-box-id'),
        object_id       = cuztom.attr('data-object-id'),
        meta_type       = cuztom.data('meta-type'),
        input           = field.find('.cuztom-input'),
        value           = input.val(),
        data = {
            action:     'cuztom_save_field',
            cuztom: {
                value:      value,
                box_id:     box_id,
                field_id:   field_id,
                meta_type:  meta_type,
                object_id:  object_id,
            }
        };

    $.post(
        Cuztom.ajax_url,
        data,
        function(response) {
            var response        = $.parseJSON(response),
                border_color    = input.css('border-color');

            if( response.status ) {
                input.animate({ borderColor: '#60b334' }, 400, function(){ input.animate({ borderColor: border_color }); });
            }
        }
    );

    // Prevent click
    event.preventDefault();
});
