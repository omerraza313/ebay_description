@extends('admin.layouts.master')
@section('users_select', 'active')
@push('custom-css')
    <style>
        .ui-autocomplete {
            max-height: 150px;
            overflow-y: auto;
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
                        <h1 class="m-0">Edit User</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">User</li>
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
                        <form method="POST" action="{{ route('admin.users.update', ['user' => $user]) }}">
                            @csrf
                            @method('PUT')
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">User</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="User Name">Name</label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" placeholder="User Name" value="{{ old('name', $user->name) }}">
                                                @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="User Name">Email</label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="User Email" value="{{ old('email', $user->email) }}">
                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="role_id">Role</label>
                                                <select name="role_id" class="form-control" id="">
                                                    <option value="">Select Role</option>
                                                    <option {{$user->role_id == '1' ? 'selected' : ''}} value="1">Admin</option>
                                                    <option {{$user->role_id == '2' ? 'selected' : ''}} value="2">General</option>
                                                </select>
                                                @error('status')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select name="status" class="form-control" id="">
                                                    <option value="">Select Status</option>
                                                    <option {{$user->status == 'active' ? 'selected' : ''}} value="active">Active</option>
                                                    <option {{$user->status == 'inactive' ? 'selected' : ''}} value="inactive">In Active</option>
                                                </select>
                                                @error('status')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="status">Passowrd</label>
                                                <input type="password" class="form-control">
                                                @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="submit" class="btn btn-primary float-right">Update User</button>
                                        </div>
                                    </div>
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

    @endpush
@endsection
