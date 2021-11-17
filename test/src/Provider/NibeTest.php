<?php

namespace Olssonm\Nibe\OAuth2\Client\Tests\Provider;

use GuzzleHttp\ClientInterface;
use League\OAuth2\Client\Token\AccessToken;
use Mockery as m;
use Olssonm\OAuth2\Client\Provider\Exception\ResourceOwnerException;
use Olssonm\OAuth2\Client\Provider\Nibe;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;

class NibeTest extends TestCase
{
    /**
     * @var BaseProvider
     */
    protected $provider;

    protected function setUp(): void
    {
        $this->provider = new Nibe([
            'clientId' => 'mock_client_id',
            'clientSecret' => 'mock_secret',
            'redirectUri' => 'mock_redirect_uri',
        ]);
    }

    public function testAuthorizationUrl()
    {
        $url = $this->provider->getAuthorizationUrl();
        $uri = parse_url($url);

        parse_str($uri['query'], $query);

        $this->assertEquals('https', $uri['scheme']);
        $this->assertEquals('api.nibeuplink.com', $uri['host']);
        $this->assertEquals('/oauth/authorize', $uri['path']);

        $this->assertArrayHasKey('client_id', $query);
        $this->assertArrayHasKey('redirect_uri', $query);
        $this->assertArrayHasKey('state', $query);
        $this->assertArrayHasKey('scope', $query);
        $this->assertArrayHasKey('response_type', $query);
        $this->assertArrayHasKey('approval_prompt', $query);

        $this->assertNotNull($this->provider->getState());
    }

    public function testResourceOwnerDetailsUrl()
    {
        $this->expectException(ResourceOwnerException::class);

        $token = m::mock(AccessToken::class);
        $this->provider->getResourceOwnerDetailsUrl($token);
    }

    public function testGetAccessToken()
    {
        $response = m::mock('Psr\Http\Message\ResponseInterface');
        $response->shouldReceive('getBody')->andReturn('{"access_token":"mock_access_token", "token_type":"bearer"}');
        $response->shouldReceive('getHeader')->andReturn(['content-type' => 'json']);
        $response->shouldReceive('getStatusCode')->andReturn(200);

        $client = m::mock('GuzzleHttp\ClientInterface');
        $client->shouldReceive('send')->times(1)->andReturn($response);
        $this->provider->setHttpClient($client);

        $token = $this->provider->getAccessToken('authorization_code', ['code' => 'mock_authorization_code']);

        $this->assertEquals('mock_access_token', $token->getToken());
        $this->assertNull($token->getExpires());
        $this->assertNull($token->getRefreshToken());
        $this->assertNull($token->getResourceOwnerId());
    }
}
