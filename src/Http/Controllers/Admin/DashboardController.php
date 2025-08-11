<?php

namespace Ihasan\BagistoWishlistShare\Http\Controllers\Admin;

use Carbon\Carbon;
use Ihasan\BagistoWishlistShare\Repositories\WishlistShareRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function __construct(
        protected WishlistShareRepository $wishlistShareRepository,
    ) {}

    /**
     * Get dashboard widget data.
     */
    public function widget(): JsonResponse
    {
        $last30Days = Carbon::now()->subDays(30);

        $analytics = $this->wishlistShareRepository->getAnalyticsData([
            'date_from' => $last30Days,
        ]);

        $topShares = $this->wishlistShareRepository->getTopPerformingShares(1);
        $topShare = $topShares->first();

        $recentShares = $this->wishlistShareRepository->getRecentActivity(5);

        return response()->json([
            'success' => true,
            'data' => [
                'total_shares' => $analytics['total_shares'],
                'total_views' => $analytics['total_views'],
                'active_shares' => $analytics['active_shares'],
                'top_share' => $topShare ? [
                    'title' => $topShare->title ?: 'Untitled',
                    'customer_name' => $topShare->customer->first_name.' '.$topShare->customer->last_name,
                    'view_count' => $topShare->view_count,
                ] : null,
                'recent_shares' => $recentShares->map(function ($share) {
                    return [
                        'id' => $share->id,
                        'title' => $share->title ?: 'Untitled',
                        'customer_name' => $share->customer->first_name.' '.$share->customer->last_name,
                        'view_count' => $share->view_count,
                        'created_at' => $share->created_at->diffForHumans(),
                    ];
                }),
            ],
        ]);
    }
}
