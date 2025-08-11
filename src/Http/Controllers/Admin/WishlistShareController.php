<?php

namespace Ihasan\BagistoWishlistShare\Http\Controllers\Admin;

use Carbon\Carbon;
use Ihasan\BagistoWishlistShare\Repositories\WishlistShareRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Webkul\Customer\Repositories\CustomerRepository;

class WishlistShareController extends Controller
{
    public function __construct(
        protected WishlistShareRepository $wishlistShareRepository,
        protected CustomerRepository $customerRepository,
    ) {}

    /**
     * Display the analytics dashboard.
     */
    public function index(Request $request)
    {
        $dateRange = $request->get('date_range', '30');
        $startDate = Carbon::now()->subDays($dateRange);

        $analytics = $this->getAnalyticsData($startDate);
        $topShares = $this->getTopShares($startDate);
        $recentShares = $this->getRecentShares();
        $platformStats = $this->getPlatformStats($startDate);

        return view(
            'wishlist-share::admin.analytics.index',
            compact(
                'analytics',
                'topShares',
                'recentShares',
                'platformStats',
                'dateRange',
            ),
        );
    }

    /**
     * Get analytics data for the dashboard.
     */
    protected function getAnalyticsData(Carbon $startDate): array
    {
        $filters = [
            'date_from' => $startDate,
            'date_to' => now(),
        ];

        $analytics = $this->wishlistShareRepository->getAnalyticsData($filters);
        $dailyStats = $this->wishlistShareRepository->getDailyStatistics(
            $filters,
        );

        // Calculate growth compared to previous period
        $periodLength = now()->diffInDays($startDate);
        $previousPeriod = $startDate->copy()->subDays($periodLength);

        $growthData = $this->wishlistShareRepository->getGrowthComparison(
            $startDate,
            $previousPeriod,
        );

        return [
            'total_shares' => $analytics['total_shares'],
            'total_views' => $analytics['total_views'],
            'active_shares' => $analytics['active_shares'],
            'expired_shares' => $analytics['expired_shares'],
            'daily_stats' => $dailyStats,
            'growth' => $growthData['growth'],
        ];
    }

    /**
     * Get top performing shares.
     */
    protected function getTopShares(Carbon $startDate, int $limit = 10): array
    {
        $filters = [
            'date_from' => $startDate,
            'date_to' => now(),
        ];

        return $this->wishlistShareRepository
            ->getTopPerformingShares($limit, $filters)
            ->map(function ($share) {
                return [
                    'id' => $share->id,
                    'title' => $share->title,
                    'customer_name' => $share->customer->first_name.
                        ' '.
                        $share->customer->last_name,
                    'customer_email' => $share->customer->email,
                    'view_count' => $share->view_count,
                    'items_count' => $share->items->count(),
                    'created_at' => $share->created_at,
                    'expires_at' => $share->expires_at,
                    'is_public' => $share->is_public,
                    'share_url' => route(
                        'wishlist-share.view',
                        $share->share_token,
                    ),
                ];
            })
            ->toArray();
    }

    /**
     * Get recent shares.
     */
    protected function getRecentShares(int $limit = 15): array
    {
        return $this->wishlistShareRepository
            ->getRecentActivity($limit)
            ->map(function ($share) {
                return [
                    'id' => $share->id,
                    'title' => $share->title,
                    'customer_name' => $share->customer->first_name.
                        ' '.
                        $share->customer->last_name,
                    'customer_email' => $share->customer->email,
                    'view_count' => $share->view_count,
                    'items_count' => $share->items->count(),
                    'created_at' => $share->created_at,
                    'expires_at' => $share->expires_at,
                    'is_public' => $share->is_public,
                    'share_token' => $share->share_token,
                ];
            })
            ->toArray();
    }

    /**
     * Get platform sharing statistics.
     */
    protected function getPlatformStats(Carbon $startDate): array
    {
        $filters = [
            'date_from' => $startDate,
            'date_to' => now(),
        ];

        return $this->wishlistShareRepository->getPlatformStatistics($filters);
    }

    /**
     * Get detailed analytics data for API.
     */
    public function analytics(Request $request): JsonResponse
    {
        $dateRange = $request->get('date_range', '30');
        $startDate = Carbon::now()->subDays($dateRange);

        $analytics = $this->getAnalyticsData($startDate);

        return response()->json([
            'success' => true,
            'data' => $analytics,
        ]);
    }

    /**
     * Get all shares with pagination and filtering.
     */
    public function shares(Request $request)
    {
        $filters = [];

        // Apply filters
        if ($request->has('search')) {
            $filters['search'] = $request->get('search');
        }

        if ($request->has('status')) {
            $filters['status'] = $request->get('status');
        }

        if ($request->has('date_from')) {
            $filters['date_from'] = $request->get('date_from');
        }

        if ($request->has('date_to')) {
            $filters['date_to'] = $request->get('date_to');
        }

        $shares = $this->wishlistShareRepository->getFilteredShares(
            $filters,
            20,
        );

        return view('wishlist-share::admin.shares.index', compact('shares'));
    }

    /**
     * Show detailed view of a specific share.
     */
    public function show(int $id)
    {
        $share = $this->wishlistShareRepository
            ->with(['customer', 'items.product'])
            ->findOrFail($id);

        return view('wishlist-share::admin.shares.show', compact('share'));
    }

    /**
     * Delete a share.
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $share = $this->wishlistShareRepository->findOrFail($id);
            $this->wishlistShareRepository->delete($id);

            return response()->json([
                'success' => true,
                'message' => trans(
                    'wishlist-share::admin.share-deleted-successfully',
                ),
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => trans(
                        'wishlist-share::admin.error-deleting-share',
                    ),
                ],
                500,
            );
        }
    }

    /**
     * Bulk delete shares.
     */
    public function bulkDestroy(Request $request): JsonResponse
    {
        try {
            $ids = $request->get('ids', []);

            if (empty($ids)) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => trans(
                            'wishlist-share::admin.no-shares-selected',
                        ),
                    ],
                    400,
                );
            }

            foreach ($ids as $id) {
                $this->wishlistShareRepository->delete($id);
            }

            return response()->json([
                'success' => true,
                'message' => trans(
                    'wishlist-share::admin.shares-deleted-successfully',
                    ['count' => count($ids)],
                ),
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => trans(
                        'wishlist-share::admin.error-deleting-shares',
                    ),
                ],
                500,
            );
        }
    }

    /**
     * Clean up expired shares.
     */
    public function cleanupExpired(): JsonResponse
    {
        try {
            $count = $this->wishlistShareRepository->cleanupExpiredShares();

            return response()->json([
                'success' => true,
                'message' => trans(
                    'wishlist-share::admin.expired-shares-cleaned',
                    ['count' => $count],
                ),
            ]);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => trans(
                        'wishlist-share::admin.error-cleaning-expired-shares',
                    ),
                ],
                500,
            );
        }
    }

    /**
     * Export analytics data.
     */
    public function export(Request $request)
    {
        $dateRange = $request->get('date_range', '30');
        $startDate = Carbon::now()->subDays($dateRange);

        $filters = [
            'date_from' => $startDate,
            'date_to' => now(),
        ];

        $shares = $this->wishlistShareRepository
            ->getFilteredShares($filters, 1000)
            ->items();

        $filename = 'wishlist-shares-'.now()->format('Y-m-d').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($shares) {
            $file = fopen('php://output', 'w');

            // CSV headers
            fputcsv($file, [
                'ID',
                'Title',
                'Customer Name',
                'Customer Email',
                'Items Count',
                'View Count',
                'Is Public',
                'Created At',
                'Expires At',
                'Share URL',
            ]);

            // CSV data
            foreach ($shares as $share) {
                fputcsv($file, [
                    $share->id,
                    $share->title,
                    $share->customer->first_name.
                    ' '.
                    $share->customer->last_name,
                    $share->customer->email,
                    $share->items->count(),
                    $share->view_count,
                    $share->is_public ? 'Yes' : 'No',
                    $share->created_at->format('Y-m-d H:i:s'),
                    $share->expires_at
                        ? $share->expires_at->format('Y-m-d H:i:s')
                        : 'Never',
                    route('wishlist-share.view', $share->share_token),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
