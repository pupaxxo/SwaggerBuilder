# Still very much in development!
...
# SwaggerBuilder
Now you can write your Swagger API documentation in JSON, YAML, _or_ PHP!

Do you find the Swagger config very hard to write? Well (with an informative IDE) this should make it easier. Fields Swagger requires appear in constructors, optional fields are set with specific setter methods.

Type hinting all over the place!

###Example
```php
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
            (new Response(200, 'User fetched successfully.'))
                ->setSchema((new Schema())
                    ->setProperty('type', (new Schema(SchemaType::STRING)))
                    ->setProperty('id', (new Schema(SchemaType::NUMBER)))
                    ->setProperty('attributes', (new Schema())
                        ->setProperty('name', (new Schema(SchemaType::STRING)))
                        ->setProperty('phone', (new Schema(SchemaType::NUMBER)))
                        ->setProperty('profileImg', (new Schema(SchemaType::STRING))
                            ->setDescription('A url from which the User profile image can be fetched.')))
                    ->setExample([
                        'type' => 'User',
                        'id' => 42,
                        'attributes' => [
                            'name' => 'John Doe',
                            'phone' => 8881231234,
                            'profileImg' => 'www.my.org/imgs/42.png',
                        ],
                    ])),
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
            ->addParameter(new BodyParameter('body', true, (new Schema())
                ->setProperty('name', (new Schema(SchemaType::STRING))->setExample('Mary Jane'))
                ->setProperty('phone', (new Schema(SchemaType::NUMBER))->setExample(8881230123))
                ->setProperty('password', (new Schema(SchemaType::STRING)))->setExample('pass123'))),
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
        "/user": {
            "post": {
                "responses": {
                    "200": {
                        "description": "User created successfully."
                    },
                    "422": {
                        "description": "Invalid user data given."
                    }
                },
                "consumes": [
                    "multipart/form-data"
                ],
                "parameters": [
                    {
                        "name": "name",
                        "in": "formData",
                        "type": "string",
                        "required": true
                    },
                    {
                        "name": "password",
                        "in": "formData",
                        "type": "string",
                        "required": true,
                        "minLength": 6
                    },
                    {
                        "name": "phone",
                        "in": "formData",
                        "type": "integer",
                        "required": false,
                        "minimum": 1000000000,
                        "exclusiveMinimum": false,
                        "maximum": 99999999999
                    },
                    {
                        "name": "profileImg",
                        "in": "formData",
                        "type": "string",
                        "required": false
                    }
                ]
            }
        },
        "/user/{userId}": {
            "get": {
                "responses": {
                    "200": {
                        "description": "User fetched successfully.",
                        "schema": {
                            "type": "object",
                            "properties": {
                                "type": {
                                    "type": "string"
                                },
                                "id": {
                                    "type": "number"
                                },
                                "attributes": {
                                    "type": "object",
                                    "properties": {
                                        "name": {
                                            "type": "string"
                                        },
                                        "phone": {
                                            "type": "number"
                                        },
                                        "profileImg": {
                                            "type": "string",
                                            "description": "A url from which the User profile image can be fetched."
                                        }
                                    }
                                }
                            },
                            "example": {
                                "type": "User",
                                "id": 42,
                                "attributes": {
                                    "name": "John Doe",
                                    "phone": 8881231234,
                                    "profileImg": "www.my.org/imgs/42.png"
                                }
                            }
                        }
                    },
                    "404": {
                        "description": "User id not found."
                    }
                },
                "parameters": [
                    {
                        "name": "include",
                        "in": "query",
                        "type": "array",
                        "required": false,
                        "items": {
                            "type": "string"
                        },
                        "description": "Available User relationships include: [subscription, organizations]"
                    }
                ]
            },
            "put": {
                "responses": {
                    "200": {
                        "description": "User updated successfully."
                    },
                    "422": {
                        "description": "Invalid user data given."
                    },
                    "404": {
                        "description": "User id not found."
                    }
                },
                "parameters": [
                    {
                        "name": "body",
                        "in": "body",
                        "required": true,
                        "schema": {
                            "type": "object",
                            "properties": {
                                "name": {
                                    "type": "string",
                                    "example": "Mary Jane"
                                },
                                "phone": {
                                    "type": "number",
                                    "example": 8881230123
                                },
                                "password": {
                                    "type": "string"
                                }
                            },
                            "example": "pass123"
                        }
                    }
                ]
            },
            "delete": {
                "responses": {
                    "200": {
                        "description": "User deleted successfully."
                    },
                    "404": {
                        "description": "User id not found."
                    }
                }
            },
            "parameters": [
                {
                    "name": "userId",
                    "in": "path",
                    "type": "integer",
                    "required": true,
                    "description": "The id of the User resource to be operated on."
                }
            ]
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
