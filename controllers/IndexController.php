<?php
/**
 * Created by PhpStorm.
 * User: joshpalan
 * Date: 7/25/18
 * Time: 12:15 PM
 */

class Magento2Connector_IndexController extends \Pimcore\Controller\Action\Admin
{
    public function indexAction()
    {
        $ConfigService  = new \Magento2Connector\Config\ConfigService();
        $mapping = $ConfigService->get('mapping');

        $view = $this->view;
        $view->mapping = $mapping;
    }
}