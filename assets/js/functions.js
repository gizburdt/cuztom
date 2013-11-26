jQuery.noConflict();

jQuery( function( $ ) {

	var add_events;

	(add_events = function( object ) 
	{
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
		$( '.js-slider', object ).slider();

		// Accordion
		$('.js-cuztom-accordion', object).accordion();

		// Sortable
		$('.js-cuztom-sortable', object).sortable({
			handle: '.cuztom-handle-sortable'
		});

		// Remove current attached image
		$('.cuztom-td, .form-field', object).on( 'click', '.js-cuztom-remove-media', function()
		{
			var that 	= $( this ),
				td 		= that.closest('.cuztom-field, .cuztom-td, .form-field');

			$( '.cuztom-preview', td ).html('');
			$( '.cuztom-hidden', td ).val('');
			
			that.hide();
			
			return false;
		});

		// Upload image
		$('.cuztom-td, .form-field', object).on( 'click', '.js-cuztom-upload', function()
		{
			var that	= $(this),
				type 	= that.data('cuztom-media-type'),
				parent	= that.closest('.cuztom-field, .cuztom-td, .form-field'),
				hidden 	= $( '.cuztom-hidden', parent ),
				preview = $( '.cuztom-preview', parent ),
				_cuztom_uploader;

			try {
				preview_size  = $.parseJSON( that.data('cuztom-media-preview-size') );
			} catch(e) {
				preview_size  = that.data('cuztom-media-preview-size');
			}

			if( Cuztom.wp_version >= '3.5' )
			{
				if( _cuztom_uploader ) 
				{
					_cuztom_uploader.open();
	            	return;
	        	}

	        	//Extend the wp.media object
		        _cuztom_uploader = wp.media.frames.file_frame = wp.media({
		            multiple: false,
		        });

		        // Send the data to the fields
		        _cuztom_uploader.on('select', function() {
	            	attachment = _cuztom_uploader.state().get('selection').first().toJSON();

	            	// (Re)set the remove button
	            	$('.js-cuztom-remove-media', parent).remove();
	            	that.after('<a href="#" class="js-cuztom-remove-media cuztom-remove-media">' + ( type == 'image' ? Cuztom.remove_image : Cuztom.remove_file ) + '</a> ');

	            	// Send an id or url to the field and set the preview
	            	if( type == 'image' )
					{
						console.log( attachment );
						var thumbnail = preview_size && !$.isArray(preview_size) && attachment.sizes[preview_size] ? attachment.sizes[preview_size] : ( attachment.sizes.medium ? attachment.sizes.medium : attachment.sizes.full );
						if( $.isArray( preview_size ) ) {
							if( parseInt( preview_size[0] ) > 0 )
								thumbnail.width = parseInt( preview_size[0] );
							if( parseInt( preview_size[1] ) > 0 )
								thumbnail.height = parseInt( preview_size[1] );
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
			}
			else
			{
				var uploadID 	= hidden,
			    	spanID 		= preview;

			    var	_original_send_to_editor = window.send_to_editor;
			    
				tb_show( '', 'media-upload.php?post_id=0&type=image&TB_iframe=true' );
				
				window.send_to_editor = function( html ) 
				{
					if( type == 'image' )
					{
						// Add image source to the hidden field
					    img 	= $(html).find('img');
					    imgID 	= html.match(/wp-image-(\d+)/g)[0].split('-')[2];

					    uploadID.val( imgID );

						// Add the image to the preview
						html 	= $(html).find('img');
					    spanID.html( html );
					}
					else
					{
						url		= $(html).attr('href');
						uploadID.val( url );

						anchor	= $(html).find('img').attr('title');
						html	= $('<span class="cuztom-mime"><a href="' + url + '" target="_blank">' + anchor + '</a></span>' );
						spanID.html( html );
					}
					
					// Close Wordpress media popup
					tb_remove();

					$('.js-cuztom-remove-media', parent).remove();
					that.after('<a href="#" class="js-cuztom-remove-media cuztom-remove-media">' + ( type == 'image' ? Cuztom.remove_image : Cuztom.remove_file ) + '</a> ');

					// Reset default function
					window.send_to_editor = _original_send_to_editor;
				}
			}

			return false;
		});
	})( $('body') );

	// Remove sortable
	$('.cuztom').on( 'click', '.js-cuztom-remove-sortable', function() 
	{
		var that 		= $( this ),
			field 		= that.closest('.js-cuztom-sortable-item'),
			wrap 		= that.closest('.js-cuztom-sortable'),
			fields 		= $( '.js-cuztom-sortable-item', wrap ).length;
		
		if( fields > 1 ) { field.remove(); }
		if( fields == 2 ){ $( '.js-cuztom-sortable-item', wrap ).find('.js-cuztom-remove-sortable').remove(); }
	});		
	
	// Add sortable
	$('.cuztom').on( 'click', '.js-cuztom-add-sortable', function() 
	{
		var that			= $( this ),
			parent 			= that.closest( '.cuztom-td, .cuztom' ),
			wrap 			= $( '.js-cuztom-sortable', parent ),
			is_bundle		= wrap.data( 'cuztom-sortable-type') == 'bundle' ? true : false,
			last 			= $( '.js-cuztom-sortable-item:last', wrap ),
			handle 			= '<div class="cuztom-handle-sortable js-cuztom-handle-sortable"></div>',
			remover 		= '<div class="cuztom-remove-sortable js-cuztom-remove-sortable"></div>',
			new_item 		= last.clone( false, false ),
			switch_editors 	= [];
		
		// Set new bundle array key
		if( is_bundle )
		{
			new_item.find('tr').each(function() {

				var cuztom_input = $(this).find('.cuztom-input');

				// Checkboxes and radios to default value
				if( cuztom_input.attr('type') == 'checkbox' || cuztom_input.attr('type') == 'radio' ) {
					cuztom_input.each(function() {
						$(this).removeAttr('checked').prop('checked', false);

						var default_value = $(this).closest('.cuztom-checkboxes-wrap').data('default-value');
						if( default_value != undefined && (default_value + '').length && default_value == $(this).val() )
							$(this).attr('checked', 'checked').prop('checked', true);
					});
				}

				// Wysiwyg
				if( cuztom_input.hasClass('wp-editor-area') ) {
					var last_id = cuztom_input.attr('id'), last_name = cuztom_input.attr('name');
					$(this).find('span.mceEditor').remove();
					cuztom_input.show();
				}

				// New name and id attributes
				cuztom_input.attr('name', function( i, val ) { return val.replace( /\[(\d+)\]/, function( match, n ) { return '[' + ( Number(n) + 1 ) + ']'; });}).attr('id', function( i, val ) { return val.replace( /\_(\d+)/, function( match, n ) { return '_' + ( Number(n) + 1 ); })}).removeClass('hasDatepicker');

				// Set label for new id
				$(this).find('label').attr('for', cuztom_input.attr('id'));

				// Color
				if( cuztom_input.hasClass('cuztom-colorpicker') ) {
					cuztom_input.attr('value', '');
					$(this).find('.cuztom-td').html(cuztom_input.clone( false ));
				}

				// Select
				if( cuztom_input.hasClass('cuztom-select') ) {
					cuztom_input.each(function() {
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
				if( cuztom_input.hasClass('wp-editor-area' )) {
					var new_id = cuztom_input.attr('id'), new_name = cuztom_input.attr('name'), last_id_regexp = new RegExp(last_id, 'g'), last_name_regexp = new RegExp(last_name, 'g');
					$(this).html( $(this).html().replace( last_name_regexp, new_name ).replace( last_id_regexp, new_id ) );

					// Clone tinyMCEPreInit.mceInit object
					tinyMCEPreInit.mceInit[new_id] = tinyMCEPreInit.mceInit[last_id];
					tinyMCEPreInit.mceInit[new_id].body_class = tinyMCEPreInit.mceInit[new_id].body_class.replace( last_id_regexp, new_id );
					tinyMCEPreInit.mceInit[new_id].elements = tinyMCEPreInit.mceInit[new_id].elements.replace( last_id_regexp, new_id );

					// Clone QTags instance
					QTags.instances[new_id] = QTags.instances[last_id];
					QTags.instances[new_id].canvas = cuztom_input[0];
					QTags.instances[new_id].id = new_id;
					QTags.instances[new_id].settings.id = new_id;
					QTags.instances[new_id].name = 'qt_' + new_id;
					QTags.instances[new_id].toolbar = $(this).find('.quicktags-toolbar')[0];

					var mode = 'html';
					if( $(this).find('.wp-editor-wrap').hasClass('tmce-active') )
						mode = 'tmce';
					switch_editors.push({'id': new_id, 'mode': mode});
				}
			});
		}
		
		// Reset data
		new_item.find('.cuztom-input, select, textarea').val('').removeAttr('selected');
		new_item.find('.js-cuztom-remove-media').remove();
		new_item.find('.cuztom-preview').html('');

		// Add the new item
		new_item.appendTo( wrap );

		// Add events to the new item
		add_events(new_item);
		
		// Add new handler and remover if necessary
		$('.js-cuztom-sortable-item', parent).each(function( index, item ) {
			if( $('.js-cuztom-handle-sortable', item ).length == 0 ) { $(item).prepend( handle ); }
			if( $('.js-cuztom-remove-sortable', item ).length == 0 ) { $(item).append( remover ); }
		});

		// Switch editors
		for( var i = 0; i < switch_editors.length; i++ )
			switchEditors.go( switch_editors[i]['id'], switch_editors[i]['mode'] );
		
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