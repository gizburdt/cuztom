jQuery(function($) {

	var cuztomUI,
		doc = $(document);

	(cuztomUI = function(object) {
		object = $(object);

		// Datepicker
		$('.js-cztm-datepicker', object).map(function() {
			return $(this).datepicker({ dateFormat: $(this).data('date-format') });
		});

		// Timepicker
		$('.js-cztm-timepicker', object).map(function() {
			return $(this).timepicker({ timeFormat: $(this).data('time-format') });
		});

		// Datetime
		$('.js-cztm-datetimepicker', object).map(function() {
			return $(this).datetimepicker({
				timeFormat: $(this).data('time-format'),
				dateFormat: $(this).data('date-format')
			});
		});

		// Colorpicker
		$('.js-cztm-colorpicker', object).wpColorPicker();

		// Tabs
		$('.js-cztm-tabs', object).tabs();

		// Slider
		$('.js-cztm-slider', object ).slider();

		// Accordion
		$('.js-cztm-accordion', object).accordion();

		// Sortable
		$('.js-cztm-sortable', object).sortable({
			handle: '.cuztom-handle-sortable a'
		});
	})(document);

});