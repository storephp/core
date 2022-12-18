<?php

use App\Models\Product;

return [
    'product_relation' => [
        'foreign_key' => 'sku',
        'model' => Product::class,
    ],
];
