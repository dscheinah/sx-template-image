<?php

namespace Sx\TemplateTest\Image\Template;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sx\Template\Collector\Collector;
use Sx\Template\Collector\DTO\CollectorContentDTO;
use Sx\Template\Image\DTO\ImageConfigurationDTO;
use Sx\Template\Image\Template\GalleryCollector;
use Sx\Template\PageValueProviderInterface;

class GalleryCollectorTest extends TestCase
{
    private GalleryCollector $galleryCollector;

    private MockObject $collectorMock;

    private MockObject $pageValueProviderMock;

    protected function setUp(): void
    {
        $this->collectorMock = $this->createMock(Collector::class);
        $this->pageValueProviderMock = $this->createMock(PageValueProviderInterface::class);
        $this->galleryCollector = new GalleryCollector(
            $this->collectorMock,
            $this->pageValueProviderMock,
        );
    }

    public function testGallery(): void
    {
        $collectorContentDTO = new CollectorContentDTO();
        $collectorContentDTO->type = 'gallery';
        $collectorContentDTO->key = 'test key';
        $collectorContentDTO->value = 'test value';
        $collectorContentDTO->label = 'test label';

        $this->pageValueProviderMock->expects($this->once())->method('get')
            ->with($collectorContentDTO->type, $collectorContentDTO->key)
            ->willReturn($collectorContentDTO->value);

        $this->collectorMock->expects($this->once())->method('addContent')
            ->with($collectorContentDTO);

        self::assertEmpty($this->galleryCollector->gallery($collectorContentDTO->key, new ImageConfigurationDTO(), $collectorContentDTO->label));
    }
}
