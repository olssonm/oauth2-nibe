<?php

namespace Olssonm\OAuth2\Client\Provider;

use Olssonm\OAuth2\Client\Provider\Exception\ResourceOwnerException;
use League\OAuth2\Client\Provider\AbstractProvider;
use League\OAuth2\Client\Provider\Exception\IdentityProviderException;
use League\OAuth2\Client\Token\AccessToken;
use League\OAuth2\Client\Tool\BearerAuthorizationTrait;
use Psr\Http\Message\ResponseInterface;

class Nibe extends AbstractProvider
{
    use BearerAuthorizationTrait;

    /**
     * Returns the base URL for authorizing a client.
     *
     * @return string
     */
    public function getBaseAuthorizationUrl()
    {
        return 'https://api.nibeuplink.com/oauth/authorize';
    }

    /**
     * Returns the base URL for requesting an access token.
     *
     * @param array $params
     * @return string
     */
    public function getBaseAccessTokenUrl(array $params)
    {
        return 'https://api.nibeuplink.com/oauth/token';
    }

    /**
     * Returns the URL for requesting the resource owner's details.
     *
     * @param AccessToken $token
     * @return mixed
     * @throws ResourceOwnerException
     */
    public function getResourceOwnerDetailsUrl(AccessToken $token)
    {
        throw new ResourceOwnerException();
    }

    /**
     * This should only be the scopes that are required to request the details of the resource owner,
     * rather than all the available scopes.
     *
     * @return void
     */
    protected function getDefaultScopes()
    {
        return ['READSYSTEM'];
    }

    /**
     * Returns the string that should be used to separate scopes when building
     * the URL for requesting an access token.
     *
     * @return string Scope separator, defaults to ','
     */
    protected function getScopeSeparator()
    {
        return ' ';
    }

    /**
     * Check a provider response for errors.
     *
     * @throws IdentityProviderException
     * @param  ResponseInterface $response
     * @param  string $data Parsed response data
     * @return void
     */
    protected function checkResponse(ResponseInterface $response, $data)
    {
        if ($response->getStatusCode() >= 400) {
            throw new IdentityProviderException(
                $data['error'] ?: $response->getReasonPhrase(),
                $response->getStatusCode(),
                $data
            );
        }
    }

    /**
     * Generates a resource owner object from a successful resource owner details request.
     *
     * @param array $response
     * @param AccessToken $token
     * @return void
     * @throws ResourceOwnerException
     */
    protected function createResourceOwner(array $response, AccessToken $token)
    {
        throw new ResourceOwnerException();
    }
}
