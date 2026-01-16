<?php
class Model_Categoria extends Zend_Db_Table_Abstract
{
    protected $_name = 'categorias';
    protected $_primary = 'id_categorias';

    public function findById($id)
    {
        return $this->find($id)->current();
    }

    public function findAll()
    {
        $select = $this->select()
            ->order('nome ASC');

        return $this->fetchAll($select)->toArray();
    }

    public function findWithActiveProducts($idLoja)
    {
        $select = $this->select()
            ->setIntegrityCheck(false)
            ->distinct()
            ->from(['c' => 'categorias'])
            ->join(['p' => 'produtos'], 'c.id_categorias = p.id_categorias', [])
            ->where('p.id_lojas = ?', $idLoja)
            ->where('p.status = ?', 'ativo')
            ->order('c.nome ASC');

        return $this->fetchAll($select)->toArray();
    }
}
