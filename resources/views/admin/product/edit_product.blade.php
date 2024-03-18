@extends('admin.layouts.master')
@section('products_select', 'active')
@push('custom-css')
<style type="text/css">
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
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <!-- <style type="text/css">
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


  </style> -->
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
                        <h1 class="m-0">Edit Product</h1>
                       
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dash') }}">Home</a></li>
                            <li class="breadcrumb-item active">Product</li>
                        </ol>
                        <br/>
                        
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!----Main Body Form---->
        <section class="content">
            <div class="container-fluid">
                @if(session('error'))
                  <div class="col-md-12">
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                      {{ session('error') }}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  </div>
                @endif
                <div class="row">

                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <form method="POST" action="{{ route('admin.product.update', ['product' => $product]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Product</h3>
                                    <button class="btn btn-sm btn-success float-sm-right copy-to-clipboard" data-html="{{ $product->html }}"><i class="fas fa-copy"></i> Copy to Clipboard</button>
                                     <a href="{{ route('admin.product.preview', ['id' => $product->id]) }}" class="btn btn-sm btn-warning float-sm-right" target="__blank"><i class="fas fa-eye"></i> Preview</a>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="Product Name">Product Name</label>
                                                <input type="text" class="form-control @error('product_name') is-invalid @enderror" id="product_name" name="product_name" placeholder="Product Name" value="{{$product->product_name}}" required>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="Product SKU">SKU</label>
                                                <input type="text" class="form-control @error('sku') is-invalid @enderror" id="sku" name="sku" placeholder="sku" value="{{$product->sku}}">
                                                @error('sku')
                                                    <div class="invalid-feedback">
                                                        {{ $message }}
                                                    </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="Product price">Price</label>
                                                <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" placeholder="price" value="{{$product->price}}" step="any">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                          <div class="form-group">
                                            <label for="Product description">Description</label>
                                               
                                            <textarea id="summernote" name="description">
                                               {!! $product->description !!}
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
                                              <input type="file" class="form-control @error('main_image') is-invalid @enderror" id="main_image" name="main_image">
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                            <!-- Image preview thumbnail -->
                                            <div id="main_image_preview" class="thumbnail">
                                                <img id="main_image_display" src="{{ asset('storage/main_images/' . $product->image) }}" alt="Main Image" style="max-width:80%; max-height:100px; border-radius: 5%;">
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                              <div class="form-group">
                                                  <label for="Gallery Images">Gallery Images</label>
                                                  <input type="file" class="form-control @error('gallery_images') is-invalid @enderror" id="gallery_images" name="gallery_images[]" multiple>
                                              </div>
                                        </div>
                                        <div class="col-md-12">
                                              <!-- Gallery images preview container -->
                                              <div id="gallery_preview_container">
                                                  @foreach($gallery as $g)
                                                    <span class="thumbnail_preview"><img src="{{ asset('storage/gallery_images/' . $g->image_path) }}" alt="Gallery Image" style="max-width:100%; max-height:100px; border-radius:5%;">
                                                    <button class="remove_thumbnail" data-id="{{$g->id}}" onclick="removeThumbnail(this)">&times;</button></span>
                                                  @endforeach
                                              </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                              <label for="attribute">Attribute</label>

                                                <div id="attribute_container">
                                                    @foreach($allAttributes as $index => $attribute)
                                                        <div class="row product-attribute">
                                                            <div class="col-md-5 form-group">
                                                                <select class="form-control" name="attributes[]">
                                                                    <option value="{{ $attribute->id }}" {{ in_array($attribute->id, array_column($productAttributes, 'attribute_id')) ? 'selected' : '' }}>{{ $attribute->name }}</option>
                                                                    <!-- Add options if needed -->
                                                                </select>
                                                            </div>
                                                            <div class="col-md-5 form-group">
                                                                @php
                                                                    $productAttribute = collect($productAttributes)->firstWhere('attribute_id', $attribute->id);
                                                                @endphp
                                                                <input type="text" class="form-control" name="attribute_values[]" value="{{ $productAttribute ? $productAttribute['value'] : '' }}">
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                 @php
                                                    $loop_count_num = 1;
                                                    @endphp
                                                {{--    <div id="attribute_container">

                                                   
                                                    @foreach($productAttributes as $attribute)
                                                    <div class="row product-attribute" data-attribute-id="{{$loop_count_num}}">
                                                        <div class="col-md-5 form-group">
                                                            <select class="form-control" name="attributes[]" required="">
                                                                <option value="">Select Attribute</option>
                                                                @foreach($allAttributes as $att)
                                                                    @if($attribute['attribute_id'] == $att->id)
                                                                        <option value="{{$att->id}}" selected>{{$att->name}}</option>
                                                                    @else
                                                                        <option value="{{$att->id}}">{{$att->name}}</option>
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-md-5 form-group">
                                                            <input type="text" class="form-control" name="attribute_values[]" value="{{$attribute['value']}}" required="">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button class="btn btn-danger remove_att" data-value-id="{{$loop_count_num}}"  data-id="{{$attribute['id']}}"><i class="fa fa-minus"></i></button>
                                                        </div>
                                                    </div>
                                                        @php
                                                        $loop_count_num++;
                                                        @endphp
                                                    @endforeach
                                                </div>
                                              <button type="button" class="btn btn-success" onclick="addAttribute()">
                                                  <i class="fa fa-plus"></i>
                                              </button> --}}
                                            </div>
                                        </div>
                                    </div>
                                       
                                </div>
                                <div class="row">
                                    <!-- Category dropdown with Select2 -->
                                    <div class="col-md-12 p-2">
                                      <div class="form-group">
                                        <label for="category">Category</label>
                                        <select class="js-example-basic-multiple form-control" name="categories[]" multiple="multiple">
                                            @foreach($categoryCollection as $category)
                                                @php $isSelected = false; @endphp
                                                @foreach($categories as $cat)
                                                    @if($cat->id == $category->id)
                                                        @php $isSelected = true; @endphp
                                                    @endif
                                                @endforeach
                                                <option value="{{ $category->id }}" @if($isSelected) selected @endif>{{ $category->path }}</option>
                                            @endforeach
                                        </select>

                                      </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="row">
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Update Product</button>
                                    </div>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>

        <!----End Main Body Form---->

    </div>

    @push('custom-js')
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
        // previewContainer.innerHTML = '';
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

        var ImageId = $(button).data("id");
        console.log(ImageId);
        if(ImageId){
            $.get('/admin/product/delete/gallery-image/'+ImageId, function(response){
                    console.log("Image Deleted");
            });   
        }

    }

    var attributeCount = @json($loop_count_num);
    var attributes = @json($allAttributes);
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
            '<button class="btn btn-danger remove_att" data-value-id="' + attributeCount + '" data-id="0">' +
            '<i class="fa fa-minus"></i>' +
            '</button>' +
            '</div>' +
            '</div>';

        $('#attribute_container').append(attHtml);
    }

    $(document).on('click', '.remove_att', function(e) {
        e.preventDefault();
        var attCount = $(this).data('value-id');
        var dataId = $(this).data('id');

        console.log('Removing attribute with ID: ' + attCount);
        
        var attributeElement = $('.product-attribute[data-attribute-id="' + attCount + '"]');
        //attributeElement.remove();
        if (dataId > 0) {
            var csrfToken = '{{ csrf_token() }}';
            console.log(csrfToken);
            $.ajax({
                url: '/admin/product/delete-attribute/' + dataId,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    _method: 'DELETE', 
                    attributeId: dataId
                },
                success: function(response) {
                    // On success, remove the attribute element
                    attributeElement.remove();
                },
                error: function(error) {
                    console.error('Error deleting attribute:', error);
                }
            });
        } else {
        // If dataId is 0, just remove the element
            attributeElement.remove();
        }
        //$('.product-attribute[data-attribute-id="' + attCount + '"]').remove();
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Select all buttons with the class 'copy-to-clipboard'
        var copyButtons = document.querySelectorAll('.copy-to-clipboard');

        // Iterate over each button
        copyButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                // Get the HTML data from the button's 'data-html' attribute
                var htmlToCopy = button.getAttribute('data-html');

                // Create a textarea element to hold the HTML
                var textarea = document.createElement('textarea');
                textarea.value = htmlToCopy;

                // Append the textarea to the body and select its content
                document.body.appendChild(textarea);
                textarea.select();

                // Copy the selected text to the clipboard
                document.execCommand('copy');

                // Remove the textarea from the DOM
                document.body.removeChild(textarea);

                // You can add a notification or other feedback here
                alert('HTML copied to clipboard!');
            });
        });
    });
</script>


<script>
            $(document).ready(function () {
        // Summernote
        $('#summernote').summernote({
            height: 200,
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
    @endpush
@endsection
