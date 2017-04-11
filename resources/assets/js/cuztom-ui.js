
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

    // Variables
    var cuztomWysiwyg;

    // Helpers
    (cuztomWysiwyg = function() {
        if(typeof tinymce !== 'undefined') {
            $('.js-cuztom-sortable .js-cuztom-wysiwyg').each(function(){
                var editorId = $(this).attr('id');

                tinymce.execCommand('mceRemoveEditor', true, editorId);
                tinymce.execCommand('mceAddEditor', true, editorId);

                quicktags({id: editorId});
            });
        }
    })(document);

    // Datepicker
    $('.js-cuztom-datepicker', object).each(function(i, item) {
        return $(item).datetimepicker({
            scrollInput: false,
            timepicker: false,
            format: $(item).attr('data-date-format')
        });
    });

    // Timepicker
    $('.js-cuztom-timepicker', object).each(function(i, item) {
        return $(item).datetimepicker({
            scrollInput: false,
            datepicker: false,
            format: $(item).attr('data-time-format')
        });
    });

    // Datetime
    $('.js-cuztom-datetimepicker', object).each(function(i, item) {
        return $(item).datetimepicker({
            scrollInput: false,
            format: $(item).attr('data-date-format') + ' ' + $(item).attr('data-time-format'),
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
        handle: '.js-cuztom-sortable-item-handle',
        stop: function() {
            cuztomWysiwyg();
        }
    });
})(document);
