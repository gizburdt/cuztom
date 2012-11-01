jQuery.noConflict();
jQuery(function($) {
	
	// Datepicker
	$('.cuztom_datepicker').each(function(){
		$(this).datepicker({ dateFormat: $(this).data('date-format') });
	});
	
	
	// Colorpicker
	$('.cuztom_colorpicker').miniColors();
	

	// Tabs
	$('.cuztom_tabs').tabs();
	

	// Accordion
	$('.cuztom_accordion').accordion();
	

	// Remove current attached image
	$('.cuztom_td').on( 'click', '.cuztom_remove_image, .cuztom_remove_file', function()
	{
		$(this).closest('.cuztom_td').find('.cuztom_preview').html('');
		$(this).closest('.cuztom_td').find('.cuztom_hidden').val('');
		$(this).hide();
		
		return false;
	});
	

	// Upload image
	$('.cuztom_td').on( 'click', '.cuztom_upload', function() 
	{
		that		= $(this);
		type 		= $(this).hasClass('cuztom_file') ? 'file' : 'image';

		parent		= $(this).closest('.cuztom_td');
		
	    uploadID 	= parent.find('.cuztom_hidden');
	    spanID 		= parent.find('.cuztom_preview');		
	    formfield 	= parent.find('.cuztom_hidden').attr('name');
	    
		tb_show( '', 'media-upload.php?post_id=0&type=image&TB_iframe=true' );
		
		window.send_to_editor = function( html ) {

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

				anchor	= $(html).text();
				html	= $('<span class="cuztom_mime"><a href="' + url + '" target="_blank">' + anchor + '</a></span>' );
				spanID.html( html );
			}
			
			// Close Wordpress media popup
			tb_remove();

			// Add remove button
			that.after('<a href="#" class="cuztom_remove_image">' + ( type == 'image' ? Cuztom.remove_image : Cuztom.remove_file ) + '</a> ')
		}
	    
		return false;
	});
	

	// Repeatable
	$('.cuztom_repeatable_wrap, .cuztom_bundle_wrap').sortable();
	

	$('.cuztom_helper').on( 'click', '.remove_repeatable, .remove_bundle', function() 
	{
		var that = $(this),
			field = that.closest('.cuztom_field, .cuztom_bundle'),
			wrap = that.closest('.cuztom_repeatable_wrap, .cuztom_bundle_wrap'),
			fields = wrap.find('.cuztom_field, .cuztom_bundle').length;
		
		if( fields > 1 ) { field.remove(); }
		if( fields == 2 ){ wrap.find('.cuztom_field, .cuztom_bundle').find('.remove_repeatable, .remove_bundle').remove(); }
	});
	

	$('.cuztom_td').on( 'click', '.cuztom_add_field', function() 
	{
		// Set some variables
		var parent = $(this).closest('.cuztom_td'),
			wrap = $('.cuztom_repeatable_wrap', parent),
			field = $('.cuztom_field:last', wrap),
			first = $('.cuztom_field:first', parent),
			handle = '<div class="handle_repeatable"></div>',
			remover = '<div class="remove_repeatable"></div>',
			new_field = field.clone(true);
		
		// Add the new field
		new_field.find('input, textarea, select').val('').removeAttr('selected');
		new_field.appendTo(wrap);
		
		$('.cuztom_field', parent).each(function( index, item ) {
			if( $('.handle_repeatable', item ).length == 0 ) { $(item).prepend( handle ); }
			if( $('.remove_repeatable', item ).length == 0 ) { $(item).append( remover ); }
		});
		
		return false;
	});
	

	$('.cuztom_helper').on( 'click', '.cuztom_add_bundle', function() 
	{
		// Set some variables
		var parent = $(this).closest('.cuztom_helper'),
			wrap = $('.cuztom_bundle_wrap', parent),
			bundle = $('.cuztom_bundle:last', wrap),
			handle = '<div class="handle_bundle"></div>',
			remover = '<div class="remove_bundle"></div>',
			new_bundle = bundle.clone(true);
		
		// Add the new bundle
		new_bundle.find('.cuztom_input').each(function(){
			$(this).attr('name', function( i, val ){ return val.replace( /(\d+)/, function( n ){ return Number(n) + 1 } ) } );
		});
		
		// Add the new bundle
		new_bundle.find('input, textarea, select').val('').removeAttr('selected');
		new_bundle.appendTo(wrap);
		
		$('.cuztom_bundle', parent).each(function( index, item ) {
			if( $('.handle_bundle', item ).length == 0 ) { $(item).prepend( handle ); }
			if( $('.remove_bundle', item ).length == 0 ) { $(item).append( remover ); }
		});
		
		return false;
	});
	
});