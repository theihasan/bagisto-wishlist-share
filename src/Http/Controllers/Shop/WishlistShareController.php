<?php

namespace Ihasan\BagistoWishlistShare\Http\Controllers\Shop;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Ihasan\BagistoWishlistShare\Events\WishlistShared;
use Ihasan\BagistoWishlistShare\Http\Requests\WishlistShareRequest;
use Ihasan\BagistoWishlistShare\Repositories\WishlistShareRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Webkul\Customer\Repositories\WishlistRepository;

class WishlistShareController extends Controller
{
    public function __construct(
        protected WishlistShareRepository $wishlistShareRepository,
        protected WishlistRepository $wishlistRepository,
    ) {}

    /**
     * Create a new wishlist share.
     */
    public function create(WishlistShareRequest $request): JsonResponse
    {
        $customer = Auth::guard('customer')->user();

        $wishlistItems = $this->wishlistRepository
            ->where([
                'customer_id' => $customer->id,
                'channel_id' => core()->getCurrentChannel()->id,
            ])
            ->get();

        if ($wishlistItems->isEmpty()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => trans('wishlist-share::app.empty-wishlist'),
                ],
                400,
            );
        }

        $shareToken = Str::random(32);
        $expiresAt = $request->expires_in_days
            ? now()->addDays($request->expires_in_days)
            : now()->addDays(
                config('wishlist-share.share_token.expires_in_days', 30),
            );

        $wishlistShare = $this->wishlistShareRepository->create([
            'customer_id' => $customer->id,
            'share_token' => $shareToken,
            'title' => $request->title ?:
                trans('wishlist-share::app.default-title', [
                    'name' => $customer->first_name,
                ]),
            'description' => $request->description,
            'is_public' => $request->is_public ?? true,
            'expires_at' => $expiresAt,
        ]);

        foreach ($wishlistItems as $item) {
            $wishlistShare->items()->create([
                'product_id' => $item->product_id,
                'product_options' => $item->additional,
                'quantity' => 1,
            ]);
        }

        event(new WishlistShared($wishlistShare));

        return response()->json([
            'success' => true,
            'message' => trans('wishlist-share::app.share-created'),
            'data' => [
                'share_token' => $shareToken,
                'share_url' => route('wishlist-share.view', $shareToken),
                'qr_url' => route('wishlist-share.qr', $shareToken),
            ],
        ]);
    }

    /**
     * View a shared wishlist.
     */
    public function view(string $token)
    {
        $wishlistShare = $this->wishlistShareRepository->findByToken($token);

        if (! $wishlistShare || ! $wishlistShare->isAccessible()) {
            abort(404);
        }

        $wishlistShare->incrementViewCount();

        // Load the necessary relationships including product images
        $wishlistShare->load(['items.product.images', 'customer']);

        return view(
            'wishlist-share::customer.shared-wishlist',
            compact('wishlistShare'),
        );
    }

    /**
     * Generate QR code for wishlist share.
     */
    public function generateQR(string $token): Response
    {
        $wishlistShare = $this->wishlistShareRepository->findByToken($token);

        if (! $wishlistShare || ! $wishlistShare->isAccessible()) {
            abort(404);
        }

        $shareUrl = route('wishlist-share.view', $token);

        $qrCode = QrCode::create($shareUrl)
            ->setSize(config('wishlist-share.qr_code.size', 200))
            ->setMargin(config('wishlist-share.qr_code.margin', 10));

        $writer = new PngWriter;
        $result = $writer->write($qrCode);

        return response($result->getString(), 200, [
            'Content-Type' => 'image/png',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }

    /**
     * Delete a wishlist share.
     */
    public function delete(string $token): JsonResponse
    {
        $customer = Auth::guard('customer')->user();

        $wishlistShare = $this->wishlistShareRepository
            ->findWhere([
                'share_token' => $token,
                'customer_id' => $customer->id,
            ])
            ->first();

        if (! $wishlistShare) {
            return response()->json(
                [
                    'success' => false,
                    'message' => trans('wishlist-share::app.share-not-found'),
                ],
                404,
            );
        }

        $this->wishlistShareRepository->delete($wishlistShare->id);

        return response()->json([
            'success' => true,
            'message' => trans('wishlist-share::app.share-deleted'),
        ]);
    }

    /**
     * API: Create a new wishlist share.
     */
    public function apiCreate(WishlistShareRequest $request): JsonResponse
    {
        return $this->create($request);
    }

    /**
     * API: View a shared wishlist.
     */
    public function apiView(string $token): JsonResponse
    {
        $wishlistShare = $this->wishlistShareRepository->findByToken($token);

        if (! $wishlistShare || ! $wishlistShare->isAccessible()) {
            return response()->json(
                [
                    'success' => false,
                    'message' => trans('wishlist-share::app.share-not-found'),
                ],
                404,
            );
        }

        $wishlistShare->incrementViewCount();
        $wishlistShare->load(['items.product', 'customer']);

        return response()->json([
            'success' => true,
            'data' => [
                'title' => $wishlistShare->title,
                'description' => $wishlistShare->description,
                'customer_name' => $wishlistShare->customer->first_name.
                    ' '.
                    $wishlistShare->customer->last_name,
                'created_at' => $wishlistShare->created_at,
                'view_count' => $wishlistShare->view_count,
                'items' => $wishlistShare->items->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'product' => [
                            'id' => $item->product->id,
                            'name' => $item->product->name,
                            'url_key' => $item->product->url_key,
                            'price' => $item->product->price,
                            'images' => $item->product->images,
                        ],
                        'quantity' => $item->quantity,
                        'options' => $item->product_options,
                    ];
                }),
            ],
        ]);
    }

    /**
     * API: Get user's shares.
     */
    public function myShares(): JsonResponse
    {
        $customer = Auth::guard('customer')->user();

        $shares = $this->wishlistShareRepository
            ->where('customer_id', $customer->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $shares->map(function ($share) {
                return [
                    'token' => $share->share_token,
                    'title' => $share->title,
                    'description' => $share->description,
                    'is_public' => $share->is_public,
                    'expires_at' => $share->expires_at,
                    'view_count' => $share->view_count,
                    'items_count' => $share->items->count(),
                    'share_url' => route(
                        'wishlist-share.view',
                        $share->share_token,
                    ),
                    'created_at' => $share->created_at,
                ];
            }),
        ]);
    }
}
