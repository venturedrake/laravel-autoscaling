# # Laravel Autoscaling

[![Latest Version on Packagist](https://img.shields.io/packagist/v/venturedrake/laravel-autoscaling.svg?style=flat-square)](https://packagist.org/packages/venturedrake/laravel-autoscaling)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Total Downloads](https://img.shields.io/packagist/dt/venturedrake/laravel-autoscaling.svg?style=flat-square)](https://packagist.org/packages/venturedrake/laravel-autoscaling)

### Autoscaling for your Laravel applications managed by Laravel Forge. 

Laravel autoscaling is a simple package to help you manage vertical and horizontal scaling by setting a pre-defined schedule to resize your Linode servers according to expected demand. 

## Installation

You can install the package via composer:

```bash
composer require venturedrake/laravel-autoscaling
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="autoscaling-config"
```

## Usage

```php
php artisan autoscaling:run
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Roadmap

- Scheduled veritcal scaling (DONE)
- Scheduled horizontal scaling
- Auto scaling based on CPU/Memory usage
- AI powered auto scaling
- Support for other cloud providers (AWS, DigitalOcean, etc.)

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Andrew Drake](https://github.com/andrewdrake)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
