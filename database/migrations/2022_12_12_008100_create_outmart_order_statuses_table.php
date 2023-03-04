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
        Schema::create($this->prefix . 'order_statuses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('state_id')->nullable()->constrained($this->prefix . 'order_states')->nullOnDelete();
            $table->string('status_key')->unique()->index();
            $table->string('status_label')->unique();
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
        Schema::dropIfExists($this->prefix . 'order_statuses');
    }
};
