@extends('admin::layouts.admin')

@section('admin-content')

	<h1>Add location</h1>

	@if (session('error'))
		<span class="alert alert-error">{{ session('error') }}</span>
	@endif
		
	<form action="locations/save" method="post" enctype="multipart/form-data">

		{{ csrf_field() }}
		
		@if ($errors->first('title'))
		    <div class="alert alert-error no-hide">
		        <span class="help-block">
		            <strong>{{ $errors->first('title') }}</strong>
		        </span>
		    </div>
		@endif 

		<label for="title">Title:</label>
		<input type="text" name="title" placeholder="Title" value="{{ old('title') }}">
		
		<label for="description">Description:</label>
		<textarea name="description" class="htmlEditor" rows="15" data-page-name="description" data-page-id="new" id="editor-1">{{ old('description') }}</textarea>
				
		<div class="input-wrap proposal-address-input-wrap">
			<label>Adress:</label>
			<input type="text" name="address" placeholder="Address for finding location" id="address" value="{{ old('address') }}"/>

			<div id="locate" class="button dark">Locate</div>

			<input type="hidden" name="latitude" placeholder="latitude" id="latitude" />
			<input type="hidden" name="longitude" placeholder="longitude" id="longitude" />
			<input type="hidden" name="zoom" id="zoom" placeholder="zoom" value="12"/>
			<input type="hidden" name="image" id="mapImage"/>
		</div>

		<div class="static-map-wrap" style="height: 200px;">
			<div id="map" style="width: 100%;min-height: 300px;margin-bottom: 24px;"></div>								
		</div>

		<label>Image</label>
		<div class="file-input-wrap cf">
			<div class="fileUpload">
				<span>Choose file</span>
				<input type="file" name="image"/>
			</div>
		</div>

		<label for="link">Link:</label>
		<input type="text" name="link" placeholder="URL" value="{{ old('link') }}">
	
		<input type="submit" value="Add">
	</form>

<script src='https://maps.googleapis.com/maps/api/js'></script>
<script>

var map;
var markers = [];
var deleteMarkers;

function initMap() {
	var mapDiv = document.getElementById('map');
	var lat = {{ !empty(old('latitude')) ? old('latitude') : 44.786568 }};
	var lng = {{ !empty(old('longitude')) ? old('longitude') : 20.44892159999995 }};

	map = new google.maps.Map(mapDiv, {
		center: { lat: lat, lng: lng },
		zoom: 4 ,
		scrollwheel: false,
	});

	@if (1!=1)
		var marker = new google.maps.Marker({
			// icon: '../images/map-marker-orange.png',
			position: {lat: , lng:  },
			map: map,
		});

		markers.push(marker);
	@endif

	document.getElementById('locate').addEventListener('click', function() {
    	var address = document.getElementById("address").value;
		codeAddress(address,'true',map);
		});

		map.addListener('zoom_changed', function(event) {
	    $('#zoom').val(map.getZoom());
	    var zoom = $('#zoom').val(map.getZoom()).val();

	    setStaticMap($('#latitude').val(), $('#longitude').val(), map.getZoom());
	});

	google.maps.event.addListener(map, 'click', function(event) {
		placeMarker(event.latLng, map);
	});
}

initMap();


function placeMarker(latLng, map) {
	deleteMarkers();		

    var marker = new google.maps.Marker({
    	icon: 'images/map-marker-orange.png',
        position: latLng, 
        map: map
    });

    $('#latitude').val(latLng.lat());
    $('#longitude').val(latLng.lng());
    $('#zoom').val(map.getZoom());

    setStaticMap(latLng.lat(), latLng.lng(), map.getZoom());

    // add marker in markers array
    markers.push(marker);
    //center map by marker
    map.panTo(latLng);
}

function setStaticMap(lat,lng,zoom){
	var mapSrc = 'https://maps.googleapis.com/maps/api/staticmap?center='+lat+','+lng+'&zoom='+zoom+'&scale=2&size=640x300&maptype=roadmap&key=AIzaSyCvMo4tix_7-gqUXt4QQuA8buWLcxzLyMw&format=png&visual_refresh=true&markers=size:mid%7Ccolor:0xf17201%7Clabel:%7C'+lat+','+lng

	// $('#staticMapImage').attr('src',mapSrc);
	$('#mapImage').val(mapSrc);
}

deleteMarkers = function() {
  	for (var i = 0; i < markers.length; i++) {
	    markers[i].setMap(null);
  	}
  	markers = [];
}
// end google map		

// get lat and lng from  address
geocoder = new google.maps.Geocoder();


$('#locate').click(function(){
	var address = document.getElementById("address").value;
	codeAddress(address,'true',map);
})


$('#update-offer').click(function(e){
	e.preventDefault();
	if( $('#latitude').val() == '' ){
		var address = document.getElementById("address").value;
		codeAddress(address,'true');


		setTimeout(function(){
			var interval = setInterval(function(){
				if( $('#latitude').val() != '' ){
					$(".form").submit();
					clearInterval(interval);
				}
			},100)

		},500)
		
	}else{
		$(".form").submit();
	}

})


if( $('#latitude').val() == "" && $('#address').val() != '' ){
	var address = document.getElementById("address").value;
	codeAddress(address,'true');
	
	setTimeout(function(){
		var interval = setInterval(function(){
			if( $('#latitude').val() != '' ){
				$.post('administration/ajax/update-location', { image: $('#mapImage').val(), latitude: $('#latitude').val() , longitude: $('#longitude').val(), zoom: $('#zoom').val()}, function(data) {
					
				});
				clearInterval(interval);
			}
		},100)

	},500)



}
</script>
@stop