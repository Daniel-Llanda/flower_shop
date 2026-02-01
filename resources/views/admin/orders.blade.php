@extends('admin.layout')

@section('content')
<div style="height: 50px;"></div>

<h2 class="fw-bold mb-4" style="color: #064e3b;">Orders</h2>

<div class="ms-2 mb-3">
    <a href="{{ route('admin.orders') }}" class="btn btn-success">Pending</a>
    <a href="{{ route('admin.completed') }}" class="btn btn-outline-success">Completed</a>
    <a href="{{ route('admin.cancelled') }}" class="btn btn-outline-success">Cancelled</a>
</div>

@if($pendingOrders->isEmpty())
    <div class="card card-dashboard p-3 text-center text-muted">
        No pending orders.
    </div>
@else
    <div class="row g-4">
        @foreach($pendingOrders as $order)
            <div class="col-md-6 col-lg-4">

                <div class="accordion" id="accordion{{ $order->id }}">
                    <div class="accordion-item border-0 shadow-sm rounded">
                        <h2 class="accordion-header" id="heading{{ $order->id }}">
                            <button class="accordion-button collapsed fw-semibold"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $order->id }}"
                                    aria-expanded="false">
                                <strong>{{ $order->customer_name }}</strong>
                                <!-- <span>Order #{{ $order->id }}</span> -->
                                <span class="badge bg-warning text-dark ms-auto">Pending</span>
                            </button>
                        </h2>

                        <div id="collapse{{ $order->id }}" class="accordion-collapse collapse">
                            <div class="accordion-body">

                                <!-- CUSTOMER INFO -->
                                <div class="mb-2">
                                    <strong>{{ $order->customer_name }}</strong><br>
                                    <small>{{ $order->contact_number }}</small><br>
                                    <small class="text-muted">{{ $order->address ?? 'No address' }}</small>
                                </div>

                                <!-- ORDER TYPE -->
                                <div class="mb-2">
                                    <span class="badge {{ $order->order_type === 'delivery' ? 'bg-warning text-dark' : 'bg-info' }}">
                                        {{ ucfirst($order->order_type) }}
                                    </span>
                                    <span class="badge bg-success">
                                        {{ ucfirst($order->payment_mode) }}
                                    </span>
                                </div>

                                <!-- ITEMS -->
                                <div class="border-top pt-2 mt-3">
                                    @foreach($order->items as $item)
                                        <div class="d-flex justify-content-between small">
                                            <span>{{ $item->item_name }} × {{ $item->quantity }}</span>
                                            <span>₱{{ number_format($item->subtotal, 2) }}</span>
                                        </div>
                                    @endforeach
                                </div>

                                <hr>

                                <!-- TOTAL -->
                                <div class="d-flex justify-content-between fw-bold">
                                    <span>Total</span>
                                    <span>₱{{ number_format($order->total_amount, 2) }}</span>
                                </div>
                                @if($order->message)
                                    <div class="small text-muted mb-2">
                                        Message: "{{ $order->message }}"
                                    </div>
                                @endif

                                <!-- DATE -->
                                <div class="small text-muted mt-2">
                                    {{ $order->created_at->format('M d, Y h:i A') }}
                                </div>

                                <!-- ACTIONS -->
                                <div class="d-flex gap-2 mt-3 justify-content-between">
                                    <form method="POST" action="{{ route('admin.orders.cancel', $order->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-outline-danger">
                                            Cancel Order
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.orders.complete', $order->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-success">
                                            Mark as Completed
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        @endforeach
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
