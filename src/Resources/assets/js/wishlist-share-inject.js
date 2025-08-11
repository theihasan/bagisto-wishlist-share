/**
 * Bagisto Wishlist Share Extension
 * Universal theme-compatible wishlist sharing functionality
 * 
 * @version 1.0.0
 * @author Ihasan
 * @license MIT
 */

(function() {
    'use strict';
    
    // Configuration
    const CONFIG = {
        debug: false,
        retryAttempts: 3,
        retryDelay: 1000,
        buttonPosition: 'floating', // 'floating' or 'inline'
        floatingPosition: {
            top: '200px',
            right: '20px'
        }
    };
    
    // State
    let retryCount = 0;
    let shareModal = null;
    let shareButton = null;
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }
    
    function init() {
        if (!isWishlistPage()) {
            return;
        }
        
        log('Initializing Wishlist Share functionality...');
        
        // Try to initialize, with retries for dynamic content
        attemptInitialization();
    }
    
    function isWishlistPage() {
        return window.location.pathname.includes('/wishlist') || 
               document.querySelector('[class*="wishlist"]') ||
               document.title.toLowerCase().includes('wishlist');
    }
    
    function attemptInitialization() {
        if (retryCount >= CONFIG.retryAttempts) {
            log('Max retry attempts reached. Initialization failed.', 'error');
            return;
        }
        
        retryCount++;
        
        if (initializeWishlistShare()) {
            log('Wishlist Share initialized successfully!');
        } else {
            log(`Initialization attempt ${retryCount} failed. Retrying in ${CONFIG.retryDelay}ms...`);
            setTimeout(attemptInitialization, CONFIG.retryDelay);
        }
    }
    
    function initializeWishlistShare() {
        // Create share button
        shareButton = createShareButton();
        
        // Create and inject modal
        shareModal = createShareModal();
        
        // Try to place button in optimal location
        const placed = placeShareButton();
        
        if (placed) {
            log('Share button placed successfully');
            return true;
        }
        
        return false;
    }
    
    function createShareButton() {
        const button = document.createElement('button');
        button.className = 'wishlist-share-btn';
        button.setAttribute('aria-label', 'Share Wishlist');
        button.setAttribute('title', 'Share your wishlist with friends');
        
        // Universal styling that works across themes
        button.style.cssText = `
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
            color: white !important;
            border: none !important;
            padding: 12px 20px !important;
            border-radius: 8px !important;
            font-size: 14px !important;
            font-weight: 600 !important;
            cursor: pointer !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 8px !important;
            transition: all 0.3s ease !important;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4) !important;
            z-index: 1000 !important;
            position: relative !important;
            min-width: 160px !important;
            justify-content: center !important;
            text-decoration: none !important;
            outline: none !important;
            user-select: none !important;
        `;
        
        button.innerHTML = `
            <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="flex-shrink: 0;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
            </svg>
            <span>Share Wishlist</span>
        `;
        
        // Add hover effects
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px) scale(1.02)';
            this.style.boxShadow = '0 8px 20px rgba(102, 126, 234, 0.6)';
        });
        
        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
            this.style.boxShadow = '0 4px 12px rgba(102, 126, 234, 0.4)';
        });
        
        button.addEventListener('click', openShareModal);
        
        return button;
    }
    
    function placeShareButton() {
        // Strategy 1: Try inline placement (theme-specific)
        if (CONFIG.buttonPosition === 'inline' && tryInlinePlacement()) {
            return true;
        }
        
        // Strategy 2: Floating placement (universal fallback)
        return createFloatingButton();
    }
    
    function tryInlinePlacement() {
        // Common selectors across different Bagisto themes
        const selectors = [
            // Velocity theme
            '.flex.items-center.justify-between',
            '[class*="delete"]',
            
            // Other common patterns
            '.wishlist-header',
            '.page-header',
            '[class*="wishlist-title"]',
            '.actions',
            '.toolbar',
            
            // Generic patterns
            'h1:contains("Wishlist")',
            'h2:contains("Wishlist")',
            '[data-testid*="wishlist"]',
            '[id*="wishlist"]'
        ];
        
        for (const selector of selectors) {
            try {
                const element = document.querySelector(selector);
                if (element && isVisible(element)) {
                    insertButtonNear(element);
                    log(`Button placed inline near: ${selector}`);
                    return true;
                }
            } catch (e) {
                // Invalid selector, continue
            }
        }
        
        // Try text-based search
        const deleteAllElement = findElementByText('Delete All');
        const wishlistElement = findElementByText('Wishlist');
        
        if (deleteAllElement && isVisible(deleteAllElement)) {
            insertButtonNear(deleteAllElement, 'before');
            log('Button placed near "Delete All" text');
            return true;
        }
        
        if (wishlistElement && isVisible(wishlistElement)) {
            insertButtonNear(wishlistElement, 'after');
            log('Button placed near "Wishlist" text');
            return true;
        }
        
        return false;
    }
    
    function createFloatingButton() {
        const container = document.createElement('div');
        container.className = 'wishlist-share-floating-container';
        container.style.cssText = `
            position: fixed !important;
            top: ${CONFIG.floatingPosition.top} !important;
            right: ${CONFIG.floatingPosition.right} !important;
            z-index: 9999 !important;
            background: white !important;
            padding: 8px !important;
            border-radius: 12px !important;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.12) !important;
            backdrop-filter: blur(10px) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            transition: all 0.3s ease !important;
        `;
        
        // Add floating animation
        container.style.animation = 'wishlistShareFloat 3s ease-in-out infinite';
        
        // Add CSS animation keyframes
        if (!document.querySelector('#wishlist-share-styles')) {
            const style = document.createElement('style');
            style.id = 'wishlist-share-styles';
            style.textContent = `
                @keyframes wishlistShareFloat {
                    0%, 100% { transform: translateY(0px); }
                    50% { transform: translateY(-5px); }
                }
                
                .wishlist-share-floating-container:hover {
                    transform: translateY(-3px) !important;
                    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.18) !important;
                }
                
                @media (max-width: 768px) {
                    .wishlist-share-floating-container {
                        top: 120px !important;
                        right: 10px !important;
                        padding: 6px !important;
                    }
                    
                    .wishlist-share-btn {
                        min-width: 140px !important;
                        padding: 10px 16px !important;
                        font-size: 13px !important;
                    }
                }
            `;
            document.head.appendChild(style);
        }
        
        container.appendChild(shareButton);
        document.body.appendChild(container);
        
        log('Floating button created');
        return true;
    }
    
    function insertButtonNear(element, position = 'before') {
        const container = document.createElement('div');
        container.style.cssText = 'display: inline-flex; margin: 0 10px; align-items: center;';
        container.appendChild(shareButton);
        
        if (position === 'before') {
            element.parentNode.insertBefore(container, element);
        } else {
            element.parentNode.insertBefore(container, element.nextSibling);
        }
    }
    
    function findElementByText(text) {
        const elements = document.querySelectorAll('*');
        for (const element of elements) {
            if (element.textContent && 
                element.textContent.trim() === text && 
                element.children.length === 0) {
                return element;
            }
        }
        return null;
    }
    
    function isVisible(element) {
        const rect = element.getBoundingClientRect();
        const style = window.getComputedStyle(element);
        
        return rect.width > 0 && 
               rect.height > 0 && 
               style.display !== 'none' && 
               style.visibility !== 'hidden' && 
               style.opacity !== '0';
    }
    
    function createShareModal() {
        const modal = document.createElement('div');
        modal.id = 'wishlist-share-modal';
        modal.className = 'wishlist-share-modal';
        modal.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 99999;
            backdrop-filter: blur(5px);
        `;
        
        modal.innerHTML = `
            <div class="modal-content" style="
                background: white;
                border-radius: 16px;
                box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
                max-width: 500px;
                width: 90%;
                max-height: 90vh;
                overflow-y: auto;
                position: relative;
                animation: modalSlideIn 0.3s ease-out;
            ">
                <div class="modal-header" style="
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 24px 24px 0;
                    border-bottom: 1px solid #e5e7eb;
                    margin-bottom: 24px;
                ">
                    <h3 style="font-size: 1.5rem; font-weight: 600; color: #111827; margin: 0;">
                        🎉 Share Your Wishlist
                    </h3>
                    <button class="close-btn" style="
                        background: none;
                        border: none;
                        font-size: 24px;
                        color: #6b7280;
                        cursor: pointer;
                        padding: 8px;
                        border-radius: 50%;
                        transition: all 0.2s;
                        width: 40px;
                        height: 40px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                    " onmouseover="this.style.backgroundColor='#f3f4f6'" onmouseout="this.style.backgroundColor='transparent'">&times;</button>
                </div>
                
                <div class="modal-body" style="padding: 0 24px 24px;">
                    <p style="color: #6b7280; margin-bottom: 20px; text-align: center;">
                        Share your amazing product discoveries with friends and family!
                    </p>
                    
                    <div class="share-options" style="display: grid; gap: 12px;">
                        ${createShareOption('facebook', '#1877f2', 'Facebook', facebookIcon())}
                        ${createShareOption('twitter', '#1da1f2', 'Twitter', twitterIcon())}
                        ${createShareOption('linkedin', '#0077b5', 'LinkedIn', linkedinIcon())}
                        ${createShareOption('email', '#6b7280', 'Email', emailIcon())}
                        ${createShareOption('copy', '#10b981', 'Copy Link', copyIcon())}
                    </div>
                    
                    <div class="demo-message" style="
                        margin-top: 24px;
                        padding: 16px;
                        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                        color: white;
                        border-radius: 12px;
                        text-align: center;
                        font-weight: 500;
                    ">
                        ✨ Wishlist sharing is now active! Choose your preferred sharing method above.
                    </div>
                </div>
            </div>
        `;
        
        // Add modal animation styles
        if (!document.querySelector('#modal-animations')) {
            const style = document.createElement('style');
            style.id = 'modal-animations';
            style.textContent = `
                @keyframes modalSlideIn {
                    from {
                        opacity: 0;
                        transform: translateY(-50px) scale(0.9);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0) scale(1);
                    }
                }
            `;
            document.head.appendChild(style);
        }
        
        document.body.appendChild(modal);
        
        // Add event listeners
        modal.querySelector('.close-btn').addEventListener('click', closeShareModal);
        modal.addEventListener('click', function(e) {
            if (e.target === modal) closeShareModal();
        });
        
        // Add share option listeners
        modal.querySelectorAll('.share-option').forEach(option => {
            option.addEventListener('click', function() {
                const platform = this.dataset.platform;
                shareOnPlatform(platform);
            });
        });
        
        return modal;
    }
    
    function createShareOption(platform, color, label, icon) {
        return `
            <button class="share-option" data-platform="${platform}" style="
                display: flex;
                align-items: center;
                gap: 12px;
                padding: 14px 18px;
                background-color: ${color};
                color: white;
                border: none;
                border-radius: 10px;
                cursor: pointer;
                font-weight: 500;
                font-size: 15px;
                transition: all 0.2s;
                box-shadow: 0 2px 8px ${color}33;
            " onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 16px ${color}66';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 8px ${color}33';">
                ${icon}
                Share on ${label}
            </button>
        `;
    }
    
    // Icon functions
    function facebookIcon() {
        return '<svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>';
    }
    
    function twitterIcon() {
        return '<svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>';
    }
    
    function linkedinIcon() {
        return '<svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>';
    }
    
    function emailIcon() {
        return '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>';
    }
    
    function copyIcon() {
        return '<svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>';
    }
    
    function openShareModal() {
        if (shareModal) {
            shareModal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            log('Share modal opened');
        }
    }
    
    function closeShareModal() {
        if (shareModal) {
            shareModal.style.display = 'none';
            document.body.style.overflow = 'auto';
            log('Share modal closed');
        }
    }
    
    async function shareOnPlatform(platform) {
        const title = 'Check out my wishlist!';
        const description = 'I found some amazing products I wanted to share with you.';
        
        // First create a share link via API
        let shareUrl;
        try {
            // Get CSRF token from multiple possible sources
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') ||
                            document.querySelector('input[name="_token"]')?.value ||
                            window.Laravel?.csrfToken ||
                            '';
            
            if (!csrfToken) {
                throw new Error('CSRF token not found');
            }
            
            const response = await fetch('/customer/account/wishlist/share/create', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                credentials: 'same-origin',
                body: JSON.stringify({
                    title: title,
                    description: description,
                    is_public: true,
                    expires_in_days: 30
                })
            });
            
            if (!response.ok) {
                throw new Error(`HTTP ${response.status}: ${response.statusText}`);
            }
            
            const result = await response.json();
            
            if (result.success) {
                shareUrl = result.data.share_url;
                log(`Share URL created successfully: ${shareUrl}`);
            } else {
                throw new Error(result.message || 'Failed to create share link');
            }
        } catch (error) {
            console.error('Error creating share link:', error);
            
            // Show user-friendly error message
            if (error.message.includes('419')) {
                alert('Session expired. Please refresh the page and try again.');
            } else if (error.message.includes('CSRF token not found')) {
                alert('Security token missing. Please refresh the page and try again.');
            } else {
                alert(`Could not create shareable link: ${error.message}`);
            }
            
            // Don't fallback to current URL as it's not shareable
            return;
        }
        
        switch (platform) {
            case 'facebook':
                window.open(`https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(shareUrl)}`, '_blank', 'width=600,height=400');
                break;
            case 'twitter':
                window.open(`https://twitter.com/intent/tweet?url=${encodeURIComponent(shareUrl)}&text=${encodeURIComponent(title)}`, '_blank', 'width=600,height=400');
                break;
            case 'linkedin':
                window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${encodeURIComponent(shareUrl)}`, '_blank', 'width=600,height=400');
                break;
            case 'email':
                const subject = encodeURIComponent(title);
                const body = encodeURIComponent(`Hi,\n\nI wanted to share my wishlist with you:\n\n${shareUrl}\n\n${description}\n\nBest regards!`);
                window.location.href = `mailto:?subject=${subject}&body=${body}`;
                break;
            case 'copy':
                copyToClipboard(shareUrl);
                break;
        }
        
        log(`Shared on ${platform}`);
    }
    
    function copyToClipboard(text) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text).then(() => {
                showCopyFeedback();
            });
        } else {
            // Fallback for older browsers
            const textArea = document.createElement('textarea');
            textArea.value = text;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            showCopyFeedback();
        }
    }
    
    function showCopyFeedback() {
        const copyBtn = document.querySelector('[data-platform="copy"]');
        if (copyBtn) {
            const originalHTML = copyBtn.innerHTML;
            copyBtn.innerHTML = `
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Copied Successfully!
            `;
            copyBtn.style.backgroundColor = '#059669';
            
            setTimeout(() => {
                copyBtn.innerHTML = originalHTML;
                copyBtn.style.backgroundColor = '#10b981';
            }, 2000);
        }
    }
    
    function log(message, type = 'info') {
        if (CONFIG.debug) {
            console[type](`[Wishlist Share] ${message}`);
        }
    }
    
    // Handle escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeShareModal();
        }
    });
    
    // Expose for debugging
    if (CONFIG.debug) {
        window.WishlistShare = {
            openModal: openShareModal,
            closeModal: closeShareModal,
            config: CONFIG
        };
    }
    
})();