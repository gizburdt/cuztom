jQuery.noConflict();

jQuery(function($) {
	
	// Datepicker
	$('.js-cuztom-datepicker').map(function(){
		return $(this).datepicker({ dateFormat: $(this).data('date-format') });
	});

	// Timepicker
	$('.js-cuztom-timepicker').map(function(){
		return $(this).timepicker({ timeFormat: $(this).data('time-format') });
	});

	// Datetime
	$('.js-cuztom-datetimepicker').map(function(){
		return $(this).datetimepicker({ 
			timeFormat: $(this).data('time-format'),
			dateFormat: $(this).data('date-format')
		});
	});
	
	// Colorpicker
	$('.js-cuztom-colorpicker').wpColorPicker();

	// Tabs
	$('.js-cuztom-tabs').tabs();

	// Slider
	$( ".js-slider" ).slider();

	// Accordion
	$('.js-cuztom-accordion').accordion();

	// Sortable
	$('.js-cuztom-sortable').sortable();

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
		var that		= $( this ),
			parent 		= that.closest( '.cuztom-td, .cuztom' ),
			wrap 		= $( '.js-cuztom-sortable', parent ),
			is_bundle	= wrap.data( 'cuztom-sortable-type') == 'bundle' ? true : false,
			last 		= $( '.js-cuztom-sortable-item:last', wrap ),
			handle 		= '<div class="cuztom-handle-sortable js-cuztom-handle-sortable"></div>',
			remover 	= '<div class="cuztom-remove-sortable js-cuztom-remove-sortable"></div>',
			new_item 	= last.clone( true );
		
		// Set new bundle array key
		if( is_bundle )
		{
			new_item.find('.cuztom-input').each( function() {
				$(this).attr('name', function( i, val ) { return val.replace( /\[(\d+)\]/, function( match, n ) { return "[" + ( Number(n) + 1 ) + "]"; }); })
				$(this).attr('id', function( i, val ) { return val.replace( /\_(\d+)/, function( match, n ) { return "_" + ( Number(n) + 1 ); }); })
			});
		}
		
		// Reset data
		new_item.find('.cuztom-input, textarea, select, .cuztom-hidden').val('').removeAttr('selected');
		new_item.find('.js-cuztom-remove-media').remove();
		new_item.find('.cuztom-preview').html('');

		// Add the new item
		new_item.appendTo( wrap );
		
		// Add new handler and remover if necessary
		$('.js-cuztom-sortable-item', parent).each(function( index, item ) {
			if( $('.js-cuztom-handle-sortable', item ).length == 0 ) { $(item).prepend( handle ); }
			if( $('.js-cuztom-remove-sortable', item ).length == 0 ) { $(item).append( remover ); }
		});
		
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

	// Remove current attached image
	$('.cuztom-td').on( 'click', '.js-cuztom-remove-media', function()
	{
		var that 	= $( this ),
			td 		= that.closest('.cuztom-td');

		$( '.cuztom-preview', td ).html('');
		$( '.cuztom-hidden', td ).val('');
		
		that.hide();
		
		return false;
	});

	// Upload image
	$('.cuztom-td').on( 'click', '.js-cuztom-upload', function()
	{
		var that	= $(this),
			type 	= that.data('cuztom-media-type'),
			parent	= that.closest('.cuztom-td'),
			hidden 	= $( '.cuztom-hidden', parent ),
			preview = $( '.cuztom-preview', parent ),
			_cuztom_uploader;

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
					var thumbnail = attachment.sizes.medium ? attachment.sizes.medium : attachment.sizes.full;

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
	
});