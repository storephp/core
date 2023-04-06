<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Basketin\Base\MigrationBase;

return new class extends MigrationBase
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->prefix . 'customer_customer_channels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained($this->prefix . 'customers')->cascadeOnDelete();
            $table->foreignId('channel_id')->constrained($this->prefix . 'customer_channels')->cascadeOnDelete();
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
        Schema::dropIfExists($this->prefix . 'customer_customer_channels');
    }
};
