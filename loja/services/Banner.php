<?php
class Service_Banner
{
    private $bannerModel;

    /**
     * @param Model_Banner|null $bannerModel
     */
    public function __construct($bannerModel = null)
    {
        $this->bannerModel = $bannerModel ?: new Model_Banner();
    }

    public function findAtivosByLoja($idLoja)
    {
        return $this->bannerModel->findAtivosByLoja($idLoja);
    }
}
