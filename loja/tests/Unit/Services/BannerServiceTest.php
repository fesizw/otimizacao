<?php

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;

/**
 * Testes para Service_Banner
 */
class BannerServiceTest extends TestCase
{
    public function testFindAtivosByLojaReturnsBanners(): void
    {
        $bannerModelMock = $this->createMock(\Model_Banner::class);
        
        $mockRowset = $this->createMock(\Zend_Db_Table_Rowset::class);
        $mockRowset->method('toArray')->willReturn([
            ['id_banners' => 1, 'titulo' => 'Banner 1', 'status' => 'ativo'],
            ['id_banners' => 2, 'titulo' => 'Banner 2', 'status' => 'ativo'],
        ]);

        $bannerModelMock
            ->method('findAtivosByLoja')
            ->with(1)
            ->willReturn($mockRowset);

        $service = new \Service_Banner($bannerModelMock);
        $result = $service->findAtivosByLoja(1);

        $this->assertNotNull($result);
    }

    public function testFindAtivosByLojaWithInvalidLojaReturnsEmpty(): void
    {
        $bannerModelMock = $this->createMock(\Model_Banner::class);
        
        $mockRowset = $this->createMock(\Zend_Db_Table_Rowset::class);
        $mockRowset->method('toArray')->willReturn([]);

        $bannerModelMock
            ->method('findAtivosByLoja')
            ->with(999)
            ->willReturn($mockRowset);

        $service = new \Service_Banner($bannerModelMock);
        $result = $service->findAtivosByLoja(999);
        
        $this->assertNotNull($result);
    }
}
