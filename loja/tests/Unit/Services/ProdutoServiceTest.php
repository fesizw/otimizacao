<?php

namespace Tests\Unit\Services;

use PHPUnit\Framework\TestCase;

/**
 * Testes para Service_Produto
 */
class ProdutoServiceTest extends TestCase
{
    private $service;

    private $produtoModelMock;

    private $especificacaoModelMock;

    private $reviewModelMock;

    private $relacionadoModelMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->produtoModelMock = $this->createMock(\Model_Produto::class);
        $this->especificacaoModelMock = $this->createMock(\Model_ProdutoEspecificacao::class);
        $this->reviewModelMock = $this->createMock(\Model_Review::class);
        $this->relacionadoModelMock = $this->createMock(\Model_ProdutoRelacionado::class);
    }

    public function testFindAllByLojaWithDetailsReturnsEmptyArrayWhenNoProducts(): void
    {
        $this->produtoModelMock
            ->method('findActivosByLoja')
            ->willReturn([]);

        $service = $this->createServiceWithMocks();
        $result = $service->findAllByLojaWithDetails(1);

        $this->assertIsArray($result);
        $this->assertEmpty($result);
    }

    public function testFindAllByLojaWithDetailsReturnsProductsWithRelatedData(): void
    {
        $produtos = [
            ['id_produtos' => 1, 'nome' => 'Produto 1', 'categoria' => 'Cat1'],
            ['id_produtos' => 2, 'nome' => 'Produto 2', 'categoria' => 'Cat2'],
        ];

        $specs = [
            1 => ['Cor' => 'Azul'],
            2 => ['Tamanho' => 'G'],
        ];

        $reviews = [
            1 => [['id_reviews' => 1, 'nota' => 5, 'comentario' => 'Ótimo']],
        ];

        $relacionados = [
            2 => [['id_relacao' => 3, 'relacionado' => ['id_produtos' => 3, 'nome' => 'Prod 3']]],
        ];

        $this->produtoModelMock
            ->method('findActivosByLoja')
            ->willReturn($produtos);

        $this->especificacaoModelMock
            ->method('findByProductIdsGrouped')
            ->willReturn($specs);

        $this->reviewModelMock
            ->method('findByProductIdsGrouped')
            ->willReturn($reviews);

        $this->relacionadoModelMock
            ->method('findByProductIdsGrouped')
            ->willReturn($relacionados);

        $service = $this->createServiceWithMocks();
        $result = $service->findAllByLojaWithDetails(1);

        $this->assertCount(2, $result);
        $this->assertEquals(['Cor' => 'Azul'], $result[0]['specs']);
        $this->assertCount(1, $result[0]['reviews']);
        $this->assertEmpty($result[0]['relacionados']);
        $this->assertEquals(['Tamanho' => 'G'], $result[1]['specs']);
        $this->assertCount(1, $result[1]['relacionados']);
    }

    public function testFindByIdWithDetailsReturnsNullWhenProductNotFound(): void
    {
        $this->produtoModelMock
            ->method('findByIdWithCategoria')
            ->willReturn(null);

        $service = $this->createServiceWithMocks();
        $result = $service->findByIdWithDetails(999);

        $this->assertNull($result);
    }

    public function testFindByIdWithDetailsReturnsProductWithAllData(): void
    {
        $produto = [
            'id_produtos' => 1,
            'nome' => 'Produto Teste',
            'preco' => 99.99,
            'categoria' => 'Eletrônicos',
        ];

        $this->produtoModelMock
            ->method('findByIdWithCategoria')
            ->with(1)
            ->willReturn($produto);

        $this->especificacaoModelMock
            ->method('findByProductIdsGrouped')
            ->willReturn([1 => ['Voltagem' => '220V']]);

        $this->reviewModelMock
            ->method('findByProductIdsGrouped')
            ->willReturn([1 => [['nota' => 4]]]);

        $this->relacionadoModelMock
            ->method('findByProductIdsGrouped')
            ->willReturn([]);

        $service = $this->createServiceWithMocks();
        $result = $service->findByIdWithDetails(1);

        $this->assertNotNull($result);
        $this->assertEquals('Produto Teste', $result['nome']);
        $this->assertEquals(['Voltagem' => '220V'], $result['specs']);
        $this->assertCount(1, $result['reviews']);
        $this->assertEmpty($result['relacionados']);
    }

    /**
     * Cria o service com os mocks injetados via construtor
     */
    private function createServiceWithMocks(): \Service_Produto
    {
        return new \Service_Produto(
            $this->produtoModelMock,
            $this->especificacaoModelMock,
            $this->reviewModelMock,
            $this->relacionadoModelMock
        );
    }
}
