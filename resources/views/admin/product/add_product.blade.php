@extends('admin.layouts.master')
@section('product_select', 'active')
@push('custom-css')
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <style type="text/css">
    .thumbnail_preview{
       margin: 5px;
       border-radius: 5%;   
    }
    .main_image_close{
        position: absolute;
        background-color: #ffffff;
        padding: 0px 7px;
        color: whiite;
        border: 2px solid black;
        border-radius: 82%;
        margin: -1%
    }
    .main_image_close:hover{
      cursor: pointer;
    }
    .remove_thumbnail{
      margin: -1%;
      background: transparent;
      border: 1px solid black;
      position: absolute;
      border-radius: 80%;
      padding: 0px 7px;
      background-color: #ffffff;
    }
    .remove_thumbnail:hover{
      cursor: pointer;
    }


  </style>
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('backend_assets/plugins/summernote/summernote-bs4.min.css')}}">
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Product</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dash') }}}">Home</a></li>
              <li class="breadcrumb-item active">Product</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!----Main Body Form---->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
         <!-- <div class="col-md-12">
           Omer
         </div> -->
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <form method="POST" action="{{route('admin.product.create')}}" enctype="multipart/form-data">
              @csrf
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Product</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            
                <div class="card-body">

                  <div class="row">

                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="Product Name">Product Name</label>
                        <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="product_name" name="product_name" placeholder="Product Name" required>
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="Product SKU">SKU</label>
                        <input type="text" class="form-control @error('sku') is-invalid @enderror" id="sku" name="sku" placeholder="sku">
                        
                      </div>
                    </div>

                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="Product price">Price</label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" placeholder="price" step="any">
                      </div>
                    </div>

                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="Product description">Description</label>
                           
                        <textarea id="summernote" name="description">
                          
                        </textarea>
                         
                      </div>
                     <!--  <div class="form-group">
                        <label for="Product description">Description</label>
                        <input type="text" class="form-control @error('description') is-invalid @enderror" id="description" name="description" placeholder="description">
                      </div> -->
                    </div>
                  </div>

                    <div class="row">
                      <div class="col-md-6">
                          <div class="form-group">
                              <label for="Main Image">Main Image</label>
                              <input type="file" class="form-control @error('main_image') is-invalid @enderror" id="main_image" name="main_image" required>
                              @error('main_image')
                                  <div class="invalid-feedback">{{ $message }}</div>
                              @enderror
                          </div>
                      </div>
                      <div class="col-md-6">
                          <!-- Image preview thumbnail -->
                          <div id="main_image_preview" class="thumbnail" style="display: none;">
                              <img id="main_image_display" src="#" alt="Main Image" style="max-width:80%; max-height:100px; border-radius: 5%;">
                          </div>
                      </div>
                    </div>

                  <!-- <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="Gallery Images">Gallery Images</label>
                              <div id="gallery_images_container">                                  
                                  
                              </div>
                              <button type="button" class="btn btn-success" onclick="addGalleryImage()">
                                  <i class="fa fa-plus"></i>
                              </button>
                          </div>
                      </div>
                  </div> -->

                  <div class="row">
                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="Gallery Images">Gallery Images</label>
                              <input type="file" class="form-control @error('gallery_images') is-invalid @enderror" id="gallery_images" name="gallery_images[]" multiple>
                              @if (Session::has('errors'))
                                  <div class="alert alert-danger alert-dismissible">
                                      @foreach (Session::get('errors')->all() as $error)
                                          {{ $error }}<br>
                                      @endforeach
                                  </div>
                              @endif
                          </div>
                      </div>
                      <div class="col-md-12">
                          <!-- Gallery images preview container -->
                          <div id="gallery_preview_container"></div>
                      </div>
                  </div>

                  

                  <div class="row">
                      <!-- Attribute dropdown with Select2 -->
                      <div class="col-md-12">
                          <!-- <div class="form-group">
                              <label for="attribute">Attribute</label>
                              <div id="attribute_container"></div>
                              <button type="button" class="btn btn-success" onclick="addAttribute()">
                                  <i class="fa fa-plus"></i>
                              </button>
                          </div> -->

                          <div class="form-group">
                            <label for="attributes">Attributes</label>
                            <div id="attribute_container">
                              @foreach($attributes as $index => $attribute)
                                <div class="row product-attribute">
                                  <div class="col-md-5 form-group">
                                    <select class="form-control" name="attributes[]">
                                      <option value="{{ $attribute->id }}">{{ $attribute->name }}</option>
                                      <!-- Add options if needed -->
                                    </select>
                                  </div>
                                  <div class="col-md-5 form-group">
                                    
                                    <input type="text" class="form-control" name="attribute_values[]" value="">
                                  </div>
                                </div>
                              @endforeach
                            </div>
                          </div>

                      </div>
                  </div>


                  <div class="row">
                    <!-- Category dropdown with Select2 -->
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="category">Category</label>
                        <select class="js-example-basic-multiple form-control" name="categories[]" multiple="multiple">
                          @foreach($categoryCollection as $category)
                            <option value="{{ $category->id }}">{{ $category->path }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right">Add Product</button>
                      </div>
                    </div>
                    
                      <!-- @if(session('success'))
                      <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                      </div>
                      @endif -->
                  </div>
                <!-- /.card-body -->          
            
            </div>

            <!-- /.card -->
            </form>
            
          </div>
        </div>
      </div>
    </section>


    <!----End Main Body Form---->
   
</div>

@push('custom-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxy/1.6.1/scripts/jquery.ajaxy.min.js" integrity="sha512-bztGAvCE/3+a1Oh0gUro7BHukf6v7zpzrAb3ReWAVrt+bVNNphcl2tDTKCBr5zk7iEDmQ2Bv401fX3jeVXGIcA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<style>
  .select2-selection__choice__display{
    color: black;
  }
    /* Custom styles for Select2 dropdown */
    /*.custom-theme .select2-selection__rendered {
        padding: 10px 15px; 
        border: 1px solid red; 
    }

    .custom-theme .select2-selection__arrow {
        top: 50%; 
    }*/
</style>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2 for the attribute and category dropdowns
        $('.js-example-basic-multiple').select2({
          theme: "classic"
        });
    });
</script>
<script>
    var galleryImageCount = 1;

    function addGalleryImage() {
        galleryImageCount++;

        var html = '<div class="row" id="gallery_image_' + galleryImageCount + '">' +
            '<div class="col-md-10 form-group">' +
            '<input type="file" class="form-control" name="gallery_images[]">' +
            '</div>' +
            '<div class="col-md-2">' +
            '<button class="btn btn-danger" onclick="removeGalleryImage(' + galleryImageCount + ')">' +
            '<i class="fa fa-minus"></i>' +
            '</button>' +
            '</div>' +
            '</div>';

        $('#gallery_images_container').append(html);
    }

    function removeGalleryImage(count) {
        $('#gallery_image_' + count).remove();
    }
</script>
<script>
    var attributeCount = 1;
    var attributes = @json($attributes); // Convert PHP array to JavaScript array

    function addAttribute() {
        attributeCount++;

        var attHtml = '<div class="row product-attribute" data-attribute-id="' + attributeCount + '">' +
            '<div class="col-md-5 form-group">' +
            '<select class="form-control" name="attributes[]" required>' +
            '<option value="">Select Attribute</option>';

        attributes.forEach(function(attribute) {
            attHtml += '<option value="' + attribute.id + '">' + attribute.name + '</option>';
        });

        attHtml += '</select>' +
            '</div>' +
            '<div class="col-md-5 form-group">' +
            '<input type="text" class="form-control" name="attribute_values[]" required>' +
            '</div>' +
            '<div class="col-md-2">' +
            '<button class="btn btn-danger remove_att" data-value-id="' + attributeCount + '">' +
            '<i class="fa fa-minus"></i>' +
            '</button>' +
            '</div>' +
            '</div>';

        $('#attribute_container').append(attHtml);
    }

    $(document).on('click', '.remove_att', function() {
        var attCount = $(this).data('value-id');
        console.log('Removing attribute with ID: ' + attCount);
        $('.product-attribute[data-attribute-id="' + attCount + '"]').remove();
    });
</script>
<script>
    $(document).ready(function () {
        $('#main_image').change(function () {
            previewMainImage(this);
        });

        function previewMainImage(input) {
            var preview = $('#main_image_display');
            var previewContainer = $('#main_image_preview');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    preview.attr('src', e.target.result);
                    previewContainer.show(); // Show the thumbnail container

                    // Add close button
                    var closeButton = $('<span class="main_image_close">x</span>').addClass('close-button');
                    previewContainer.append(closeButton);

                    // Attach click event to the close button
                    closeButton.click(function () {
                        previewContainer.hide(); // Hide the thumbnail container
                        $('#main_image').val(''); // Clear the input field
                        closeButton.remove(); // Remove the close button
                    });
                };

                reader.readAsDataURL(input.files[0]);
            } else {
                preview.attr('src', '#');
                previewContainer.hide(); // Hide the thumbnail container
            }
        }
    });
</script>

<script>
    // Array to store selected file names
    var selectedFileNames = [];

    // Function to handle selected gallery images
    function handleGalleryImages() {
        var galleryInput = document.getElementById('gallery_images');
        var previewContainer = document.getElementById('gallery_preview_container');

        // Clear existing previews
        previewContainer.innerHTML = '';
        // Clear selected file names array
        selectedFileNames = [];

        // Loop through selected files and display previews
        for (var i = 0; i < galleryInput.files.length; i++) {
            var file = galleryInput.files[i];
            selectedFileNames.push(file.name); // Store file name in the array

            var reader = new FileReader();

            reader.onload = function (e) {
                // Create a thumbnail preview for each image
                var thumbnail = document.createElement('span');
                thumbnail.className = 'thumbnail_preview';
                thumbnail.innerHTML =
                    '<img src="' + e.target.result + '" alt="Gallery Image" style="max-width:100%; max-height:100px; border-radius:5%;">' +
                    '<button class="remove_thumbnail" onclick="removeThumbnail(this)">&times;</button>'; // Close (remove) button

                // Append the thumbnail to the preview container
                previewContainer.appendChild(thumbnail);
            };

            // Read the image file as a data URL
            reader.readAsDataURL(file);
        }
    }

    // Attach the handleGalleryImages function to the change event of the file input
    document.getElementById('gallery_images').addEventListener('change', handleGalleryImages);

    // Function to remove a thumbnail and update the input field
    function removeThumbnail(button) {
        console.log('button clicked');
        console.log(selectedFileNames);

        var thumbnail = button.parentNode;
        var galleryInput = document.getElementById('gallery_images');

        // Find the index of the thumbnail being removed
        var index = Array.from(thumbnail.parentNode.children).indexOf(thumbnail);

        // Remove the thumbnail from the preview container
        thumbnail.parentNode.removeChild(thumbnail);

        // Remove the corresponding file name from the array
        var removedFileName = selectedFileNames.splice(index, 1)[0];

        // Create a new DataTransfer object
        var dataTransfer = new DataTransfer();

        // Add the updated files to the DataTransfer
        Array.from(galleryInput.files).forEach(file => {
            if (file.name !== removedFileName) {
                dataTransfer.items.add(file);
            }
        });

        // Set the files property of the input to the updated files
        galleryInput.files = dataTransfer.files;
    }
</script>


<!-- Summernote -->
<script src="{{ asset('backend_assets/plugins/summernote/summernote-bs4.min.js')}}"></script>

<script>

  // $(document).ready(function (){


  //   // Summernote
  //   $('#summernote').summernote({
  //     height:100,
  //   });

  // });
$(document).ready(function () {
    // Summernote
    $('#summernote').summernote({
        height: 100,
        toolbar: [
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['style', 'ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['view', ['fullscreen', 'codeview']],
        ],
    });
});




</script>

<!-- <script>
    // Function to handle selected gallery images
    function handleGalleryImages() {
        var galleryInput = document.getElementById('gallery_images');
        var previewContainer = document.getElementById('gallery_preview_container');

        // Clear existing previews
        previewContainer.innerHTML = '';

        // Loop through selected files and display previews
        for (var i = 0; i < galleryInput.files.length; i++) {
            var file = galleryInput.files[i];
            var reader = new FileReader();

            reader.onload = function (e) {
                // Create a thumbnail preview for each image
                var thumbnail = document.createElement('span');
                thumbnail.className = 'thumbnail_preview';
                thumbnail.innerHTML =
                    '<img src="' + e.target.result + '" alt="Gallery Image" style="max-width:100%; max-height:100px; border-radius:5%;">' +
                    '<button class="remove_thumbnail" onclick="removeThumbnail(this)">&times;</button>'; // Close (remove) button

                // Append the thumbnail to the preview container
                previewContainer.appendChild(thumbnail);
            };

            // Read the image file as a data URL
            reader.readAsDataURL(file);
        }
    }

    // Attach the handleGalleryImages function to the change event of the file input
    document.getElementById('gallery_images').addEventListener('change', handleGalleryImages);

    // Function to remove a thumbnail and update the input field
    function removeThumbnail(button) {
        var thumbnail = button.parentNode;
        thumbnail.parentNode.removeChild(thumbnail); // Remove the thumbnail from the preview container
    }
</script> -->

@endpush
@endsection