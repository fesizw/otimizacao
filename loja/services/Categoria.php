<?php
/**
 * Service para operações de categorias
 */
class Service_Categoria
{
    private $categoriaModel;

    /**
     * @param Model_Categoria|null $categoriaModel
     */
    public function __construct($categoriaModel = null)
    {
        $this->categoriaModel = $categoriaModel ?: new Model_Categoria();
    }

    public function findAll()
    {
        return $this->categoriaModel->findAll();
    }

    public function findWithActiveProducts($idLoja)
    {
        return $this->categoriaModel->findWithActiveProducts($idLoja);
    }

    public function findById($id)
    {
        return $this->categoriaModel->findById($id);
    }
}
