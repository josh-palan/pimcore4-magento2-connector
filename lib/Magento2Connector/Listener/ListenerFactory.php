<?php
/**
 * @category    Magento2Connector
 * @date        14/06/2017 09:25
 * @author      Kamil Wręczycki <kwreczycki@divante.pl>
 * @author      Bartosz Idzikowski <bidzikowski@divante.pl>
 * @copyright   2017 Divante Ltd. (https://divante.co)
 */

namespace Magento2Connector\Listener;

use Magento2Connector\Swagger\ApiFactory;
use Pimcore\Model\DataObject\AbstractObject;
use Pimcore\Model\DataObject\Category;
use Pimcore\Model\DataObject\MagentoBaseProduct as Product;

/**
 * @class ListenerFactory
 * @package  Magento2Connector\Listener
 */
class ListenerFactory
{
    /**
     * @param AbstractObject $abstractObject
     * @return CrudListenerInterface
     * @throws \DI\DependencyException
     * @throws \DI\NotFoundException
     */
    public static function getListener(AbstractObject $abstractObject)
    {
        $apiFactory = new ApiFactory();
        $diContainer = \Pimcore::getDiContainer();
        switch ($abstractObject) {
            case $abstractObject instanceof Product:
                $catalogRepositoryClass = $apiFactory->get('CatalogProductRepositoryV1Api');
                return new ProductCrudListener(
                    $catalogRepositoryClass,
                    $diContainer->get('magento2.event_manager'),
                    $diContainer->get('magento2.product.request.body.builder')
                );
                break;

                // TODO: Are we doing category management? Need to look at request body more on this one...
            case $abstractObject instanceof Category:
                $categoryRepositoryClass = $apiFactory->get('CatalogCategoryRepositoryV1Api');
                return new CategoryCrudListener(
                    $categoryRepositoryClass,
                    $diContainer->get('magento2.event_manager'),
                    $diContainer->get('magento2.category.request.body.builder')
                );
                break;
            default:
                return null;
        }
    }
}
