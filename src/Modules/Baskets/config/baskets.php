<?php

use App\Models\Product;

return [
    'product_relation' => [
        'foreign_key' => 'id',
        'model' => Product::class,
    ],
];
