<?php

use App\Models\Product;

return [
    'max_quote' => 10,

    'product_relation' => [
        'foreign_key' => 'sku',
        'model' => Product::class,
    ],
];
