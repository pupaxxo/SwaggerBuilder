<?php

use SwagBag\Components\Contact;
use SwagBag\Components\Example;
use SwagBag\Components\Header;
use SwagBag\Components\Info;
use SwagBag\Components\License;
use SwagBag\Components\Operation;
use SwagBag\Components\Parameters\BodyParam;
use SwagBag\Components\Parameters\QueryParam;
use SwagBag\Components\Path;
use SwagBag\Components\Response;
use SwagBag\Components\Schema;
use SwagBag\Components\Swagger;
use SwagBag\Mime;
use SwagBag\Scheme;
use SwagBag\Type;
use SwagBag\Verb;

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

// Home path
$home = new Path('/', [
    new Operation(Verb::GET, [
        new Response(),
    ]),
]);

// Users path
$createUser = (new Operation(Verb::POST, [
    new Response(200),
    new Response(422),
]))
    ->setSummary('Persist a user.')
    ->setDescription('Stores a user in a database.')
    ->setOperationId('users.persist');

$listUsers = (new Operation(Verb::GET, [
    (new Response(200))
        ->addHeader((new Header('X-Rate-Limit-Remaining', Type::INTEGER))
            ->setDescription('The number of remaining requests in the current period.'))
        ->addHeader((new Header('X-Rate-Limit-Reset', Type::INTEGER))
            ->setDescription('The number of seconds left in the current period.')),
]))
    ->addParameter(new QueryParam('page'))
    ->addParameter((new QueryParam('first_name', false, Type::STRING))
        ->setDescription('The name by which to filter users.')
        ->setOther('deprecated-warning', 'Deprecated in 0.0.3')
    );

$updateUser = (new Operation(Verb::PUT, [
    (new Response(422, 'The client provided invalid user data.'))
        ->addExample(new Example(Mime::JSON, [
            'type' => 'user',
            'id' => 1,
            'properties' => [
                'first_name' => 'Arya',
                'age' => 9,
            ],
        ])),
]))
    ->addParameter(new BodyParam('first_name', true, new Schema()))
    ->addParameter(new BodyParam('age', true, new Schema()));

$users = new Path('/users', [
    $listUsers,
    $createUser,
    $updateUser,
]);

/**
 * Define Swagger
 */
$swagger = (new Swagger('2.0', $info, [$home, $users]))
    ->setHost('192.176.99.100')
    ->setBasePath('/api')
    ->addScheme(Scheme::HTTPS)
    ->addConsumedMime(Mime::JSON)
    ->addProducedMime(Mime::JSON);

echo str_replace(['\/'], ['/'], json_encode($swagger, JSON_PRETTY_PRINT)) . "\n";
