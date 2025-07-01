<?php

namespace Sx\Template\Image\Template;

use Sx\Container\FactoryInterface;
use Sx\Container\Injector;
use Sx\Template\Image\ConfiguredImageRendererInterface;
use Sx\Template\Image\ImageValueProviderInterface;
use Sx\Template\PageValueProviderInterface;

class ImageEmitterFactory implements FactoryInterface
{
    /**
     * @param Injector $injector
     * @param array<mixed> $options
     * @param string $class
     *
     * @return ImageEmitter
     */
    public function create(Injector $injector, array $options, string $class): ImageEmitter
    {
        $pageValueProvider = $injector->get(PageValueProviderInterface::class);
        assert($pageValueProvider instanceof PageValueProviderInterface);
        $imageValueProvider = $injector->get(ImageValueProviderInterface::class);
        assert($imageValueProvider instanceof ImageValueProviderInterface);
        $imageRenderer = $injector->get(ConfiguredImageRendererInterface::class);
        assert($imageRenderer instanceof ConfiguredImageRendererInterface);
        return new ImageEmitter(
            $pageValueProvider,
            $imageValueProvider,
            $imageRenderer,
        );
    }
}
