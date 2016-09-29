@extends('admin::layouts.admin')

@section('admin-content')
	<div class="admin-header">
		<h1>Edit location Marker</h1>
		<span class="last-update">Last change: {{$marker->updated_at->tz('CET')->format('d M, Y, H:i\h')}}</span>
	</div>

	<div class="admin-content">
		@if (session('success'))
		    <span class="alert alert-success">
		        {{ session('success') }}
		    </span>
		@endif

		<form action="locations/update-marker/{{ $marker->id }}" method="post">
			{{ csrf_field() }}

			@if ($errors->first('title'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('title') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Title</label>
			<input type="text" name="title" placeholder="Marker title" value="{{ $marker->title }}">

			@if ($errors->first('key'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('key') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Key</label>
			<input type="text" name="key" placeholder="Marker key" value="{{ $marker->key }}">

			<label for="description">Description:</label>
			<textarea name="description" class="htmlEditor" rows="15" data-page-name="description" data-page-id="new" id="editor-1">{{ $marker->description or $marker->description }}</textarea>
			
			<div class="input-wrap">
				<label>Adress:</label>
				<input type="text" name="address" placeholder="Address for finding marker location" id="address" value="{{ old('address') }}"/>

			<div id="locate" class="button dark item">Locate</div>

			<div class="static-map-wrap" style="height: auto;z-index: 1;">
				<div id="map" style="width: 100%;min-height: 300px;margin-bottom: 24px;"></div>								
			</div>

			<label for="latitude">Latitude:</label>
				<input type="text" name="latitude" placeholder="Latitude" id="latitude" value="{{ $marker->latitude }}"/>
			<label for="longitude">Longitude:</label>
				<input type="text" name="longitude" placeholder="Longitude" id="longitude" value="{{ $marker->longitude }}"/>

			<input type="hidden" name="zoom" id="zoom" placeholder="zoom"/>
			<input type="hidden" id="mapImage"/>

			<input type="submit" value="Update" class="save-item">
			<a href="location/delete-marker/{{ $marker->id }}" class="button remove-item right delete">Delete marker</a>

		</form>

		<script src="https://maps.googleapis.com/maps/api/js{{ !empty(config('laravel-admin.google_map_api')) ? '?key='.config('laravel-admin.google_map_api') : ''}}"></script>
		<script>

		var map;
		var markers = [];
		var deleteMarkers;

		function initMap() {
			var mapDiv = document.getElementById('map');
			var lat = {{ $marker->latitude }};
			var lng = {{ $marker->longitude }};

			map = new google.maps.Map(mapDiv, {
				center: { lat: lat, lng: lng },
				zoom: 12 ,
				scrollwheel: false,
			});

			@if ($marker->latitude && $marker->longitude)
				var marker = new google.maps.Marker({
			    	@if ($marker->location->image)
				    	icon: '{{ 'uploads/'.$marker->location->image }}',
			    	@else
				    	icon: 'images/map-marker-orange.png',
			    	@endif
					position: {lat: {{ $marker->latitude }}, lng: {{ $marker->longitude }} },
					map: map,
				});

				markers.push(marker);
			@endif

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
		    	@if ($marker->location->image)
			    	icon: '{{ 'uploads/'.$marker->location->image }}',
		    	@else
			    	icon: 'images/map-marker-orange.png',
		    	@endif
		        position: latLng, 
		        map: map
		    });

		    $('#latitude').val(latLng.lat());
		    $('#longitude').val(latLng.lng());
		    $('#zoom').val(map.getZoom());

		    // setStaticMap(latLng.lat(), latLng.lng(), map.getZoom());

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