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
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreign(['menu_item_id'], 'fk_order_items_menu_item')->references(['id'])->on('menu_items')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['orders_id'], 'fk_order_items_order')->references(['id'])->on('orders')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign('fk_order_items_menu_item');
            $table->dropForeign('fk_order_items_order');
        });
    }
};
