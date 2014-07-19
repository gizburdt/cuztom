jQuery.noConflict();
jQuery( function( $ ) {

	var cuztomUI;
	(cuztomUI = function(object) {
		object = $(object);

		// Datepicker
		$('.js-cz-datepicker', object).map(function(){
			return $(this).datepicker({ dateFormat: $(this).data('date-format') });
		});

		// Timepicker
		$('.js-cz-timepicker', object).map(function(){
			return $(this).timepicker({ timeFormat: $(this).data('time-format') });
		});

		// Datetime
		$('.js-cz-datetimepicker', object).map(function(){
			return $(this).datetimepicker({
				timeFormat: $(this).data('time-format'),
				dateFormat: $(this).data('date-format')
			});
		});

		// Colorpicker
		$('.js-cz-colorpicker', object).wpColorPicker();

		// Tabs
		$('.js-cz-tabs', object).tabs();

		// Slider
		$('.js-cz-slider', object ).slider();

		// Accordion
		$('.js-cz-accordion', object).accordion();

		// Sortable
		$('.js-cz-sortable', object).sortable({
			handle: '.cuztom-handle-sortable a'
		});
	})(document);

	// Add sortable
	$(document).on( 'click', '.js-cz-add-sortable', function(event) {
		var that 		= $(this),
			isBundle	= that.data('sortable-type') == 'bundle',
			fieldID 	= that.data('field-id'),
			field 		= $('.cuztom-field#' + fieldID),
			sortable 	= field.find('.cuztom-sortable'),
			count 		= sortable.find('.cuztom-sortable-item').length,
			index 		= count,
			data 		= {
				action: isBundle ? 'cuztom_add_bundle_item' : 'cuztom_add_repeatable_item',
				cuztom: {
					field_id: 	fieldID,
					count: 		count,
					index: 		index
				}
			};

		// Call
		$.post(
			Cuztom.ajax_url,
			data,
			function(response) {
				var response = $.parseJSON(response);

				if( response.status ) {
					sortable.append(response.item);
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
	$(document).on( 'click', '.js-cz-remove-sortable', function()
	{
		var that 		= $(this),
			item 		= that.closest('.cuztom-sortable-item'),
			sortable 	= item.closest('.cuztom-sortable'),
			field 		= sortable.closest('.cuztom-field'),
			fieldID 	= field.data('id'),
			control		= $('.cuztom-control[data-control-for="' + fieldID + '"]');

		// Remove
		item.remove();

		// Remove remove-button
		if( sortable.find('.cuztom-sortable-item').length == 1 ) {
			sortable.find('.cuztom-sortable-item').last().find('.js-cz-remove-sortable').remove();
		}

		return false;
	});

	// Remove current attached image
	$(document).on( 'click', '.js-cz-remove-media', function()
	{
		var that 		= $(this),
			parent 		= that.closest('.cuztom-field');

		parent.find( '.cuztom-preview').html('');
		parent.find( '.cuztom-hidden').val('');

		that.hide();

		return false;
	});

	// Upload image
	$(document).on( 'click', '.js-cz-upload', function()
	{
		var that		= $(this),
			type 		= that.data('media-type'),
			fieldID 	= that.data('id'),
			parent 		= that.parent(),
			hidden 		= $( '.cuztom-hidden', parent ),
			preview 	= $( '.cuztom-preview', parent ),
			_cuztom_uploader;

		// Set preview size
		previewSize 		= 'medium';

		// Fire!
		if( _cuztom_uploader ) {
			_cuztom_uploader.open();
        	return;
    	}

    	// Extend the wp.media object
        _cuztom_uploader = wp.media.frames.file_frame = wp.media({
            multiple: 	false,
            type:  		type
        });

        // Send the data to the fields
        _cuztom_uploader.on('select', function() {
        	attachment = _cuztom_uploader.state().get('selection').first().toJSON();

        	// (Re)set the remove button
        	parent.find('.js-cz-remove-media').remove();
        	that.after('<a href="#" class="js-cz-remove-media cuztom-remove-media"></a>');

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

	// Ajax save
	$(document).on( 'click', '.js-cz-ajax-save', function(event) {
		var that 			= $(this),
			fieldID 		= that.data('button-for'),
			object 			= that.data('object'),
			meta_type 		= that.data('meta-type'),
			input 			= $('.cuztom-input[id="' + fieldID + '"]'),
			value 			= input.val(),
			data = {
				action: 	'cuztom_save_field',
				cuztom: {
					value: 		value,
					id: 		fieldID,
					meta_type: 	meta_type,
					object_id: 	object,
				}
			};

		$.post(
			Cuztom.ajax_url,
			data,
			function(response) {
				var response 		= $.parseJSON(response),
					border_color 	= input.css('border-color');

				if( response.status ) {
					input.animate({ borderColor: '#60b334' }, 200, function(){ input.animate({ borderColor: border_color }); });
				}
			}
		);

		// Prevent click
		event.preventDefault();
	});

});