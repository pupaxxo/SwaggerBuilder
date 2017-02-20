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
                }
            }
        },
        "/user/{userId}": {
            "get": {
                "responses": {
                    "200": {
                        "description": "User fetched successfully."
                    },
                    "404": {
                        "description": "User id not found."
                    }
                }
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
                }
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
