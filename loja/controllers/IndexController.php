<?php
require_once 'lib/Http/BaseController.php';

use Loja\Http\AjaxTrait;

class IndexController extends BaseController
{
    use AjaxTrait;

    /**
     * @var Zend_Db_Adapter_Abstract
     */
    protected $db;

    protected $loja;

    public function init()
    {
        parent::init();
        $this->db = \Zend_Registry::get('db');
        $this->loja = \Zend_Registry::get('loja');
    }

    public function indexAction()
    {
        $this->view->banners = $this->db->fetchAll("SELECT * FROM banners WHERE id_lojas = ? AND status = 'ativo' AND inicio_exibicao <= NOW() AND (fim_exibicao IS NULL OR fim_exibicao >= NOW())", [$this->loja->id_lojas], Zend_Db::FETCH_OBJ);

        $this->render("index");
    }

    public function productsAction()
    {
        $produtos = $this->db->fetchAll("SELECT p.*, c.nome as categoria FROM produtos p INNER JOIN categorias c USING(id_categorias) WHERE id_lojas = ? AND status = 'ativo'", [$this->loja->id_lojas], Zend_Db::FETCH_ASSOC);
        foreach ($produtos as $index => $produto) {
            $specList = $this->db->fetchAll("SELECT * FROM produtos_especificacao WHERE id_produtos = ?", [(int)$produto['id_produtos']], Zend_Db::FETCH_ASSOC);
            $specDict = [];
            foreach ($specList as $spec) {
                $specDict[$spec['titulo']] = $spec['valor'];
            }

            $produtos[$index]['specs'] = $specDict;

            $reviews = $this->db->fetchAll("SELECT * FROM reviews WHERE id_produtos = ?", [(int)$produto['id_produtos']], Zend_Db::FETCH_ASSOC);
            foreach ($reviews as $reviewIndex => $review) {
                $reviews[$reviewIndex]['cliente'] = $this->db->fetchCol("SELECT nome FROM clientes WHERE id_clientes = ?", [(int)$review['id_cliente']]);
            }

            $produtos[$index]['reviews'] = $reviews;

            $relacionados = $this->db->fetchAll("SELECT * FROM produtos_relacionados WHERE id_produtos = ?", [(int)$produto['id_produtos']], Zend_Db::FETCH_ASSOC);
            foreach ($relacionados as $relacionadoIndex => $relacionado) {
                $relacionados[$relacionadoIndex]['relacionado'] = $this->db->fetchRow("SELECT * FROM produtos WHERE id_produtos = ?", [(int)$relacionado['id_relacao']]);
            }

            $produtos[$index]['relacionados'] = $relacionados;
        }

        $this->sendJson($produtos);
    }

    public function detalhesAction()
    {
        $this->view->id = $this->getParam("id");
        $this->render();
    }
}