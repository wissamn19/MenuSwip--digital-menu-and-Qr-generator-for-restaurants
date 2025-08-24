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
        Schema::table('order_on', function (Blueprint $table) {
            $table->foreign(['order_id'], 'order_on_ibfk_1')->references(['id'])->on('orders')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['user_id'], 'order_on_ibfk_2')->references(['id'])->on('owners')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_on', function (Blueprint $table) {
            $table->dropForeign('order_on_ibfk_1');
            $table->dropForeign('order_on_ibfk_2');
        });
    }
};
