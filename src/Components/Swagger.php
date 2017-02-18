<?php

namespace SwagBag\Components;

use SwagBag\Mime;
use SwagBag\Scheme;

class Swagger extends Component
{
    public function __construct(string $version, Info $info, array $paths = [])
    {
        $this
            ->set('version', $version)
            ->set('info', $info);
        foreach ($paths as $path) {
            $this->addPath($path);
        }
    }

    private function addPath(Path $path): Swagger
    {
        return $this->set("paths.{$path->getUri()}", $path);
    }

    public function setHost(string $host = 'localhost'): Swagger
    {
        return $this->set('host', $host);
    }

    public function setBasePath(string $basePath = '/v1'): Swagger
    {
        if (strpos($basePath, '/') !== 0) {
            $basePath = "/{$basePath}";
        }
        return $this->set('basePath', $basePath);
    }

    public function addScheme(string $scheme = Scheme::HTTP): Swagger
    {
        return $this->append('schemes', $scheme);
    }

    public function addConsumedMime(string $mime = Mime::JSON): Swagger
    {
        return $this->append('consumes', $mime);
    }

    public function addProducedMime(string $mime = Mime::JSON): Swagger
    {
        return $this->append('produces', $mime);
    }
}
