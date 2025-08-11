<?php

namespace Ihasan\BagistoWishlistShare\Repositories;

use Webkul\Core\Eloquent\Repository;
use Ihasan\BagistoWishlistShare\Models\WishlistShare;

class WishlistShareRepository extends Repository
{
    /**
     * Specify Model class name
     */
    public function model(): string
    {
        return WishlistShare::class;
    }

    /**
     * Find wishlist share by token.
     */
    public function findByToken(string $token): ?WishlistShare
    {
        return $this->findOneWhere(["share_token" => $token]);
    }

    /**
     * Find active shares for a customer.
     */
    public function getActiveSharesForCustomer(int $customerId)
    {
        return $this->where("customer_id", $customerId)
            ->where("is_public", true)
            ->where(function ($query) {
                $query
                    ->whereNull("expires_at")
                    ->orWhere("expires_at", ">", now());
            })
            ->orderBy("created_at", "desc")
            ->get();
    }

    /**
     * Clean up expired shares.
     */
    public function cleanupExpiredShares(): int
    {
        return $this->model->where("expires_at", "<", now())->delete();
    }

    /**
     * Get analytics data for admin dashboard.
     */
    public function getAnalyticsData(array $filters = []): array
    {
        $query = $this->model->query();

        // Apply date filters
        if (isset($filters["date_from"])) {
            $query->where("created_at", ">=", $filters["date_from"]);
        }

        if (isset($filters["date_to"])) {
            $query->where("created_at", "<=", $filters["date_to"]);
        }

        $totalShares = $query->count();
        $totalViews = $query->sum("view_count");
        $activeShares = $this->getActiveSharesCount();
        $expiredShares = $this->getExpiredSharesCount();

        return [
            "total_shares" => $totalShares,
            "total_views" => $totalViews,
            "active_shares" => $activeShares,
            "expired_shares" => $expiredShares,
        ];
    }

    /**
     * Get count of active shares.
     */
    public function getActiveSharesCount(): int
    {
        return $this->model
            ->where("is_public", true)
            ->where(function ($query) {
                $query
                    ->whereNull("expires_at")
                    ->orWhere("expires_at", ">", now());
            })
            ->count();
    }

    /**
     * Get count of expired shares.
     */
    public function getExpiredSharesCount(): int
    {
        return $this->model->where("expires_at", "<", now())->count();
    }

    /**
     * Get top performing shares by view count.
     */
    public function getTopPerformingShares(
        int $limit = 10,
        array $filters = [],
    ): \Illuminate\Database\Eloquent\Collection {
        $query = $this->model->with(["customer", "items"]);

        // Apply date filters
        if (isset($filters["date_from"])) {
            $query->where("created_at", ">=", $filters["date_from"]);
        }

        if (isset($filters["date_to"])) {
            $query->where("created_at", "<=", $filters["date_to"]);
        }

        return $query->orderBy("view_count", "desc")->limit($limit)->get();
    }

    /**
     * Get daily statistics for charts.
     */
    public function getDailyStatistics(
        array $filters = [],
    ): \Illuminate\Support\Collection {
        $query = $this->model->selectRaw('
            DATE(created_at) as date,
            COUNT(*) as shares_count,
            SUM(view_count) as total_views
        ');

        // Apply date filters
        if (isset($filters["date_from"])) {
            $query->where("created_at", ">=", $filters["date_from"]);
        }

        if (isset($filters["date_to"])) {
            $query->where("created_at", "<=", $filters["date_to"]);
        }

        return $query->groupBy("date")->orderBy("date")->get();
    }

    /**
     * Get platform sharing statistics.
     */
    public function getPlatformStatistics(array $filters = []): array
    {
        $query = $this->model->whereNotNull("shared_platforms");

        // Apply date filters
        if (isset($filters["date_from"])) {
            $query->where("created_at", ">=", $filters["date_from"]);
        }

        if (isset($filters["date_to"])) {
            $query->where("created_at", "<=", $filters["date_to"]);
        }

        $shares = $query->get();

        $platformCounts = [
            "facebook" => 0,
            "twitter" => 0,
            "linkedin" => 0,
            "email" => 0,
            "copy" => 0,
        ];

        foreach ($shares as $share) {
            if (
                $share->shared_platforms &&
                is_array($share->shared_platforms)
            ) {
                foreach ($share->shared_platforms as $platform) {
                    if (isset($platformCounts[$platform])) {
                        $platformCounts[$platform]++;
                    }
                }
            }
        }

        return $platformCounts;
    }

    /**
     * Get customer sharing statistics.
     */
    public function getCustomerStatistics(int $customerId): array
    {
        $totalShares = $this->where("customer_id", $customerId)->count();
        $totalViews = $this->where("customer_id", $customerId)->sum(
            "view_count",
        );
        $activeShares = $this->where("customer_id", $customerId)
            ->where("is_public", true)
            ->where(function ($query) {
                $query
                    ->whereNull("expires_at")
                    ->orWhere("expires_at", ">", now());
            })
            ->count();

        return [
            "total_shares" => $totalShares,
            "total_views" => $totalViews,
            "active_shares" => $activeShares,
        ];
    }

    /**
     * Get shares with advanced filtering and pagination.
     */
    public function getFilteredShares(array $filters = [], int $perPage = 20)
    {
        $query = $this->model->with(["customer", "items"]);

        // Search filter
        if (!empty($filters["search"])) {
            $search = $filters["search"];
            $query->where(function ($q) use ($search) {
                $q->where("title", "like", "%{$search}%")->orWhereHas(
                    "customer",
                    function ($customerQuery) use ($search) {
                        $customerQuery
                            ->where("first_name", "like", "%{$search}%")
                            ->orWhere("last_name", "like", "%{$search}%")
                            ->orWhere("email", "like", "%{$search}%");
                    },
                );
            });
        }

        // Status filter
        if (!empty($filters["status"])) {
            switch ($filters["status"]) {
                case "active":
                    $query->where("is_public", true)->where(function ($q) {
                        $q->whereNull("expires_at")->orWhere(
                            "expires_at",
                            ">",
                            now(),
                        );
                    });
                    break;
                case "expired":
                    $query->where("expires_at", "<", now());
                    break;
                case "private":
                    $query->where("is_public", false);
                    break;
            }
        }

        // Date filters
        if (!empty($filters["date_from"])) {
            $query->where("created_at", ">=", $filters["date_from"]);
        }

        if (!empty($filters["date_to"])) {
            $query->where("created_at", "<=", $filters["date_to"]);
        }

        return $query->orderBy("created_at", "desc")->paginate($perPage);
    }

    /**
     * Get recent activity for dashboard.
     */
    public function getRecentActivity(
        int $limit = 15,
    ): \Illuminate\Database\Eloquent\Collection {
        return $this->model
            ->with(["customer", "items"])
            ->orderBy("created_at", "desc")
            ->limit($limit)
            ->get();
    }

    /**
     * Get growth comparison data.
     */
    public function getGrowthComparison(
        \Carbon\Carbon $currentPeriodStart,
        \Carbon\Carbon $previousPeriodStart,
    ): array {
        $currentPeriodEnd = now();
        $previousPeriodEnd = $currentPeriodStart;

        // Current period stats
        $currentShares = $this->model
            ->whereBetween("created_at", [
                $currentPeriodStart,
                $currentPeriodEnd,
            ])
            ->count();

        $currentViews = $this->model
            ->whereBetween("created_at", [
                $currentPeriodStart,
                $currentPeriodEnd,
            ])
            ->sum("view_count");

        // Previous period stats
        $previousShares = $this->model
            ->whereBetween("created_at", [
                $previousPeriodStart,
                $previousPeriodEnd,
            ])
            ->count();

        $previousViews = $this->model
            ->whereBetween("created_at", [
                $previousPeriodStart,
                $previousPeriodEnd,
            ])
            ->sum("view_count");

        // Calculate growth percentages
        $sharesGrowth =
            $previousShares > 0
                ? (($currentShares - $previousShares) / $previousShares) * 100
                : ($currentShares > 0
                    ? 100
                    : 0);

        $viewsGrowth =
            $previousViews > 0
                ? (($currentViews - $previousViews) / $previousViews) * 100
                : ($currentViews > 0
                    ? 100
                    : 0);

        return [
            "current" => [
                "shares" => $currentShares,
                "views" => $currentViews,
            ],
            "previous" => [
                "shares" => $previousShares,
                "views" => $previousViews,
            ],
            "growth" => [
                "shares" => round($sharesGrowth, 1),
                "views" => round($viewsGrowth, 1),
            ],
        ];
    }
}