# Categories

You can easily manage product categories for your eCommerce from the following namespace

## The Namespace

```php
<?php

use Store\Models\Product\Category;
```

## Methods

### Create new category

```php
<?php

use Store\Models\Product\Category;

$category = Category::create([
    'parent_id' => 1, // Or set null
    'slug' => 'slug',
]);

// Add field By EAV
$category->name = 'Name';

$category->save();
```

You can add more fields by `EAV` to make it go to config file `config/store.php`:-

```php
/*
|--------------------------------------------------------------------------
| Catalog configs
|--------------------------------------------------------------------------
*/
'catalog' => [
    'categories' => [
        'model' => \Store\Models\Product\Category::class,
        // highlight-next-line
        'external_fillable_entry' => [],
    ],

    'products' => [
        'model' => \Store\Models\Product::class,
        'external_fillable_entry' => [],
    ],
],
```

Add the key field to `external_fillable_entry` array.

#### Example:-

```php title=config/store.php
[
    ...
    'external_fillable_entry' => ['icon'],
    ...
]
```

```php title=example.php
use Store\Models\Product\Category;

$category = Category::create([
    'parent_id' => 1, // Or set null
    'slug' => 'slug',
]);

// Add field By EAV
$category->name = 'Name';
$category->icon = 'icon.svg';

$category->save();
```
