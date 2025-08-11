# Publishing Guide

This guide explains how to publish the Bagisto Wishlist Share package to GitHub and Packagist.

## GitHub Repository Setup

### 1. Create GitHub Repository

1. Go to [GitHub](https://github.com) and create a new repository
2. Repository name: `bagisto-wishlist-share`
3. Description: `Enhanced wishlist sharing functionality for Bagisto with social media integration`
4. Make it public
5. Don't initialize with README (we have our own)

### 2. Upload Package Files

Upload the entire contents of `/packages/Webkul/WishlistShare/` to your GitHub repository.

**Required Files Structure:**
```
bagisto-wishlist-share/
├── .github/
│   ├── workflows/
│   │   ├── tests.yml
│   │   └── fix-php-code-style-issues.yml
│   └── ISSUE_TEMPLATE/
│       ├── bug_report.md
│       └── feature_request.md
├── src/
│   ├── Config/
│   ├── Contracts/
│   ├── Database/
│   ├── Events/
│   ├── Http/
│   ├── Listeners/
│   ├── Models/
│   ├── Providers/
│   ├── Repositories/
│   ├── Resources/
│   └── Routes/
├── tests/
│   ├── Feature/
│   └── TestCase.php
├── .gitignore
├── CHANGELOG.md
├── composer.json
├── CONTRIBUTING.md
├── INSTALLATION.md
├── LICENSE
├── package.json
├── phpunit.xml
├── postcss.config.js
├── PUBLISH.md (this file)
├── README.md
├── tailwind.config.js
└── vite.config.js
```

### 3. Initial Git Commands

```bash
# Navigate to your package directory
cd /Users/figlab/Desktop/sites/bagisto/packages/Webkul/WishlistShare

# Initialize git repository
git init

# Add all files
git add .

# Initial commit
git commit -m "Initial release of Bagisto Wishlist Share package

- Enhanced wishlist sharing functionality
- Social media integration (Facebook, Twitter, LinkedIn, Email)
- QR code generation for mobile sharing
- Admin analytics dashboard
- Universal theme compatibility
- Comprehensive documentation"

# Add remote origin (replace with your GitHub URL)
git remote add origin https://github.com/theihasan/bagisto-wishlist-share.git

# Push to GitHub
git branch -M main
git push -u origin main
```

### 4. Create Release Tag

```bash
# Create and push version tag
git tag -a v1.0.0 -m "Release version 1.0.0

Features:
- Shareable wishlist links with unique tokens
- Social media integration
- QR code generation
- Admin analytics dashboard
- Universal theme compatibility
- Comprehensive API and documentation"

git push origin v1.0.0
```

## Packagist Registration

### 1. Register on Packagist

1. Go to [Packagist.org](https://packagist.org)
2. Sign up or login with your GitHub account
3. Click "Submit" in the top navigation

### 2. Submit Package

1. Enter your GitHub repository URL: `https://github.com/theihasan/bagisto-wishlist-share`
2. Click "Check" to validate
3. If validation passes, click "Submit"

### 3. Setup Auto-Update Hook

1. Go to your package page on Packagist
2. Click "Settings" tab
3. Copy the webhook URL
4. Go to your GitHub repository settings
5. Navigate to "Webhooks"
6. Add webhook with the Packagist URL
7. Set content type to `application/json`
8. Select "Just the push event"

## Installation Testing

After publishing, test the installation:

```bash
# Create a test Bagisto project
composer create-project bagisto/bagisto test-project

# Navigate to project
cd test-project

# Install your package
composer require theihasan/bagisto-wishlist-share

# Follow installation steps
php artisan vendor:publish --provider="Ihasan\BagistoWishlistShare\Providers\WishlistShareServiceProvider"
php artisan migrate
npm run build
```

## Version Management

### Semantic Versioning

Follow [Semantic Versioning](https://semver.org/):

- **MAJOR** version (1.0.0 → 2.0.0): Breaking changes
- **MINOR** version (1.0.0 → 1.1.0): New features, backward compatible
- **PATCH** version (1.0.0 → 1.0.1): Bug fixes, backward compatible

### Release Process

1. **Update Version Numbers:**
   ```bash
   # Update composer.json version
   # Update CHANGELOG.md
   # Update README.md if needed
   ```

2. **Commit Changes:**
   ```bash
   git add .
   git commit -m "Prepare release v1.1.0"
   git push
   ```

3. **Create Release Tag:**
   ```bash
   git tag -a v1.1.0 -m "Release version 1.1.0"
   git push origin v1.1.0
   ```

4. **Create GitHub Release:**
   - Go to GitHub repository
   - Click "Releases" → "Create a new release"
   - Select the tag you just created
   - Add release notes from CHANGELOG.md
   - Publish release

## Marketing & Promotion

### 1. Bagisto Community

- Share in Bagisto Discord/Slack
- Post in Bagisto forums
- Submit to Bagisto marketplace (if available)

### 2. Social Media

- Tweet about the release
- Share on LinkedIn
- Post in relevant Facebook groups

### 3. Documentation Sites

- Add to awesome-bagisto lists
- Submit to Laravel package directories

## Maintenance

### Regular Tasks

1. **Monitor Issues:** Respond to GitHub issues promptly
2. **Update Dependencies:** Keep dependencies up to date
3. **Security Updates:** Monitor for security vulnerabilities
4. **Documentation:** Keep documentation current
5. **Testing:** Ensure compatibility with new Bagisto versions

### Support Channels

- **GitHub Issues:** Primary support channel
- **Email:** For security issues
- **Community:** Bagisto forums and Discord

## Success Metrics

Track these metrics to measure success:

- **Downloads:** Packagist download statistics
- **Stars:** GitHub repository stars
- **Issues:** Number and resolution time of issues
- **Contributions:** Community contributions and PRs
- **Usage:** Feedback from users

## Next Steps

After successful publication:

1. **Monitor Initial Feedback:** Watch for issues in first few days
2. **Create Documentation Site:** Consider GitHub Pages for detailed docs
3. **Plan Future Features:** Based on user feedback
4. **Build Community:** Engage with users and contributors

## Troubleshooting

### Common Publishing Issues

1. **Packagist Validation Fails:**
   - Check composer.json syntax
   - Ensure all required fields are present
   - Verify GitHub repository is public

2. **Auto-update Not Working:**
   - Check webhook configuration
   - Verify webhook URL is correct
   - Test webhook delivery in GitHub

3. **Installation Issues:**
   - Test installation in fresh Bagisto project
   - Check dependency conflicts
   - Verify service provider registration

Remember to keep this guide updated as you learn from the publishing process!