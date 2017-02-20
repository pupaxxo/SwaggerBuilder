<?php

use SwagBag\Components\Contact;
use SwagBag\Components\Info;
use SwagBag\Components\License;
use SwagBag\Components\Operation;
use SwagBag\Components\Path;
use SwagBag\Components\Response;
use SwagBag\Components\Swagger;
use SwagBag\Mime;
use SwagBag\Scheme;
use SwagBag\Verb;

require_once __DIR__ . '/vendor/autoload.php';

$info = (new Info('Example', '0.1.0'))
    ->setDescription('My example.')
    ->setTermsOfService('Some terms')
    ->setContact((new Contact())
        ->setName('Example Org')
        ->setUrl('www.example.org')
        ->setEmail('support@example.org')
        ->setOther('billing', 'billing@example.org')
        ->setOther('technical', 'technical@example.org'))
    ->setLicense((new License('Example License'))
        ->setUrl('www.my.org/license')
        ->setOther('more-license-data', 'This is just an example.')
        ->setOther('extra-license-data', 'Really, this is all just for example.'));

$paths = [
    (new Path('/user', [
        /**
         * Create User
         */
        (new Operation(Verb::POST, [
            (new Response(200, 'User created successfully.')),
            (new Response(422, 'Invalid user data given.')),
        ]))
    ])),
    (new Path('/user/{userId}', [
        /**
         * Read User
         */
        (new Operation(Verb::GET, [
            (new Response(200, 'User fetched successfully.')),
            (new Response(404, 'User id not found.')),
        ])),
        /**
         * Update User
         */
        (new Operation(Verb::PUT, [
            (new Response(200, 'User updated successfully.')),
            (new Response(422, 'Invalid user data given.')),
            (new Response(404, 'User id not found.')),
        ])),
        /**
         * Delete User
         */
        (new Operation(Verb::DELETE, [
            (new Response(200, 'User deleted successfully.')),
            (new Response(404, 'User id not found.')),
        ])),
    ])),
];

/**
 * Define Swagger
 */
$swagger = (new Swagger('2.0', $info, $paths))
    ->setHost('192.176.99.100')
    ->setBasePath('/api')
    ->addScheme(Scheme::HTTPS)
    ->addConsumedMime(Mime::JSON)
    ->addProducedMime(Mime::JSON);

echo str_replace(['\/'], ['/'], json_encode($swagger, JSON_PRETTY_PRINT)) . "\n";
