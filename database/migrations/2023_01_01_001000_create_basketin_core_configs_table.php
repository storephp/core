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
        Schema::create($this->prefix . 'core_configs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_view_id')->nullable()->constrained($this->prefix . 'store_views')->cascadeOnDelete();
            $table->string('path')->index();
            $table->string('value');
            $table->unique(['store_view_id', 'path']);
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
        Schema::dropIfExists($this->prefix . 'core_configs');
    }
};
