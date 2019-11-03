<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Create Post</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.css" rel="stylesheet">
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-8 mx-auto">
				<form action="" method="post">
					@csrf
					<div class="form-group">
						<label for="" class="control-label">Title</label>
						<input type="text" name="title" class="form-control">
					</div>
					<div class="form-group">
						<label for="" class="control-label">Content</label>
						<textarea name="content" id="summernote" class="form-control"></textarea>
					</div>
					<div class="form-group">
						<button class="btn btn-primary">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote-bs4.js"></script>
    <script>
    	$.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{csrf_token()}}'
            }
        });
    	$('#summernote').summernote({
	        height: 300, 
	        callbacks: {
                onImageUpload: function(image) {
                    uploadImage(image[0]);
                },
                onMediaDelete : function(target) {
                    deleteImage(target[0].src);
                }
            }
	    });

    	function uploadImage(image) {
            var data = new FormData();
            data.append("image", image);
            url = "{{url('upload-image')}}";
            $.ajax({
		        url: url,
		        cache: false,
		        contentType: false,
		        processData: false,
		        data: data,
		        type: "POST",
		        success: function(url) {
		        	$('#summernote').summernote("insertImage", '{{url("/")}}/'+url);
		        },
		        error: function(data) {
		            console.log(data);
		        }
		    });
        }

        function deleteImage(src) {
        	data = {"image_path" : image}
			$.post("{{url('q/post/image/delete')}}", data);
        }
    </script>
</body>
</html>