<?php

namespace dbeurive\Rsa;

/**
 * Class RSA
 *
 * This class implements a Symfony 3 service that encode and decode data using the RSA algorithm.
 *
 * If you need to generate the RSA keys, then follow the procedure below:
 *
 *     openssl genpkey -algorithm RSA -out key.pem -pkeyopt rsa_keygen_bits:2048;
 *     openssl rsa -in key.pem -pubout -out key_pub.pem
 *     openssl rsa -in key.pem -out key_prv.pem
 *
 * dbeurive\Rsa
 */
class RSA
{
    private $__publicKey;
    private $__privateKey;

    /**
     * RSA constructor.
     * @param string $inRsaPublicKey Path to the RSA public key.
     * @param string $inRsaPrivateKey Path to the RSA private key.
     */
    public function __construct($inRsaPublicKey, $inRsaPrivateKey) {

        // Load the public key.

        $text = file_get_contents($inRsaPublicKey);
        if (false === $text) {
            throw new \Exception("Could not load the file that contains the public key ($inRsaPublicKey).");
        }

        $this->__publicKey = openssl_pkey_get_public($text);
        if (false === $this->__publicKey) {
            throw new \Exception("The given path does not contain a valid public key ($inRsaPublicKey).");
        }

        // Load the private key.

        $text = file_get_contents($inRsaPrivateKey);
        if (false === $text) {
            throw new \Exception("Could not load the file that contains the private key ($inRsaPrivateKey).");
        }

        $this->__privateKey = openssl_pkey_get_private($text);
        if (false === $this->__privateKey) {
            throw new \Exception("The given path does not contain a valid private key ($inRsaPrivateKey).");
        }
    }

    /**
     * Encode a string.
     * @param string $inString String to encode.
     * @return string The method returns the encoded string.
     * @throws \Exception
     */
    public function encode($inString) {
        $result = null;
        if (false === openssl_public_encrypt($inString, $result, $this->__publicKey)) {
            throw new \Exception("An error occurred while encoding the text.");
        }
        return bin2hex($result);
    }

    /**
     * Decode a string.
     * @param string $inString String to decode.
     * @return string The method returns the decoded string.
     * @throws \Exception
     */
    public function decode($inString) {
        $result = null;
        if (false === openssl_private_decrypt(hex2bin($inString), $result, $this->__privateKey)) {
            throw new \Exception("An error occurred while decoding the text.");
        }
        return $result;
    }
}