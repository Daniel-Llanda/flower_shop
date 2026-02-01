@extends('admin.layout')

@section('content')
<div style="height: 50px;"></div>
<h2 class="fw-bold mb-4" style="color:#064e3b;">Users</h2>

<div class="card card-dashboard p-4">

    @if($users->isEmpty())
        <div class="alert alert-warning text-center">
            No users found.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle" id="userTable">
                <thead class="table-light">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th width="120">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <button type="submit" class="btn btn-primary btn-sm">View</button>
                            </td>
       
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    @endif
</div>

<script>
    $(document).ready(function () {
        $('#userTable').DataTable({
            ordering: true,
            order: [[0, 'desc']],
        });
    });
</script>
@endsection
