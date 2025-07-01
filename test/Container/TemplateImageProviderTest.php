<?php

namespace Sx\TemplateTest\Image\Container;

use PHPUnit\Framework\TestCase;
use Sx\Container\Injector;
use Sx\Template\Image\ConfiguredImageRendererInterface;
use Sx\Template\Image\Container\TemplateImageProvider;
use Sx\Template\Image\Template\GalleryCollector;
use Sx\Template\Image\Template\GalleryEmitter;
use Sx\Template\Image\Template\ImageCollector;
use Sx\Template\Image\Template\ImageEmitter;

class TemplateImageProviderTest extends TestCase
{
    public function testProvide(): void
    {
        $injector = new Injector();
        (new TemplateImageProvider())->provide($injector);
        self::assertTrue($injector->has(ConfiguredImageRendererInterface::class));
        self::assertTrue($injector->has(GalleryCollector::class));
        self::assertTrue($injector->has(GalleryEmitter::class));
        self::assertTrue($injector->has(ImageCollector::class));
        self::assertTrue($injector->has(ImageEmitter::class));
    }
}
