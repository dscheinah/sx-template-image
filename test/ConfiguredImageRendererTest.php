<?php

namespace Sx\TemplateTest\Image;

use PHPUnit\Framework\MockObject\MockObject;
use Sx\Image\DTO\RenderedImageDTO;
use Sx\Image\ImageRenderer;
use Sx\Template\Image\ConfiguredImageRenderer;
use PHPUnit\Framework\TestCase;
use Sx\Template\Image\DTO\ImageConfigurationDTO;
use Sx\Template\Image\DTO\ImageDataDTO;
use Sx\Template\Image\DTO\ImageDTO;
use Sx\Template\Image\DTO\ImagePropertyDTO;

class ConfiguredImageRendererTest extends TestCase
{
    private const DIRECTORY = '/target/directory/';

    private const PREFIX = '/target/prefix/';

    private ConfiguredImageRenderer $configuredImageRenderer;

    private MockObject $imageRendererMock;

    protected function setUp(): void
    {
        $this->imageRendererMock = $this->createMock(ImageRenderer::class);
        $this->configuredImageRenderer = new ConfiguredImageRenderer(
            $this->imageRendererMock,
            self::DIRECTORY . '/',
            self::PREFIX . '/',
        );
    }

    public function testRender(): void
    {
        $properties = new ImagePropertyDTO();
        $properties->source = '/source';
        $properties->name = 'image-name';

        $configuration = new ImageConfigurationDTO();
        $configuration->width = 10;
        $configuration->height = 20;

        $renderedImage = new RenderedImageDTO();
        $renderedImage->base64 = 'base64';
        $renderedImage->width = 30;
        $renderedImage->height = 40;

        $this->imageRendererMock->expects($this->once())->method('readFromJpeg')
            ->with(self::DIRECTORY . 'image-name-10x20.jpg', 10, 20)
            ->willReturn(null);
        $this->imageRendererMock->expects($this->once())->method('renderToJpeg')
            ->with('/source', self::DIRECTORY . 'image-name-10x20.jpg', 10, 20)
            ->willReturn($renderedImage);

        $image = $this->configuredImageRenderer->render($properties, $configuration);

        $expected = new ImageDTO();
        $expected->image = new ImageDataDTO();
        $expected->image->path = self::DIRECTORY . 'image-name-10x20.jpg';
        $expected->image->url = self::PREFIX . 'image-name-10x20.jpg';
        $expected->image->base64 = 'base64';
        $expected->image->width = 30;
        $expected->image->height = 40;
        $expected->properties = $properties;

        self::assertEquals($expected, $image);
    }

    public function testRenderWithThumbnail(): void
    {
        $properties = new ImagePropertyDTO();
        $properties->source = '/source';
        $properties->name = 'image-name';

        $configuration = new ImageConfigurationDTO();
        $configuration->use_thumbnail = true;
        $configuration->thumbnail_width = 10;
        $configuration->thumbnail_height = 20;

        $renderedImage = new RenderedImageDTO();
        $renderedImage->base64 = 'base64';
        $renderedImage->width = 30;
        $renderedImage->height = 40;

        $this->imageRendererMock->method('readFromJpeg')
            ->willReturn(null);
        $this->imageRendererMock->method('renderToJpeg')
            ->willReturn($renderedImage);

        $image = $this->configuredImageRenderer->render($properties, $configuration);

        $expected = new ImageDataDTO();
        $expected->path = self::DIRECTORY . 'image-name-10x20.jpg';
        $expected->url = self::PREFIX . 'image-name-10x20.jpg';
        $expected->base64 = 'base64';
        $expected->width = 30;
        $expected->height = 40;

        self::assertEquals($expected, $image->thumbnail);
    }

    public function testRenderWithoutName(): void
    {
        $properties = new ImagePropertyDTO();
        $properties->source = '/path/to/source.png';

        $configuration = new ImageConfigurationDTO();

        $renderedImage = new RenderedImageDTO();
        $renderedImage->base64 = 'base64';
        $renderedImage->width = 30;
        $renderedImage->height = 40;

        $this->imageRendererMock->expects($this->once())->method('readFromJpeg')
            ->with(self::DIRECTORY . 'source-0x0.jpg', null, null)
            ->willReturn(null);
        $this->imageRendererMock->expects($this->once())->method('renderToJpeg')
            ->with('/path/to/source.png', self::DIRECTORY . 'source-0x0.jpg', null, null)
            ->willReturn($renderedImage);

        $image = $this->configuredImageRenderer->render($properties, $configuration);

        $expected = new ImageDataDTO();
        $expected->path = self::DIRECTORY . 'source-0x0.jpg';
        $expected->url = self::PREFIX . 'source-0x0.jpg';
        $expected->base64 = 'base64';
        $expected->width = 30;
        $expected->height = 40;

        self::assertEquals($expected, $image->image);
    }

    public function testRenderFileExists(): void
    {
        $properties = new ImagePropertyDTO();
        $properties->source = '/source';
        $properties->name = 'image-name';

        $configuration = new ImageConfigurationDTO();

        $renderedImage = new RenderedImageDTO();
        $renderedImage->base64 = 'base64';
        $renderedImage->width = 30;
        $renderedImage->height = 40;

        $this->imageRendererMock->expects($this->once())->method('readFromJpeg')
            ->with(self::DIRECTORY . 'image-name-0x0.jpg', null, null)
            ->willReturn($renderedImage);
        $this->imageRendererMock->expects($this->never())->method('renderToJpeg');

        $image = $this->configuredImageRenderer->render($properties, $configuration);

        $expected = new ImageDataDTO();
        $expected->path = self::DIRECTORY . 'image-name-0x0.jpg';
        $expected->url = self::PREFIX . 'image-name-0x0.jpg';
        $expected->base64 = 'base64';
        $expected->width = 30;
        $expected->height = 40;

        self::assertEquals($expected, $image->image);
    }

    public function testRenderNoImage(): void
    {
        $properties = new ImagePropertyDTO();
        $properties->source = '/source';

        $configuration = new ImageConfigurationDTO();

        $this->imageRendererMock->method('readFromJpeg')
            ->willReturn(null);
        $this->imageRendererMock->method('renderToJpeg')
            ->willReturn(null);

        self::assertNull($this->configuredImageRenderer->render($properties, $configuration));
    }
}
