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
        Schema::create($this->prefix . 'baskets', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->index();
            $table->nullablemorphs('customer');
            $table->string('currency', 3);
            $table->unsignedTinyInteger('status')->default(1);
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
        Schema::dropIfExists($this->prefix . 'baskets');
    }
};
