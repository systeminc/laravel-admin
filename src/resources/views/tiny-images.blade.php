@extends('admin::layouts.document')

@section('styles')
	@parent
	<link rel="stylesheet" href="css/admin.css">
@append

@section('scripts')
	@parent
	<script src="scripts/admin.js"></script>
@append

@section('body')
	<script>
		$(function(){

			$(".close").click(function(event) {
				$(window.parent.document).find('.tiny-upload-overlay').remove();
			});
		
			$(".thumb img").click(function(event) {
				$('form').before('<p class="message">Image added</p>');
				
				setTimeout(function() {
					$('.message').fadeOut();
				}, 1000);

				$(this).fadeOut('fast').fadeIn('fast');

				window.parent.tinyMCE.get("{{$editor_id}}").execCommand('mceInsertContent',false,'<img style="position: relative; float: left;" src="'+$(this).attr("src")+'">');
			});
		
			$(".delete-image").click(function(e) {
				e.preventDefault();
				$.post('delete-tiny-image', {
					path: $(this).data('path'),
					_token: '{{csrf_token()}}',
				});
				$(this).parent().remove();
			});

			$("[type='file']").change(function(event) {
				$(this).parents("form").submit();
			});
		
		})

	</script>

	<style>

		.close:hover{
			color: red;
		}
		
		.close{
			display: block; 
			text-align: right; 
			position: absolute; 
			top: 5px; 
			right: 5px;
			font-size: 16px;
		}

		.message {
		    padding: 15px;
		    border: 1px solid transparent;
		    border-radius: 4px;    
		    color: #3c763d;
		    background-color: #dff0d8;
		    border-color: #d6e9c6;
		    width: 60%;
		    text-align: center;
		    display: block;
		    margin: auto;
		}

		form {
			display: inline-block; 
			background: white; 
			padding: 30px; 
			position: relative;
		}

		.thumb {
			display:inline-block;
			position: relative;
			cursor: pointer;
		}

		.thumb img {
			height:80px;
		}

		.delete-image {
			display: block; 
			text-align: right; 
			position: absolute; 
			top:0;
			right:0;
			padding: 3px;
			background: white;
			font-size: 16px;
			line-height: 0.7em;
		}
		.delete-image:hover {
			background: red;
			color: white;
		}

		button{
			zoom: 0.3;
			position: absolute;
		}

		.fileUpload{
			margin-top: 20px;
		}

	</style>

	<div style="display:table; width: 100%; height: 100%; position: fixed;">
		<div style="display:table-cell; vertical-align:middle; text-align:center; height:100%;">
		
			<form action="upload-tiny-image" method="post" enctype="multipart/form-data">

				<a href="#" class="close">X</a>

				<div style="max-width: 500px; min-width:500px; overflow-y:auto; height:300px;">

					@foreach ($images as $image) 
						<div class="thumb">
							<div class="delete-image" data-path='{{$image}}'>x</div>
							<img src="{{ Storage::url($image)}}">
						</div>						
					@endforeach

				</div>

				<input type="hidden" name="directory" value="{{$directory}}">
				<input type="hidden" name="_token" value="{{csrf_token()}}">
				
			    <div class="fileUpload" style="overflow:visible">
					<span>Upload image</span>
					<input type="file" class="upload" name="files[]" multiple>
				</div>

			</form>
				
		</div>
	</div>

@stop