jQuery.noConflict();
jQuery( function( $ ) {

	var cuztomGalleries = {};

	function get_Selection( element ) {
		var images_name = $( element ).data( 'name' ) + '[images][]';

		var text = '[gallery';
		var images = $( 'input[name="' + images_name + '"]', element );
		if( ! images.length ) {
			return null;
		}
		else {
			text += ' ids="';
			var first = true;
			images.each( function() {
				if( first == true )
					first = false;
				else
					text += ',';

				text += $( this ).val();
			} );
			text += '"';
		}

		text += ']';

		var shortcode = wp.shortcode.next( 'gallery', text );

		if ( ! shortcode )
			return;

		shortcode = shortcode.shortcode;

		if ( _.isUndefined( shortcode.get('id') ) && ! _.isUndefined( wp.media.gallery.defaults.id ) )
			shortcode.set( 'id', wp.media.gallery.defaults.id );

		var attachments = wp.media.gallery.attachments( shortcode );
		var selection = new wp.media.model.Selection( attachments.models, {
			props: attachments.props.toJSON(),
			multiple: true
		});

		selection.gallery = attachments.gallery;

		selection.more().done( function() {
			selection.props.set({ query: false });
			selection.unmirror();
			selection.props.unset('orderby');
		});

		//selection.on( 'add remove reset', generatePreview, selection );

		return selection;
	}

	function handleSelectionChange( model, selection ) {
		var element = this.cuztomElement;
		generatePreview( selection, element );
	}

	function handleSelectionReset( selection ) {
		var element = this.cuztomElement;
		generatePreview( selection, element );
	}

	function generatePreview( selection, element ) {
		var previewElement = $( '.cuztom-gallery-preview > ul.list', element );
		previewElement.empty();

		var html = '<!--';

		selection.forEach( function( image ) {
			html +='--><li><img src="' + image.attributes.sizes.thumbnail.url + '" width="' + image.attributes.sizes.thumbnail.width + '" height="' + image.attributes.sizes.thumbnail.height + '" /></li><!--';
		} );

		html += '-->';

		previewElement.html( html );
	}

	var cuztomUI;
	(cuztomUI = function(object) {
		object = $(object);

		// Datepicker
		$('.js-cztm-datepicker', object).map(function() {
			return $(this).datepicker({ dateFormat: $(this).data('date-format') });
		});

		// Timepicker
		$('.js-cztm-timepicker', object).map(function() {
			return $(this).timepicker({ timeFormat: $(this).data('time-format') });
		});

		// Datetime
		$('.js-cztm-datetimepicker', object).map(function() {
			return $(this).datetimepicker({
				timeFormat: $(this).data('time-format'),
				dateFormat: $(this).data('date-format')
			});
		});

		// Colorpicker
		$('.js-cztm-colorpicker', object).wpColorPicker();

		// Tabs
		$('.js-cztm-tabs', object).tabs();

		// Slider
		$('.js-cztm-slider', object ).slider();

		// Accordion
		$('.js-cztm-accordion', object).accordion();

		// Sortable
		$('.js-cztm-sortable', object).sortable({
			handle: '.cuztom-handle-sortable a'
		});

		// Location
		$('.js-cztm-location-map').each(function() {
			if( $(this).hasClass('loaded') ) {
				return;
			}

			var td 			= $(this).closest('.cuztom-td'),
				latField 	= $('.cuztom-location-latitude', td),
				lngField 	= $('.cuztom-location-longitude', td);
				latitude	= parseFloat( latField.val() ),
				longitude	= parseFloat( lngField.val() ),
				latDefault 	= parseFloat( latField.data('default-value') ),
				lngDefault 	= parseFloat( lngField.data('default-value') );

			if( latitude < -90 || latitude > 90 || isNaN(latitude) ) {
				latitude = latDefault;
			}

			if( longitude < -180 || longitude > 180 || isNaN(longitude) ) {
				longitude = lngDefault;
			}

			latitude 	= latitude.toFixed(6);
			longitude 	= longitude.toFixed(6);
			latLng 		= new google.maps.LatLng( latitude, longitude );

			var map = new google.maps.Map( this, {
					zoom: 12,
					center: latLng,
					mapTypeId: google.maps.MapTypeId.ROADMAP
				});

			// Creates a draggable marker
			var mapMarker = new google.maps.Marker({
				position: latLng,
				draggable: true
			});

			$(this).data('map', map).data('map-marker', mapMarker).addClass('loaded');

			// Adds a listener to the marker, to update fields
			google.maps.event.addListener(mapMarker, 'dragend', function(event) {
				var td = $(this.map.j).closest('.cuztom-td');
				latField.val(event.latLng.lat().toFixed(6));
				lngField.val(event.latLng.lng().toFixed(6));
			});

			// Adds the marker on the map
			mapMarker.setMap(map);
		});

		// Gallery
		$('.cuztom-gallery').each( function() {
			var selection;
			selection = get_Selection( this );

			var args = {
				multiple: true,
				type: 'image',
				modal: true,
				frame: 'post',
				state: 'gallery-library',
				editing: true
			};

			if( selection != null ) {
				args.state = 'gallery-edit';
				args.selection = selection;
			}

			_cuztom_gallery = wp.media( args );

			_cuztom_gallery.cuztomElement = this;

			_cuztom_gallery.options.selection.on( 'add remove sort', handleSelectionChange, _cuztom_gallery );
			_cuztom_gallery.options.selection.on( 'reset', handleSelectionReset, _cuztom_gallery );

			_cuztom_gallery.on( 'update', function( library ) {
				var ids = library.pluck( 'id' );
				var cuztomElement = $( this.cuztomElement );
				var images_name = cuztomElement.data( 'name' ) + '[images][]';

				$( 'input[name="' + cuztomElement.data( 'name' ) + '[link]"], input[name="' + cuztomElement.data( 'name' ) + '[columns]"], input[name="' + cuztomElement.data( 'name' ) + '[random]"], input[name="' + images_name + '"]', cuztomElement ).remove();

				if( library.gallery.has( 'link' ) ) {
					cuztomElement.append( '<input type="hidden" name="' + cuztomElement.data( 'name' ) + '[link]" value="' + library.gallery.get( 'link' ) + '" />' );
				}
				if( library.gallery.has( 'columns' ) ) {
					cuztomElement.append( '<input type="hidden" name="' + cuztomElement.data( 'name' ) + '[columns]" value="' + library.gallery.get( 'columns' ) + '" />' );
				}
				if( library.gallery.attributes._orderbyRandom ) {
					cuztomElement.append( '<input type="hidden" name="' + cuztomElement.data( 'name' ) + '[random]" value="' + library.gallery.attributes._orderbyRandom + '" />' );
				}
				ids.forEach( function( value ) {
					cuztomElement.append( '<input type="hidden" name="' + images_name + '" value="' + value + '" />' );
				} );
			}, _cuztom_gallery );


			cuztomGalleries[ $( this ).data( 'name' ) ] = _cuztom_gallery;

		});
	})(document);

	// Add sortable
	$(document).on( 'click', '.js-cztm-add-sortable', function(event) 
	{
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
	$(document).on( 'click', '.js-cztm-remove-sortable', function()
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
			sortable.find('.cuztom-sortable-item').last().find('.js-cztm-remove-sortable').remove();
		}

		return false;
	});

	// Remove current attached image
	$(document).on( 'click', '.js-cztm-remove-media', function()
	{
		var that 		= $(this),
			parent 		= that.closest('.cuztom-field');

		parent.find( '.cuztom-preview').html('');
		parent.find( '.cuztom-hidden').val('');

		that.hide();

		return false;
	});

	// Upload image
	$(document).on( 'click', '.js-cztm-upload', function()
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
			parent.find('.js-cztm-remove-media').remove();
			that.after('<a href="#" class="js-cztm-remove-media cuztom-remove-media"></a>');

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
	$(document).on( 'click', '.js-cztm-ajax-save', function(event) {
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

	// Set location default
	$(document).on( 'click', '.js-cztm-location-default', function(event) {
		var td = $(this).closest('.cuztom-td');

		$('.cuztom-location-latitude, .cuztom-location-longitude', td).each( function() {
			$(this).val( $(this).data('default-value') );
		});

		// Prevent click
		event.preventDefault();
	});

	// Update marker
	$(document).on( 'keyup blur', '.cuztom-location-latitude, .cuztom-location-longitude', function(event) {
		var td 			= $(this).closest('.cuztom-td'),
			mapElement 	= $('.cuztom-location-map', td),
			latField 	= $('.cuztom-location-latitude', td),
			lngField 	= $('.cuztom-location-longitude', td);

		var map 		= mapElement.data('map'),
			marker 		= mapElement.data('map-marker'),
			latitude 	= parseFloat( latField.val() ),
			longitude	= parseFloat( lngField.val() ),
			latDefault 	= parseFloat( latField.data('default-value') ),
			lngDefault 	= parseFloat( lngField.data('default-value') );

		if( latitude < -90 || latitude > 90 || isNaN(latitude) ) {
			latitude = latDefault;
		}

		if( longitude < -180 || longitude > 180 || isNaN(longitude) ) {
			longitude = lngDefault;
		}

		latitude 	= latitude.toFixed(6);
		longitude 	= longitude.toFixed(6);
		latLng 		= new google.maps.LatLng(latitude, longitude);

		map.setCenter(latLng);
		marker.setPosition(latLng);
	});

	// Gallery edit button
	$(document).on( 'click', '.js-cztm-edit-gallery', function( event ) {
		cuztomGalleries[ $( this ).closest( '.cuztom-gallery' ).data( 'name' ) ].open();

		// Prevent click
		event.preventDefault();
	} );

});