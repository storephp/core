<?php

declare (strict_types = 1);

test('It assert is equal store_', function () {
    $config = config('store.database.table_prefix');
    $this->assertEquals($config, 'store_');
});
