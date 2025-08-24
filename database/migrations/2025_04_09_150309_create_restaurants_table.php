<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('restaurants', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('resturantName');
            $table->string('state', 50)->nullable();
            $table->string('location')->nullable();
            $table->string('type', 100);
            $table->string('urlimage');
            $table->unsignedBigInteger('owner_id')->index('fk_restaurant_owner');
            $table->string('qr_code')->nullable();
            $table->time('starttime')->nullable();
            $table->time('endtime')->nullable();

            $table->unique(['owner_id'], 'unique_owner_restaurant');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('restaurants');
    }
};
