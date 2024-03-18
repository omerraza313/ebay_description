<!-- resources/views/product_layout.blade.php -->

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
        
        /*product layout starts*/ 
        .product-layout{
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: flex;
        }

        .product-image, .product-details{
            flex-basis: 50%;
        }

        .product-image img{
            width: 350px;
            height: auto;
        }

        .attribute{
            font-size: 12px;
        }

        .attribute tbody tr td{
            padding: 5px;
        }
    </style>
    <!-- <link rel="stylesheet" href="{{ asset('css/styles.css') }}"> -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>

    <div class="container">
        <div class="product-layout">
            <div class="product-image">
                <!-- You can replace this with an actual image tag and source -->
                <img src="{{ asset('images/watch.jpg') }}" alt="Product Image">
            </div>
            <div class="product-details">
                <h2 id="productName">{{ $product_name }}</h2>
                <p><strong>SKU:</strong> <span id="productSku">{{ $sku }}</span></p>
                <p><strong>Price:</strong> $<span id="productPrice">{{ $price }}</span></p>

                <!-- Attribute Table -->
                <div class="size-chart-table card-body-auto">
                    <table class="attribute" cellspacing="0">
                        <tbody>
                            <tr>
                                <td>AVAILABILITY</td>
                                <td id="availability">In-stock</td>
                            </tr>
                            <tr>
                                <td>DIAMOND CLARITY</td>
                                <td id="diamondClarity">VS/SI</td>
                            </tr>
                            <tr>
                                <td>DIAMOND COLOR</td>
                                <td id="diamondColor">F/G</td>
                            </tr>
                            <tr>
                                <td>DIAMOND SHAPE</td>
                                <td id="diamondShape">ROUND DIAMOND</td>
                            </tr>
                            <!-- Add more rows for other attributes -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Your jQuery code goes here
        // You can add more dynamic functionality as needed
    </script>

</body>
</html>
