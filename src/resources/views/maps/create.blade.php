@extends('admin::layouts.admin')

@section('admin-content')
	<div class="admin-header">
		<h1>Add map</h1>
		<span class="last-update"></span>
	</div>

	<div class="admin-content">
		@if (session('error'))
	        <div class="alert alert-error no-hide">
	            <span class="help-block">
	                <strong>{{ session('error') }}</strong>
	            </span>
	        </div>
	    @endif
			
		<form action="places/maps/save" method="post" enctype="multipart/form-data">

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

			@if ($errors->first('key'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('key') }}</strong>
			        </span>
			    </div>
			@endif 			

			<label for="key">Key:</label>
			<input type="text" name="key" placeholder="Key" value="{{ old('key') }}">
			
			<label for="description">Description:</label>
			<textarea name="description" class="htmlEditor" rows="15" data-page-name="description" data-page-id="new" id="editor-1">{{ old('description') }}</textarea>
					
			<div class="input-wrap">
				<label>Address for finding map</label>
				<input type="text" name="address" placeholder="Address for finding map" id="address" value="{{ old('address') }}"/>

			<div id="locate" class="button dark item">Locate</div>

			<div class="static-map-wrap" style="height: auto;z-index: 1;">
				<div id="map" style="width: 100%;min-height: 300px;margin-bottom: 24px;"></div>								
			</div>

			@if ($errors->first('latitude'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('latitude') }}</strong>
			        </span>
			    </div>
			@endif 

			<label for="latitude">Latitude:</label>
				<input type="text" name="latitude" placeholder="Latitude" id="latitude" value="{{ old('latitude') }}" />

			@if ($errors->first('longitude'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('longitude') }}</strong>
			        </span>
			    </div>
			@endif 

			<label for="longitude">Longitude:</label>
				<input type="text" name="longitude" placeholder="Longitude" id="longitude" value="{{ old('longitude') }}" />

			<label for="zoom">Zoom:</label>
			<input type="text" name="zoom" id="zoom" placeholder="zoom" value="{{ old('zoom') }}"/>
			<input type="hidden" id="mapImage"/>

			<input type="submit" value="Add" class="save-item">
			<a href="{{ url()->previous() }}" class="button back-button">Back</a>
		</form>

		<script src='https://maps.googleapis.com/maps/api/js{{ !empty(config('laravel-admin.google_map_api')) ? '?key='.config('laravel-admin.google_map_api') : ''}}'></script>
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

			document.getElementById('locate').addEventListener('click', function() {
		    	var address = document.getElementById("address").value;
				codeAddress(address,'true',map);
				map.setZoom(12);

			});

			map.addListener('zoom_changed', function(event) {
			    $('#zoom').val(map.getZoom());

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
		</script>	
	</div>


@stop