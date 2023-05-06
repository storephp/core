<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Store\Base\MigrationBase;

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
            $table->string('product_sku')->index();
            $table->unsignedInteger('quantity')->default(1);
            $table->unique(['basket_id', 'product_sku']);
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
