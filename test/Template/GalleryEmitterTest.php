<?php

namespace Sx\TemplateTest\Image\Template;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sx\Template\Image\ConfiguredImageRendererInterface;
use Sx\Template\Image\DTO\ImageConfigurationDTO;
use Sx\Template\Image\DTO\ImageDTO;
use Sx\Template\Image\DTO\ImagePropertyDTO;
use Sx\Template\Image\GalleryValueProviderInterface;
use Sx\Template\Image\ImageValueProviderInterface;
use Sx\Template\Image\Template\GalleryEmitter;
use Sx\Template\PageValueProviderInterface;

class GalleryEmitterTest extends TestCase
{
    private GalleryEmitter $galleryEmitter;

    private MockObject $pageValueProviderMock;

    private MockObject $galleryValueProviderMock;

    private MockObject $imageValueProviderMock;

    private MockObject $configuredImageRendererMock;

    protected function setUp(): void
    {
        $this->pageValueProviderMock = $this->createMock(PageValueProviderInterface::class);
        $this->galleryValueProviderMock = $this->createMock(GalleryValueProviderInterface::class);
        $this->imageValueProviderMock = $this->createMock(ImageValueProviderInterface::class);
        $this->configuredImageRendererMock = $this->createMock(ConfiguredImageRendererInterface::class);
        $this->galleryEmitter = new GalleryEmitter(
            $this->pageValueProviderMock,
            $this->galleryValueProviderMock,
            $this->imageValueProviderMock,
            $this->configuredImageRendererMock,
        );
    }

    public function testGallery(): void
    {
        $key = 'test key';
        $configuration = new ImageConfigurationDTO();
        $value = 'test value';
        $images = ['image key', 'image key'];
        $properties = new ImagePropertyDTO();
        $image = new ImageDTO();

        $this->pageValueProviderMock->expects($this->once())->method('get')
            ->with('gallery', $key)
            ->willReturn($value);
        $this->galleryValueProviderMock->expects($this->once())->method('get')
            ->with($value)
            ->willReturn($images);
        $this->imageValueProviderMock->expects($this->exactly(2))->method('get')
            ->with('image key')
            ->willReturn($properties);
        $this->configuredImageRendererMock->expects($this->exactly(2))->method('render')
            ->with($properties, $configuration)
            ->willReturn($image);

        self::assertEquals([$image, $image], $this->galleryEmitter->gallery($key, $configuration));
    }

    public function testGalleryValueNotFound(): void
    {
        $key = 'test key';

        $this->pageValueProviderMock->expects($this->once())->method('get')
            ->with('gallery', $key)
            ->willReturn(null);

        self::assertEquals([], $this->galleryEmitter->gallery($key, new ImageConfigurationDTO()));
    }

    public function testGalleryNotFound(): void
    {
        $key = 'test key';
        $value = 'test value';

        $this->pageValueProviderMock->expects($this->once())->method('get')
            ->with('gallery', $key)
            ->willReturn($value);
        $this->galleryValueProviderMock->expects($this->once())->method('get')
            ->with($value)
            ->willReturn([]);

        self::assertEquals([], $this->galleryEmitter->gallery($key,  new ImageConfigurationDTO()));
    }

    public function testGalleryImageNotFound(): void
    {
        $key = 'test key';
        $value = 'test value';
        $images = ['image key', 'image key'];

        $this->pageValueProviderMock->expects($this->once())->method('get')
            ->with('gallery', $key)
            ->willReturn($value);
        $this->galleryValueProviderMock->expects($this->once())->method('get')
            ->with($value)
            ->willReturn($images);
        $this->imageValueProviderMock->expects($this->exactly(2))->method('get')
            ->with('image key')
            ->willReturn(null);

        self::assertEquals([], $this->galleryEmitter->gallery($key, new ImageConfigurationDTO()));
    }

    public function testGalleryRenderFailed(): void
    {
        $key = 'test key';
        $configuration = new ImageConfigurationDTO();
        $value = 'test value';
        $images = ['image key', 'image key'];
        $properties = new ImagePropertyDTO();

        $this->pageValueProviderMock->expects($this->once())->method('get')
            ->with('gallery', $key)
            ->willReturn($value);
        $this->galleryValueProviderMock->expects($this->once())->method('get')
            ->with($value)
            ->willReturn($images);
        $this->imageValueProviderMock->expects($this->exactly(2))->method('get')
            ->with('image key')
            ->willReturn($properties);
        $this->configuredImageRendererMock->expects($this->exactly(2))->method('render')
            ->with($properties, $configuration)
            ->willReturn(null);

        self::assertEquals([], $this->galleryEmitter->gallery($key, $configuration));
    }
}
