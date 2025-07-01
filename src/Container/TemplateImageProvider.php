<?php

namespace Sx\Template\Image\Container;

use Sx\Container\Injector;
use Sx\Container\ProviderInterface;
use Sx\Template\Image\ConfiguredImageRendererFactory;
use Sx\Template\Image\ConfiguredImageRendererInterface;
use Sx\Template\Image\Template\GalleryCollector;
use Sx\Template\Image\Template\GalleryCollectorFactory;
use Sx\Template\Image\Template\GalleryEmitter;
use Sx\Template\Image\Template\GalleryEmitterFactory;
use Sx\Template\Image\Template\ImageCollector;
use Sx\Template\Image\Template\ImageCollectorFactory;
use Sx\Template\Image\Template\ImageEmitter;
use Sx\Template\Image\Template\ImageEmitterFactory;

class TemplateImageProvider implements ProviderInterface
{
    /**
     * Registers the default factories for all classes used in this module.
     *
     * @param Injector $injector
     */
    public function provide(Injector $injector): void
    {
        $injector->set(ConfiguredImageRendererInterface::class, ConfiguredImageRendererFactory::class);

        $injector->set(GalleryCollector::class, GalleryCollectorFactory::class);
        $injector->set(GalleryEmitter::class, GalleryEmitterFactory::class);
        $injector->set(ImageCollector::class, ImageCollectorFactory::class);
        $injector->set(ImageEmitter::class, ImageEmitterFactory::class);
    }
}
