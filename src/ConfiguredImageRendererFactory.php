<?php

namespace Sx\Template\Image;

use Sx\Container\ContainerException;
use Sx\Container\FactoryInterface;
use Sx\Container\Injector;
use Sx\Image\ImageRenderer;

class ConfiguredImageRendererFactory implements FactoryInterface
{
    /**
     * @param Injector $injector
     * @param array<mixed> $options
     * @param string $class
     *
     * @return ConfiguredImageRenderer
     */
    public function create(Injector $injector, array $options, string $class): ConfiguredImageRenderer
    {
        $config = $options['image'] ?? [];
        assert(is_array($config));
        if (!isset($config['directory']) || !is_string($config['directory'])) {
            throw new ContainerException(
                'Configure "image.directory" as rendering target.'
            );
        }
        if (!isset($config['prefix']) || !is_string($config['prefix'])) {
            throw new ContainerException(
                'Configure "image.prefix" for browsers to target directory.'
            );
        }
        return new ConfiguredImageRenderer(
            new ImageRenderer(),
            $config['directory'] ,
            $config['prefix'],
        );
    }
}
