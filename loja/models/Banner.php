<?php
class Model_Banner extends Zend_Db_Table_Abstract
{
    protected $_name = 'banners';
    protected $_primary = 'id_banners';

    public function findAtivosByLoja($idLoja)
    {
        $select = $this->select()
            ->where('id_lojas = ?', $idLoja)
            ->where('status = ?', 'ativo')
            ->where('inicio_exibicao <= NOW()')
            ->where('fim_exibicao IS NULL OR fim_exibicao >= NOW()');

        return $this->fetchAll($select);
    }
}
