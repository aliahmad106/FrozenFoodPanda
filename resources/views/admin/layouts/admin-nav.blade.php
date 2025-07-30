<li>
    <a class="dropdown-item" href="{{ route('admin.products') }}">
        <i class="fas fa-box me-2"></i>Manage Products
    </a>
</li>
<li>
    <a class="dropdown-item" href="{{ route('admin.analytics') }}">
        <i class="fas fa-chart-bar me-2"></i>Analytics
    </a>
</li>
<li>
    <a class="dropdown-item" href="{{ route('admin.orders.index') }}">
        <i class="fas fa-shopping-bag me-2"></i>Manage Orders
    </a>
</li>
<li>
    <a class="dropdown-item {{ Request::is('admin/reviews*') ? 'active' : '' }}" href="{{ route('admin.reviews.index') }}">
        <i class="fas fa-star me-2"></i>Manage Reviews
        @isset($pendingReviewsCount)
            @if($pendingReviewsCount > 0)
                <span class="badge badge-danger">{{ $pendingReviewsCount }}</span>
            @endif
        @endisset
    </a>
</li>