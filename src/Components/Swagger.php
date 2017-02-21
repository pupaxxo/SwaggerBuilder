<?php

namespace SwaggerBuilder\Components;

use SwaggerBuilder\Traits\Mimes;
use SwaggerBuilder\Traits\Schemes;
use SwaggerBuilder\Validator;

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
        Validator::assertNotEmpty($paths, static::class, Path::class);
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
