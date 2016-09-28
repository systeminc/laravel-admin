@extends('admin::layouts.admin')

@section('custom-script')
	<script src="scripts/chosen.jquery.js"></script>
	<link rel="stylesheet" href="scripts/chosen.css">
	<script type="text/javascript">
		$(function(){
		    var config = {
		      '.chosen-select' : {}
		    }
		    for (var selector in config) {
		      $(selector).chosen(config[selector]);
		    }
		});

  </script>
@stop

@section('admin-content')
	<div class="admin-header">
		<h1>Email Leads</h1>
		<span class="last-update"></span>
	</div>

	<div class="admin-content">
		
		@if (session('error'))
		    <span class="alert alert-error">
		        {{ session('error') }}
		    </span>
		@endif
		
		@if (session('success'))
		    <span class="alert alert-success">
		        {{ session('success') }}
		    </span>
		@endif

		{{-- {{dd(old('receivers'))}} --}}
		
		<form action="" method="post">
			{{ csrf_field() }}
						
			<select name="receivers[]" multiple data-placeholder="Select a Email-s" style="width:100%;" class="chosen-select" tabindex="7">
			
				@foreach ($leads as $lead)

					<?php $json = json_decode($lead->data);?>
					{{$selected = ''}}

					@if (!empty($json->email))
						@if (old('receivers'))
							@foreach( old('receivers') as $email )
								@if( $json->email == $email )
									{{$selected = 'selected'}}
								
								@endif
							@endforeach

						@endif

						<option value="{{ $json->email }}" {{$selected}}>{{ $json->email }}</option>
					@endif

				@endforeach
			</select>

		
			<label for="subject">Subject</label>
			<input type="text" name="subject" value="{{old('subject')}}" placeholder="Subject">

			<label>Email body</label>
			<textarea name="body" class="htmlEditor" rows="15" data-page-name="leads" data-page-id="2" id="editor-2">{{old('body')}}</textarea>

			<input type="submit" value="Send" class="save-item">
		</form>
		
	</div>




@stop