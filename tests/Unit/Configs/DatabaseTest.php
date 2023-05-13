<?php

declare (strict_types = 1);

test('It assert is equal basketin_', function () {
    $config = config('basketin.database.table_prefix');
    $this->assertEquals($config, 'basketin_');
});
