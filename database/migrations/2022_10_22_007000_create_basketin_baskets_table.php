<?php

use Basketin\Base\MigrationBase;
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
        Schema::create($this->prefix . 'baskets', function (Blueprint $table) {
            $table->id();
            $table->ulid('ulid')->unique()->index();
            $table->nullablemorphs('customer');
            $table->string('currency', 3);
            $table->string('coupon_code')->nullable();
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
