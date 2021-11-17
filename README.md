# NIBE Provider for OAuth 2.0 Client

[![Latest Version on Packagist](https://img.shields.io/packagist/v/olssonm/oauth2-nibe?style=flat-square)](https://packagist.org/packages/olssonm/oauth2-nibe)
[![Software License](https://img.shields.io/packagist/l/olssonm/oauth2-nibe?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/github/workflow/status/olssonm/oauth2-nibe/Run%20tests.svg?style=flat-square&label=tests)](https://github.com/olssonm/oauth2-nibe/actions?query=workflow%3A%22Run+tests%22)

This package provides [NIBE Uplink](https://nibeuplink.com/) OAuth 2.0 support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## Installation

To install, use composer:

```
composer require olssonm/oauth2-nibe
```

## Usage

Usage is the same as The League's OAuth client, using `Olssonm\OAuth2\Client\Provider\Nibe` as the provider.

### Authorization Code Flow

```php
$provider = new Olssonm\OAuth2\Client\Provider\Nibe([
    'clientId'          => 'XXXXXX',
    'clientSecret'      => 'XXXXXX',
    'redirectUri'       => 'https://my.example.com/your-redirect-url/'
]);
```

For further usage of this package please refer to the [core package documentation on "Authorization Code Grant"](https://oauth2-client.thephpleague.com/usage#authorization-code-grant).

### Resource owner information

NIBE does not support access to any personal information of the authorizing resource owner. As such, this package does not support the `getResourceOwner` method documented in the core package.

This package will throw a `Olssonm\OAuth2\Client\Provider\Exception\ResourceOwnerException` exception if you attempt to use this method.

## License

The MIT License (MIT). Please see [License File](https://github.com/olssonm/oauth2-nibe/blob/master/LICENSE) for more information.

© 2021 [Marcus Olsson](https://marcusolsson.me).
