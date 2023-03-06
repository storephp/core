<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use OutMart\Base\MigrationBase;

return new class extends MigrationBase
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->prefix . 'catalog_product_entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_view_id')->nullable()->constrained($this->prefix . 'store_views')->cascadeOnDelete();
            $table->foreignId('product_id')->nullable()->constrained($this->prefix . 'catalog_products')->cascadeOnDelete();
            $table->string('entry_key')->index();
            $table->json('entry_value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->prefix . 'catalog_product_entries');
    }
};
