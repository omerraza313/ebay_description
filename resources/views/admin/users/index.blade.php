@extends('admin.layouts.master')
@section('users_select', 'active')
<style>
    .pagination li a {
        font-size: 14px; /* Adjust the font size as needed */
    }

    svg{
      display: inline-block !important;
      max-height: 20px;
    }
    nav[role="navigation"] > div:first-child {
      display: none;
    }
</style>
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">User</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dash')}}">Home</a></li>
              <li class="breadcrumb-item active">User</li>
            </ol>
          </div><!-- /.col -->
          <!-- @if(session('success'))
            <div class="alert alert-success" role="alert">
              {{ session('success') }}
            </div>
          @endif -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!----Main Body Content---->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <a href="{{ route('admin.users.add') }}" class="btn btn-primary">
                  Add User
                </a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th style="width: 10%;">Sr.No #</th>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th style="width: 20%;">Action</th> 
                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($users as $index => $user)
                    <tr>
                      <td>{{ $index + 1 }}</td>
                      <td>{{ $user->name }}</td>
                      <td>{{ $user->email }}</td>
                      <td>{{ $user->status }}</td>
                      <td>
                        <a href="{{ route('admin.users.edit', ['user' => $user->id]) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>

                        <form action="{{ route('admin.users.delete', ['user' => $user->id]) }}" style="display:inline-block" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this User?')"><i class="fas fa-trash-alt"></i></button>
                        </form>   

                      </td>
                    </tr>  
                    @endforeach
                  </tbody>

                  <tfoot>
                      <tr>
                          <td colspan="6" class="text-center">
                              {{ $users->links() }}
                          </td>
                      </tr>
                  </tfoot>
                  
                </table>
              </div>
              <!-- /.card-body -->
            </div>
          </div>
        </div>
      </div>
    </section>
    <!----End Main Body Content---->
   
</div>


@endsection