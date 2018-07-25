<?php

return [
    'magento2connector' => [
        'username'  => '',
        'password'  => '',
        'host'      => '',
        'mapping'   => [
            'product' => [
                'sku'               => 'sku',
                'name'              => 'name',
                'attribute_set_id'  => 4,
                'price'             => 'price',
                'status'            => 'status',
                'visibility'        => 'visibility',
                'weight'            => 'weight',
                'type'              => 'simple',
                'type_id'           => 'type_id',
                'custom_attributes' => [
                    ['attribute_code' => 'description', 'value' => 'description'],
                    ['attribute_code' => 'short_description', 'value' => 'short_description'],
                ]
            ],
            'category' => [
                'name'      => 'name',
                'parent_id' => 'categoryHelper.parentId',
                'is_active' => 'is_active',
                'position'  => 'categoryHelper.position',
                'level'     => 0,
                'children'  => 'children',
                'path'      => 'path',
                'available_sort_by'     => [

                ],
                'include_in_menu'       => 'include_in_menu',
                'extension_attributes'  => [

                ],
                'custom_attributes'     => [
                    ['attribute_code' => '', 'value' => ''],
                ],
            ]
        ]
    ]
];
