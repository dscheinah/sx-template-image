<?php

namespace Sx\TemplateTest\Image\Template;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sx\Template\Collector\Collector;
use Sx\Template\Collector\DTO\CollectorContentDTO;
use Sx\Template\Image\DTO\ImageConfigurationDTO;
use Sx\Template\Image\Template\ImageCollector;
use Sx\Template\PageValueProviderInterface;

class ImageCollectorTest extends TestCase
{
    private ImageCollector $imageCollector;

    private MockObject $collectorMock;

    private MockObject $pageValueProviderMock;

    protected function setUp(): void
    {
        $this->collectorMock = $this->createMock(Collector::class);
        $this->pageValueProviderMock = $this->createMock(PageValueProviderInterface::class);
        $this->imageCollector = new ImageCollector(
            $this->collectorMock,
            $this->pageValueProviderMock,
        );
    }

    public function testImage(): void
    {
        $collectorContentDTO = new CollectorContentDTO();
        $collectorContentDTO->type = 'image';
        $collectorContentDTO->key = 'test key';
        $collectorContentDTO->value = 'test value';
        $collectorContentDTO->label = 'test label';

        $this->pageValueProviderMock->expects($this->once())->method('get')
            ->with($collectorContentDTO->type, $collectorContentDTO->key)
            ->willReturn($collectorContentDTO->value);

        $this->collectorMock->expects($this->once())->method('addContent')
            ->with($collectorContentDTO);

        self::assertEmpty($this->imageCollector->image($collectorContentDTO->key, new ImageConfigurationDTO(), $collectorContentDTO->label));
    }
}
