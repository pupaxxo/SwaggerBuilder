<?php

use SwagBag\Components\Contact;
use SwagBag\Components\Info;
use SwagBag\Components\License;
use SwagBag\Components\Swagger;
use SwagBag\Mime;
use SwagBag\Scheme;

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Define Swagger Info
 */
$contact = (new Contact())
    ->setName('Example Org')
    ->setUrl('www.example.org')
    ->setEmail('support@example.org')
    ->setOther('billing', 'billing@example.org')
    ->setOther('technical', 'technical@example.org');
$license = (new License('Example License'))
    ->setUrl('www.my.org/license')
    ->setOther('more-license-data', 'This is just an example.')
    ->setOther('extra-license-data', 'Really, this is all just for example.');
$info = (new Info('Example', '0.1.0'))
    ->setDescription('My example.')
    ->setTermsOfService('Some terms')
    ->setContact($contact)
    ->setLicense($license);

/**
 * Define Swagger Paths
 */
$paths = [];

/**
 * Define Swagger
 */
$swagger = (new Swagger('2.0', $info, $paths))
    ->setHost('192.176.99.100')
    ->setBasePath('/')
    ->addScheme(Scheme::HTTPS)
    ->addConsumedMime(Mime::JSON)
    ->addProducedMime(Mime::JSON);

echo str_replace(['\/'], ['/'], json_encode($swagger, JSON_PRETTY_PRINT)) . "\n";
