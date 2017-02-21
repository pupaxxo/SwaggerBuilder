<?php

namespace SwaggerBuilder\Components;

use SwaggerBuilder\Traits\Description;

class Response extends Component
{
    use Description;

    private $code;

    /**
     * Response constructor.
     * @param integer|string $code
     * @param string $description
     */
    public function __construct($code = 'default', string $description = 'The response to this request.')
    {
        $this->code = $code;
        $this->setDescription($description);
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setSchema(Schema $schema): Response
    {
        return $this->set('schema', $schema);
    }

    public function addHeader(Header $header): Response
    {
        return $this->set("headers.{$header->getName()}", $header);
    }

    public function addExample(Example $example): Response
    {
        return $this->add("examples.{$example->getMime()}", $example);
    }
}
