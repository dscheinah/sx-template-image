<?php

namespace Sx\Template\Image;

use Sx\Template\Image\DTO\ImagePropertyDTO;

interface ImageValueProviderInterface
{
    /**
     * Is called given a value from the PageValueProvider to get the real image data to output.
     *
     * @param mixed $value
     *
     * @return ImagePropertyDTO|null
     */
    public function get(mixed $value): ?ImagePropertyDTO;
}
