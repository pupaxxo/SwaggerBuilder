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
    new Response(200),
]))
    ->addParameter(new Parameter('page'));

$updateUser = (new Operation(Verb::PUT, [
    new Response(422),
]));

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
                    "200": []
                }
            }
        },
        "/users": {
            "get": {
                "responses": {
                    "200": []
                },
                "parameters": {
                    "page": [
                        []
                    ]
                }
            },
            "post": {
                "responses": {
                    "200": [],
                    "422": []
                },
                "summary": "Persist a user.",
                "description": "Stores a user in a database.",
                "operationId": "users.persist"
            },
            "put": {
                "responses": {
                    "422": []
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
