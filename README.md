# SwaggerBuilder
Now you can write your Swagger API documentation in JSON, YAML, _or_ PHP!

Do you find the Swagger config very hard to write? Well (with an informative IDE) this should make it easier.

### Usage Note:
Fields Swagger requires appear in constructors, optional fields are set with specific setter methods. There's type hinting all over the place!

## Example: Swagger Petstore (Simple)

#### Swagger
A valid Swagger object requires the Swagger version, an Info object and at least 1 Path.
```php
$swagger = (new Swagger('2.0', $info, $paths))
    ->setHost('petstore.swagger.io')
    ->setBasePath('/api')
    ->setSchemes([Scheme::HTTP])
    ->setConsumedMimes([Mime::APP_JSON])
    ->setProducedMimes([Mime::APP_JSON]);
```

#### Info
A valid Info object requires the application name and version.
```php
// (optional) contact from the example
$contact = (new Contact())
    ->setName('Swagger API team')
    ->setEmail('foo@example.com')
    ->setUrl('http://swagger.io');

// (optional) license from the example
$license = (new License('MIT'))
    ->setUrl('http://opensource.org/licenses/MIT');

// The Info object is what we really need
$info = (new Info('Swagger Petstore (Simple)', '1.0.0'))
    ->setDescription('A sample API that uses a petstore as an example to demonstrate features in the swagger-2.0 specification')
    ->setTermsOfService('http://helloreverb.com/terms/')
    ->setContact($contact)
    ->setLicense($license);
```

#### Paths
A valid Path object requires a route and at least 1 Operation.
```php
$paths = [
    new Path('/pets', $operations),
];
```

#### Operations
A valid Operation object requires an HTTP verb and at least 1 example Response.
```php
$addPet = (new Operation(Verb::POST, $responses))
    ->setDescription('Creates a new pet in the store. Duplicates are allowed')
    ->setOperationId('addPet')
    ->setProducedMimes()
    ->addParameter($addPetBody);

$operations = [
    $addPet,
];
```

#### Responses
A valid Response object requires a status code (or 'default') and a description.
```php
$petResponseModel = (new Schema())
    ->setProperty('id', (new Schema(Type::INTEGER))->setFormat(Format::LONG), true)
    ->setProperty('name', new Schema(Type::STRING), true)
    ->setProperty('tag', new Schema(Type::STRING));

$errorResponseModel = (new Schema())
    ->setProperty('code', (new Schema(Type::INTEGER))->setFormat(Format::INTEGER), true)
    ->setProperty('message', new Schema(Type::STRING), true);

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
```
See [`/example.php`](https://github.com/SamuelDavis/SwaggerBuilder/blob/master/example.php) for a complete implementation of all the paths in the Petstore CRUD example.

#### Swagger JSON
Just json_encode the Swagger object (or any object which extends Component) to get a valid Swagger JSON blob.
```php
echo str_replace(['\/'], ['/'], json_encode($swagger, JSON_PRETTY_PRINT)) . "\n";
```
#### Result
```json
{
    "paths": {
        "/pets": {
            "post": {
                "responses": {
                    "200": {
                        "description": "pet response",
                        "schema": {
                            "type": "object",
                            "required": [
                                "id",
                                "name"
                            ],
                            "properties": {
                                "id": {
                                    "type": "integer",
                                    "format": "int64"
                                },
                                "name": {
                                    "type": "string"
                                },
                                "tag": {
                                    "type": "string"
                                }
                            }
                        }
                    },
                    "default": {
                        "description": "unexpected error",
                        "schema": {
                            "type": "object",
                            "required": [
                                "code",
                                "message"
                            ],
                            "properties": {
                                "code": {
                                    "type": "integer",
                                    "format": "int32"
                                },
                                "message": {
                                    "type": "string"
                                }
                            }
                        }
                    }
                },
                "description": "Creates a new pet in the store. Duplicates are allowed",
                "operationId": "addPet",
                "produces": [
                    "application/json"
                ],
                "parameters": [
                    {
                        "name": "pet",
                        "in": "body",
                        "required": true,
                        "schema": {
                            "type": "object",
                            "properties": {
                                "id": {
                                    "type": "integer",
                                    "format": "int64"
                                },
                                "name": {
                                    "type": "string"
                                },
                                "tag": {
                                    "type": "string"
                                }
                            },
                            "required": [
                                "name"
                            ]
                        },
                        "description": "Pet to add to the store"
                    }
                ]
            }
        }
    },
    "swagger": "2.0",
    "info": {
        "title": "Swagger Petstore (Simple)",
        "version": "1.0.0",
        "description": "A sample API that uses a petstore as an example to demonstrate features in the swagger-2.0 specification",
        "termsOfService": "http://helloreverb.com/terms/",
        "contact": {
            "name": "Swagger API team",
            "email": "foo@example.com",
            "url": "http://swagger.io"
        },
        "license": {
            "name": "MIT",
            "url": "http://opensource.org/licenses/MIT"
        }
    },
    "host": "petstore.swagger.io",
    "basePath": "/api",
    "schemes": [
        "http"
    ],
    "consumes": [
        "application/json"
    ],
    "produces": [
        "application/json"
    ]
}
```
