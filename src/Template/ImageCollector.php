<?php

namespace Sx\Template\Image\Template;

use Sx\Template\Collector\Collector;
use Sx\Template\Collector\DTO\CollectorContentDTO;
use Sx\Template\Image\DTO\ImageConfigurationDTO;
use Sx\Template\Image\DTO\ImageDTO;
use Sx\Template\PageValueProviderInterface;

class ImageCollector implements ImageInterface
{
    public function __construct(
        private readonly Collector $collector,
        private readonly PageValueProviderInterface $pageValueProvider,
    ) {
    }

    /**
     * Registers the given image for selection in the CMS.
     *
     * The current selected value is retrieved from the page provider.
     *
     * @param string $key
     * @param ImageConfigurationDTO $configuration
     * @param string|null $label
     *
     * @return ImageDTO|null
     */
    public function image(string $key, ImageConfigurationDTO $configuration, ?string $label = null): ?ImageDTO
    {
        $collectorContentDTO = new CollectorContentDTO();
        $collectorContentDTO->type = 'image';
        $collectorContentDTO->key = $key;
        $collectorContentDTO->value = $this->pageValueProvider->get('image', $key);
        $collectorContentDTO->label = $label;
        $this->collector->addContent($collectorContentDTO);
        return null;
    }
}
