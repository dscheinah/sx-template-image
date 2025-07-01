<?php

namespace Sx\Template\Image\Template;

use Sx\Template\Image\ConfiguredImageRendererInterface;
use Sx\Template\Image\DTO\ImageConfigurationDTO;
use Sx\Template\Image\DTO\ImageDTO;
use Sx\Template\Image\ImageValueProviderInterface;
use Sx\Template\PageValueProviderInterface;

class ImageEmitter implements ImageInterface
{
    public function __construct(
        private readonly PageValueProviderInterface $pageValueProvider,
        private readonly ImageValueProviderInterface $imageValueProvider,
        private readonly ConfiguredImageRendererInterface $imageRenderer,
    ) {
    }

    /**
     * Renders the currently selected image for the key using the registered providers.
     *
     * The label is only needed for the CMS and therefore unused.
     *
     * @param string $key
     * @param ImageConfigurationDTO $configuration
     * @param string|null $label
     *
     * @return ImageDTO|null
     */
    public function image(string $key, ImageConfigurationDTO $configuration, ?string $label = null): ?ImageDTO
    {
        $value = $this->pageValueProvider->get('image', $key);
        if (!$value) {
            return null;
        }
        $properties = $this->imageValueProvider->get($value);
        if (!$properties) {
            return null;
        }
        return $this->imageRenderer->render($properties, $configuration);
    }
}
