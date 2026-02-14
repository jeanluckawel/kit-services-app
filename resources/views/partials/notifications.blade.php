<li class="nav-item dropdown">
    <a class="nav-link" data-bs-toggle="dropdown" href="#">
        <i class="bi bi-bell-fill"></i>
        @if($unreadCount > 0)
            <span class="navbar-badge badge text-bg-warning">{{ $unreadCount }}</span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
        <span class="dropdown-item dropdown-header">{{ $unreadCount }} Notifications</span>
        <div class="dropdown-divider"></div>

        @forelse($notifications as $notification)
            <a href="#" class="dropdown-item">
                <i class="bi bi-person-plus-fill me-2"></i>
                {{ $notification->data['message'] ?? '' }}
                <span class="float-end text-secondary fs-7">{{ $notification->created_at->diffForHumans() }}</span>
            </a>
            <div class="dropdown-divider"></div>
        @empty
            <span class="dropdown-item text-center text-secondary">Pas de notifications</span>
        @endforelse

        <a href="{{ route('notifications.index') }}" class="dropdown-item dropdown-footer">Voir toutes les notifications</a>
    </div>
</li>
