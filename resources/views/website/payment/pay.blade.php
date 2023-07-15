<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Payment Method</title>
    <link href="{{ asset('website/css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        button {
            background-color: #fff;
            /* border: none; */
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 5px 2px;
            cursor: pointer;
            width: 100%;
            padding: 5px;
            border-radius: 5px;
        }
        .paylogo {
            height: 150px;
        }
        .paylogo img {
            width: 100%;
            height: 100%;
            /* object-fit: cover;   */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="col-md-6 mx-auto">
            <form action="{{ route('url-create') }}" method="POST">
                @csrf
                <div class="row my-5">
                    <input type="hidden"  value="{{ session()->get('order_total') }}" id="amount" name="amount" placeholder="Enter your amount">
                    <input type="hidden"  value="{{ session()->get('invoice') }}" id="invoice" name="invoice" placeholder="Enter Invoice No">
                    <input type="hidden"  value="{{ session()->get('orderId') }}" id="orderId" name="orderId" placeholder="Order Id">

                    <div class="col-md-6 m-auto">
                        <button type="submit" id="bKash_button" class="paylogo">
                            <img src="{{ asset('image/bkash.png') }}" alt="">
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
