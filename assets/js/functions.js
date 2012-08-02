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
	    
		tb_show( '', 'media-upload.php?type=image&TB_iframe=true' );
		
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
	
	$('.cuztom_add').on( 'click', function(){
		field = $(this).closest('.cuztom_repeatable_td').find('.cuztom_field:last').clone(true);		
		fieldLocation = $(this).closest('.cuztom_repeatable_td').find('.cuztom_field_wrap');
		
		
		//$('input', field).val('').attr('name', function(index, name) {
		//	return name.replace(/(\d+)/, function(fullMatch, n) {
		//		return Number(n) + 1;
		//	});
		//})
		
		field.insertAfter(fieldLocation, $(this).closest('td'));
		return false;
	});
	
});