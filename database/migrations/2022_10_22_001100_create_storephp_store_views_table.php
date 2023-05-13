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
        Schema::create($this->prefix . 'store_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->nullable()->constrained($this->prefix . 'stores')->cascadeOnDelete();
            $table->string('name')->unique();
            $table->string('slug')->unique()->index();
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
        Schema::dropIfExists($this->prefix . 'store_views');
    }
};
