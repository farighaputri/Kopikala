<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
    <style>
        body { font-family: sans-serif; background: #f5f5f5; margin:0; }
        .container { display:flex; justify-content:center; align-items:center; height:100vh; }
        .card { background:white; padding:2rem; border-radius:10px; box-shadow:0 4px 12px rgba(0,0,0,0.15); width:500px; text-align:center; }
        .card h2 { color:#4a2f1f; margin-bottom:1rem; }
        .card table { width:100%; border-collapse: collapse; margin:1rem 0; }
        .card table th, .card table td { border:1px solid #ddd; padding:8px; text-align:left; }
        .card table th { background:#f2f2f2; }
        .btn { display:inline-block; background:#4a2f1f; color:white; padding:0.5rem 1rem; border:none; border-radius:5px; cursor:pointer; text-decoration:none; margin-top:1rem; }
        .btn:hover { background:#3a2214; }
    </style>
</head>
<body>

<div class="container">
    <div class="card">
        <h2>Thank you for your order!</h2>
        <p>Your order has been received and is waiting confirmation.</p>

        <h3>Order #{{ $order->order_id }}</h3>
        <p>Status: <strong>{{ $order->status }}</strong></p>

        <h4>Items Ordered:</h4>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items ?? [] as $index => $item)

                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item['name'] ?? 'No Name' }}</td>
                    <td>{{ $item['quantity'] ?? 1 }}</td>
                    <td>Rp {{ number_format($item['price'] ?? 0, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1), 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">No items found</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <p><strong>Total: Rp {{ number_format($order->total, 0, ',', '.') }}</strong></p>

        <a href="{{ route('frontend.detail', $order->order_id) }}" class="btn">
            See Order Details
        </a>
    </div>
</div>

</body>
</html>
