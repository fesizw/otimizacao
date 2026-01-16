<?php

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;

/**
 * Testes para Service_Categoria
 */
class CategoriaServiceTest extends TestCase
{
    public function testFindAllReturnsCategories(): void
    {
        $categoriaModelMock = $this->createMock(\Model_Categoria::class);
        
        $categoriaModelMock
            ->method('findAll')
            ->willReturn([
                ['id_categorias' => 1, 'nome' => 'Eletrônicos'],
                ['id_categorias' => 2, 'nome' => 'Roupas'],
            ]);

        $service = new \Service_Categoria($categoriaModelMock);
        $result = $service->findAll();

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        $this->assertEquals('Eletrônicos', $result[0]['nome']);
    }

    public function testFindWithActiveProductsReturnsOnlyActiveCategories(): void
    {
        $categoriaModelMock = $this->createMock(\Model_Categoria::class);
        
        $categoriaModelMock
            ->method('findWithActiveProducts')
            ->with(1)
            ->willReturn([
                ['id_categorias' => 1, 'nome' => 'Categoria Ativa'],
            ]);

        $service = new \Service_Categoria($categoriaModelMock);
        $result = $service->findWithActiveProducts(1);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
    }

    public function testFindByIdReturnsCategory(): void
    {
        $categoriaModelMock = $this->createMock(\Model_Categoria::class);
        
        $mockRow = $this->createMock(\Zend_Db_Table_Row::class);
        $mockRow->method('toArray')->willReturn([
            'id_categorias' => 5,
            'nome' => 'Categoria Específica',
        ]);

        $categoriaModelMock
            ->method('findById')
            ->with(5)
            ->willReturn($mockRow);

        $service = new \Service_Categoria($categoriaModelMock);
        $result = $service->findById(5);

        $this->assertNotNull($result);
    }

    public function testFindByIdReturnsNullWhenNotFound(): void
    {
        $categoriaModelMock = $this->createMock(\Model_Categoria::class);
        
        $categoriaModelMock
            ->method('findById')
            ->with(999)
            ->willReturn(null);

        $service = new \Service_Categoria($categoriaModelMock);
        $result = $service->findById(999);

        $this->assertNull($result);
    }
}
