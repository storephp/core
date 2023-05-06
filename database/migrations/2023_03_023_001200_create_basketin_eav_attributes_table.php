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
        Schema::create($this->prefix . 'eav_attributes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('model_id')->constrained($this->prefix . 'eav_models')->cascadeOnDelete();
            $table->foreignId('entity_id')->constrained($this->prefix . 'eav_entities')->cascadeOnDelete();
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
        Schema::dropIfExists($this->prefix . 'eav_attributes');
    }
};
