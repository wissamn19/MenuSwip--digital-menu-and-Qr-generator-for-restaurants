<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderOffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('order_off', function (Blueprint $table) {
            $table->id(); // bigint unsigned auto-increment
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('chef_id');

            // Indexes
            $table->index('order_id');
            $table->index('chef_id');

            $table->foreign('order_id')
              ->references('id')
              ->on('orders')
              ->onDelete('cascade');

        $table->foreign('chef_id')
              ->references('id')
              ->on('owners')
              ->onDelete('cascade');

          
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_offs');
    }
}
