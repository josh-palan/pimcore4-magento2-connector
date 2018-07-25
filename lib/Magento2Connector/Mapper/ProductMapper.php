<?php
/**
 * @category    Magento2Connector
 * @date        14/06/2017 09:25
 * @author      Kamil Wręczycki <kwreczycki@divante.pl>
 * @author      Bartosz Idzikowski <bidzikowski@divante.pl>
 * @copyright   2017 Divante Ltd. (https://divante.co)
 */

namespace Magento2Connector\Mapper;

use Pimcore\Model\DataObject\AbstractObject;
use Pimcore\Model\DataObject\MagentoBaseProduct as Product;
use Swagger\Magento2Client\Model\CatalogDataProductInterface;

/**
 * @class ProductMapper
 * @package  Magento2Connector\Mapper
 */
class ProductMapper implements MapperInterface
{
    /**
     * @param AbstractObject $product
     * @return CatalogDataProductInterface
     */
    public function mapToObject(AbstractObject $product)
    {
        return new CatalogDataProductInterface($this->toArray($product));
    }

    /**
     * @param AbstractObject $product
     * @return array
     */
    public function toArray(AbstractObject $product)
    {
        $ConfigService  = new \Magento2Connector\Config\ConfigService();

        $mapping = $ConfigService->get('mapping');

        /**@var Product $product */
        return $this->getBasedOnConfigRecusively($mapping, $product)['product'];
    }

    private function getBasedOnConfigRecusively($mapping, $product)
    {
        $interfaceArray = [];

        foreach ($mapping as $property => $attribute) {
            if (is_object($attribute)) {
                $interfaceArray[$property] = $this->getBasedOnConfigRecusively($attribute, $product);
            } else {
                $method = 'get' . ucfirst($attribute);
                if (method_exists($product, $method)) {
                    $interfaceArray[$property] = $product->$method();
                } else {
                    // TODO: Do we want to throw exceptions here? Maybe just log instead?
                }
            }
        }

        return $interfaceArray;
    }

    /**
     * @param Product $product
     * @return array
     */
    private function getCategoryIds(Product $product)
    {
        $categories = [];

        foreach ($product->getCategories() as $category) {
            if (!$category->getMagentoId()) {
                continue;
            }

            $categories[] = $category->getMagentoId();
        }

        return $categories;
    }
}
