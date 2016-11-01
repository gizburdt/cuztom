
// Ajax save
doc.on( 'click', '.js-cuztom-ajax-save', function(event) {
    var that            = $(this),
        cuztom          = that.closest('.js-cuztom'),
        field           = that.closest('.js-cuztom-field'),
        field_id        = field.attr('data-id'),
        box_id          = cuztom.attr('data-box-id'),
        object_id       = cuztom.attr('data-object-id'),
        meta_type       = cuztom.data('meta-type'),
        input           = field.find('.cuztom-input'),
        value           = input.val(),
        data = {
            action:     'cuztom_save_field',
            security:   Cuztom.wp_nonce,
            cuztom: {
                value:     value,
                box:       box_id,
                field_id:  field_id,
                meta_type: meta_type,
                object_id: object_id,
            }
        };

    console.log(input);

    $.post(
        Cuztom.ajax_url,
        data,
        function(response) {
            var response        = $.parseJSON(response),
                border_color    = input.css('border-color');

            if( response.status ) {
                input.animate({ borderColor: '#60b334' }, 1200, function(){ input.animate({ borderColor: border_color }); });
            }
        }
    );

    // Prevent click
    event.preventDefault();
});
