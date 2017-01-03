
/**
 * Variable function, so it can be called from other places
 */
var cuztomUI;

/**
 * Function with all UI functions
 * @param  element object Document
 */
(cuztomUI = function(object) {
    var object = $(object);

    // Datepicker
    $('.js-cuztom-datepicker', object).map(function() {
        return $(this).datetimepicker({
            scrollInput: false,
            timepicker: false,
            format: $(this).data('date-format')
        });
    });

    // Timepicker
    $('.js-cuztom-timepicker', object).map(function() {
        return $(this).datetimepicker({
            scrollInput: false,
            datepicker: false,
            format: $(this).attr('data-time-format')
        });
    });

    // Datetime
    $('.js-cuztom-datetimepicker', object).map(function() {
        return $(this).datetimepicker({
            scrollInput: false,
            format: $(this).data('date-format') + ' ' + $(this).data('time-format'),
        });
    });

    // Colorpicker
    $('.js-cuztom-colorpicker', object).wpColorPicker();

    // Tabs
    $('.js-cuztom-tabs', object).tabs();

    // Slider
    $('.js-cuztom-slider', object ).slider();

    // Accordion
    $('.js-cuztom-accordion', object).accordion({
        heightStyle: "content"
    });

    // Sortable
    $('.js-cuztom-sortable', object).sortable({
        items: '> li',
        handle: '.js-cuztom-sortable-item-handle'
    });
})(document);
