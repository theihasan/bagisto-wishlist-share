# Bagisto Wishlist Share Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/theihasan/bagisto-wishlist-share.svg?style=flat-square)](https://packagist.org/packages/theihasan/bagisto-wishlist-share)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/theihasan/bagisto-wishlist-share/tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/theihasan/bagisto-wishlist-share/actions?query=workflow%3Atests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/theihasan/bagisto-wishlist-share/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/theihasan/bagisto-wishlist-share/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/theihasan/bagisto-wishlist-share.svg?style=flat-square)](https://packagist.org/packages/theihasan/bagisto-wishlist-share)
[![License](https://img.shields.io/packagist/l/theihasan/bagisto-wishlist-share.svg?style=flat-square)](https://packagist.org/packages/theihasan/bagisto-wishlist-share)

## Overview

The **Bagisto Wishlist Share** package is an enhanced wishlist sharing functionality for Bagisto e-commerce platform that allows customers to create shareable links for their wishlists with social media integration, QR code generation, and comprehensive admin management.

### **Package Structure**
```
packages/Webkul/WishlistShare/
├── src/
│   ├── Config/                 # Configuration files
│   ├── Contracts/             # Interface contracts
│   ├── Database/              # Migrations and seeders
│   ├── Events/                # Event classes
│   ├── Http/                  # Controllers and requests
│   ├── Listeners/             # Event listeners
│   ├── Models/                # Eloquent models
│   ├── Providers/             # Service providers
│   ├── Repositories/          # Repository pattern
│   ├── Resources/
│   │   ├── assets/
│   │   │   ├── css/          # Package stylesheets
│   │   │   └── js/           # JavaScript files
│   │   │       └── wishlist-share-inject.js  # Universal injection script
│   │   ├── lang/             # Language files
│   │   └── views/            # Blade templates
│   │       ├── admin/        # Admin panel views
│   │       ├── customer/     # Customer-facing views
│   │       └── components/   # Reusable components
│   └── Routes/               # Route definitions
├── composer.json             # Package dependencies
├── package.json             # Frontend dependencies
└── README.md               # This documentation
```

### **Key Files**
- **`wishlist-share-inject.js`**: Universal theme compatibility script (published to `public/`)
- **`WishlistShareServiceProvider.php`**: Main service provider with auto-integration
- **`WishlistShare.php`**: Main model with sharing logic
- **`WishlistShareController.php`**: API and web controllers
- **`share-modal.blade.php`**: Modal component for sharing interface
- **`wishlist-share-integration.blade.php`**: Integration component for themes

## Features

### 🎯 Core Features
- **Shareable Wishlist Links**: Generate unique, secure links for wishlist sharing
- **Social Media Integration**: Share wishlists on Facebook, Twitter, LinkedIn, and via email
- **QR Code Generation**: Automatic QR code creation for easy mobile sharing
- **Expiration Management**: Configurable expiration dates for shared wishlists
- **Privacy Controls**: Public/private wishlist sharing options
- **View Tracking**: Track how many times a shared wishlist has been viewed

### 📊 Admin Features
- **Analytics Dashboard**: Comprehensive analytics with date range filtering
- **Share Management**: View, manage, and delete customer wishlist shares
- **Bulk Operations**: Mass delete expired or selected shares
- **Export Functionality**: Export share data to CSV
- **Settings Configuration**: Customize button colors, labels, and social sharing options
- **Platform Statistics**: Track sharing across different social platforms

### 🎨 Frontend Features
- **Modal Interface**: Clean, user-friendly sharing modal
- **Responsive Design**: Mobile-optimized sharing interface
- **Copy to Clipboard**: One-click link copying functionality
- **QR Code Display**: In-modal QR code generation and download
- **Social Sharing Buttons**: Direct sharing to social platforms

## Installation & Integration

### Requirements
- PHP ^8.2
- Laravel ^11.0
- Bagisto e-commerce platform (v2.0+)
- endroid/qr-code ^5.0
- Node.js & NPM (for asset compilation)

### Step-by-Step Installation

#### 1. **Install via Composer**
```bash
composer require theihasan/bagisto-wishlist-share
```

#### 2. **Register Service Provider** (Auto-discovery enabled)
If auto-discovery is disabled, manually add to `config/app.php`:
```php
'providers' => [
    // ...
    Ihasan\BagistoWishlistShare\Providers\WishlistShareServiceProvider::class,
],
```

#### 3. **Publish Package Resources**
```bash
# Publish all package resources
php artisan vendor:publish --provider="Ihasan\BagistoWishlistShare\Providers\WishlistShareServiceProvider"

# Or publish individually:
php artisan vendor:publish --tag=wishlist-share-config
php artisan vendor:publish --tag=wishlist-share-assets
php artisan vendor:publish --tag=wishlist-share-views
php artisan vendor:publish --tag=wishlist-share-lang
php artisan vendor:publish --tag=wishlist-share-inject
```

#### 4. **Run Database Migrations**
```bash
php artisan migrate
```

#### 5. **Compile Assets**
```bash
# If using Vite (Bagisto 2.0+)
npm run build

# Or if using Laravel Mix
npm run production
```

#### 6. **Clear Application Cache**
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

#### 7. **Seed Sample Data** (Optional)
```bash
php artisan db:seed --class="Ihasan\BagistoWishlistShare\Database\Seeders\WishlistShareSeeder"
```

### Integration into Existing Bagisto Project

#### **Method 1: Package Installation (Recommended)**
Follow the installation steps above. The package will automatically integrate with your existing Bagisto installation.

#### **Method 2: Manual Integration**
If you want to customize or integrate manually:

1. **Copy Package Files**
```bash
# Copy the package to your packages directory
cp -r vendor/theihasan/bagisto-wishlist-share packages/Webkul/WishlistShare
```

2. **Update Composer.json**
```json
{
    "autoload": {
        "psr-4": {
            "Ihasan\\BagistoWishlistShare\\": "packages/Webkul/WishlistShare/src/"
        }
    }
}
```

3. **Register in packages.php**
Add to `config/concord.php`:
```php
'modules' => [
    // ... existing modules
    Ihasan\BagistoWishlistShare\Providers\ModuleServiceProvider::class,
]
```

#### **Method 3: Development Setup**
For package development:

1. **Clone Repository**
```bash
git clone https://github.com/theihasan/bagisto-wishlist-share.git packages/Webkul/WishlistShare
```

2. **Install Dependencies**
```bash
cd packages/Webkul/WishlistShare
composer install
npm install
```

3. **Build Assets**
```bash
npm run build
```

### Post-Installation Configuration

#### **1. Environment Variables**
Add to your `.env` file:
```env
# Wishlist Share Configuration
WISHLIST_SHARE_ENABLED=true
WISHLIST_SHARE_TOKEN_LENGTH=32
WISHLIST_SHARE_EXPIRES_DAYS=30
WISHLIST_SHARE_QR_SIZE=200
```

#### **2. Admin Configuration**
1. Login to Bagisto Admin Panel
2. Navigate to **Configuration → Wishlist Share**
3. Configure social sharing settings
4. Set button colors and labels
5. Enable/disable features as needed

#### **3. Theme Integration**
The package automatically integrates with the default Bagisto theme. For custom themes:

**Add to your wishlist template:**
```blade
@if(config('wishlist-share.enabled'))
    @wishlistShare
    @wishlistShareAssets
@endif
```

**Or manually include:**
```blade
@include('wishlist-share::customer.share-modal')
```

#### **4. Custom Styling**
Override default styles by publishing views and modifying:
```bash
php artisan vendor:publish --tag=wishlist-share-views
```

Edit: `resources/views/vendor/wishlist-share/customer/share-modal.blade.php`

## Configuration

### Basic Configuration

The package configuration is located at `config/wishlist-share.php`:

```php
return [
    'enabled' => true,
    
    'social_platforms' => [
        'facebook' => [
            'enabled' => true,
            'url' => 'https://www.facebook.com/sharer/sharer.php?u=',
        ],
        'twitter' => [
            'enabled' => true,
            'url' => 'https://twitter.com/intent/tweet?url=',
        ],
        'linkedin' => [
            'enabled' => true,
            'url' => 'https://www.linkedin.com/sharing/share-offsite/?url=',
        ],
        'email' => [
            'enabled' => true,
            'subject' => 'Check out my wishlist',
        ],
    ],
    
    'qr_code' => [
        'enabled' => true,
        'size' => 200,
        'margin' => 10,
    ],
    
    'share_token' => [
        'length' => 32,
        'expires_in_days' => 30,
    ],
];
```

### Admin Settings

Access admin settings via: **Admin Panel → Wishlist Share → Settings**

Configure:
- Button colors and labels
- Social sharing button colors
- Add to wishlist button customization
- View product button customization

## Database Schema

### wishlist_shares Table
```sql
- id (Primary Key)
- customer_id (Foreign Key to customers table)
- share_token (Unique 64-character string)
- title (Nullable string)
- description (Nullable text)
- is_public (Boolean, default: true)
- expires_at (Nullable timestamp)
- view_count (Integer, default: 0)
- shared_platforms (JSON, nullable)
- created_at, updated_at (Timestamps)
```

### wishlist_share_items Table
```sql
- id (Primary Key)
- wishlist_share_id (Foreign Key to wishlist_shares table)
- product_id (Foreign Key to products table)
- product_options (JSON, nullable)
- quantity (Integer, default: 1)
- created_at, updated_at (Timestamps)
```

## API Endpoints

### Customer API Routes (Authenticated)
- `POST /api/wishlist-share/create` - Create a new wishlist share
- `GET /api/wishlist-share/my-shares` - Get user's wishlist shares

### Public API Routes
- `GET /api/wishlist-share/{token}` - View shared wishlist data

### Web Routes
- `POST /customer/account/wishlist/share/create` - Create wishlist share
- `GET /customer/account/wishlist/share/{token}/qr` - Generate QR code
- `DELETE /customer/account/wishlist/share/{token}` - Delete wishlist share
- `GET /shared-wishlist/{token}` - View shared wishlist page

## Developer Integration Guide

### **Integration Methods**

The package provides multiple integration methods to work with different Bagisto themes and customization needs:

#### **Method 1: Automatic Integration (Recommended)**
The package automatically integrates with the default Bagisto wishlist page by:
- Adding a "Share Wishlist" button next to the "Delete All" button
- Including the share modal and injection script
- Using the `wishlist-share-inject.js` for universal theme compatibility

#### **Method 2: Component Integration**
```blade
<!-- In your custom wishlist template -->
@include('wishlist-share::components.wishlist-share-integration', [
    'buttonPosition' => 'inline',     // 'inline' or 'floating'
    'showInlineButton' => true,       // Show additional inline button
    'floatingPosition' => [           // Custom floating position
        'top' => '150px',
        'right' => '20px'
    ]
])
```

#### **Method 3: Manual Integration**
```blade
<!-- In your custom wishlist template -->
<div class="wishlist-actions">
    @if(auth('customer')->check() && config('wishlist-share.enabled'))
        <button onclick="document.getElementById('wishlist-share-modal').style.display = 'flex'" class="btn btn-primary">
            <i class="fas fa-share-alt"></i> Share Wishlist
        </button>
    @endif
</div>

<!-- Include the share modal -->
@include('wishlist-share::customer.share-modal')
<script src="{{ asset('wishlist-share-inject.js') }}" defer></script>
```

### **Frontend Integration**

#### **1. Adding Share Button to Custom Templates**
```blade
<!-- In your custom wishlist template -->
<div class="wishlist-actions">
    @if(auth('customer')->check() && config('wishlist-share.enabled'))
        <button onclick="openWishlistShareModal()" class="btn btn-primary">
            <i class="fas fa-share-alt"></i> Share Wishlist
        </button>
    @endif
</div>

<!-- Include the share modal -->
@wishlistShare
@wishlistShareAssets
```

#### **2. JavaScript Integration**
```javascript
// Custom share button handler
function openWishlistShareModal() {
    document.getElementById('wishlist-share-modal').style.display = 'flex';
}

// Listen for share events
document.addEventListener('wishlist-shared', function(event) {
    console.log('Wishlist shared:', event.detail);
    // Custom tracking or analytics
});
```

#### **3. CSS Customization**
```css
/* Override default styles */
.wishlist-share-modal {
    /* Custom modal styles */
}

.wishlist-share-btn {
    background-color: var(--primary-color);
    /* Custom button styles */
}
```

### **Backend Integration**

#### **1. Custom Controller Integration**
```php
<?php

namespace App\Http\Controllers;

use Ihasan\BagistoWishlistShare\Repositories\WishlistShareRepository;

class CustomWishlistController extends Controller
{
    public function __construct(
        protected WishlistShareRepository $wishlistShareRepository
    ) {}

    public function myCustomShares()
    {
        $customer = auth('customer')->user();
        
        $shares = $this->wishlistShareRepository
            ->where('customer_id', $customer->id)
            ->with(['items.product'])
            ->get();
            
        return view('custom.my-shares', compact('shares'));
    }
}
```

#### **2. Event Listeners**
```php
<?php

namespace App\Listeners;

use Ihasan\BagistoWishlistShare\Events\WishlistShared;

class CustomWishlistShareListener
{
    public function handle(WishlistShared $event)
    {
        $wishlistShare = $event->wishlistShare;
        
        // Custom logic: send notification, track analytics, etc.
        $this->sendNotificationToAdmin($wishlistShare);
        $this->trackCustomAnalytics($wishlistShare);
    }
}
```

Register in `EventServiceProvider`:
```php
protected $listen = [
    WishlistShared::class => [
        CustomWishlistShareListener::class,
    ],
];
```

#### **3. Custom Repository Methods**
```php
<?php

namespace App\Repositories;

use Ihasan\BagistoWishlistShare\Repositories\WishlistShareRepository;

class CustomWishlistShareRepository extends WishlistShareRepository
{
    public function getPopularShares($limit = 10)
    {
        return $this->model
            ->orderBy('view_count', 'desc')
            ->limit($limit)
            ->get();
    }
    
    public function getSharesByDateRange($startDate, $endDate)
    {
        return $this->model
            ->whereBetween('created_at', [$startDate, $endDate])
            ->with(['customer', 'items'])
            ->get();
    }
}
```

### **API Integration**

#### **1. Custom API Endpoints**
```php
<?php

// routes/api.php
Route::middleware('auth:sanctum')->group(function () {
    Route::get('my-wishlist-shares', [CustomApiController::class, 'myShares']);
    Route::post('share-wishlist', [CustomApiController::class, 'createShare']);
});

// Controller
class CustomApiController extends Controller
{
    public function myShares(Request $request)
    {
        $shares = app(WishlistShareRepository::class)
            ->where('customer_id', auth()->id())
            ->paginate($request->get('per_page', 15));
            
        return response()->json([
            'data' => $shares,
            'message' => 'Shares retrieved successfully'
        ]);
    }
}
```

#### **2. Mobile App Integration**
```javascript
// React Native / Mobile App
const shareWishlist = async (wishlistData) => {
    try {
        const response = await fetch('/api/wishlist-share/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify(wishlistData)
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Handle successful share
            shareToSocialMedia(result.data.share_url);
        }
    } catch (error) {
        console.error('Share failed:', error);
    }
};
```

### **Testing Integration**

#### **1. Feature Tests**
```php
<?php

namespace Tests\Feature;

use Tests\TestCase;
use Webkul\Customer\Models\Customer;
use Ihasan\BagistoWishlistShare\Models\WishlistShare;

class WishlistShareTest extends TestCase
{
    public function test_customer_can_create_wishlist_share()
    {
        $customer = Customer::factory()->create();
        
        $response = $this->actingAs($customer, 'customer')
            ->post('/customer/account/wishlist/share/create', [
                'title' => 'My Test Wishlist',
                'description' => 'Test description',
                'is_public' => true,
                'expires_in_days' => 30
            ]);
            
        $response->assertStatus(200)
            ->assertJson(['success' => true]);
            
        $this->assertDatabaseHas('wishlist_shares', [
            'customer_id' => $customer->id,
            'title' => 'My Test Wishlist'
        ]);
    }
}
```

## Usage

### For Customers

1. **Creating a Share**:
   - Navigate to your wishlist
   - Click the "Share Wishlist" button
   - Fill in title and description (optional)
   - Set expiration date
   - Choose privacy settings
   - Click "Create Share Link"

2. **Sharing Options**:
   - Copy link to clipboard
   - Share on social media (Facebook, Twitter, LinkedIn)
   - Send via email
   - Download/display QR code

### For Administrators

1. **Analytics Dashboard**:
   - View total shares, views, and conversion metrics
   - Filter by date ranges (7, 30, 90 days, 1 year)
   - Monitor top-performing shares
   - Track platform-wise sharing statistics

2. **Share Management**:
   - View all customer shares
   - Filter and search shares
   - Delete individual or bulk shares
   - Clean up expired shares
   - Export share data

## Customization

### Blade Directives

The package provides custom Blade directives:

```blade
@wishlistShare
<!-- Renders the share modal -->

@wishlistShareAssets
<!-- Includes package CSS and JS assets -->
```

### View Customization

Published views can be customized at:
- `resources/views/vendor/wishlist-share/customer/share-modal.blade.php`
- `resources/views/vendor/wishlist-share/customer/shared-wishlist.blade.php`
- `resources/views/vendor/wishlist-share/admin/`

### Language Customization

Language files are published to:
- `resources/lang/vendor/wishlist-share/en/app.php`
- `resources/lang/vendor/wishlist-share/en/admin.php`

## Events

### WishlistShared Event
Fired when a wishlist is shared:

```php
use Ihasan\BagistoWishlistShare\Events\WishlistShared;

// Event data includes:
// - $wishlistShare (WishlistShare model instance)
```

### Event Listeners
- `LogWishlistShare` - Logs wishlist sharing activity

## Models

### WishlistShare Model
**Location**: `src/Models/WishlistShare.php`

**Key Methods**:
- `isExpired()` - Check if share has expired
- `isAccessible()` - Check if share is public and not expired
- `incrementViewCount()` - Increment view counter

**Relationships**:
- `customer()` - Belongs to Customer
- `items()` - Has many WishlistShareItem

### WishlistShareItem Model
**Location**: `src/Models/WishlistShareItem.php`

**Relationships**:
- `wishlistShare()` - Belongs to WishlistShare
- `product()` - Belongs to Product

## Repository Pattern

### WishlistShareRepository
**Location**: `src/Repositories/WishlistShareRepository.php`

**Key Methods**:
- `findByToken($token)` - Find share by token
- `getFilteredShares($filters)` - Get filtered shares for admin
- `getAnalyticsData($filters)` - Get analytics data
- `cleanExpiredShares()` - Remove expired shares

## Universal Theme Compatibility

### **Injection Script (`wishlist-share-inject.js`)**

The package includes a universal injection script that provides theme-agnostic integration:

#### **Features:**
- **Auto-Detection**: Automatically detects wishlist pages
- **Smart Placement**: Tries multiple strategies to place the share button optimally
- **Fallback Support**: Uses floating button if inline placement fails
- **Theme Compatibility**: Works with Velocity, custom themes, and future Bagisto versions
- **Responsive Design**: Adapts to mobile and desktop layouts
- **Error Handling**: Graceful degradation with retry mechanisms

#### **Placement Strategies:**
1. **Inline Placement**: Attempts to place button near existing UI elements
2. **Floating Placement**: Falls back to a floating button with animations
3. **Text-based Detection**: Finds elements by text content ("Delete All", "Wishlist")
4. **CSS Selector Matching**: Uses common Bagisto theme selectors

#### **Configuration:**
```javascript
// The script can be configured via window.WishlistShareConfig
window.WishlistShareConfig = {
    enabled: true,
    debug: false,
    buttonPosition: 'floating', // 'inline' or 'floating'
    floatingPosition: {
        top: '200px',
        right: '20px'
    }
};
```

## Security Features

- **Unique Tokens**: 32-character random tokens for share URLs
- **Expiration Control**: Automatic expiration of shared links
- **Privacy Settings**: Public/private sharing options
- **Customer Ownership**: Users can only manage their own shares
- **Token Validation**: Secure token validation for access control
- **CSRF Protection**: Full CSRF token validation for API calls

## Performance Considerations

- **Database Indexing**: Optimized indexes on frequently queried columns
- **Eager Loading**: Efficient relationship loading to prevent N+1 queries
- **Caching**: QR codes cached with appropriate headers
- **Bulk Operations**: Efficient bulk delete operations for cleanup

## Quick Start Guide

### **5-Minute Setup**
```bash
# 1. Install package
composer require theihasan/bagisto-wishlist-share

# 2. Publish and migrate
php artisan vendor:publish --provider="Ihasan\BagistoWishlistShare\Providers\WishlistShareServiceProvider"
php artisan migrate

# 3. Build assets
npm run build

# 4. Clear cache
php artisan config:clear && php artisan cache:clear

# 5. Test - Visit your wishlist page and look for the share button!
```

### **Verification Checklist**
- [ ] Package installed via Composer
- [ ] Migrations run successfully
- [ ] Assets published and compiled
- [ ] Share button appears on wishlist page
- [ ] Modal opens when clicking share button
- [ ] Admin menu shows "Wishlist Share" section

## Troubleshooting

### **Installation Issues**

1. **Composer Installation Fails**:
```bash
# Clear composer cache
composer clear-cache

# Update composer
composer self-update

# Install with verbose output
composer require theihasan/bagisto-wishlist-share -vvv
```

2. **Migration Errors**:
```bash
# Check if tables already exist
php artisan migrate:status

# Rollback if needed
php artisan migrate:rollback --step=2

# Re-run migrations
php artisan migrate
```

3. **Asset Compilation Issues**:
```bash
# Clear node modules
rm -rf node_modules package-lock.json

# Reinstall dependencies
npm install

# Build with verbose output
npm run build -- --verbose
```

### **Runtime Issues**

1. **Share Modal Not Appearing**:
   - **Check Assets**: Ensure CSS/JS files are loaded
   ```bash
   php artisan vendor:publish --tag=wishlist-share-assets --force
   npm run build
   ```
   - **Verify Blade Directives**: Check if `@wishlistShare` is included
   - **Browser Console**: Look for JavaScript errors
   - **Theme Compatibility**: Ensure your theme supports the modal structure

2. **QR Code Not Generating**:
   - **Check Dependencies**:
   ```bash
   composer show endroid/qr-code
   ```
   - **PHP Extensions**: Ensure GD or Imagick is installed
   ```bash
   php -m | grep -i gd
   ```
   - **File Permissions**: Check temp directory permissions
   ```bash
   chmod 755 storage/app/temp
   ```

3. **Social Sharing Not Working**:
   - **URL Encoding**: Check if URLs are properly encoded
   - **HTTPS**: Ensure your site uses HTTPS for social sharing
   - **Configuration**: Verify social platform URLs in config
   ```php
   // config/wishlist-share.php
   'social_platforms' => [
       'facebook' => [
           'enabled' => true,
           'url' => 'https://www.facebook.com/sharer/sharer.php?u=',
       ],
   ]
   ```

4. **Database Issues**:
   - **Foreign Key Constraints**: Ensure customer table exists
   ```sql
   SHOW CREATE TABLE customers;
   ```
   - **Index Issues**: Check if indexes are created properly
   ```sql
   SHOW INDEX FROM wishlist_shares;
   ```

5. **Permission Issues**:
   - **Admin Access**: Check ACL permissions
   ```bash
   php artisan cache:clear
   ```
   - **Customer Authentication**: Verify customer guard is working
   ```php
   // Check in controller
   dd(auth('customer')->check());
   ```

### **Development Issues**

1. **Package Not Auto-Loading**:
```bash
# Regenerate autoload files
composer dump-autoload

# Clear application cache
php artisan config:clear
php artisan route:clear
```

2. **Views Not Updating**:
```bash
# Clear view cache
php artisan view:clear

# Re-publish views
php artisan vendor:publish --tag=wishlist-share-views --force
```

3. **Routes Not Working**:
```bash
# Check route list
php artisan route:list | grep wishlist-share

# Clear route cache
php artisan route:clear
```

### **Debug Mode**
Enable debug mode for detailed error logging:

```php
// config/wishlist-share.php
'debug' => env('WISHLIST_SHARE_DEBUG', false),
```

```env
# .env
WISHLIST_SHARE_DEBUG=true
APP_DEBUG=true
```

### **Performance Issues**

1. **Slow Loading**:
   - Enable query logging to identify N+1 queries
   - Use eager loading for relationships
   - Implement caching for frequently accessed data

2. **Memory Issues**:
   - Increase PHP memory limit
   - Optimize database queries
   - Use pagination for large datasets

### **Getting Help**

1. **Check Logs**:
```bash
tail -f storage/logs/laravel.log
```

2. **Enable Query Logging**:
```php
// In AppServiceProvider boot method
DB::listen(function ($query) {
    Log::info($query->sql, $query->bindings);
});
```

3. **Community Support**:
   - GitHub Issues: Report bugs and feature requests
   - Bagisto Community: Ask questions in forums
   - Stack Overflow: Tag questions with `bagisto` and `wishlist-share`

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests for new functionality
5. Submit a pull request

## License

This package is licensed under the MIT License.

## Support

For support and bug reports, please create an issue in the package repository.

## Screenshots

### Customer Wishlist Sharing
![Wishlist Share Button](https://via.placeholder.com/800x400/667eea/ffffff?text=Wishlist+Share+Button)

### Share Modal
![Share Modal](https://via.placeholder.com/600x500/764ba2/ffffff?text=Share+Modal+Interface)

### Admin Analytics Dashboard
![Admin Dashboard](https://via.placeholder.com/800x600/667eea/ffffff?text=Admin+Analytics+Dashboard)

## Testing

```bash
# Run tests
composer test

# Run tests with coverage
composer test-coverage

# Run specific test
vendor/bin/phpunit tests/Feature/WishlistShareTest.php
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

If you discover a security vulnerability, please send an e-mail to ihasan@example.com. All security vulnerabilities will be promptly addressed.

## Credits

- [Ihasan](https://github.com/theihasan)

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

### Version 1.0.0
- Initial release
- Core wishlist sharing functionality
- Social media integration
- QR code generation
- Admin analytics dashboard
- Comprehensive settings management