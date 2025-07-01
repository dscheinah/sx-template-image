<?php

namespace Sx\Template\Image\DTO;

class ImagePropertyDTO
{
    /**
     * Set this to the source path in the filesystem. This will be used to render the public images.
     *
     * @var string
     */
    public string $source;

    /**
     * Defines the base filename of the rendered image.
     *
     * You can append a hash or version. Identifiers for sizes and the file extension are added automatically.
     *
     * @var string|null
     */
    public ?string $name = null;

    /**
     * Defines the alt attribute of the image tag.
     *
     * @var string|null
     */
    public ?string $alt = null;

    /**
     * Defines the title attribute the image tag.
     *
     * @var string|null
     */
    public ?string $title = null;
}
