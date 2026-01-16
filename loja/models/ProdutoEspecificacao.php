<?php
class Model_ProdutoEspecificacao extends Zend_Db_Table_Abstract
{
    protected $_name = 'produtos_especificacao';
    protected $_primary = 'id_produtos_especificacao';

    public function findByProductIds(array $productIds)
    {
        if (empty($productIds)) {
            return [];
        }

        $select = $this->select()
            ->from($this->_name, ['id_produtos', 'titulo', 'valor'])
            ->where('id_produtos IN (?)', $productIds);

        return $this->fetchAll($select)->toArray();
    }

    public function findByProductIdsGrouped(array $productIds)
    {
        $specs = $this->findByProductIds($productIds);

        $grouped = [];
        foreach ($specs as $spec) {
            $pid = $spec['id_produtos'];
            if (!isset($grouped[$pid])) {
                $grouped[$pid] = [];
            }
            $grouped[$pid][$spec['titulo']] = $spec['valor'];
        }

        return $grouped;
    }
}
