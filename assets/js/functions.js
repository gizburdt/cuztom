jQuery.noConflict();
jQuery(function($) {
	
	$('.cuztom_datepicker').datepicker();
	
	$('.cuztom_colorpicker').miniColors();
	
	$('.cuztom_tabs').tabs();
	
	$('.cuztom_accordion').accordion();
	
	$('.cuztom_remove_image').on( 'click', function(){
		$('.cuztom_preview').html('');
		$('.cuztom_hidden').val('');
		$(this).hide();
		
		return false;
	});
	
	$('.cuztom_upload').on( 'click', function(){
		parent		= $(this).closest('.cuztom_td');
		
	    uploadID 	= parent.find('.cuztom_hidden');		
	    spanID 		= parent.find('.cuztom_preview');		
	    formfield 	= parent.find('.cuztom_hidden').attr('name');
	    
		tb_show('', 'media-upload.php?type=image&TB_iframe=true');
	    
		return false;
	});

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
	
});