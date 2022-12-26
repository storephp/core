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
        Schema::create($this->prefix . 'basket_quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('basket_id')->constrained($this->prefix . 'baskets')->cascadeOnDelete();
            $table->foreignId('product_sku');
            $table->unsignedInteger('quantity')->default(1);
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
        Schema::dropIfExists($this->prefix . 'basket_quotes');
    }
};
