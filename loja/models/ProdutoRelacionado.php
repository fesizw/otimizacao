<?php
class Model_ProdutoRelacionado extends Zend_Db_Table_Abstract
{
    protected $_name = 'produtos_relacionados';
    protected $_primary = 'id_produtos_relacionados';

    public function findByProductIds(array $productIds)
    {
        if (empty($productIds)) {
            return [];
        }

        $select = $this->select()
            ->setIntegrityCheck(false)
            ->from(['pr' => 'produtos_relacionados'], ['id_produtos', 'id_relacao'])
            ->join(
                ['p' => 'produtos'],
                'pr.id_relacao = p.id_produtos',
                ['rel_id' => 'id_produtos', 'nome', 'preco', 'imagem']
            )
            ->where('pr.id_produtos IN (?)', $productIds);

        return $this->fetchAll($select)->toArray();
    }

    public function findByProductIdsGrouped(array $productIds)
    {
        $relacionados = $this->findByProductIds($productIds);

        $grouped = [];
        foreach ($relacionados as $rel) {
            $pid = $rel['id_produtos'];
            if (!isset($grouped[$pid])) {
                $grouped[$pid] = [];
            }
            $grouped[$pid][] = [
                'id_relacao' => $rel['id_relacao'],
                'relacionado' => [
                    'id_produtos' => $rel['rel_id'],
                    'nome' => $rel['nome'],
                    'preco' => $rel['preco'],
                    'imagem' => $rel['imagem']
                ]
            ];
        }

        return $grouped;
    }
}
