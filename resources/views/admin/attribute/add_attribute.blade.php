@extends('admin.layouts.master')
@section('attributes_select', 'active')
@push('custom-css')
  
@endpush
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Add Attribute</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Attribute</li>
            </ol>
          </div><!-- /.col -->
           @if(session('success'))
          <div class="col-md-12">
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
          </div>
          @endif
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
            <form method="POST" action="{{route('admin.attribute.create')}}">
              @csrf
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Attribute</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
            
                <div class="card-body">

                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="Attribute Name">Attribute Name</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="Attribute Name" value="{{ old('name') }}">
                        @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                      </div>
                    </div>
                    <div class="card-footer">
                      <button type="submit" class="btn btn-primary float-right">Add Attribute</button>
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

@endpush
@endsection