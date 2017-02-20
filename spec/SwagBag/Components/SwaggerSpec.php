<?php

namespace spec\SwagBag\Components;

use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use SwagBag\Components\Info;
use SwagBag\Components\Path;
use SwagBag\Components\Swagger;
use TypeError;

class SwaggerSpec extends ObjectBehavior
{
    public function let(Info $info, Path $path)
    {
        $path->getUri()->willReturn('/');
        $this->beConstructedWith('2.0', $info, [$path]);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(Swagger::class);
    }

    public function it_requires_at_least_one_path(Info $info)
    {
        $this->beConstructedWith('2.0', $info, []);
        $this
            ->shouldThrow(new InvalidArgumentException('At least one path must be specified.'))
            ->duringInstantiation();
    }

    public function it_requires_path_objects_specifically(Info $info)
    {
        $this->beConstructedWith('2.0', $info, ['foobar']);
        $this
            ->shouldThrow(TypeError::class)
            ->duringInstantiation();
    }

    public function it_stores_its_info(Info $info, Path $path)
    {
        $path->getUri()->willReturn('/');
        $this->beConstructedWith('2.0', $info, [$path]);
        $this->shouldHaveKeyWithValue('info', $info);
    }

    public function it_stores_its_version()
    {
        $this->shouldHaveKeyWithValue('swagger', '2.0');
    }
}
