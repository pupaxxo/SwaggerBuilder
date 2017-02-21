<?php

use SwaggerBuilder\Components\Contact;
use SwaggerBuilder\Components\Info;
use SwaggerBuilder\Components\Items;
use SwaggerBuilder\Components\License;
use SwaggerBuilder\Components\Operation;
use SwaggerBuilder\Components\Params\BodyParameter;
use SwaggerBuilder\Components\Params\Parameter;
use SwaggerBuilder\Components\Params\PathParameter;
use SwaggerBuilder\Components\Path;
use SwaggerBuilder\Components\Response;
use SwaggerBuilder\Components\Schema;
use SwaggerBuilder\Components\Swagger;
use SwaggerBuilder\Constants\Format;
use SwaggerBuilder\Constants\Mime;
use SwaggerBuilder\Constants\Type;
use SwaggerBuilder\Constants\Verb;

require_once __DIR__ . '/vendor/autoload.php';

$petModel = (new Schema())
    ->setProperty('id', (new Schema(Type::INTEGER))->setFormat(Format::LONG), true)
    ->setProperty('name', new Schema(Type::STRING), true)
    ->setProperty('tag', new Schema(Type::STRING));

$errorModel = (new Schema())
    ->setProperty('code', (new Schema(Type::INTEGER))->setFormat(Format::INTEGER), true)
    ->setProperty('message', new Schema(Type::STRING), true);

function buildInfo(): Info
{
    $contact = (new Contact())
        ->setName('Swagger API team')
        ->setEmail('foo@example.com')
        ->setUrl('http://swagger.io');

    $license = (new License('MIT'))
        ->setUrl('http://opensource.org/licenses/MIT');

    return (new Info('Swagger Petstore (Simple)', '1.0.0'))
        ->setDescription('A sample API that uses a petstore as an example to demonstrate features in the swagger-2.0 specification')
        ->setTermsOfService('http://helloreverb.com/terms/')
        ->setContact($contact)
        ->setLicense($license);
}

function buildFindPets(): Operation
{
    global $petModel, $errorModel;

    $tags = (new Parameter('tags', Parameter::QUERY, Type::ARRAY))
        ->setDescription('tags to filter by')
        ->setItems((new Items()))
        ->setCollectionFormat(Format::CSV);
    $limit = (new Parameter('limit', Parameter::QUERY, Type::INTEGER))
        ->setDescription('maximum number of results to return')
        ->setFormat(Format::INTEGER);

    $responses = [
        (new Response(200, 'pet response'))->setSchema($petModel),
        (new Response('default', 'unexpected error'))->setSchema($errorModel),
    ];

    return (new Operation(Verb::GET, $responses))
        ->setDescription('Returns all pets from the system that the user has access to')
        ->setOperationId('findPets')
        ->setProducedMimes([Mime::APP_JSON, Mime::APP_XML, Mime::TEXT_XML, Mime::TEXT_HTML])
        ->addParameter($tags)
        ->addParameter($limit);
}

function buildAddPet(): Operation
{
    global $petModel, $errorModel;

    $newPet = (new Schema())
        ->setProperty('id', (new Schema(Type::INTEGER))->setFormat(Format::LONG))
        ->setProperty('name', new Schema(Type::STRING), true)
        ->setProperty('tag', new Schema(Type::STRING));

    $addPetBody = (new BodyParameter('pet', true, $newPet))
        ->setDescription('Pet to add to the store');

    $responses = [
        (new Response(200, 'pet response'))->setSchema($petModel),
        (new Response('default', 'unexpected error'))->setSchema($errorModel),
    ];

    return (new Operation(Verb::POST, $responses))
        ->setDescription('Creates a new pet in the store. Duplicates are allowed')
        ->setOperationId('addPet')
        ->setProducedMimes()
        ->addParameter($addPetBody);
}

function buildFindPetById(): Operation
{
    global $petModel, $errorModel;

    $responses = [
        (new Response(200, 'pet response'))->setSchema($petModel),
        (new Response('default', 'unexpected error'))->setSchema($errorModel),
    ];

    return (new Operation(Verb::GET, $responses))
        ->setDescription('Returns a user based on a single ID, if the user does not have access to the pet')
        ->setOperationId('findPetById')
        ->setProducedMimes([Mime::APP_JSON, Mime::APP_XML, Mime::TEXT_XML, Mime::TEXT_HTML]);
}

function buildDeletePet(): Operation
{
    global $errorModel;

    $responses = [
        new Response(204, 'pet deleted'),
        (new Response('default', 'unexpected error'))->setSchema($errorModel),
    ];
    return (new Operation(Verb::DELETE, $responses))
        ->setDescription('deletes a single pet based on the ID supplied')
        ->setOperationId('deletePet');
}

$paths = [
    new Path('/pets', [buildFindPets(), buildAddPet(),]),
    (new Path('/pets/{id}', [buildFindPetById(), buildDeletePet()]))
        ->addParameter((new PathParameter('id', Type::INTEGER))
            ->setFormat(Format::LONG)
            ->setDescription('The ID of the pet to operate on.')),
];

$swagger = (new Swagger('2.0', buildInfo(), $paths))
    ->setHost('petstore.swagger.io')
    ->setBasePath('/api')
    ->setSchemes()
    ->setConsumedMimes()
    ->setProducedMimes();

echo str_replace(['\/'], ['/'], json_encode($swagger, JSON_PRETTY_PRINT)) . "\n";
