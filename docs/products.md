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
    'name' => 'Iphone 14',
]);
```

#### Exceptions

- `\Store\Exceptions\Products\ProductAlreadyExistsException` if SKU is exists.

#### Events

- Product created `\Store\Support\Events\Products\ProductCreatedEvent`
