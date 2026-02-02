<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Orders Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background: #f2f2f2; }
        h2 { margin-bottom: 10px; }
    </style>
</head>
<body>

<h2>Filtered Orders Report</h2>
@if($from && $to)
    <p>
        <strong>Date Range:</strong>
        {{ \Carbon\Carbon::parse($from)->format('M d, Y') }}
        –
        {{ \Carbon\Carbon::parse($to)->format('M d, Y') }}
    </p>
@endif


<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Customer</th>
            <th>Status</th>
            <th>Total</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>₱{{ number_format($order->total_amount, 2) }}</td>
                <td>{{ $order->created_at->format('M d, Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
