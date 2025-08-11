<x-admin::layouts>
    <x-slot:title>
        @lang('wishlist-share::admin.share-details')
    </x-slot>

    @push('styles')
        @bagistoVite([
            'src/Resources/assets/css/app.css',
            'src/Resources/assets/js/app.js'
        ], 'wishlist-share')
    @endpush

    <div class="content">
        <div class="page-header">
            <div class="page-title">
                <h1>
                    <i class="icon angle-left-icon back-link" onclick="history.length > 1 ? history.go(-1) : window.location = '{{ route('admin.wishlist-share.shares.index') }}';"></i>
                    {{ trans('wishlist-share::admin.share-details') }}
                </h1>
            </div>

            <div class="page-action">
                <a href="{{ route('wishlist-share.view', $share->share_token) }}" target="_blank" class="btn btn-lg btn-primary">
                    {{ trans('wishlist-share::admin.view-public-page') }}
                </a>
                
                <button class="btn btn-lg btn-danger" onclick="deleteShare()">
                    {{ trans('wishlist-share::admin.delete-share') }}
                </button>
            </div>
        </div>

        <div class="row">
            <!-- Share Information -->
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ trans('wishlist-share::admin.share-information') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="info-group">
                                    <label>{{ trans('wishlist-share::admin.title') }}</label>
                                    <p>{{ $share->title ?: trans('wishlist-share::admin.untitled') }}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="info-group">
                                    <label>{{ trans('wishlist-share::admin.status') }}</label>
                                    <p>
                                        @if($share->is_public && (!$share->expires_at || $share->expires_at->isFuture()))
                                            <span class="badge badge-success">{{ trans('wishlist-share::admin.active') }}</span>
                                        @elseif($share->expires_at && $share->expires_at->isPast())
                                            <span class="badge badge-danger">{{ trans('wishlist-share::admin.expired') }}</span>
                                        @else
                                            <span class="badge badge-secondary">{{ trans('wishlist-share::admin.private') }}</span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        @if($share->description)
                            <div class="info-group">
                                <label>{{ trans('wishlist-share::admin.description') }}</label>
                                <p>{{ $share->description }}</p>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-4">
                                <div class="info-group">
                                    <label>{{ trans('wishlist-share::admin.created-at') }}</label>
                                    <p>{{ $share->created_at->format('M d, Y H:i') }}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="info-group">
                                    <label>{{ trans('wishlist-share::admin.expires-at') }}</label>
                                    <p>
                                        @if($share->expires_at)
                                            {{ $share->expires_at->format('M d, Y H:i') }}
                                        @else
                                            {{ trans('wishlist-share::admin.never') }}
                                        @endif
                                    </p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="info-group">
                                    <label>{{ trans('wishlist-share::admin.view-count') }}</label>
                                    <p><span class="badge badge-primary">{{ $share->view_count }}</span></p>
                                </div>
                            </div>
                        </div>

                        <div class="info-group">
                            <label>{{ trans('wishlist-share::admin.share-url') }}</label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ route('wishlist-share.view', $share->share_token) }}" readonly id="share-url">
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" onclick="copyShareUrl()">
                                        {{ trans('wishlist-share::admin.copy') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                        @if($share->shared_platforms && count($share->shared_platforms) > 0)
                            <div class="info-group">
                                <label>{{ trans('wishlist-share::admin.shared-on-platforms') }}</label>
                                <div class="platform-badges">
                                    @foreach($share->shared_platforms as $platform)
                                        <span class="badge badge-info platform-badge">
                                            {{ ucfirst($platform) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Wishlist Items -->
                <div class="card">
                    <div class="card-header">
                        <h4>{{ trans('wishlist-share::admin.wishlist-items') }} ({{ $share->items->count() }})</h4>
                    </div>
                    <div class="card-body">
                        @if($share->items->count() > 0)
                            <div class="row">
                                @foreach($share->items as $item)
                                    @if($item->product)
                                        <div class="col-md-6 col-lg-4 mb-4">
                                            <div class="product-card">
                                                <div class="product-image">
                                                    <img src="{{ $item->product->base_image->small_image_url ?? bagisto_asset('images/product-placeholders/front.svg') }}" 
                                                         alt="{{ $item->product->name }}" 
                                                         class="img-fluid">
                                                </div>
                                                <div class="product-info">
                                                    <h6 class="product-name">{{ $item->product->name }}</h6>
                                                    <div class="product-price">
                                                        {!! $item->product->price_html !!}
                                                    </div>
                                                    @if($item->product_options && count($item->product_options))
                                                        <div class="product-options">
                                                            @foreach($item->product_options as $key => $value)
                                                                <small class="text-muted">{{ ucfirst($key) }}: {{ $value }}</small><br>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                    <div class="product-actions mt-2">
                                                        <a href="{{ route('admin.catalog.products.edit', $item->product->id) }}" class="btn btn-sm btn-primary">
                                                            {{ trans('wishlist-share::admin.edit-product') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        @else
                            <div class="empty-state">
                                <p>{{ trans('wishlist-share::admin.no-items-in-wishlist') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ trans('wishlist-share::admin.customer-information') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="customer-info">
                            <div class="customer-avatar">
                                <div class="avatar-placeholder">
                                    {{ strtoupper(substr($share->customer->first_name, 0, 1)) }}{{ strtoupper(substr($share->customer->last_name, 0, 1)) }}
                                </div>
                            </div>
                            <div class="customer-details">
                                <h5>{{ $share->customer->first_name }} {{ $share->customer->last_name }}</h5>
                                <p class="text-muted">{{ $share->customer->email }}</p>
                                
                                <div class="customer-stats">
                                    <div class="stat-item">
                                        <label>{{ trans('wishlist-share::admin.customer-since') }}</label>
                                        <span>{{ $share->customer->created_at->format('M Y') }}</span>
                                    </div>
                                    <div class="stat-item">
                                        <label>{{ trans('wishlist-share::admin.total-shares') }}</label>
                                        <span>{{ $share->customer->wishlistShares()->count() }}</span>
                                    </div>
                                </div>

                                <div class="customer-actions mt-3">
                                    <a href="{{ route('admin.customers.edit', $share->customer->id) }}" class="btn btn-primary btn-sm">
                                        {{ trans('wishlist-share::admin.view-customer') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- QR Code -->
                <div class="card">
                    <div class="card-header">
                        <h4>{{ trans('wishlist-share::admin.qr-code') }}</h4>
                    </div>
                    <div class="card-body text-center">
                        <img src="{{ route('wishlist-share.qr', $share->share_token) }}" 
                             alt="QR Code" 
                             class="qr-code img-fluid">
                        <p class="text-muted mt-2">{{ trans('wishlist-share::admin.qr-code-description') }}</p>
                        <a href="{{ route('wishlist-share.qr', $share->share_token) }}" 
                           download="wishlist-qr-{{ $share->id }}.png" 
                           class="btn btn-outline-primary btn-sm">
                            {{ trans('wishlist-share::admin.download-qr') }}
                        </a>
                    </div>
                </div>

                <!-- Share Statistics -->
                <div class="card">
                    <div class="card-header">
                        <h4>{{ trans('wishlist-share::admin.statistics') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="stats-list">
                            <div class="stat-row">
                                <span class="stat-label">{{ trans('wishlist-share::admin.total-views') }}</span>
                                <span class="stat-value">{{ $share->view_count }}</span>
                            </div>
                            <div class="stat-row">
                                <span class="stat-label">{{ trans('wishlist-share::admin.total-items') }}</span>
                                <span class="stat-value">{{ $share->items->count() }}</span>
                            </div>
                            <div class="stat-row">
                                <span class="stat-label">{{ trans('wishlist-share::admin.days-active') }}</span>
                                <span class="stat-value">
                                    @if($share->expires_at)
                                        {{ $share->created_at->diffInDays($share->expires_at) }}
                                    @else
                                        ∞
                                    @endif
                                </span>
                            </div>
                            @if($share->expires_at)
                                <div class="stat-row">
                                    <span class="stat-label">{{ trans('wishlist-share::admin.days-remaining') }}</span>
                                    <span class="stat-value">
                                        @if($share->expires_at->isFuture())
                                            {{ now()->diffInDays($share->expires_at) }}
                                        @else
                                            0
                                        @endif
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
    function copyShareUrl() {
        const shareUrlInput = document.getElementById('share-url');
        shareUrlInput.select();
        shareUrlInput.setSelectionRange(0, 99999);
        
        try {
            document.execCommand('copy');
            alert('{{ trans("wishlist-share::admin.url-copied") }}');
        } catch (err) {
            console.error('Failed to copy URL:', err);
        }
    }

    function deleteShare() {
        if (confirm('{{ trans("wishlist-share::admin.confirm-delete-share") }}')) {
            fetch('{{ route("admin.wishlist-share.shares.destroy", $share->id) }}', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    window.location.href = '{{ route("admin.wishlist-share.shares.index") }}';
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('{{ trans("wishlist-share::admin.error-occurred") }}');
            });
        }
    }
</script>
@endpush

@push('css')
<style>
    .info-group {
        margin-bottom: 20px;
    }

    .info-group label {
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
        display: block;
    }

    .info-group p {
        margin: 0;
        color: #666;
    }

    .platform-badges .platform-badge {
        margin-right: 5px;
        margin-bottom: 5px;
    }

    .product-card {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 15px;
        height: 100%;
        transition: box-shadow 0.2s;
    }

    .product-card:hover {
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    .product-image {
        text-align: center;
        margin-bottom: 10px;
    }

    .product-image img {
        max-height: 120px;
        object-fit: cover;
        border-radius: 4px;
    }

    .product-name {
        font-size: 0.9rem;
        font-weight: 600;
        margin-bottom: 8px;
        line-height: 1.3;
    }

    .product-price {
        font-weight: 600;
        color: #007bff;
        margin-bottom: 8px;
    }

    .product-options {
        margin-bottom: 10px;
    }

    .customer-info {
        text-align: center;
    }

    .customer-avatar {
        margin-bottom: 15px;
    }

    .avatar-placeholder {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background-color: #007bff;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 1.2rem;
        margin: 0 auto;
    }

    .customer-details h5 {
        margin-bottom: 5px;
        color: #333;
    }

    .customer-stats {
        margin: 20px 0;
        text-align: left;
    }

    .stat-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        padding-bottom: 8px;
        border-bottom: 1px solid #f0f0f0;
    }

    .stat-item:last-child {
        border-bottom: none;
        margin-bottom: 0;
    }

    .stat-item label {
        font-size: 0.85rem;
        color: #666;
        margin: 0;
    }

    .stat-item span {
        font-weight: 600;
        color: #333;
    }

    .qr-code {
        max-width: 200px;
        border: 1px solid #e9ecef;
        border-radius: 8px;
    }

    .stats-list {
        padding: 0;
    }

    .stat-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .stat-row:last-child {
        border-bottom: none;
    }

    .stat-label {
        font-size: 0.9rem;
        color: #666;
    }

    .stat-value {
        font-weight: 600;
        color: #333;
    }

    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #666;
    }

    .input-group {
        margin-bottom: 0;
    }

    .badge {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
</style>
@endpush</x-admin::layouts>
