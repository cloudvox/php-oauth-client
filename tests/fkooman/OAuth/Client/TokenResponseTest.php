<?php

require_once 'vendor/autoload.php';

use \fkooman\OAuth\Client\TokenResponse;
use \fkooman\OAuth\Client\TokenResponseException;

class TokenResponseTest extends PHPUnit_Framework_TestCase
{

    public function testSimple()
    {
        $t = new TokenResponse(
            array(
                "access_token" => "foo",
                "token_type" => "Bearer",
                "expires_in" => 5,
                "scope" => "foo",
                "refresh_token" => "bar",
                "unsupported_key" => "foo",
            )
        );
        $this->assertEquals("foo", $t->getAccessToken());
        $this->assertEquals("Bearer", $t->getTokenType());
        $this->assertEquals(5, $t->getExpiresIn());
        $this->assertEquals("bar", $t->getRefreshToken());
        $this->assertEquals("foo", $t->getScope()->getScopeAsString());
    }

    public function testScope()
    {
        $t = new TokenResponse(
            array(
                "access_token" => "foo",
                "token_type" => "Bearer",
                "scope" => "foo bar baz baz",
            )
        );
        // scope will be sorted de-duplicated string space separated
        $this->assertEquals("bar baz foo", $t->getScope()->getScopeAsString());
    }

    /**
     * @expectedException \fkooman\OAuth\Client\TokenResponseException
     * @expectedExceptionMessage scope needs to be a non-empty string
     */
    public function testNullScope()
    {
        $t = new TokenResponse(
            array(
                "access_token" => "foo",
                "token_type" => "Bearer",
                "scope" => null,
            )
        );
    }

    /**
     * @expectedException \fkooman\OAuth\Client\TokenResponseException
     * @expectedExceptionMessage scope needs to be a non-empty string
     */
    public function testEmptyScope()
    {
        $t = new TokenResponse(
            array(
                "access_token" => "foo",
                "token_type" => "Bearer",
                "scope" => "",
            )
        );
    }

    /**
     * @expectedException \fkooman\OAuth\Client\TokenResponseException
     * @expectedExceptionMessage expires_in needs to be a positive integer
     */
    public function testNegativeExpiresIn()
    {
        $t = new TokenResponse(
            array(
                "access_token" => "foo",
                "token_type" => "Bearer",
                "expires_in" => -5,
            )
        );

    }
}
