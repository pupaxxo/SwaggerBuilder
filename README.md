# SwaggerBuilder
Now you can write your Swagger API documentation in JSON, YAML, _or_ PHP!

Do you find the Swagger config very hard to write? Well (with an informative IDE) this should make it easier.

### Usage Note:
Fields Swagger requires appear in constructors, optional fields are set with specific setter methods. There's type hinting all over the place!

## Example: Swagger Petstore (Simple)

#### Swagger
A valid Swagger object requires 3 things: the Swagger version, an Info object and at least 1 Path.
```php
$swagger = (new Swagger('2.0', $info, $paths))
    ->setHost('petstore.swagger.io')
    ->setBasePath('/api')
    ->setSchemes([Scheme::HTTP])
    ->setConsumedMimes([Mime::APP_JSON])
    ->setProducedMimes([Mime::APP_JSON]);
```

#### Info
A valid Info object requires only 2 things: the application name and version.
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
A valid Path object requires a route and at least 1 Operation
The Operation requires an HTTP verb and at least 1 example Response
```php
$petModel = (new Schema())
    ->setProperty('id', (new Schema(Type::INTEGER))->setFormat(Format::LONG), true)
    ->setProperty('name', new Schema(Type::STRING), true)
    ->setProperty('tag', new Schema(Type::STRING));

$errorModel = (new Schema())
    ->setProperty('code', (new Schema(Type::INTEGER))->setFormat(Format::INTEGER), true)
    ->setProperty('message', new Schema(Type::STRING), true);

$responses = [
    (new Response(200, 'pet response'))->setSchema($petModel),
    (new Response('default', 'unexpected error'))->setSchema($errorModel),
];

$findPetById = (new Operation(Verb::GET, $responses))
    ->setDescription('Returns a user based on a single ID, if the user does not have access to the pet')
    ->setOperationId('findPetById')
    ->setProducedMimes([Mime::APP_JSON, Mime::APP_XML, Mime::TEXT_XML, Mime::TEXT_HTML]);

$paths = [
    (new Path('/pets/{id}', [$findPetById]))
        ->addParameter((new PathParameter('id', Type::INTEGER))
            ->setFormat(Format::LONG)
            ->setDescription('The ID of the pet to operate on.')),
];
```
See `/example.php` for a complete implementation of all the paths in the Petstore CRUD example.

#### Swagger JSON
Just json_encode the Swagger object (or any object which extends Component) to get a valid Swagger JSON blob.
```php
echo str_replace(['\/'], ['/'], json_encode($swagger, JSON_PRETTY_PRINT)) . "\n";
```
```json
{
    "paths": {
        "/pets/{id}": {
            "get": {
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
                "description": "Returns a user based on a single ID, if the user does not have access to the pet",
                "operationId": "findPetById",
                "produces": [
                    "application/json",
                    "application/xml",
                    "text/xml",
                    "text/html"
                ]
            },
            "parameters": [
                {
                    "name": "id",
                    "in": "path",
                    "type": "integer",
                    "required": true,
                    "format": "int64",
                    "description": "The ID of the pet to operate on."
                }
            ]
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
