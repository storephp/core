# Products

You can install StorePHP Core via composer

## The Namespace

```php
<?php

use Store\Support\Facades\Product;
```

## Methods

### Get all products

```php
$product = Product::list(function ($query) {
    $query->where('id', 1);
});
```

### Get product by id

```php
$product = Product::getBySku(1);
```

#### Exceptions

- `\Store\Exceptions\Products\ProductAlreadyNotException` product not exists.

### Get product by SKU

```php
$product = Product::getBySku('iphone-14');
```

#### Exceptions

- `\Store\Exceptions\Products\ProductAlreadyNotException` product not exists.

### Create new product

```php
<?php

$product = Product::create([
    'sku' => 'iphone-14',
    'name' => 'Iphone 14',
]);
```

#### Exceptions

- `\Store\Exceptions\Products\ProductAlreadyExistsException` if SKU is exists.

#### Events

- Product created `\Store\Events\Products\ProductCreatedEvent`
