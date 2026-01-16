<?php

namespace Loja\Http;

trait AjaxTrait
{
//    abstract public function getResponse(): \Zend_Controller_Response_Abstract;

    /**
     * @throws \Zend_Controller_Response_Exception
     */
    public function sendJson($data, $code = 200, $charset = "utf-8") {
        $this->getResponse()
            ->setHttpResponseCode($code)
            ->setHeader("Content-Type", "application/json;charset=" . $charset)
            ->setBody(\Zend_Json_Encoder::encode($data));
    }
}