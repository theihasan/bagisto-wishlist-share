<?php

namespace Ihasan\BagistoWishlistShare\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Webkul\Admin\Http\Controllers\Controller;
use Webkul\Core\Repositories\CoreConfigRepository;

class SettingsController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct(
        protected CoreConfigRepository $coreConfigRepository
    ) {}

    /**
     * Display the settings page.
     */
    public function index()
    {
        $settings = [
            'add_to_wishlist_button_color' => core()->getConfigData('wishlist_share.settings.buttons.add_to_wishlist_button_color') ?: '#6b7280',
            'add_to_wishlist_button_label' => core()->getConfigData('wishlist_share.settings.buttons.add_to_wishlist_button_label') ?: 'Add to My Wishlist',
            'view_product_button_color' => core()->getConfigData('wishlist_share.settings.buttons.view_product_button_color') ?: '#2563eb',
            'view_product_button_label' => core()->getConfigData('wishlist_share.settings.buttons.view_product_button_label') ?: 'View Product',
            'facebook_button_color' => core()->getConfigData('wishlist_share.settings.social_sharing.facebook_button_color') ?: '#1877f2',
            'twitter_button_color' => core()->getConfigData('wishlist_share.settings.social_sharing.twitter_button_color') ?: '#1da1f2',
            'linkedin_button_color' => core()->getConfigData('wishlist_share.settings.social_sharing.linkedin_button_color') ?: '#0077b5',
            'email_button_color' => core()->getConfigData('wishlist_share.settings.social_sharing.email_button_color') ?: '#6b7280',
            'copy_link_button_color' => core()->getConfigData('wishlist_share.settings.social_sharing.copy_link_button_color') ?: '#16a34a',
        ];

        return view('wishlist-share::admin.settings.index', compact('settings'));
    }

    /**
     * Store the settings.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'add_to_wishlist_button_color' => 'required|string|max:7',
            'add_to_wishlist_button_label' => 'required|string|max:255',
            'view_product_button_color' => 'required|string|max:7',
            'view_product_button_label' => 'required|string|max:255',
            'facebook_button_color' => 'required|string|max:7',
            'twitter_button_color' => 'required|string|max:7',
            'linkedin_button_color' => 'required|string|max:7',
            'email_button_color' => 'required|string|max:7',
            'copy_link_button_color' => 'required|string|max:7',
        ]);

        $configData = [
            'wishlist_share.settings.buttons.add_to_wishlist_button_color' => $request->add_to_wishlist_button_color,
            'wishlist_share.settings.buttons.add_to_wishlist_button_label' => $request->add_to_wishlist_button_label,
            'wishlist_share.settings.buttons.view_product_button_color' => $request->view_product_button_color,
            'wishlist_share.settings.buttons.view_product_button_label' => $request->view_product_button_label,
            'wishlist_share.settings.social_sharing.facebook_button_color' => $request->facebook_button_color,
            'wishlist_share.settings.social_sharing.twitter_button_color' => $request->twitter_button_color,
            'wishlist_share.settings.social_sharing.linkedin_button_color' => $request->linkedin_button_color,
            'wishlist_share.settings.social_sharing.email_button_color' => $request->email_button_color,
            'wishlist_share.settings.social_sharing.copy_link_button_color' => $request->copy_link_button_color,
        ];

        foreach ($configData as $key => $value) {
            $this->coreConfigRepository->create([
                'code' => $key,
                'value' => $value,
                'channel_code' => core()->getCurrentChannel()->code,
                'locale_code' => core()->getCurrentLocale()->code,
            ]);
        }

        return response()->json([
            'message' => trans('wishlist-share::admin.settings-saved-successfully'),
            'redirect_url' => route('admin.wishlist-share.settings.index')
        ]);
    }
}