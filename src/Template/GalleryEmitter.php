<?php

namespace Sx\Template\Image\Template;

use Sx\Template\Image\ConfiguredImageRendererInterface;
use Sx\Template\Image\DTO\ImageConfigurationDTO;
use Sx\Template\Image\DTO\ImageDTO;
use Sx\Template\Image\GalleryValueProviderInterface;
use Sx\Template\Image\ImageValueProviderInterface;
use Sx\Template\PageValueProviderInterface;

class GalleryEmitter implements GalleryInterface
{
    public function __construct(
        private readonly PageValueProviderInterface $pageValueProvider,
        private readonly GalleryValueProviderInterface $galleryValueProvider,
        private readonly ImageValueProviderInterface $imageValueProvider,
        private readonly ConfiguredImageRendererInterface $imageRenderer,
    ) {
    }

    /**
     * Returns the images of the currently selected gallery for the key using the registered providers.
     *
     * The label is only needed for the CMS and therefore unused.
     *
     * @param string $key
     * @param ImageConfigurationDTO $configuration
     * @param string|null $label
     *
     * @return iterable<ImageDTO>
     */
    public function gallery(string $key, ImageConfigurationDTO $configuration, ?string $label = null): iterable
    {
        $value = $this->pageValueProvider->get('gallery', $key);
        if (!$value) {
            return [];
        }
        $images = [];
        foreach ($this->galleryValueProvider->get($value) as $imageValue) {
            $properties = $this->imageValueProvider->get($imageValue);
            if (!$properties) {
                continue;
            }
            $image = $this->imageRenderer->render($properties, $configuration);
            if (!$image) {
                continue;
            }
            $images[] = $image;
        }
        return $images;
    }
}
