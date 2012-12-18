jQuery.noConflict();

jQuery(function($) 
{	
	// Datepicker
	$('.js-cuztom-datepicker').each(function(){
		$(this).datepicker({ dateFormat: $(this).data('date-format') });
	});
	
	// Colorpicker
	$('.js-cuztom-colorpicker').miniColors();

	// Tabs
	$('.js-cuztom-tabs').tabs();

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
	
	// Add sortabe
	$('.cuztom').on( 'click', '.js-cuztom-add-sortable', function() 
	{
		var that		= $(this),
			parent 		= $(this).closest('.cuztom-td, .cuztom'),
			wrap 		= $('.cuztom-sortable', parent),
			last 		= $('.cuztom-sortable-item:last', wrap),
			handle 		= '<div class="cuztom-handle-sortable"></div>',
			remover 	= '<div class="js-cuztom-remove-sortable remove_bundle"></div>',
			new_item 	= last.clone(true);

		console.log(last);
		
		// Add the new bundle
		if( wrap.hasClass('js-cuztom-sortable-bundle') )
		{
			new_item.find('.cuztom-input').each(function(){
				$(this).attr('name', function( i, val ){ return val.replace( /(\d+)/, function( n ){ return Number(n) + 1 } ) } );
			});
		}
		
		// Add the item
		new_item.find('input, textarea, select').val('').removeAttr('selected');
		new_item.appendTo(wrap);
		
		$('.js-cuztom-sortable-item', parent).each(function( index, item ) {
			if( $('.js-cuztom-handle-sortable', item ).length == 0 ) { $(item).prepend( handle ); }
			if( $('.js-cuztom-remove-sortable', item ).length == 0 ) { $(item).append( remover ); }
		});
		
		return false;
	});

	// Upload image
	$('.cuztom-td').on( 'click', '.js-cuztom-upload', function() 
	{
		that		= $(this);
		type 		= $(this).hasClass('cuztom_file') ? 'file' : 'image';

		parent		= $(this).closest('.cuztom-td');
		
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
	
});