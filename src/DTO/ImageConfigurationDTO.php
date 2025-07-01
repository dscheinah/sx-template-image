<?php

namespace Sx\Template\Image\DTO;

class ImageConfigurationDTO
{
    /**
     * Set this to true to generate two version of the image with different sizes
     * given by $thumbnail_width and $thumbnail_height.
     *
     * @var bool
     */
    public bool $use_thumbnail = false;

    /**
     * Used to set the target width of the generated image.
     *
     * Leave empty to auto-calculate by height or if none are given, use the full input size.
     *
     * @var positive-int|null
     */
    public ?int $width = null;

    /**
     * Used to set the target height of the generated image.
     *
     * Leave empty to auto-calculate by width or if none are given, use the full input size.
     *
     * @var positive-int|null
     */
    public ?int $height = null;

    /**
     * Set $use_thumbnail to true to activate this property. It follows the same rules as $width.
     *
     * @var positive-int|null
     */
    public ?int $thumbnail_width = null;

    /**
     * Set $use_thumbnail to true to activate this property. It follows the same rules as $height.
     *
     * @var positive-int|null
     */
    public ?int $thumbnail_height = null;
}
