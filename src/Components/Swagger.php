<?php

namespace SwagBag\Components;

use SwagBag\Traits\Mimes;
use SwagBag\Traits\Schemes;

class Swagger extends Component
{
    use Mimes, Schemes {
        Mimes::set insteadof Schemes;
        Mimes::append insteadof Schemes;
    }

    /**
     * Swagger constructor.
     * @param string $version
     * @param Info $info
     * @param Path[] $paths
     */
    public function __construct(string $version, Info $info, array $paths = [])
    {
        $this
            ->set('swagger', $version)
            ->set('info', $info);
        foreach ($paths as $path) {
            $this->addPath($path);
        }
    }

    public function addPath(Path $path): Swagger
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
