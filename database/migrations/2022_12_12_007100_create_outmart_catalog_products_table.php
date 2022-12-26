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
        Schema::create($this->prefix . 'catalog_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('configurable_id')->nullable()->constrained($this->prefix . 'catalog_products')->cascadeOnDelete();
            $table->json('categories')->nullable();
            $table->string('name');
            $table->string('slug');
            $table->string('sku')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->unsignedTinyInteger('product_type')->default(1); // Configurable product = 1
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
        Schema::dropIfExists($this->prefix . 'catalog_products');
    }
};
