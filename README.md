# Description

This package contains a very basic service that performs RSA encoding and decoding.

Please note that this package is just an example for an article.

Please note that if you need to generate RSA keys:

    openssl genpkey -algorithm RSA -out key.pem -pkeyopt rsa_keygen_bits:2048;
    openssl rsa -in key.pem -pubout -out key_pub.pem
    openssl rsa -in key.pem -out key_prv.pem
    
The commands above will generate a public key `key_pub.pem` and a private key `key_prv.pem`.
