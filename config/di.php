<?php
/**
 * @category    Magento2Connector
 * @date        7/25/18 9:55
 * @author      Joshua Palan
 *
 * UPDATED 7/25/18 by Joshua Palan
 */

try {
    $ConfigService  = new \Magento2Connector\Config\ConfigService();
    $userName       = $ConfigService->get('username');
    $password       = $ConfigService->get('password');
    $host           = $ConfigService->get('host');
    $mapping        = $ConfigService->get('mapping');
} catch (Exception $e) {
}

return [
    'magento2.db.api.logger' => DI\factory([\Pimcore\Log\ApplicationLogger::class, 'getDbLogger'])
        ->parameter('component', 'api_logger')
        ->scope(\DI\Scope::PROTOTYPE),
    'magento2.event_manager' => DI\factory([\Pimcore::class, 'getEventManager']),
    'magento2.api.client.configuration' => DI\object(\Swagger\Magento2Client\Configuration::class)
        ->method(
            'setUsername',
            $userName
        )
        ->method(
            'setPassword',
            $password
        )
        ->method(
            'setHost',
            $host
        ),

    'magento2.api.client'                    => DI\object(\Swagger\Magento2Client\ApiClient::class)
        ->constructor(
            DI\get('magento2.api.client.configuration')
        ),
    'magento2.swagger.token.service'         => DI\object(\Swagger\Magento2Client\Api\IntegrationAdminTokenServiceV1Api::class)
        ->constructor(
            DI\get('magento2.api.client')
        ),
    'magento2.token.provider'                => DI\object(\Magento2Connector\Swagger\TokenProvider::class)
        ->constructor(
            DI\get('magento2.swagger.token.service'),
            $userName,
            $password
        ),
    'magento2.product.mapper'                => DI\object(\Magento2Connector\Mapper\ProductMapper::class),
    'magento2.category.mapper'               => DI\object(\Magento2Connector\Mapper\CategoryMapper::class),
    'magento2.product.request.body.builder'  => DI\object(\Magento2Connector\Swagger\RequestBodyBuilder\ProductRequestBodyBuilder::class)
        ->constructor(
            DI\get('magento2.product.mapper')
        ),
    'magento2.category.request.body.builder' => DI\object(\Magento2Connector\Swagger\RequestBodyBuilder\CategoryRequestBodyBuilder::class)
        ->constructor(
            DI\get('magento2.category.mapper')
        )
];
