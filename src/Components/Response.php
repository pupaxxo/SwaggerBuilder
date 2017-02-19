<?php

namespace SwagBag\Components;

class Response extends Component
{
    private $code;

    public function __construct(int $code = 200, string $description = 'The response to this request.')
    {
        $this->code = $code;
        $this->setDescription($description);
    }

    private function setDescription(string $description): Response
    {
        return $this->set('description', $description);
    }

    public function getCode(): int
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
        return $this->append("examples.{$example->getMime()}", $example);
    }
}
