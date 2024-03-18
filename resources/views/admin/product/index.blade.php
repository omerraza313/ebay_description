@extends('admin.layouts.master')
@section('products_select', 'active')
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
            <h1 class="m-0">Product</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('admin.dash')}}">Home</a></li>
              <li class="breadcrumb-item active">Products</li>
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
          @if(session('delete'))
          <div class="col-md-12">
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              {{ session('delete') }}
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

    <!----Main Body Content---->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <a href="{{ route('admin.product.add') }}" class="btn btn-primary">
                  Add Product
                </a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th style="width: 10%;">Sr.No #</th>
                    <th>Product Name</th>
                    <th>Sku</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($products as $key=>$product)
                    <tr>
                      <td>{{ ++$key }}</td>
                      <td>{{ $product->product_name }}</td>
                      <td>{{ $product->sku }}</td>
                      <td>{{ $product->price }}</td>
                      <td>
                        <img src="{{ asset('storage/main_images/' . $product->image) }}" alt="Product Image" style="max-width: 100px; max-height: 100px;">
                      </td>
                      <td>
                        <button class="btn btn-success copy-to-clipboard" data-html="{{ $product->html }}"><i class="fas fa-copy"></i></button>
                        <a href="{{ route('admin.product.preview', ['id' => $product->id]) }}" class="btn btn-warning"><i class="fas fa-eye"></i></a>
                        <a href="{{ route('admin.product.edit', ['id' => $product->id]) }}" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                        <form action="{{ route('admin.product.destroy', ['id' => $product->id]) }}" style="display:inline-block" method="POST">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this product?')"><i class="fas fa-trash-alt"></i></button>
                        </form>   
                      </td>
                    </tr>
                    @endforeach

                  </tbody>
                  <tfoot>
                      <tr>
                          <td colspan="6" class="text-center">
                              {{ $products->links() }}
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

    <!-- Bootstrap Modal -->
    <div class="modal fade" id="copyConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="copyConfirmationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="copyConfirmationModalLabel">Copy Confirmation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    HTML copied to clipboard!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

   
</div>

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
                // alert('HTML copied to clipboard!');
                $('#copyConfirmationModal').modal('show');
            });
        });
    });
</script>



@endsection