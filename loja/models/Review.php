<?php
class Model_Review extends Zend_Db_Table_Abstract
{
    protected $_name = 'reviews';
    protected $_primary = 'id_reviews';

    public function findByProductIds(array $productIds)
    {
        if (empty($productIds)) {
            return [];
        }

        $select = $this->select()
            ->setIntegrityCheck(false)
            ->from(['r' => 'reviews'])
            ->joinLeft(['c' => 'clientes'], 'r.id_clientes = c.id_clientes', ['cliente' => 'nome'])
            ->where('r.id_produtos IN (?)', $productIds);

        return $this->fetchAll($select)->toArray();
    }

    public function findByProductIdsGrouped(array $productIds)
    {
        $reviews = $this->findByProductIds($productIds);

        $grouped = [];
        foreach ($reviews as $review) {
            $pid = $review['id_produtos'];
            if (!isset($grouped[$pid])) {
                $grouped[$pid] = [];
            }
            $grouped[$pid][] = $review;
        }

        return $grouped;
    }
}
