<?php

namespace Sx\TemplateTest\Image\DTO;

use Sx\Template\Image\DTO\ImageDataDTO;
use Sx\Template\Image\DTO\ImageDTO;
use PHPUnit\Framework\TestCase;
use Sx\Template\Image\DTO\ImagePropertyDTO;

class ImageDTOTest extends TestCase
{
    public function testToString(): void
    {
        $imageDTO = new ImageDTO();
        $imageDTO->image = new ImageDataDTO();
        $imageDTO->image->url = '/url';
        $imageDTO->image->width = 10;
        $imageDTO->image->height = 20;
        $imageDTO->properties = new ImagePropertyDTO();
        self::assertEquals(
            '<img src="/url" width="10" height="20" alt="" title=""/>',
            (string) $imageDTO
        );
    }

    public function testToStringExtended(): void
    {
        $imageDTO = new ImageDTO();
        $imageDTO->thumbnail = new ImageDataDTO();
        $imageDTO->thumbnail->url = '/url';
        $imageDTO->thumbnail->width = 10;
        $imageDTO->thumbnail->height = 20;
        $imageDTO->properties = new ImagePropertyDTO();
        $imageDTO->properties->alt = '&';
        $imageDTO->properties->title = '"';
        self::assertEquals(
            '<img src="/url" width="10" height="20" alt="&amp;" title="&quot;"/>',
            (string) $imageDTO
        );
    }
}
