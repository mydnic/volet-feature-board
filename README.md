# A Volet Feature allowing users to vote for features, see the roadmap, etc.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mydnic/volet-feature-board.svg?style=flat-square)](https://packagist.org/packages/mydnic/volet-feature-board)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/mydnic/volet-feature-board/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/mydnic/volet-feature-board/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/mydnic/volet-feature-board/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/mydnic/volet-feature-board/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mydnic/volet-feature-board.svg?style=flat-square)](https://packagist.org/packages/mydnic/volet-feature-board)

A Feature board plugin for [Volet](https://github.com/mydnic/volet) - Allow users to suggest and vote for features

## Installation

You can install the package via composer:

```bash
composer require mydnic/volet-feature-board
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="volet-feature-board-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="volet-feature-board-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="volet-feature-board-views"
```

## Usage

```php
$voletFeatureboard = new Mydnic\VoletFeatureboard();
echo $voletFeatureboard->echoPhrase('Hello, Mydnic!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Clément Rigo](https://github.com/mydnic)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
