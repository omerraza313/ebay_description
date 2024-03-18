<!-- resources/views/form.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Page</title>

    <style type="text/css">
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        .btn {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #0056b3;
        }
        .alert-message{
            padding: 5px;
            background-color: #5cb85c;
        }
    </style>
    <!-- <link rel="stylesheet" href="{{ asset('css/styles.css') }}"> -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>

    <div class="container">
        @if(session('success'))
            <div class="alert-message">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('process.form') }}" method="post" id="productForm" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="product_name">Product Name:</label>
                <input type="text" name="product_name" id="productNameInput" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="sku">SKU:</label>
                <input type="text" name="sku" id="productSkuInput" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" name="price" id="productPriceInput" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Generate HTML</button>
        </form>
    </div>

    <!-- ... (existing script) ... -->

</body>
</html>






