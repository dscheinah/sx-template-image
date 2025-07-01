<?php

namespace Sx\Template\Image\Template;

use Sx\Container\FactoryInterface;
use Sx\Container\Injector;
use Sx\Template\Collector\Collector;
use Sx\Template\PageValueProviderInterface;

class GalleryCollectorFactory implements FactoryInterface
{
    /**
     * @param Injector $injector
     * @param array<mixed> $options
     * @param string $class
     *
     * @return GalleryCollector
     */
    public function create(Injector $injector, array $options, string $class): GalleryCollector
    {
        $collector = $injector->get(Collector::class);
        assert($collector instanceof Collector);
        $pageValueProvider = $injector->get(PageValueProviderInterface::class);
        assert($pageValueProvider instanceof PageValueProviderInterface);
        return new GalleryCollector(
            $collector,
            $pageValueProvider,
        );
    }
}
