<?php

namespace Sx\Template\Image\Template;

use Sx\Template\Image\DTO\ImageConfigurationDTO;
use Sx\Template\Image\DTO\ImageDTO;

interface ImageInterface
{
    /**
     * Used to render an image with the given key and configuration. Use the label for the CMS user.
     *
     * @param string $key
     * @param ImageConfigurationDTO $configuration
     * @param string|null $label
     *
     * @return ImageDTO|null
     */
    public function image(string $key, ImageConfigurationDTO $configuration, ?string $label = null): ?ImageDTO;
}
