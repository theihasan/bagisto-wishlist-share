# Contributing to Bagisto Wishlist Share

Thank you for considering contributing to the Bagisto Wishlist Share package! This document provides guidelines for contributing to the project.

## Code of Conduct

This project adheres to a code of conduct. By participating, you are expected to uphold this code.

## How to Contribute

### Reporting Bugs

Before creating bug reports, please check the existing issues to avoid duplicates. When creating a bug report, include:

- **Clear title and description**
- **Steps to reproduce** the issue
- **Expected vs actual behavior**
- **Environment details** (PHP version, Laravel version, Bagisto version)
- **Screenshots** if applicable

### Suggesting Enhancements

Enhancement suggestions are welcome! Please provide:

- **Clear title and description** of the enhancement
- **Use case** explaining why this would be useful
- **Possible implementation** if you have ideas

### Pull Requests

1. **Fork** the repository
2. **Create a feature branch** from `main`
3. **Make your changes** following the coding standards
4. **Add tests** for new functionality
5. **Update documentation** if needed
6. **Submit a pull request**

#### Pull Request Guidelines

- Follow PSR-12 coding standards
- Include tests for new features
- Update documentation for API changes
- Keep commits atomic and well-described
- Ensure CI passes

## Development Setup

### Prerequisites

- PHP 8.1+
- Composer
- Node.js & NPM
- Bagisto 2.0+

### Installation

```bash
# Clone your fork
git clone https://github.com/yourusername/bagisto-wishlist-share.git
cd bagisto-wishlist-share

# Install dependencies
composer install
npm install

# Run tests
composer test
```

### Testing

```bash
# Run all tests
composer test

# Run tests with coverage
composer test-coverage

# Run specific test
vendor/bin/phpunit tests/Feature/WishlistShareTest.php
```

## Coding Standards

### PHP

- Follow PSR-12 coding standards
- Use type hints where possible
- Write descriptive method and variable names
- Add PHPDoc comments for public methods

### JavaScript

- Use ES6+ features
- Follow consistent indentation (2 spaces)
- Use meaningful variable names
- Add comments for complex logic

### Blade Templates

- Use consistent indentation (4 spaces)
- Follow Bagisto's template conventions
- Keep templates clean and readable

## Database Changes

### Migrations

- Create reversible migrations
- Use descriptive migration names
- Add indexes for performance
- Include foreign key constraints

### Seeders

- Provide realistic sample data
- Make seeders idempotent
- Document seeder purpose

## Documentation

### Code Documentation

- Add PHPDoc comments for all public methods
- Document complex algorithms
- Include usage examples

### User Documentation

- Update README.md for new features
- Add configuration examples
- Include troubleshooting guides

## Commit Messages

Use conventional commit format:

```
type(scope): description

[optional body]

[optional footer]
```

Types:
- `feat`: New feature
- `fix`: Bug fix
- `docs`: Documentation changes
- `style`: Code style changes
- `refactor`: Code refactoring
- `test`: Adding tests
- `chore`: Maintenance tasks

Examples:
```
feat(sharing): add LinkedIn sharing support
fix(modal): resolve modal closing issue on mobile
docs(readme): update installation instructions
```

## Release Process

1. Update version in `composer.json`
2. Update `CHANGELOG.md`
3. Create release tag
4. Publish to Packagist

## Getting Help

- **Issues**: Use GitHub issues for bugs and feature requests
- **Discussions**: Use GitHub discussions for questions
- **Email**: Contact maintainers for security issues

## Recognition

Contributors will be recognized in:
- README.md contributors section
- Release notes
- Package documentation

Thank you for contributing to Bagisto Wishlist Share!