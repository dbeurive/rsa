<?php

use dbeurive\Rsa\RSA;

class RSATest extends PHPUnit_Framework_TestCase
{
    const TEXT = "Text that will be encoded";
    /** @var RSA */
    private $__rsa;

    protected function setUp() {
        $pubKeyPath = __DIR__ . DIRECTORY_SEPARATOR . 'keys' . DIRECTORY_SEPARATOR . 'key_pub.pem';
        $prvKeyPath = __DIR__ . DIRECTORY_SEPARATOR . 'keys' . DIRECTORY_SEPARATOR . 'key_prv.pem';
        $this->__rsa = new RSA($pubKeyPath, $prvKeyPath);
    }

    public function testEncodeDecode() {
        $encoded = $this->__rsa->encode(self::TEXT);
        $decoded = $this->__rsa->decode($encoded);
        $this->assertEquals(self::TEXT, $decoded);
    }
}