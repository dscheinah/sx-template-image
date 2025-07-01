<?php

namespace Sx\Template\Image;

use Sx\Template\Image\DTO\ImageConfigurationDTO;
use Sx\Template\Image\DTO\ImageDTO;
use Sx\Template\Image\DTO\ImagePropertyDTO;

interface ConfiguredImageRendererInterface
{
    /**
     * Implement to create a rendered image out of the given properties and configuration.
     *
     * @param ImagePropertyDTO $properties
     * @param ImageConfigurationDTO $configuration
     *
     * @return ImageDTO|null
     */
    public function render(ImagePropertyDTO $properties, ImageConfigurationDTO $configuration): ?ImageDTO;
}
