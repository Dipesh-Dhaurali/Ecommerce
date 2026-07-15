<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt #{{ $order->id }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            background: #fff;
            color: #000;
            padding: 20px;
        }
        .receipt {
            max-width: 400px;
            margin: 0 auto;
        }
        .receipt-header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px dashed #000;
        }
        .receipt-header h1 {
            font-size: 24px;
            margin-bottom: 5px;
        }
        .receipt-header p {
            font-size: 12px;
            color: #666;
        }
        .receipt-details {
            margin-bottom: 15px;
            font-size: 14px;
        }
        .receipt-details div {
            margin-bottom: 5px;
        }
        .receipt-items {
            width: 100%;
            margin-bottom: 20px;
        }
        .receipt-items th,
        .receipt-items td {
            font-size: 13px;
            padding: 5px 0;
            text-align: left;
        }
        .receipt-items .price {
            text-align: right;
        }
        .receipt-total {
            border-top: 2px dashed #000;
            padding-top: 10px;
            margin-top: 10px;
        }
        .receipt-total div {
            display: flex;
            justify-content: space-between;
            font-size: 14px;
            margin-bottom: 5px;
        }
        .receipt-total .grand-total {
            font-weight: bold;
            font-size: 16px;
        }
        .receipt-footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px dashed #000;
            font-size: 12px;
            color: #666;
        }
        @media print {
            body {
                padding: 0;
            }
            .receipt {
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="receipt">
        <div class="receipt-header">
            <h1>E-Mart</h1>
            <p>Your One-Stop Shop</p>
            <p>123 Main Street, City</p>
        </div>

        <div class="receipt-details">
            <div><strong>Receipt #:</strong> {{ $order->id }}</div>
            <div><strong>Date:</strong> {{ $order->created_at->format('F j, Y, g:i a') }}</div>
            <div><strong>Order Type:</strong> {{ ucfirst($order->order_type) }}</div>
            <div><strong>Customer:</strong> {{ $order->customer_name }}</div>
            @if($order->customer_phone)
                <div><strong>Phone:</strong> {{ $order->customer_phone }}</div>
            @endif
        </div>

        <table class="receipt-items">
            <thead>
                <tr>
                    <th>Item</th>
                    <th class="price">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>
                            {{ $item->inventory->name }}<br>
                            <span style="font-size: 12px; color: #666;">{{ $item->quantity }} × Rs. {{ number_format($item->price, 2) }}</span>
                        </td>
                        <td class="price">Rs. {{ number_format($item->total, 2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="receipt-total">
            <div>
                <span>Subtotal</span>
                <span>Rs. {{ number_format($order->subtotal, 2) }}</span>
            </div>
            <div class="grand-total">
                <span>Total</span>
                <span>Rs. {{ number_format($order->total, 2) }}</span>
            </div>
        </div>

        <div class="receipt-footer">
            <p>Thank you for your purchase!</p>
            <p>Have a great day!</p>
        </div>
    </div>

    <script>
        window.addEventListener('load', function() {
            window.print();
        });
    </script>
</body>
</html>