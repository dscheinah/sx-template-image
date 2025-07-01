<?php

namespace Sx\Template\Image\DTO;

class ImageDTO
{
    /**
     * Contains all generated data for the main image to render.
     *
     * @var ImageDataDTO
     */
    public ImageDataDTO $image;

    /**
     * If a thumbnail is generated, this contains all the generated data for the thumbnail.
     *
     * @var ImageDataDTO|null
     */
    public ?ImageDataDTO $thumbnail = null;

    /**
     * Contains all the properties given by the ImageValueProviderInterface to be used as attributes.
     *
     * @var ImagePropertyDTO
     */
    public ImagePropertyDTO $properties;

    /**
     * Renders a default image tag with data and properties.
     *
     * If a thumbnail is set, it is preferred for rendering. In that case, you should use the image manually.
     *
     * @return string
     */
    public function __toString(): string
    {
        $data = $this->thumbnail ?: $this->image;
        return sprintf(
            '<img src="%s" width="%d" height="%d" alt="%s" title="%s"/>',
            $data->url,
            $data->width,
            $data->height,
            htmlentities($this->properties->alt ?: ''),
            htmlentities($this->properties->title ?: ''),
        );
    }
}
