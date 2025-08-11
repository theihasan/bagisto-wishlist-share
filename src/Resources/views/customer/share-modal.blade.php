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

<div id="wishlist-share-modal" class="wishlist-share-modal" style="display: none;">
    <div class="modal-overlay" @click="closeModal"></div>
    <div class="modal-content">
        <div class="modal-header">
            <h3>{{ trans('wishlist-share::app.share-wishlist') }}</h3>
            <button class="close-btn" @click="closeModal">&times;</button>
        </div>
        
        <div class="modal-body">
            <form @submit.prevent="createShare">
                <div class="form-group">
                    <label for="share-title">{{ trans('wishlist-share::app.title') }}</label>
                    <input 
                        type="text" 
                        id="share-title" 
                        v-model="shareForm.title" 
                        :placeholder="trans('wishlist-share::app.title-placeholder')"
                        maxlength="255"
                    >
                </div>
                
                <div class="form-group">
                    <label for="share-description">{{ trans('wishlist-share::app.description') }}</label>
                    <textarea 
                        id="share-description" 
                        v-model="shareForm.description" 
                        :placeholder="trans('wishlist-share::app.description-placeholder')"
                        maxlength="1000"
                        rows="3"
                    ></textarea>
                </div>
                
                <div class="form-group">
                    <label class="checkbox-label">
                        <input 
                            type="checkbox" 
                            v-model="shareForm.is_public"
                        >
                        {{ trans('wishlist-share::app.make-public') }}
                    </label>
                </div>
                
                <div class="form-group">
                    <label for="expires-in">{{ trans('wishlist-share::app.expires-in') }}</label>
                    <select id="expires-in" v-model="shareForm.expires_in_days">
                        <option value="7">{{ trans('wishlist-share::app.7-days') }}</option>
                        <option value="30" selected>{{ trans('wishlist-share::app.30-days') }}</option>
                        <option value="90">{{ trans('wishlist-share::app.90-days') }}</option>
                        <option value="365">{{ trans('wishlist-share::app.1-year') }}</option>
                    </select>
                </div>
                
                <div class="form-actions">
                    <button type="submit" class="btn-primary" :disabled="isCreating">
                        <span v-if="isCreating">{{ trans('wishlist-share::app.creating') }}...</span>
                        <span v-else>{{ trans('wishlist-share::app.create-share') }}</span>
                    </button>
                </div>
            </form>
            
            <div v-if="shareData" class="share-result">
                <h4>{{ trans('wishlist-share::app.share-ready') }}</h4>
                
                <div class="share-url-section">
                    <label>{{ trans('wishlist-share::app.share-link') }}</label>
                    <div class="url-input-group">
                        <input 
                            type="text" 
                            :value="shareData.share_url" 
                            readonly 
                            ref="shareUrlInput"
                        >
                        <button @click="copyToClipboard" class="copy-btn">
                            {{ trans('wishlist-share::app.copy') }}
                        </button>
                    </div>
                </div>
                
                <div class="social-sharing">
                    <h5>{{ trans('wishlist-share::app.share-on') }}</h5>
                    <div class="social-buttons">
                        <button @click="shareOnFacebook" class="social-btn facebook">
                            <i class="fab fa-facebook-f"></i>
                            Facebook
                        </button>
                        <button @click="shareOnTwitter" class="social-btn twitter">
                            <i class="fab fa-twitter"></i>
                            Twitter
                        </button>
                        <button @click="shareOnLinkedIn" class="social-btn linkedin">
                            <i class="fab fa-linkedin-in"></i>
                            LinkedIn
                        </button>
                        <button @click="shareViaEmail" class="social-btn email">
                            <i class="fas fa-envelope"></i>
                            Email
                        </button>
                    </div>
                </div>
                
                <div class="qr-code-section">
                    <h5>{{ trans('wishlist-share::app.qr-code') }}</h5>
                    <div class="qr-code-container">
                        <img :src="shareData.qr_url" alt="QR Code" class="qr-code">
                        <button @click="downloadQR" class="download-qr-btn">
                            {{ trans('wishlist-share::app.download-qr') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<script>
document.addEventListener('DOMContentLoaded', function() {
    const { createApp } = Vue;
    
    createApp({
        data() {
            return {
                showModal: false,
                isCreating: false,
                shareForm: {
                    title: '',
                    description: '',
                    is_public: true,
                    expires_in_days: 30
                },
                shareData: null
            }
        },
        methods: {
            openModal() {
                this.showModal = true;
                document.getElementById('wishlist-share-modal').style.display = 'flex';
                document.body.style.overflow = 'hidden';
            },
            closeModal() {
                this.showModal = false;
                document.getElementById('wishlist-share-modal').style.display = 'none';
                document.body.style.overflow = 'auto';
                this.shareData = null;
                this.resetForm();
            },
            resetForm() {
                this.shareForm = {
                    title: '',
                    description: '',
                    is_public: true,
                    expires_in_days: 30
                };
            },
            async createShare() {
                this.isCreating = true;
                
                try {
                    const response = await fetch('{{ route("wishlist-share.create") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(this.shareForm)
                    });
                    
                    const result = await response.json();
                    
                    if (result.success) {
                        this.shareData = result.data;
                        this.$nextTick(() => {
                            this.$refs.shareUrlInput.select();
                        });
                    } else {
                        alert(result.message);
                    }
                } catch (error) {
                    console.error('Error creating share:', error);
                    alert('{{ trans("wishlist-share::app.error-creating-share") }}');
                } finally {
                    this.isCreating = false;
                }
            },
            copyToClipboard() {
                this.$refs.shareUrlInput.select();
                document.execCommand('copy');
                
                // Show feedback
                const copyBtn = event.target;
                const originalText = copyBtn.textContent;
                copyBtn.textContent = '{{ trans("wishlist-share::app.copied") }}';
                setTimeout(() => {
                    copyBtn.textContent = originalText;
                }, 2000);
            },
            shareOnFacebook() {
                const url = encodeURIComponent(this.shareData.share_url);
                window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank', 'width=600,height=400');
            },
            shareOnTwitter() {
                const url = encodeURIComponent(this.shareData.share_url);
                const text = encodeURIComponent(`Check out my wishlist: ${this.shareForm.title || 'My Wishlist'}`);
                window.open(`https://twitter.com/intent/tweet?url=${url}&text=${text}`, '_blank', 'width=600,height=400');
            },
            shareOnLinkedIn() {
                const url = encodeURIComponent(this.shareData.share_url);
                window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, '_blank', 'width=600,height=400');
            },
            shareViaEmail() {
                const subject = encodeURIComponent(`Check out my wishlist: ${this.shareForm.title || 'My Wishlist'}`);
                const body = encodeURIComponent(`Hi,\n\nI wanted to share my wishlist with you:\n\n${this.shareData.share_url}\n\n${this.shareForm.description || ''}\n\nBest regards!`);
                window.location.href = `mailto:?subject=${subject}&body=${body}`;
            },
            downloadQR() {
                const link = document.createElement('a');
                link.href = this.shareData.qr_url;
                link.download = 'wishlist-qr-code.png';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        },
        mounted() {
            // Add share button to wishlist page
            const wishlistHeader = document.querySelector('.wishlist-header, .page-header');
            if (wishlistHeader) {
                const shareButton = document.createElement('button');
                shareButton.className = 'wishlist-share-btn btn btn-primary';
                shareButton.innerHTML = '<i class="fas fa-share-alt"></i> {{ trans("wishlist-share::app.share-wishlist") }}';
                shareButton.addEventListener('click', () => this.openModal());
                
                const deleteAllBtn = wishlistHeader.querySelector('.delete-all-btn');
                if (deleteAllBtn) {
                    deleteAllBtn.parentNode.insertBefore(shareButton, deleteAllBtn);
                } else {
                    wishlistHeader.appendChild(shareButton);
                }
            }
        }
    }).mount('#wishlist-share-modal');
});
</script>