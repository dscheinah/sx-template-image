<?php

namespace Sx\TemplateTest\Image\Template;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sx\Template\Image\ConfiguredImageRendererInterface;
use Sx\Template\Image\DTO\ImageConfigurationDTO;
use Sx\Template\Image\DTO\ImageDTO;
use Sx\Template\Image\DTO\ImagePropertyDTO;
use Sx\Template\Image\ImageValueProviderInterface;
use Sx\Template\Image\Template\ImageEmitter;
use Sx\Template\PageValueProviderInterface;

class ImageEmitterTest extends TestCase
{
    private ImageEmitter $imageEmitter;

    private MockObject $pageValueProviderMock;

    private MockObject $imageValueProviderMock;

    private MockObject $configuredImageRendererMock;

    protected function setUp(): void
    {
        $this->pageValueProviderMock = $this->createMock(PageValueProviderInterface::class);
        $this->imageValueProviderMock = $this->createMock(ImageValueProviderInterface::class);
        $this->configuredImageRendererMock = $this->createMock(ConfiguredImageRendererInterface::class);
        $this->imageEmitter = new ImageEmitter(
            $this->pageValueProviderMock,
            $this->imageValueProviderMock,
            $this->configuredImageRendererMock,
        );
    }

    public function testImage(): void
    {
        $key = 'test key';
        $configuration = new ImageConfigurationDTO();
        $value = 'test value';
        $properties = new ImagePropertyDTO();
        $image = new ImageDTO();

        $this->pageValueProviderMock->expects($this->once())->method('get')
            ->with('image', $key)
            ->willReturn($value);
        $this->imageValueProviderMock->expects($this->once())->method('get')
            ->with($value)
            ->willReturn($properties);
        $this->configuredImageRendererMock->expects($this->once())->method('render')
            ->with($properties, $configuration)
            ->willReturn($image);

        self::assertSame($image, $this->imageEmitter->image($key, $configuration));
    }

    public function testImageValueNotFound(): void
    {
        $key = 'test key';

        $this->pageValueProviderMock->expects($this->once())->method('get')
            ->with('image', $key)
            ->willReturn(null);

        self::assertNull($this->imageEmitter->image($key, new ImageConfigurationDTO()));
    }

    public function testImageNotFound(): void
    {
        $key = 'test key';
        $value = 'test value';

        $this->pageValueProviderMock->expects($this->once())->method('get')
            ->with('image', $key)
            ->willReturn($value);
        $this->imageValueProviderMock->expects($this->once())->method('get')
            ->with($value)
            ->willReturn(null);

        self::assertNull($this->imageEmitter->image($key, new ImageConfigurationDTO()));
    }

    public function testImageRenderFailed(): void
    {
        $key = 'test key';
        $configuration = new ImageConfigurationDTO();
        $value = 'test value';
        $properties = new ImagePropertyDTO();

        $this->pageValueProviderMock->expects($this->once())->method('get')
            ->with('image', $key)
            ->willReturn($value);
        $this->imageValueProviderMock->expects($this->once())->method('get')
            ->with($value)
            ->willReturn($properties);
        $this->configuredImageRendererMock->expects($this->once())->method('render')
            ->with($properties, $configuration)
            ->willReturn(null);

        self::assertNull($this->imageEmitter->image($key, $configuration));
    }
}
