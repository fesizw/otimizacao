<?php
require_once dirname(__DIR__) . '/lib/Http/BaseController.php';
require_once dirname(__DIR__) . '/autoload.php';

use Loja\Http\AjaxTrait;

class IndexController extends BaseController
{
    use AjaxTrait;

    protected $produtoService;

    protected $bannerService;

    protected $loja;

    public function init()
    {
        parent::init();
        $this->loja = \Zend_Registry::get('loja');
        $this->produtoService = new Service_Produto();
        $this->bannerService = new Service_Banner();
    }

    public function indexAction()
    {
        $this->view->banners = $this->bannerService->findAtivosByLoja($this->loja->id_lojas);
        $this->render("index");
    }

    public function productsAction()
    {
        $produtos = $this->produtoService->findAllByLojaWithDetails($this->loja->id_lojas);
        $this->sendJson($produtos);
    }

    public function productAction()
    {
        $id = $this->getParam("id");

        if (!$id) {
            $this->sendJson(['error' => 'ID do produto é obrigatório'], 400);
            return;
        }

        $produto = $this->produtoService->findByIdWithDetails($id);

        if (!$produto) {
            $this->sendJson(['error' => 'Produto não encontrado'], 404);
            return;
        }

        $this->sendJson($produto);
    }

    public function detalhesAction()
    {
        $this->view->id = $this->getParam("id");
        $this->render();
    }
}
