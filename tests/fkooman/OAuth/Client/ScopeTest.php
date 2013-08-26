<?php

require_once 'vendor/autoload.php';

use \fkooman\OAuth\Client\Scope;
use \fkooman\OAuth\Client\ScopeException;

class ScopeTest extends PHPUnit_Framework_TestCase
{

    public function testStringScope()
    {
        $s = new Scope("read write delete");
        $this->assertTrue($s->hasScope(new Scope("read")));
        $this->assertTrue($s->hasScope(new Scope("write")));
        $this->assertTrue($s->hasScope(new Scope("delete")));
        $this->assertTrue($s->hasScope(new Scope(array("read", "delete"))));
        $this->assertFalse($s->hasScope(new Scope("foo")));
    }

    public function testArrayScope()
    {
        $s = new Scope(array("read", "write", "delete"));
        $this->assertTrue($s->hasScope(new Scope("read")));
        $this->assertTrue($s->hasScope(new Scope("write")));
        $this->assertTrue($s->hasScope(new Scope("delete")));
        $this->assertTrue($s->hasScope(new Scope(array("read", "delete"))));
        $this->assertFalse($s->hasScope(new Scope("foo")));
    }

    public function testNullScope()
    {
        $s = new Scope(null);
        $this->assertFalse($s->hasScope(new Scope("foo")));
        $this->assertTrue($s->hasScope(new Scope(array())));
        $this->assertTrue($s->hasScope(new Scope()));
        $this->assertTrue($s->hasScope(new Scope(array())));

    }

    /**
     * @expectedException \fkooman\OAuth\Client\ScopeException
     * @expectedExceptionMessage invalid scope token 'ç'
     */
    public function testInvalidScope()
    {
        $s = new Scope("ç");
    }

    /**
     * @expectedException \fkooman\OAuth\Client\ScopeException
     * @expectedExceptionMessage invalid scope token 'ç'
     */
    public function testInvalidScopeArray()
    {
        $s = new Scope(array("foo", "bar", "baz", "ç"));
    }

}
