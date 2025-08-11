<x-admin::layouts>
    <x-slot:title>
        @lang('wishlist-share::admin.wishlist-share-analytics')
    </x-slot>

    @push('styles')
        @bagistoVite([
            'src/Resources/assets/css/app.css',
            'src/Resources/assets/js/app.js'
        ], 'wishlist-share')
    @endpush

    <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
        <p class="text-xl font-bold text-gray-800 dark:text-white">
            @lang('wishlist-share::admin.wishlist-share-analytics')
        </p>

        <div class="flex items-center gap-x-2.5">
            <div class="flex items-center gap-x-2">
                <select class="px-3 py-1.5 bg-white border border-gray-300 rounded-md text-gray-600 dark:bg-gray-900 dark:border-gray-800 dark:text-gray-300" id="date-range-selector" onchange="updateDateRange()">
                    <option value="7" {{ $dateRange == '7' ? 'selected' : '' }}>@lang('wishlist-share::admin.last-7-days')</option>
                    <option value="30" {{ $dateRange == '30' ? 'selected' : '' }}>@lang('wishlist-share::admin.last-30-days')</option>
                    <option value="90" {{ $dateRange == '90' ? 'selected' : '' }}>@lang('wishlist-share::admin.last-90-days')</option>
                    <option value="365" {{ $dateRange == '365' ? 'selected' : '' }}>@lang('wishlist-share::admin.last-year')</option>
                </select>
            </div>

            <a href="{{ route('admin.wishlist-share.analytics.export', ['date_range' => $dateRange]) }}" class="primary-button">
                @lang('wishlist-share::admin.export-data')
            </a>

            <button class="secondary-button" onclick="cleanupExpiredShares()">
                @lang('wishlist-share::admin.cleanup-expired')
            </button>
        </div>
    </div>

    <!-- Analytics Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mt-8">
        <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 dark:bg-blue-900">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($analytics['total_shares']) }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">@lang('wishlist-share::admin.total-shares')</p>
                    @if($analytics['growth']['shares'] != 0)
                        <span class="text-sm font-medium {{ $analytics['growth']['shares'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $analytics['growth']['shares'] > 0 ? '+' : '' }}{{ number_format($analytics['growth']['shares'], 1) }}%
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 dark:bg-green-900">
                    <svg class="w-6 h-6 text-green-600 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($analytics['total_views']) }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">@lang('wishlist-share::admin.total-views')</p>
                    @if($analytics['growth']['views'] != 0)
                        <span class="text-sm font-medium {{ $analytics['growth']['views'] > 0 ? 'text-green-600' : 'text-red-600' }}">
                            {{ $analytics['growth']['views'] > 0 ? '+' : '' }}{{ number_format($analytics['growth']['views'], 1) }}%
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-yellow-100 dark:bg-yellow-900">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($analytics['active_shares']) }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">@lang('wishlist-share::admin.active-shares')</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-900 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 dark:bg-red-900">
                    <svg class="w-6 h-6 text-red-600 dark:text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($analytics['expired_shares']) }}</h3>
                    <p class="text-gray-600 dark:text-gray-400">@lang('wishlist-share::admin.expired-shares')</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Shares Table -->
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow mt-8">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">@lang('wishlist-share::admin.top-performing-shares')</h3>
                <a href="{{ route('admin.wishlist-share.shares.index') }}" class="primary-button">
                    @lang('wishlist-share::admin.view-all-shares')
                </a>
            </div>
        </div>
        <div class="p-6">
            @if(count($topShares) > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-6 py-3">@lang('wishlist-share::admin.title')</th>
                                <th class="px-6 py-3">@lang('wishlist-share::admin.customer')</th>
                                <th class="px-6 py-3">@lang('wishlist-share::admin.items')</th>
                                <th class="px-6 py-3">@lang('wishlist-share::admin.views')</th>
                                <th class="px-6 py-3">@lang('wishlist-share::admin.created-at')</th>
                                <th class="px-6 py-3">@lang('wishlist-share::admin.status')</th>
                                <th class="px-6 py-3">@lang('wishlist-share::admin.actions')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topShares as $share)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                                        {{ $share['title'] ?: trans('wishlist-share::admin.untitled') }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>{{ $share['customer_name'] }}</div>
                                        <div class="text-xs text-gray-500">{{ $share['customer_email'] }}</div>
                                    </td>
                                    <td class="px-6 py-4">{{ $share['items_count'] }}</td>
                                    <td class="px-6 py-4">
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                            {{ $share['view_count'] }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">{{ $share['created_at']->format('M d, Y') }}</td>
                                    <td class="px-6 py-4">
                                        @if($share['is_public'] && (!$share['expires_at'] || $share['expires_at']->isFuture()))
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                                @lang('wishlist-share::admin.active')
                                            </span>
                                        @elseif($share['expires_at'] && $share['expires_at']->isPast())
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
                                        <a href="{{ $share['share_url'] }}" target="_blank" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                                            @lang('wishlist-share::admin.view')
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500 dark:text-gray-400">@lang('wishlist-share::admin.no-shares-found')</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow mt-8">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">@lang('wishlist-share::admin.recent-activity')</h3>
        </div>
        <div class="p-6">
            @if(count($recentShares) > 0)
                <div class="space-y-4">
                    @foreach($recentShares as $share)
                        <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <div class="flex items-center">
                                <div class="p-2 bg-blue-100 dark:bg-blue-900 rounded-full">
                                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.367 2.684 3 3 0 00-5.367-2.684z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                                        <strong>{{ $share['customer_name'] }}</strong> @lang('wishlist-share::admin.shared-wishlist')
                                        @if($share['title'])
                                            "{{ $share['title'] }}"
                                        @endif
                                    </div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ $share['items_count'] }} @lang('wishlist-share::admin.items') • 
                                        {{ $share['view_count'] }} @lang('wishlist-share::admin.views') • 
                                        {{ $share['created_at']->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('wishlist-share.view', $share['share_token']) }}" target="_blank" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 text-sm">
                                @lang('wishlist-share::admin.view')
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-500 dark:text-gray-400">@lang('wishlist-share::admin.no-recent-activity')</p>
                </div>
            @endif
        </div>
    </div>

    @push('scripts')
    <script>
        function updateDateRange() {
            const dateRange = document.getElementById('date-range-selector').value;
            window.location.href = `{{ route('admin.wishlist-share.analytics.index') }}?date_range=${dateRange}`;
        }

        function cleanupExpiredShares() {
            if (confirm('@lang("wishlist-share::admin.confirm-cleanup-expired")')) {
                fetch('{{ route("admin.wishlist-share.cleanup-expired") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
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