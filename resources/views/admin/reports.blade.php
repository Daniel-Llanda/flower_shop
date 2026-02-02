@extends('admin.layout')

@section('content')
<div style="height: 50px;"></div>

<h2 class="fw-bold mb-4" style="color:#064e3b;">Reports</h2>

<!-- SUMMARY BOXES -->
<div class="row mb-4">

    <div class="col-md-4">
        <div class="card p-3 text-center border-warning">
            <h6 class="text-warning fw-bold">Pending Orders</h6>
            <h2 class="fw-bold">{{ $counts['pending'] }}</h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3 text-center border-success">
            <h6 class="text-success fw-bold">Completed Orders</h6>
            <h2 class="fw-bold">{{ $counts['completed'] }}</h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card p-3 text-center border-danger">
            <h6 class="text-danger fw-bold">Cancelled Orders</h6>
            <h2 class="fw-bold">{{ $counts['cancelled'] }}</h2>
        </div>
    </div>

</div>

<!-- FILTER FORM -->
<div class="card card-dashboard p-4 mb-4">
    <form method="GET" action="{{ route('admin.reports') }}">
        <div class="row g-3 align-items-end">

            <div class="col-md-4">
                <label class="form-label fw-semibold">Order Status</label>
                <select name="status" class="form-select">
                    <option value="">Select Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">From</label>
                <input type="date" name="from" class="form-control" value="{{ request('from') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label fw-semibold">To</label>
                <input type="date" name="to" class="form-control" value="{{ request('to') }}">
            </div>

            <div class="col-md-2">
                <button class="btn btn-success w-100">
                    Filter
                </button>
            </div>

        </div>
    </form>
</div>
<!-- ONLY SHOW RESULTS IF FILTER IS USED -->
@if(request()->hasAny(['status', 'from', 'to']))

    <div class="card card-dashboard p-4">
        @if(request('from') && request('to'))
            <div class="mb-3 text-muted">
                <strong>Date Range:</strong>
                {{ \Carbon\Carbon::parse(request('from'))->format('M d, Y') }}
                –
                {{ \Carbon\Carbon::parse(request('to'))->format('M d, Y') }}
            </div>
        @endif


        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0">Filtered Orders</h5>

            <!-- DOWNLOAD PDF BUTTON -->
            <a href="{{ route('admin.reports.pdf', request()->query()) }}"
               class="btn btn-sm btn-primary">
                <i class="bi bi-file-earmark-pdf"></i> Download PDF
            </a>
        </div>

        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Customer</th>
                    <th>Status</th>
                    <th>Total</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>
                            <span class="badge
                                @if($order->status == 'completed') bg-success
                                @elseif($order->status == 'pending') bg-warning
                                @else bg-danger @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>₱{{ number_format($order->total_amount, 2) }}</td>
                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            No results found for selected filters
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endif


@endsection
