<?php

namespace Ihasan\BagistoWishlistShare\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WishlistShareRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->guard('customer')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'is_public' => 'boolean',
            'expires_in_days' => 'nullable|integer|min:1|max:365',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.max' => trans('wishlist-share::app.title-max-length'),
            'description.max' => trans('wishlist-share::app.description-max-length'),
            'expires_in_days.min' => trans('wishlist-share::app.expires-min-value'),
            'expires_in_days.max' => trans('wishlist-share::app.expires-max-value'),
        ];
    }
}
