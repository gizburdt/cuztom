jQuery.noConflict();
jQuery( function( $ ) {

	var cuztomEvents;
	(cuztomEvents = function(object) {
		object = $(object);

		// Datepicker
		$('.js-cuztom-datepicker', object).map(function(){
			return $(this).datepicker({ dateFormat: $(this).data('date-format') });
		});

		// Timepicker
		$('.js-cuztom-timepicker', object).map(function(){
			return $(this).timepicker({ timeFormat: $(this).data('time-format') });
		});

		// Datetime
		$('.js-cuztom-datetimepicker', object).map(function(){
			return $(this).datetimepicker({ 
				timeFormat: $(this).data('time-format'),
				dateFormat: $(this).data('date-format')
			});
		});
		
		// Colorpicker
		$('.js-cuztom-colorpicker', object).wpColorPicker();

		// Tabs
		$('.js-cuztom-tabs', object).tabs();

		// Slider
		$('.js-slider', object ).slider();

		// Accordion
		$('.js-cuztom-accordion', object).accordion();

		// Sortable
		$('.js-cuztom-sortable', object).sortable({
			handle: '.cuztom-handle-sortable a'
		});
	})(document);

	// Upload image
	$(document).on( 'click', '.js-cuztom-upload', function()
	{
		var that			= $(this),
			selector		= that.closest('.js-cuztom-field-selector'),
			fieldID 		= selector.attr('id'),
			fieldObject 	= window['Cuztom_' + fieldID],
			type 			= fieldObject.type,
			parent 			= that.parent(),
			hidden 			= $( '.cuztom-hidden', parent ),
			preview 		= $( '.cuztom-preview', parent ),
			_cuztom_uploader;

		// Set preview size
		if( fieldObject.args.preview_size )
			previewSize  	= fieldObject.args.preview_size;
		else
			previewSize 	= 'medium';

		// Fire!
		if( _cuztom_uploader ) 
		{
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
        	parent.find('.js-cuztom-remove-media').remove();
        	that.after('<a href="#" class="js-cuztom-remove-media cuztom-remove-media"></a>');

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

	// Remove current attached image
	$(document).on( 'click', '.js-cuztom-remove-media', function()
	{
		var that 		= $(this),
			selector 	= that.closest('.js-cuztom-field-selector'),
			parent 		= selector;

		parent.find( '.cuztom-preview').html('');
		parent.find( '.cuztom-hidden').val('');
		
		that.hide();
		
		return false;
	});

	// Remove sortable
	$(document).on( 'click', '.js-cuztom-remove-sortable', function()
	{
		var that 		= $(this),
			item 		= that.closest('.cuztom-sortable-item'),
			sortable 	= item.closest('.cuztom-sortable'),
			fields 		= sortable.find('.cuztom-sortable-item').length,
			field 		= sortable.closest('.field'),
			fieldID 	= field.data('id'),
			control		= $('.cuztom-control[data-control-for="' + fieldID + '"]');

		console.log(control);

		item.remove();

		return false;
	});		
	
	// Add sortable
	$(document).on( 'click', '.js-cuztom-add-sortable', function(event) {
		var that 			= $(this),
			isBundle		= that.data('sortable-type') == 'bundle',
			fieldID 		= that.data('field-id'),
			field 			= isBundle ? $('.cuztom-field#' + fieldID) : that.closest('.cuztom-field')
			sortable 		= field.find('.cuztom-sortable'),
			count 			= sortable.find('.cuztom-sortable-item').length,
			index 			= count,
			data 			= {
				action: 	isBundle ? 'cuztom_add_bundle_item' : 'cuztom_add_repeatable_item',
				cuztom: 	{
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

				if( response.status )
					sortable.append(response.item);
			}
		);

		// Re-init events
		cuztomEvents(document);

		// Prevent click
		event.preventDefault();
	});

	// Ajax save
	$(document).on( 'click', '.js-cuztom-ajax-save', function(event) {
		var that 			= $(this),
			fieldID 		= that.data('button-for'),
			object 			= that.data('object'),
			meta_type 		= that.data('meta-type'),
			input 			= $('.cuztom-input[id="' + fieldID + '"]'),
			value 			= input.val(),
			data = {
				action: 	'cuztom_field_ajax_save',
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

				if( response.status )
					input.animate({ borderColor: '#60b334' }, 200, function(){ input.animate({ borderColor: border_color }); });
			}
		);

		// Prevent click
		event.preventDefault();
	});

});