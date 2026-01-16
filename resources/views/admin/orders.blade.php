@extends('admin.layout')

@section('content')
<div style="height: 50px;"></div>

<h2 class="fw-bold mb-4 text-dark">Orders</h2>

{{-- ================= PENDING ORDERS (CARDS) ================= --}}
<h5 class="fw-semibold mb-3">Pending Orders</h5>


@if($pendingOrders->isEmpty())
    <div class="card card-dashboard p-3 text-center text-muted mb-4">
        No pending orders.
    </div>
@else
    <div class="row g-4 mb-5">
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




{{-- ================= COMPLETED & CANCELLED (TABLE) ================= --}}
<h5 class="fw-semibold mb-3">Completed & Cancelled Orders</h5>

@if($otherOrders->isEmpty())
    <div class="card card-dashboard p-3 text-center text-muted">
        No completed or cancelled orders.
    </div>
@else
    <div class="card card-dashboard shadow-sm p-3">

        <!-- Nav Tabs -->
        <ul class="nav nav-tabs mb-3" id="orderStatusTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="completed-tab" data-bs-toggle="tab"
                        data-bs-target="#completed" type="button" role="tab"
                        aria-controls="completed" aria-selected="true">
                    Completed
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="cancelled-tab" data-bs-toggle="tab"
                        data-bs-target="#cancelled" type="button" role="tab"
                        aria-controls="cancelled" aria-selected="false">
                    Cancelled
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="orderStatusTabsContent">

            <!-- COMPLETED ORDERS -->
            <div class="tab-pane fade show active" id="completed" role="tabpanel" aria-labelledby="completed-tab">
                @php
                    $completedOrders = $otherOrders->where('status', 'completed');
                @endphp

                @if($completedOrders->isEmpty())
                    <div class="text-center text-muted py-3">No completed orders.</div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0 p-3" id="completedOrdersTable">
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
                                @foreach($completedOrders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->customer_name }}</td>
                                        <td>{{ $order->contact_number }}</td>
                                        <td>₱{{ number_format($order->total_amount, 2) }}</td>
                                        <td>{{ $order->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <!-- VIEW DETAILS BUTTON -->
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
                @endif
            </div>

            <!-- CANCELLED ORDERS -->
            <div class="tab-pane fade" id="cancelled" role="tabpanel" aria-labelledby="cancelled-tab">
                @php
                    $cancelledOrders = $otherOrders->where('status', 'cancelled');
                @endphp

                @if($cancelledOrders->isEmpty())
                    <div class="text-center text-muted py-3">No cancelled orders.</div>
                @else
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
                                @foreach($cancelledOrders as $order)
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
                @endif
            </div>

        </div>

    </div>
@endif

{{-- DATATABLES JS --}}



    <script>
        $(document).ready(function() {
            $('#completedOrdersTable').DataTable({
                ordering: true,
                order: [[0, 'desc']],
            });
            $('#cancelledOrdersTable').DataTable({
                ordering: true,
                order: [[0, 'desc']],
            });
        });
    </script>




@endsection
