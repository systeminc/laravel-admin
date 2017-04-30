$(function(){

	// Delete confirmation
	$("a.delete, a.remove-item").click(function(e) {
		e.preventDefault();
		e.stopPropagation();
		
		if ( confirm("Are you sure you want to delete?") ){
			window.location = $(this).attr("href");
		}

	});

	// Delete confirmation AJAX
	$("body").delegate('button.delete', 'click', function(e) {
		e.preventDefault();
	});

	// CTRL + S to save in admin
	$(document).keydown(function(event) {
		if (!( String.fromCharCode(event.which).toLowerCase() == 's' && event.ctrlKey) && event.which !== 19) return true;
		$(".save").trigger("click");
		event.preventDefault();
		return false;
	});

	$('ul.account').click(function(e){
		e.stopPropagation();
		$(this).find('.submenu-down').fadeToggle();
	})

	$('body').click(function(){
		$('ul.account').find('.submenu-down').fadeOut();
	})

	// on change submit sort
	$('.sort-search-wrap .select-style').change(function(){
		$(this).parent().submit();
	})

	// datapicker
	$('.datepicker').datepicker({
    	dateFormat: 'yy-mm-dd', 
    	altField: '#date', 
    	yearRange: '1930:'+(new Date).getFullYear()
    });
    

    $('.icon-menu').click(function(){
    	$(this).toggleClass('open');
    	$(this).parent().toggleClass('open');

    	$(this).siblings('.submenu').slideToggle();
    })

    $('.input-box-wrap .button').click(function(){
    	$('.input-popup').fadeToggle();
    })

});

$(window).on("load", function(){

    hideAlert();

    $( ".sortable" ).sortable({
	  	stop: function( event, ui ) {
			var order = [];
			var sortingObject = $(this);
			var link = sortingObject.data('link');

			sortingObject.find('.items-order').each(function(){
				order.push($(this).data('id'));
			});

			if ($(ui.item).next('.no-scrolable').length > 0){
				sortingObject.sortable('cancel');
				
			}

			if( !sortingObject.hasClass("no-ajax") ){
				$.post(link, { order:order}, function(data) {
		  			if(data=='Success'){
		  				$(sortingObject).parent().append("<span class='alert alert-success'>Order saved!</span>")
		  			}else{
		  				$(sortingObject).parent().append("<span class='alert alert-error'>Order saving error!</span>")
		  			}

		  			hideAlert();
				});
			}
	  	},

	  	cancel: ".no-scrolable"
	});

	$('.copy').click(function(){
		$(this).addClass('clicked');

		setTimeout(function(){
			$('.copy.clicked').removeClass('clicked');
		},1000)
	})

});

function codeAddress(address, proposal, resultsMap) {
	geocoder.geocode( { 'address': address}, function(results, status) {
	  	if (status == google.maps.GeocoderStatus.OK) {

            $('#latitude').val(results[0].geometry.location.lat())
            $('#longitude').val(results[0].geometry.location.lng())
			
			if( !empty(resultsMap) ){
				resultsMap.setCenter(results[0].geometry.location);
				deleteMarkers();

				var marker = new google.maps.Marker({
			    	icon: 'images/map-marker-orange.png',
					map: resultsMap,
					position: results[0].geometry.location
				});

				markers.push(marker);
			}

	  	} else {
	    	alert("We couldn't find your address: " + status);
		}

		if( !empty(proposal) ){
			var mapSrc = 'https://maps.googleapis.com/maps/api/staticmap?center='+results[0].geometry.location.lat()+','+results[0].geometry.location.lng()+'&zoom='+resultsMap.getZoom()+'&scale=2&size=640x300&maptype=roadmap&key=AIzaSyCvMo4tix_7-gqUXt4QQuA8buWLcxzLyMw&format=png&visual_refresh=true&markers=size:mid%7Ccolor:0xf17201%7Clabel:%7C'+results[0].geometry.location.lat()+','+results[0].geometry.location.lng()

			$('#mapImage').val(mapSrc);

		}


	});
}

function codeAddressAjax(item_id, address) {
	geocoder.geocode( { 'address': address}, function(results, status) {
	  	if (status == google.maps.GeocoderStatus.OK) {
	  		var data = {
	  			'latitude': results[0].geometry.location.lat(),
  				'longitude': results[0].geometry.location.lng()
	  		}

	  		updateTrackRecordItemLocation(item_id,data);

		}else if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
            setTimeout('codeAddressAjax('+item_id+',"'+address.replace(/'/g, '')+'")',1000);
	  	} else {
	    	alert("We couldn't find your address: " + status);
		}

	});
}

function hideAlert(){
	setTimeout(function(){
    	if( !$('.alert').hasClass('no-hide') ) {
        	$('.alert').slideUp(function(){
        		$(this).remove();
        	});
    	}
    }, 5000);	
}

function ajaxDeleteGalleryImage(url, id) {

	if ( confirm("Are you sure you want delete?")) {
		$.post(url, function(data) {
			if(data){
				$('[data-id='+id+']').remove();				
			}
		});
	}
}