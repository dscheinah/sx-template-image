<?php

namespace Sx\TemplateTest\Image\Template;

use PHPUnit\Framework\TestCase;
use Sx\Container\Injector;
use Sx\Template\Collector\Collector;
use Sx\Template\Image\Template\ImageCollectorFactory;
use Sx\Template\PageValueProviderInterface;

class ImageCollectorFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $this->expectNotToPerformAssertions();

        $injector = new Injector();
        $injector->set(Collector::class, $this->createMock(Collector::class));
        $injector->set(PageValueProviderInterface::class, $this->createMock(PageValueProviderInterface::class));

        $factory = new ImageCollectorFactory();
        $factory->create($injector, [], '');
    }
}
