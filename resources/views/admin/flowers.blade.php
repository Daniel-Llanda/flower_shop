@extends('admin.layout')

@section('content')
<div style="height: 50px;"></div>
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold" style="color:#064e3b;">Flowers</h2>
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addFlowerModal">
        + Add Flower
    </button>
</div>

@if($flowers->isEmpty())
    <div class="alert alert-info text-center">
        No flowers yet. Click <strong>“Add Flower”</strong> to get started.
    </div>
@else
<div class="card card-dashboard p-4">
    <table class="table table-bordered align-middle" id="flowerTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Description</th>
                <th width="140">Action</th>
            </tr>
        </thead>

        <tbody>
            @forelse($flowers as $flower)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($flower->image)
                            <img src="{{ asset('storage/'.$flower->image) }}" width="60">
                        @endif
                    </td>
                    <td>{{ $flower->name }}</td>
                    <td>₱{{ number_format($flower->price, 2) }}</td>
                    <td>{{ $flower->description }}</td>
                    <td>
                        <button
                            class="btn btn-sm btn-primary editFlowerBtn"
                            data-id="{{ $flower->id }}"
                            data-name="{{ $flower->name }}"
                            data-price="{{ $flower->price }}"
                            data-description="{{ $flower->description }}"
                        >
                            <i class="bi bi-pencil-square"></i>
                        </button>

                        <button
                            class="btn btn-sm btn-danger deleteFlowerBtn"
                            data-id="{{ $flower->id }}"
                            data-name="{{ $flower->name }}"
                        >
                            <i class="bi bi-trash"></i>
                        </button>

                        <form id="delete-flower-{{ $flower->id }}"
                            action="{{ route('admin.flowers.destroy', $flower->id) }}"
                            method="POST"
                            class="d-none">
                            @csrf
                            @method('DELETE')
                        </form>
                        <form action="{{ route('admin.flowers.toggle', $flower->id) }}"
                            method="POST"
                            class="d-inline">
                            @csrf
                            @method('PATCH')

                            <button
                                type="submit"
                                class="btn btn-sm {{ $flower->is_visible ? 'btn-secondary' : 'btn-success' }}"
                                title="{{ $flower->is_visible ? 'Hide Flower' : 'Unhide Flower' }}"
                            >
                                @if($flower->is_visible)
                                    <i class="bi bi-eye-slash"></i>
                                @else
                                    <i class="bi bi-eye"></i>
                                @endif
                            </button>
                        </form>

                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="5" class="text-center">No flowers yet</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endif



<div class="modal fade" id="addFlowerModal">
    <div class="modal-dialog">
        <form method="POST" action="{{ route('admin.flowers.store') }}" enctype="multipart/form-data" class="modal-content">
            @csrf

            <div class="modal-header">
                <h5 class="modal-title">Add Flower</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">Flower Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" step="0.01" name="price" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Short Description</label>
                    <textarea name="description" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Flower Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-success">Save</button>
            </div>

        </form>
    </div>
</div>

<div class="modal fade" id="editFlowerModal">
    <div class="modal-dialog">
        <form method="POST" id="editFlowerForm" enctype="multipart/form-data" class="modal-content">
            @csrf
            @method('PUT')

            <input type="hidden" id="editRoute" value="{{ route('admin.flowers.update', ':id') }}">

            <div class="modal-header">
                <h5 class="modal-title">Edit Flower</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <div class="mb-3">
                    <label class="form-label">Flower Name</label>
                    <input type="text" name="name" id="editName" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" step="0.01" name="price" id="editPrice" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Short Description</label>
                    <textarea name="description" id="editDescription" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Change Image (optional)</label>
                    <input type="file" name="image" class="form-control">
                </div>

            </div>

            <div class="modal-footer">
                <button class="btn btn-success">Update</button>
            </div>
        </form>
    </div>
</div>


<script>
    $(document).ready(function () {

        $('#flowerTable').DataTable({
            ordering: true,
            order: [[0, 'desc']],
        });

        // EDIT
        $('.editFlowerBtn').on('click', function () {
            let id = $(this).data('id');

            $('#editName').val($(this).data('name'));
            $('#editPrice').val($(this).data('price'));
            $('#editDescription').val($(this).data('description'));

            let route = $('#editRoute').val().replace(':id', id);
            $('#editFlowerForm').attr('action', route);

            new bootstrap.Modal(document.getElementById('editFlowerModal')).show();
        });

        // DELETE
        $('.deleteFlowerBtn').on('click', function () {
            let id = $(this).data('id');
            let name = $(this).data('name');

            Swal.fire({
                title: 'Are you sure?',
                text: `Delete "${name}" permanently?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-flower-${id}`).submit();
                }
            });
        });

    });
</script>

@endsection
