jQuery.noConflict();
jQuery( function( $ ) {

	var cuztomEvents;
	(cuztomEvents = function( object ) 
	{
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
			parent 			= selector,
			type 			= fieldObject.type,
			hidden 			= $( '.cuztom-hidden', selector ),
			preview 		= $( '.cuztom-preview', selector ),
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
			field 		= that.closest('.js-cuztom-sortable-item'),
			wrap 		= that.closest('.js-cuztom-sortable'),
			fields 		= wrap.find('.js-cuztom-sortable-item').length;
		
		if( fields > 1 ) { field.remove(); }
		if( fields == 2 ){ wrap.find('.js-cuztom-sortable-item').find('.js-cuztom-remove-sortable').remove(); }

		return false;
	});		
	
	// Add sortable
	$(document).on( 'click', '.js-cuztom-add-sortable', function() 
	{
		var that			= $(this),
			selector		= that.closest('.js-cuztom-field-selector'),
			fieldID 		= selector.attr('id'),
			fieldObject 	= window['Cuztom_' + fieldID],
			wrap 			= $( '.js-cuztom-sortable', selector ),
			isBundle		= fieldObject.type == 'bundle',
			handle 			= '<div class="cuztom-handle-sortable js-cuztom-handle-sortable"></div>',
			remover 		= '<div class="cuztom-remove-sortable js-cuztom-remove-sortable"></div>',
			lastItem 		= $( '.js-cuztom-sortable-item:last', wrap ),
			newItem 		= lastItem.clone( false, false ),
			countItems 		= $( '.js-cuztom-sortable-item', wrap ).length,
			switchEditors 	= [];

		// Check limit
		if( countItems >= fieldObject.limit )
		{
			alert( Cuztom.translations.limit_reached );
			return false;
		}

		// Dealing with bundles
		if( isBundle )
		{
			newItem.find('.cuztom-tr').each(function() {

				var row				= $(this),
					selector 		= row.find('.js-cuztom-field-selector'),
					cuztomInput 	= $('.cuztom-input', selector),
					fieldID 		= selector.attr('id'),
					fieldObject 	= window['Cuztom_' + fieldID];

				// Checkboxes and radios to default value
				if( fieldObject.type == 'checkbox' || fieldObject.type == 'radio' ) 
				{
					cuztomInput.each(function() {
						$(this).removeAttr('checked').prop('checked', false);

						var default_value = $(this).closest('.cuztom-checkboxes-wrap').data('default-value');
						if( default_value != undefined && (default_value + '').length && default_value == $(this).val() )
							$(this).attr('checked', 'checked').prop('checked', true);
					});
				}

				// Wysiwyg
				if( fieldObject.type == 'wysiwyg' ) 
				{
					var last_id = cuztomInput.attr('id'), last_name = cuztomInput.attr('name');
					$(this).find('span.mceEditor').remove();
					cuztomInput.show();
				}

				// New name and id attributes
				cuztomInput.attr('name', function( i, val ) { return val.replace( /\[(\d+)\]/, function( match, n ) { return '[' + ( Number(n) + 1 ) + ']'; });}).attr('id', function( i, val ) { return val.replace( /\_(\d+)/, function( match, n ) { return '_' + ( Number(n) + 1 ); })}).removeClass('hasDatepicker');

				// Set label for new id
				$(this).find('label').attr('for', cuztomInput.attr('id'));

				// Color
				if( fieldObject.type == 'color' ) 
				{
					cuztomInput.attr('value', '');
					$(this).find('.cuztom-td').html(cuztomInput.clone( false ));
				}

				// Select
				if( cuztomInput.hasClass('cuztom-select') ) 
				{
					cuztomInput.each(function() {
						var default_value = $(this).data('default-value');
						$(this).find('option').removeAttr('selected').prop('selected', false);
						if( default_value != undefined && (default_value + '').length ) {
							$(this).find('option').each(function() {
								if( $(this).val() == default_value )
									$(this).attr('selected', 'selected').prop('selected', true);
							});
						}
					});
				}

				// Add new wysiwyg
				if( fieldObject.type == 'wysiwyg' ) 
				{
					var new_id = cuztomInput.attr('id'), new_name = cuztomInput.attr('name'), last_id_regexp = new RegExp(last_id, 'g'), last_name_regexp = new RegExp(last_name, 'g');
					$(this).html( $(this).html().replace( last_name_regexp, new_name ).replace( last_id_regexp, new_id ) );

					// Clone tinyMCEPreInit.mceInit object
					tinyMCEPreInit.mceInit[new_id] = tinyMCEPreInit.mceInit[last_id];
					tinyMCEPreInit.mceInit[new_id].body_class = tinyMCEPreInit.mceInit[new_id].body_class.replace( last_id_regexp, new_id );
					tinyMCEPreInit.mceInit[new_id].elements = tinyMCEPreInit.mceInit[new_id].elements.replace( last_id_regexp, new_id );

					// Clone QTags instance
					QTags.instances[new_id] = QTags.instances[last_id];
					QTags.instances[new_id].canvas = cuztomInput[0];
					QTags.instances[new_id].id = new_id;
					QTags.instances[new_id].settings.id = new_id;
					QTags.instances[new_id].name = 'qt_' + new_id;
					QTags.instances[new_id].toolbar = $(this).find('.quicktags-toolbar')[0];

					var mode = 'html';
					if( $(this).find('.wp-editor-wrap').hasClass('tmce-active') )
						mode = 'tmce';
					switchEditors.push({'id': new_id, 'mode': mode});
				}
			});
		}
		
		// Dealing with repeatable
		else
		{

		}
		
		// Reset data
		newItem.find('.cuztom-input, select, textarea').val('').removeAttr('selected');
		newItem.find('.js-cuztom-remove-media').remove();
		newItem.find('.cuztom-preview').html('');

		// Add the new item
		newItem.appendTo( wrap );

		// Add events to the new item
		cuztomEvents(newItem);
		
		// Add new handler and remover if necessary
		$('.js-cuztom-sortable-item', parent).each(function( index, item ) {
			if( $('.js-cuztom-handle-sortable', item ).length == 0 ) { $(item).prepend( handle ); }
			if( $('.js-cuztom-remove-sortable', item ).length == 0 ) { $(item).append( remover ); }
		});

		// Switch editors
		for( var i = 0; i < switchEditors.length; i++ )
			switchEditors.go( switchEditors[i]['id'], switchEditors[i]['mode'] );
		
		return false;
	});

	// Ajax save
	$('.cuztom-td').on( 'click', '.js-cuztom-ajax-save', function()
	{
		var that		= $(this),
			parent		= that.closest('.cuztom-td'),
			cuztom 		= parent.closest('.cuztom'),
			input 		= $('.cuztom-input', parent),
			field_id 	= input.attr('id'),
			value		= input.val(),

			// Needs better handling
			meta_type 	= cuztom.data('meta-type'),
			object_id	= cuztom.data('object-id');

		var data = {
			action: 	'cuztom_field_ajax_save',
			cuztom: 	{
				value: 		value,
				field_id: 	field_id,

				// Needs better handling
				meta_type:  meta_type,
				object_id: 	object_id
			}
		};

		$.post( Cuztom.ajax_url, data, function(r) {
			var border_color = input.css('border-color');
			input.animate({ borderColor: '#60b334' }, 200, function(){ input.animate({ borderColor: border_color }); });
		});

		return false;
	});

});