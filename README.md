# Still very much in development!
...
# SwaggerBuilder
Now you can write your Swagger API documentation in JSON, YAML, _or_ PHP!

Do you find the Swagger config very hard to write? Well (with an informative IDE) this should make it easier. Fields Swagger requires appear in constructors, optional fields are set with specific setter methods.

Type hinting all over the place!

###Example
```php
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
```
###Output
```json
{
    "swagger": "2.0",
    "info": {
        "title": "Example",
        "version": "0.1.0",
        "description": "My example.",
        "termsOfService": "Some terms",
        "contact": {
            "name": "Example Org",
            "url": "www.example.org",
            "email": "support@example.org",
            "x-billing": "billing@example.org",
            "x-technical": "technical@example.org"
        },
        "license": {
            "name": "Example License",
            "url": "www.my.org/license",
            "x-more-license-data": "This is just an example.",
            "x-extra-license-data": "Really, this is all just for example."
        }
    },
    "paths": {
        "/": {
            "get": {
                "responses": {
                    "200": {
                        "description": "The response to this request."
                    }
                }
            }
        },
        "/users": {
            "get": {
                "responses": {
                    "200": {
                        "description": "The response to this request.",
                        "headers": {
                            "X-Rate-Limit-Remaining": {
                                "type": "integer",
                                "description": "The number of remaining requests in the current period."
                            },
                            "X-Rate-Limit-Reset": {
                                "type": "integer",
                                "description": "The number of seconds left in the current period."
                            }
                        }
                    }
                },
                "parameters": [
                    {
                        "name": "page",
                        "required": false,
                        "in": "query",
                        "type": "string"
                    },
                    {
                        "name": "first_name",
                        "required": false,
                        "in": "query",
                        "type": "string",
                        "description": "The name by which to filter users.",
                        "x-deprecated-warning": "Deprecated in 0.0.3"
                    }
                ]
            },
            "post": {
                "responses": {
                    "200": {
                        "description": "The response to this request."
                    },
                    "422": {
                        "description": "The response to this request."
                    }
                },
                "summary": "Persist a user.",
                "description": "Stores a user in a database.",
                "operationId": "users.persist"
            },
            "put": {
                "responses": {
                    "422": {
                        "description": "The client provided invalid user data.",
                        "examples": {
                            "application/json": [
                                {
                                    "type": "user",
                                    "id": 1,
                                    "properties": {
                                        "first_name": "Arya",
                                        "age": 9
                                    }
                                }
                            ]
                        }
                    }
                },
                "parameters": [
                    {
                        "name": "first_name",
                        "required": true,
                        "in": "body",
                        "schema": []
                    },
                    {
                        "name": "age",
                        "required": true,
                        "in": "body",
                        "schema": []
                    }
                ]
            }
        }
    },
    "host": "192.176.99.100",
    "basePath": "/api",
    "schemes": [
        "https"
    ],
    "consumes": [
        "application/json"
    ],
    "produces": [
        "application/json"
    ]
}
```
