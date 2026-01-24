@extends('admin.layout')

@section('content')
<div style="height: 50px;"></div>

<h2 class="fw-bold mb-4 text-dark">My Profile</h2>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="row g-4">

    <!-- UPDATE EMAIL -->
    <div class="col-md-6">
        <div class="card card-dashboard p-4">
            <h5 class="fw-bold mb-3">Update Email</h5>

            <form method="POST" action="{{ route('admin.profile.email') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <input type="email"
                            name="email"
                            class="form-control"
                           value="{{ old('email', auth('admin')->user()->email) }}"

                            required>
                </div>

                <button class="btn btn-primary w-100">
                    Update Email
                </button>
            </form>
        </div>
    </div>

    <!-- UPDATE PASSWORD -->
    <div class="col-md-6">
        <div class="card card-dashboard p-4">
            <h5 class="fw-bold mb-3">Update Password</h5>

            <form method="POST" action="">
                @csrf

                <div class="mb-3">
                    <label class="form-label">New Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>

                <button class="btn btn-danger w-100">
                    Update Password
                </button>
            </form>
        </div>
    </div>

</div>
@endsection
