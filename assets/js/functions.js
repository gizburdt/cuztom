jQuery.noConflict();
jQuery(function($) {
	
	$('.cuztom_datepicker').datepicker();
	
	$('.cuztom_colorpicker').miniColors();
	
	$('.cuztom_tabs').tabs();
	
	$('.cuztom_accordion').accordion();
	
	$('.cuztom_td').on( 'click', '.cuztom_remove_image', function(){
		$('.cuztom_preview').html('');
		$('.cuztom_hidden').val('');
		$(this).hide();
		
		return false;
	});
	
	$('.cuztom_td').on( 'click', '.cuztom_upload', function(){
		parent		= $(this).closest('.cuztom_td');
		
	    uploadID 	= parent.find('.cuztom_hidden');
	    spanID 		= parent.find('.cuztom_preview');		
	    formfield 	= parent.find('.cuztom_hidden').attr('name');
	    
		tb_show( '', 'media-upload.php?type=image&TB_iframe=true&post_id=0' );
		
		window.send_to_editor = function( html ) {		
			// Add image source to the hidden field
		    img = $(html).find('img');
		    uploadID.val( img.attr('src') );

			// Add the image to the preview
			html = $(html).find('img');
		    spanID.html( html );

			// Close Wordpress media popup
			tb_remove();
		}
	    
		return false;
	});
	
	$('.cuztom_repeatable_wrap').sortable();
	
	$('.cuztom_td').on( 'click', '.cuztom_add', function(){
		// Set some variables
		parent = $(this).closest('.cuztom_td');
		wrap = $('.cuztom_repeatable_wrap', parent);
		field = $('.cuztom_field:last', wrap);
		
		// Add the new field
		new_field = field.clone(true);
		new_field.find('input').val('');
		new_field.appendTo(wrap);
		
		return false;
	});
	
});