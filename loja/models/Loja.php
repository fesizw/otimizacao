<?php
class Model_Loja extends Zend_Db_Table_Abstract
{
    protected $_name = 'lojas';
    protected $_primary = 'id_lojas';

    public function findById($id)
    {
        return $this->find($id)->current();
    }

    public function findAll()
    {
        return $this->fetchAll()->toArray();
    }

    public function findByNome($nome)
    {
        $select = $this->select()
            ->where('nome = ?', $nome);

        return $this->fetchRow($select);
    }
}
