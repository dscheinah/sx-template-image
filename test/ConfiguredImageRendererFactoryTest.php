<?php

namespace Sx\TemplateTest\Image;

use PHPUnit\Framework\TestCase;
use Sx\Container\ContainerException;
use Sx\Container\Injector;
use Sx\Template\Image\ConfiguredImageRendererFactory;

class ConfiguredImageRendererFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $this->expectNotToPerformAssertions();
        $factory = new ConfiguredImageRendererFactory();
        $factory->create(new Injector(), ['image' => ['directory' => __DIR__, 'prefix'    => '/']], '');
    }

    public function testCreateWithoutDirectory(): void
    {
        $this->expectException(ContainerException::class);
        $factory = new ConfiguredImageRendererFactory();
        $factory->create(new Injector(), ['image' => ['prefix' => '/']], '');
    }

    public function testCreateWithoutPrefix(): void
    {
        $this->expectException(ContainerException::class);
        $factory = new ConfiguredImageRendererFactory();
        $factory->create(new Injector(), ['image' => ['directory' => __DIR__]], '');
    }
}
