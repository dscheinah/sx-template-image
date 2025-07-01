<?php

namespace Sx\Template\Image\DTO;

class ImageDataDTO
{
    /**
     * The internal filesystem path of the rendered image.
     *
     * @var string
     */
    public string $path;

    /**
     * The public URL of the rendered image.
     *
     * @var string
     */
    public string $url;

    /**
     * The base64 encoded content of the rendered image.
     *
     * @var string
     */
    public string $base64;

    /**
     * The real width of the rendered image.
     *
     * @var positive-int
     */
    public int $width;

    /**
     * The real height of the rendered image.
     *
     * @var positive-int
     */
    public int $height;
}
