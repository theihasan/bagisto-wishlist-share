<x-shop::layouts :has-header="true">
    <x-slot:title>
        {{ $wishlistShare->title }}
    </x-slot:title>

    @push('styles')
        @bagistoVite([
            'src/Resources/assets/css/app.css',
            'src/Resources/assets/js/app.js'
        ], 'wishlist-share')
        
        <style>
            /* Fix for duplicate header issue */
            .lg\:hidden {
                display: none !important;
            }
            
            @media (max-width: 1023px) {
                .lg\:hidden {
                    display: flex !important;
                }
                .max-lg\:hidden {
                    display: none !important;
                }
            }
        </style>
    @endpush


    <div class="container px-[60px] max-lg:px-[30px] max-sm:px-[15px] max-w-[1320px] mx-auto">
        <div class="shared-wishlist-container py-8">
            <!-- Breadcrumb -->
            <nav class="flex mb-6" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3">
                    <li class="inline-flex items-center">
                        <a href="{{ route('shop.home.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2">Shared Wishlist</span>
                        </div>
                    </li>
                </ol>
            </nav>

            <!-- Header Section -->
            <div class="wishlist-header bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-8 mb-8 border border-blue-100">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $wishlistShare->title }}</h1>
                                @if($wishlistShare->description)
                                    <p class="text-gray-600 text-lg leading-relaxed">{{ $wishlistShare->description }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Shared by <strong>{{ $wishlistShare->customer->first_name }} {{ $wishlistShare->customer->last_name }}</strong></span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a1 1 0 011-1h6a1 1 0 011 1v4h3a1 1 0 011 1v9a2 2 0 01-2 2H5a2 2 0 01-2-2V8a1 1 0 011-1h3z"></path>
                                </svg>
                                <span>Created {{ $wishlistShare->created_at->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center">
                                <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                <span>{{ $wishlistShare->view_count }} {{ $wishlistShare->view_count == 1 ? 'view' : 'views' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if($wishlistShare->items->count() > 0)
                <div class="wishlist-items">
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-2xl font-semibold text-gray-900">
                            Products in this wishlist
                            <span class="text-lg text-gray-500 font-normal">({{ $wishlistShare->items->count() }} items)</span>
                        </h2>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach($wishlistShare->items as $item)
                            @if($item->product && $item->product->status)
                                <div class="product-card group bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-xl hover:border-blue-200 transition-all duration-300">
                                    <div class="product-image relative overflow-hidden">
                                        <a href="{{ route('shop.product_or_category.index', $item->product->url_key) }}" class="block">
                                            <img
                                                src="{{ $item->product->base_image_url ?? bagisto_asset('images/small-product-placeholder.webp') }}"
                                                alt="{{ $item->product->name }}"
                                                class="w-full h-64 object-cover group-hover:scale-105 transition-transform duration-300"
                                                onerror="this.src='{{ bagisto_asset('images/small-product-placeholder.webp') }}'"
                                            >
                                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition-all duration-300"></div>
                                        </a>
                                    </div>

                                    <div class="product-info p-5">
                                        <h3 class="product-name font-semibold text-gray-900 mb-2 line-clamp-2 leading-tight">
                                            <a href="{{ route('shop.product_or_category.index', $item->product->url_key) }}" class="hover:text-blue-600 transition-colors">
                                                {{ $item->product->name }}
                                            </a>
                                        </h3>

                                        <div class="product-price mb-4 text-lg font-bold text-gray-900">
                                            {!! $item->product->price_html !!}
                                        </div>

                                        @if($item->product_options && count($item->product_options))
                                            <div class="product-options text-sm text-gray-600 mb-4 space-y-1">
                                                @foreach($item->product_options as $key => $value)
                                                    <div class="flex justify-between">
                                                        <span class="font-medium">{{ ucfirst($key) }}:</span>
                                                        <span>{{ $value }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        <div class="product-actions space-y-2">
                                            @auth('customer')
                                                <button
                                                    class="add-to-wishlist-btn w-full py-2.5 px-4 rounded-lg font-medium transition-colors border flex items-center justify-center"
                                                    style="background-color: {{ core()->getConfigData('wishlist_share.settings.buttons.add_to_wishlist_button_color') ?: '#6b7280' }}; color: white; border-color: {{ core()->getConfigData('wishlist_share.settings.buttons.add_to_wishlist_button_color') ?: '#6b7280' }};"
                                                    onmouseover="this.style.opacity='0.9'"
                                                    onmouseout="this.style.opacity='1'"
                                                    onclick="addToWishlist({{ $item->product->id }})"
                                                >
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                                                    </svg>
                                                    {{ core()->getConfigData('wishlist_share.settings.buttons.add_to_wishlist_button_label') ?: 'Add to My Wishlist' }}
                                                </button>
                                            @endauth

                                            <a
                                                href="{{ route('shop.product_or_category.index', $item->product->url_key) }}"
                                                class="view-product-btn w-full py-2.5 px-4 rounded-lg text-center font-medium transition-colors flex items-center justify-center"
                                                style="background-color: {{ core()->getConfigData('wishlist_share.settings.buttons.view_product_button_color') ?: '#2563eb' }}; color: white;"
                                                onmouseover="this.style.opacity='0.9'"
                                                onmouseout="this.style.opacity='1'"
                                            >
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                {{ core()->getConfigData('wishlist_share.settings.buttons.view_product_button_label') ?: 'View Product' }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @else
                <div class="empty-wishlist text-center py-20">
                    <div class="mx-auto mb-6 w-32 h-32 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center">
                        <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">No items in this wishlist</h3>
                    <p class="text-gray-600 max-w-md mx-auto">This wishlist is currently empty. The owner hasn't added any products yet.</p>
                </div>
            @endif

            <!-- Share Actions Section -->
            <div class="share-actions mt-12 bg-gray-50 rounded-2xl p-8">
                <div class="text-center mb-6">
                    <h3 class="text-2xl font-semibold text-gray-900 mb-2">Share this wishlist</h3>
                    <p class="text-gray-600">Spread the word about these amazing products!</p>
                </div>

                <div class="social-sharing-buttons grid grid-cols-2 md:grid-cols-5 gap-3 mb-6">
                    <button onclick="shareOnFacebook()" class="social-btn facebook text-white px-4 py-3 rounded-lg font-medium transition-colors flex items-center justify-center"
                        style="background-color: {{ core()->getConfigData('wishlist_share.settings.social_sharing.facebook_button_color') ?: '#1877f2' }};"
                        onmouseover="this.style.opacity='0.9'"
                        onmouseout="this.style.opacity='1'">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        <span class="hidden sm:inline">Facebook</span>
                    </button>
                    <button onclick="shareOnTwitter()" class="social-btn twitter text-white px-4 py-3 rounded-lg font-medium transition-colors flex items-center justify-center"
                        style="background-color: {{ core()->getConfigData('wishlist_share.settings.social_sharing.twitter_button_color') ?: '#1da1f2' }};"
                        onmouseover="this.style.opacity='0.9'"
                        onmouseout="this.style.opacity='1'">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                        <span class="hidden sm:inline">Twitter</span>
                    </button>
                    <button onclick="shareOnLinkedIn()" class="social-btn linkedin text-white px-4 py-3 rounded-lg font-medium transition-colors flex items-center justify-center"
                        style="background-color: {{ core()->getConfigData('wishlist_share.settings.social_sharing.linkedin_button_color') ?: '#0077b5' }};"
                        onmouseover="this.style.opacity='0.9'"
                        onmouseout="this.style.opacity='1'">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                        <span class="hidden sm:inline">LinkedIn</span>
                    </button>
                    <button onclick="shareViaEmail()" class="social-btn email text-white px-4 py-3 rounded-lg font-medium transition-colors flex items-center justify-center"
                        style="background-color: {{ core()->getConfigData('wishlist_share.settings.social_sharing.email_button_color') ?: '#6b7280' }};"
                        onmouseover="this.style.opacity='0.9'"
                        onmouseout="this.style.opacity='1'">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <span class="hidden sm:inline">Email</span>
                    </button>
                    <button onclick="copyShareLink()" class="social-btn copy text-white px-4 py-3 rounded-lg font-medium transition-colors flex items-center justify-center"
                        style="background-color: {{ core()->getConfigData('wishlist_share.settings.social_sharing.copy_link_button_color') ?: '#16a34a' }};"
                        onmouseover="this.style.opacity='0.9'"
                        onmouseout="this.style.opacity='1'">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        <span class="hidden sm:inline">Copy Link</span>
                    </button>
                </div>

                <div class="qr-code-section text-center">
                    <button onclick="toggleQRCode()" class="qr-toggle-btn bg-white hover:bg-gray-50 text-gray-700 px-6 py-3 rounded-lg font-medium transition-colors border border-gray-200 hover:border-gray-300 inline-flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/>
                        </svg>
                        Show QR Code
                    </button>

                    <div id="qr-code-container" class="mt-6 hidden">
                        <div class="bg-white p-6 rounded-xl border border-gray-200 inline-block">
                            <img
                                src="{{ route('wishlist-share.qr', $wishlistShare->share_token) }}"
                                alt="QR Code"
                                class="mx-auto rounded-lg"
                            >
                            <p class="text-sm text-gray-600 mt-3">Scan with your phone to share</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
const shareUrl = "{{ route('wishlist-share.view', $wishlistShare->share_token) }}";
const shareTitle = "{{ $wishlistShare->title }}";
const shareDescription = "{{ $wishlistShare->description }}";

function shareOnFacebook() {
    const url = encodeURIComponent(shareUrl);
    window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
}

function shareOnTwitter() {
    const url = encodeURIComponent(shareUrl);
    const text = encodeURIComponent(`Check out this wishlist: ${shareTitle}`);
    window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank', 'width=600,height=400');
}

function shareOnLinkedIn() {
    const url = encodeURIComponent(shareUrl);
    window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, '_blank', 'width=600,height=400');
}

function shareViaEmail() {
    const subject = encodeURIComponent(`Check out this wishlist: ${shareTitle}`);
    const body = encodeURIComponent(`Hi,\n\nI wanted to share this wishlist with you:\n\n${shareUrl}\n\n${shareDescription}\n\nEnjoy!`);
    window.location.href = `mailto:?subject=${subject}&body=${body}`;
}

function copyShareLink() {
    navigator.clipboard.writeText(shareUrl).then(() => {
        const btn = event.target.closest('button');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-check mr-2"></i>{{ trans("wishlist-share::app.copied") }}';
        setTimeout(() => {
            btn.innerHTML = originalText;
        }, 2000);
    });
}

function toggleQRCode() {
    const container = document.getElementById('qr-code-container');
    const btn = event.target.closest('button');

    if (container.classList.contains('hidden')) {
        container.classList.remove('hidden');
        btn.innerHTML = '<i class="fas fa-qrcode mr-2"></i>{{ trans("wishlist-share::app.hide-qr-code") }}';
    } else {
        container.classList.add('hidden');
        btn.innerHTML = '<i class="fas fa-qrcode mr-2"></i>{{ trans("wishlist-share::app.show-qr-code") }}';
    }
}

@auth('customer')
function addToWishlist(productId) {
    fetch('{{ route("shop.api.customers.account.wishlist.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Authorization': 'Bearer ' + localStorage.getItem('token')
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            // Show success message
            alert(data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('{{ trans("wishlist-share::app.error-adding-to-wishlist") }}');
    });
}
@endauth
    </script>
    @endpush
</x-shop::layouts>
