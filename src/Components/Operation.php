<?php

namespace SwagBag\Components;

use InvalidArgumentException;
use SwagBag\Constants\Verb;
use SwagBag\Traits\Mimes;
use SwagBag\Traits\Parameters;
use SwagBag\Traits\Schemes;
use SwagBag\Validator;

class Operation extends Component
{
    use Mimes, Parameters, Schemes;

    private static $IDS = [];

    private $method;

    /**
     * Operation constructor.
     * @param string $method
     * @param Response[] $responses
     */
    public function __construct(string $method = Verb::GET, array $responses = [])
    {
        Validator::assertNotEmpty($responses, static::class, Response::class);
        $this->method = $method;
        foreach ($responses as $response) {
            $this->addResponse($response);
        }
    }

    private function addResponse(Response $response): Operation
    {
        return $this->set("responses.{$response->getCode()}", $response);
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function setSummary(string $summary): Operation
    {
        return $this->set('summary', $summary);
    }

    public function setDescription(string $description): Operation
    {
        return $this->set('description', $description);
    }

    public function setOperationId(string $id): Operation
    {
        if (($i = array_search($id, static::$IDS)) !== false) {
            throw new InvalidArgumentException("Given operation id '{$id}' is already registered as the {$i}th operation.");
        }
        static::$IDS[] = $id;
        return $this->set('operationId', $id);
    }

    public function setDeprecated(): Operation
    {
        return $this->set('deprecated', true);
    }
}
