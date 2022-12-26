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
        Schema::create($this->prefix . 'customer_addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained($this->prefix . 'customers')->cascadeOnDelete();
            $table->string('label');
            $table->integer('country_id')->index()->nullable();
            $table->integer('city_id')->index()->nullable();
            $table->integer('zip_code')->nullable();
            $table->string('street_line_1');
            $table->string('street_line_2')->nullable();
            $table->string('telephone_number')->index();
            $table->boolean('is_main')->nullable();
            $table->timestamps();

            $table->unique(['customer_id', 'is_main']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->prefix . 'customer_addresses');
    }
};
