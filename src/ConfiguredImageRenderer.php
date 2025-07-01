<?php

namespace Sx\Template\Image;

use Sx\Image\ImageRenderer;
use Sx\Template\Image\DTO\ImageConfigurationDTO;
use Sx\Template\Image\DTO\ImageDataDTO;
use Sx\Template\Image\DTO\ImageDTO;
use Sx\Template\Image\DTO\ImagePropertyDTO;

class ConfiguredImageRenderer implements ConfiguredImageRendererInterface
{
    public function __construct(
        private readonly ImageRenderer $renderer,
        private readonly string $directory,
        private readonly string $prefix,
    ) {
    }

    /**
     * Creates a rendered image out of the given properties and configuration.
     *
     * @param ImagePropertyDTO $properties
     * @param ImageConfigurationDTO $configuration
     *
     * @return ImageDTO|null
     */
    public function render(ImagePropertyDTO $properties, ImageConfigurationDTO $configuration): ?ImageDTO
    {
        $name = $properties->name ?: pathinfo($properties->source, PATHINFO_FILENAME);

        $image = new ImageDTO();

        $data = $this->createData(
            $properties->source,
            $name,
            $configuration->width,
            $configuration->height,
        );
        if (!$data) {
            return null;
        }
        $image->image = $data;

        if ($configuration->use_thumbnail) {
            $image->thumbnail = $this->createData(
                $properties->source,
                $name,
                $configuration->thumbnail_width,
                $configuration->thumbnail_height,
            );
        }

        $image->properties = $properties;
        return $image;
    }

    /**
     * Renders an image and creates the complete ImageDataDTO.
     *
     * @param string $source
     * @param string $name
     * @param positive-int|null $width
     * @param positive-int|null $height
     *
     * @return ImageDataDTO|null
     */
    private function createData(string $source, string $name, ?int $width, ?int $height): ?ImageDataDTO
    {
        $name = sprintf('%s-%sx%s.jpg', $name, $width ?: 0, $height ?: 0);

        $target = rtrim($this->directory, '/') . '/' . $name;

        $image = $this->renderer->readFromJpeg($target, $width, $height)
            ?: $this->renderer->renderToJpeg($source, $target, $width, $height);

        if (!$image) {
            return null;
        }

        $data = new ImageDataDTO();
        $data->path = $target;
        $data->url = rtrim($this->prefix, '/') . '/' . $name;
        $data->base64 = $image->base64;
        $data->width = $image->width;
        $data->height = $image->height;
        return $data;
    }
}
