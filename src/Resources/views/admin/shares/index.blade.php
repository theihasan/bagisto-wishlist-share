<x-admin::layouts>
    <x-slot:title>
        @lang('wishlist-share::admin.wishlist-shares')
    </x-slot>

    @push('styles')
        @bagistoVite([
            'src/Resources/assets/css/app.css',
            'src/Resources/assets/js/app.js'
        ], 'wishlist-share')
    @endpush

    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
        <p class="text-xl font-bold text-gray-800 dark:text-white">
            @lang('wishlist-share::admin.wishlist-shares')
        </p>

        <div class="flex items-center gap-x-2.5">
            <a href="{{ route('admin.wishlist-share.analytics.index') }}" class="primary-button">
                @lang('wishlist-share::admin.view-analytics')
            </a>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow mt-8">
        <div class="p-6">
            <form method="GET" action="{{ route('admin.wishlist-share.shares.index') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">@lang('wishlist-share::admin.search')</label>
                    <input type="text" name="search" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white" value="{{ request('search') }}" placeholder="@lang('wishlist-share::admin.search-placeholder')">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">@lang('wishlist-share::admin.status')</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                        <option value="">@lang('wishlist-share::admin.all-statuses')</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>@lang('wishlist-share::admin.active')</option>
                        <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>@lang('wishlist-share::admin.expired')</option>
                        <option value="private" {{ request('status') == 'private' ? 'selected' : '' }}>@lang('wishlist-share::admin.private')</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">@lang('wishlist-share::admin.date-from')</label>
                    <input type="date" name="date_from" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white" value="{{ request('date_from') }}">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">@lang('wishlist-share::admin.date-to')</label>
                    <input type="date" name="date_to" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white" value="{{ request('date_to') }}">
                </div>

                <div class="flex items-end">
                    <div class="flex gap-2">
                        <button type="submit" class="primary-button">
                            @lang('wishlist-share::admin.filter')
                        </button>
                        <a href="{{ route('admin.wishlist-share.shares.index') }}" class="secondary-button">
                            @lang('wishlist-share::admin.reset')
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Shares Table -->
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow mt-8">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">@lang('wishlist-share::admin.shares-list')</h3>
                
                @if($shares->count() > 0)
                    <div class="flex items-center gap-2">
                        <button class="secondary-button" onclick="bulkDelete()" id="bulk-delete-btn" style="display: none;">
                            @lang('wishlist-share::admin.delete-selected')
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <div class="p-6">
            @if($shares->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3 w-10">
                                    <input type="checkbox" id="select-all" onchange="toggleSelectAll()" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                </th>
                                <th class="px-6 py-3">@lang('wishlist-share::admin.title')</th>
                                <th class="px-6 py-3">@lang('wishlist-share::admin.customer')</th>
                                <th class="px-6 py-3">@lang('wishlist-share::admin.items')</th>
                                <th class="px-6 py-3">@lang('wishlist-share::admin.views')</th>
                                <th class="px-6 py-3">@lang('wishlist-share::admin.status')</th>
                                <th class="px-6 py-3">@lang('wishlist-share::admin.created-at')</th>
                                <th class="px-6 py-3">@lang('wishlist-share::admin.expires-at')</th>
                                <th class="px-6 py-3">@lang('wishlist-share::admin.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($shares as $share)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-6 py-4">
                                        <input type="checkbox" class="share-checkbox rounded border-gray-300 text-blue-600 focus:ring-blue-500" value="{{ $share->id }}" onchange="toggleBulkActions()">
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900 dark:text-white">
                                            {{ $share->title ?: trans('wishlist-share::admin.untitled') }}
                                        </div>
                                        @if($share->description)
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ Str::limit($share->description, 50) }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-gray-900 dark:text-white">{{ $share->customer->first_name }} {{ $share->customer->last_name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $share->customer->email }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                            {{ $share->items->count() }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="bg-purple-100 text-purple-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-purple-900 dark:text-purple-300">
                                            {{ $share->view_count }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($share->is_public && (!$share->expires_at || $share->expires_at->isFuture()))
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                                @lang('wishlist-share::admin.active')
                                            </span>
                                        @elseif($share->expires_at && $share->expires_at->isPast())
                                            <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">
                                                @lang('wishlist-share::admin.expired')
                                            </span>
                                        @else
                                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-gray-700 dark:text-gray-300">
                                                @lang('wishlist-share::admin.private')
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-gray-900 dark:text-white">{{ $share->created_at->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ $share->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($share->expires_at)
                                            <div class="text-gray-900 dark:text-white">{{ $share->expires_at->format('M d, Y') }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $share->expires_at->format('H:i') }}</div>
                                        @else
                                            <span class="text-gray-500 dark:text-gray-400">@lang('wishlist-share::admin.never')</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('admin.wishlist-share.shares.show', $share->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" title="@lang('wishlist-share::admin.view-details')">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                            </a>
                                            <a href="{{ route('wishlist-share.view', $share->share_token) }}" target="_blank" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300" title="@lang('wishlist-share::admin.view-public')">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                                </svg>
                                            </a>
                                            <button onclick="deleteShare({{ $share->id }})" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" title="@lang('wishlist-share::admin.delete')">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-6 flex justify-center">
                    {{ $shares->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">@lang('wishlist-share::admin.no-shares-found')</h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">@lang('wishlist-share::admin.no-shares-description')</p>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        function toggleSelectAll() {
            const selectAll = document.getElementById('select-all');
            const checkboxes = document.querySelectorAll('.share-checkbox');
            
            checkboxes.forEach(checkbox => {
                checkbox.checked = selectAll.checked;
            });
            
            toggleBulkActions();
        }

        function toggleBulkActions() {
            const checkboxes = document.querySelectorAll('.share-checkbox:checked');
            const bulkDeleteBtn = document.getElementById('bulk-delete-btn');
            
            if (checkboxes.length > 0) {
                bulkDeleteBtn.style.display = 'inline-block';
            } else {
                bulkDeleteBtn.style.display = 'none';
            }
        }

        function deleteShare(id) {
            if (confirm('@lang("wishlist-share::admin.confirm-delete-share")')) {
                fetch(`{{ route('admin.wishlist-share.shares.destroy', '') }}/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('@lang("wishlist-share::admin.error-occurred")');
                });
            }
        }

        function bulkDelete() {
            const checkboxes = document.querySelectorAll('.share-checkbox:checked');
            const ids = Array.from(checkboxes).map(cb => cb.value);
            
            if (ids.length === 0) {
                alert('@lang("wishlist-share::admin.no-shares-selected")');
                return;
            }

            if (confirm(`@lang("wishlist-share::admin.confirm-delete-shares") ${ids.length} @lang("wishlist-share::admin.shares")?`)) {
                fetch('{{ route("admin.wishlist-share.shares.bulk-destroy") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ ids: ids })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('@lang("wishlist-share::admin.error-occurred")');
                });
            }
        }
    </script>
    @endpush
</x-admin::layouts>