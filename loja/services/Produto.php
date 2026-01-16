<?php
class Service_Produto
{
    private $produtoModel;
    private $especificacaoModel;
    private $reviewModel;
    private $relacionadoModel;

    /**
     * @param Model_Produto|null $produtoModel
     * @param Model_ProdutoEspecificacao|null $especificacaoModel
     * @param Model_Review|null $reviewModel
     * @param Model_ProdutoRelacionado|null $relacionadoModel
     */
    public function __construct(
        $produtoModel = null,
        $especificacaoModel = null,
        $reviewModel = null,
        $relacionadoModel = null
    ) {
        $this->produtoModel = $produtoModel ?: new Model_Produto();
        $this->especificacaoModel = $especificacaoModel ?: new Model_ProdutoEspecificacao();
        $this->reviewModel = $reviewModel ?: new Model_Review();
        $this->relacionadoModel = $relacionadoModel ?: new Model_ProdutoRelacionado();
    }

    public function findAllByLojaWithDetails($idLoja)
    {
        $produtos = $this->produtoModel->findActivosByLoja($idLoja);

        if (empty($produtos)) {
            return [];
        }

        $productIds = array_column($produtos, 'id_produtos');

        $specsByProduct = $this->especificacaoModel->findByProductIdsGrouped($productIds);
        $reviewsByProduct = $this->reviewModel->findByProductIdsGrouped($productIds);
        $relacionadosByProduct = $this->relacionadoModel->findByProductIdsGrouped($productIds);

        foreach ($produtos as $index => $produto) {
            $pid = $produto['id_produtos'];
            $produtos[$index]['specs'] = $specsByProduct[$pid] ?? [];
            $produtos[$index]['reviews'] = $reviewsByProduct[$pid] ?? [];
            $produtos[$index]['relacionados'] = $relacionadosByProduct[$pid] ?? [];
        }

        return $produtos;
    }

    public function findByIdWithDetails($id)
    {
        $produto = $this->produtoModel->findByIdWithCategoria($id);

        if (!$produto) {
            return null;
        }

        $produto['specs'] = $this->especificacaoModel->findByProductIdsGrouped([$id])[$id] ?? [];
        $produto['reviews'] = $this->reviewModel->findByProductIdsGrouped([$id])[$id] ?? [];
        $produto['relacionados'] = $this->relacionadoModel->findByProductIdsGrouped([$id])[$id] ?? [];

        return $produto;
    }
}
