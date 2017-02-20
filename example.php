<?php

use SwagBag\Components\Contact;
use SwagBag\Components\Info;
use SwagBag\Components\Items;
use SwagBag\Components\License;
use SwagBag\Components\Operation;
use SwagBag\Components\Params\BodyParameter;
use SwagBag\Components\Params\Parameter;
use SwagBag\Components\Params\PathParameter;
use SwagBag\Components\Path;
use SwagBag\Components\Response;
use SwagBag\Components\Schema;
use SwagBag\Components\Swagger;
use SwagBag\Mime;
use SwagBag\ParamType;
use SwagBag\Scheme;
use SwagBag\Type;
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
            /**
             * Supply User data from a form
             */
            ->addConsumedMime(Mime::FORM_DATA)
            ->addParameter((new Parameter('name', Parameter::FORM, ParamType::STRING, true)))
            ->addParameter((new Parameter('password', Parameter::FORM, ParamType::STRING, true))
                ->setMinLength(6))
            ->addParameter((new Parameter('phone', Parameter::FORM, ParamType::INTEGER, false))
                ->setMin(1000000000)
                ->setMax(99999999999))
            ->addParameter((new Parameter('profileImg', Parameter::FORM, ParamType::STRING, false))),
    ])),
    (new Path('/user/{userId}', [
        /**
         * Read User
         */
        (new Operation(Verb::GET, [
            (new Response(200, 'User fetched successfully.')),
            (new Response(404, 'User id not found.')),
        ]))
            ->addParameter((new Parameter('include', Parameter::QUERY, ParamType::ARRAY))
                ->setItems(new Items(Type::STRING))
                ->setDescription('Available User relationships include: [subscription, organizations]')),
        /**
         * Update User
         */
        (new Operation(Verb::PUT, [
            (new Response(200, 'User updated successfully.')),
            (new Response(422, 'Invalid user data given.')),
            (new Response(404, 'User id not found.')),
        ]))
            /**
             * Supply User fields as a JSON blob
             */
            ->addParameter(new BodyParameter('body', true, (new Schema()))),
        /**
         * Delete User
         */
        (new Operation(Verb::DELETE, [
            (new Response(200, 'User deleted successfully.')),
            (new Response(404, 'User id not found.')),
        ])),
    ]))
        ->addParameter((new PathParameter('userId', ParamType::INTEGER))
            ->setDescription('The id of the User resource to be operated on.')),
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
