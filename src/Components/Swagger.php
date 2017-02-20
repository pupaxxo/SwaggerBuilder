<?php

namespace SwagBag\Components;

use InvalidArgumentException;
use SwagBag\Traits\Mimes;
use SwagBag\Traits\Schemes;

class Swagger extends Component
{
    use Mimes, Schemes;

    /**
     * Swagger constructor.
     * @param string $version
     * @param Info $info
     * @param Path[] $paths
     */
    public function __construct(string $version, Info $info, array $paths = [])
    {
        if (!$paths) {
            throw new InvalidArgumentException('At least one path must be specified.');
        }
        foreach ($paths as $path) {
            $this->addPath($path);
        }
        $this
            ->set('swagger', $version)
            ->set('info', $info);
    }

    private function addPath(Path $path): Swagger
    {
        return $this->set("paths.{$path->getUri()}", $path);
    }

    public function setHost(string $host = 'localhost'): Swagger
    {
        return $this->set('host', $host);
    }

    public function setBasePath(string $basePath = '/api/v1'): Swagger
    {
        if (strpos($basePath, '/') !== 0) {
            $basePath = "/{$basePath}";
        }
        return $this->set('basePath', $basePath);
    }
}
