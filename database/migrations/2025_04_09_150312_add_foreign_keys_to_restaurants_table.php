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
        Schema::table('restaurants', function (Blueprint $table) {
            $table->foreign(['user_id'], 'fk_restaurant_user')->references(['id'])->on('owners')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['user_id'], 'fk_user_id')->references(['id'])->on('owners')->onUpdate('NO ACTION')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('restaurants', function (Blueprint $table) {
            $table->dropForeign('fk_restaurant_user');
            $table->dropForeign('fk_user_id');
        });
    }
};
