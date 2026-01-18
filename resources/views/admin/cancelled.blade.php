@extends('admin.layout')

@section('content')
<div style="height: 50px;"></div>

<h2 class="fw-bold mb-4 text-dark">Orders</h2>

<div class="ms-2 mb-3">
    <a href="{{ route('admin.orders') }}" class="btn btn-outline-primary">Pending</a>
    <a href="{{ route('admin.completed') }}" class="btn btn-outline-primary">Completed</a>
    <a href="{{ route('admin.cancelled') }}" class="btn btn-primary">Cancelled</a>
</div>


@if($orders->isEmpty())
    <div class="card card-dashboard p-3 text-center text-muted">
        No cancelled orders.
    </div>
@else
    <div class="card card-dashboard shadow-sm p-3">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 p-3" id="cancelledOrdersTable">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Customer</th>
                        <th>Contact</th>
                        <th>Total</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>{{ $order->contact_number }}</td>
                            <td>₱{{ number_format($order->total_amount, 2) }}</td>
                            <td>{{ $order->created_at->format('M d, Y') }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#orderModal{{ $order->id }}">
                                    View Details
                                </button>
                            </td>
                        </tr>

                        <!-- ORDER DETAILS MODAL -->
                        <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1" aria-labelledby="orderModalLabel{{ $order->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="orderModalLabel{{ $order->id }}">
                                            Order #{{ $order->id }} Details
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <p><strong>Customer:</strong> {{ $order->customer_name }}</p>
                                        <p><strong>Contact:</strong> {{ $order->contact_number }}</p>
                                        <p><strong>Address:</strong> {{ $order->address ?? 'No address' }}</p>
                                        <p><strong>Order Type:</strong>
                                            <span class="badge {{ $order->order_type === 'delivery' ? 'bg-warning text-dark' : 'bg-info' }}">
                                                {{ ucfirst($order->order_type) }}
                                            </span>
                                            <span class="badge bg-success">{{ ucfirst($order->payment_mode) }}</span>
                                        </p>
                                        <p><strong>Status:</strong>
                                            @if($order->status === 'completed')
                                                <span class="badge bg-success">Completed</span>
                                            @else
                                                <span class="badge bg-danger">Cancelled</span>
                                            @endif
                                        </p>

                                        <hr>
                                        <h6>Items:</h6>
                                        <div class="list-group mb-2">
                                            @foreach($order->items as $item)
                                                <div class="d-flex justify-content-between small list-group-item">
                                                    <span>{{ $item->item_name }} × {{ $item->quantity }}</span>
                                                    <span>₱{{ number_format($item->subtotal, 2) }}</span>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="d-flex justify-content-between fw-bold">
                                            <span>Total</span>
                                            <span>₱{{ number_format($order->total_amount, 2) }}</span>
                                        </div>

                                        @if($order->message)
                                            <div class="mt-2"><strong>Message:</strong> "{{ $order->message }}"</div>
                                        @endif

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif




<script>
    $(document).ready(function () {

        let completedTable = $('#completedOrdersTable').DataTable({
            ordering: true,
            order: [[0, 'desc']]
        });

        let cancelledTable = $('#cancelledOrdersTable').DataTable({
            ordering: true,
            order: [[0, 'desc']]
        });

        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function () {
            completedTable.columns.adjust();
            cancelledTable.columns.adjust();
        });

    });
</script>





@endsection
