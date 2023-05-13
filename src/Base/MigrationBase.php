<?php

namespace Store\Base;

use Illuminate\Database\Migrations\Migration;

abstract class MigrationBase extends Migration
{
    /**
     * Table prefix.
     *
     * @var string $prefix
     */
    protected string $prefix = '';

    /**
     * Create a new instance of the migration.
     */
    public function __construct()
    {
        $this->prefix = config('store.database.table_prefix');
    }
}
