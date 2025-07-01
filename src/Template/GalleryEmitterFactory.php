<?php

namespace Sx\Template\Image\Template;

use Sx\Container\FactoryInterface;
use Sx\Container\Injector;
use Sx\Template\Image\ConfiguredImageRendererInterface;
use Sx\Template\Image\GalleryValueProviderInterface;
use Sx\Template\Image\ImageValueProviderInterface;
use Sx\Template\PageValueProviderInterface;

class GalleryEmitterFactory implements FactoryInterface
{
    /**
     * @param Injector $injector
     * @param array<mixed> $options
     * @param string $class
     *
     * @return GalleryEmitter
     */
    public function create(Injector $injector, array $options, string $class): GalleryEmitter
    {
        $pageValueProvider = $injector->get(PageValueProviderInterface::class);
        assert($pageValueProvider instanceof PageValueProviderInterface);
        $galleryValueProvider = $injector->get(GalleryValueProviderInterface::class);
        assert($galleryValueProvider instanceof GalleryValueProviderInterface);
        $imageValueProvider = $injector->get(ImageValueProviderInterface::class);
        assert($imageValueProvider instanceof ImageValueProviderInterface);
        $imageRenderer = $injector->get(ConfiguredImageRendererInterface::class);
        assert($imageRenderer instanceof ConfiguredImageRendererInterface);
        return new GalleryEmitter(
            $pageValueProvider,
            $galleryValueProvider,
            $imageValueProvider,
            $imageRenderer,
        );
    }
}
