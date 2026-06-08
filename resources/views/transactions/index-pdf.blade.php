<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 4px; }
        th { background: #eee; }
    </style>
</head>
<body>

<h3>Transaction Report</h3>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Order ID</th>
            <th>Customer</th>
            <th>Qty</th>
            <th>Status</th>
            <th>Branch</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($transactions as $i => $trx)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $trx->order_id }}</td>
            <td>{{ $trx->customer_name }}</td>
            <td>{{ $trx->quantity }}</td>
            <td>{{ $trx->status }}</td>
            <td>{{ optional($trx->branch)->branch_name }}</td>
            <td>{{ number_format($trx->total) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
