@extends('admin::layouts.admin')

@section('admin-content')
	<div class="admin-header">
		<h1>Edit location</h1>
		<span class="last-update">Last change: {{$location->updated_at->tz('CET')->format('d M, Y, H:i\h')}}</span>
	</div>

	<div class="admin-content">
		@if (session('success'))
		    <span class="alert alert-success">
		        {{ session('success') }}
		    </span>
		@endif

		<form action="locations/update/{{ $location->id }}" method="post" enctype="multipart/form-data">
			{{ csrf_field() }}

			@if ($errors->first('title'))
			    <div class="alert alert-error no-hide">
			        <span class="help-block">
			            <strong>{{ $errors->first('title') }}</strong>
			        </span>
			    </div>
			@endif 

			<label>Title</label>
			<input type="text" name="title" placeholder="Page title" value="{{ $location->title or old('title') }}">

			<label for="description">Description:</label>
			<textarea name="description" class="htmlEditor" rows="15" data-page-name="description" data-page-id="new" id="editor-1">{{ $location->description or old('description') }}</textarea>
			
			<div class="input-wrap">
				<label>Adress:</label>
				<input type="text" name="address" placeholder="Address for finding location" id="address" value="{{ old('address') }}"/>

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
					<div class="small-image-preview" style="background-image: url(uploads/{{$location->image}})"></div>
					<input type="checkbox" name="delete_image" value="Delete this file">Delete this file?
				@else
					<div class="fileUpload">
						<span>Choose file</span>
						<input type="file" name="image"/>
					</div>
				@endif
			</div>

			<label for="link">Link:</label>
			<input type="text" name="link" placeholder="URL" value="{{ $location->link or old('link') }}">

			<input type="submit" value="Update" class="save-item">

			<a href="locations/delete/{{ $location->id }}" class="button remove-item">Delete location</a>
		</form>

		<div class="section-header">
			<span>Map markers</span>
			<div class="line"></div>
		</div>

		@if (session('marker'))
		    <div class="alert alert-error no-hide">
		        <span class="help-block">
		            <strong>{{ session('marker') }}</strong>
		        </span>
		    </div>
		@endif

		<div class="cf">
			<div class="cf"></div>
			<a href="locations/add-marker/{{ $location->id }}" class="button right">Add marker</a>
			<div class="cf"></div>

			@if (!empty($location->marker->first()))
				
				<ul class="elements-list">
					@foreach ($location->marker as $marker)
						<li>
							<a href="locations/edit-marker/{{$marker->id}}"><b>{{ ucfirst($marker->title) }}</b></a>
							<a href="locations/delete-marker/{{ $marker->id }}" class="button remove-item file list delete">Delete</a>
						</li>
					@endforeach
				</ul>
			@else
				<p>No markers yet</p>
			@endif
		</div>

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