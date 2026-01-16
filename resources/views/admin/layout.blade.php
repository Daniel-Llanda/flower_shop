<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>EveryDhay Admin Dashboard</title>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
            background-color: #fff0f6; /* soft pink background */
        }

        /* Sidebar */
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            padding-top: 56px; /* navbar height */
            background-color: #ffe6f0; /* pastel pink */
            width: 220px;
            box-shadow: 2px 0 8px rgba(0,0,0,0.05);
        }

        .sidebar .nav-link {
            color: #8b4d6b;
            font-weight: 500;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            border-radius: 8px;
            margin: 4px 10px;
        }

        .sidebar .nav-link.active,
        .sidebar .nav-link:hover {
            background-color: #f9c1d9; /* soft hover */
            color: #fff;
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        /* Main content */
        .content {
            margin-left: 220px;
            padding: 20px;
        }

   /* Hide text and show only icons on tablets */
@media (min-width: 768px) and (max-width: 991.98px) {
    .sidebar {
        width: 80px; /* narrow sidebar for icons only */
        text-align: center;
        padding-top: 56px;
    }

    .sidebar .nav-link {
        justify-content: center;
        padding: 12px 0;
    }

    .sidebar .nav-link i {
        margin-right: 0;
        font-size: 1.5rem;
    }

    .sidebar .nav-text {
        display: none;
    }

    .content {
        margin-left: 80px; /* match sidebar width */
    }
}

/* Full sidebar on desktop */
@media (min-width: 992px) {
    .sidebar {
        width: 220px;
    }

    .sidebar .nav-text {
        display: inline;
    }

    .content {
        margin-left: 220px;
    }
}

        /* Cards */
        .card-dashboard {
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(0,0,0,0.05);
        }

        .card-pink {
            background: linear-gradient(135deg, #f9c1d9, #ffcce3);
            color: #5a2a3c;
        }

        .card-purple {
            background: linear-gradient(135deg, #d8b4f8, #e9d5ff);
            color: #4b1f6d;
        }

        .card-yellow {
            background: linear-gradient(135deg, #fff4e6, #ffe8cc);
            color: #a6631b;
        }

        .navbar-custom {
            background-color: #ff66a3; /* pastel magenta */
        }

        .navbar-custom .navbar-brand,
        .navbar-custom .btn-outline-light {
            color: #fff;
        }
    </style>
</head>
<body>

    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">EveryDhay Admin</a>
            <div class="ms-auto">
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="btn btn-outline-light btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
<!-- Sidebar -->
<div class="sidebar d-none d-md-block">
    <ul class="nav flex-column pt-3">

        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
               href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2"></i>
                <span class="nav-text">Dashboard</span>
            </a>
        </li>

        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->routeIs('admin.users') ? 'active' : '' }}"
               href="{{ route('admin.users') }}">
                <i class="bi bi-people"></i>
                <span class="nav-text">Users</span>
            </a>
        </li>

        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->routeIs('admin.orders') ? 'active' : '' }}"
               href="{{ route('admin.orders') }}">
                <i class="bi bi-basket"></i>
                <span class="nav-text">Orders</span>
            </a>
        </li>

        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->routeIs('admin.flowers') ? 'active' : '' }}"
               href="{{ route('admin.flowers') }}">
                <i class="bi bi-flower1"></i>
                <span class="nav-text">Flowers</span>
            </a>
        </li>

        <li class="nav-item mb-1">
            <a class="nav-link {{ request()->routeIs('admin.reports') ? 'active' : '' }}"
               href="{{ route('admin.reports') }}">
                <i class="bi bi-file-earmark-text"></i>
                <span class="nav-text">Reports</span>
            </a>
        </li>

    </ul>
</div>




    <div class="content">
        @yield('content')
    </div>


    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
