<div class="sidebar bg-light" style="min-height: 100vh;">
    <div class="p-3">
        <h5>Admin Panel</h5>
        <hr>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" href="{{ route('admin.users') }}">
                    <i class="fas fa-users me-2"></i> User Management
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('attendance.*') ? 'active' : '' }}" href="{{ route('attendance.index') }}">
                    <i class="fas fa-calendar-check me-2"></i> Attendance
                </a>
            </li>
        </ul>
    </div>
</div>