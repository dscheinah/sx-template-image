<?php

namespace Sx\Template\Image;

interface GalleryValueProviderInterface
{
    /**
     * Is called given a value from the PageValueProvider to get the list of image values to output.
     *
     * Each entry of the returned array is given to the ImageValueProviderInterface to get the real image data.
     *
     * @param mixed $value
     *
     * @return array<mixed>
     */
    public function get(mixed $value): array;
}
