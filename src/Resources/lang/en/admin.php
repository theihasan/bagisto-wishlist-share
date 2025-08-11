<?php

return [
    // Menu and Navigation
    'wishlist-share' => 'Wishlist Share',
    'wishlist-share-analytics' => 'Wishlist Share Analytics',
    'wishlist-shares' => 'Wishlist Shares',
    'analytics' => 'Analytics',
    'shares' => 'Shares',
    
    // Analytics Dashboard
    'total-shares' => 'Total Shares',
    'total-views' => 'Total Views',
    'active-shares' => 'Active Shares',
    'expired-shares' => 'Expired Shares',
    'shares-and-views-over-time' => 'Shares and Views Over Time',
    'sharing-platforms' => 'Sharing Platforms',
    'top-performing-shares' => 'Top Performing Shares',
    'recent-activity' => 'Recent Activity',
    'last-7-days' => 'Last 7 Days',
    'last-30-days' => 'Last 30 Days',
    'last-90-days' => 'Last 90 Days',
    'last-year' => 'Last Year',
    'export-data' => 'Export Data',
    'cleanup-expired' => 'Cleanup Expired',
    'view-all-shares' => 'View All Shares',
    'view-analytics' => 'View Analytics',
    
    // Table Headers
    'title' => 'Title',
    'customer' => 'Customer',
    'items' => 'Items',
    'views' => 'Views',
    'status' => 'Status',
    'created-at' => 'Created At',
    'expires-at' => 'Expires At',
    'actions' => 'Actions',
    'date' => 'Date',
    'shares' => 'Shares',
    
    // Status Labels
    'active' => 'Active',
    'expired' => 'Expired',
    'private' => 'Private',
    'never' => 'Never',
    'untitled' => 'Untitled',
    
    // Filters and Search
    'search' => 'Search',
    'search-placeholder' => 'Search by title, customer name or email...',
    'all-statuses' => 'All Statuses',
    'date-from' => 'Date From',
    'date-to' => 'Date To',
    'filter' => 'Filter',
    'reset' => 'Reset',
    'shares-list' => 'Shares List',
    
    // Actions
    'view' => 'View',
    'view-details' => 'View Details',
    'view-public' => 'View Public Page',
    'view-public-page' => 'View Public Page',
    'edit' => 'Edit',
    'delete' => 'Delete',
    'delete-share' => 'Delete Share',
    'delete-selected' => 'Delete Selected',
    'copy' => 'Copy',
    'download-qr' => 'Download QR Code',
    'edit-product' => 'Edit Product',
    'view-customer' => 'View Customer',
    
    // Share Details
    'share-details' => 'Share Details',
    'share-information' => 'Share Information',
    'customer-information' => 'Customer Information',
    'wishlist-items' => 'Wishlist Items',
    'description' => 'Description',
    'view-count' => 'View Count',
    'share-url' => 'Share URL',
    'shared-on-platforms' => 'Shared on Platforms',
    'qr-code' => 'QR Code',
    'qr-code-description' => 'Scan this QR code to view the wishlist',
    'statistics' => 'Statistics',
    'total-items' => 'Total Items',
    'days-active' => 'Days Active',
    'days-remaining' => 'Days Remaining',
    'customer-since' => 'Customer Since',
    
    // Messages
    'no-shares-found' => 'No shares found',
    'no-shares-description' => 'No wishlist shares have been created yet.',
    'no-recent-activity' => 'No recent activity',
    'no-items-in-wishlist' => 'No items in this wishlist',
    'no-shares-selected' => 'No shares selected',
    'shared-wishlist' => 'shared a wishlist',
    'url-copied' => 'URL copied to clipboard!',
    
    // Confirmations
    'confirm-delete-share' => 'Are you sure you want to delete this share?',
    'confirm-delete-shares' => 'Are you sure you want to delete',
    'confirm-cleanup-expired' => 'Are you sure you want to cleanup all expired shares? This action cannot be undone.',
    
    // Success Messages
    'share-deleted-successfully' => 'Share deleted successfully',
    'shares-deleted-successfully' => ':count shares deleted successfully',
    'expired-shares-cleaned' => ':count expired shares cleaned up successfully',
    
    // Error Messages
    'error-deleting-share' => 'Error deleting share',
    'error-deleting-shares' => 'Error deleting shares',
    'error-cleaning-expired-shares' => 'Error cleaning up expired shares',
    'error-occurred' => 'An error occurred. Please try again.',
    
    // Chart Labels
    'shares-chart-label' => 'Shares',
    'views-chart-label' => 'Views',
    
    // Platform Names
    'facebook' => 'Facebook',
    'twitter' => 'Twitter',
    'linkedin' => 'LinkedIn',
    'email' => 'Email',
    'copy-link' => 'Copy Link',
    
    // Bulk Actions
    'bulk-actions' => 'Bulk Actions',
    'select-all' => 'Select All',
    'with-selected' => 'With Selected',
    
    // Export
    'export-csv' => 'Export CSV',
    'export-excel' => 'Export Excel',
    'export-pdf' => 'Export PDF',
    
    // Permissions
    'wishlist-share-analytics' => 'Wishlist Share Analytics',
    'wishlist-share-management' => 'Wishlist Share Management',
    'view-analytics' => 'View Analytics',
    'manage-shares' => 'Manage Shares',
    'delete-shares' => 'Delete Shares',
    'export-analytics' => 'Export Analytics',
    
    // Settings
    'settings' => 'Settings',
    'general-settings' => 'General Settings',
    'enable-sharing' => 'Enable Wishlist Sharing',
    'enable-qr-codes' => 'Enable QR Codes',
    'default-expiry-days' => 'Default Expiry Days',
    'max-expiry-days' => 'Maximum Expiry Days',
    'enable-analytics' => 'Enable Analytics Tracking',
    'cleanup-frequency' => 'Cleanup Frequency',
    'social-platforms' => 'Social Platforms',
    'enable-facebook' => 'Enable Facebook Sharing',
    'enable-twitter' => 'Enable Twitter Sharing',
    'enable-linkedin' => 'Enable LinkedIn Sharing',
    'enable-email' => 'Enable Email Sharing',
    
    // Validation Messages
    'title-required' => 'Title is required',
    'title-max-length' => 'Title cannot exceed 255 characters',
    'description-max-length' => 'Description cannot exceed 1000 characters',
    'expiry-days-min' => 'Expiry days must be at least 1',
    'expiry-days-max' => 'Expiry days cannot exceed 365',
    
    // Help Text
    'analytics-help' => 'View detailed analytics about wishlist sharing activity including views, shares, and platform statistics.',
    'shares-help' => 'Manage all wishlist shares created by customers. You can view, delete, and monitor share activity.',
    'cleanup-help' => 'Automatically remove expired shares to keep your database clean and improve performance.',
    'export-help' => 'Export analytics data to CSV format for further analysis or reporting.',
    
    // Dashboard Widgets
    'widget-total-shares' => 'Total Shares',
    'widget-total-views' => 'Total Views',
    'widget-active-shares' => 'Active Shares',
    'widget-top-customer' => 'Top Customer',
    'widget-most-viewed' => 'Most Viewed Share',
    'widget-recent-shares' => 'Recent Shares',
    
    // Time Periods
    'today' => 'Today',
    'yesterday' => 'Yesterday',
    'this-week' => 'This Week',
    'this-month' => 'This Month',
    'this-year' => 'This Year',
    'custom-range' => 'Custom Range',
    
    // Growth Indicators
    'growth-up' => 'Growth',
    'growth-down' => 'Decline',
    'no-change' => 'No Change',
    'vs-previous-period' => 'vs previous period',
    
    // Settings Page
    'save-settings' => 'Save Settings',
    'settings-saved-successfully' => 'Settings saved successfully!',
    'preview' => 'Preview',
    'preview-description' => 'See how your buttons will look with the current settings',
    
    // System Configuration
    'system' => [
        'title' => 'Wishlist Share',
        'info' => 'Configure wishlist sharing settings and appearance',
        'settings' => [
            'title' => 'Settings',
            'info' => 'Customize wishlist share appearance and behavior',
            'buttons' => [
                'title' => 'Button Settings',
                'info' => 'Customize button colors and labels',
                'add-to-wishlist-color' => 'Add to Wishlist Button Color',
                'add-to-wishlist-label' => 'Add to Wishlist Button Label',
                'view-product-color' => 'View Product Button Color',
                'view-product-label' => 'View Product Button Label',
            ],
            'social-sharing' => [
                'title' => 'Social Sharing Buttons',
                'info' => 'Customize social sharing button colors',
                'facebook-color' => 'Facebook Button Color',
                'twitter-color' => 'Twitter Button Color',
                'linkedin-color' => 'LinkedIn Button Color',
                'email-color' => 'Email Button Color',
                'copy-link-color' => 'Copy Link Button Color',
            ],
        ],
    ],
];