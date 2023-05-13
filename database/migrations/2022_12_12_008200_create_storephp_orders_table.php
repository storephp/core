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
        Schema::create($this->prefix . 'orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->nullable()->constrained($this->prefix . 'customers')->cascadeOnDelete();
            $table->foreignId('basket_id')->nullable()->constrained($this->prefix . 'baskets')->cascadeOnDelete();
            $table->foreignId('status_id')->nullable()->constrained($this->prefix . 'order_statuses')->nullOnDelete();
            $table->json('discount_details')->nullable();
            $table->decimal('sub_total', 10, 2);
            $table->decimal('discount_total', 10, 2)->nullable();
            $table->decimal('shipping_total', 10, 2)->nullable();
            $table->decimal('tax_total', 10, 2)->nullable();
            $table->decimal('grand_total', 10, 2);
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
        Schema::dropIfExists($this->prefix . 'orders');
    }
};
