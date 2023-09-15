# Products

You can install StorePHP Core via composer

## The Namespace

```php
<?php

use Store\Support\Facades\Product;
```

## Methods

### Create new product

```php
<?php

$product = Product::create([
    'sku' => 'iphone-14',
]);

$product->categories = [1, 5];
$product->name = 'Iphone 14';
$product->slug = 'iphone-14';
$product->description = 'product description';
$product->price = 1400;
$product->discount_price = 1300;
$product->thumbnail_path = 'path/thumbnail.png';

$product->save();
```

### Get all products

```php
<?php

return Product::all();
```

### Get product by id

```php
<?php

return Product::getById(<id:int>);
```

### Get product by SKU

```php
<?php

return Product::getBySku('<sku:string>');
```
