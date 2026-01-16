<?php
class BaseController extends Zend_Controller_Action {
    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        Zend_Registry::set('objRequest', $request);

        parent::__construct($request, $response, $invokeArgs);

        if ($this->view === null) {
            $this->view = new Zend_View();
            $this->view->addScriptPath(VIEWS_DIR);
            $this->view->addHelperPath(HELPER_DIR, 'Portal');
        }

        $this->init();
    }

    public function render($action = null, $name = null, $noController = false)
    {
        $this->getResponse()->prepend('topo', $this->view->render('topo.phtml'));

        parent::render($action, $name, $noController);

        $this->getResponse()->append('rodape', $this->view->render('rodape.phtml'));
    }
}