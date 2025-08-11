# Installation Guide

This guide will walk you through installing the Bagisto Wishlist Share package in your Bagisto project.

## Prerequisites

Before installing, ensure you have:

- **Bagisto 2.0+** installed and running
- **PHP 8.1+** 
- **Laravel 10.0+** or **11.0+**
- **Composer** installed
- **Node.js & NPM** for asset compilation

## Quick Installation

### Step 1: Install via Composer

```bash
composer require theihasan/bagisto-wishlist-share
```

### Step 2: Publish Package Resources

```bash
# Publish all resources at once
php artisan vendor:publish --provider="Ihasan\BagistoWishlistShare\Providers\WishlistShareServiceProvider"
```

### Step 3: Run Migrations

```bash
php artisan migrate
```

### Step 4: Build Assets

```bash
npm run build
```

### Step 5: Clear Cache

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

## Detailed Installation

### Manual Resource Publishing

If you prefer to publish resources individually:

```bash
# Configuration files
php artisan vendor:publish --tag=wishlist-share-config

# Assets (CSS, JS)
php artisan vendor:publish --tag=wishlist-share-assets

# Views (Blade templates)
php artisan vendor:publish --tag=wishlist-share-views

# Language files
php artisan vendor:publish --tag=wishlist-share-lang

# Injection script
php artisan vendor:publish --tag=wishlist-share-inject
```

### Environment Configuration

Add these optional environment variables to your `.env` file:

```env
# Wishlist Share Configuration
WISHLIST_SHARE_ENABLED=true
WISHLIST_SHARE_TOKEN_LENGTH=32
WISHLIST_SHARE_EXPIRES_DAYS=30
WISHLIST_SHARE_QR_SIZE=200
WISHLIST_SHARE_DEBUG=false
```

## Verification

### 1. Check Database Tables

Verify that the migration created the required tables:

```sql
SHOW TABLES LIKE 'wishlist_shares';
SHOW TABLES LIKE 'wishlist_share_items';
```

### 2. Check Published Files

Verify that files were published correctly:

```bash
# Check if injection script exists
ls -la public/wishlist-share-inject.js

# Check if config file exists
ls -la config/wishlist-share.php

# Check if views were published
ls -la resources/views/vendor/wishlist-share/
```

### 3. Test the Feature

1. Login to your Bagisto store as a customer
2. Add some products to your wishlist
3. Navigate to your wishlist page
4. Look for the "Share Wishlist" button
5. Click the button to open the share modal

## Troubleshooting

### Common Issues

#### 1. Share Button Not Appearing

**Solution:**
```bash
# Re-publish and rebuild assets
php artisan vendor:publish --tag=wishlist-share-inject --force
npm run build
php artisan cache:clear
```

#### 2. Modal Not Opening

**Check JavaScript Console:**
- Open browser developer tools
- Look for JavaScript errors
- Ensure `wishlist-share-inject.js` is loading

**Solution:**
```bash
# Clear view cache and rebuild
php artisan view:clear
npm run build
```

#### 3. Database Migration Errors

**Check Dependencies:**
```bash
# Ensure customers table exists
php artisan migrate:status
```

**Solution:**
```bash
# Run Bagisto migrations first
php artisan migrate
```

#### 4. Permission Errors

**Check File Permissions:**
```bash
# Fix storage permissions
chmod -R 775 storage/
chmod -R 775 bootstrap/cache/
```

#### 5. Asset Compilation Issues

**Clear Node Modules:**
```bash
rm -rf node_modules package-lock.json
npm install
npm run build
```

### Debug Mode

Enable debug mode for detailed logging:

```env
# .env
WISHLIST_SHARE_DEBUG=true
APP_DEBUG=true
```

Check logs:
```bash
tail -f storage/logs/laravel.log
```

## Advanced Configuration

### Custom Theme Integration

If you're using a custom theme, you may need to manually integrate the share functionality:

```blade
{{-- In your custom wishlist template --}}
@include('wishlist-share::components.wishlist-share-integration', [
    'buttonPosition' => 'inline',
    'showInlineButton' => true
])
```

### Multi-Store Setup

For multi-store setups, configure per-store settings:

```php
// config/wishlist-share.php
'multi_store' => [
    'store_1' => [
        'enabled' => true,
        'expires_in_days' => 30,
    ],
    'store_2' => [
        'enabled' => false,
    ],
],
```

## Next Steps

After successful installation:

1. **Configure Settings**: Visit Admin Panel → Wishlist Share → Settings
2. **Customize Appearance**: Modify colors, labels, and social sharing options
3. **Test Functionality**: Create test shares and verify all features work
4. **Monitor Analytics**: Check the analytics dashboard for usage metrics

## Getting Help

If you encounter issues:

1. **Check Documentation**: Review the main [README.md](README.md)
2. **Search Issues**: Look through [GitHub Issues](https://github.com/theihasan/bagisto-wishlist-share/issues)
3. **Create Issue**: Report bugs or request features
4. **Community Support**: Ask questions in Bagisto community forums

## Uninstallation

To remove the package:

```bash
# Remove package
composer remove theihasan/bagisto-wishlist-share

# Remove published files (optional)
rm -f public/wishlist-share-inject.js
rm -f config/wishlist-share.php
rm -rf resources/views/vendor/wishlist-share/

# Drop database tables (optional - will lose data!)
php artisan migrate:rollback --step=2
```

**Note:** Uninstalling will remove all wishlist share data. Export important data before uninstalling.