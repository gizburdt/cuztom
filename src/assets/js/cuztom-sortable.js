/*!
 * Cuztom
 * Sortable
 * Made by Gizburdt
 */

// Add sortable
doc.on( 'click', '.js-cztm-add-sortable', function(event) {
    var that            = $(this),
        boxID           = $('.js-cztm').attr('data-box-id'),
        isBundle        = that.attr('data-sortable-type') == 'bundle',
        fieldID         = that.attr('data-field-id'),
        field           = $('.cuztom-field#' + fieldID),
        counter         = field.find('.js-cztm-counter'),
        counterCurrent  = counter.find('.js-current'),
        counterMax      = counter.find('.js-max'),
        sortable        = field.find('.cuztom-sortable'),
        count           = sortable.find('.cuztom-sortable-item').length,
        index           = count,
        data            = {
            action: isBundle ? 'cuztom_add_bundle_item' : 'cuztom_add_repeatable_item',
            cuztom: {
                box_id:     boxID,
                field_id:   fieldID,
                count:      count,
                index:      index
            }
        };

    // Call
    $.post(
        Cztm.ajax_url,
        data,
        function(response) {
            var response = $.parseJSON(response);

            if( response.status ) {
                sortable.append(response.item);
                counterCurrent.text(count + 1);
            } else {
                alert( response.message );
            }

            // Re-init ui
            cuztomUI(document);
        }
    );

    // Prevent click
    event.preventDefault();
});

// Remove sortable
doc.on( 'click', '.js-cztm-remove-sortable', function() {
    var that            = $(this),
        item            = that.closest('.cuztom-sortable-item'),
        sortable        = item.closest('.cuztom-sortable'),
        field           = sortable.closest('.cuztom-field'),
        fieldID         = field.attr('data-field-id'),
        control         = $('.cuztom-control[data-control-for="' + fieldID + '"]'),
        count           = sortable.find('.cuztom-sortable-item').length,
        counter         = field.find('.js-cztm-counter'),
        counterCurrent  = counter.find('.js-current'),
        counterMax      = counter.find('.js-max');

    // Remove
    item.remove();
    counterCurrent.text(count - 1);

    // Remove remove-button
    if( sortable.find('.cuztom-sortable-item').length == 1 ) {
        sortable.find('.cuztom-sortable-item').last().find('.js-cztm-remove-sortable').remove();
    }

    return false;
});