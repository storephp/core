<?php

use Store\Base\MigrationBase;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends MigrationBase
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->prefix . 'eav_values', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_view_id')->nullable()->constrained($this->prefix . 'store_views')->cascadeOnDelete();
            $table->foreignId('attribute_id')->constrained($this->prefix . 'eav_attributes')->cascadeOnDelete();
            $table->json('attribute_value');
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
        Schema::dropIfExists($this->prefix . 'eav_values');
    }
};
