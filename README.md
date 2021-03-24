# Nibe Provider for OAuth 2.0 Client

This package provides Nibe OAuth 2.0 support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## Installation

To install, use composer:

```
composer require olssonm/oauth2-nibe
```

## Usage

Usage is the same as The League's OAuth client, using `\Olssonm\OAuth2\Client\Provider\Nibe` as the provider.

### Authorization Code Flow

```php
$provider = new Olssonm\OAuth2\Client\Provider\Nibe([
    'clientId'          => '{nibe-client-id}',
    'clientSecret'      => '{nibe-client-secret}',
    'redirectUri'       => 'https://example.com/callback-url',
    'scope'             => ['READSYSTEM']
]);

if (!isset($_GET['code'])) {

    // If we don't have an authorization code then get one
    $authUrl = $provider->getAuthorizationUrl();
    $_SESSION['oauth2state'] = $provider->getState();
    header('Location: '.$authUrl);
    exit;

// Check given state against previously stored one to mitigate CSRF attack
} elseif (empty($_GET['state']) || ($_GET['state'] !== $_SESSION['oauth2state'])) {

    unset($_SESSION['oauth2state']);
    exit('Invalid state');

} else {

    // Try to get an access token (using the authorization code grant)
    $token = $provider->getAccessToken('authorization_code', [
        'code'  => $_GET['code'],
        'scope' => ['READSYSTEM'] // Notice that the Nibe API requires scope for retrieving access token
    ]);

    // Use this to interact with an API on the users behalf
    echo $token->getToken();
}
```

## License

The MIT License (MIT). Please see [License File](https://github.com/michaelKaefer/oauth2-wrike/blob/master/LICENSE) for more information.

© 2021 [Marcus Olsson](https://marcusolsson.me).
