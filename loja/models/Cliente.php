<?php
class Model_Cliente extends Zend_Db_Table_Abstract
{
    protected $_name = 'clientes';
    protected $_primary = 'id_clientes';

    public function findById($id)
    {
        return $this->find($id)->current();
    }

    public function findByIds(array $ids)
    {
        if (empty($ids)) {
            return [];
        }

        $select = $this->select()
            ->where('id_clientes IN (?)', $ids);

        return $this->fetchAll($select)->toArray();
    }

    public function findAll()
    {
        return $this->fetchAll()->toArray();
    }
}
