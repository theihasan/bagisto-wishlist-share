<x-admin::layouts>
    <x-slot:title>
        @lang('wishlist-share::admin.settings')
    </x-slot:title>

    @push('styles')
        @bagistoVite([
            'src/Resources/assets/css/app.css',
            'src/Resources/assets/js/app.js'
        ], 'wishlist-share')
    @endpush

    <div class="flex gap-4 justify-between items-center max-sm:flex-wrap">
        <p class="text-xl text-gray-800 dark:text-white font-bold">
            @lang('wishlist-share::admin.settings')
        </p>
    </div>

    <x-admin::form
        :action="route('admin.wishlist-share.settings.store')"
        method="POST"
    >
        <div class="flex gap-2.5 mt-3.5 max-xl:flex-wrap">
            <div class="flex flex-col gap-2 flex-1 max-xl:flex-auto">
                
                <!-- Button Settings Card -->
                <div class="p-4 bg-white dark:bg-gray-900 rounded box-shadow">
                    <p class="text-base text-gray-800 dark:text-white font-semibold mb-4">
                        @lang('wishlist-share::admin.system.settings.buttons.title')
                    </p>
                    <p class="text-xs text-gray-600 dark:text-gray-300 mb-4">
                        @lang('wishlist-share::admin.system.settings.buttons.info')
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Add to Wishlist Button -->
                        <div class="space-y-4">
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label class="required">
                                    @lang('wishlist-share::admin.system.settings.buttons.add-to-wishlist-color')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="color"
                                    name="add_to_wishlist_button_color"
                                    :value="$settings['add_to_wishlist_button_color']"
                                    rules="required"
                                />

                                <x-admin::form.control-group.error control-name="add_to_wishlist_button_color" />
                            </x-admin::form.control-group>

                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label class="required">
                                    @lang('wishlist-share::admin.system.settings.buttons.add-to-wishlist-label')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="text"
                                    name="add_to_wishlist_button_label"
                                    :value="$settings['add_to_wishlist_button_label']"
                                    rules="required"
                                />

                                <x-admin::form.control-group.error control-name="add_to_wishlist_button_label" />
                            </x-admin::form.control-group>
                        </div>

                        <!-- View Product Button -->
                        <div class="space-y-4">
                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label class="required">
                                    @lang('wishlist-share::admin.system.settings.buttons.view-product-color')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="color"
                                    name="view_product_button_color"
                                    :value="$settings['view_product_button_color']"
                                    rules="required"
                                />

                                <x-admin::form.control-group.error control-name="view_product_button_color" />
                            </x-admin::form.control-group>

                            <x-admin::form.control-group>
                                <x-admin::form.control-group.label class="required">
                                    @lang('wishlist-share::admin.system.settings.buttons.view-product-label')
                                </x-admin::form.control-group.label>

                                <x-admin::form.control-group.control
                                    type="text"
                                    name="view_product_button_label"
                                    :value="$settings['view_product_button_label']"
                                    rules="required"
                                />

                                <x-admin::form.control-group.error control-name="view_product_button_label" />
                            </x-admin::form.control-group>
                        </div>
                    </div>
                </div>

                <!-- Social Sharing Settings Card -->
                <div class="p-4 bg-white dark:bg-gray-900 rounded box-shadow">
                    <p class="text-base text-gray-800 dark:text-white font-semibold mb-4">
                        @lang('wishlist-share::admin.system.settings.social-sharing.title')
                    </p>
                    <p class="text-xs text-gray-600 dark:text-gray-300 mb-4">
                        @lang('wishlist-share::admin.system.settings.social-sharing.info')
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Facebook Button Color -->
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="required">
                                @lang('wishlist-share::admin.system.settings.social-sharing.facebook-color')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="color"
                                name="facebook_button_color"
                                :value="$settings['facebook_button_color']"
                                rules="required"
                            />

                            <x-admin::form.control-group.error control-name="facebook_button_color" />
                        </x-admin::form.control-group>

                        <!-- Twitter Button Color -->
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="required">
                                @lang('wishlist-share::admin.system.settings.social-sharing.twitter-color')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="color"
                                name="twitter_button_color"
                                :value="$settings['twitter_button_color']"
                                rules="required"
                            />

                            <x-admin::form.control-group.error control-name="twitter_button_color" />
                        </x-admin::form.control-group>

                        <!-- LinkedIn Button Color -->
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="required">
                                @lang('wishlist-share::admin.system.settings.social-sharing.linkedin-color')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="color"
                                name="linkedin_button_color"
                                :value="$settings['linkedin_button_color']"
                                rules="required"
                            />

                            <x-admin::form.control-group.error control-name="linkedin_button_color" />
                        </x-admin::form.control-group>

                        <!-- Email Button Color -->
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="required">
                                @lang('wishlist-share::admin.system.settings.social-sharing.email-color')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="color"
                                name="email_button_color"
                                :value="$settings['email_button_color']"
                                rules="required"
                            />

                            <x-admin::form.control-group.error control-name="email_button_color" />
                        </x-admin::form.control-group>

                        <!-- Copy Link Button Color -->
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="required">
                                @lang('wishlist-share::admin.system.settings.social-sharing.copy-link-color')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="color"
                                name="copy_link_button_color"
                                :value="$settings['copy_link_button_color']"
                                rules="required"
                            />

                            <x-admin::form.control-group.error control-name="copy_link_button_color" />
                        </x-admin::form.control-group>
                    </div>
                </div>

                <!-- Preview Section -->
                <div class="p-4 bg-white dark:bg-gray-900 rounded box-shadow">
                    <p class="text-base text-gray-800 dark:text-white font-semibold mb-4">
                        @lang('wishlist-share::admin.preview')
                    </p>
                    <p class="text-xs text-gray-600 dark:text-gray-300 mb-4">
                        @lang('wishlist-share::admin.preview-description')
                    </p>

                    <div class="space-y-4">
                        <!-- Product Buttons Preview -->
                        <div class="flex gap-2 flex-wrap">
                            <button 
                                type="button" 
                                class="px-4 py-2 rounded-lg font-medium text-white transition-colors"
                                id="preview-add-to-wishlist"
                                style="background-color: {{ $settings['add_to_wishlist_button_color'] }};"
                            >
                                <span id="preview-add-to-wishlist-label">{{ $settings['add_to_wishlist_button_label'] }}</span>
                            </button>
                            <button 
                                type="button" 
                                class="px-4 py-2 rounded-lg font-medium text-white transition-colors"
                                id="preview-view-product"
                                style="background-color: {{ $settings['view_product_button_color'] }};"
                            >
                                <span id="preview-view-product-label">{{ $settings['view_product_button_label'] }}</span>
                            </button>
                        </div>

                        <!-- Social Buttons Preview -->
                        <div class="flex gap-2 flex-wrap">
                            <button type="button" class="px-3 py-2 rounded text-white text-sm" id="preview-facebook" style="background-color: {{ $settings['facebook_button_color'] }};">Facebook</button>
                            <button type="button" class="px-3 py-2 rounded text-white text-sm" id="preview-twitter" style="background-color: {{ $settings['twitter_button_color'] }};">Twitter</button>
                            <button type="button" class="px-3 py-2 rounded text-white text-sm" id="preview-linkedin" style="background-color: {{ $settings['linkedin_button_color'] }};">LinkedIn</button>
                            <button type="button" class="px-3 py-2 rounded text-white text-sm" id="preview-email" style="background-color: {{ $settings['email_button_color'] }};">Email</button>
                            <button type="button" class="px-3 py-2 rounded text-white text-sm" id="preview-copy-link" style="background-color: {{ $settings['copy_link_button_color'] }};">Copy Link</button>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="flex gap-x-2.5 items-center justify-end">
                    <button
                        type="submit"
                        class="primary-button"
                    >
                        @lang('wishlist-share::admin.save-settings')
                    </button>
                </div>
            </div>
        </div>
    </x-admin::form>

    @push('scripts')
    <script>
        // Live preview functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Color inputs
            const colorInputs = {
                'add_to_wishlist_button_color': 'preview-add-to-wishlist',
                'view_product_button_color': 'preview-view-product',
                'facebook_button_color': 'preview-facebook',
                'twitter_button_color': 'preview-twitter',
                'linkedin_button_color': 'preview-linkedin',
                'email_button_color': 'preview-email',
                'copy_link_button_color': 'preview-copy-link'
            };

            // Text inputs
            const textInputs = {
                'add_to_wishlist_button_label': 'preview-add-to-wishlist-label',
                'view_product_button_label': 'preview-view-product-label'
            };

            // Update colors
            Object.keys(colorInputs).forEach(inputName => {
                const input = document.querySelector(`input[name="${inputName}"]`);
                const preview = document.getElementById(colorInputs[inputName]);
                
                if (input && preview) {
                    input.addEventListener('input', function() {
                        preview.style.backgroundColor = this.value;
                    });
                }
            });

            // Update text labels
            Object.keys(textInputs).forEach(inputName => {
                const input = document.querySelector(`input[name="${inputName}"]`);
                const preview = document.getElementById(textInputs[inputName]);
                
                if (input && preview) {
                    input.addEventListener('input', function() {
                        preview.textContent = this.value;
                    });
                }
            });
        });
    </script>
    @endpush
</x-admin::layouts>