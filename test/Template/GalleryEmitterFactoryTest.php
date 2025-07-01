<?php

namespace Sx\TemplateTest\Image\Template;

use PHPUnit\Framework\TestCase;
use Sx\Container\Injector;
use Sx\Template\Image\ConfiguredImageRendererInterface;
use Sx\Template\Image\GalleryValueProviderInterface;
use Sx\Template\Image\ImageValueProviderInterface;
use Sx\Template\Image\Template\GalleryEmitterFactory;
use Sx\Template\PageValueProviderInterface;

class GalleryEmitterFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $this->expectNotToPerformAssertions();

        $injector = new Injector();
        $injector->set(PageValueProviderInterface::class, $this->createMock(PageValueProviderInterface::class));
        $injector->set(GalleryValueProviderInterface::class, $this->createMock(GalleryValueProviderInterface::class));
        $injector->set(ImageValueProviderInterface::class, $this->createMock(ImageValueProviderInterface::class));
        $injector->set(ConfiguredImageRendererInterface::class, $this->createMock(ConfiguredImageRendererInterface::class));

        $factory = new GalleryEmitterFactory();
        $factory->create($injector, [], '');
    }
}
