<?php

declare (strict_types = 1);

test('It assert is equal outmart_', function () {
    $config = config('outmart.database.table_prefix');
    $this->assertEquals($config, 'outmart_');
});
