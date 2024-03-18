@extends('admin.layouts.master')
@section('categories_select', 'active')
@push('custom-css')
  <style>
    .ui-autocomplete {
        max-height: 150px;
        overflow-y: auto;
        /* Customize other styles as needed */
        background-color: white;
        border: 1px solid #ccc;
        z-index: 100;
    }
</style>
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Category</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dash') }}">Home</a></li>
              <li class="breadcrumb-item active">Category</li>
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
         
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <form method="POST" action="{{ route('admin.category.create') }}">
              @csrf
              <div class="card card-primary">
                <div class="card-header">
                  <h3 class="card-title">Category</h3>
                </div>
                <!-- /.card-header -->
                <!-- form start -->
              
                  <div class="card-body">

                    <div class="row">

                      <div class="col-md-12">
                        <div class="form-group">
                          <label for="Category Name">Category Name</label>
                          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Attribute Name">
                          @error('name')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                            </span>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-12">
                          <div class="form-group">
                              <label for="parentCategory">Parent Category</label>
                              <input type="text" class="form-control" id="parentCategory" name="parentCategory" placeholder="Start typing to search...">
                              <input type="hidden" name="parent_id" id="parent_id" value="">
                          </div>
                      </div>
                      <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right">Add Category</button>
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

            
            </form>
            
          </div>
        </div>
      </div>
    </section>

    <!----End Main Body Form---->
   
</div>

@push('custom-js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxy/1.6.1/scripts/jquery.ajaxy.min.js" integrity="sha512-bztGAvCE/3+a1Oh0gUro7BHukf6v7zpzrAb3ReWAVrt+bVNNphcl2tDTKCBr5zk7iEDmQ2Bv401fX3jeVXGIcA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script type="text/javascript">
  console.log('hello')
</script>
<script>
    $(function() {
        $('#parentCategory').autocomplete({
            source: function(request, response) {
                $.ajax({
                    url: "{{ route('category.autocomplete') }}",
                    dataType: 'json',
                    data: {
                        term: request.term
                    },
                    success: function(data) {
                        response(data);
                    }
                });
            },
            select: function(event, ui) {
                $('#parentCategory').val(ui.item.label);
                $('#parent_id').val(ui.item.value);
                return false;
            },
            open: function(event, ui) {
                // Manipulate the autocomplete dropdown styles
                $('.ui-autocomplete').css('z-index', 100);
            }
        });
    });
</script>

@endpush
@endsection