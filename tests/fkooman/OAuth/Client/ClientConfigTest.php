<?php

require_once 'vendor/autoload.php';

use \fkooman\OAuth\Client\ClientConfig;
use \fkooman\OAuth\Client\ClientConfigException;

class ClientConfigTest extends PHPUnit_Framework_TestCase
{

    public function testSimple()
    {
        $data = array("client_id" => "foo", "client_secret" => "bar", "authorize_endpoint" => "http://www.example.org/authorize", "token_endpoint" => "http://www.example.org/token");
        $c = new ClientConfig($data);
        $this->assertEquals("foo", $c->getClientId());
        $this->assertEquals("bar", $c->getClientSecret());
        $this->assertEquals("http://www.example.org/authorize", $c->getAuthorizeEndpoint());
        $this->assertEquals("http://www.example.org/token", $c->getTokenEndpoint());
        $this->assertNull($c->getRedirectUri());
        $this->assertFalse($c->getCredentialsInRequestBody());
    }

    public function testLessSimple()
    {
        $data = array("client_id" => "foo", "client_secret" => "bar", "authorize_endpoint" => "http://www.example.org/authorize", "token_endpoint" => "http://www.example.org/token", "redirect_uri" => "http://www.example.org/callback", "credentials_in_request_body" => TRUE);
        $c = new ClientConfig($data);
        $this->assertEquals("foo", $c->getClientId());
        $this->assertEquals("bar", $c->getClientSecret());
        $this->assertEquals("http://www.example.org/authorize", $c->getAuthorizeEndpoint());
        $this->assertEquals("http://www.example.org/token", $c->getTokenEndpoint());
        $this->assertEquals("http://www.example.org/callback", $c->getRedirectUri());
        $this->assertTrue($c->getCredentialsInRequestBody());

    }

    /**
     * @dataProvider validClients
     */
    public function testValidClients(array $data)
    {
        new ClientConfig($data);
    }

    /**
     * @dataProvider invalidClients
     */
    public function testInvalidClients(array $data, $message)
    {
        try {
            new ClientConfig($data);
            $this->assertTrue(FALSE);
        } catch (ClientConfigException $e) {
            $this->assertEquals($message, $e->getMessage());
        }
    }

    public function validClients()
    {
        return array (
            array(
              array ("client_id" => "foo", "client_secret" => "bar", "authorize_endpoint" => "http://www.example.org/authorize", "token_endpoint" => "http://www.example.org/token"),
            ),
            array(
              array ("client_id" => "foo", "client_secret" => "bar", "authorize_endpoint" => "http://www.example.org/authorize", "token_endpoint" => "http://www.example.org/token", "credentials_in_request_body" => TRUE, "redirect_uri" => "http://www.example.org/callback"),
            ),
            array(
              array ("foo" => "bar", "xyz" => "abc", "client_id" => "foo", "client_secret" => "bar", "authorize_endpoint" => "http://www.example.org/authorize", "token_endpoint" => "http://www.example.org/token"),
            ),
            // empty client_secret is allowed
            array(
              array ("client_id" => "foo", "client_secret" => null, "authorize_endpoint" => "http://www.example.org/authorize", "token_endpoint" => "http://www.example.org/token"),
            ),
            array(
              array ("client_id" => "foo", "client_secret" => null, "authorize_endpoint" => "http://www.example.org/authorize", "token_endpoint" => "http://www.example.org/token", "default_token_token" => "bearer"),
            ),
        );
    }

    public function invalidClients()
    {
        return array(
            array(
                array(),
                "missing field 'client_id'"
            ),
            array(
                array("client_id" => "", "client_secret" => "", "authorize_endpoint" => "", "token_endpoint" => ""),
                "client_id must be a non-empty string"
            ),
            array(
                array("client_id" => "foo"),
                "missing field 'authorize_endpoint'"
            ),
            array(
                array("client_id" => "foo", "client_secret" => "bar"),
                "missing field 'authorize_endpoint'"
            ),
            array(
                array("client_id" => "foo", "client_secret" => "bar", "authorize_endpoint" => "http://www.example.org/authorize", "token_endpoint" => 5),
                "uri must be a non-empty string"
            ),
            array(
                array("client_id" => "foo", "client_secret" => "bar", "authorize_endpoint" => "http://www.example.org/authorize"),
                "missing field 'token_endpoint'"
            ),
            array(
                array("client_id" => "foo", "client_secret" => "bar", "authorize_endpoint" => "not_a_url", "token_endpoint" => "http://www.example.org/token#foo"),
                "uri must be valid URL"
            ),
            array(
                array("client_id" => "foo", "client_secret" => "bar", "authorize_endpoint" => "http://www.example.org/authorize", "token_endpoint" => "http://www.example.org/token#foo"),
                "uri must not contain a fragment"
            ),
            array(
              array ("client_id" => "foo", "client_secret" => "∑", "authorize_endpoint" => "http://www.example.org/authorize", "token_endpoint" => "http://www.example.org/token"),
                "invalid characters in client_id or client_secret"
            ),
            array(
              array ("client_id" => "foo", "client_secret" => 5, "authorize_endpoint" => "http://www.example.org/authorize", "token_endpoint" => "http://www.example.org/token"),
                "client_secret must be a non-empty string or null"
            ),
            array(
              array ("client_id" => "foo", "client_secret" => "bar", "authorize_endpoint" => "http://www.example.org/authorize", "token_endpoint" => "http://www.example.org/token", "default_token_type" => ''),
                "default_token_type must be a non-empty string or null"
            ),

        );
    }
}
