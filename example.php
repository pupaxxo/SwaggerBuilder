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
use SwagBag\Constants\Format;
use SwagBag\Constants\Mime;
use SwagBag\Constants\ParamType;
use SwagBag\Constants\Scheme;
use SwagBag\Constants\Type;
use SwagBag\Constants\Verb;

require_once __DIR__ . '/vendor/autoload.php';

$petResponseModel = (new Schema())
    ->setProperty('id', (new Schema(Type::INTEGER))->setFormat(Format::LONG), true)
    ->setProperty('name', new Schema(Type::STRING), true)
    ->setProperty('tag', new Schema(Type::STRING));

$errorResponseModel = (new Schema())
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
    global $petResponseModel, $errorResponseModel;

    $tags = (new Parameter('tags', Parameter::QUERY, ParamType::ARRAY))
        ->setDescription('tags to filter by')
        ->setItems((new Items()))
        ->setCollectionFormat(Format::CSV);
    $limit = (new Parameter('limit', Parameter::QUERY, ParamType::INTEGER))
        ->setDescription('maximum number of results to return')
        ->setFormat(Format::INTEGER);

    $responses = [
        (new Response(200, 'pet response'))->setSchema($petResponseModel),
        (new Response('default', 'unexpected error'))->setSchema($errorResponseModel),
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
    global $petResponseModel, $errorResponseModel;

    $newPet = (new Schema())
        ->setProperty('id', (new Schema(Type::INTEGER))->setFormat(Format::LONG))
        ->setProperty('name', new Schema(Type::STRING), true)
        ->setProperty('tag', new Schema(Type::STRING));

    $addPetBody = (new BodyParameter('pet', true, $newPet))
        ->setDescription('Pet to add to the store');

    $responses = [
        (new Response(200, 'pet response'))->setSchema($petResponseModel),
        (new Response('default', 'unexpected error'))->setSchema($errorResponseModel),
    ];

    return (new Operation(Verb::POST, $responses))
        ->setDescription('Creates a new pet in the store. Duplicates are allowed')
        ->setOperationId('addPet')
        ->setProducedMimes()
        ->addParameter($addPetBody);
}

function buildFindPetById(): Operation
{
    global $petResponseModel, $errorResponseModel;

    $responses = [
        (new Response(200, 'pet response'))->setSchema($petResponseModel),
        (new Response('default', 'unexpected error'))->setSchema($errorResponseModel),
    ];

    return (new Operation(Verb::GET, $responses))
        ->setDescription('Returns a user based on a single ID, if the user does not have access to the pet')
        ->setOperationId('findPetById')
        ->setProducedMimes([Mime::APP_JSON, Mime::APP_XML, Mime::TEXT_XML, Mime::TEXT_HTML]);
}

function buildDeletePet(): Operation
{
    global $errorResponseModel;

    $responses = [
        new Response(204, 'pet deleted'),
        (new Response('default', 'unexpected error'))->setSchema($errorResponseModel),
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
    ->setSchemes([Scheme::HTTP])
    ->setConsumedMimes([Mime::APP_JSON])
    ->setProducedMimes([Mime::APP_JSON]);

echo str_replace(['\/'], ['/'], json_encode($swagger, JSON_PRETTY_PRINT)) . "\n";
