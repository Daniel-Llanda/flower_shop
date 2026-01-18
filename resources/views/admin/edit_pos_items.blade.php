@extends('admin.layout')

@section('content')
<div style="height: 50px;"></div>
<div class="d-flex justify-content-between align-items-center">
    <h2 class="fw-bold" style="color:#8b4d6b;">Edit POS Items</h2>
    <a class="btn btn-outline-primary" href="{{ route('admin.dashboard') }}">Back</a>
</div>


<div class="card card-dashboard p-4">
    <p class="text-muted">Manage your POS items here.</p>

    @if($posItems->isEmpty())
        <div class="alert alert-warning text-center">
            No POS items found.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="posItemsTable">
                <thead class="table-light">
                    <tr>
                        <th>Item Name</th>
                        <th>Price (₱)</th>
                        <th>Category</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posItems as $item)
                        <tr>
                            <td>{{ $item->item_name }}</td>
                            <td>₱{{ number_format($item->item_price, 2) }}</td>
                            <td>
                                @php
                                    $colorNames = [
                                        'primary' => 'Blue',
                                        'secondary' => 'Gray',
                                        'success' => 'Green',
                                        'danger' => 'Red',
                                        'warning' => 'Yellow',
                                        'info' => 'Cyan',
                                        'dark' => 'Black',
                                    ];
                                    $color = $item->item_color ?? 'secondary';
                                @endphp

                                <span class="badge bg-{{ $color }}">
                                    {{ $colorNames[$color] ?? 'Default' }}
                                </span>
                            </td>
                            <td>
                                <button
                                    class="btn btn-sm btn-primary editBtn"
                                    data-id="{{ $item->id }}"
                                    data-name="{{ $item->item_name }}"
                                    data-price="{{ $item->item_price }}"
                                    data-type="{{ $item->item_type }}"
                                    data-color="{{ $item->item_color }}"
                                >

                                    <i class="bi bi-pencil-square"></i> Edit
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @endif
</div>

<div class="modal fade" id="editPosItemModal" tabindex="-1">
    <div class="modal-dialog modal-md">
        <form method="POST" id="editForm">
            @csrf
            @method('PUT')
            <input type="hidden" id="updateRoute" value="{{ route('pos-items.update', ':id') }}">


            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit POS Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Item Name</label>
                        <input type="text" name="item_name" id="editItemName" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Price (₱)</label>
                        <input type="number" step="0.01" name="item_price" id="editItemPrice" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Item Type</label>
                        <select name="item_type" id="editItemType" class="form-select">
                            <option value="bundle">Bundle</option>
                            <option value="per_stem">Per Stem</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Category Color</label>
                        <select name="item_color" id="editItemColor" class="form-select">
                            <option value="primary">Primary (Blue)</option>
                            <option value="secondary">Secondary (Gray)</option>
                            <option value="success">Success (Green)</option>
                            <option value="danger">Danger (Red)</option>
                            <option value="warning">Warning (Yellow)</option>
                            <option value="info">Info (Cyan)</option>
                            <option value="dark">Dark (Black)</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-success">Update Item</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('#posItemsTable').DataTable({
            ordering: true,
            order: [[0, 'desc']],
        });

        $('.editBtn').on('click', function () {
            let id = $(this).data('id');

            $('#editItemName').val($(this).data('name'));
            $('#editItemPrice').val($(this).data('price'));
            $('#editItemType').val($(this).data('type')); // ✅ FIXED
            $('#editItemColor').val($(this).data('color'));

            let route = $('#updateRoute').val().replace(':id', id);
            $('#editForm').attr('action', route);

            new bootstrap.Modal(document.getElementById('editPosItemModal')).show();
        });

    });
</script>

@endsection

