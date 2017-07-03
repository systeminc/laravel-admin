@extends('admin::layouts.admin')

@section('admin-content')
	<div class="admin-header">
		<h1>Edit location</h1>
		<span class="last-update">Last change: {{$location->updated_at->tz('CET')->format('d M, Y, H:i\h')}}</span>
	</div>

	<div class="admin-content">
		@if (session('error'))
	        <div class="alert alert-error no-hide">
	            <span class="help-block">
	                <strong>{{ session('error') }}</strong>
	            </span>
	        </div>
	    @endif

		<form action="places/locations/update/{{ $location->id }}" method="post" enctype="multipart/form-data">
			{{ csrf_field() }}

			@if ($errors->first('title'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('title') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Title</label>
			<input type="text" name="title" placeholder="Location title" value="{{ $location->title or old('title') }}">

			@if ($errors->first('url'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('url') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Url</label>
			<input type="text" name="url" placeholder="Url" value="{{ $location->url or old('url') }}">

			@if ($errors->first('key'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('key') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Key</label>
			<input type="text" name="key" placeholder="Location key" value="{{ $location->key or old('key') }}">

			<label for="description">Description:</label>
			<textarea name="description" class="htmlEditor" rows="15" data-page-name="description" data-page-id="new" id="editor-1">{{ $location->description or old('description') }}</textarea>
			
			<div class="input-wrap">
				<label>Adress:</label>
				<input type="text" name="address" placeholder="Address for finding location" id="address" value="{{ $location->address }}"/>

			<div id="locate" class="button dark item">Locate</div>

			<div class="static-map-wrap" style="height: auto;z-index: 1;">
				<div id="map" style="width: 100%;min-height: 300px;margin-bottom: 24px;"></div>								
			</div>

			<label for="latitude">Latitude:</label>
				<input type="text" name="latitude" placeholder="Latitude" id="latitude" value="{{ $location->latitude }}"/>
			<label for="longitude">Longitude:</label>
				<input type="text" name="longitude" placeholder="Longitude" id="longitude" value="{{ $location->longitude }}"/>

			<input type="hidden" name="zoom" id="zoom" placeholder="zoom"/>
			<input type="hidden" id="mapImage"/>

			<label>Image</label>
			<div class="file-input-wrap cf">
				@if(!empty($location->image)) 
					<div class="small-image-preview" style="background-image: url({{ asset('storage') .'/'. $location->image}})"></div>
					<input type="checkbox" name="delete_image" value="Delete this file">Delete this file?
				@else
					<div class="fileUpload">
						<span>Choose file</span>
						<input type="file" name="image"/>
					</div>
				@endif
			</div>

			<label>Thumb Image</label>
			<div class="file-input-wrap cf">
				@if(!empty($location->thumb_image)) 
					<div class="small-image-preview" style="background-image: url({{ asset('storage') .'/'. $location->thumb_image}})"></div>
					<input type="checkbox" name="delete_thumb_image" value="Delete this file">Delete this file?
				@else
					<div class="fileUpload">
						<span>Choose file</span>
						<input type="file" name="thumb_image"/>
					</div>
				@endif
			</div>

			<label>Marker Image</label>
			<div class="file-input-wrap cf">
				@if(!empty($location->marker_image)) 
					<div class="small-image-preview" style="background-image: url({{ asset('storage') .'/'. $location->marker_image}})"></div>
					<input type="checkbox" name="delete_marker_image" value="Delete this file">Delete this file?
				@else
					<div class="fileUpload">
						<span>Choose file</span>
						<input type="file" name="marker_image"/>
					</div>
				@endif
			</div>

			<div class="cf">
				<label>Map</label>

				<div class="select-style">
					<select name="map_id">
						<option value="0">Choose map</option>
					
						@foreach ($maps as $map)
							<option value="{{ $map->id }}"{{ ($map->id == $location->map_id) ? "selected" : "" }}>{{ $map->title }}</option>
						@endforeach
					</select>
				</div>
			</div>

			<input type="submit" value="Update" class="save-item">

			<a href="places/locations/delete/{{ $location->id }}" class="button remove-item">Delete location</a>
			<a href="{{ url()->previous() }}" class="button back-button">Back</a>
		</form>

		<script src="https://maps.googleapis.com/maps/api/js{{ !empty(config('laravel-admin.google_map_api')) ? '?key='.config('laravel-admin.google_map_api') : ''}}"></script>
		<script>

		var map;
		var markers = [];
		var deleteMarkers;

		function initMap() {
			var mapDiv = document.getElementById('map');
			var lat = {{ $location->latitude }};
			var lng = {{ $location->longitude }};

			map = new google.maps.Map(mapDiv, {
				center: { lat: lat, lng: lng },
				zoom: 12 ,
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