<?php

namespace Sx\Template\Image\Template;

use Sx\Template\Image\DTO\ImageConfigurationDTO;
use Sx\Template\Image\DTO\ImageDTO;

interface GalleryInterface
{
    /**
     * Used to get a gallery with the given key and configuration. Use the label for the CMS user.
     *
     * To render, you need to iterate and render each resulting image separate.
     *
     * @param string $key
     * @param ImageConfigurationDTO $configuration
     * @param string|null $label
     *
     * @return iterable<ImageDTO>
     */
    public function gallery(string $key, ImageConfigurationDTO $configuration, ?string $label = null): iterable;
}
