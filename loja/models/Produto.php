<?php
class Model_Produto extends Zend_Db_Table_Abstract
{
    protected $_name = 'produtos';
    protected $_primary = 'id_produtos';

    public function findActivosByLoja($idLoja)
    {
        $select = $this->select()
            ->setIntegrityCheck(false)
            ->from(['p' => 'produtos'])
            ->join(['c' => 'categorias'], 'p.id_categorias = c.id_categorias', ['categoria' => 'nome'])
            ->where('p.id_lojas = ?', $idLoja)
            ->where('p.status = ?', 'ativo');

        return $this->fetchAll($select)->toArray();
    }

    public function findById($id)
    {
        return $this->find($id)->current();
    }

    public function findByIdWithCategoria($id)
    {
        $select = $this->select()
            ->setIntegrityCheck(false)
            ->from(['p' => 'produtos'])
            ->join(['c' => 'categorias'], 'p.id_categorias = c.id_categorias', ['categoria' => 'nome'])
            ->where('p.id_produtos = ?', $id);

        $row = $this->fetchRow($select);
        return $row ? $row->toArray() : null;
    }
}
