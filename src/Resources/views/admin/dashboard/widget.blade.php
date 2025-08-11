<div class="wishlist-share-widget">
    <div class="widget-header">
        <h4>
            <i class="icon share-icon"></i>
            {{ trans('wishlist-share::admin.wishlist-share') }}
        </h4>
        <a href="{{ route('admin.wishlist-share.analytics.index') }}" class="widget-link">
            {{ trans('wishlist-share::admin.view-analytics') }}
        </a>
    </div>

    <div class="widget-content" id="wishlist-share-widget-content">
        <div class="loading-state">
            <div class="spinner"></div>
            <p>{{ trans('wishlist-share::admin.loading') }}</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadWishlistShareWidget();
});

function loadWishlistShareWidget() {
    fetch('{{ route("admin.wishlist-share.dashboard.widget") }}')
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                renderWishlistShareWidget(data.data);
            } else {
                showWidgetError();
            }
        })
        .catch(error => {
            console.error('Error loading wishlist share widget:', error);
            showWidgetError();
        });
}

function renderWishlistShareWidget(data) {
    const content = document.getElementById('wishlist-share-widget-content');
    
    content.innerHTML = `
        <div class="widget-stats">
            <div class="stat-item">
                <div class="stat-value">${data.total_shares}</div>
                <div class="stat-label">{{ trans('wishlist-share::admin.total-shares') }}</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">${data.total_views}</div>
                <div class="stat-label">{{ trans('wishlist-share::admin.total-views') }}</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">${data.active_shares}</div>
                <div class="stat-label">{{ trans('wishlist-share::admin.active-shares') }}</div>
            </div>
        </div>
        
        ${data.top_share ? `
            <div class="widget-section">
                <h5>{{ trans('wishlist-share::admin.most-viewed-share') }}</h5>
                <div class="top-share">
                    <div class="share-info">
                        <strong>${data.top_share.title}</strong>
                        <small>by ${data.top_share.customer_name}</small>
                    </div>
                    <div class="share-views">
                        <span class="badge">${data.top_share.view_count} views</span>
                    </div>
                </div>
            </div>
        ` : ''}
        
        ${data.recent_shares.length > 0 ? `
            <div class="widget-section">
                <h5>{{ trans('wishlist-share::admin.recent-shares') }}</h5>
                <div class="recent-shares">
                    ${data.recent_shares.map(share => `
                        <div class="recent-share-item">
                            <div class="share-info">
                                <strong>${share.title}</strong>
                                <small>by ${share.customer_name} • ${share.created_at}</small>
                            </div>
                            <div class="share-views">
                                ${share.view_count} views
                            </div>
                        </div>
                    `).join('')}
                </div>
            </div>
        ` : ''}
    `;
}

function showWidgetError() {
    const content = document.getElementById('wishlist-share-widget-content');
    content.innerHTML = `
        <div class="error-state">
            <p>{{ trans('wishlist-share::admin.widget-load-error') }}</p>
            <button onclick="loadWishlistShareWidget()" class="btn btn-sm btn-primary">
                {{ trans('wishlist-share::admin.retry') }}
            </button>
        </div>
    `;
}
</script>

<style>
.wishlist-share-widget {
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
}

.widget-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}

.widget-header h4 {
    margin: 0;
    font-size: 1rem;
    font-weight: 600;
    color: #333;
    display: flex;
    align-items: center;
    gap: 8px;
}

.widget-link {
    color: #007bff;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
}

.widget-link:hover {
    text-decoration: underline;
}

.widget-content {
    padding: 20px;
}

.loading-state, .error-state {
    text-align: center;
    padding: 20px;
}

.spinner {
    width: 24px;
    height: 24px;
    border: 2px solid #f3f3f3;
    border-top: 2px solid #007bff;
    border-radius: 50%;
    animation: spin 1s linear infinite;
    margin: 0 auto 10px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.widget-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 20px;
}

.stat-item {
    text-align: center;
    padding: 12px;
    background: #f8f9fa;
    border-radius: 6px;
}

.stat-value {
    font-size: 1.5rem;
    font-weight: bold;
    color: #007bff;
    margin-bottom: 4px;
}

.stat-label {
    font-size: 0.75rem;
    color: #666;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.widget-section {
    margin-bottom: 20px;
}

.widget-section:last-child {
    margin-bottom: 0;
}

.widget-section h5 {
    font-size: 0.875rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.top-share, .recent-share-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
}

.top-share:last-child, .recent-share-item:last-child {
    border-bottom: none;
}

.share-info strong {
    display: block;
    font-size: 0.875rem;
    color: #333;
    margin-bottom: 2px;
}

.share-info small {
    font-size: 0.75rem;
    color: #666;
}

.share-views {
    font-size: 0.75rem;
    color: #666;
}

.badge {
    background: #007bff;
    color: white;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

.recent-shares {
    max-height: 200px;
    overflow-y: auto;
}

.error-state p {
    color: #666;
    margin-bottom: 12px;
}
</style>