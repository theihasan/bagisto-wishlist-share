{{-- 
    Wishlist Share Integration Component
    This component provides seamless integration with any Bagisto theme
--}}

@if(config('wishlist-share.enabled', true) && auth('customer')->check())
    {{-- Include the share modal --}}
    @include('wishlist-share::customer.share-modal')
    
    {{-- Load the injection script --}}
    <script src="{{ asset('wishlist-share-inject.js') }}" defer></script>
    
    {{-- Optional: Add inline share button for better theme integration --}}
    @if(isset($showInlineButton) && $showInlineButton)
        <div class="wishlist-share-inline-container" style="display: inline-flex; align-items: center; margin-left: 15px;">
            <button 
                onclick="document.getElementById('wishlist-share-modal').style.display = 'flex'"
                class="wishlist-share-inline-btn"
                style="
                    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                    color: white;
                    border: none;
                    padding: 8px 16px;
                    border-radius: 6px;
                    font-size: 13px;
                    font-weight: 500;
                    cursor: pointer;
                    display: inline-flex;
                    align-items: center;
                    gap: 6px;
                    transition: all 0.2s ease;
                    box-shadow: 0 2px 8px rgba(102, 126, 234, 0.3);
                "
                onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 4px 12px rgba(102, 126, 234, 0.5)'"
                onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px rgba(102, 126, 234, 0.3)'"
            >
                <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                </svg>
                Share
            </button>
        </div>
    @endif
    
    {{-- Configuration script --}}
    <script>
        // Configure wishlist share behavior
        window.WishlistShareConfig = {
            enabled: {{ config('wishlist-share.enabled', true) ? 'true' : 'false' }},
            debug: {{ config('app.debug', false) ? 'true' : 'false' }},
            //buttonPosition: '{{ isset($buttonPosition) ? $buttonPosition : 'floating' }}',
            // @if(isset($floatingPosition))
            // floatingPosition: {!! json_encode($floatingPosition) !!},
            // @endif
        };
    </script>
@endif